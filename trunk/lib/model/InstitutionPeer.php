<?php

/**
 * Subclass for performing query and update operations on the 'institutions' table.
 *
 * 
 *
 * @package lib.model
 */ 
class InstitutionPeer extends BaseInstitutionPeer
{
    public static function createFromCSVLine($line, $lineNumber, $allLines, $update = true, $conn = null)
    {
        $exists = true;
        $institution = InstitutionPeer::retrieveByCode($line['code'], $conn);
        if(!is_null($institution) and !$update)
        {
            return array($exists, $institution);
        }
        
        if(is_null($institution))
        {
            $institution = new Institution();
            $exists = false;
        }
        
        $institution->setName($line['name']);
        $institution->setCode($line['code']);
        
        return array($exists, $institution);
    }
    
    public static function retrieveByCode($code, $conn = null)
    {
        $c = new Criteria();
        $c->add(InstitutionPeer::CODE, $code);
        
        $results = InstitutionPeer::doSelect($c, $conn);
        
        if(count($results) < 1)
        {
            return null;
        }
        else if(count($results) > 1)
        {
            throw new Exception("More that one institution returned for '" . $code . "'");
        }
        else
        {
            return $results[0];
        }
    }
}
