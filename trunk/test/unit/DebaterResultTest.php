<?php
require_once(dirname(__FILE__).'/../bootstrap/unit.php');
define('SF_APP',         '3tab');
define('SF_ENVIRONMENT', 'dev');
define('SF_DEBUG',       true);

require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');

sfContext::getInstance();

$t = new lime_test(28, new lime_output_color());

$con = Propel::getConnection();
$con->begin();
$t->diag("Check that without results, the debater_results table is empty.");
$t->is(DebaterResultPeer::doCount(new Criteria(), false, $con), 0, "-> verified debater_results view is empty.");
/*
 * Test data scenario:
 * Debate 1: 
 *   MMU A vs FOO A 
 *   Winner: MMU A
 *   Adjudicator: bar_adjudicator1
 *     Scores:
 *       mmu_a_speaker1: 77
 *       mmu_a_speaker2: 76
 *       mmu_a_speaker3: 77
 *       mmu_a_speaker2-reply: 38
 *
 *       foo_a_speaker2: 75
 *       foo_a_speaker3: 76
 *       foo_a_speaker1: 77
 *       foo_a_speaker3-reply: 37.5
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
$affirmativeDebateTeamXref = $debate->getDebateTeamXref(DebateTeamXref::AFFIRMATIVE, $con);
TeamScoreSheetPeer::createTeamScoreSheet($allocation->getId(), $affirmativeDebateTeamXref->getId(), 1)->save($con);
SpeakerScoreSheetPeer::createSpeakerScoreSheet(
  $allocation->getId(), $affirmativeDebateTeamXref->getId(), 
  DebaterPeer::retrieveByName('mmu_a_speaker1', $con)->getId(),
  77, SpeakerScoreSheet::FIRST_SPEAKER)->save($con);
SpeakerScoreSheetPeer::createSpeakerScoreSheet(
  $allocation->getId(), $affirmativeDebateTeamXref->getId(), 
  DebaterPeer::retrieveByName('mmu_a_speaker2', $con)->getId(),
  76, SpeakerScoreSheet::SECOND_SPEAKER)->save($con);
SpeakerScoreSheetPeer::createSpeakerScoreSheet(
  $allocation->getId(), $affirmativeDebateTeamXref->getId(), 
  DebaterPeer::retrieveByName('mmu_a_speaker3', $con)->getId(),
  77, SpeakerScoreSheet::THIRD_SPEAKER)->save($con);
SpeakerScoreSheetPeer::createSpeakerScoreSheet(
  $allocation->getId(), $affirmativeDebateTeamXref->getId(), 
  DebaterPeer::retrieveByName('mmu_a_speaker2', $con)->getId(),
  38, SpeakerScoreSheet::REPLY_SPEAKER)->save($con);
$negativeDebateTeamXref = $debate->getDebateTeamXref(DebateTeamXref::NEGATIVE, $con);
TeamScoreSheetPeer::createTeamScoreSheet($allocation->getId(), $negativeDebateTeamXref->getId(), 0)->save($con);
SpeakerScoreSheetPeer::createSpeakerScoreSheet(
  $allocation->getId(), $negativeDebateTeamXref->getId(), 
  DebaterPeer::retrieveByName('foo_a_speaker2', $con)->getId(),
  75, SpeakerScoreSheet::FIRST_SPEAKER)->save($con);
SpeakerScoreSheetPeer::createSpeakerScoreSheet(
  $allocation->getId(), $negativeDebateTeamXref->getId(), 
  DebaterPeer::retrieveByName('foo_a_speaker3', $con)->getId(),
  76, SpeakerScoreSheet::SECOND_SPEAKER)->save($con);
SpeakerScoreSheetPeer::createSpeakerScoreSheet(
  $allocation->getId(), $negativeDebateTeamXref->getId(), 
  DebaterPeer::retrieveByName('foo_a_speaker1', $con)->getId(),
  77, SpeakerScoreSheet::THIRD_SPEAKER)->save($con);
SpeakerScoreSheetPeer::createSpeakerScoreSheet(
  $allocation->getId(), $negativeDebateTeamXref->getId(), 
  DebaterPeer::retrieveByName('foo_a_speaker3', $con)->getId(),
  37.5, SpeakerScoreSheet::REPLY_SPEAKER)->save($con);

$t->is(DebaterResultPeer::doCount(new Criteria(), false, $con), 8, "-> verified debater_results has 8 entries.");
$t->is(DebaterPeer::retrieveByName("mmu_a_speaker1", $con)->getDebaterResult($affirmativeDebateTeamXref->getId(), SpeakerScoreSheet::FIRST_SPEAKER, $con)->getAveragedScore(), 77, "-> correct score returned first affirmative speaker");
$t->is(DebaterPeer::retrieveByName("mmu_a_speaker2", $con)->getDebaterResult($affirmativeDebateTeamXref->getId(), SpeakerScoreSheet::SECOND_SPEAKER, $con)->getAveragedScore(), 76, "-> correct score returned second affirmative speaker");
$t->is(DebaterPeer::retrieveByName("mmu_a_speaker3", $con)->getDebaterResult($affirmativeDebateTeamXref->getId(), SpeakerScoreSheet::THIRD_SPEAKER, $con)->getAveragedScore(), 77, "-> correct score returned third affirmative speaker");
$t->is(DebaterPeer::retrieveByName("mmu_a_speaker2", $con)->getDebaterResult($affirmativeDebateTeamXref->getId(), SpeakerScoreSheet::REPLY_SPEAKER, $con)->getAveragedScore(), 38, "-> correct score returned reply affirmative speaker");
$t->is(DebaterPeer::retrieveByName("foo_a_speaker2", $con)->getDebaterResult($negativeDebateTeamXref->getId(), SpeakerScoreSheet::FIRST_SPEAKER, $con)->getAveragedScore(), 75, "-> correct score returned first negative speaker");
$t->is(DebaterPeer::retrieveByName("foo_a_speaker3", $con)->getDebaterResult($negativeDebateTeamXref->getId(), SpeakerScoreSheet::SECOND_SPEAKER, $con)->getAveragedScore(), 76, "-> correct score returned second negative speaker");
$t->is(DebaterPeer::retrieveByName("foo_a_speaker1", $con)->getDebaterResult($negativeDebateTeamXref->getId(), SpeakerScoreSheet::THIRD_SPEAKER, $con)->getAveragedScore(), 77, "-> correct score returned third negative speaker");
$t->is(DebaterPeer::retrieveByName("foo_a_speaker3", $con)->getDebaterResult($negativeDebateTeamXref->getId(), SpeakerScoreSheet::REPLY_SPEAKER, $con)->getAveragedScore(), 37.5, "-> correct score returned reply negative speaker");

/*
 * Test data scenario:
 * Debate 2: 
 *   SWING A vs IIU A 
 *   Winner: SWING A
 *   Adjudicator: mmu_adjudicator1
 *     Scores:
 *       swing_a_speaker1: 77
 *       swing_a_speaker3: 76
 *       swing_a_speaker2: 77
 *       swing_a_speaker3-reply: 38
 *
 *       iiu_a_speaker2: 75
 *       iiu_a_speaker1: 76
 *       iiu_a_speaker3: 77
 *       iiu_a_speaker2-reply: 37.5
 *   Adjudicator: ntu_adjudicator2
 *     Scores:
 *       swing_a_speaker1: 76
 *       swing_a_speaker3: 75
 *       swing_a_speaker2: 75
 *       swing_a_speaker3-reply: 37.5
 *
 *       iiu_a_speaker2: 75
 *       iiu_a_speaker1: 74
 *       iiu_a_speaker3: 75
 *       iiu_a_speaker2-reply: 37
 *   Adjudicator: smu_adjudicator1
 *     Scores:
 *       swing_a_speaker1: 76
 *       swing_a_speaker3: 76
 *       swing_a_speaker2: 77
 *       swing_a_speaker3-reply: 38
 *
 *       iiu_a_speaker2: 77
 *       iiu_a_speaker1: 77
 *       iiu_a_speaker3: 78
 *       iiu_a_speaker2-reply: 37.5
 */
$t->diag("Checking for 3-person panel and an affirmative win on a split decision");
$debate = DebatePeer::createDebate(
  TeamPeer::retrieveByName("SWING A", $con)->getId(), 
  TeamPeer::retrieveByName("IIU A", $con)->getId(), 
  VenuePeer::retrieveByName("Venue 4", $con));
$debate->setRound(RoundPeer::retrieveByName("Round 1", $con));
$debate->save($con);

$affirmativeDebateTeamXref = $debate->getDebateTeamXref(DebateTeamXref::AFFIRMATIVE, $con);
$negativeDebateTeamXref = $debate->getDebateTeamXref(DebateTeamXref::NEGATIVE, $con);

$allocation = AdjudicatorAllocationPeer::createAdjudicatorAllocation(
  $debate->getId(), 
  AdjudicatorPeer::retrieveByName("mmu_adjudicator1", $con)->getId(),
  AdjudicatorAllocation::ADJUDICATOR_TYPE_CHAIR);
$allocation->save($con);
TeamScoreSheetPeer::createTeamScoreSheet($allocation->getId(), $affirmativeDebateTeamXref->getId(), 1)->save($con);
TeamScoreSheetPeer::createTeamScoreSheet($allocation->getId(), $negativeDebateTeamXref->getId(), 0)->save($con);
SpeakerScoreSheetPeer::createSpeakerScoreSheet(
  $allocation->getId(), $affirmativeDebateTeamXref->getId(), 
  DebaterPeer::retrieveByName('swing_a_speaker1', $con)->getId(),
  77, SpeakerScoreSheet::FIRST_SPEAKER)->save($con);
SpeakerScoreSheetPeer::createSpeakerScoreSheet(
  $allocation->getId(), $affirmativeDebateTeamXref->getId(), 
  DebaterPeer::retrieveByName('swing_a_speaker3', $con)->getId(),
  76, SpeakerScoreSheet::SECOND_SPEAKER)->save($con);
SpeakerScoreSheetPeer::createSpeakerScoreSheet(
  $allocation->getId(), $affirmativeDebateTeamXref->getId(), 
  DebaterPeer::retrieveByName('swing_a_speaker2', $con)->getId(),
  77, SpeakerScoreSheet::THIRD_SPEAKER)->save($con);
SpeakerScoreSheetPeer::createSpeakerScoreSheet(
  $allocation->getId(), $affirmativeDebateTeamXref->getId(), 
  DebaterPeer::retrieveByName('swing_a_speaker3', $con)->getId(),
  38, SpeakerScoreSheet::REPLY_SPEAKER)->save($con);
SpeakerScoreSheetPeer::createSpeakerScoreSheet(
  $allocation->getId(), $negativeDebateTeamXref->getId(), 
  DebaterPeer::retrieveByName('iiu_a_speaker2', $con)->getId(),
  75, SpeakerScoreSheet::FIRST_SPEAKER)->save($con);
SpeakerScoreSheetPeer::createSpeakerScoreSheet(
  $allocation->getId(), $negativeDebateTeamXref->getId(), 
  DebaterPeer::retrieveByName('iiu_a_speaker1', $con)->getId(),
  76, SpeakerScoreSheet::SECOND_SPEAKER)->save($con);
SpeakerScoreSheetPeer::createSpeakerScoreSheet(
  $allocation->getId(), $negativeDebateTeamXref->getId(), 
  DebaterPeer::retrieveByName('iiu_a_speaker3', $con)->getId(),
  77, SpeakerScoreSheet::THIRD_SPEAKER)->save($con);
SpeakerScoreSheetPeer::createSpeakerScoreSheet(
  $allocation->getId(), $negativeDebateTeamXref->getId(), 
  DebaterPeer::retrieveByName('iiu_a_speaker2', $con)->getId(),
  37.5, SpeakerScoreSheet::REPLY_SPEAKER)->save($con);

$allocation = AdjudicatorAllocationPeer::createAdjudicatorAllocation(
  $debate->getId(), 
  AdjudicatorPeer::retrieveByName("ntu_adjudicator2", $con)->getId(),
  AdjudicatorAllocation::ADJUDICATOR_TYPE_PANELIST);
$allocation->save($con);
TeamScoreSheetPeer::createTeamScoreSheet($allocation->getId(), $affirmativeDebateTeamXref->getId(), 1)->save($con);
TeamScoreSheetPeer::createTeamScoreSheet($allocation->getId(), $negativeDebateTeamXref->getId(), 0)->save($con);
SpeakerScoreSheetPeer::createSpeakerScoreSheet(
  $allocation->getId(), $affirmativeDebateTeamXref->getId(), 
  DebaterPeer::retrieveByName('swing_a_speaker1', $con)->getId(),
  76, SpeakerScoreSheet::FIRST_SPEAKER)->save($con);
SpeakerScoreSheetPeer::createSpeakerScoreSheet(
  $allocation->getId(), $affirmativeDebateTeamXref->getId(), 
  DebaterPeer::retrieveByName('swing_a_speaker3', $con)->getId(),
  75, SpeakerScoreSheet::SECOND_SPEAKER)->save($con);
SpeakerScoreSheetPeer::createSpeakerScoreSheet(
  $allocation->getId(), $affirmativeDebateTeamXref->getId(), 
  DebaterPeer::retrieveByName('swing_a_speaker2', $con)->getId(),
  75, SpeakerScoreSheet::THIRD_SPEAKER)->save($con);
SpeakerScoreSheetPeer::createSpeakerScoreSheet(
  $allocation->getId(), $affirmativeDebateTeamXref->getId(), 
  DebaterPeer::retrieveByName('swing_a_speaker3', $con)->getId(),
  37.5, SpeakerScoreSheet::REPLY_SPEAKER)->save($con);
SpeakerScoreSheetPeer::createSpeakerScoreSheet(
  $allocation->getId(), $negativeDebateTeamXref->getId(), 
  DebaterPeer::retrieveByName('iiu_a_speaker2', $con)->getId(),
  75, SpeakerScoreSheet::FIRST_SPEAKER)->save($con);
SpeakerScoreSheetPeer::createSpeakerScoreSheet(
  $allocation->getId(), $negativeDebateTeamXref->getId(), 
  DebaterPeer::retrieveByName('iiu_a_speaker1', $con)->getId(),
  74, SpeakerScoreSheet::SECOND_SPEAKER)->save($con);
SpeakerScoreSheetPeer::createSpeakerScoreSheet(
  $allocation->getId(), $negativeDebateTeamXref->getId(), 
  DebaterPeer::retrieveByName('iiu_a_speaker3', $con)->getId(),
  75, SpeakerScoreSheet::THIRD_SPEAKER)->save($con);
SpeakerScoreSheetPeer::createSpeakerScoreSheet(
  $allocation->getId(), $negativeDebateTeamXref->getId(), 
  DebaterPeer::retrieveByName('iiu_a_speaker2', $con)->getId(),
  37, SpeakerScoreSheet::REPLY_SPEAKER)->save($con);

$allocation = AdjudicatorAllocationPeer::createAdjudicatorAllocation(
  $debate->getId(), 
  AdjudicatorPeer::retrieveByName("smu_adjudicator1", $con)->getId(),
  AdjudicatorAllocation::ADJUDICATOR_TYPE_PANELIST);
$allocation->save($con);
TeamScoreSheetPeer::createTeamScoreSheet($allocation->getId(), $affirmativeDebateTeamXref->getId(), 0)->save($con);
TeamScoreSheetPeer::createTeamScoreSheet($allocation->getId(), $negativeDebateTeamXref->getId(), 1)->save($con);
SpeakerScoreSheetPeer::createSpeakerScoreSheet(
  $allocation->getId(), $affirmativeDebateTeamXref->getId(), 
  DebaterPeer::retrieveByName('swing_a_speaker1', $con)->getId(),
  76, SpeakerScoreSheet::FIRST_SPEAKER)->save($con);
SpeakerScoreSheetPeer::createSpeakerScoreSheet(
  $allocation->getId(), $affirmativeDebateTeamXref->getId(), 
  DebaterPeer::retrieveByName('swing_a_speaker3', $con)->getId(),
  76, SpeakerScoreSheet::SECOND_SPEAKER)->save($con);
SpeakerScoreSheetPeer::createSpeakerScoreSheet(
  $allocation->getId(), $affirmativeDebateTeamXref->getId(), 
  DebaterPeer::retrieveByName('swing_a_speaker2', $con)->getId(),
  77, SpeakerScoreSheet::THIRD_SPEAKER)->save($con);
SpeakerScoreSheetPeer::createSpeakerScoreSheet(
  $allocation->getId(), $affirmativeDebateTeamXref->getId(), 
  DebaterPeer::retrieveByName('swing_a_speaker3', $con)->getId(),
  38, SpeakerScoreSheet::REPLY_SPEAKER)->save($con);
SpeakerScoreSheetPeer::createSpeakerScoreSheet(
  $allocation->getId(), $negativeDebateTeamXref->getId(), 
  DebaterPeer::retrieveByName('iiu_a_speaker2', $con)->getId(),
  77, SpeakerScoreSheet::FIRST_SPEAKER)->save($con);
SpeakerScoreSheetPeer::createSpeakerScoreSheet(
  $allocation->getId(), $negativeDebateTeamXref->getId(), 
  DebaterPeer::retrieveByName('iiu_a_speaker1', $con)->getId(),
  77, SpeakerScoreSheet::SECOND_SPEAKER)->save($con);
SpeakerScoreSheetPeer::createSpeakerScoreSheet(
  $allocation->getId(), $negativeDebateTeamXref->getId(), 
  DebaterPeer::retrieveByName('iiu_a_speaker3', $con)->getId(),
  78, SpeakerScoreSheet::THIRD_SPEAKER)->save($con);
SpeakerScoreSheetPeer::createSpeakerScoreSheet(
  $allocation->getId(), $negativeDebateTeamXref->getId(), 
  DebaterPeer::retrieveByName('iiu_a_speaker2', $con)->getId(),
  37.5, SpeakerScoreSheet::REPLY_SPEAKER)->save($con);

$t->is(DebaterResultPeer::doCount(new Criteria(), false, $con), 16, "-> verified debater_results has 16 entries.");
$t->is(DebaterPeer::retrieveByName("swing_a_speaker1", $con)->getDebaterResult($affirmativeDebateTeamXref->getId(), SpeakerScoreSheet::FIRST_SPEAKER, $con)->getAveragedScore(), 76.5, "-> correct score returned first affirmative speaker");
$t->is(DebaterPeer::retrieveByName("swing_a_speaker3", $con)->getDebaterResult($affirmativeDebateTeamXref->getId(), SpeakerScoreSheet::SECOND_SPEAKER, $con)->getAveragedScore(), 75.5, "-> correct score returned second affirmative speaker");
$t->is(DebaterPeer::retrieveByName("swing_a_speaker2", $con)->getDebaterResult($affirmativeDebateTeamXref->getId(), SpeakerScoreSheet::THIRD_SPEAKER, $con)->getAveragedScore(), 76, "-> correct score returned third affirmative speaker");
$t->is(DebaterPeer::retrieveByName("swing_a_speaker3", $con)->getDebaterResult($affirmativeDebateTeamXref->getId(), SpeakerScoreSheet::REPLY_SPEAKER, $con)->getAveragedScore(), 37.75, "-> correct score returned reply affirmative speaker");
$t->is(DebaterPeer::retrieveByName("iiu_a_speaker2", $con)->getDebaterResult($negativeDebateTeamXref->getId(), SpeakerScoreSheet::FIRST_SPEAKER, $con)->getAveragedScore(), 75, "-> correct score returned first negative speaker");
$t->is(DebaterPeer::retrieveByName("iiu_a_speaker1", $con)->getDebaterResult($negativeDebateTeamXref->getId(), SpeakerScoreSheet::SECOND_SPEAKER, $con)->getAveragedScore(), 75, "-> correct score returned second negative speaker");
$t->is(DebaterPeer::retrieveByName("iiu_a_speaker3", $con)->getDebaterResult($negativeDebateTeamXref->getId(), SpeakerScoreSheet::THIRD_SPEAKER, $con)->getAveragedScore(), 76, "-> correct score returned third negative speaker");
$t->is(DebaterPeer::retrieveByName("iiu_a_speaker2", $con)->getDebaterResult($negativeDebateTeamXref->getId(), SpeakerScoreSheet::REPLY_SPEAKER, $con)->getAveragedScore(), 37.25, "-> correct score returned reply negative speaker");

/*
 * Debate 3: 
 *   MMU B vs SAB A
 *   Winner: SAB A
 *   Adjudicator: gsc_adjudicator1
 *     Scores:
 *       mmu_b_speaker1: 76
 *       mmu_b_speaker3: 76
 *       mmu_b_speaker2: 77
 *       mmu_b_speaker3-reply: 38
 *
 *       sab_a_speaker2: 77
 *       sab_a_speaker1: 77
 *       sab_a_speaker3: 77
 *       sab_a_speaker2-reply: 37.5
 *   Adjudicator: fcc_adjudicator1
 *     Scores:
 *       mmu_b_speaker1: 75
 *       mmu_b_speaker3: 76
 *       mmu_b_speaker2: 76
 *       mmu_b_speaker3-reply: 37.5
 *
 *       sab_a_speaker2: 77
 *       sab_a_speaker1: 76
 *       sab_a_speaker3: 76
 *       sab_a_speaker2-reply: 37
 *   Adjudicator: tee_adjudicator1
 *     Scores:
 *       mmu_b_speaker1: 76
 *       mmu_b_speaker3: 76
 *       mmu_b_speaker2: 77
 *       mmu_b_speaker3-reply: 38
 *
 *       sab_a_speaker2: 77
 *       sab_a_speaker1: 77
 *       sab_a_speaker3: 78
 *       sab_a_speaker2-reply: 37.5
 */
$t->diag("Checking for panel and an unanimous decision for a negative win");
$debate = DebatePeer::createDebate(
  TeamPeer::retrieveByName("MMU B", $con)->getId(), 
  TeamPeer::retrieveByName("SAB A", $con)->getId(), 
  VenuePeer::retrieveByName("Venue 7", $con));
$debate->setRound(RoundPeer::retrieveByName("Round 1", $con));
$debate->save($con);
$affirmativeDebateTeamXref = $debate->getDebateTeamXref(DebateTeamXref::AFFIRMATIVE, $con);
$negativeDebateTeamXref = $debate->getDebateTeamXref(DebateTeamXref::NEGATIVE, $con);

$allocation = AdjudicatorAllocationPeer::createAdjudicatorAllocation(
  $debate->getId(), 
  AdjudicatorPeer::retrieveByName("gsc_adjudicator1", $con)->getId(),
  AdjudicatorAllocation::ADJUDICATOR_TYPE_CHAIR);
$allocation->save($con);
TeamScoreSheetPeer::createTeamScoreSheet($allocation->getId(), $affirmativeDebateTeamXref->getId(), 1)->save($con);
TeamScoreSheetPeer::createTeamScoreSheet($allocation->getId(), $negativeDebateTeamXref->getId(), 0)->save($con);
SpeakerScoreSheetPeer::createSpeakerScoreSheet(
  $allocation->getId(), $affirmativeDebateTeamXref->getId(), 
  DebaterPeer::retrieveByName('mmu_b_speaker1', $con)->getId(),
  76, SpeakerScoreSheet::FIRST_SPEAKER)->save($con);
SpeakerScoreSheetPeer::createSpeakerScoreSheet(
  $allocation->getId(), $affirmativeDebateTeamXref->getId(), 
  DebaterPeer::retrieveByName('mmu_b_speaker3', $con)->getId(),
  76, SpeakerScoreSheet::SECOND_SPEAKER)->save($con);
SpeakerScoreSheetPeer::createSpeakerScoreSheet(
  $allocation->getId(), $affirmativeDebateTeamXref->getId(), 
  DebaterPeer::retrieveByName('mmu_b_speaker2', $con)->getId(),
  77, SpeakerScoreSheet::THIRD_SPEAKER)->save($con);
SpeakerScoreSheetPeer::createSpeakerScoreSheet(
  $allocation->getId(), $affirmativeDebateTeamXref->getId(), 
  DebaterPeer::retrieveByName('mmu_b_speaker3', $con)->getId(),
  38, SpeakerScoreSheet::REPLY_SPEAKER)->save($con);
SpeakerScoreSheetPeer::createSpeakerScoreSheet(
  $allocation->getId(), $negativeDebateTeamXref->getId(), 
  DebaterPeer::retrieveByName('sab_a_speaker2', $con)->getId(),
  77, SpeakerScoreSheet::FIRST_SPEAKER)->save($con);
SpeakerScoreSheetPeer::createSpeakerScoreSheet(
  $allocation->getId(), $negativeDebateTeamXref->getId(), 
  DebaterPeer::retrieveByName('sab_a_speaker1', $con)->getId(),
  77, SpeakerScoreSheet::SECOND_SPEAKER)->save($con);
SpeakerScoreSheetPeer::createSpeakerScoreSheet(
  $allocation->getId(), $negativeDebateTeamXref->getId(), 
  DebaterPeer::retrieveByName('sab_a_speaker3', $con)->getId(),
  77, SpeakerScoreSheet::THIRD_SPEAKER)->save($con);
SpeakerScoreSheetPeer::createSpeakerScoreSheet(
  $allocation->getId(), $negativeDebateTeamXref->getId(), 
  DebaterPeer::retrieveByName('sab_a_speaker2', $con)->getId(),
  37.5, SpeakerScoreSheet::REPLY_SPEAKER)->save($con);

$allocation = AdjudicatorAllocationPeer::createAdjudicatorAllocation(
  $debate->getId(), 
  AdjudicatorPeer::retrieveByName("fcc_adjudicator1", $con)->getId(),
  AdjudicatorAllocation::ADJUDICATOR_TYPE_PANELIST);
$allocation->save($con);
TeamScoreSheetPeer::createTeamScoreSheet($allocation->getId(), $affirmativeDebateTeamXref->getId(), 1)->save($con);
TeamScoreSheetPeer::createTeamScoreSheet($allocation->getId(), $negativeDebateTeamXref->getId(), 0)->save($con);
SpeakerScoreSheetPeer::createSpeakerScoreSheet(
  $allocation->getId(), $affirmativeDebateTeamXref->getId(), 
  DebaterPeer::retrieveByName('mmu_b_speaker1', $con)->getId(),
  75, SpeakerScoreSheet::FIRST_SPEAKER)->save($con);
SpeakerScoreSheetPeer::createSpeakerScoreSheet(
  $allocation->getId(), $affirmativeDebateTeamXref->getId(), 
  DebaterPeer::retrieveByName('mmu_b_speaker3', $con)->getId(),
  76, SpeakerScoreSheet::SECOND_SPEAKER)->save($con);
SpeakerScoreSheetPeer::createSpeakerScoreSheet(
  $allocation->getId(), $affirmativeDebateTeamXref->getId(), 
  DebaterPeer::retrieveByName('mmu_b_speaker2', $con)->getId(),
  76, SpeakerScoreSheet::THIRD_SPEAKER)->save($con);
SpeakerScoreSheetPeer::createSpeakerScoreSheet(
  $allocation->getId(), $affirmativeDebateTeamXref->getId(), 
  DebaterPeer::retrieveByName('mmu_b_speaker3', $con)->getId(),
  37.5, SpeakerScoreSheet::REPLY_SPEAKER)->save($con);
SpeakerScoreSheetPeer::createSpeakerScoreSheet(
  $allocation->getId(), $negativeDebateTeamXref->getId(), 
  DebaterPeer::retrieveByName('sab_a_speaker2', $con)->getId(),
  77, SpeakerScoreSheet::FIRST_SPEAKER)->save($con);
SpeakerScoreSheetPeer::createSpeakerScoreSheet(
  $allocation->getId(), $negativeDebateTeamXref->getId(), 
  DebaterPeer::retrieveByName('sab_a_speaker1', $con)->getId(),
  76, SpeakerScoreSheet::SECOND_SPEAKER)->save($con);
SpeakerScoreSheetPeer::createSpeakerScoreSheet(
  $allocation->getId(), $negativeDebateTeamXref->getId(), 
  DebaterPeer::retrieveByName('sab_a_speaker3', $con)->getId(),
  76, SpeakerScoreSheet::THIRD_SPEAKER)->save($con);
SpeakerScoreSheetPeer::createSpeakerScoreSheet(
  $allocation->getId(), $negativeDebateTeamXref->getId(), 
  DebaterPeer::retrieveByName('sab_a_speaker2', $con)->getId(),
  37, SpeakerScoreSheet::REPLY_SPEAKER)->save($con);

$allocation = AdjudicatorAllocationPeer::createAdjudicatorAllocation(
  $debate->getId(), 
  AdjudicatorPeer::retrieveByName("tee_adjudicator1", $con)->getId(),
  AdjudicatorAllocation::ADJUDICATOR_TYPE_PANELIST);
$allocation->save($con);
TeamScoreSheetPeer::createTeamScoreSheet($allocation->getId(), $affirmativeDebateTeamXref->getId(), 1)->save($con);
TeamScoreSheetPeer::createTeamScoreSheet($allocation->getId(), $negativeDebateTeamXref->getId(), 0)->save($con);
SpeakerScoreSheetPeer::createSpeakerScoreSheet(
  $allocation->getId(), $affirmativeDebateTeamXref->getId(), 
  DebaterPeer::retrieveByName('mmu_b_speaker1', $con)->getId(),
  76, SpeakerScoreSheet::FIRST_SPEAKER)->save($con);
SpeakerScoreSheetPeer::createSpeakerScoreSheet(
  $allocation->getId(), $affirmativeDebateTeamXref->getId(), 
  DebaterPeer::retrieveByName('mmu_b_speaker3', $con)->getId(),
  76, SpeakerScoreSheet::SECOND_SPEAKER)->save($con);
SpeakerScoreSheetPeer::createSpeakerScoreSheet(
  $allocation->getId(), $affirmativeDebateTeamXref->getId(), 
  DebaterPeer::retrieveByName('mmu_b_speaker2', $con)->getId(),
  77, SpeakerScoreSheet::THIRD_SPEAKER)->save($con);
SpeakerScoreSheetPeer::createSpeakerScoreSheet(
  $allocation->getId(), $affirmativeDebateTeamXref->getId(), 
  DebaterPeer::retrieveByName('mmu_b_speaker3', $con)->getId(),
  38, SpeakerScoreSheet::REPLY_SPEAKER)->save($con);
SpeakerScoreSheetPeer::createSpeakerScoreSheet(
  $allocation->getId(), $negativeDebateTeamXref->getId(), 
  DebaterPeer::retrieveByName('sab_a_speaker2', $con)->getId(),
  77, SpeakerScoreSheet::FIRST_SPEAKER)->save($con);
SpeakerScoreSheetPeer::createSpeakerScoreSheet(
  $allocation->getId(), $negativeDebateTeamXref->getId(), 
  DebaterPeer::retrieveByName('sab_a_speaker1', $con)->getId(),
  77, SpeakerScoreSheet::SECOND_SPEAKER)->save($con);
SpeakerScoreSheetPeer::createSpeakerScoreSheet(
  $allocation->getId(), $negativeDebateTeamXref->getId(), 
  DebaterPeer::retrieveByName('sab_a_speaker3', $con)->getId(),
  78, SpeakerScoreSheet::THIRD_SPEAKER)->save($con);
SpeakerScoreSheetPeer::createSpeakerScoreSheet(
  $allocation->getId(), $negativeDebateTeamXref->getId(), 
  DebaterPeer::retrieveByName('sab_a_speaker2', $con)->getId(),
  37.5, SpeakerScoreSheet::REPLY_SPEAKER)->save($con);

$t->is(DebaterResultPeer::doCount(new Criteria(), false, $con), 24, "-> verified debater_results has 24 entries.");
$t->is(round(DebaterPeer::retrieveByName("mmu_b_speaker1", $con)->getDebaterResult($affirmativeDebateTeamXref->getId(), SpeakerScoreSheet::FIRST_SPEAKER, $con)->getAveragedScore(), 2), 75.67, "-> correct score returned first affirmative speaker");
$t->is(DebaterPeer::retrieveByName("mmu_b_speaker3", $con)->getDebaterResult($affirmativeDebateTeamXref->getId(), SpeakerScoreSheet::SECOND_SPEAKER, $con)->getAveragedScore(), 76, "-> correct score returned second affirmative speaker");
$t->is(round(DebaterPeer::retrieveByName("mmu_b_speaker2", $con)->getDebaterResult($affirmativeDebateTeamXref->getId(), SpeakerScoreSheet::THIRD_SPEAKER, $con)->getAveragedScore(), 2), 76.67, "-> correct score returned third affirmative speaker");
$t->is(round(DebaterPeer::retrieveByName("mmu_b_speaker3", $con)->getDebaterResult($affirmativeDebateTeamXref->getId(), SpeakerScoreSheet::REPLY_SPEAKER, $con)->getAveragedScore(), 2), 37.83, "-> correct score returned reply affirmative speaker");
$t->is(DebaterPeer::retrieveByName("sab_a_speaker2", $con)->getDebaterResult($negativeDebateTeamXref->getId(), SpeakerScoreSheet::FIRST_SPEAKER, $con)->getAveragedScore(), 77, "-> correct score returned first negative speaker");
$t->is(round(DebaterPeer::retrieveByName("sab_a_speaker1", $con)->getDebaterResult($negativeDebateTeamXref->getId(), SpeakerScoreSheet::SECOND_SPEAKER, $con)->getAveragedScore(), 2), 76.67, "-> correct score returned second negative speaker");
$t->is(DebaterPeer::retrieveByName("sab_a_speaker3", $con)->getDebaterResult($negativeDebateTeamXref->getId(), SpeakerScoreSheet::THIRD_SPEAKER, $con)->getAveragedScore(), 77, "-> correct score returned third negative speaker");
$t->is(round(DebaterPeer::retrieveByName("sab_a_speaker2", $con)->getDebaterResult($negativeDebateTeamXref->getId(), SpeakerScoreSheet::REPLY_SPEAKER, $con)->getAveragedScore(), 2), 37.33, "-> correct score returned reply negative speaker");

$con->rollback();
