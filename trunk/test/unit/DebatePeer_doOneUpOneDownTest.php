<?php
require_once(dirname(__FILE__).'/../bootstrap/unit.php');
define('SF_APP',         '3tab');
define('SF_ENVIRONMENT', 'dev');
define('SF_DEBUG',       true);

require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');

sfContext::getInstance();

$t = new lime_test(56, new lime_output_color());

$con = Propel::getConnection();
$con->begin();
$t->diag("Verify correct behaviour when no swaps are necessary.");
/*
 * Test data scenario:
 * Debate 1: MMU A vs FOO A
 * Debate 2: BAR A vs SHIT A
 * Debate 3: SWING A vs IIU A
 * Debate 4: NTU A vs SMU A
 */
$debates = array();
$debates[] = DebatePeer::createDebate(TeamPeer::retrieveByName("MMU A")->getId(), TeamPeer::retrieveByName("FOO A")->getId());
$debates[] = DebatePeer::createDebate(TeamPeer::retrieveByName("BAR A")->getId(), TeamPeer::retrieveByName("SHIT A")->getId());
$debates[] = DebatePeer::createDebate(TeamPeer::retrieveByName("SWING A")->getId(), TeamPeer::retrieveByName("IIU A")->getId());
$debates[] = DebatePeer::createDebate(TeamPeer::retrieveByName("NTU A")->getId(), TeamPeer::retrieveByName("SMU A")->getId());
DebatePeer::doOneUpOneDown($debates, true, true, $con);
$expectedResults = array(
    array('MMU A', 'FOO A'),
    array('BAR A', 'SHIT A'),
    array('SWING A', 'IIU A'),
    array('NTU A', 'SMU A')
);
foreach ($debates as $index => $debate)
{
    $t->is($debate->getTeam(DebateTeamXref::AFFIRMATIVE)->getName(), $expectedResults[$index][0], "-> Correct team found in higher-rank slot for debate number $index.");
    $t->is($debate->getTeam(DebateTeamXref::NEGATIVE)->getName(), $expectedResults[$index][1], "-> Correct team found in lower-rank slot for debate number $index.");
}

$t->diag("Verify correct behaviour when swap is necessary in top room.");
/*
 * Test data scenario:
 * Debate 1: MMU A vs MMU B
 * Debate 2: BAR A vs SHIT A
 * Debate 3: SWING A vs IIU A
 * Debate 4: NTU A vs SMU A
 */
$debates = array();
$debates[] = DebatePeer::createDebate(TeamPeer::retrieveByName("MMU A")->getId(), TeamPeer::retrieveByName("MMU B")->getId());
$debates[] = DebatePeer::createDebate(TeamPeer::retrieveByName("BAR A")->getId(), TeamPeer::retrieveByName("SHIT A")->getId());
$debates[] = DebatePeer::createDebate(TeamPeer::retrieveByName("SWING A")->getId(), TeamPeer::retrieveByName("IIU A")->getId());
$debates[] = DebatePeer::createDebate(TeamPeer::retrieveByName("NTU A")->getId(), TeamPeer::retrieveByName("SMU A")->getId());
DebatePeer::doOneUpOneDown($debates, true, true, $con);
$expectedResults = array(
    array('MMU A', 'SHIT A'),
    array('BAR A', 'MMU B'),
    array('SWING A', 'IIU A'),
    array('NTU A', 'SMU A')
);
foreach ($debates as $index => $debate)
{
    $t->is($debate->getTeam(DebateTeamXref::AFFIRMATIVE)->getName(), $expectedResults[$index][0], "-> Correct team found in higher-rank slot for debate number $index.");
    $t->is($debate->getTeam(DebateTeamXref::NEGATIVE)->getName(), $expectedResults[$index][1], "-> Correct team found in lower-rank slot for debate number $index.");
}

$t->diag("Verify correct behaviour when swap is necessary in top room but swap not possible (swap stopper team is low-ranked).");
/*
 * Test data scenario:
 * Debate 1: MMU A vs MMU B
 * Debate 2: BAR A vs MMU C
 * Debate 3: SWING A vs IIU A
 * Debate 4: NTU A vs SMU A
 */
$debates = array();
$debates[] = DebatePeer::createDebate(TeamPeer::retrieveByName("MMU A")->getId(), TeamPeer::retrieveByName("MMU B")->getId());
$debates[] = DebatePeer::createDebate(TeamPeer::retrieveByName("BAR A")->getId(), TeamPeer::retrieveByName("MMU C")->getId());
$debates[] = DebatePeer::createDebate(TeamPeer::retrieveByName("SWING A")->getId(), TeamPeer::retrieveByName("IIU A")->getId());
$debates[] = DebatePeer::createDebate(TeamPeer::retrieveByName("NTU A")->getId(), TeamPeer::retrieveByName("SMU A")->getId());
DebatePeer::doOneUpOneDown($debates, true, true, $con);
$expectedResults = array(
    array('MMU A', 'MMU B'),
    array('BAR A', 'MMU C'),
    array('SWING A', 'IIU A'),
    array('NTU A', 'SMU A')
);
foreach ($debates as $index => $debate)
{
    $t->is($debate->getTeam(DebateTeamXref::AFFIRMATIVE)->getName(), $expectedResults[$index][0], "-> Correct team found in higher-rank slot for debate number $index.");
    $t->is($debate->getTeam(DebateTeamXref::NEGATIVE)->getName(), $expectedResults[$index][1], "-> Correct team found in lower-rank slot for debate number $index.");
}

$t->diag("Verify correct behaviour when swap is necessary in top room but swap not possible (swap-stopper team is high-ranked).");
/*
 * Test data scenario:
 * Debate 1: MMU A vs MMU B
 * Debate 2: MMU C vs BAR A
 * Debate 3: SWING A vs IIU A
 * Debate 4: NTU A vs SMU A
 */
$debates = array();
$debates[] = DebatePeer::createDebate(TeamPeer::retrieveByName("MMU A")->getId(), TeamPeer::retrieveByName("MMU B")->getId());
$debates[] = DebatePeer::createDebate(TeamPeer::retrieveByName("MMU C")->getId(), TeamPeer::retrieveByName("BAR A")->getId());
$debates[] = DebatePeer::createDebate(TeamPeer::retrieveByName("SWING A")->getId(), TeamPeer::retrieveByName("IIU A")->getId());
$debates[] = DebatePeer::createDebate(TeamPeer::retrieveByName("NTU A")->getId(), TeamPeer::retrieveByName("SMU A")->getId());
DebatePeer::doOneUpOneDown($debates, true, true, $con);
$expectedResults = array(
    array('MMU A', 'MMU B'),
    array('MMU C', 'BAR A'),
    array('SWING A', 'IIU A'),
    array('NTU A', 'SMU A')
);
foreach ($debates as $index => $debate)
{
    $t->is($debate->getTeam(DebateTeamXref::AFFIRMATIVE)->getName(), $expectedResults[$index][0], "-> Correct team found in higher-rank slot for debate number $index.");
    $t->is($debate->getTeam(DebateTeamXref::NEGATIVE)->getName(), $expectedResults[$index][1], "-> Correct team found in lower-rank slot for debate number $index.");
}

$t->diag("Verify correct behaviour when swap is necessary in bottom room.");
/*
 * Test data scenario:
 * Debate 1: MMU A vs FOO A
 * Debate 2: BAR A vs SHIT A
 * Debate 3: SWING A vs IIU A
 * Debate 4: NTU A vs NTU B
 */
$debates = array();
$debates[] = DebatePeer::createDebate(TeamPeer::retrieveByName("MMU A")->getId(), TeamPeer::retrieveByName("FOO A")->getId());
$debates[] = DebatePeer::createDebate(TeamPeer::retrieveByName("BAR A")->getId(), TeamPeer::retrieveByName("SHIT A")->getId());
$debates[] = DebatePeer::createDebate(TeamPeer::retrieveByName("SWING A")->getId(), TeamPeer::retrieveByName("IIU A")->getId());
$debates[] = DebatePeer::createDebate(TeamPeer::retrieveByName("NTU A")->getId(), TeamPeer::retrieveByName("NTU B")->getId());
DebatePeer::doOneUpOneDown($debates, true, true, $con);
$expectedResults = array(
    array('MMU A', 'FOO A'),
    array('BAR A', 'SHIT A'),
    array('SWING A', 'NTU B'),
    array('NTU A', 'IIU A')
);
foreach ($debates as $index => $debate)
{
    $t->is($debate->getTeam(DebateTeamXref::AFFIRMATIVE)->getName(), $expectedResults[$index][0], "-> Correct team found in higher-rank slot for debate number $index.");
    $t->is($debate->getTeam(DebateTeamXref::NEGATIVE)->getName(), $expectedResults[$index][1], "-> Correct team found in lower-rank slot for debate number $index.");
}

$t->diag("Verify correct behaviour when swap is necessary in bottom room but not possible (swap-stopper team is low-ranked).");
/*
 * Test data scenario:
 * Debate 1: MMU A vs FOO A
 * Debate 2: BAR A vs SHIT A
 * Debate 3: SWING A vs NTU C
 * Debate 4: NTU A vs NTU B
 */
$debates = array();
$debates[] = DebatePeer::createDebate(TeamPeer::retrieveByName("MMU A")->getId(), TeamPeer::retrieveByName("FOO A")->getId());
$debates[] = DebatePeer::createDebate(TeamPeer::retrieveByName("BAR A")->getId(), TeamPeer::retrieveByName("SHIT A")->getId());
$debates[] = DebatePeer::createDebate(TeamPeer::retrieveByName("SWING A")->getId(), TeamPeer::retrieveByName("NTU C")->getId());
$debates[] = DebatePeer::createDebate(TeamPeer::retrieveByName("NTU A")->getId(), TeamPeer::retrieveByName("NTU B")->getId());
DebatePeer::doOneUpOneDown($debates, true, true, $con);
$expectedResults = array(
    array('MMU A', 'FOO A'),
    array('BAR A', 'SHIT A'),
    array('SWING A', 'NTU C'),
    array('NTU A', 'NTU B')
);
foreach ($debates as $index => $debate)
{
    $t->is($debate->getTeam(DebateTeamXref::AFFIRMATIVE)->getName(), $expectedResults[$index][0], "-> Correct team found in higher-rank slot for debate number $index.");
    $t->is($debate->getTeam(DebateTeamXref::NEGATIVE)->getName(), $expectedResults[$index][1], "-> Correct team found in lower-rank slot for debate number $index.");
}


$t->diag("Verify correct behaviour when swap is necessary in bottom room but not possible (swap-stopper team is high-ranked).");
/*
 * Test data scenario:
 * Debate 1: MMU A vs FOO A
 * Debate 2: BAR A vs SHIT A
 * Debate 3: NTU C A vs SWING A
 * Debate 4: NTU A vs NTU B
 */
$debates = array();
$debates[] = DebatePeer::createDebate(TeamPeer::retrieveByName("MMU A")->getId(), TeamPeer::retrieveByName("FOO A")->getId());
$debates[] = DebatePeer::createDebate(TeamPeer::retrieveByName("BAR A")->getId(), TeamPeer::retrieveByName("SHIT A")->getId());
$debates[] = DebatePeer::createDebate(TeamPeer::retrieveByName("NTU C")->getId(), TeamPeer::retrieveByName("SWING A")->getId());
$debates[] = DebatePeer::createDebate(TeamPeer::retrieveByName("NTU A")->getId(), TeamPeer::retrieveByName("NTU B")->getId());
DebatePeer::doOneUpOneDown($debates, true, true, $con);
$expectedResults = array(
    array('MMU A', 'FOO A'),
    array('BAR A', 'SHIT A'),
    array('NTU C', 'SWING A'),
    array('NTU A', 'NTU B')
);
foreach ($debates as $index => $debate)
{
    $t->is($debate->getTeam(DebateTeamXref::AFFIRMATIVE)->getName(), $expectedResults[$index][0], "-> Correct team found in higher-rank slot for debate number $index.");
    $t->is($debate->getTeam(DebateTeamXref::NEGATIVE)->getName(), $expectedResults[$index][1], "-> Correct team found in lower-rank slot for debate number $index.");
}

$con->rollback();
