<?php

/**
 * Subclass for performing query and update operations on the 'team_score_sheets' table.
 *
 * 
 *
 * @package lib.model
 */ 
class TeamScoreSheetPeer extends BaseTeamScoreSheetPeer
{
	public static function createTeamScoreSheet($adjudicatorAllocationId, $debateTeamXrefId, $score)
	{
        $scoreSheet = new TeamScoreSheet();
        $scoreSheet->setAdjudicatorAllocationId($adjudicatorAllocationId);
        $scoreSheet->setDebateTeamXrefId($debateTeamXrefId);
        $scoreSheet->setScore($score);

        return $scoreSheet;		
	}
}
