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
	public static function getAdjudicatorsByTestScore()
	{
		$con = Propel::getConnection();
		$sql = "SELECT * FROM adjudicators WHERE active = true ORDER BY test_score DESC";  
    	$stmt = $con->createStatement();
		$rs = $stmt->executeQuery($sql, ResultSet::FETCHMODE_NUM);
		$adjudicators =  AdjudicatorPeer::populateObjects($rs); 
		
		return $adjudicators;
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
            throw new Exception("More that one adjudicator returned for '" . $name . "'");
        }
        else
        {
            return $results[0];
        }
    }
}
