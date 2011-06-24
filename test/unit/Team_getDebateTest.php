<?php
require_once(dirname(__FILE__).'/../bootstrap/unit.php');
define('SF_APP',         '3tab');
define('SF_ENVIRONMENT', 'dev');
define('SF_DEBUG',       true);

require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');

sfContext::getInstance();

$t = new lime_test(4, new lime_output_color());
$con = Propel::getConnection();
$con->begin();
/*
 * Test data scenario:
 * Debate 1: 
 *   MMU A vs FOO A 
 */
$t->diag("Checking for round 1 debate.");
$debate = DebatePeer::createDebate(
  TeamPeer::retrieveByName("MMU A", $con)->getId(), 
  TeamPeer::retrieveByName("FOO A", $con)->getId(), 
  VenuePeer::retrieveByName("Venue 1", $con));
$debate->setRound(RoundPeer::retrieveByName("Round 1", $con));
$debate->save($con);
$t->is(TeamPeer::retrieveByName("MMU A", $con)->getDebate(RoundPeer::retrieveByName("Round 1", $con)->getId(), $con)->getId(), $debate->getId(), '-> Correct debate retrieved for affirmative team.');
$t->is(TeamPeer::retrieveByName("FOO A", $con)->getDebate(RoundPeer::retrieveByName("Round 1", $con)->getId(), $con)->getId(), $debate->getId(), '-> Correct debate retrieved for negative team.');

/*
 * Test data scenario:
 * Debate 1: 
 *   FOO A vs IIU A
 */
$t->diag("Checking for round 1 debate.");
$debate = DebatePeer::createDebate(
  TeamPeer::retrieveByName("FOO A", $con)->getId(), 
  TeamPeer::retrieveByName("IIU A", $con)->getId(), 
  VenuePeer::retrieveByName("Venue 1", $con));
$debate->setRound(RoundPeer::retrieveByName("Round 2", $con));
$debate->save($con);
$t->is(TeamPeer::retrieveByName("FOO A", $con)->getDebate(RoundPeer::retrieveByName("Round 2", $con)->getId(), $con)->getId(), $debate->getId(), '-> Correct debate retrieved for affirmative team.');
$t->is(TeamPeer::retrieveByName("IIU A", $con)->getDebate(RoundPeer::retrieveByName("Round 2", $con)->getId(), $con)->getId(), $debate->getId(), '-> Correct debate retrieved for negative team.');

$con->rollback();
