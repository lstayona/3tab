<?php
require_once(dirname(__FILE__).'/../bootstrap/unit.php');
define('SF_APP',         '3tab');
define('SF_ENVIRONMENT', 'dev');
define('SF_DEBUG',       true);

require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');

sfContext::getInstance();

$con = Propel::getConnection();
$con->begin();

$t = new lime_test(72, new lime_output_color());

$rounds = RoundPeer::getRoundsInSequence($con);
foreach ($rounds as $outer => $round)
{
    $t->diag("When " . $round->getName() . " is incomplete.");
    foreach (RoundPeer::getRoundsInSequence($con) as $index => $innerRound) {
        if ($index == $outer) {
            $t->is($innerRound->isCurrentRound($con), true, $innerRound->getName() . " correctly identified as current round.");
        } else {
            $t->is($innerRound->isCurrentRound($con), false, $innerRound->getName() . " correctly identified as not being the current round.");
        }
    }
    $t->diag("Setting the status of " . $round->getName() . " as complete.");
    $round->setStatus(Round::ROUND_STATUS_RESULT_ENTRY_COMPLETE);
    $round->save($con);
    if (count($rounds) - 1 != $outer) {
        $t->is($round->isCurrentRound($con), false, $round->getName() . " correctly identified as not being the current round after status change.");
    } else {
        $t->is($round->isCurrentRound($con), true, "The final round " . $round->getName() . " was correctly identified as still being the current round even after the status change.");
    }
}

$con->rollback();
?>
