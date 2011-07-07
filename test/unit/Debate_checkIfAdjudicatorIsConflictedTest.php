<?php
require_once(dirname(__FILE__).'/../bootstrap/unit.php');
define('SF_APP',         '3tab');
define('SF_ENVIRONMENT', 'dev');
define('SF_DEBUG',       true);

require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');

sfContext::getInstance();

$t = new lime_test(4, new lime_output_color());

$con = Propel::getConnection();
$t->diag("Check that no conflicts are returned when there are none.");
$con->begin();
$debate = DebatePeer::createDebate(
  TeamPeer::retrieveByName("SWING A", $con)->getId(), 
  TeamPeer::retrieveByName("IIU A", $con)->getId(), 
  VenuePeer::retrieveByName("Venue 4", $con));
$debate->setRound(RoundPeer::retrieveByName("Round 1", $con));
$debate->save($con);
$t->is($debate->checkIfAdjudicatorIsConflicted(AdjudicatorPeer::retrieveByName("mmu_adjudicator1", $con), $con), false, '-> Adjudicator correctly determined as not conflicted.');
$con->rollback();

$t->diag("Check that conflicts are returned for own institution team in affirmative.");
$con->begin();
$debate = DebatePeer::createDebate(
  TeamPeer::retrieveByName("MMU A", $con)->getId(), 
  TeamPeer::retrieveByName("IIU A", $con)->getId(), 
  VenuePeer::retrieveByName("Venue 4", $con));
$debate->setRound(RoundPeer::retrieveByName("Round 1", $con));
$debate->save($con);
$t->is($debate->checkIfAdjudicatorIsConflicted(AdjudicatorPeer::retrieveByName("mmu_adjudicator1", $con), $con), true, '-> Adjudicator correctly determined as conflicted.');
$con->rollback();

$t->diag("Check that conflicts are returned for own institution team in negative.");
$con->begin();
$debate = DebatePeer::createDebate(
  TeamPeer::retrieveByName("SWING A", $con)->getId(), 
  TeamPeer::retrieveByName("MMU A", $con)->getId(), 
  VenuePeer::retrieveByName("Venue 4", $con));
$debate->setRound(RoundPeer::retrieveByName("Round 1", $con));
$debate->save($con);
$t->is($debate->checkIfAdjudicatorIsConflicted(AdjudicatorPeer::retrieveByName("mmu_adjudicator1", $con), $con), true, '-> Adjudicator correctly determined as conflicted.');
$con->rollback();

$t->diag("Check that conflicts are returned for personal conflicts.");
$con->begin();
$conflict = new AdjudicatorConflict();
$conflict->setAdjudicator(AdjudicatorPeer::retrieveByName("mmu_adjudicator1", $con));
$conflict->setTeam(TeamPeer::retrieveByName("SWING A", $con));
$conflict->save($con);

$debate = DebatePeer::createDebate(
  TeamPeer::retrieveByName("SWING A", $con)->getId(), 
  TeamPeer::retrieveByName("IIU A", $con)->getId(), 
  VenuePeer::retrieveByName("Venue 4", $con));
$debate->setRound(RoundPeer::retrieveByName("Round 1", $con));
$debate->save($con);
$t->is($debate->checkIfAdjudicatorIsConflicted(AdjudicatorPeer::retrieveByName("mmu_adjudicator1", $con), $con), true, '-> Adjudicator correctly determined as conflicted.');
$con->rollback();
