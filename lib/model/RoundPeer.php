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
        $criteria = new Criteria();
        $criteria->addAscendingOrderByColumn(RoundPeer::PRECEDED_BY_ROUND_ID);
        $unorderedRounds = RoundPeer::doSelect($criteria, $propelConn);
        /*
         * The rounds come back with the first round (preceded by null) at the
         * thoe bottom of the list.  Therefore, we have to insert that round
         * at the top of the returned list, followed by all the other rounds,
         * which are ordered correctly.
         */
        $rounds = array();
        if(count($unorderedRounds) > 0)
        {
            array_push($rounds, $unorderedRounds[count($unorderedRounds)-1]);
            for($count = 0; $count < count($unorderedRounds) - 1; $count++)
            {
                array_push($rounds, $unorderedRounds[$count]);
            }
        }
        
        return $rounds;
    }
	
	 
	public static function getCurrentRound($conn=null)
	{
		$rounds = RoundPeer::doSelect(new Criteria(), $conn);
		foreach($rounds as $round)
		{
			if($round->isCurrentRound())
			{
				return $round;
			}
		}
		
		throw new Exception('All rounds have been completed, or there is an error with the rounds');		
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
