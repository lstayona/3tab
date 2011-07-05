<?php

/**
 * Subclass for representing a row from the 'debates_teams_xrefs' table.
 *
 * 
 *
 * @package lib.model
 */ 
class DebateTeamXref extends BaseDebateTeamXref
{
	const AFFIRMATIVE = 1;
	const NEGATIVE = 2;
	
	public function swapTeams($xref, $conn = null)
	{	
        $tempTeam = $this->getTeam($conn);
        $this->setTeam($xref->getTeam($conn));
        $xref->setTeam($tempTeam);
	}
	
    public function getSpeakerScoreForPosition($speakerPosition, $conn = null)
    {
        //only get the sheets in the majority
        $c = new Criteria();
        $c->add(TeamScoreSheetPeer::DEBATE_TEAM_XREF_ID, $this->getId());
        $c->add(TeamScoreSheetPeer::SCORE, $this->getTeam()->getTeamScore($this->getDebate()));
        $teamScoreSheets = TeamScoreSheetPeer::doSelect($c);
        
        $speakerScore = 0;
        foreach($teamScoreSheets as $teamScoreSheet)
        {
                //total up all the score in the speaker for sheets for each team score sheet
                $c = new Criteria();
                $c->add(SpeakerScoreSheetPeer::ADJUDICATOR_ALLOCATION_ID, $teamScoreSheet->getAdjudicatorAllocation()->getId());
                $c->add(SpeakerScoreSheetPeer::DEBATE_TEAM_XREF_ID, $this->getId());
                $c->add(SpeakerScoreSheetPeer::SPEAKING_POSITION, $speakerPosition);
                foreach(SpeakerScoreSheetPeer::doSelect($c) as $speakerScoreSheet)
                {
                    $speakerScore += $speakerScoreSheet->getScore();            
                }               
        }
		
		if(count($teamScoreSheets) == 0)
		{
			return 0;
		}
		else
		{
			return $speakerScore / count($teamScoreSheets);
		}
    }
	
	public function getSpeakerScoreSheet($speakerPosition, $adjudicatorAllocation, $con = null)
	{
		if(is_null($con))
        {
            $con = Propel::getConnection();
        }
        
    	$stmt = $con->createStatement();
		$query = "SELECT speaker_score_sheets.* from speaker_score_sheets WHERE ".
		"debate_team_xref_id = %d AND adjudicator_allocation_id = %d and speaking_position = %d";
		$query = sprintf($query, $this->getId(), $adjudicatorAllocation->getId(), $speakerPosition);
		$rs = $stmt->executeQuery($query, ResultSet::FETCHMODE_NUM);
        
		$sheets = SpeakerScoreSheetPeer::populateObjects($rs);
		return $sheets[0];
	}
    
    public function getSpeaker($speakerPosition, $conn = null)
    {
        $speakersInPosition = $this->getSpeakersInPosition($conn);
        if(isset($speakersInPosition[$speakerPosition]))
        {
            return $speakersInPosition[$speakerPosition];
        }
        
        return null;
    }
    
    public function getSpeakersInPosition($conn = null)
    {
        $speakersInPosition = array();
        foreach(SpeakerScoreSheet::getSpeakerPositions() as $speakerPosition => $description)
        {
            $c = new Criteria();
            $c->add(SpeakerScoreSheetPeer::SPEAKING_POSITION, $speakerPosition);
            foreach($this->getSpeakerScoreSheets($c, $conn) as $speakerScoreSheet)
            {
                if(!isset($speakersInPosition[$speakerPosition]))
                {
                    $speakersInPosition[$speakerPosition] = $speakerScoreSheet->getDebater($conn);
                }
                else
                {
                    if($speakersInPosition[$speakerPosition]->getId() != $speakerScoreSheet->getDebaterId())
                    {
                        throw new Exception("Conflict between more than one debater for position " . $description . " Original: " . $speakers[$speakerPosition]->getName() . " Conflicting: " . $speakerScoreSheet->getDebater()->getName());
                    }
                }
            }
        }
        
        return $speakersInPosition;
    }
	
	public function getSpeakerScore($debater)
	{
			//only get the sheets in the majority
			$c = new Criteria();
			$c->add(TeamScoreSheetPeer::DEBATE_TEAM_XREF_ID, $this->getId());
			$c->add(TeamScoreSheetPeer::SCORE, $this->getTeam()->getTeamScore($this->getDebate()));
			$teamScoreSheets = TeamScoreSheetPeer::doSelect($c);
			$speakerScore = 0;
			foreach($teamScoreSheets as $teamScoreSheet)
			{
					//total up all the score in the speaker for sheets for each team score sheet
					$c = new Criteria();
					$c->add(SpeakerScoreSheetPeer::ADJUDICATOR_ALLOCATION_ID, $teamScoreSheet->getAdjudicatorAllocation()->getId());
					$c->add(SpeakerScoreSheetPeer::DEBATE_TEAM_XREF_ID, $this->getId());
					$c->add(SpeakerScoreSheetPeer::DEBATER_ID, $debater->getId());
					foreach(SpeakerScoreSheetPeer::doSelect($c) as $speakerScoreSheet)
					{
							if($speakerScoreSheet->getSpeakingPosition() != 4) 
							{
									$speakerScore += $speakerScoreSheet->getScore();
							}               
					}               
			}
			return $speakerScore / count($teamScoreSheets);
	}
	
	public function getTeamScoreSheetsInMajority($conn = null)
	{
		$c = new Criteria();
		$c->add(TeamScoreSheetPeer::DEBATE_TEAM_XREF_ID, $this->getId());
		$c->add(TeamScoreSheetPeer::SCORE, $this->getTeam()->getTeamScore($this->getDebate()));
		$teamScoreSheets = TeamScoreSheetPeer::doSelect($c, $conn);
		
		return $teamScoreSheets;
	}	
	
	public function isWinner($conn = null)
	{
		return $this->getTeam()->getTeamScore($this->getDebate()) == 1 ? true : false;
	}

	public function getSpeakerScores($conn = null)
	{
			//only get the sheets in the majority
			$c = new Criteria();
			$c->add(TeamScoreSheetPeer::DEBATE_TEAM_XREF_ID, $this->getId());
			$c->add(TeamScoreSheetPeer::SCORE, $this->getTeam()->getTeamScore($this->getDebate()));
			$teamScoreSheets = TeamScoreSheetPeer::doSelect($c, $conn);
			//this is in the case that a new round was allocated and scores have not been entered yet
			if(count($teamScoreSheets) == 0)
			{
					return 0;
			}
			$totalSpeakerScore = 0;
			foreach($teamScoreSheets as $teamScoreSheet)
			{
					//total up all the score in the speaker for sheets for each team score sheet
					$c = new Criteria();
					$c->add(SpeakerScoreSheetPeer::ADJUDICATOR_ALLOCATION_ID, $teamScoreSheet->getAdjudicatorAllocation()->getId());
					$c->add(SpeakerScoreSheetPeer::DEBATE_TEAM_XREF_ID, $this->getId());
					foreach(SpeakerScoreSheetPeer::doSelect($c, $conn) as $speakerScoreSheet)
					{
							$totalSpeakerScore += $speakerScoreSheet->getScore();
					}               
			}
			return $totalSpeakerScore / count($teamScoreSheets);
	}
	
	public function getMargin($conn = null)
	{
			$xref = $this->getDebate($conn)->getDebateTeamXrefs();
			if($xref[0]->getId() == $this->getId())
			{
					return $this->getSpeakerScores($conn) - $xref[1]->getSpeakerScores($conn);
			}
			else
			{
					return $this->getSpeakerScores($conn) - $xref[0]->getSpeakerScores($conn);
			}
	}

    public function getTeamResult($con = null)
    {
        $debateResults = $this->getTeamResultsRelatedByDebateTeamXrefId(null, $con);

        if (count($debateResults) > 1) {
            throw new Exception("Cannot have more than one TeamResult for a DebateTeamXref object");
        } else if (count($debateResults) < 1) {
            return null;
        } else {
            return $debateResults[0];
        }
    }
    
    public function getTeamMargin($con = null)
    {
        $teamMargins = $this->getTeamMargins(null, $con);

        if (count($teamMargins) > 1) {
            throw new Exception("Cannot have more than one TeamMargin for a DebateTeamXref object");
        } else if (count($teamMargins) < 1) {
            return null;
        } else {
            return $teamMargins[0];
        }
    }
}
