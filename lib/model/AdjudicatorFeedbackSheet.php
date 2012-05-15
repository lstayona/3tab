<?php

/**
 * Subclass for representing a row from the 'adjudicator_feedback_sheets' table.
 *
 * 
 *
 * @package lib.model
 */ 
class AdjudicatorFeedbackSheet extends BaseAdjudicatorFeedbackSheet
{
        public static function feedbackComplete($round, $con = null)
        {
            if(count(self::getTeamsWithPendingFeedback($round,$con))== 0)
            {
                return true;
            }
        }
        
        public static function getTeamsWithPendingFeedback($round, $con=null)
        {
            $c = new Criteria();
            $c->addAscendingOrderByColumn(TeamPeer::NAME);
            $teams = TeamPeer::doSelect($c);
            $teamsWithPendingFeedback = array();
            foreach($teams as $team){
               $feedback_sheets_expected_for_round = count(self::getFeedbacksExpected($round, $team, $con = null));
               if($feedback_sheets_expected_for_round >0){
                  $teamsWithPendingFeedback[] = $team;
               }             
            }
            return $teamsWithPendingFeedback;
        }
        
       
        
        public static function getFeedbacksExpected($round, $team, $con = null)
        {
                if($con==null)
		{
			$con = Propel::getConnection();
		}		
		$stmt = $con->createStatement();
		$query = "SELECT DISTINCT adjudicator_allocations.* FROM debates_teams_xrefs,debates, adjudicator_allocations
                          WHERE debates_teams_xrefs.debate_id = debates.id 
                          AND adjudicator_allocations.debate_id = debates_teams_xrefs.debate_id
                          AND debates_teams_xrefs.team_id = %d
                          AND debates.round_id = %d";
		$query = sprintf($query, $team->getId(), $round->getId());
		$rs = $stmt->executeQuery($query, ResultSet::FETCHMODE_NUM);
		$allocatedJudges = AdjudicatorAllocationPeer::populateObjects($rs);
                $judgesWithNoFeedback = array();
                foreach($allocatedJudges as $judgeAllocation){
                    if(!self::checkFeedbackReceived($team, $judgeAllocation->getAdjudicator(),$con))
                    {
                        $judgesWithNoFeedback[] = $judgeAllocation;
                    }
                }
                
                return $judgesWithNoFeedback;
        }       
     
        
        private static function checkFeedbackReceived($team, $adjudicator, $con = null)
        {
            if($con==null)
		{
			$con = Propel::getConnection();
		}		
		$stmt = $con->createStatement();
		$query = "SELECT DISTINCT adjudicator_feedback_sheets.* FROM adjudicator_feedback_sheets,debates_teams_xrefs, debates
                          WHERE adjudicator_feedback_sheets.debate_team_xref_id = debates_teams_xrefs.id
                          AND debates_teams_xrefs.debate_id = debates.id
                          AND debates_teams_xrefs.team_id = %d
                          AND adjudicator_id = %d";
		$query = sprintf($query, $team->getId(), $adjudicator->getId());
		$rs = $stmt->executeQuery($query, ResultSet::FETCHMODE_NUM);
		$feedback_sheets = AdjudicatorFeedbackSheetPeer::populateObjects($rs);
                
                return count($feedback_sheets) > 0;
        }
        
	/*public static function feedbackComplete($round, $con=null)
	{
		$c = new Criteria();
		//$c->add(AdjudicatorPeer::ACTIVE, true);
		$adjudicators = AdjudicatorPeer::doSelect($c);
		$feedbacksLeft = 0;
		foreach($adjudicators as $anAdjudicator)
		{
			$feedbacksLeft += count(self::getFeedbackingTeams($anAdjudicator, $round, $con));
			$feedbacksLeft += count(self::getFeedbackingAdjudicators($anAdjudicator, $round, $con));
		}
		if($feedbacksLeft == 0)
		{
			return true;
		}
		return false;
	}
	
	public static function getAdjudicatorsToReceiveFeedback($round, $con=null)
	{
		$c = new Criteria();
		//$c->add(AdjudicatorPeer::ACTIVE, true);
		$adjudicators = AdjudicatorPeer::doSelect($c);
		$validAdjudicators = array();
		foreach($adjudicators as $anAdjudicator)
		{
			$feedbacksLeft = 0;
			$feedbacksLeft += count(self::getFeedbackingTeams($anAdjudicator, $round, $con));
			$feedbacksLeft += count(self::getFeedbackingAdjudicators($anAdjudicator, $round, $con));
			if($feedbacksLeft > 0)
			{
				$validAdjudicators[] = $anAdjudicator;
			}
		}
		return $validAdjudicators;
	}
	
	public static function getFeedbackingTeams($adjudicator, $round, $con=null)
	{
		if($con==null)
		{
			$con = Propel::getConnection();
		}		
		$teams = array();
		$allocation = $adjudicator->getAdjudicatorAllocation($round, $con);
		if($allocation && $allocation->getType() != 1)
		{
			return $teams;
		}		
		$stmt = $con->createStatement();
		$query = "SELECT debates_teams_xrefs.* FROM adjudicator_allocations, debates_teams_xrefs, ".
			"debates WHERE adjudicator_allocations.adjudicator_id = %d AND adjudicator_allocations.debate_id ".
			"= debates_teams_xrefs.debate_id AND adjudicator_allocations.debate_id = debates.id ".
			"AND debates.round_id = %d";
		$query = sprintf($query, $adjudicator->getId(), $round->getId());
		$rs = $stmt->executeQuery($query, ResultSet::FETCHMODE_NUM);
		$debateTeamXrefs = DebateTeamXrefPeer::populateObjects($rs);
		if($debateTeamXrefs == null)
		{
			return $teams;
		}
		foreach($debateTeamXrefs as $xref)
		{
			$query2 = "SELECT * from adjudicator_feedback_sheets WHERE adjudicator_feedback_sheets.".
			"debate_team_xref_id = %d AND adjudicator_id = %d";
			$query2 = sprintf($query2, $xref->getId($con), $adjudicator->getId());
			$rs = $stmt->executeQuery($query2, ResultSet::FETCHMODE_NUM);
			$feedbackSheet = AdjudicatorFeedbackSheetPeer::populateObjects($rs);
			if($feedbackSheet == null)
			{
				$teams[] = $xref->getTeam($con);
			}
		}
		return $teams;
	}
	
	public static function getFeedbackingAdjudicators($adjudicator, $round, $con=null)
	{
		if($con == null)
		{
			$con = Propel::getConnection();
		}			
		$feedbackingAdjudicators = array();
		$stmt = $con->createStatement();
		$query = "SELECT debates.* FROM adjudicator_allocations,debates WHERE ".
		"adjudicator_id = %d AND adjudicator_allocations.debate_id = debates.id and debates.round_id = %d";
		$query = sprintf($query, $adjudicator->getId(), $round->getId());
		$rs = $stmt->executeQuery($query, ResultSet::FETCHMODE_NUM);
		$debate = DebatePeer::populateObjects($rs);
		if($debate == null)
		{
			return $feedbackingAdjudicators;
		}
		$query2 = "SELECT adjudicator_allocations.* FROM adjudicator_allocations ".
		"WHERE adjudicator_allocations.debate_id = %d AND ".
		"adjudicator_allocations.adjudicator_id != %d";		
		$query2 = sprintf($query2, $debate[0]->getId(), $adjudicator->getId());
		$rs = $stmt->executeQuery($query2, ResultSet::FETCHMODE_NUM);
		$adjudicatorAllocations = AdjudicatorAllocationPeer::populateObjects($rs);	
		foreach($adjudicatorAllocations as $allocation)
		{	
			$query3 = "SELECT * FROM adjudicator_feedback_sheets WHERE adjudicator_allocation_id = %d ".
							 "AND adjudicator_id = %d";
			$query3 = sprintf($query3, $allocation->getId(), $adjudicator->getId());
			$rs = $stmt->executeQuery($query3, ResultSet::FETCHMODE_NUM);
			$feedbackSheet = AdjudicatorFeedbackSheetPeer::populateObjects($rs);
			if($feedbackSheet == null)
			{
				$feedbackingAdjudicators[] = $allocation->getAdjudicator();
			}
		}
		return $feedbackingAdjudicators;
	}*/
}
