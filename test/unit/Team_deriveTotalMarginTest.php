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
 * Round 1 Debate 1: 
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
$t->diag("Round 1: Checking for 3-person panel and an affirmative win on a split decision");
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

$t->is($affirmativeDebateTeamXref->getTeam($con)->deriveTotalMargin($con), 2.5, '-> correct total margin four affirmative team after round 1.');
$t->is($negativeDebateTeamXref->getTeam($con)->deriveTotalMargin($con), -2.5, '-> correct total margin four affirmative team after round 1.');

/*
 * Test data scenario:
 * Round 2 Debate 1: 
 *   IIU A vs SWING A 
 *   Winner: IIU A
 *   Adjudicator: bar_adjudicator1
 *     Scores:
 *       iiu_a_speaker1: 77
 *       iiu_a_speaker2: 76
 *       iiu_a_speaker3: 77
 *       iiu_a_speaker2-reply: 38
 *
 *       swing_a_speaker2: 75
 *       swing_a_speaker3: 76
 *       swing_a_speaker1: 77
 *       swing_a_speaker3-reply: 37.5
 */
$t->diag("Round 2: Checking for single chair with an affirmative win");
$debate = DebatePeer::createDebate(
  TeamPeer::retrieveByName("IIU A", $con)->getId(), 
  TeamPeer::retrieveByName("SWING A", $con)->getId(), 
  VenuePeer::retrieveByName("Venue 1", $con));
$debate->setRound(RoundPeer::retrieveByName("Round 2", $con));
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
  DebaterPeer::retrieveByName('iiu_a_speaker1', $con)->getId(),
  77, SpeakerScoreSheet::FIRST_SPEAKER)->save($con);
SpeakerScoreSheetPeer::createSpeakerScoreSheet(
  $allocation->getId(), $affirmativeDebateTeamXref->getId(), 
  DebaterPeer::retrieveByName('iiu_a_speaker2', $con)->getId(),
  76, SpeakerScoreSheet::SECOND_SPEAKER)->save($con);
SpeakerScoreSheetPeer::createSpeakerScoreSheet(
  $allocation->getId(), $affirmativeDebateTeamXref->getId(), 
  DebaterPeer::retrieveByName('iiu_a_speaker3', $con)->getId(),
  77, SpeakerScoreSheet::THIRD_SPEAKER)->save($con);
SpeakerScoreSheetPeer::createSpeakerScoreSheet(
  $allocation->getId(), $affirmativeDebateTeamXref->getId(), 
  DebaterPeer::retrieveByName('iiu_a_speaker2', $con)->getId(),
  38, SpeakerScoreSheet::REPLY_SPEAKER)->save($con);
$negativeDebateTeamXref = $debate->getDebateTeamXref(DebateTeamXref::NEGATIVE, $con);
TeamScoreSheetPeer::createTeamScoreSheet($allocation->getId(), $negativeDebateTeamXref->getId(), 0)->save($con);
SpeakerScoreSheetPeer::createSpeakerScoreSheet(
  $allocation->getId(), $negativeDebateTeamXref->getId(), 
  DebaterPeer::retrieveByName('swing_a_speaker2', $con)->getId(),
  75, SpeakerScoreSheet::FIRST_SPEAKER)->save($con);
SpeakerScoreSheetPeer::createSpeakerScoreSheet(
  $allocation->getId(), $negativeDebateTeamXref->getId(), 
  DebaterPeer::retrieveByName('swing_a_speaker3', $con)->getId(),
  76, SpeakerScoreSheet::SECOND_SPEAKER)->save($con);
SpeakerScoreSheetPeer::createSpeakerScoreSheet(
  $allocation->getId(), $negativeDebateTeamXref->getId(), 
  DebaterPeer::retrieveByName('swing_a_speaker1', $con)->getId(),
  77, SpeakerScoreSheet::THIRD_SPEAKER)->save($con);
SpeakerScoreSheetPeer::createSpeakerScoreSheet(
  $allocation->getId(), $negativeDebateTeamXref->getId(), 
  DebaterPeer::retrieveByName('swing_a_speaker3', $con)->getId(),
  37.5, SpeakerScoreSheet::REPLY_SPEAKER)->save($con);

$t->is($affirmativeDebateTeamXref->getTeam($con)->deriveTotalMargin($con), 0.0, '-> correct total margin four affirmative team after round 2.');
$t->is($negativeDebateTeamXref->getTeam($con)->deriveTotalMargin($con), 0.0, '-> correct total margin four affirmative team after round 2.');

$con->rollback();
