<?php

/**
 * Subclass for representing a row from the 'debates' table.
 *
 * 
 *
 * @package lib.model
 */ 
class Debate extends BaseDebate
{	
    public static function getNumberOfTeamsPerDebate()
    {
        return 2;
    }
    
	public function checkIfAdjudicatorIsConflicted($adjudicator, $con = null)
	{
        $c = new Criteria();
        $c->add(DebatePeer::ID, $this->getId());
        $c->addJoin(DebateTeamXrefPeer::DEBATE_ID, DebatePeer::ID);
        $c->addJoin(AdjudicatorConflictPeer::TEAM_ID, DebateTeamXrefPeer::TEAM_ID);

        return $adjudicator->countAdjudicatorConflicts($c, true, $con) > 0 ? true : false;
	}

    public function areBothTeamsInDebateFromSameInstitution($conn = null)
    {
        $debateTeamXrefs = $this->getDebateTeamXrefs(new Criteria(), $conn);
        if(count($debateTeamXrefs) == Debate::getNumberOfTeamsPerDebate())
        {
            if($debateTeamXrefs[0]->getTeam($conn)->getInstitutionId() == 
              $debateTeamXrefs[1]->getTeam($conn)->getInstitutionId())
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        else
        {
            throw new Exception(
            "There should be ".Debate::getNumberOfTeamsPerDebate()." and only ".
            Debate::getNumberOfTeamsPerDebate()." teams in this debate.  Got " . 
            count($debateTeamXrefs) . "instead."); 
        }
    }
	
	public function haveBothTeamsMetBefore($conn = null)
	{	
		$debateTeamXrefs = $this->getDebateTeamXrefs(new Criteria(), $conn);
		 if(count($debateTeamXrefs) == Debate::getNumberOfTeamsPerDebate())
        {
			$team1 = $debateTeamXrefs[0]->getTeam($conn);
			$team2 = $debateTeamXrefs[1]->getTeam($conn);
			$teamsMetByTeam1 = $team1->getTeamsDebated($conn);
            foreach($teamsMetByTeam1 as $teamMet)
			{
				if($teamMet->getId() == $team2->getId())
				{
					return true;
				}
			}
			return false;
        }
        else
        {
            throw new Exception(
            "There should be ".Debate::getNumberOfTeamsPerDebate()." and only ".
            Debate::getNumberOfTeamsPerDebate()." teams in this debate.  Got " . 
            count($debateTeamXrefs) . "instead."); 
        }
		return false;
	}

	
	public function getDebateTeamXref($position, $conn = null)
	{
		$c = new Criteria();
		$c->add(DebateTeamXrefPeer::DEBATE_ID, $this->getId());
		$c->add(DebateTeamXrefPeer::POSITION, $position);
		$xrefs = DebateTeamXrefPeer::doSelect($c, $conn);
		return $xrefs[0];
	}
    
    public function getDebateTeamXrefForTeam($teamId, $con = null)
    {
        $c = new Criteria();
        $c->add(DebateTeamXrefPeer::DEBATE_ID, $this->getId());
		$c->add(DebateTeamXrefPeer::TEAM_ID, $teamId);
        $debateTeamXrefs = DebateTeamXrefPeer::doSelect($c, $con);

        if (count($debateTeamXrefs) > 1) {
            throw new Exception("More than one DebateTeamXref returned for " . 
            "team_id = " . $teamId . " and debate_id = " . $this->getId());
        } else if (count($debateTeamXrefs) < 1) {
            throw new Exception("No DebateTeamXref returned for " . 
            "team_id = " . $teamId . " and debate_id = " . $this->getId());
        } else {
            return $debateTeamXrefs[0];
        }
    }

	public function getTeam($position, $conn = null)
	{
		foreach($this->getDebateTeamXrefs(new Criteria(), $conn) as $debateTeamXref)
        {
            if($debateTeamXref->getPosition() == $position)
            {
                return $debateTeamXref->getTeam($conn);
            }
        }
        
        throw new Exception("No team has filled the position with value '" .
        $position . "' for this debate.");
	}
	
	public function getInfo($conn = null)
	{
		return $this->getTeam(1, $conn)->getName()." - ".$this->getTeam(2, $conn)->getName();
	}
	
	public function getUnscoredAdjudicatorAllocations($conn=null)
	{

		$allocations = $this->getAdjudicatorAllocations(null, $conn);
		$unscoredAllocations = array();
		foreach($allocations as $allocation)
		{
			if($allocation->countTeamScoreSheets() < 2)
			{
				$unscoredAllocations[] = $allocation;
			}	
		}
		return $unscoredAllocations;
	}
		
	public function getDebateInfo($onlyNotScored = false)
	{
		$venueName = $this->getVenue()->getName();
		$xrefs = $this->getDebateTeamXrefs();
		$teamGov = $xrefs[0]->getTeam();
		$teamOpp = $xrefs[1]->getTeam();
		
		$output = $venueName." ".$teamGov->getName()." ".$teamOpp->getName();
		
		return $output;
	}
	
	public function getBracket($con = null)
	{
        if (is_null($this->getRound($con)->getPrecededByRoundId())) 
        {
            return 0;
        }
        else if ($this->getRound($con)->isCurrentRound($con) and 
          !($this->getRound($con)->isFinalRound($con) and $this->getRound($con)->getStatus() >= Round::ROUND_STATUS_RESULT_ENTRY_COMPLETE))
        {
            $bracket = 0;
            foreach($this->getDebateTeamXrefs(null, $con) as $debateTeamXref) {
                $score = $debateTeamXref->getTeam($con)->getTotalTeamScore($con); 
                if ($score > $bracket) {
                    $bracket = $score;
                }
            }

            return $bracket;
        }
        else 
        {
            $previousRound = $this->getRound($con)->getRoundRelatedByPrecededByRoundId($con);
            $bracket = 0;
            foreach($this->getDebateTeamXrefs(null, $con) as $debateTeamXref) {
                $score = $debateTeamXref->getTeam($con)->getTotalTeamScoreAtRound($previousRound, $con); 
                if ($score > $bracket) {
                    $bracket = $score;
                }
            }

            return $bracket;
        }
	}
	
	public function getEnergy($bubble=false, $conn=null)
	{
		$debate = new MiniDebate();
		$debate->setDebateId($this->getId(), $bubble);
		return $debate->getEnergy();
	}
    
    public function resultsEntered($conn = null)
    {
    	$c = new Criteria();
    	$c->add(AdjudicatorAllocationPeer::TYPE, AdjudicatorAllocation::ADJUDICATOR_TYPE_TRAINEE, Criteria::NOT_EQUAL);
        foreach($this->getAdjudicatorAllocations($c, $conn) as $adjudicatorAllocation)
        {
        	$teamScoreSheetCount = $adjudicatorAllocation->countTeamScoreSheets(new Criteria(), $conn);
            if($teamScoreSheetCount < 2)
            {
                return false;
            }
            else if($teamScoreSheetCount > 2)
            {
                throw new Exception("More than 2 team score sheets.");
            }
            
            $speakerScoreSheetCount = $adjudicatorAllocation->countSpeakerScoreSheets(new Criteria(), $conn);
            if($speakerScoreSheetCount < 8)
            {
                return false;
            }
            else if($speakerScoreSheetCount > 8)
            {
                throw new Exception("More than 8 speaker score sheets");
            }
        }
        
        return true;
    }
    
    //get the winning team as default, if want to get losing team, pass in false as the first argument
	public function getWinningDebateTeamXref($winner = true, $conn = null)
    {
        if($this->resultsEntered($conn))
		{
			$c = new Criteria();
			$c->addJoin(TeamResultPeer::DEBATE_TEAM_XREF_ID, DebateTeamXrefPeer::ID);
			$c->add(DebateTeamXrefPeer::DEBATE_ID, $this->getId());
			$c->add(TeamResultPeer::MAJORITY_TEAM_SCORE, 1);
			$winningDebateTeamResult = TeamResultPeer::doSelectOne($c, $conn);
		
			return $winner ? $winningDebateTeamResult->getDebateTeamXrefRelatedByDebateTeamXrefId($conn) : 
			$winningDebateTeamResult->getDebateTeamXrefRelatedByOpponentDebateTeamXrefId($conn);
		}
		else
		{
			return null;
		}
    }
	//gets the majority adjudicator allocations as default, if want to get minority, pass in false as the first argument	
	public function getAdjudicatorAllocationsInMajority($majority = true, $conn = null)
	{
		if($this->resultsEntered($conn))
		{
			$c = new Criteria();
			$c->addJoin(TeamResultPeer::DEBATE_TEAM_XREF_ID, DebateTeamXrefPeer::ID);
			$c->add(DebateTeamXrefPeer::DEBATE_ID, $this->getId());	
			$c->add(TeamResultPeer::MAJORITY_TEAM_SCORE, 1);
			$c->addJoin(TeamScoreSheetPeer::DEBATE_TEAM_XREF_ID, TeamResultPeer::DEBATE_TEAM_XREF_ID);
			$c->addJoin(TeamScoreSheetPeer::ADJUDICATOR_ALLOCATION_ID, AdjudicatorAllocationPeer::ID);
			if ($majority)
			{
				$c->add(TeamScoreSheetPeer::SCORE, 1);
			}
			else
			{
				$c->add(TeamScoreSheetPeer::SCORE, 0);	
			}

			return AdjudicatorAllocationPeer::doSelect($c, $conn);
		}
		else
		{
			return null;
		}
	}
	
	public function isSplitDecision($conn = null)
	{
		if($this->resultsEntered($conn))
		{
			$c = new Criteria();
			$c->addJoin(TeamResultPeer::DEBATE_TEAM_XREF_ID, DebateTeamXrefPeer::ID);
			$c->add(DebateTeamXrefPeer::DEBATE_ID, $this->getId());
			$c->add(TeamResultPeer::MAJORITY_TEAM_SCORE, 0);
			$c->add(TeamResultPeer::TEAM_VOTE_COUNT, 0, Criteria::GREATER_THAN);

			return TeamResultPeer::doCount($c, true, $conn) > 0 ? true : false;
		}
		else
		{
			return null;
		}
	
	}
	
    public function getChair($con = null)
    {
        $c = new Criteria();
        $c->addJoin(AdjudicatorAllocationPeer::DEBATE_ID, DebatePeer::ID);
        $c->addJoin(AdjudicatorAllocationPeer::ADJUDICATOR_ID, AdjudicatorPeer::ID);
        $c->add(DebatePeer::ID, $this->getId());
        $c->add(AdjudicatorAllocationPeer::TYPE, AdjudicatorAllocation::ADJUDICATOR_TYPE_CHAIR);
        $adjudicators = AdjudicatorPeer::doSelect($c, $con);

        if (count($adjudicators) > 1) {
            throw new Exception("More than one adjudicator in chair position for debate with id " . $this->getId());
        } else if (count($adjudicators) < 1) {
            return null;
        } else {
            return $adjudicators[0];
        }
    }
}
