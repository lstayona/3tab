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
    
			$criteria = new Criteria();	
			$criteria->addJoin(AdjudicatorAllocationPeer::DEBATE_ID, DebatePeer::ID);
			$criteria->addJoin(DebatePeer::ID, DebateTeamXrefPeer::DEBATE_ID);
			$criteria->add(DebatePeer::ROUND_ID, $round->getId());
			$criteria->add(DebateTeamXrefPeer::TEAM_ID, $team->getId());
			$criteria->add(AdjudicatorAllocationPeer::TYPE, AdjudicatorAllocation::ADJUDICATOR_TYPE_TRAINEE, Criteria::NOT_EQUAL);

            $judgesWithNoFeedback = array();
            foreach(AdjudicatorAllocationPeer::doSelect($criteria, $con) as $judgeAllocation)
            {
                if(!self::checkFeedbackReceived($team, $judgeAllocation->getAdjudicator($con), $round, $con))
                {
                    $judgesWithNoFeedback[] = $judgeAllocation;
                }
            }

            return $judgesWithNoFeedback;
        }       
     
        
        private static function checkFeedbackReceived($team, $adjudicator, $round, $con = null)
        {
			$criteria = new Criteria();	
			$criteria->addJoin(AdjudicatorFeedbackSheetPeer::DEBATE_TEAM_XREF_ID, DebateTeamXrefPeer::ID);
			$criteria->addJoin(DebateTeamXrefPeer::DEBATE_ID, DebatePeer::ID);
			$criteria->add(DebatePeer::ROUND_ID, $round->getId());
			$criteria->add(DebateTeamXrefPeer::TEAM_ID, $team->getId());
			$criteria->add(AdjudicatorFeedbackSheetPeer::ADJUDICATOR_ID, $adjudicator->getId());

			return AdjudicatorFeedbackSheetPeer::doCount($criteria, true, $con) > 0 ? true : false;
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
