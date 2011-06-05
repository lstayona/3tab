<?php

/**
 * Subclass for performing query and update operations on the 'adjudicator_allocations' table.
 *
 * 
 *
 * @package lib.model
 */ 
class AdjudicatorAllocationPeer extends BaseAdjudicatorAllocationPeer
{
	
	public static function createAdjudicatorAllocation($debateId, $adjudicatorId, $type)
	{
		$allocation = new AdjudicatorAllocation();
		$allocation->setDebateId($debateId);
		$allocation->setAdjudicatorId($adjudicatorId);
		$allocation->setType($type);
		
		return $allocation;
	}

}
