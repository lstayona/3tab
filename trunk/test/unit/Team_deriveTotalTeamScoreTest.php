<?php
require_once(dirname(__FILE__).'/../bootstrap/unit.php');
define('SF_APP',         '3tab');
define('SF_ENVIRONMENT', 'dev');
define('SF_DEBUG',       true);

require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');

sfContext::getInstance();

$t = new lime_test(8, new lime_output_color());

$con = Propel::getConnection();
$con->begin();
/*
 * Round 1 Debate 1: 
 *   MMU A vs FOO A 
 *   Winner: MMU A
 *   Adjudicator: bar_adjudicator1
 */
$t->diag("Checking after first round");
$debate = DebatePeer::createDebate(
  TeamPeer::retrieveByName("MMU A", $con)->getId(), 
  TeamPeer::retrieveByName("FOO A", $con)->getId(), 
  VenuePeer::retrieveByName("Venue 1", $con));
$debate->setRound(RoundPeer::retrieveByName("Round 1", $con));
$debate->save($con);

$allocation = AdjudicatorAllocationPeer::createAdjudicatorAllocation(
  $debate->getId(), 
  AdjudicatorPeer::retrieveByName("bar_adjudicator1", $con)->getId(),
  AdjudicatorAllocation::ADJUDICATOR_TYPE_CHAIR);
$allocation->save($con);

TeamScoreSheetPeer::createTeamScoreSheet($allocation->getId(), $debate->getDebateTeamXref(DebateTeamXref::AFFIRMATIVE, $con)->getId(), 1)->save($con);
TeamScoreSheetPeer::createTeamScoreSheet($allocation->getId(), $debate->getDebateTeamXref(DebateTeamXref::NEGATIVE, $con)->getId(), 0)->save($con);

$t->is(TeamPeer::retrieveByName("MMU A", $con)->deriveTotalTeamScore(), 1, "-> Correct total score for winning team");
$t->is(TeamPeer::retrieveByName("FOO A", $con)->deriveTotalTeamScore(), 0, "-> Correct total score for losing team");

/*
 * Round 1 Debate 2: 
 *   BAR A vs SHIT A
 *   Winner: SHIT A
 *   Adjudicator: ntu_adjudicator1 
 */
$debate = DebatePeer::createDebate(
  TeamPeer::retrieveByName("BAR A", $con)->getId(), 
  TeamPeer::retrieveByName("SHIT A", $con)->getId(), 
  VenuePeer::retrieveByName("Venue 2", $con));
$debate->setRound(RoundPeer::retrieveByName("Round 1", $con));
$debate->save($con);

$allocation = AdjudicatorAllocationPeer::createAdjudicatorAllocation(
  $debate->getId(), 
  AdjudicatorPeer::retrieveByName("ntu_adjudicator1", $con)->getId(),
  AdjudicatorAllocation::ADJUDICATOR_TYPE_CHAIR);
$allocation->save($con);

TeamScoreSheetPeer::createTeamScoreSheet($allocation->getId(), $debate->getDebateTeamXref(DebateTeamXref::AFFIRMATIVE, $con)->getId(), 0)->save($con);
TeamScoreSheetPeer::createTeamScoreSheet($allocation->getId(), $debate->getDebateTeamXref(DebateTeamXref::NEGATIVE, $con)->getId(), 1)->save($con);

$t->is(TeamPeer::retrieveByName("SHIT A", $con)->deriveTotalTeamScore(), 1, "-> Correct total score for winning team");
$t->is(TeamPeer::retrieveByName("BAR A", $con)->deriveTotalTeamScore(), 0, "-> Correct total score for losing team");

/*
 * Round 2 Debate 1: 
 *   SHIT A vs MMU A
 *   Winner: SHIT A
 *   Adjudicator: ntu_adjudicator1
 */
$t->diag("Checking after second round");
$debate = DebatePeer::createDebate(
  TeamPeer::retrieveByName("SHIT A", $con)->getId(), 
  TeamPeer::retrieveByName("MMU A", $con)->getId(), 
  VenuePeer::retrieveByName("Venue 1", $con));
$debate->setRound(RoundPeer::retrieveByName("Round 2", $con));
$debate->save($con);

$allocation = AdjudicatorAllocationPeer::createAdjudicatorAllocation(
  $debate->getId(), 
  AdjudicatorPeer::retrieveByName("ntu_adjudicator1", $con)->getId(),
  AdjudicatorAllocation::ADJUDICATOR_TYPE_CHAIR);
$allocation->save($con);

TeamScoreSheetPeer::createTeamScoreSheet($allocation->getId(), $debate->getDebateTeamXref(DebateTeamXref::AFFIRMATIVE, $con)->getId(), 1)->save($con);
TeamScoreSheetPeer::createTeamScoreSheet($allocation->getId(), $debate->getDebateTeamXref(DebateTeamXref::NEGATIVE, $con)->getId(), 0)->save($con);

$t->is(TeamPeer::retrieveByName("SHIT A", $con)->deriveTotalTeamScore(), 2, "-> Correct total score for winning team");
$t->is(TeamPeer::retrieveByName("MMU A", $con)->deriveTotalTeamScore(), 1, "-> Correct total score for losing team");

/*
 * Round 2 Debate 2: 
 *   FOO A vs BAR A
 *   Winner: FOO A
 *   Adjudicator: iiu_adjudicator1 
 */
$debate = DebatePeer::createDebate(
  TeamPeer::retrieveByName("FOO A", $con)->getId(), 
  TeamPeer::retrieveByName("BAR A", $con)->getId(), 
  VenuePeer::retrieveByName("Venue 2", $con));
$debate->setRound(RoundPeer::retrieveByName("Round 2", $con));
$debate->save($con);

$allocation = AdjudicatorAllocationPeer::createAdjudicatorAllocation(
  $debate->getId(), 
  AdjudicatorPeer::retrieveByName("iiu_adjudicator1", $con)->getId(),
  AdjudicatorAllocation::ADJUDICATOR_TYPE_CHAIR);
$allocation->save($con);

TeamScoreSheetPeer::createTeamScoreSheet($allocation->getId(), $debate->getDebateTeamXref(DebateTeamXref::AFFIRMATIVE, $con)->getId(), 1)->save($con);
TeamScoreSheetPeer::createTeamScoreSheet($allocation->getId(), $debate->getDebateTeamXref(DebateTeamXref::NEGATIVE, $con)->getId(), 0)->save($con);

$t->is(TeamPeer::retrieveByName("FOO A", $con)->deriveTotalTeamScore(), 1, "-> Correct total score for winning team");
$t->is(TeamPeer::retrieveByName("BAR A", $con)->deriveTotalTeamScore(), 0, "-> Correct total score for losing team");

$con->rollback();
