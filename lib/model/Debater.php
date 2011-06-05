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
}
