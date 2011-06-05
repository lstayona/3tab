<?php
class Panel
{
	protected $members;
	protected $energy;
	protected $identifier;
	
	public function setMembers($a1, $a2, $a3)
	{
		$this->members[] = $a1;
		$this->members[] = $a2;
		$this->members[] = $a3;
		$this->energy = $this->measureEnergy();
		$this->identifier = rand(1,1000000);
	}
	
	public function getId()
	{
		return $this->identifier;
	}
	
	public function isPanel()
	{
		if($this->members[1] != null && $this->members[2] != null)
		{
			return true;
		}
		return false;
	}
	
	public function getMembers()
	{
		return $this->members;
	}
	
	public function getMember($position)
	{
		return $this->members[$position];
	}	
	
	public function setMember($position, $AdjId)
	{
		$this->members[$position] = $AdjId;
	}	
	
	public function getEnergy()
	{
		return $this->energy;
	}
		
	protected function measureEnergy()
	{
		$round = RoundPeer::getCurrentRound();
		if($this->members[0] != null && $this->members[1] != null && $this->members[2] != null)
		{
			$s1 = AdjudicatorPeer::retrieveByPk($this->members[0])->getScore($round);
			$s2 = AdjudicatorPeer::retrieveByPk($this->members[1])->getScore($round);
			$s3 = AdjudicatorPeer::retrieveByPk($this->members[2])->getScore($round);
			return ($s1+$s2+$s3)/3;
		}
		else if($this->members[0] != null && $this->members[1] == null && $this->members[2] == null)
		{
			return AdjudicatorPeer::retrieveByPk($this->members[0])->getScore($round);
		}
		else if($this->members[0] == null && $this->members[1] == null && $this->members[2] == null)
		{
			return 0;
		}
	}
	
	


	public static function comparePanel($a, $b)
	{
		if($a->energy == $b->energy)
		{
			return 0;
		}
		return ($a->energy < $b->energy) ? +1 : -1;
	}

}
?>