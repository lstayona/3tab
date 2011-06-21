<?php

/**
 * Subclass for representing a row from the 'debaters' table.
 *
 * 
 *
 * @package lib.model
 */ 
class Debater extends BaseDebater
{
	public function save($con = null)
	{
		parent::save($con);
			
		if(!$this->getSpeakerScores())
		{
			$speakerScore = new SpeakerScore();
			$speakerScore->setDebater($this);
			$speakerScore->save($con);
			$this->addSpeakerScore($speakerScore);			
			parent::save($con);
		}
		
	}
	
	public function getTotalSpeakerScoreSlow($conn = null)
	{
		$xrefs = $this->getTeam($conn)->getDebateTeamXrefs();
		$totalSpeakerScore = 0;
		foreach($xrefs as $xref)
		{			
			$totalSpeakerScore += $xref->getSpeakerScore($this);
		}
		
		return $totalSpeakerScore;
	}

    public function getDebaterResult($debateTeamXrefId, $speakingPosition, $con = null)
    {
        $criteria = new Criteria();
        $criteria->add(DebaterResultPeer::DEBATE_TEAM_XREF_ID, $debateTeamXrefId);
        $criteria->add(DebaterResultPeer::SPEAKING_POSITION, $speakingPosition);
        
        $debaterResults = $this->getDebaterResults($criteria, $con);

        if (count($debaterResults) > 1) {
            throw new Exception("Cannot have more than one DebaterResult for a Debater object");
        } else if (count($debaterResults) < 1) {
            return null;
        } else {
            return $debaterResults[0];
        }
    }
}
