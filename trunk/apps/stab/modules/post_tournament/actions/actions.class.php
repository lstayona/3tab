<?php

/**
 * post_tournament actions.
 *
 * @package    stab
 * @subpackage post_tournament
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class post_tournamentActions extends sfActions
{
  /**
   * Executes index action
   *
   */
  public function executeIndex()
  {
    $this->rounds = RoundPeer::getRoundsInSequence();
  }
  
  public function executeSpeakerRankings()
  {
	$this->speakerScores = SpeakerScorePeer::getDebatersInOrder();
  }
  
  public function executeTeamRankings()
  {
	$this->teamScores = TeamScorePeer::getTeamsInRankedOrder();
  }
  
  public function executeResultsByRound()
  {
	$this->rounds = RoundPeer::getRoundsInSequence();
  }
  
  public function executeResultsByTeam()
  {
	$c = new Criteria();
	$c->addAscendingOrderByColumn(TeamPeer::NAME);
	$this->teams = TeamPeer::doSelect($c);
	$rounds = RoundPeer::getRoundsInSequence();
	$this->roundIds = array();
	foreach($rounds as $round)
	{
		$this->roundIds[] = $round->getId();
	}
  }
  
  public function executeResultsByAdjudicator()
  {
	$c = new Criteria();
	$c->addAscendingOrderByColumn(AdjudicatorPeer::NAME);
	$this->adjudicators = AdjudicatorPeer::doSelect($c);
	$rounds = RoundPeer::getRoundsInSequence();
	$this->roundIds = array();
	foreach($rounds as $round)
	{
		$this->roundIds[] = $round->getId();
	}
  }
  
  public function executeViewMatchups()
  {
	$this->round = RoundPeer::retrieveByPK($this->getRequestParameter("id"));
  }
  
  public function executeViewScoreSheets()
  {
	$this->debate = DebatePeer::retrieveByPk($this->getRequestParameter("debateId"));
  }
}
