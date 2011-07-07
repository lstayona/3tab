<?php

/**
 * Subclass for performing query and update operations on the 'adjudicators' table.
 *
 * 
 *
 * @package lib.model
 */ 
class AdjudicatorPeer extends BaseAdjudicatorPeer
{	
	public static function getAdjudicatorsByTestScore($con = null)
	{
	    $c = new Criteria();
        $c->add(AdjudicatorPeer::ACTIVE, true);
        $c->addDescendingOrderByColumn(AdjudicatorPeer::TEST_SCORE);

		return AdjudicatorPeer::doSelect($c, $con);
	}
    
    public static function createFromCSVLine($line, $lineNumber, $allLines, $update = true, $conn = null)
    {
        $exists = true;
        $adjudicator = AdjudicatorPeer::retrieveByName($line['name'], $conn);
        if(!is_null($adjudicator) and !$update)
        {
            return array($exists, $adjudicator);
        }
        
        if(is_null($adjudicator))
        {
            $adjudicator = new Adjudicator();
            $exists = false;
        }
        
        $adjudicator->setName($line['name']);
        $adjudicator->setTestScore($line['test_score']);
        $adjudicator->setActive($line['active']);
        $institution = InstitutionPeer::retrieveByCode($line['institution-code'], $conn);
        if(!is_null($institution))
        {
            $adjudicator->setInstitution($institution);
        }
        else
        {
            throw new Exception("The institution with the code '" . $line['institution-code'] . "' does not exist.");
        }
        
        return array($exists, $adjudicator);
    }
    
    public static function retrieveByName($name, $conn = null)
    {
        $c = new Criteria();
        $c->add(AdjudicatorPeer::NAME, $name);
        
        $results = AdjudicatorPeer::doSelect($c, $conn);
        
        if(count($results) < 1)
        {
            return null;
        }
        else if(count($results) > 1)
        {
            throw new Exception("More than one adjudicator returned for '" . $name . "'");
        }
        else
        {
            return $results[0];
        }
    }

    public static function getUnallocatedAdjudicators($round, $con = null)
    {   
        if (!($con instanceof Connection)) {
            $con = Propel::getConnection();
        }
        $sql = "SELECT adjudicators.* FROM adjudicators " .
        "WHERE adjudicators.active = true AND adjudicators.id NOT IN ( " .
        "  SELECT adjudicators.id " . 
        "  FROM adjudicators " . 
        "  JOIN adjudicator_allocations ON adjudicator_allocations.adjudicator_id = adjudicators.id " .
        "  JOIN debates ON debates.id = adjudicator_allocations.debate_id " .
        "  WHERE debates.round_id = ? AND adjudicators.active = true)";
        $stmt = $con->prepareStatement($sql);
        $stmt->setInt(1, $round->getId()); 
		$rs = $stmt->executeQuery(ResultSet::FETCHMODE_NUM);

		return AdjudicatorPeer::populateObjects($rs); 
    }

    public static function getUnallocatedTrainees($round, $con = null)
	{
        $unallocatedAdjudicators = AdjudicatorPeer::getUnallocatedAdjudicators($round, $con);
        $traineeAdjudicators = array();
		foreach($unallocatedAdjudicators as $unallocatedAdjudicator)
		{
			if($unallocatedAdjudicator->getScore($round) <= 1.5)
			{
				$traineeAdjudicators[] = $unallocatedAdjudicator;
			}
		}
        
        return $traineeAdjudicators;
    }
}
