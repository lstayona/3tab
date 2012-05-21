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
        
        public static function getChairsWithTrainees($round, $con = null)
        {
            $chairAllocations = self::getChairAllocations($round, $con);
            $chairsWithTrainees = array();
            foreach($chairAllocations as $chair)
            {
                if(count($chair->getTraineeAllocations()) > 0)
                {
                    $chairsWithTrainees[] = $chair;
                }
            }
            return $chairsWithTrainees;
        }
        
        public static function getChairAllocationsWithTraineesWithoutFeedback($round, $con = null)
        {
            $chairAllocations = self::getChairAllocations($round, $con);
            $chairAllocationsWithTraineesWithoutFeedback = array();
            foreach($chairAllocations as $chairAllocation)
            {
                if(count($chairAllocation->getTraineeAllocationsWithoutFeedback()) > 0)
                {
                    $chairAllocationsWithTraineesWithoutFeedback[] = $chairAllocation;
                }              
            }
            return $chairAllocationsWithTraineesWithoutFeedback;
        }
        
        public static function getChairAllocations($round, $con = null)
        {
             if($con==null)
		{
			$con = Propel::getConnection();
		}		
		$stmt = $con->createStatement();
		$query = "select adjudicator_allocations.* from adjudicator_allocations, debates, adjudicators where debates.round_id = %d
                          and adjudicator_allocations.debate_id = debates.id 
                          and adjudicator_allocations.adjudicator_id = adjudicators.id
                          and type = %d order by adjudicators.name asc";
		$query = sprintf($query,  $round->getId(), AdjudicatorAllocation::ADJUDICATOR_TYPE_CHAIR);
		$rs = $stmt->executeQuery($query, ResultSet::FETCHMODE_NUM);
		$chairAllocations = AdjudicatorAllocationPeer::populateObjects($rs);
                              
                return $chairAllocations;
        }        

}
