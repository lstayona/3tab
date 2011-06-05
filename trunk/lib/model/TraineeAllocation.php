<?php

/**
 * Subclass for representing a row from the 'trainee_allocations' table.
 *
 * 
 *
 * @package lib.model
 */ 
class TraineeAllocation extends BaseTraineeAllocation
{
	public function getInfo()
	{
		return $this->getAdjudicatorRelatedByTraineeId()->getName()." - ".$this->getAdjudicatorRelatedByChairId()->getName();
	}
	
	public static function getNotFeedbacked($round, $conn = null)
	{
		$allocations = TraineeAllocationPeer::doSelect(new Criteria(), $conn);
		$unFeedbacked = array();
		foreach($allocations as $anAllocation)
		{
			$chair = $anAllocation->getAdjudicatorRelatedByChairId();
			$trainee = $anAllocation->getAdjudicatorRelatedByTraineeId();
			$adjudicatorAllocation = $chair->getAdjudicatorAllocation($round, $conn);
			if(!$adjudicatorAllocation->getAdjudicatorFeedbackSheets())
			{
				$unFeedbacked[] = $anAllocation;
			}
		}
		return $unFeedbacked;
	}
}
