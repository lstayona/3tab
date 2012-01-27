<?php

/**
 * Subclass for performing query and update operations on the 'debates_teams_xrefs' table.
 *
 * 
 *
 * @package lib.model
 */ 
class DebateTeamXrefPeer extends BaseDebateTeamXrefPeer
{
    public static function createDebateTeamXref($debate, $team, $position)
	{
        $xref = new DebateTeamXref();
        $xref->setDebate($debate);
        $xref->setTeamId($team);
        $xref->setPosition($position);
        
        $debate->addDebateTeamXref($xref);
        
		return $xref;	
	}

    public static function populateResultInformationForRound($roundId, $conn = null)
    {
        if (!($con instanceof Connection)) {
            $con = Propel::getConnection();
        }

        try {
            $con->begin(); 
            $sql = <<<EOD
UPDATE debates_teams_xrefs
SET 
  majority_team_score = team_margins.majority_team_score,
  team_speaker_score = team_margins.team_speaker_score,
  margin = team_margins.margin
FROM team_margins
JOIN debates_teams_xrefs AS dbtx ON dbtx.id = team_margins.debate_team_xref_id
JOIN debates ON dbtx.debate_id = debates.id
WHERE debates.round_id = ? 
AND debates_teams_xrefs.id = team_margins.debate_team_xref_id
EOD;
            $stmt = $con->prepareStatement($sql);
            $stmt->setInt(1, $roundId);
            $stmt->executeUpdate();
            $con->commit();
        } catch (Exception $e) {
            $con->rollback();
            throw $e;
        }
    }
}
