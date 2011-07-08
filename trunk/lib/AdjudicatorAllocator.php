<?php

class AdjudicatorAllocator{
	
	//variables that hold the debates and adjudicators
	protected $debates;
	protected $panels;
	protected $bubble;
	
	//the array that will contain the population
	protected $population;
	
	public function setup($debates, $adjudicators, $random = false, $bubble=false, $con = null)
	{	
		$debateIds = array();
		foreach($debates as $aDebate)
		{
			$debateIds[] = $aDebate->getId($con);
		}
		$adjudicatorIds = array();
		foreach($adjudicators as $anAdjudicator)
		{
			$adjudicatorIds[] = $anAdjudicator->getId($con);
		}
		foreach($debateIds as $id)
		{
			$debate = new MiniDebate();
			$debate->setDebateId($id,$bubble, $con);
			$this->debates[] = $debate;
		}
		if(!$random) usort($this->debates, array("MiniDebate", "compDebate"));
		$panelMaker = new PanelMaker();
		$panelMaker->formPanels($adjudicatorIds, count($this->debates), $bubble);
		
		$this->panels = $panelMaker->getPanelsByScore();
		$this->bubble = $bubble;
	}
	
	public function setDebateEnergies($debateEnergies)
	{
		foreach($this->debates as $number => $aDebate)
		{
			$aDebate->setEnergy($debateEnergies[$number]);
		}
		usort($this->debates, array("MiniDebate", "compDebate"));
	}	
	
	public function allocate($conn = null)
	{	
		if(is_null($conn))
        {
            $conn = Propel::getConnection();
        }
		//try to sort the panels so that they don't clash with the debates
		for($i = 0; $i < count($this->debates); $i++)
		{
			//if clash, try to swap the panel with the panels below
			
			$count = 0;
			while(($this->checkConflicts($this->debates[$i]->getTeamIds(), $this->panels[$i+$count]) or $this->checkSeenBefore($this->debates[$i]->getTeamIds(), $this->panels[$i+$count]))
			or ($this->checkConflicts($this->debates[$i+$count]->getTeamIds(), $this->panels[$i]) or $this->checkSeenBefore($this->debates[$i+$count]->getTeamIds(), $this->panels[$i])))
			{
				$count++;
				if(($count + $i) >= count($this->debates) || $count  > 10)
				{
					$count = 0;
					break;
				}				
			}	
			if($count != 0)	$this->swapPanels($i, $i+$count);
			
			//if still clash, try to swap the panel with the  panels above
			$count = 0;
			while(($this->checkConflicts($this->debates[$i]->getTeamIds(), $this->panels[$i-$count]) or $this->checkSeenBefore($this->debates[$i]->getTeamIds(), $this->panels[$i-$count]))
			or ($this->checkConflicts($this->debates[$i-$count]->getTeamIds(), $this->panels[$i]) or $this->checkSeenBefore($this->debates[$i-$count]->getTeamIds(), $this->panels[$i])))
			{
				$count++;
				if(($i - $count) < 0 || $count > 10)
				{
					$count = 0;
					break;
				}
			}
			if($count != 0)	$this->swapPanels($i, $i-$count);
		}
		
		$allocation = array();
		for($i=0; $i<count($this->debates); $i++)
		{
			$allocation[] = $this->createAdjudicatorAllocation($this->debates[$i]->getDebateId(), $this->panels[$i]);
		}
		return $allocation;
	}
	
	protected function checkConflicts($teamIds, $panel, $conn = null)
	{
		if(is_null($conn))
        {
            $conn = Propel::getConnection();
        }
        
        $query = 'SELECT * FROM adjudicator_conflicts WHERE (team_id=%d or team_id = %d) AND (adjudicator_id = %d or adjudicator_id = %d or adjudicator_id = %d)';

		if(!$panel->isPanel())
		{
			$query = sprintf($query, $teamIds[0], $teamIds[1], $panel->getMember(0), $panel->getMember(0), $panel->getMember(0));
		}
		else
		{
			$query = sprintf($query, $teamIds[0], $teamIds[1], $panel->getMember(0), $panel->getMember(1), $panel->getMember(2));
		}
        
		return ($conn->executeQuery($query, ResultSet::FETCHMODE_ASSOC)->getRecordCount() != 0) ? true : false; 
	}
	
    protected function checkSeenBefore($teamIds, $panel, $conn = null)
    {
        if(is_null($conn))
        {
            $conn = Propel::getConnection();
        }
        
        $query = 'SELECT * FROM adjudicator_allocations ' .
        'JOIN debates ON debates.id = adjudicator_allocations.debate_id ' .
        'JOIN debates_teams_xrefs ON debates_teams_xrefs.debate_id = debates.id ' .
        'WHERE (debates_teams_xrefs.team_id = %d OR debates_teams_xrefs.team_id = %d) AND ' .
        '(adjudicator_allocations.adjudicator_id = %d OR ' .
        'adjudicator_allocations.adjudicator_id = %d OR ' .
        'adjudicator_allocations.adjudicator_id = %d)';

        if(!$panel->isPanel())
		{
			$query = sprintf($query, $teamIds[0], $teamIds[1], $panel->getMember(0), $panel->getMember(0), $panel->getMember(0));
		}
		else
		{
			$query = sprintf($query, $teamIds[0], $teamIds[1], $panel->getMember(0), $panel->getMember(1), $panel->getMember(2));
		}
        
		return ($conn->executeQuery($query, ResultSet::FETCHMODE_ASSOC)->getRecordCount() != 0) ? true : false; 
    }

	protected function swapPanels($pos1, $pos2)
	{
		$temp = $this->panels[$pos1];
		$this->panels[$pos1] = $this->panels[$pos2];
		$this->panels[$pos2] = $temp;
	}
	
	protected function createAdjudicatorAllocation($debate, $panel)
	{
		$allocatedPanel = array();
		$a1 = $panel->getMember(0);
		$allocatedPanel[] = AdjudicatorAllocationPeer::createAdjudicatorAllocation($debate, $a1, 1);
		$a2 = $panel->getMember(1);
		if($a2 != null) $allocatedPanel[] = AdjudicatorAllocationPeer::createAdjudicatorAllocation($debate, $a2, 2);
		$a3 = $panel->getMember(2);
		if($a3 != null) $allocatedPanel[] = AdjudicatorAllocationPeer::createAdjudicatorAllocation($debate, $a3, 2);
		
		return $allocatedPanel;
	}	
}

?>
