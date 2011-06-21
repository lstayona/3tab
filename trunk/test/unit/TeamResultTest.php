<?php
require_once(dirname(__FILE__).'/../bootstrap/unit.php');
define('SF_APP',         '3tab');
define('SF_ENVIRONMENT', 'dev');
define('SF_DEBUG',       true);

require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');

sfContext::getInstance();

$t = new lime_test(91, new lime_output_color());

$con = Propel::getConnection();
$con->begin();
$t->diag("Check that without results, the team_results table is empty.");
$t->is(TeamResultPeer::doCount(new Criteria(), false, $con), 0, "-> verified team_results view is empty.");
/*
 * Test data scenario:
 * Debate 1: 
 *   MMU A vs FOO A 
 *   Winner: MMU A
 *   Adjudicator: bar_adjudicator1
 */
$t->diag("Checking for single chair with an affirmative win");
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

$t->is(TeamResultPeer::doCount(new Criteria(), false, $con), 2, "-> verified team_results view has 2 entries.");
$t->is($debate->getDebateTeamXref(DebateTeamXref::AFFIRMATIVE, $con)->getTeam($con)->getName(), "MMU A", "-> verified team in affirmative");
$affirmativeTeamResult = $debate->getDebateTeamXref(DebateTeamXref::AFFIRMATIVE, $con)->getTeamResult($con);
$t->is($affirmativeTeamResult->getDebateTeamXrefRelatedByDebateTeamXrefId($con)->getTeam($con)->getName(), "MMU A", '-> verified correct team in result entry');
$t->is($affirmativeTeamResult->getTeamVoteCount(), 1, "-> correct vote count returned");
$t->is($affirmativeTeamResult->getDebateTeamXrefRelatedByOpponentDebateTeamXrefId($con)->getTeam($con)->getName(), "FOO A", "-> verified correct opposing team in result entry");
$t->is($affirmativeTeamResult->getOpponentTeamVoteCount(), 0, "-> correct opposing vote count returned");
$t->is($affirmativeTeamResult->getMajorityTeamScore(), 1, "-> correct majority team score returned");
$t->is($affirmativeTeamResult->getDebateTeamXrefRelatedByWinningDebateTeamXrefId($con)->getTeam($con)->getName(), "MMU A", "-> verified correct winning team in result entry");
$t->is($debate->getDebateTeamXref(DebateTeamXref::NEGATIVE, $con)->getTeam($con)->getName(), "FOO A", "-> verified team in negative");
$negativeTeamResult = $debate->getDebateTeamXref(DebateTeamXref::NEGATIVE, $con)->getTeamResult($con);
$t->is($negativeTeamResult->getDebateTeamXrefRelatedByDebateTeamXrefId($con)->getTeam($con)->getName(), "FOO A", '-> verified correct team in result entry');
$t->is($negativeTeamResult->getTeamVoteCount(), 0, "-> correct vote count returned");
$t->is($negativeTeamResult->getDebateTeamXrefRelatedByOpponentDebateTeamXrefId($con)->getTeam($con)->getName(), "MMU A", "-> verified correct opposing team in result entry");
$t->is($negativeTeamResult->getOpponentTeamVoteCount(), 1, "-> correct opposing vote count returned");
$t->is($negativeTeamResult->getMajorityTeamScore(), 0, "-> correct majority team score returned");
$t->is($negativeTeamResult->getDebateTeamXrefRelatedByWinningDebateTeamXrefId($con)->getTeam($con)->getName(), "MMU A", "-> verified correct winning team in result entry");

/*
 * Debate 2: 
 *   BAR A vs SHIT A
 *   Winner: SHIT A
 *   Adjudicator: ntu_adjudicator1 
 */
$t->diag("Checking for single chair with an negative win");
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

$t->is(TeamResultPeer::doCount(new Criteria(), false, $con), 4, "-> verified team_results view has 4 entries.");
$t->is($debate->getDebateTeamXref(DebateTeamXref::AFFIRMATIVE, $con)->getTeam($con)->getName(), "BAR A", "-> verified team in affirmative");
$affirmativeTeamResult = $debate->getDebateTeamXref(DebateTeamXref::AFFIRMATIVE, $con)->getTeamResult($con);
$t->is($affirmativeTeamResult->getDebateTeamXrefRelatedByDebateTeamXrefId($con)->getTeam($con)->getName(), "BAR A", '-> verified correct team in result entry');
$t->is($affirmativeTeamResult->getTeamVoteCount(), 0, "-> correct vote count returned");
$t->is($affirmativeTeamResult->getDebateTeamXrefRelatedByOpponentDebateTeamXrefId($con)->getTeam($con)->getName(), "SHIT A", "-> verified correct opposing team in result entry");
$t->is($affirmativeTeamResult->getOpponentTeamVoteCount(), 1, "-> correct opposing vote count returned");
$t->is($affirmativeTeamResult->getMajorityTeamScore(), 0, "-> correct majority team score returned");
$t->is($affirmativeTeamResult->getDebateTeamXrefRelatedByWinningDebateTeamXrefId($con)->getTeam($con)->getName(), "SHIT A", "-> verified correct winning team in result entry");
$t->is($debate->getDebateTeamXref(DebateTeamXref::NEGATIVE, $con)->getTeam($con)->getName(), "SHIT A", "-> verified team in negative");
$negativeTeamResult = $debate->getDebateTeamXref(DebateTeamXref::NEGATIVE, $con)->getTeamResult($con);
$t->is($negativeTeamResult->getDebateTeamXrefRelatedByDebateTeamXrefId($con)->getTeam($con)->getName(), "SHIT A", '-> verified correct team in result entry');
$t->is($negativeTeamResult->getTeamVoteCount(), 1, "-> correct vote count returned");
$t->is($negativeTeamResult->getDebateTeamXrefRelatedByOpponentDebateTeamXrefId($con)->getTeam($con)->getName(), "BAR A", "-> verified correct opposing team in result entry");
$t->is($negativeTeamResult->getOpponentTeamVoteCount(), 0, "-> correct opposing vote count returned");
$t->is($negativeTeamResult->getMajorityTeamScore(), 1, "-> correct majority team score returned");
$t->is($negativeTeamResult->getDebateTeamXrefRelatedByWinningDebateTeamXrefId($con)->getTeam($con)->getName(), "SHIT A", "-> verified correct winning team in result entry");

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

$t->is(TeamResultPeer::doCount(new Criteria(), false, $con), 6, "-> verified team_results view has 6 entries.");
$t->is($debate->getDebateTeamXref(DebateTeamXref::AFFIRMATIVE, $con)->getTeam($con)->getName(), "SWING A", "-> verified team in affirmative");
$affirmativeTeamResult = $debate->getDebateTeamXref(DebateTeamXref::AFFIRMATIVE, $con)->getTeamResult($con);
$t->is($affirmativeTeamResult->getDebateTeamXrefRelatedByDebateTeamXrefId($con)->getTeam($con)->getName(), "SWING A", '-> verified correct team in result entry');
$t->is($affirmativeTeamResult->getTeamVoteCount(), 2, "-> correct vote count returned");
$t->is($affirmativeTeamResult->getDebateTeamXrefRelatedByOpponentDebateTeamXrefId($con)->getTeam($con)->getName(), "IIU A", "-> verified correct opposing team in result entry");
$t->is($affirmativeTeamResult->getOpponentTeamVoteCount(), 1, "-> correct opposing vote count returned");
$t->is($affirmativeTeamResult->getMajorityTeamScore(), 1, "-> correct majority team score returned");
$t->is($affirmativeTeamResult->getDebateTeamXrefRelatedByWinningDebateTeamXrefId($con)->getTeam($con)->getName(), "SWING A", "-> verified correct winning team in result entry");
$t->is($debate->getDebateTeamXref(DebateTeamXref::NEGATIVE, $con)->getTeam($con)->getName(), "IIU A", "-> verified team in negative");
$negativeTeamResult = $debate->getDebateTeamXref(DebateTeamXref::NEGATIVE, $con)->getTeamResult($con);
$t->is($negativeTeamResult->getDebateTeamXrefRelatedByDebateTeamXrefId($con)->getTeam($con)->getName(), "IIU A", '-> verified correct team in result entry');
$t->is($negativeTeamResult->getTeamVoteCount(), 1, "-> correct vote count returned");
$t->is($negativeTeamResult->getDebateTeamXrefRelatedByOpponentDebateTeamXrefId($con)->getTeam($con)->getName(), "SWING A", "-> verified correct opposing team in result entry");
$t->is($negativeTeamResult->getOpponentTeamVoteCount(), 2, "-> correct opposing vote count returned");
$t->is($negativeTeamResult->getMajorityTeamScore(), 0, "-> correct majority team score returned");
$t->is($negativeTeamResult->getDebateTeamXrefRelatedByWinningDebateTeamXrefId($con)->getTeam($con)->getName(), "SWING A", "-> verified correct winning team in result entry");

/*
 * Debate 4: 
 *   NTU A vs SMU A
 *   Winner: SMU A
 *   Adjudicators:
 *     Majority: iiu_adjudicator1, uitm_adjudicator1 
 *     Minority: gab_adjudicator2
 */
$t->diag("Checking for panel and a split decision for a negative win");
$debate = DebatePeer::createDebate(
  TeamPeer::retrieveByName("NTU A", $con)->getId(), 
  TeamPeer::retrieveByName("SMU A", $con)->getId(), 
  VenuePeer::retrieveByName("Venue 5", $con));
$debate->setRound(RoundPeer::retrieveByName("Round 1", $con));
$debate->save($con);

$allocation = AdjudicatorAllocationPeer::createAdjudicatorAllocation(
  $debate->getId(), 
  AdjudicatorPeer::retrieveByName("gab_adjudicator2", $con)->getId(),
  AdjudicatorAllocation::ADJUDICATOR_TYPE_CHAIR);
$allocation->save($con);
TeamScoreSheetPeer::createTeamScoreSheet($allocation->getId(), $debate->getDebateTeamXref(DebateTeamXref::AFFIRMATIVE, $con)->getId(), 1)->save($con);
TeamScoreSheetPeer::createTeamScoreSheet($allocation->getId(), $debate->getDebateTeamXref(DebateTeamXref::NEGATIVE, $con)->getId(), 0)->save($con);

$allocation = AdjudicatorAllocationPeer::createAdjudicatorAllocation(
  $debate->getId(), 
  AdjudicatorPeer::retrieveByName("iiu_adjudicator1", $con)->getId(),
  AdjudicatorAllocation::ADJUDICATOR_TYPE_PANELIST);
$allocation->save($con);
TeamScoreSheetPeer::createTeamScoreSheet($allocation->getId(), $debate->getDebateTeamXref(DebateTeamXref::AFFIRMATIVE, $con)->getId(), 0)->save($con);
TeamScoreSheetPeer::createTeamScoreSheet($allocation->getId(), $debate->getDebateTeamXref(DebateTeamXref::NEGATIVE, $con)->getId(), 1)->save($con);

$allocation = AdjudicatorAllocationPeer::createAdjudicatorAllocation(
  $debate->getId(), 
  AdjudicatorPeer::retrieveByName("uitm_adjudicator1", $con)->getId(),
  AdjudicatorAllocation::ADJUDICATOR_TYPE_PANELIST);
$allocation->save($con);
TeamScoreSheetPeer::createTeamScoreSheet($allocation->getId(), $debate->getDebateTeamXref(DebateTeamXref::AFFIRMATIVE, $con)->getId(), 0)->save($con);
TeamScoreSheetPeer::createTeamScoreSheet($allocation->getId(), $debate->getDebateTeamXref(DebateTeamXref::NEGATIVE, $con)->getId(), 1)->save($con);

$t->is(TeamResultPeer::doCount(new Criteria(), false, $con), 8, "-> verified team_results view has 8 entries.");
$t->is($debate->getDebateTeamXref(DebateTeamXref::AFFIRMATIVE, $con)->getTeam($con)->getName(), "NTU A", "-> verified team in affirmative");
$affirmativeTeamResult = $debate->getDebateTeamXref(DebateTeamXref::AFFIRMATIVE, $con)->getTeamResult($con);
$t->is($affirmativeTeamResult->getDebateTeamXrefRelatedByDebateTeamXrefId($con)->getTeam($con)->getName(), "NTU A", '-> verified correct team in result entry');
$t->is($affirmativeTeamResult->getTeamVoteCount(), 1, "-> correct vote count returned");
$t->is($affirmativeTeamResult->getDebateTeamXrefRelatedByOpponentDebateTeamXrefId($con)->getTeam($con)->getName(), "SMU A", "-> verified correct opposing team in result entry");
$t->is($affirmativeTeamResult->getOpponentTeamVoteCount(), 2, "-> correct opposing vote count returned");
$t->is($affirmativeTeamResult->getMajorityTeamScore(), 0, "-> correct majority team score returned");
$t->is($affirmativeTeamResult->getDebateTeamXrefRelatedByWinningDebateTeamXrefId($con)->getTeam($con)->getName(), "SMU A", "-> verified correct winning team in result entry");
$t->is($debate->getDebateTeamXref(DebateTeamXref::NEGATIVE, $con)->getTeam($con)->getName(), "SMU A", "-> verified team in negative");
$negativeTeamResult = $debate->getDebateTeamXref(DebateTeamXref::NEGATIVE, $con)->getTeamResult($con);
$t->is($negativeTeamResult->getDebateTeamXrefRelatedByDebateTeamXrefId($con)->getTeam($con)->getName(), "SMU A", '-> verified correct team in result entry');
$t->is($negativeTeamResult->getTeamVoteCount(), 2, "-> correct vote count returned");
$t->is($negativeTeamResult->getDebateTeamXrefRelatedByOpponentDebateTeamXrefId($con)->getTeam($con)->getName(), "NTU A", "-> verified correct opposing team in result entry");
$t->is($negativeTeamResult->getOpponentTeamVoteCount(), 1, "-> correct opposing vote count returned");
$t->is($negativeTeamResult->getMajorityTeamScore(), 1, "-> correct majority team score returned");
$t->is($negativeTeamResult->getDebateTeamXrefRelatedByWinningDebateTeamXrefId($con)->getTeam($con)->getName(), "SMU A", "-> verified correct winning team in result entry");

/*
 * Debate 5: 
 *   UITM A vs TEE A
 *   Winner: UITM A
 *   Adjudicators:
 *     Majority: tee_adjudicator1, hyc_adjudicator1,fcc_adjudicator2 
 */
$t->diag("Checking for panel and an unanimous decision for an affirmative win");
$debate = DebatePeer::createDebate(
  TeamPeer::retrieveByName("UITM A", $con)->getId(), 
  TeamPeer::retrieveByName("TEE A", $con)->getId(), 
  VenuePeer::retrieveByName("Venue 6", $con));
$debate->setRound(RoundPeer::retrieveByName("Round 1", $con));
$debate->save($con);

$allocation = AdjudicatorAllocationPeer::createAdjudicatorAllocation(
  $debate->getId(), 
  AdjudicatorPeer::retrieveByName("tee_adjudicator1", $con)->getId(),
  AdjudicatorAllocation::ADJUDICATOR_TYPE_CHAIR);
$allocation->save($con);
TeamScoreSheetPeer::createTeamScoreSheet($allocation->getId(), $debate->getDebateTeamXref(DebateTeamXref::AFFIRMATIVE, $con)->getId(), 1)->save($con);
TeamScoreSheetPeer::createTeamScoreSheet($allocation->getId(), $debate->getDebateTeamXref(DebateTeamXref::NEGATIVE, $con)->getId(), 0)->save($con);

$allocation = AdjudicatorAllocationPeer::createAdjudicatorAllocation(
  $debate->getId(), 
  AdjudicatorPeer::retrieveByName("hyc_adjudicator1", $con)->getId(),
  AdjudicatorAllocation::ADJUDICATOR_TYPE_PANELIST);
$allocation->save($con);
TeamScoreSheetPeer::createTeamScoreSheet($allocation->getId(), $debate->getDebateTeamXref(DebateTeamXref::AFFIRMATIVE, $con)->getId(), 1)->save($con);
TeamScoreSheetPeer::createTeamScoreSheet($allocation->getId(), $debate->getDebateTeamXref(DebateTeamXref::NEGATIVE, $con)->getId(), 0)->save($con);

$allocation = AdjudicatorAllocationPeer::createAdjudicatorAllocation(
  $debate->getId(), 
  AdjudicatorPeer::retrieveByName("fcc_adjudicator2", $con)->getId(),
  AdjudicatorAllocation::ADJUDICATOR_TYPE_PANELIST);
$allocation->save($con);
TeamScoreSheetPeer::createTeamScoreSheet($allocation->getId(), $debate->getDebateTeamXref(DebateTeamXref::AFFIRMATIVE, $con)->getId(), 1)->save($con);
TeamScoreSheetPeer::createTeamScoreSheet($allocation->getId(), $debate->getDebateTeamXref(DebateTeamXref::NEGATIVE, $con)->getId(), 0)->save($con);

$t->is(TeamResultPeer::doCount(new Criteria(), false, $con), 10, "-> verified team_results view has 10 entries.");
$t->is($debate->getDebateTeamXref(DebateTeamXref::AFFIRMATIVE, $con)->getTeam($con)->getName(), "UITM A", "-> verified team in affirmative");
$affirmativeTeamResult = $debate->getDebateTeamXref(DebateTeamXref::AFFIRMATIVE, $con)->getTeamResult($con);
$t->is($affirmativeTeamResult->getDebateTeamXrefRelatedByDebateTeamXrefId($con)->getTeam($con)->getName(), "UITM A", '-> verified correct team in result entry');
$t->is($affirmativeTeamResult->getTeamVoteCount(), 3, "-> correct vote count returned");
$t->is($affirmativeTeamResult->getDebateTeamXrefRelatedByOpponentDebateTeamXrefId($con)->getTeam($con)->getName(), "TEE A", "-> verified correct opposing team in result entry");
$t->is($affirmativeTeamResult->getOpponentTeamVoteCount(), 0, "-> correct opposing vote count returned");
$t->is($affirmativeTeamResult->getMajorityTeamScore(), 1, "-> correct majority team score returned");
$t->is($affirmativeTeamResult->getDebateTeamXrefRelatedByWinningDebateTeamXrefId($con)->getTeam($con)->getName(), "UITM A", "-> verified correct winning team in result entry");
$t->is($debate->getDebateTeamXref(DebateTeamXref::NEGATIVE, $con)->getTeam($con)->getName(), "TEE A", "-> verified team in negative");
$negativeTeamResult = $debate->getDebateTeamXref(DebateTeamXref::NEGATIVE, $con)->getTeamResult($con);
$t->is($negativeTeamResult->getDebateTeamXrefRelatedByDebateTeamXrefId($con)->getTeam($con)->getName(), "TEE A", '-> verified correct team in result entry');
$t->is($negativeTeamResult->getTeamVoteCount(), 0, "-> correct vote count returned");
$t->is($negativeTeamResult->getDebateTeamXrefRelatedByOpponentDebateTeamXrefId($con)->getTeam($con)->getName(), "UITM A", "-> verified correct opposing team in result entry");
$t->is($negativeTeamResult->getOpponentTeamVoteCount(), 3, "-> correct opposing vote count returned");
$t->is($negativeTeamResult->getMajorityTeamScore(), 0, "-> correct majority team score returned");
$t->is($negativeTeamResult->getDebateTeamXrefRelatedByWinningDebateTeamXrefId($con)->getTeam($con)->getName(), "UITM A", "-> verified correct winning team in result entry");

/*
 * Debate 6: 
 *   MMU B vs SAB A
 *   Winner: SAB A
 *   Adjudicators:
 *     Majority: gsc_adjudicator1, fcc_adjudicator1, iiu_adjudicator2  
 */
$t->diag("Checking for panel and an unanimous decision for a negative win");
$debate = DebatePeer::createDebate(
  TeamPeer::retrieveByName("MMU B", $con)->getId(), 
  TeamPeer::retrieveByName("SAB A", $con)->getId(), 
  VenuePeer::retrieveByName("Venue 7", $con));
$debate->setRound(RoundPeer::retrieveByName("Round 1", $con));
$debate->save($con);

$allocation = AdjudicatorAllocationPeer::createAdjudicatorAllocation(
  $debate->getId(), 
  AdjudicatorPeer::retrieveByName("gsc_adjudicator1", $con)->getId(),
  AdjudicatorAllocation::ADJUDICATOR_TYPE_CHAIR);
$allocation->save($con);
TeamScoreSheetPeer::createTeamScoreSheet($allocation->getId(), $debate->getDebateTeamXref(DebateTeamXref::AFFIRMATIVE, $con)->getId(), 0)->save($con);
TeamScoreSheetPeer::createTeamScoreSheet($allocation->getId(), $debate->getDebateTeamXref(DebateTeamXref::NEGATIVE, $con)->getId(), 1)->save($con);

$allocation = AdjudicatorAllocationPeer::createAdjudicatorAllocation(
  $debate->getId(), 
  AdjudicatorPeer::retrieveByName("fcc_adjudicator1", $con)->getId(),
  AdjudicatorAllocation::ADJUDICATOR_TYPE_PANELIST);
$allocation->save($con);
TeamScoreSheetPeer::createTeamScoreSheet($allocation->getId(), $debate->getDebateTeamXref(DebateTeamXref::AFFIRMATIVE, $con)->getId(), 0)->save($con);
TeamScoreSheetPeer::createTeamScoreSheet($allocation->getId(), $debate->getDebateTeamXref(DebateTeamXref::NEGATIVE, $con)->getId(), 1)->save($con);

$allocation = AdjudicatorAllocationPeer::createAdjudicatorAllocation(
  $debate->getId(), 
  AdjudicatorPeer::retrieveByName("iiu_adjudicator2", $con)->getId(),
  AdjudicatorAllocation::ADJUDICATOR_TYPE_PANELIST);
$allocation->save($con);
TeamScoreSheetPeer::createTeamScoreSheet($allocation->getId(), $debate->getDebateTeamXref(DebateTeamXref::AFFIRMATIVE, $con)->getId(), 0)->save($con);
TeamScoreSheetPeer::createTeamScoreSheet($allocation->getId(), $debate->getDebateTeamXref(DebateTeamXref::NEGATIVE, $con)->getId(), 1)->save($con);

$t->is(TeamResultPeer::doCount(new Criteria(), false, $con), 12, "-> verified team_results view has 12 entries.");
$t->is($debate->getDebateTeamXref(DebateTeamXref::AFFIRMATIVE, $con)->getTeam($con)->getName(), "MMU B", "-> verified team in affirmative");
$affirmativeTeamResult = $debate->getDebateTeamXref(DebateTeamXref::AFFIRMATIVE, $con)->getTeamResult($con);
$t->is($affirmativeTeamResult->getDebateTeamXrefRelatedByDebateTeamXrefId($con)->getTeam($con)->getName(), "MMU B", '-> verified correct team in result entry');
$t->is($affirmativeTeamResult->getTeamVoteCount(), 0, "-> correct vote count returned");
$t->is($affirmativeTeamResult->getDebateTeamXrefRelatedByOpponentDebateTeamXrefId($con)->getTeam($con)->getName(), "SAB A", "-> verified correct opposing team in result entry");
$t->is($affirmativeTeamResult->getOpponentTeamVoteCount(), 3, "-> correct opposing vote count returned");
$t->is($affirmativeTeamResult->getMajorityTeamScore(), 0, "-> correct majority team score returned");
$t->is($affirmativeTeamResult->getDebateTeamXrefRelatedByWinningDebateTeamXrefId($con)->getTeam($con)->getName(), "SAB A", "-> verified correct winning team in result entry");
$t->is($debate->getDebateTeamXref(DebateTeamXref::NEGATIVE, $con)->getTeam($con)->getName(), "SAB A", "-> verified team in negative");
$negativeTeamResult = $debate->getDebateTeamXref(DebateTeamXref::NEGATIVE, $con)->getTeamResult($con);
$t->is($negativeTeamResult->getDebateTeamXrefRelatedByDebateTeamXrefId($con)->getTeam($con)->getName(), "SAB A", '-> verified correct team in result entry');
$t->is($negativeTeamResult->getTeamVoteCount(), 3, "-> correct vote count returned");
$t->is($negativeTeamResult->getDebateTeamXrefRelatedByOpponentDebateTeamXrefId($con)->getTeam($con)->getName(), "MMU B", "-> verified correct opposing team in result entry");
$t->is($negativeTeamResult->getOpponentTeamVoteCount(), 0, "-> correct opposing vote count returned");
$t->is($negativeTeamResult->getMajorityTeamScore(), 1, "-> correct majority team score returned");
$t->is($negativeTeamResult->getDebateTeamXrefRelatedByWinningDebateTeamXrefId($con)->getTeam($con)->getName(), "SAB A", "-> verified correct winning team in result entry");

$con->rollback();
