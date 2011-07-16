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

    public static function flushAndRepopulate($con = null)
    {
        if (!($con instanceof Connection)) {
            $con = Propel::getConnection();
        }

        try {
            $con->begin(); 
            $stmt = $con->createStatement();
            $rowsAffectedByDelete = $stmt->executeUpdate("DELETE FROM team_scores");

            $stmt = $con->createStatement();
            $sql = <<<EOD
INSERT INTO team_scores 
SELECT
  nextval('team_scores_seq'), 
  teams.id AS team_id, 
  SUM(COALESCE(team_margins.majority_team_score, 0)) AS total_team_score, 
  SUM(COALESCE(team_margins.team_speaker_score, 0.00)) AS total_speaker_score,
  SUM(COALESCE(team_margins.margin, 0.00)) AS total_margin,
  teams.created_at,
  LOCALTIMESTAMP(0)
  FROM teams
LEFT JOIN debates_teams_xrefs ON debates_teams_xrefs.team_id = teams.id
LEFT JOIN team_margins ON team_margins.debate_team_xref_id = debates_teams_xrefs.id
GROUP BY teams.id, teams.name, teams.created_at
EOD;
            $rowsAffectedByInsert = $stmt->executeUpdate($sql);

            if ($rowsAffectedByDelete != $rowsAffectedByInsert) {
                throw new Exception("Number of rows inserted (i.e. $rowsAffectedByInsert) to team_scores table not equal to number of rows deleted (i.e. $rowsAffectedByDelete).");
            }

            $con->commit();
        } catch (Exception $e) {
            $con->rollback();
            throw $e;
        }
    }
}
