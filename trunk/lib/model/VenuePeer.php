<?php

/**
 * Subclass for performing query and update operations on the 'venues' table.
 *
 * 
 *
 * @package lib.model
 */ 
class VenuePeer extends BaseVenuePeer
{
    public static function getActiveVenuesOrderedByPriority($criteria = null, $conn = null)
    {
        if(is_null($criteria))
        {
            $criteria = new Criteria();
        }
        
        $criteria->add(VenuePeer::ACTIVE, true);
        $criteria->addDescendingOrderByColumn(VenuePeer::PRIORITY);
        
        return VenuePeer::doSelect($criteria, $conn);
    }
    
    public static function createFromCSVLine($line, $lineNumber, $allLines, $update = true, $conn = null)
    {
        $exists = true;
        $venue = VenuePeer::retrieveByName($line['name'], $conn);
        if(!is_null($venue) and !$update)
        {
            return array($exists, $venue);
        }
        
        if(is_null($venue))
        {
            $venue = new Venue();
            $exists = false;
        }
        
        $venue->setName($line['name']);
        $venue->setActive($line['active']);
        $venue->setPriority($line['priority']);
         
        return array($exists, $venue);
    }
    
    public static function retrieveByName($name, $conn = null)
    {
        $c = new Criteria();
        $c->add(VenuePeer::NAME, $name);
        
        $results = VenuePeer::doSelect($c, $conn);
        
        if(count($results) < 1)
        {
            return null;
        }
        else if(count($results) > 1)
        {
            throw new Exception("More that one venue returned for '" . $name . "'");
        }
        else
        {
            return $results[0];
        }
    }
}
