<?php

/**
 * Subclass for performing query and update operations on the 'team_scores' table.
 *
 * 
 *
 * @package lib.model
 */ 
class TeamScorePeer extends BaseTeamScorePeer
{	
	public static function getTeamsInRankedOrder($active = true, $con = null)
	{	
		$activeCondition = null;
        if($active === true)
        {
            $activeCondition = "WHERE teams.active = true";
        }
        else if($active === false)
        {
            $activeCondition = "WHERE teams.active = false";
        }
        
        if(is_null($con))
        {
            $con = Propel::getConnection();
        }
		$stmt = $con->createStatement();
		$rs = $stmt->executeQuery(
		"SELECT  team_scores.* FROM team_scores, ".
		"teams ".$activeCondition." AND teams.id = team_scores.team_id ORDER BY team_scores.total_team_score DESC, ".
		"team_scores.total_speaker_score DESC, team_scores.total_margin DESC", ResultSet::FETCHMODE_NUM);
		
		return TeamScorePeer::populateObjects($rs);
	}
}
