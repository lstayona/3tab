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
		$allocations = $this->getAdjudicatorAllocations($conn);
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
		if(is_null($con))
        {
            $con = Propel::getConnection();
        }
		$stmt = $con->createStatement();
		$query = "SELECT  team_scores.* FROM team_scores, ".
						"teams WHERE teams.id = team_scores.team_id AND (team_scores.team_id = %d OR ".
						"team_scores.team_id = %d) ORDER BY team_scores.total_team_score DESC, ".
						"team_scores.total_speaker_score DESC, team_scores.total_margin DESC";
		//echo $this->getTeam(1, $con)->getName()."-".$this->getTeam(2, $con)->getName().'<br>';
		//echo $this->getTeam(1, $con)->getId()."-".$this->getTeam(2, $con)->getId().'<br>';
		$query = sprintf($query, $this->getTeam(1, $con)->getId(), $this->getTeam(2, $con)->getId());
		$rs = $stmt->executeQuery($query, ResultSet::FETCHMODE_NUM);
		$teamScores = TeamScorePeer::populateObjects($rs);
		$teamGovScore = $teamScores[0]->getTotalTeamScore($con);
		$teamOppScore = $teamScores[1]->getTotalTeamScore($con);
		//$teamGovScore = $this->getTeam(1, $conn)->getTotalTeamScore($conn);
		//$teamOppScore = $this->getTeam(2, $conn)->getTotalTeamScore($conn);
		
		return ($teamGovScore > $teamOppScore) ? $teamGovScore : $teamOppScore;		
	}
	
	public function getEnergy($bubble=false, $conn=null)
	{
		$debate = new MiniDebate();
		$debate->setDebateId($this->getId(), $bubble);
		return $debate->getEnergy();
	}
    
    public function resultsEntered($conn = null)
    {
        foreach($this->getAdjudicatorAllocations(new Criteria(), $conn) as $adjudicatorAllocation)
        {
            if($adjudicatorAllocation->countTeamScoreSheets(new Criteria(), $conn) < 2)
            {
                return false;
            }
            else if($adjudicatorAllocation->countTeamScoreSheets(new Criteria(), $conn) > 2)
            {
                throw new Exception("More than 2 team score sheets.");
            }
            
            if($adjudicatorAllocation->countSpeakerScoreSheets(new Criteria(), $conn) < 8)
            {
                return false;
            }
            else if($adjudicatorAllocation->countSpeakerScoreSheets(new Criteria(), $conn) > 8)
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
			$affXref = $this->getDebateTeamXref(1, $conn);
			$negXref = $this->getDebateTeamXref(2, $conn);
			if($affXref->isWinner($conn))
			{
				$winnerXref = $affXref;
				$loserXref = $negXref;
			}
			else if($negXref->isWinner($conn))
			{
				$winnerXref = $negXref;
				$loserXref = $affXref;
			}	
			return $winner ? $winnerXref : $loserXref;
		}
		else
		{
			return "No Results Yet";
			//throw new Exception("The results have not been entered yet");
		}
    }
	//gets the majority adjudicator allocations as default, if want to get minority, pass in false as the first argument	
	public function getAdjudicatorAllocationsInMajority($majority = true, $conn = null)
	{
		if($this->resultsEntered($conn))
		{
			$affXref = $this->getDebateTeamXref(1, $conn);
			$majorityScoreSheets = $affXref->getTeamScoreSheetsInMajority($conn);
			$majorityAllocations = array();
			$majId = array();
			foreach($majorityScoreSheets as $aScoreSheet)
			{
				$majorityAllocations[] = $aScoreSheet->getAdjudicatorAllocation($conn);
				$majId[] = $aScoreSheet->getId();
			}
			
			if($majority)
			{				
				return $majorityAllocations;
			}
			else
			{
				$minorityAllocations = array();
				$allScoreSheets = $affXref->getTeamScoreSheets($conn);
				foreach($allScoreSheets as $aScoreSheet)
				{
					if(!in_array($aScoreSheet->getId(), $majId))
					{
						$minorityAllocations[] = $aScoreSheet->getAdjudicatorAllocation($conn);
					}				
				}
				return $minorityAllocations;
			}			
		}
		else
		{
			return "No Results Yet";
			//throw new Exception("The results have not been entered yet");
		}
	}
	
	public function isSplitDecision($conn = null)
	{
		if($this->resultsEntered($conn))
		{
			if(count($this->getAdjudicatorAllocations()) >
			   count($this->getAdjudicatorAllocationsInMajority()))
			{
				return true;
			}
			return false;
		}
		else
		{
			return "No Results Yet";
			//throw new Exception("The results have not been entered yet");
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
