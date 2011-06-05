<?php

class MiniTeam
{
	protected $teamId;
	protected $teamScore;
	protected $speakerScore;
	protected $margin;
	
	function setTeamId($v)
	{
		$this->teamId = $v;
	}
	
	function setTeamScore($v)
	{
		$this->teamScore = $v;
	}
	
	function setSpeakerScore($v)
	{
		$this->speakerScore = $v;
	}
	
	function setMargin($v)
	{
		$this->margin = $v;
	}	
	
	function getTeamId()
	{
		return $this->teamId;
	}	
	
	function getTeamScore()
	{
		return $this->teamScore;
	}
	
	function getSpeakerScore()
	{
		return $this->speakerScore;
	}
	
	function getMargin()
	{
		return $this->margin;
	}
	
	static function compTeam($a, $b)
	{
		if($a->getTeamScore() == $b->getTeamScore())
		{
			if($a->getSpeakerScore() == $b->getSpeakerScore())
			{
				if($a->getMargin() == $b->getMargin())
				{
					return 0;
				}
				return ($a->getMargin() < $b->getMargin()) ? +1 : -1;
			}
			return ($a->getSpeakerScore() < $b->getSpeakerScore()) ? +1 : -1;
		}
		return ($a->getTeamScore() < $b->getTeamScore()) ? +1 : -1;
	}
}

?>
