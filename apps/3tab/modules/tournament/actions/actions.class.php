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
        $this->debates = DebatePeer::doDraw($this->round, 
        	sfConfig::get('app_on_same_institution', false) == 1 ? true : false, 
        	sfConfig::get('app_on_have_met_before', false) == 1 ? true : false);
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
		$this->adjudicators = AdjudicatorPeer::getAdjudicatorsByTestScore();
	
		// If there is an error with the submission, use this to repopulate 
		// form data.	
		if($this->getRequestParameter("skipProcessing"))
		{
			$this->adjudicatorAllocations = $this->getRequestParameter("allocations");
        }
        // The request is coming from pre-allocation form or tournament 
        // management screen.
        else
        {
        	$debates = $this->round->getDebates();		
        	if ($this->round->getStatus() >= Round::ROUND_STATUS_ADJUDICATOR_ALLOCATIONS_CONFIRMED)
        	{
        		$panels = array();
        		foreach ($debates as $number => $debate)
        		{
        			$panels[$number] = array();
        			$c = new Criteria();
        			$c->add(AdjudicatorAllocationPeer::TYPE, AdjudicatorAllocation::ADJUDICATOR_TYPE_TRAINEE, Criteria::NOT_EQUAL);
        			$c->addAscendingOrderByColumn(AdjudicatorAllocationPeer::TYPE);
        			$c->addAscendingOrderByColumn(AdjudicatorAllocationPeer::ID);

        			foreach ($debate->getAdjudicatorAllocations($c) as $adjudicatorAllocation)
        			{
        				$panels[$number][] = $adjudicatorAllocation;
        			}
        		}

				$this->adjudicatorAllocations = $panels;
        	}
        	else
        	{
        		$allocator = new AdjudicatorAllocator();

        		if($this->round->getType() == Round::ROUND_TYPE_RANDOM)
        		{		
        			$allocator->setup($debates, $this->adjudicators, true, false);
        		}
        		else if($this->round->getType() == Round::ROUND_TYPE_PRELIMINARY)
        		{
        			$debateEnergies = $this->getRequestParameter("debateEnergies");
        			$allocator->setup($debates, $this->adjudicators, false, false);
        			$allocator->setDebateEnergies($debateEnergies);
        		}		
        		else if($this->round->getType() == Round::ROUND_TYPE_BUBBLE)
        		{
        			$debateEnergies = $this->getRequestParameter("debateEnergies");
        			$allocator->setup($debates, $this->adjudicators, false, true);	
        			$allocator->setDebateEnergies($debateEnergies);
        		}

        		$this->adjudicatorAllocations = $allocator->allocate();
        	}
        }
    }

	public function executePreAdjudicatorAllocation()
	{
		$this->round = RoundPeer::retrieveByPK($this->getRequestParameter("id"));
		$this->debates = $this->round->getDebates();
		$this->debateEnergies = array();

		if ($this->round->getStatus() >= Round::ROUND_STATUS_ADJUDICATOR_ALLOCATIONS_CONFIRMED or 
			$this->round->getType() == Round::ROUND_TYPE_RANDOM) 
		{
			$this->redirect('tournament/createAdjudicatorAllocation?id=' . $this->getRequestParameter("id"));
		}

		foreach($this->debates as $aDebate)
		{
			if($this->round->getType() == Round::ROUND_TYPE_PRELIMINARY)
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
		
		if ($round->hasResultsEntered())
		{
			throw new Exception("Cannot change adjudicator allocations when " .
				"results have already been entered for the round.");
		}	

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
					$conflicts[$number][$position] = DebatePeer::retrieveByPk($debateIds[$number])->checkIfAdjudicatorIsConflicted(AdjudicatorPeer::retrieveByPk($p));	
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

            // Delete all allocations
            foreach ($round->getDebates(null, $propelConn) as $debate)
            {
            	foreach ($debate->getAdjudicatorAllocations(null, $propelConn) as $adjudicatorAllocation)
            	{
            		$adjudicatorAllocation->delete($propelConn);
            	}
            }

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
		$this->debates = $this->round->getDebates();
		$this->trainees = AdjudicatorPeer::getUnallocatedAdjudicators($this->round);

		if ($this->getRequest()->getMethod() == sfRequest::GET)
		{
			$panels = array();
			foreach ($this->debates as $number => $debate)
			{
				$c = new Criteria();
				$c->add(AdjudicatorAllocationPeer::TYPE, AdjudicatorAllocation::ADJUDICATOR_TYPE_TRAINEE);
				$c->addAscendingOrderByColumn(AdjudicatorAllocationPeer::ID);
				foreach ($debate->getAdjudicatorAllocations($c) as $traineeAllocation)
				{
					$panels[$number][] = $traineeAllocation->getAdjudicatorId();
				}
			}

			$this->getRequest()->setParameter('trainees', $panels);
		}
	}
	
	public function validateConfirmTraineeAllocation()
	{
		$round = RoundPeer::retrieveByPk($this->getRequestParameter('id'));
		$trainees = $this->getRequestParameter('trainees');
		$debateIds = $this->getRequestParameter('debates');
		$conflicts = array();
		$hasError = false;

		$allocatedTrainees = array();
		foreach($trainees as $number => $traineesForChair)
		{
			foreach($traineesForChair as $position => $aTrainee)
			{
				if($aTrainee != null)
				{
					$allocatedTrainees[] = $aTrainee;
					$conflicts[$number][$position] = DebatePeer::retrieveByPk($debateIds[$number])->checkIfAdjudicatorIsConflicted(AdjudicatorPeer::retrieveByPk($aTrainee));
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
			foreach ($round->getDebates(null, $propelConn) as $number => $debate)
			{
				$c = new Criteria();
				$c->add(AdjudicatorAllocationPeer::TYPE, AdjudicatorAllocation::ADJUDICATOR_TYPE_TRAINEE);
				foreach ($debate->getAdjudicatorAllocations($c, $propelConn) as $traineeAllocation)
				{
					$traineeAllocation->delete($propelConn);
				}
			}

			$traineeAdjudicatorIds = $this->getRequestParameter('trainees');
			foreach ($this->getRequestParameter('debates') as $number => $debateId)
			{
				foreach ($traineeAdjudicatorIds[$number] as $adjudicatorId)
				{
					if($adjudicatorId != 0)
					{
						$allocation = new AdjudicatorAllocation();
						$allocation->setDebateId($debateId);
						$allocation->setAdjudicatorId($adjudicatorId);
						$allocation->setType(AdjudicatorAllocation::ADJUDICATOR_TYPE_TRAINEE);
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
            	$adjudicatorAllocation = 
            	  AdjudicatorAllocationPeer::retrieveByPK($adjudicatorAllocationId, $propelConn);

            	if ($adjudicatorAllocation->getType() == AdjudicatorAllocation::ADJUDICATOR_TYPE_TRAINEE)
            	{
            		throw new Exception("Result submitted for trainee");
            	}

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

            TeamScorePeer::flushAndRepopulate($propelConn);
            SpeakerScorePeer::flushAndRepopulate($propelConn);
            DebateTeamXrefPeer::populateResultInformationForRound($this->getRequestParameter('id'), $propelConn);

            $round = RoundPeer::retrieveByPk($this->getRequestParameter('id'));
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
                $this->teams = AdjudicatorFeedbackSheet::getTeamsWithPendingFeedback($this->round);
	}	
	
	public function executeEnterFeedback()
	{
		$this->round = RoundPeer::retrieveByPK($this->getRequestParameter("id"));
		$this->team = TeamPeer::retrieveByPK($this->getRequestParameter("team"));
                $this->adjudicatorsToFeedback = AdjudicatorFeedbackSheet::getFeedbacksExpected($this->round, $this->team);		
	}
	
	public function validateConfirmFeedback()
	{
                $adjCount = $this->getRequestParameter("adjCount");
                for($i = 1; $i < $adjCount; $i++){
                    $score = $this->getRequestParameter("score".$i);
                    if( $score == 0) return true;
                    else if($score < 1 || $score > 5){
                        $this->getRequest()->setError("scoreError", "The scores entered for adjudicator ".
                                                                     $i." were not within range");
                        return false;
                    }                    
                }
                return true;                
	}
	
	public function handleErrorConfirmFeedback()
	{
		$this->getRequest()->setParameter("team",$this->getRequestParameter("team"));
		$this->getRequest()->setParameter("id", $this->getRequestParameter("id"));
		$this->forward('tournament', 'enterFeedback');
	}
	
	public function executeConfirmFeedback()
	{
		$round = RoundPeer::retrieveByPK($this->getRequestParameter("id"));
		$propelConn = Propel::getConnection();
                try
                {			
                    $propelConn->begin();
                    $team = TeamPeer::retrieveByPK($this->getRequestParameter("team"));
                    $debateTeamXref = $team->getDebate($round->getId())->getDebateTeamXrefForTeam($team->getId());
                    $adjCount = $this->getRequestParameter("adjCount");
                    for($i = 1; $i < $adjCount; $i++){
                        $feedback = new AdjudicatorFeedbackSheet();
                        $feedback->setAdjudicatorId($this->getRequestParameter("adjudicator".$i));                        
                        $feedback->setDebateTeamXref($debateTeamXref);
                        $feedback->setComments($this->getRequestParameter("comments".$i));
                        //only save if a score entered
                        $score =$this->getRequestParameter("score".$i);
                        $feedback->setScore($score);
                        if($score) $feedback->save($propelConn);
                    }
                }
                catch(Exception $e)
                {
                    $propelConn->rollback();
                    throw $e;
                }
                
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
                $link = "tournament/feedbackEntry?id=".$round->getId();
                $this->redirect($link);
	}
	
	public function executeTraineeFeedbackEntry()
	{
                //grab all the chairs who still have pending trainees
		$this->round = RoundPeer::retrieveByPK($this->getRequestParameter("id"));
                //$this->chairAllocations = AdjudicatorAllocationPeer::getChairsWithTrainees($this->round);
		$this->chairAllocations = AdjudicatorAllocationPeer::getChairAllocationsWithTraineesWithoutFeedback($this->round);	
	}
	
	public function executeEnterTraineeFeedback()
	{
                //get all trainees for selected chair
            	$this->round = RoundPeer::retrieveByPK($this->getRequestParameter("id"));
		$this->chairAllocation = AdjudicatorAllocationPeer::retrieveByPk($this->getRequestParameter("chairAllocation"));
                $this->traineeAllocations = $this->chairAllocation->getTraineeAllocationsWithoutFeedback();
	}
	
	public function validateConfirmTraineeFeedback()
	{
		$traineeCount = $this->getRequestParameter("traineeCount");
                for($i = 1; $i < $traineeCount; $i++){
                    $score = $this->getRequestParameter("score".$i);
                    if($score < 1 || $score > 5){
                        $this->getRequest()->setError("scoreError", "The scores entered for adjudicator ".
                                                                     $i." were not within range");
                        return false;
                    }                    
                }
                return true; 
	}
	
	public function handleErrorConfirmTraineeFeedback()
	{		
		$this->getRequest()->setParameter("comments", $this->getRequestParameter("comments"));
		$this->getRequest()->setParameter("traineeAllocation", $this->getRequestParameter("traineeAllocation"));
                $this->getRequest()->setParameter("chairAllocation", $this->getRequestParameter("chairAllocation"));
		$this->forward('tournament', 'enterTraineeFeedback');
	}
	
	public function executeConfirmTraineeFeedback()
	{
		$round = RoundPeer::retrieveByPK($this->getRequestParameter("id"));
		$propelConn = Propel::getConnection();
        try
        {			
            $propelConn->begin();
                    $chairAllocation = AdjudicatorAllocationPeer::retrieveByPk($this->getRequestParameter("chairAllocation"));
                    $adjCount = $this->getRequestParameter("adjCount");
                    for($i = 1; $i < $adjCount; $i++){
                        $feedback = new AdjudicatorFeedbackSheet();
                        $feedback->setAdjudicatorId($this->getRequestParameter("trainee".$i));                        
                        $feedback->setAdjudicatorAllocation($chairAllocation);
                        $feedback->setComments($this->getRequestParameter("comments".$i));
                        //only save if a score entered
                        $score =$this->getRequestParameter("score".$i);
                        $feedback->setScore($score);
                        if($score) $feedback->save($propelConn);
                    }
                    
            
        }
        catch(Exception $e)
        {
            $propelConn->rollback();
            throw $e;
        }
        $propelConn->commit();
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
        $this->hideNavigationBar = true;
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
}
