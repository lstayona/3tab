<?php

/**
 * Subclass for performing query and update operations on the 'debater_results' table.
 *
 * 
 *
 * @package lib.model
 */ 
class DebaterResultPeer extends BaseDebaterResultPeer
{
	const COUNT = 'COUNT(debater_results.*)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT debater_results.*)';
}
