<?php

/**
 * Subclass for performing query and update operations on the 'debaters' table.
 *
 * 
 *
 * @package lib.model
 */ 
class DebaterPeer extends BaseDebaterPeer
{
    public static function createFromCSVLine($line, $lineNumber, $allLines, $update = true, $conn = null)
    {
        $exists = true;
        $debater = DebaterPeer::retrieveByName($line['name'], $conn);
        if(!is_null($debater) and !$update)
        {
            return array($exists, $debater);
        }
        
        if(is_null($debater))
        {
            $debater = new Debater();
            $exists = false;
        }
        
        $debater->setName($line['name']);
        $team = TeamPeer::retrieveByName($line['team-name'], $conn);
        if(!is_null($team))
        {
            $debater->setTeam($team);
        }
        else
        {
            throw new Exception("The team with the name '" . $line['team-name'] . "' does not exist.");
        }
        
        return array($exists, $debater);
    }
    
    public static function retrieveByName($name, $conn = null)
    {
        $c = new Criteria();
        $c->add(DebaterPeer::NAME, $name);
        
        $results = DebaterPeer::doSelect($c, $conn);
        
        if(count($results) < 1)
        {
            return null;
        }
        else if(count($results) > 1)
        {
            throw new Exception("More that one debater returned for '" . $name . "'");
        }
        else
        {
            return $results[0];
        }
    }
}
