<?php

/**
 * Subclass for performing query and update operations on the 'rounds' table.
 *
 * 
 *
 * @package lib.model
 */ 
class RoundPeer extends BaseRoundPeer
{
    public static function getRoundsInSequence($propelConn = null)
    {
        $rounds = array();
        $hasRetrievedAllRounds = false;
        $precededByRoundId = null;

        while (!$hasRetrievedAllRounds) {
            $c = new Criteria();
            if (is_null($precededByRoundId)) {
                $c->add(RoundPeer::PRECEDED_BY_ROUND_ID, null, Criteria::ISNULL);
            } else {
                $c->add(RoundPeer::PRECEDED_BY_ROUND_ID, $precededByRoundId);
            }
            $round = RoundPeer::doSelectOne($c, $propelConn);
            if (!is_null($round)) {
                array_push($rounds, $round);
                $precededByRoundId = $round->getId();
            } else {
                $hasRetrievedAllRounds = true;
            }
        }
                
        return $rounds;
    }
	
	public static function getCurrentRound($conn=null)
	{
		$rounds = RoundPeer::getRoundsInSequence($conn);
		foreach($rounds as $round)
		{
			if($round->isCurrentRound($conn))
			{
				return $round;
			}
		}
		
		throw new Exception('Unable to find current round.');		
	}	

	public static function retrieveByName($name, $conn = null)
    {
        $c = new Criteria();
        $c->add(RoundPeer::NAME, $name);
        
        $results = RoundPeer::doSelect($c, $conn);
        
        if(count($results) < 1)
        {
            return null;
        }
        else if(count($results) > 1)
        {
            throw new Exception("More that one round returned for '" . $name . "'");
        }
        else
        {
            return $results[0];
        }
    }

}
