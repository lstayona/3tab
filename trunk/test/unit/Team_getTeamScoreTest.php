<?php
require_once(dirname(__FILE__).'/../bootstrap/unit.php');
define('SF_APP',         '3tab');
define('SF_ENVIRONMENT', 'dev');
define('SF_DEBUG',       true);

require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');

sfContext::getInstance();

$t = new lime_test(2, new lime_output_color());

$con = Propel::getConnection();
$con->begin();
/*
 * Debate 3: 
 *   SWING A vs IIU A
 *   Winner: SWING A
 *   Adjudicators:
 *     Majority: mmu_adjudicator1, ntu_adjudicator2
 *     Minority: smu_adjudicator1
 */
$t->diag("Checking for panel and a split decision for an affirmative win");
$debate = DebatePeer::createDebate(
  TeamPeer::retrieveByName("SWING A", $con)->getId(), 
  TeamPeer::retrieveByName("IIU A", $con)->getId(), 
  VenuePeer::retrieveByName("Venue 4", $con));
$debate->setRound(RoundPeer::retrieveByName("Round 1", $con));
$debate->save($con);

$allocation = AdjudicatorAllocationPeer::createAdjudicatorAllocation(
  $debate->getId(), 
  AdjudicatorPeer::retrieveByName("mmu_adjudicator1", $con)->getId(),
  AdjudicatorAllocation::ADJUDICATOR_TYPE_CHAIR);
$allocation->save($con);
TeamScoreSheetPeer::createTeamScoreSheet($allocation->getId(), $debate->getDebateTeamXref(DebateTeamXref::AFFIRMATIVE, $con)->getId(), 1)->save($con);
TeamScoreSheetPeer::createTeamScoreSheet($allocation->getId(), $debate->getDebateTeamXref(DebateTeamXref::NEGATIVE, $con)->getId(), 0)->save($con);

$allocation = AdjudicatorAllocationPeer::createAdjudicatorAllocation(
  $debate->getId(), 
  AdjudicatorPeer::retrieveByName("ntu_adjudicator2", $con)->getId(),
  AdjudicatorAllocation::ADJUDICATOR_TYPE_PANELIST);
$allocation->save($con);
TeamScoreSheetPeer::createTeamScoreSheet($allocation->getId(), $debate->getDebateTeamXref(DebateTeamXref::AFFIRMATIVE, $con)->getId(), 1)->save($con);
TeamScoreSheetPeer::createTeamScoreSheet($allocation->getId(), $debate->getDebateTeamXref(DebateTeamXref::NEGATIVE, $con)->getId(), 0)->save($con);

$allocation = AdjudicatorAllocationPeer::createAdjudicatorAllocation(
  $debate->getId(), 
  AdjudicatorPeer::retrieveByName("smu_adjudicator1", $con)->getId(),
  AdjudicatorAllocation::ADJUDICATOR_TYPE_PANELIST);
$allocation->save($con);
TeamScoreSheetPeer::createTeamScoreSheet($allocation->getId(), $debate->getDebateTeamXref(DebateTeamXref::AFFIRMATIVE, $con)->getId(), 0)->save($con);
TeamScoreSheetPeer::createTeamScoreSheet($allocation->getId(), $debate->getDebateTeamXref(DebateTeamXref::NEGATIVE, $con)->getId(), 1)->save($con);

$t->is(TeamPeer::retrieveByName("SWING A", $con)->getTeamScore($debate, $con), 1, "-> correct score returned for winning team");
$t->is(TeamPeer::retrieveByName("IIU A", $con)->getTeamScore($debate, $con), 0, "-> correct score returned for lose team");
$con->rollback();
