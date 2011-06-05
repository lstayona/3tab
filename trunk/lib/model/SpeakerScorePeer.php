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
}
