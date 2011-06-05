<?php

/**
 * Subclass for representing a row from the 'team_score_sheets' table.
 *
 * 
 *
 * @package lib.model
 */ 
class TeamScoreSheet extends BaseTeamScoreSheet
{
	public static function createTeamScoreSheet($allocation, $xref, $score)
	{
		$propelConn = Propel::getConnection();
		try{
			$propelConn->begin();
			$scoreSheet = new TeamScoreSheet();
			$scoreSheet->setAdjudicatorAllocationId($allocation);
			$scoreSheet->setDebateTeamXrefId($xref);
			$scoreSheet->setScore($score);
			$scoreSheet->save($propelConn);				
			$propelConn->commit();			
		}
		catch(Exception $e)
		{
			$propelConn->rollback();
			throw $e;
		}		
		return $scoreSheet;		
	}
}
