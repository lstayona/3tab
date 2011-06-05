<?php

/**
 * Subclass for representing a row from the 'adjudicator_allocations' table.
 *
 * 
 *
 * @package lib.model
 */ 
class AdjudicatorAllocation extends BaseAdjudicatorAllocation
{
	const ADJUDICATOR_TYPE_CHAIR = 1;
	const ADJUDICATOR_TYPE_PANELIST = 2;
	const ADJUDICATOR_TYPE_TRAINEE = 3;
	
	public function getAdjudicatorName($conn = null){
		return $this->getAdjudicator()->getName();
	}
	
	public static function checkConflicts($debate, $adjudicator, $con = null)
	{
		$conflict = false;
		$xrefs = $debate->getDebateTeamXrefs($con);
		$gov = TeamPeer::retrieveByPk($xrefs[0]->getTeamId(), $con);
		$opp = TeamPeer::retrieveByPk($xrefs[1]->getTeamId(), $con);
		if($gov->getInstitutionId() == $adjudicator->getInstitutionId() ||
		   $opp->getInstitutionId() == $adjudicator->getInstitutionId())
		{
			$conflict = true;
		}
		
		return $conflict;		
	}
    
    public function getTeamScoreSheet($position, $conn = null)
    {
        $c = new Criteria();
        $c->add(DebateTeamXrefPeer::POSITION, $position);
        $teamScoreSheets = $this->getTeamScoreSheetsJoinDebateTeamXref($c, $conn);
        
        return $teamScoreSheets[0];
    }
    
    public function getTeamByScore($score, $conn = null)
    {
        $c = new Criteria();
        $c->add(TeamScoreSheetPeer::SCORE, $score);
        $teamScoreSheets = $this->getTeamScoreSheetsJoinDebateTeamXref($c, $conn);
        
        return $teamScoreSheets[0]->getDebateTeamXref($conn)->getTeam($conn);
    }
    
    public function isComplete($conn = null)
    {
        return (
          $this->countTeamScoreSheets(null, false, $conn) == 
          $this->getDebate($conn)->countDebateTeamXrefs(null, false, $conn)
        );
    }
    
    public function hasSpeakerScoreSheetForDebateAndSpeakerPosition($speakingPosition, $debateTeamXref, $conn = null)
    {
        $c = new Criteria();
        $c->add(SpeakerScoreSheetPeer::SPEAKING_POSITION, $speakingPosition);
        $c->add(SpeakerScoreSheetPeer::DEBATE_TEAM_XREF_ID, $debateTeamXref->getId());
        
        if($this->countSpeakerScoreSheets($c, $conn) > 1)
        {
            throw new Exception("More than 1 speaker in the position '".$speakingPosition."' for debate with id '".$debateTeamXref->getDebateId()."'");
        }
        else if($this->countSpeakerScoreSheets($c, $conn) < 1)
        {
            return false;
        }
        else
        {
            return true;
        }
    }
    
    public function getSpeakerScoreSheetByDebateAndSpeakerPosition($speakingPosition, $debateTeamXref, $conn = null)
    {
        $c = new Criteria();
        $c->add(SpeakerScoreSheetPeer::SPEAKING_POSITION, $speakingPosition);
        $c->add(SpeakerScoreSheetPeer::DEBATE_TEAM_XREF_ID, $debateTeamXref->getId());
        $speakerScoreSheets = $this->getSpeakerScoreSheets($c, $conn);
        
        if(count($speakerScoreSheets) > 1)
        {
            throw new Exception("More than 1 speaker in the position '".$speakingPosition."' for debate with id '".$debateTeamXref->getDebateId()."'");
        }
        else if(count($speakerScoreSheets) < 1)
        {
            return null;
        }
        else
        {
            return $speakerScoreSheets[0];
        }
    }	
		
	public static function getUnallocatedTrainees($round, $con=null)
	{
		$c = new Criteria();
		$c->add(AdjudicatorPeer::ACTIVE, true);
		$adjudicators = AdjudicatorPeer::doSelect($c);
		$traineeAdjudicators = array();
		foreach($adjudicators as $anAdjudicator)
		{
			if($anAdjudicator->getScore($round) < 1.5)
			{
				$traineeAdjudicators[] = $anAdjudicator;
			}
		}
		$unallocatedTrainees = array();
		$allocatedAdjudicators = AdjudicatorFeedbackSheet::getAdjudicatorsToReceiveFeedback($round, $con);
		foreach($traineeAdjudicators as $aTrainee)
		{
			if(!in_array($aTrainee, $allocatedAdjudicators))
			{
				$unallocatedTrainees[] = $aTrainee;
			}
		}
		return $unallocatedTrainees;
	}
	
	public static function getChairs($round, $con=null)
	{
		$debates = $round->getDebates();
		$chairs = array();
		foreach($debates as $debate)
		{
			$c = new Criteria();
			$c->add(AdjudicatorAllocationPeer::TYPE, 1);
			$allocations = $debate->getAdjudicatorAllocations($c, $con);
			$chairs[] = $allocations[0]->getAdjudicator();
		}
		return $chairs;
	
	}	
    
    public function getTeamTotalSpeakerScore($debateTeamXref, $conn = null)
    {
        $c = new Criteria();
        $c->add(SpeakerScoreSheetPeer::DEBATE_TEAM_XREF_ID, $debateTeamXref->getId());
        
        $totalSpeakerScore = 0;
        foreach($this->getSpeakerScoreSheets($c, $conn) as $speakerScoreSheet)
        {
            $totalSpeakerScore += $speakerScoreSheet->getScore();
        }
        
        return $totalSpeakerScore;
    }
}
