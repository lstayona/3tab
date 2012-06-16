<?php

/**
 * Subclass for representing a row from the 'adjudicators' table.
 *
 * 
 *
 * @package lib.model
 */ 
class Adjudicator extends BaseAdjudicator
{
	public function getInfo($conn = null)
    {
		return $this->getName()." - ".
		$this->getInstitution($conn)->getCode($conn);
	}
	
	public function getInfoPlus($conn = null)
    {
		$currentRound = RoundPeer::getCurrentRound($conn);
		return $this->getName()." - ".
		$this->getInstitution($conn)->getCode($conn)." - ".
		round($this->getScore($currentRound), 2);
	}
	
	public function getTeamsAdjudicated($con = null)
	{
		$c = new Criteria();
		$c->add(AdjudicatorAllocationPeer::TYPE, AdjudicatorAllocation::ADJUDICATOR_TYPE_TRAINEE, Criteria::NOT_EQUAL);
		$allocations = $this->getAdjudicatorAllocations($c, $con);
		$teams = array();
		foreach($allocations as $anAllocation)
		{
			$teams[] = $anAllocation->getDebate()->getDebateTeamXref(1, $con)->getTeam($con);
			$teams[] = $anAllocation->getDebate()->getDebateTeamXref(2, $con)->getTeam($con);
		}
		return $teams;
	}
	
	public function hasTeamBeenAdjudicated($team, $con=null)
	{
		$teamsAdjudicated = $this->getTeamsAdjudicated($con);
		if(in_array($team, $teamsAdjudicated))
		{
			return true;
		}		
		return false;
	}
	
	public function haveTeamsBeenAdjudicated($teams, $con=null)
	{
		$teamsAdjudicated = $this->getTeamsAdjudicated($con);
		foreach($teams as $team)
		{
			if(in_array($team, $teamsAdjudicated))
			{
				return true;
			}
		}
		return false;
	}
	
	public function save($con = null)
	{
		$conflicts = $this->createHomeInstitutionConflicts($con);
		foreach($conflicts as $conflict)
		{	
			if($conflict != null)
			{
				$this->addAdjudicatorConflict($conflict);
			}
		}
		parent::save($con);
	}
	
	public function delete($con = null)
	{		
		$conflicts = $this->getAdjudicatorConflicts();
		foreach($conflicts as $aConflict)
		{
			$aConflict->delete($con);		
		}
		parent::delete($con);
	}
	
	public function getDebate($round, $conn = null)
	{
		$allocations = $this->getAdjudicatorAllocations();
		foreach($allocations as $anAllocation)
		{
			$debate = $anAllocation->getDebate($conn);
			if($debate->getRound($conn)->getId() == $round->getId())
			{	
				return $debate;
			}
		}
		return null;
	}
	
	public function getAdjudicatorAllocation($round, $conn = null)
	{		
		$allocations = $this->getAdjudicatorAllocations();
		foreach($allocations as $anAllocation)
		{
			$debate = $anAllocation->getDebate($conn);
			if($debate->getRound($conn)->getId() == $round->getId())
			{	
				return $anAllocation;
			}
		
		}
		return null;	
	}
	
	public function getTrainees($round, $conn = null)
	{
		$c = new Criteria();
		$c->add(TraineeAllocationPeer::ROUND_ID, $round->getId());
		$traineeAllocations = $this->getTraineeAllocationsRelatedByChairId($c, $conn);
		$trainees = array();
		foreach($traineeAllocations as $anAllocation)
		{
			$trainees[] = $anAllocation->getAdjudicatorRelatedByTraineeId();
		}
		
		return $trainees;
	
	}
	
	public function getScore($round=null, $conn = null)
	{
		if($round == null)
		{
			$round = RoundPeer::getCurrentRound();
			
		}
		$feedbackWeightage = $round->getFeedbackWeightage($conn);
		if($this->getAverageFeedbackScore($conn) != null)
		{
			$score = $this->getTestScore($conn)*(1-$feedbackWeightage) +$this->getAverageFeedbackScore($conn)*$feedbackWeightage;
			$score = $score;
		}
		else
		{
			$score = $this->getTestScore($conn);
		}
		return $score;
	}
        
        public function getAverageFeedbackScoreForRound($round, $con = null)
        {
            if(is_null($con))
            {
                $con = Propel::getConnection();
            }
            
            $query = "select count(score) as t_count from adjudicator_feedback_sheets, adjudicator_allocations, debates, rounds where 
                     adjudicator_allocation_id = adjudicator_allocations.id
                     and adjudicator_allocations.debate_id = debates.id
                     and debates.round_id = rounds.id
                     and rounds.id = %d
                     and adjudicator_feedback_sheets.adjudicator_id=%d";
            $query = sprintf($query, $round->getId(), $this->getId());
            $statement = $con->prepareStatement($query);
            $rs = $statement->executeQuery();
	    $rs->next();
            if($rs->getInt('t_count') == 1)
	    {
		$query = "select score as t_score from adjudicator_feedback_sheets, adjudicator_allocations, debates, rounds where 
                     adjudicator_allocation_id = adjudicator_allocations.id
                     and adjudicator_allocations.debate_id = debates.id
                     and debates.round_id = rounds.id
                     and rounds.id = %d
                     and adjudicator_feedback_sheets.adjudicator_id=%d";
                    $query = sprintf($query, $round->getId(), $this->getId());
                    $statement = $con->prepareStatement($query);
                    $rs = $statement->executeQuery();
                    $rs->next();
                    return $rs->getFloat('t_score');
	    }else{
                $query = "select count(score) as a_count from adjudicator_feedback_sheets, debates_teams_xrefs, debates, rounds where 
                    debate_team_xref_id = debates_teams_xrefs.id
                    and debates_teams_xrefs.debate_id = debates.id
                    and debates.round_id = rounds.id
                    and rounds.id = %d
                    and adjudicator_id=%d";
                    $query = sprintf($query, $round->getId(), $this->getId());
                    $statement = $con->prepareStatement($query);
                    $rs = $statement->executeQuery();
                    $rs->next();                   
            
                if($rs->getInt('a_count') >= 1)
                {
                    $query = "select avg(score) as a_score from adjudicator_feedback_sheets, debates_teams_xrefs, debates, rounds where 
                        debate_team_xref_id = debates_teams_xrefs.id
                        and debates_teams_xrefs.debate_id = debates.id
                        and debates.round_id = rounds.id
                        and rounds.id = %d
                        and adjudicator_id=%d";
                    $query = sprintf($query, $round->getId(), $this->getId());
                    $statement = $con->prepareStatement($query);
                    $rs = $statement->executeQuery();
                    $rs->next();   
                    return $rs->getFloat('a_score');
                    
                }
                    
                    
                    
            }
        }
	
	public function getAverageFeedbackScore($con = null)
	{
		if(is_null($con))
        {
            $con = Propel::getConnection();
        }
		$query = "SELECT count(score) AS count from adjudicator_feedback_sheets WHERE adjudicator_id = %d";
		$query = sprintf($query, $this->getId());
		$statement = $con->prepareStatement($query);
		$rs = $statement->executeQuery();
		$rs->next();
		if($rs->getInt('count') == 0)
		{
			return null;
		}
		
		$query = "SELECT avg(score) AS score from adjudicator_feedback_sheets WHERE adjudicator_id = %d";
		$query = sprintf($query, $this->getId());
		$statement = $con->prepareStatement($query);
		$rs = $statement->executeQuery();
		$rs->next();
		return $rs->getFloat('score');
	}
	
	public function createConflict($team, $con=null)
	{
		$c = new Criteria();
		$c->add(AdjudicatorConflictPeer::TEAM_ID, $team->getId());
		$c->add(AdjudicatorConflictPeer::ADJUDICATOR_ID, $this->getId());
		$conflict = AdjudicatorConflictPeer::doSelect($c, $con);
		if($conflict == null)
		{
			$conflict = new AdjudicatorConflict();
			$conflict->setTeam($team);
			$conflict->setAdjudicator($this);
			return $conflict;
		}
		return null;
	}
	
	public function createHomeInstitutionConflicts($con = null)
	{
		$conflicts = array();
		$c = new Criteria();
		$c->add(TeamPeer::INSTITUTION_ID, $this->getInstitutionId());
		$teams = TeamPeer::doSelect($c, $con);
		foreach($teams as $team)
		{
			$conflicts[] = $this->createConflict($team, $con);
		}

		return $conflicts;
	}

    public function hasCheckedIn($round, $con = null)
    {
        $c = new Criteria();
        $c->add(AdjudicatorCheckinPeer::ROUND_ID, $round->getId());

        return $this->countAdjudicatorCheckins($c, false, $con) > 0 ? true : false;
    }
}
