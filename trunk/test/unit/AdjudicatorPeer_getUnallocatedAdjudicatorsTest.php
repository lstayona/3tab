<?php
require_once(dirname(__FILE__).'/../bootstrap/unit.php');
define('SF_APP',         '3tab');
define('SF_ENVIRONMENT', 'dev');
define('SF_DEBUG',       true);

require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');

sfContext::getInstance();

$t = new lime_test(5, new lime_output_color());

$con = Propel::getConnection();
$con->begin();

$t->diag("Deactivating all adjudicators except 3");
$con->executeUpdate("UPDATE adjudicators SET active = false WHERE ".
"adjudicators.name NOT IN ('mmu_adjudicator1', 'ntu_adjudicator2', ".
"'smu_adjudicator1')");

$debate = DebatePeer::createDebate(
  TeamPeer::retrieveByName("SWING A", $con)->getId(), 
  TeamPeer::retrieveByName("IIU A", $con)->getId(), 
  VenuePeer::retrieveByName("Venue 4", $con));
$debate->setRound(RoundPeer::retrieveByName("Round 1", $con));
$debate->save($con);

$t->diag("Checking with no allocations");
$t->is(count(AdjudicatorPeer::getUnallocatedAdjudicators($debate->getRound($con), $con)), 3, '-> correct number of unallocated adjudicators returned.');

AdjudicatorAllocationPeer::createAdjudicatorAllocation(
  $debate->getId(), 
  AdjudicatorPeer::retrieveByName("mmu_adjudicator1", $con)->getId(),
  AdjudicatorAllocation::ADJUDICATOR_TYPE_CHAIR)->save($con);

$t->diag("Checking with one allocation");
$t->is(count(AdjudicatorPeer::getUnallocatedAdjudicators($debate->getRound($con), $con)), 2, '-> correct number of unallocated adjudicators returned.');

AdjudicatorAllocationPeer::createAdjudicatorAllocation(
  $debate->getId(), 
  AdjudicatorPeer::retrieveByName("ntu_adjudicator2", $con)->getId(),
  AdjudicatorAllocation::ADJUDICATOR_TYPE_PANELIST)->save($con);

$t->diag("Checking with two allocations");
$unallocatedAdjudicators = AdjudicatorPeer::getUnallocatedAdjudicators($debate->getRound($con), $con);
$t->is(count($unallocatedAdjudicators), 1, '-> correct number of unallocated adjudicators returned.');
$t->is($unallocatedAdjudicators[0]->getName(), 'smu_adjudicator1', '-> correct unallocated adjudicator returned');

AdjudicatorAllocationPeer::createAdjudicatorAllocation(
  $debate->getId(), 
  AdjudicatorPeer::retrieveByName("smu_adjudicator1", $con)->getId(),
  AdjudicatorAllocation::ADJUDICATOR_TYPE_PANELIST)->save($con);

$t->diag("Checking with two allocations");
$t->is(count(AdjudicatorPeer::getUnallocatedAdjudicators($debate->getRound($con), $con)), 0, '-> correct number of unallocated adjudicators returned.');

$con->rollback();
