<?php
require_once(dirname(__FILE__).'/../bootstrap/unit.php');
define('SF_APP',         '3tab');
define('SF_ENVIRONMENT', 'dev');
define('SF_DEBUG',       true);

require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');

sfContext::getInstance();

$con = Propel::getConnection();
$con->begin();

$t = new lime_test(2, new lime_output_color());

$rounds = RoundPeer::getRoundsInSequence($con);

$t->is($rounds[0]->getName(), "Round 1", "First round is correct.");
$t->is($rounds[count($rounds) - 1]->getName(), "Round 8", "Final round is correct.");

$con->rollback();
?>
