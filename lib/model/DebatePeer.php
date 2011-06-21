<?php

/**
 * Subclass for performing query and update operations on the 'debates' table.
 *
 * 
 *
 * @package lib.model
 */ 
class DebatePeer extends BaseDebatePeer
{
    public static function doDraw($round, $oneUpOneDownOnSameInstitution = true, $oneUpOneDownOnMetBefore = true, $con = null)
    {
        $debates = array();
        if($round->getType() == Round::ROUND_TYPE_RANDOM)
        {
            $debates = DebatePeer::generateRandomDrawDebates($con);
            DebatePeer::doOneUpOneDown($debates, $oneUpOneDownOnSameInstitution, $oneUpOneDownOnMetBefore, $con);
        }
        else if($round->getType() == Round::ROUND_TYPE_PRELIMINARY || $round->getType() == Round::ROUND_TYPE_BUBBLE)
        {
            $debates = DebatePeer::generateMatchedDrawDebates();
            foreach($debates as $debate)
            {
                $brackets[$debate->getBracket()][] = $debate;
            }
            foreach($brackets as $bracket)
            {
                DebatePeer::doOneUpOneDown($bracket, $oneUpOneDownOnSameInstitution, $oneUpOneDownOnMetBefore, $con);
            }
            foreach($debates as $debate)
            {
                $xrefs = $debate->getDebateTeamXrefs();
                if((rand(0,1) == 0) ? true : false)
                {
                    $xrefs[0]->swapTeams($xrefs[1]);
                }
            }
            DebatePeer::checkTeamPositions($debates);
        }
        
        return $debates;
    }

    public static function generateRandomDrawDebates($conn = null)
    {
        $teams = TeamPeer::getTeamsInRandomOrder(true, $conn);
        $debates = array();
        $venues = VenuePeer::getActiveVenuesOrderedByPriority(new Criteria(), $conn);
        if(count($teams) % 2 == 0)
        {
            for($walker = 0; $walker < count($teams); $walker+=2)
            {
                array_push($debates, DebatePeer::createDebate($teams[$walker]->getId(), $teams[$walker+1]->getId(), $venues[$walker / 2]));
            }
        }
        else
        {
            throw new Exception("There are an odd number of teams; ". count($teams)." team(s).  A swing team should be inserted.");
        }
        
        return $debates;
    }
	
	public static function generateMatchedDrawDebates($conn = null)
	{
		$teamScores = TeamScorePeer::getTeamsInRankedOrder(true, $conn);
		$teams = array();
		foreach($teamScores as $teamScore)
        {
			$teams[] = $teamScore->getTeam();
		}

		$debates = array();
        $venues = VenuePeer::getActiveVenuesOrderedByPriority(new Criteria(), $conn);
		//check if num of teams is even
		if(count($teams) % 2 == 0)
		{
			//initialize all the brackets so we can handle empty brackets
			for($i=0; $i <= $teams[0]->getTotalTeamScore(); $i++)
			{
				$brackets[$i] = null;
			}
			
			//create the brackets
			foreach($teams as $team)
			{
				$brackets[$team->getTotalTeamScore()][] = $team->getId();
			}	
						
			//check the brackets
			for($i=count($brackets)-1; $i >= 0; $i--)
			{
				if($brackets[$i] != null)
				{
					if(count($brackets[$i]) % 2 != 0)
					{
						//pullup one team from the next non empty bracket
						//the last bracket should always be even now, but do this check anyway
						if($i != 0)
						{
							//find the next non empty bracket
							$count = 1;
							while($brackets[$i-$count] == null){
								$count++;
							}
							//move first element from the array
							$temp = array_reverse($brackets[$i-$count]);
							$brackets[$i][] = array_pop($temp);
							$brackets[$i-$count] = array_reverse($temp);
						}
					}
				}
			}
			//do the slide on the brackets
			$counter = 0;
			$bracketCounter = count($brackets);
			foreach(array_reverse($brackets) as $teams)
			{
				$numDebates = count($teams)/2;
				for($i=0; $i < $numDebates; $i++)
				{
                    /*
                     * By default, the team that is put in the affirmative is 
                     * the higher ranked team and the team that is put in the 
                     * negative is the lower ranked team.
                     */
					array_push($debates, DebatePeer::createDebate($teams[$i], $teams[$i+$numDebates], $venues[$counter]));
					$counter++;
				}
			}
		}
		else
		{
			throw new Exception("There are an odd number of teams; ". count($teams)." team(s).  A swing team should be inserted.");
		}
		
		return $debates;
	}
    
    public static function createDebate($affirmativeTeamId, $negativeTeamId, $venue = null)
	{
        $debate = new Debate();
        DebateTeamXrefPeer::createDebateTeamXref($debate, $affirmativeTeamId, DebateTeamXref::AFFIRMATIVE);
        DebateTeamXrefPeer::createDebateTeamXref($debate, $negativeTeamId, DebateTeamXref::NEGATIVE);
        $debate->setVenue($venue);
        
		return $debate;		
	}
  	
    /**
     * This method does the one-up, one-down swap for the array of Debates that
     * are passed in to the method. There are two potential triggers for a 
     * one-up, one-down to be done:
     * 1. Both teams in a debate are from the same institution.
     * 2. Both teams have met before.
     *
     * If either of these conditions are enabled as trigger points and the 
     * debate meets either of those conditions, we swap the lower ranked 
     * team in the room with the lower ranked team in the debate below or
     * in the debate above. However, we only do so if the swap doesn't result
     * in the same conditions that triggered the swap in the room that receives 
     * the swapped team. If that happens, we revert to the original state.
     * 
     * Clarification: The lower ranked team is the team with the higher
     * index of the two DebateTeamXref objects in the array returned by the 
     * call to the Debate::getDebateTeamXrefs method.
     *
     * @param $debate Array An array of Debate objects.
     * @param $oneUpOneDownOnSameInstitution boolean
     * @param $oneUpOneDownOnMetBefore boolean
     * @param $conn Connection
     */
	public static function doOneUpOneDown($debates, $oneUpOneDownOnSameInstitution = true, $oneUpOneDownOnMetBefore = true, $conn = null)
	{
        //If there is only one debate or one-up, one-down isn't necessary, just return
		if(count($debates) == 1 or ($oneUpOneDownOnSameInstitution == false and $oneUpOneDownOnMetBefore == false))
		{
			return;
		}

		for($i = 0; $i < count($debates); $i++)
		{			
			$xrefs = $debates[$i]->getDebateTeamXrefs(new Criteria(), $conn);
			if(($debates[$i]->areBothTeamsInDebateFromSameInstitution($conn) and $oneUpOneDownOnSameInstitution) or 
              ($debates[$i]->haveBothTeamsMetBefore($conn) and $oneUpOneDownOnMetBefore))
			{			
				/*
                 * If it is the top debate in the bracket, swap the lower 
                 * ranked team in the current debate with the lower ranked 
                 * team in the debate below.
                 */
				if($i == 0)
				{
					$lowerXrefs = $debates[$i+1]->getDebateTeamXrefs(new Criteria(), $conn);
					if($xrefs[1]->getTeam($conn)->getInstitutionId() != $lowerXrefs[1]->getTeam($conn)->getInstitutionId() && $xrefs[1]->getTeam($conn)->getInstitutionId() != $lowerXrefs[0] ->getTeam($conn)->getInstitutionId() &&
					   !$xrefs[1]->getTeam($conn)->hasMetTeam($lowerXrefs[1]->getTeam($conn)) &&
					   !$xrefs[1]->getTeam($conn)->hasMetTeam($lowerXrefs[0]->getTeam($conn)) )
					{
						$xrefs[1]->swapTeams($lowerXrefs[1], $conn);
					}
				}
				/*
                 * If it is the lowest debate in the bracket, swap the lower 
                 * ranked team in the current debate with the lower ranked 
                 * team in the debate above.
                 */
				else if($i == count($debates)-1)
				{
					$higherXrefs = $debates[$i -1]->getDebateTeamXrefs(new Criteria(), $conn);
					if($xrefs[1]->getTeam($conn)->getInstitutionId() !=
					   $higherXrefs[1]->getTeam($conn)->getInstitutionId() &&
					   $xrefs[1]->getTeam($conn)->getInstitutionId() !=
					   $higherXrefs[0] ->getTeam($conn)->getInstitutionId()&&
					   !$xrefs[1]->getTeam($conn)->hasMetTeam($higherXrefs[1]->getTeam($conn)) &&
					   !$xrefs[1]->getTeam($conn)->hasMetTeam($higherXrefs[0]->getTeam($conn)))
					{
						$xrefs[1]->swapTeams($higherXrefs[1], $conn);
					}
				}
                /*
                 * If it is a debate in the middle of the bracket, first 
                 * attempt to swap with the debate below and, if that's not
                 * possible, swap with the debate above.
                 */
				else
				{
					$lowerXrefs = $debates[$i+1]->getDebateTeamXrefs(new Criteria(), $conn);
					$higherXrefs = $debates[$i -1]->getDebateTeamXrefs(new Criteria(), $conn);
					if($xrefs[1]->getTeam($conn)->getInstitutionId() !=
					   $lowerXrefs[1]->getTeam($conn)->getInstitutionId() &&
					   $xrefs[1]->getTeam($conn)->getInstitutionId() !=
					   $lowerXrefs[0] ->getTeam($conn)->getInstitutionId()&&
					   !$xrefs[1]->getTeam($conn)->hasMetTeam($lowerXrefs[1]->getTeam($conn)) &&
					   !$xrefs[1]->getTeam($conn)->hasMetTeam($lowerXrefs[0]->getTeam($conn)))
					{
						$xrefs[1]->swapTeams($lowerXrefs[1], $conn);
					}
					else if($xrefs[1]->getTeam($conn)->getInstitutionId() !=
					   $higherXrefs[1]->getTeam($conn)->getInstitutionId() &&
					   $xrefs[1]->getTeam($conn)->getInstitutionId() !=
					   $higherXrefs[0] ->getTeam($conn)->getInstitutionId()&&
					   !$xrefs[1]->getTeam($conn)->hasMetTeam($higherXrefs[1]->getTeam($conn)) &&
					   !$xrefs[1]->getTeam($conn)->hasMetTeam($higherXrefs[0]->getTeam($conn)))
					{
						$xrefs[1]->swapTeams($higherXrefs[1], $conn);
					}
				}
			}			
		}		
	}
	
	public static function checkTeamPositions($debates, $conn=null)
	{
		foreach($debates as $debate)
		{
			$xrefs = $debate->getDebateTeamXrefs($conn);
			if($xrefs[0]->getTeam($conn)->getTotalAffs($conn) >
			   $xrefs[1]->getTeam($conn)->getTotalAffs($conn))
			{
			   $xrefs[0]->swapTeams($xrefs[1]);
			}
		}			   
	}	
}
