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
			for($i=0; $i<=$teams[0]->getTotalTeamScore(); $i++)
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
    
    public static function createDebate($affirmativeTeam, $negativeTeam, $venue = null)
	{
        $debate = new Debate();
        DebateTeamXrefPeer::createDebateTeamXref($debate, $affirmativeTeam, DebateTeamXref::AFFIRMATIVE);
        DebateTeamXrefPeer::createDebateTeamXref($debate, $negativeTeam, DebateTeamXref::NEGATIVE);
        $debate->setVenue($venue);
        
		return $debate;		
	}
  	
	public static function doOneUpOneDown($debates, $conn = null)
	{
		if(count($debates) == 1)
		{
			return 0;
		}
		for($i = 0; $i < count($debates); $i++)
		{			
			$xrefs = $debates[$i]->getDebateTeamXrefs(new Criteria(), $conn);
			if($debates[$i]->areBothTeamsInDebateFromSameInstitution($conn) || $debates[$i]->haveBothTeamsMetBefore($conn))
			{			
				//if its the first, check and swap with the debate below
				if($i == 0)
				{
					$lowerXrefs = $debates[$i+1]->getDebateTeamXrefs(new Criteria(), $conn);
					if($xrefs[1]->getTeam($conn)->getInstitutionId() !=
					   $lowerXrefs[1]->getTeam($conn)->getInstitutionId() &&
					   $xrefs[1]->getTeam($conn)->getInstitutionId() !=
					   $lowerXrefs[0] ->getTeam($conn)->getInstitutionId() &&
					   !$xrefs[1]->getTeam($conn)->hasMetTeam($lowerXrefs[1]->getTeam($conn)) &&
					   !$xrefs[1]->getTeam($conn)->hasMetTeam($lowerXrefs[0]->getTeam($conn)) )
					{
						$xrefs[1]->swapTeams($lowerXrefs[1], $conn);
					}
				}
				//if its the last, check and swap with the debate above
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
				//else check and swap below first, else check and swap above
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
