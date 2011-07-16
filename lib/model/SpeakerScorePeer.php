<?php

/**
 * Subclass for performing query and update operations on the 'speaker_scores' table.
 *
 * 
 *
 * @package lib.model
 */ 
class SpeakerScorePeer extends BaseSpeakerScorePeer
{
	public static function getDebatersInOrder( $con = null)
	{	        
        if(is_null($con))
        {
            $con = Propel::getConnection();
        }
		$stmt = $con->createStatement();
		$rs = $stmt->executeQuery(
		"SELECT  speaker_scores.* FROM speaker_scores, ".
		"debaters WHERE debaters.id = speaker_scores.debater_id ORDER BY ".
		"speaker_scores.total_speaker_score DESC", ResultSet::FETCHMODE_NUM);
		
		return SpeakerScorePeer::populateObjects($rs);
	}

    public static function flushAndRepopulate($con = null)
    {
        if (!($con instanceof Connection)) {
            $con = Propel::getConnection();
        }

        try {
            $con->begin(); 
            $stmt = $con->createStatement();
            $rowsAffectedByDelete = $stmt->executeUpdate("DELETE FROM speaker_scores");

            $stmt = $con->createStatement();
            $sql = <<<EOD
INSERT INTO speaker_scores
SELECT
  nextval('speaker_scores_seq'), 
  debaters.id AS debater_id,
  SUM(COALESCE(debater_results.averaged_score, 0.00)) AS total_speaker_score,
  debaters.created_at,
  LOCALTIMESTAMP(0)
FROM debaters
LEFT JOIN debater_results ON debater_results.debater_id = debaters.id AND debater_results.speaking_position <> 4
GROUP BY debaters.id, debaters.name, debaters.created_at
EOD;
            $rowsAffectedByInsert = $stmt->executeUpdate($sql);

            if ($rowsAffectedByDelete != $rowsAffectedByInsert) {
                throw new Exception("Number of rows inserted (i.e. $rowsAffectedByInsert) to speaker_scores table not equal to number of rows deleted (i.e. $rowsAffectedByDelete).");
            }

            $con->commit();
        } catch (Exception $e) {
            $con->rollback();
            throw $e;
        }
    }

}
