<?php

/**
 * Subclass for performing query and update operations on the 'team_score_sheets' table.
 *
 * 
 *
 * @package lib.model
 */ 
class SpeakerScoreSheetPeer extends BaseSpeakerScoreSheetPeer
{
	public static function createSpeakerScoreSheet($adjudicatorAllocationId, $debateTeamXrefId, $debaterId, $score, $position)
	{
        $scoreSheet = new SpeakerScoreSheet();
        $scoreSheet->setAdjudicatorAllocationId($adjudicatorAllocationId);
        $scoreSheet->setDebateTeamXrefId($debateTeamXrefId);
        $scoreSheet->setDebaterId($debaterId);
        $scoreSheet->setScore($score);
        $scoreSheet->setSpeakingPosition($position);

		return $scoreSheet;		
	}

}
