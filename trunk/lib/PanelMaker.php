<?php
class PanelMaker
{
	//constants to denote the adjudicator rank
	const RANK_A = 0;
	const RANK_B = 1;
	const RANK_C = 2;
	const RANK_D = 3;
	const RANK_E = 4;
	
	protected $adjudicators;
	protected $ranks;
	protected $bubble;
	protected $panels;
	
	 public function getRankText($status = null)
    {
        if(is_null($status))
        {
            $status = $this->getStatus();
        }
        
        $textStatus = array(
            PanelMaker::RANK_A => "Rank A",
            PanelMaker::RANK_B => "Rank B",
			PanelMaker::RANK_C => "Rank C",
			PanelMaker::RANK_D => "Rank D",
			PanelMaker::RANK_E => "Rank E",
        );
        
        return $textStatus[$status];
    }
	
	public function formPanels($adjudicators, $numPanels, $bubble=false)
	{
		$bubble = false; //disabling the bubble round panel making
		$this->adjudicators = $adjudicators;
		$this->bubble = $bubble;
		$this->ranks = $this->rateAdjudicators();
		$this->removeTrainees();
		$this->panels = $this->extractSingleChairs();
		$panelsLeft = $numPanels - count($this->panels);
		if($panelsLeft < 0)
		{
			$panelsLeft = 0;
		}
		$blankPanels = 0;
		while($panelsLeft*3 > count($this->adjudicators)-$this->countAdjudicators(self::RANK_E))
		{
			$panelsLeft--;
			$blankPanels++;
			//throw new Exception('Do not have enough adjudicate to allocate into panels. Consider promoting more people to B');
		}
		$numB = $this->countAdjudicators(self::RANK_B);
		$numC = $this->countAdjudicators(self::RANK_C);
		$numD = $this->countAdjudicators(self::RANK_D);
		if($panelsLeft != 0)
		{
			$this->buildPanels($numB, $numC, $numD, $panelsLeft);
		}
		$this->buildEmptyPanels($blankPanels);
	}
	
		
	public function getPanelsByScore()
	{
		usort($this->panels, array("Panel", "comparePanel"));
		return $this->panels;
	}
	
	protected function rateAdjudicators()
	{
		$ratings = array();		
		foreach($this->adjudicators as $adjudicator)
		{
			$score = AdjudicatorPeer::retrieveByPk($adjudicator)->getScore(RoundPeer::getCurrentRound());
			if($score >= 4.5 && $score <= 5)
			{
				$ratings[] = self::RANK_A;
			}
			else if($score >=3.5 && $score < 4.5)
			{
				$ratings[] = self::RANK_B;
			}
			else if($score >= 2.5 && $score < 3.5)
			{
				$ratings[] = self::RANK_C;
			}
			else if($score >= 1.5 && $score < 2.5)
			{
				$ratings[] = self::RANK_D;
			}
			else if($score >= 1 && $score < 1.5)
			{
				$ratings[] = self::RANK_E;
			}
			else
			{
				throw new Exception('An adjudicator has an invalid score');			
			}			
		}	
		return $ratings;
	}
	
	protected function extractSingleChairs()
	{
		$newAdjList = array();
		$newRankList = array();
		$singleChair = array();
		for($i=0; $i<count($this->adjudicators); $i++)
		{
			if($this->bubble)
			{
				if($this->ranks[$i] == self::RANK_A)
				{
					$panel = new Panel();
					$panel->setMembers($this->adjudicators[$i], null, null);
					$singleChair[] = $panel;
				}
				else
				{
					$newAdjList[] = $this->adjudicators[$i];
					$newRankList[] = $this->ranks[$i];
				}
			}
			else
			{
				if($this->ranks[$i] == self::RANK_A || $this->ranks[$i] == self::RANK_B)
				{
					$panel = new Panel();
					$panel->setMembers($this->adjudicators[$i], null, null);
					$singleChair[] = $panel;
				}
				else
				{
					$newAdjList[] = $this->adjudicators[$i];
					$newRankList[] = $this->ranks[$i];
				}
			}
		}
		$this->adjudicators = $newAdjList;
		$this->ranks = $newRankList;
		return $singleChair;
	}	
	
	protected function countAdjudicators($rank)
	{
		$counter = 0;
		for($i=0; $i<count($this->adjudicators); $i++)
		{
			if($this->ranks[$i] == $rank)
			{
				$counter++;
			}
		}
		return $counter;
	}
	
	protected function buildPanels($numB, $numC, $numD, $panelsLeft)
	{
		if(!$this->bubble)
		{
			if($numC/2 < $panelsLeft)
			{	
				$this->buildPanels2(self::RANK_C, self::RANK_C, self::RANK_C, $numC%2);
				$this->buildPanels2(self::RANK_C, self::RANK_C, self::RANK_D, floor($numC/2)-$numC%2);
				$this->buildPanels2(self::RANK_D, self::RANK_D, self::RANK_D, $panelsLeft - floor($numC/2));
			}
			else
			{
				if($numC - $panelsLeft * 2 > $panelsLeft)
				{
					$this->buildPanels2(self::RANK_C, self::RANK_C, self::RANK_C, $panelsLeft);
				}
				else
				{
					$this->buildPanels2(self::RANK_C, self::RANK_C, self::RANK_C, $numC - $panelsLeft * 2);
					$this->buildPanels2(self::RANK_C, self::RANK_C, self::RANK_D, $panelsLeft * 3 - $numC);	
				}
			}
		}
		else
		{
			if($numB/2 < $panelsLeft)
			{
				$this->buildPanels2(self::RANK_B, self::RANK_B, self::RANK_B, $numB%2);
				if($numC >= floor($numB/2)-$numB%2)
				{
					$this->buildPanels2(self::RANK_B, self::RANK_B, self::RANK_C, floor($numB/2)-$numB%2);
					$numC = $numC - (floor($numB/2) - $numB%2);
				}
				else
				{
					throw new Exception('Do not have enough Cs to form B-B-C panels, promote more Cs');
				}
			}
			else
			{
				$this->buildPanels2(self::RANK_B, self::RANK_B, self::RANK_B, $numB - $panelsLeft * 2);
				if($numC >= $panelsLeft * 3 - $numB)
				{
					$this->buildPanels2(self::RANK_B, self::RANK_B, self::RANK_C, $panelsLeft * 3 - $numB);
					$numC = $numC - ($panelsLeft * 3 - $numB);
				}
				else
				{
					throw new Exception('Do not have enough Cs to form B-B-C panels, promote more Cs');
				}
			}
			if($numC/2 < $panelsLeft)
			{			
				$this->buildPanels2(self::RANK_C, self::RANK_C, self::RANK_C, $numC%2);
				$this->buildPanels2(self::RANK_C, self::RANK_C, self::RANK_D, floor($numC/2)-$numC%2);
				$this->buildPanels2(self::RANK_D, self::RANK_D, self::RANK_D, $panelsLeft - floor($numC/2));
			}
			else
			{
				$this->buildPanels2(self::RANK_C, self::RANK_C, self::RANK_C, $numC - $panelsLeft * 2);
				$this->buildPanels2(self::RANK_C, self::RANK_C, self::RANK_D, $panelsLeft * 3 - $numC);	
			}		
		}
	}
	
	protected function buildPanels2($rank1, $rank2, $rank3, $numPanels)
	{
		$panelArray = array();
		$chairs = $this->getAllAdjudicators($rank1);
		for($i=0; $i<$numPanels; $i++)
		{			
			$panelArray[$i][] = $chairs[$i];		
			$this->removeAdjudicator($chairs[$i]);
			//remove allocated adj from the list
		}
		$panel1 = $this->getAllAdjudicators($rank2);
		for($i=0; $i<$numPanels; $i++)
		{			
			$panelArray[$i][] = $panel1[$i];
			$this->removeAdjudicator($panel1[$i]);
			//remove allocated adj from the list
		}
		
		$panel2 = $this->getAllAdjudicators($rank3);
		for($i=0; $i<$numPanels; $i++)
		{			
			$panelArray[$i][] = $panel2[$i];	
			$this->removeAdjudicator($panel2[$i]);			
			//remove allocated adj from the list
		}		
		foreach($panelArray as $p)
		{
			$panel = new Panel();
			$panel->setMembers($p[0], $p[1], $p[2]);
			$this->panels[] = $panel;
		}
	}
	
	public function buildEmptyPanels($count)
	{
		for($i = 0; $i < $count; $i++)
		{
			$panel = new Panel();
			$panel->setMembers(null,null,null);
			$this->panels[] = $panel;
		}
	}
	
	protected function removeAdjudicator($adj)
	{
		$pos = array_search($adj, $this->adjudicators);
		$adjudicators = array();
		foreach($this->adjudicators as $number => $adj)
		{
			if($number != $pos)
			{				
				$adjudicators[] = $adj;
			}
		}	
		$ranks = array();
		foreach($this->ranks as $number => $rank)
		{
			if($number != $pos)
			{				
				$ranks[] = $rank;
			}
		}
		$this->adjudicators = $adjudicators;
		$this->ranks = $ranks;
	}
	
	protected function getAllAdjudicators($rank)
	{
		$adjudicators = array();
		for($i=0; $i < count($this->adjudicators); $i++)
		{
			if($this->ranks[$i] == $rank)
			{
				$adjudicators[] = $this->adjudicators[$i];
			}
		}	
		return $adjudicators;
	}
	
	protected function removeTrainees()
	{
		$newAdjList = array();
		$newRankings = array();
		for($i = 0; $i < count($this->adjudicators); $i++)
		{
			if($this->ranks[$i] != self::RANK_E)
			{	
				$newAdjList[] = $this->adjudicators[$i];
				$newRankings[] = $this->ranks[$i];
			}
		}
		$this->ranks = $newRankings;
		$this->adjudicators = $newAdjList;
	}
	
	}

?>