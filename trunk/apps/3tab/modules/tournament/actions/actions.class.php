<?php

/**
 * tournament actions.
 *
 * @package    3tab
 * @subpackage tournament
 * @author     suthen
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class tournamentActions extends sfActions
{
    /**
    * Executes index action
    *
    */
    public function executeIndex()
    {
        $this->rounds = RoundPeer::getRoundsInSequence();
    }
    
    public function executeCreateMatchups()
    {
        $this->round = RoundPeer::retrieveByPK($this->getRequestParameter("id"));
        $this->debates = DebatePeer::doDraw($this->round);
    }
    
    public function validateConfirmMatchups()
    {
        $round = RoundPeer::retrieveByPK($this->getRequestParameter("id"));
        if ($round->getStatus() >= Round::ROUND_STATUS_MATCHUPS_CONFIRMED) {
            $this->getRequest()->setError("round_already_confirmed", "Matchups for " . $round->getName() . " have already been confirmed.");
        }

        return !$this->getRequest()->hasErrors();
    }

    public function handleErrorConfirmMatchups()
    {
        $this->forward('tournament', 'createMatchups');
    }

    public function executeConfirmMatchups()
    {
        $propelConn = Propel::getConnection();
        try
        {			
            $propelConn->begin();
            $round = RoundPeer::retrieveByPK($this->getRequestParameter("id"), $propelConn);		
            foreach($this->getRequestParameter('debates') as $aDebate)
            {
                $debate = DebatePeer::createDebate(
                    $aDebate['affirmative_team_id'],
                    $aDebate['negative_team_id'], 
                    VenuePeer::retrieveByPK($aDebate['venue_id'], $propelConn)
                );
                $round->addDebate($debate);
                $debate->save($propelConn);
            }
            $round->setStatus(Round::ROUND_STATUS_MATCHUPS_CONFIRMED);
            $round->save($propelConn);
            $propelConn->commit();
        }
        catch(Exception $e)
        {
            $propelConn->rollback();
            throw $e;
        }
        
        $this->redirect('tournament/index');
    }
    
    public function executeCreateAdjudicatorAllocation()
    {
		$this->round = RoundPeer::retrieveByPK($this->getRequestParameter("id"));		
		$debates = $this->round->getDebates();		
		$adjudicators = AdjudicatorPeer::getAdjudicatorsByTestScore();
		$allocator = new AdjudicatorAllocator();
		
		if($this->getRequestParameter("skipProcessing"))
		{
			$this->adjudicatorAllocations = $this->getRequestParameter("allocations");
			$this->unallocatedAdjudicators = $this->getUnallocatedAdjudicators($this->adjudicatorAllocations);
			return sfView::SUCCESS;
        }
		if($this->round->getType() == Round::ROUND_TYPE_RANDOM)
		{		
			$allocator->setup($debates, $adjudicators, true, false);
		}
		else if($this->round->getType() == Round::ROUND_TYPE_PRELIMINARY)
		{
			$debateEnergies = $this->getRequestParameter("debateEnergies");
			$allocator->setup($debates, $adjudicators, false, false);
			$allocator->setDebateEnergies($debateEnergies);
		}		
		else if($this->round->getType() == Round::ROUND_TYPE_BUBBLE)
		{
			$debateEnergies = $this->getRequestParameter("debateEnergies");
			$allocator->setup($debates, $adjudicators, false, true);	
			$allocator->setDebateEnergies($debateEnergies);
		}
		$this->adjudicatorAllocations = $allocator->allocate();
		$this->unallocatedAdjudicators = $this->getUnallocatedAdjudicators($this->adjudicatorAllocations);
        $this->adjudicators = $adjudicators;
    }

	public function executePreAdjudicatorAllocation()
	{
		$this->round = RoundPeer::retrieveByPK($this->getRequestParameter("id"));
		$this->debates = $this->round->getDebates();
		$this->debateEnergies = array();
		foreach($this->debates as $aDebate)
		{
			if($this->round->getType() == Round::ROUND_TYPE_RANDOM)
			{
                $this->redirect('tournament/createAdjudicatorAllocation?id=' . $this->getRequestParameter("id"));
			}
			else if($this->round->getType() == Round::ROUND_TYPE_PRELIMINARY)
			{	
				$this->debateEnergies[] = $aDebate->getEnergy();
			}
			else if($this->round->getType() == Round::ROUND_TYPE_BUBBLE)
			{
				$this->debateEnergies[] = $aDebate->getEnergy(true);	
			}
		}
	}
	
	public function validateConfirmAdjudicatorAllocation()
	{
		//check if panels are 1,3
		$panels = $this->getRequestParameter('adjudicatorId');
		$debateIds = $this->getRequestParameter('debateId');
		$round = RoundPeer::retrieveByPK($this->getRequestParameter("id"));
		
		$adjudicators = array();
		$hasError = false;
		$count = 0;
		foreach($panels as $number => $panel)
		{			
			$counter = 0;
			foreach($panel as $position => $p)
			{
				if($p != null)
				{
					$adjudicators[] = $p;
					$counter++;
					$conflicts[$number][$position] = AdjudicatorAllocation::checkConflicts(
					DebatePeer::retrieveByPk($debateIds[$number]),
					AdjudicatorPeer::retrieveByPk($p));					
				}
			}
			if(!($counter == 1 || $counter == 3))
			{
				//find the teams in the debates
				$debate = DebatePeer::retrieveByPk($debateIds[$number]);
				//$debate->getDebateInfo();
				$this->getRequest()->setError("panelSizeError".$number, "There is an even numbered panel in ".$debate->getVenue()->getName());

				//send the error message for which debate this is for
				$hasError = true;
			}
		}
		//check if there are duplicate entries
		$duplicateAdjudicators = $this->getDuplicateAdjudicators($adjudicators);
		if(count($duplicateAdjudicators) != 0)
		{
			//find the adjudicator that is causing the error
			foreach($duplicateAdjudicators as $number => $duplicate)
			{
				$adjudicator = AdjudicatorPeer::retrieveByPk($duplicate);
				$errors[$number] = "The adjudicator ".$adjudicator->getName()." is allocated more than once. Check allocations for ";
				foreach($this->getAdjudicatorAssignments($duplicate, $panels) as $debateNumber)
				{
					$debate = DebatePeer::retrieveByPk($debateIds[$debateNumber]);
					$errors[$number] = $errors[$number].$debate->getVenue()->getName()." ";
				}
			}
			foreach($errors as $number=>$anError)
			{
				$this->getRequest()->setError("multipleAllocationsError".$number, $anError);
			}
			//find which debates he is at
			//send the error message
			$hasError = true;
		}
		$conflictCaused = false;;
		foreach($conflicts as $conflict)
		{
			foreach($conflict as $conf)
			{
				if($conf) $conflictCaused = true;
			}
		}
		//check if there are clashes
		if($conflictCaused)
		{
			foreach($conflicts as $number=>$aConflict)
			{
				foreach($aConflict as $position=>$conflictingPanelist)
				{
					if($conflicts[$number][$position])
					{
						$debate = DebatePeer::retrieveByPk($debateIds[$number]);
						$adjudicator = AdjudicatorPeer::retrieveByPk($panels[$number][$position]);
						$this->getRequest()->setError("conflictError".$number.$position, "The adjudicator ".
						$adjudicator->getName()." has a conflict at ".$debate->getVenue()->getName());
					}
				}	
			}
			$hasError = true;
		}
		if(!$hasError) $this->getRequest()->setParameter("skipProcessing", false);
		return !$hasError;
	}
	
	public function handleErrorConfirmAdjudicatorAllocation()
	{
		$round = RoundPeer::retrieveByPK($this->getRequestParameter("id"));
		$debateId = $this->getRequestParameter('debateId');
		$panels = $this->getRequestParameter('adjudicatorId');
		$allocations = array();
		 foreach($panels as $number => $panel)
		{				
			$allocation = AdjudicatorAllocationPeer::createAdjudicatorAllocation(
								$debateId[$number], $panel[0],1);
			$allocations[$number][] = $allocation;
			
			if($panel[1] != null)
			{
				$allocation = AdjudicatorAllocationPeer::createAdjudicatorAllocation(
									$debateId[$number], $panel[1],2);
				$allocations[$number][] = $allocation;
			}
			
			if($panel[2] != null)
			{
				$allocation = AdjudicatorAllocationPeer::createAdjudicatorAllocation(
									$debateId[$number], $panel[2],2);
				$allocations[$number][] = $allocation;
			}			
		}
		$this->getRequest()->setParameter("allocations", $allocations);
		$this->getRequest()->setParameter("skipProcessing", true);
		$this->forward('tournament', 'createAdjudicatorAllocation');
	}
	
	
	public function executeConfirmAdjudicatorAllocation()
	{
        $propelConn = Propel::getConnection();
        try
        {
            $propelConn->begin();
            $round = RoundPeer::retrieveByPK($this->getRequestParameter("id"), $propelConn);
			$debateId = $this->getRequestParameter('debateId');
			$panels = $this->getRequestParameter('adjudicatorId');		
            foreach($panels as $number => $panel)
            {				
				$allocation = AdjudicatorAllocationPeer::createAdjudicatorAllocation(
									$debateId[$number], $panel[0],1);
				DebatePeer::retrieveByPk($debateId[$number])->addAdjudicatorAllocation($allocation);
				$allocation->save($propelConn);
				
				if($panel[1] != null)
				{
					$allocation = AdjudicatorAllocationPeer::createAdjudicatorAllocation(
										$debateId[$number], $panel[1],2);
					DebatePeer::retrieveByPk($debateId[$number])->addAdjudicatorAllocation($allocation);
					$allocation->save($propelConn);
				}
				
				if($panel[2] != null)
				{
					$allocation = AdjudicatorAllocationPeer::createAdjudicatorAllocation(
										$debateId[$number], $panel[2],2);
					DebatePeer::retrieveByPk($debateId[$number])->addAdjudicatorAllocation($allocation);	
					$allocation->save($propelConn);
				}
				
                DebatePeer::retrieveByPk($debateId[$number])->save($propelConn);
            }
            $round->setStatus(Round::ROUND_STATUS_ADJUDICATOR_ALLOCATIONS_CONFIRMED);
            $round->save($propelConn);
            $propelConn->commit();
        }
        catch(Exception $e)
        {
            $propelConn->rollback();
            throw $e;
        }
        
        $this->redirect('tournament/index');
	}
	
	public function executeTraineeAllocation()
	{
		$this->round = RoundPeer::retrieveByPK($this->getRequestParameter('id'));
		$this->trainees = AdjudicatorPeer::getUnallocatedTrainees($this->round);
	}
	
	public function validateConfirmTraineeAllocation()
	{
		$round = RoundPeer::retrieveByPk($this->getRequestParameter('id'));
		$trainees = $this->getRequestParameter('trainees');
		$chairIds = $this->getRequestParameter('chairs');
		$chairs = array();
		$debateIds = array();
		$conflicts = array();
		$hasError = false;
		foreach($chairIds as $number => $chairId)
		{
			$chairs[$number] = AdjudicatorPeer::retrieveByPk($chairId);
			$debate = $chairs[$number]->getDebate($round);
			$debateIds[] = $debate->getId();
		}
		$allocatedTrainees = array();
		foreach($trainees as $number => $traineesForChair)
		{
			foreach($traineesForChair as $position => $aTrainee)
			{
				if($aTrainee != null)
				{
					$allocatedTrainees[] = $aTrainee;
					$conflicts[$number][$position] = AdjudicatorAllocation::checkConflicts(
					DebatePeer::retrieveByPk($debateIds[$number]),
					AdjudicatorPeer::retrieveByPk($aTrainee));	
				}
			}
		}
		$duplicateAdjudicators = $this->getDuplicateAdjudicators($allocatedTrainees);
		if(count($duplicateAdjudicators) != 0)
		{
			//find the adjudicator that is causing the error
			foreach($duplicateAdjudicators as $number => $duplicate)
			{
				$adjudicator = AdjudicatorPeer::retrieveByPk($duplicate);
				$errors[$number] = "The trainee ".$adjudicator->getName()." is allocated more than once.";
			}
			foreach($errors as $number=>$anError)
			{
				$this->getRequest()->setError("multipleAllocationsError".$number, $anError);
			}
			//find which debates he is at
			//send the error message
			$hasError = true;
		}
		$conflictCaused = false;;
		
		foreach($conflicts as $conflict)
		{
			foreach($conflict as $conf)
			{
				if($conf) $conflictCaused = true;
			}
		}
		
		//check if there are clashes
		if($conflictCaused)
		{
			foreach($conflicts as $number=>$aConflict)
			{
				foreach($aConflict as $position=>$conflictingPanelist)
				{
					if($conflicts[$number][$position])
					{
						$debate = DebatePeer::retrieveByPk($debateIds[$number]);
						$adjudicator = AdjudicatorPeer::retrieveByPk($trainees[$number][$position]);
						$this->getRequest()->setError("conflictError".$number.$position, "The adjudicator ".
						$adjudicator->getName()." has a conflict.");
					}
				}	
			}
			$hasError = true;
		}
		
		return !$hasError;
	}
	
	public function handleErrorConfirmTraineeAllocation()
	{
		$this->forward('tournament', 'traineeAllocation');
	}
	
	public function executeConfirmTraineeAllocation()
	{
		$propelConn = Propel::getConnection();
        try
        {
			$propelConn->begin();
			$round = RoundPeer::retrieveByPK($this->getRequestParameter("id"), $propelConn);
			$chairIds = $this->getRequestParameter('chairs');
			$trainees = $this->getRequestParameter('trainees');
			foreach($chairIds as $number => $chairId)
			{
				foreach($trainees[$number] as $position => $traineeForChair)
				{
					if($traineeForChair != 0)
					{
						$allocation = new TraineeAllocation();
						$allocation->setRound($round);
						$allocation->setChairId($chairId);
						$allocation->setTraineeId($traineeForChair);
						$allocation->save($propelConn);
					}
				}
			}
			$round->setStatus(Round::ROUND_STATUS_TRAINEE_ALLOCATIONS_CONFIRMED);
            $round->save($propelConn);
			$propelConn->commit();
		}
		catch(Exception $e)
        {
            $propelConn->rollback();
            throw $e;
        }
		$this->redirect('tournament/index');
	}
	
	public function executeResultsEntry()
    {
        $this->round = RoundPeer::retrieveByPK($this->getRequestParameter('id'));
    }
    
    public function executeResultsView()
    {
        $this->round = RoundPeer::retrieveByPK($this->getRequestParameter('id'));
    }
    
    public function executeDebateResultsEntry()
    {
        $this->debate = DebatePeer::retrieveByPK($this->getRequestParameter('id'));
    }
    
        public function executeDebateResultsView()
    {
        $this->debate = DebatePeer::retrieveByPK($this->getRequestParameter('id'));
    }
    
 	public function validateUpdateResults()
    {
        $errors = array();
        
        $totalScoreForTeamFromAdjudicator = array();
        foreach($this->getRequestParameter('speaker_scores') as $debateTeamXrefId => $speakers)
        {
            foreach($speakers as $speakingPosition => $speaker)
            {
                foreach($speaker["scores"] as $adjudicatorAllocationId => $score)
                {
                    if(!isset($totalScoreForTeamFromAdjudicator[$adjudicatorAllocationId][$debateTeamXrefId]))
                    {
                        $totalScoreForTeamFromAdjudicator[$adjudicatorAllocationId][$debateTeamXrefId] = 0;
                    }
                    $totalScoreForTeamFromAdjudicator[$adjudicatorAllocationId][$debateTeamXrefId] += $score;
                    
                    if(in_array($speakingPosition, array(SpeakerScoreSheet::FIRST_SPEAKER, SpeakerScoreSheet::SECOND_SPEAKER, SpeakerScoreSheet::THIRD_SPEAKER)))
                    {
                        if($score < sfConfig::get("app_lowest_possible"))
                        {
                            $errors['speaker_scores'][$debateTeamXrefId][$speakingPosition]['scores'][$adjudicatorAllocationId] = "Score $score is too low.  " .  sfConfig::get("app_lowest_possible") . " is the lowest possible score.";
                        }
                        else if($score > sfConfig::get("app_highest_possible"))
                        {
                            $errors['speaker_scores'][$debateTeamXrefId][$speakingPosition]['scores'][$adjudicatorAllocationId] = "Score $score is too high.  " .  sfConfig::get("app_highest_possible") . " is the highest possible score.";
                        }
                    }
                    
                    if(in_array($speakingPosition, array(SpeakerScoreSheet::REPLY_SPEAKER)))
                    {
                        if($score < (sfConfig::get("app_lowest_possible") / 2))
                        {
                            $errors['speaker_scores'][$debateTeamXrefId][$speakingPosition]['scores'][$adjudicatorAllocationId] = "Scores is too low.  " .  (sfConfig::get("app_lowest_possible") / 2) . " is the lowest possible score.";
                        }
                        else if($score > (sfConfig::get("app_highest_possible") / 2))
                        {
                            $errors['speaker_scores'][$debateTeamXrefId][$speakingPosition]['scores'][$adjudicatorAllocationId] = "Scores is too high.  " .  (sfConfig::get("app_highest_possible") / 2) . " is the highest possible score.";
                        }
                    }
                }
            }
        }
        
        foreach($this->getRequestParameter('speaker_scores') as $debateTeamXrefId => $speakers)
        {
            $debaters = array();
            foreach($speakers as $speakingPosition => $speaker)
            {
                if(in_array($speaker["debater_id"], array_keys($debaters)))
                {
                    if($speakingPosition != SpeakerScoreSheet::REPLY_SPEAKER)
                    {
                        $errors['speaker_scores'][$debateTeamXrefId][$speakingPosition]['debater_id'] = "'".DebaterPeer::retrieveByPK($speaker["debater_id"])->getName()."' has already been placed in speaker position '" . $debaters[$speaker["debater_id"]] . "'.";
                    }
                    
                    if($speakingPosition == SpeakerScoreSheet::REPLY_SPEAKER and 
                      !in_array($debaters[$speaker["debater_id"]], array(SpeakerScoreSheet::FIRST_SPEAKER, 
                      SpeakerScoreSheet::SECOND_SPEAKER)))
                    {
                        $errors['speaker_scores'][$debateTeamXrefId][$speakingPosition]['debater_id'] = "'".DebaterPeer::retrieveByPK($speaker["debater_id"])->getName()."' cannot be a reply speaker as he/she is a third speaker.";
                    }
                }
                $debaters[$speaker["debater_id"]] = $speakingPosition;
            }
        }
        
        foreach($this->getRequestParameter('adjudicator_votes') as $adjudicatorAllocationId => $winningTeamId)
        {
            $totalScores = array();
            foreach($totalScoreForTeamFromAdjudicator[$adjudicatorAllocationId] as $debateTeamXrefId => $totalScore)
            {
                $totalScores[DebateTeamXrefPeer::retrieveByPK($debateTeamXrefId)->getTeamId()] = $totalScore;
            }
           
            asort($totalScores, SORT_NUMERIC);
            $teamsSortedByScores = array_keys($totalScores);
            if(end($teamsSortedByScores) != $winningTeamId)
            {
                $errors['adjudicator_votes'][$adjudicatorAllocationId] = "Win given to '" . 
                TeamPeer::retrieveByPK($winningTeamId)->getName() . "' but total score for '" .
                TeamPeer::retrieveByPK(end($teamsSortedByScores))->getName() . "' is higher.";
            }
            
            $scoreValues = array_values($totalScores);
            if($scoreValues[0] == end($scoreValues))
            {
                $errors['adjudicator_votes'][$adjudicatorAllocationId] = "Both teams have been given equal scores by this adjudicator.";
            }
        }
		
        
        $this->getRequest()->setErrors($errors);
        
        return !$this->getRequest()->hasErrors();
    }
    
    public function handleErrorUpdateResults()
    {
        $this->forward('tournament', 'debateResultsEntry');
    }
    
    public function executeUpdateResults()
    {
        $propelConn = Propel::getConnection();
        try
        {
            $propelConn->begin();
            $debate = DebatePeer::retrieveByPK($this->getRequestParameter('id'), $propelConn);
            foreach($debate->getAdjudicatorAllocations(null, $propelConn) as $adjudicatorAllocation)
            {
                foreach($adjudicatorAllocation->getTeamScoreSheets(null, $propelConn) as $teamScoreSheet)
                {
                    $teamScoreSheet->delete($propelConn);
                }
                
                foreach($adjudicatorAllocation->getSpeakerScoreSheets(null, $propelConn) as $speakerScoreSheet)
                {
                    $speakerScoreSheet->delete($propelConn);
                }
            }
            
            foreach($this->getRequestParameter('adjudicator_votes') as $adjudicatorAllocationId => $winningTeamId)
            {
				 foreach($debate->getDebateTeamXrefs(null, $propelConn) as $debateTeamXref)
                {
                    $teamScoreSheet = new TeamScoreSheet();
                    $teamScoreSheet->setAdjudicatorAllocationId($adjudicatorAllocationId);
                    $teamScoreSheet->setDebateTeamXref($debateTeamXref);
                    $teamScoreSheet->setScore(($debateTeamXref->getTeamId() == $winningTeamId) ? 1 : 0);
                    $teamScoreSheet->save($propelConn);
                }
            }
			
			foreach($this->getRequestParameter('speaker_scores') as $debateTeamXrefId => $speakers)
            {
                foreach($speakers as $speakingPosition => $speaker)
                {
                    foreach($speaker["scores"] as $adjudicatorAllocationId => $score)
                    {
                        $speakerScoreSheet = new SpeakerScoreSheet();
                        $speakerScoreSheet->setAdjudicatorAllocationId($adjudicatorAllocationId);
                        $speakerScoreSheet->setDebateTeamXrefId($debateTeamXrefId);
                        $speakerScoreSheet->setDebaterId($speaker["debater_id"]);
                        $speakerScoreSheet->setScore($score);
                        $speakerScoreSheet->setSpeakingPosition($speakingPosition);
                        $speakerScoreSheet->save($propelConn);
					}
                }
            }
			
			$propelConn->commit();
        }
        catch(Exception $e)
        {
            $propelConn->rollback();
            throw $e;
        }
        
        $this->redirect('tournament/resultsEntry?id=' . $debate->getRoundId());
    }
    
	public function executeConfirmRoundResults()
	{
		$propelConn = Propel::getConnection();
        try
        {
            $propelConn->begin();
            $round = RoundPeer::retrieveByPk($this->getRequestParameter('id'));

            $c = new Criteria();
            $c->addJoin(RoundPeer::ID, DebatePeer::ROUND_ID);
            $c->addJoin(DebatePeer::ID, DebateTeamXrefPeer::DEBATE_ID);
            $c->addJoin(DebateTeamXrefPeer::TEAM_ID, TeamPeer::ID);
            $c->add(RoundPeer::ID, $round->getId());
			$teams = TeamPeer::doSelect($c, $propelConn);
			foreach($teams as $team)
			{
				$c = new Criteria();
				$c->add(TeamScorePeer::TEAM_ID, $team->getId());
				$teamScore = TeamScorePeer::doSelect($c, $propelConn);
				$teamScore[0]->setTotalTeamScore($team->deriveTotalTeamScore($propelConn));
				$teamScore[0]->setTotalSpeakerScore($team->deriveTotalSpeakerScore($propelConn));
				$teamScore[0]->setTotalMargin($team->deriveTotalMargin($propelConn));
				$teamScore[0]->save($propelConn);
			}
			$debaters = DebaterPeer::doSelect(new Criteria(), $propelConn);
			foreach($debaters as $debater)
			{
				$c = new Criteria();
				$c->add(SpeakerScorePeer::DEBATER_ID, $debater->getId());
				$speakerScore = SpeakerScorePeer::doSelect($c, $propelConn);
				$speakerScore[0]->setTotalSpeakerScore($debater->getTotalSpeakerScoreSlow($propelConn));
				$speakerScore[0]->save($propelConn);
			}			
            
            $round->setStatus(ROUND::ROUND_STATUS_RESULT_ENTRY_COMPLETE);
			$round->save($propelConn);
			$propelConn->commit();
		}
		 catch(Exception $e)
        {
            $propelConn->rollback();
            throw $e;
        }
		$this->redirect('tournament/index');
	}
	public function executeFeedbackEntry()
	{
		$this->round = RoundPeer::retrieveByPK($this->getRequestParameter("id"));
		$this->adjudicators = AdjudicatorFeedbackSheet::getAdjudicatorsToReceiveFeedback($this->round);
	}
	
	public function executeSelectFeedbackSource()
	{
		$this->round = RoundPeer::retrieveByPK($this->getRequestParameter("id"));
		$this->adjudicator = AdjudicatorPeer::retrieveByPK($this->getRequestParameter("adjudicator"));
		$this->source = $this->getRequestParameter("source");
		if(!$this->source)
		{
			throw new Exception("Please choose select the source of the feedback before hitting submit");
		}
		else if($this->source == 1)
		{
			/*
			$con = Propel::getConnection();
			$stmt = $con->createStatement();
			//get debate_team_xrefs for this adjudicator in this round
			
		
			$query = "SELECT debates_teams_xrefs.* FROM adjudicator_allocations,debates, debates_teams_xrefs, ".
			"adjudicator_feedback_sheets WHERE adjudicator_allocations.adjudicator_id = %d AND ".
			"adjudicator_allocations.debate_id = debates.id and debates.round_id = %d AND debates_teams_xrefs.debate_id ".
			" = debates.id";
			$query = sprintf($query, $this->adjudicator->getId(), $this->round->getId());
			$rs = $stmt->executeQuery($query, ResultSet::FETCHMODE_NUM);
			$debateTeamXrefs = DebateTeamXrefPeer::populateObjects($rs);
			if($debateTeamXrefs == null)
			{
				throw new Exception("All feedback from teams adjudicated have been received.");
			}
			$this->teams = array();
			foreach($debateTeamXrefs as $xref)
			{
				$query2 = "SELECT * from adjudicator_feedback_sheets WHERE adjudicator_feedback_sheets.debate_team_xref_id = %d";
				$query2 = sprintf($query2, $xref->getId($con));
				$rs = $stmt->executeQuery($query2, ResultSet::FETCHMODE_NUM);
				$feedbackSheet = AdjudicatorFeedbackSheetPeer::populateObjects($rs);
				if($feedbackSheet == null)
				{
					$this->teams[] = $xref->getTeam($con);
				}
			}*/
			$this->teams = AdjudicatorFeedbackSheet::getFeedbackingTeams($this->adjudicator, $this->round);
			if(count($this->teams) == 0)
			{
				throw new Exception("All feedback from teams adjudicated have been received.");
			}
		}
		else if($this->source == 2)
		{
			/*
			$con = Propel::getConnection();
			$stmt = $con->createStatement();
			$query = "SELECT debates.* FROM adjudicator_allocations,debates WHERE ".
			"adjudicator_id = %d AND adjudicator_allocations.debate_id = debates.id and debates.round_id = %d";
			$query = sprintf($query, $this->adjudicator->getId(), $this->round->getId());
			$rs = $stmt->executeQuery($query, ResultSet::FETCHMODE_NUM);
			$debate = DebatePeer::populateObjects($rs);
			$query2 = "SELECT adjudicator_allocations.* FROM adjudicator_allocations, ".
			"adjudicator_feedback_sheets WHERE adjudicator_allocations.debate_id = %d AND ".
			"adjudicator_allocations.adjudicator_id != %d";
			$query2 = sprintf($query2, $debate[0]->getId(), $this->adjudicator->getId());
			$rs = $stmt->executeQuery($query2, ResultSet::FETCHMODE_NUM);
			$adjudicatorAllocations = AdjudicatorAllocationPeer::populateObjects($rs);
			if($adjudicatorAllocations == null)
			{
				throw new Exception("All feedback from panelists have been entered.");
			}			
			$this->feedbackingAdjudicators = array();
			foreach($adjudicatorAllocations as $allocation)
			{	
				$query3 = "SELECT * FROM adjudicator_feedback_sheets WHERE adjudicator_allocation_id = %d ".
								 "AND adjudicator_id = %d";
				$query3 = sprintf($query3, $allocation->getId(), $this->adjudicator->getId());
				$rs = $stmt->executeQuery($query3, ResultSet::FETCHMODE_NUM);
				$feedbackSheet = AdjudicatorFeedbackSheetPeer::populateObjects($rs);
				if($feedbackSheet == null)
				{
					$this->feedbackingAdjudicators[] = $allocation->getAdjudicator();
				}
			}*/
			$this->feedbackingAdjudicators = AdjudicatorFeedbackSheet::getFeedbackingAdjudicators($this->adjudicator, $this->round);
			if(count($this->feedbackingAdjudicators) == 0)
			{
				throw new Exception("All feedback from panelists have been entered.");
			}
		}
	}
	
	public function executeEnterFeedback()
	{
		$this->round = RoundPeer::retrieveByPK($this->getRequestParameter("id"));
		$this->adjudicator = AdjudicatorPeer::retrieveByPK($this->getRequestParameter("adjudicator"));
		$this->source = $this->getRequestParameter("source");
		$this->comments = $this->getRequestParameter("comments");
		if($this->source == 1)
		{
			$this->team = TeamPeer::retrieveByPk($this->getRequestParameter("team"));
			$con = Propel::getConnection();
			$stmt = $con->createStatement();
			$query = "SELECT debates_teams_xrefs.* from debates, debates_teams_xrefs WHERE ".
			"debates_teams_xrefs.team_id = %d AND debates.round_id=%d AND debates.id = debates_teams_xrefs.debate_id";
			$query = sprintf($query, $this->getRequestParameter("team"), $this->getRequestParameter("id"));
			$rs = $stmt->executeQuery($query, ResultSet::FETCHMODE_NUM);
			$this->feedbackFrom = DebateTeamXrefPeer::populateObjects($rs);				
		}
		else if($this->source == 2)
		{
			$this->feedbackingAdjudicator = AdjudicatorPeer::retrieveByPk($this->getRequestParameter("feedbackingAdjudicator"));
			$con = Propel::getConnection();
			$stmt = $con->createStatement();
			$query = "SELECT adjudicator_allocations.* from debates, adjudicator_allocations WHERE ".
			"adjudicator_allocations.adjudicator_id = %d AND debates.round_id=%d AND debates.id = adjudicator_allocations.debate_id";
			$query = sprintf($query, $this->getRequestParameter("feedbackingAdjudicator"), $this->getRequestParameter("id"));
			$rs = $stmt->executeQuery($query, ResultSet::FETCHMODE_NUM);
			$this->feedbackFrom = AdjudicatorAllocationPeer::populateObjects($rs);	
		}
	}
	
	public function validateConfirmFeedback()
	{
		$score = $this->getRequestParameter("score");
		if($score < 1 || $score > 5)
		{
			$this->getRequest()->setError("scoreError", "The scores entered for this adjudicator were not within range");
			return false;
		}
		return true;
	}
	
	public function handleErrorConfirmFeedback()
	{
		$source = $this->getRequestParameter("source");
		if($source == 1)
		{
			$this->getRequest()->setParameter("team", $this->getRequestParameter("team"));
		}
		else if($source == 2)
		{
			$this->getRequest()->setParameter("feedbackingAdjudicator", $this->getRequestParameter("feedbackingAdjudicator"));
		}
		$this->getRequest()->setParameter("adjudicator",$this->getRequestParameter("adjudicator"));
		$this->getRequest()->setParameter("id", $this->getRequestParameter("id"));
		$this->getRequest()->setParameter("source", $source);
		$this->getRequest()->setParameter("comments", $this->getRequestParameter("comments"));
		$this->forward('tournament', 'enterFeedback');
	}
	
	public function executeConfirmFeedback()
	{
		$round = RoundPeer::retrieveByPK($this->getRequestParameter("id"));
		$propelConn = Propel::getConnection();
        try
        {			
            $propelConn->begin();
            $feedback = new AdjudicatorFeedbackSheet();
			$feedback->setAdjudicatorId($this->getRequestParameter("adjudicator"));
			if($this->getRequestParameter("source") == 1)
			{
				$feedback->setDebateTeamXrefId($this->getRequestParameter("sourceId"));
			}
			else if($this->getRequestParameter("source") == 2)
			{
				$feedback->setAdjudicatorAllocationId($this->getRequestParameter("sourceId"));
			}
			$feedback->setComments($this->getRequestParameter("comments"));
			$feedback->setScore($this->getRequestParameter("score"));
            $feedback->save($propelConn);
			
			if(AdjudicatorFeedbackSheet::feedbackComplete($round, $propelConn))
			{
				if($round->getStatus == Round::ROUND_STATUS_TRAINEE_FEEDBACK_ENTRY_COMPLETE)
				{
					$round->setStatus(Round::ROUND_STATUS_COMPLETE);
				}
				else
				{
					$round->setStatus(Round::ROUND_STATUS_ADJUDICATOR_FEEDBACK_ENTRY_COMPLETE);
				}
				$round->save($propelConn);
				$propelConn->commit();
				$this->redirect("tournament/index");
			}
            $propelConn->commit();
        }
        catch(Exception $e)
        {
            $propelConn->rollback();
            throw $e;
        }
		
		$link = "tournament/feedbackEntry?id=".$round->getId();
        $this->redirect($link);
	}
	
	public function executeTraineeFeedbackEntry()
	{
		$this->round = RoundPeer::retrieveByPK($this->getRequestParameter("id"));
		$c = new Criteria;
		$c->add(TraineeAllocationPeer::ROUND_ID,$this->round->getId());
		$this->traineeAllocations = TraineeAllocationPeer::doSelect($c);
	}
	
	public function executeEnterTraineeFeedback()
	{
		$this->round = RoundPeer::retrieveByPK($this->getRequestParameter("id"));
		$this->allocation = TraineeAllocationPeer::retrieveByPk($this->getRequestParameter("traineeAllocation"));	
		$this->comments = $this->getRequestParameter("comments");
	}
	
	public function validateConfirmTraineeFeedback()
	{
		$score = $this->getRequestParameter("score");
		if($score < 1 || $score > 5)
		{
			$this->getRequest()->setError("scoreError", "The score entered for this trainee were not within range");
			return false;
		}
		return true;
	}
	
	public function handleErrorConfirmTraineeFeedback()
	{		
		$this->getRequest()->setParameter("comments", $this->getRequestParameter("comments"));
		$this->getRequest()->setParameter("traineeAllocation", $this->getRequestParameter("traineeAllocation"));
		$this->forward('tournament', 'enterTraineeFeedback');
	}
	
	public function executeConfirmTraineeFeedback()
	{
		$round = RoundPeer::retrieveByPK($this->getRequestParameter("id"));
		$propelConn = Propel::getConnection();
        try
        {			
            $propelConn->begin();
            $feedback = new AdjudicatorFeedbackSheet();
			$feedback->setAdjudicatorId($this->getRequestParameter("trainee"));
			
			$chair = AdjudicatorPeer::retrieveByPk($this->getRequestParameter("chair"));
			$feedback->setAdjudicatorAllocation($chair->getAdjudicatorAllocation($round));
			
			$feedback->setComments($this->getRequestParameter("comments"));
			$feedback->setScore($this->getRequestParameter("score"));
			$feedback->save($propelConn);
			
			/*
			if(!TraineeAllocation::getNotFeedbacked($round))
			{
				if($round->getStatus() == Round::ROUND_STATUS_ADJUDICATOR_FEEDBACK_ENTRY_COMPLETE)
				{
					$round->setStatus(Round::ROUND_STATUS_COMPLETE);
				}
				else
				{
					$round->setStatus(Round::ROUND_STATUS_TRAINEE_FEEDBACK_ENTRY_COMPLETE);
				}
				$round->save($propelConn);
				
				$propelConn->commit();
				$this->redirect("tournament/index");
			}*/
			
            $propelConn->commit();
        }
        catch(Exception $e)
        {
            $propelConn->rollback();
            throw $e;
        }
		
        
		$link = "tournament/traineeFeedbackEntry?id=".$round->getId();
        $this->redirect($link);
	}
	
	public function executeViewMatchups()
    {
        $this->round = RoundPeer::retrieveByPK($this->getRequestParameter('id'));
    }
	
	 public function executeViewMatchupsWithAdjudicators()
    {
        $this->round = RoundPeer::retrieveByPK($this->getRequestParameter('id'));
    }
    
     public function executeViewMatchupsWithAdjudicatorsLess()
    {
        $this->round = RoundPeer::retrieveByPK($this->getRequestParameter('id'));
    }
    
     public function executeViewMatchupsWithAdjudicatorsLessRandom()
    {
        $this->round = RoundPeer::retrieveByPK($this->getRequestParameter('id'));
    }
	
	
	public function getDuplicateAdjudicators($adjudicators)
	{
		$uniqueAdjudicators = array_unique($adjudicators);
		$duplicateAdjudicators = array();
		for($i = 0; $i < count($adjudicators);  $i++)
		{
			if(!array_key_exists($i, $uniqueAdjudicators))
			{
				$duplicateAdjudicators[] = $adjudicators[$i];
			}
		}
		return $duplicateAdjudicators;
	}
	
	public function getAdjudicatorAssignments($adjudicator, $panels)
	{
		$debates = array();
		foreach($panels as $number => $panel)
		{
			foreach($panel as $p)
			{
				if($p == $adjudicator)
				{
					$debates[] = $number;
				}
			}
		}
		return $debates;
	}
    
	public function getUnallocatedAdjudicators($allocations)
	{
		$allocatedAdjudicators = array();
		foreach($allocations as $anAllocation)
		{
			foreach($anAllocation as $adjAllocation)
			{
				$allocatedAdjudicators[] = $adjAllocation->getAdjudicator();
			}
		}
		$c = new Criteria();
		$c->add(AdjudicatorPeer::ACTIVE, true);
		$adjudicators = AdjudicatorPeer::doSelect($c);
		$unallocatedAdjudicators = array();
		foreach($adjudicators as $anAdjudicator)
		{
			if(!in_array($anAdjudicator, $allocatedAdjudicators))
			{
				$unallocatedAdjudicators[] = $anAdjudicator;
			}
		}
		return $unallocatedAdjudicators;
	}
}
