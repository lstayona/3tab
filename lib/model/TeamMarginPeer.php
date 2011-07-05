<?php

/**
 * Subclass for performing query and update operations on the 'team_margins' table.
 *
 * 
 *
 * @package lib.model
 */ 
class TeamMarginPeer extends BaseTeamMarginPeer
{	
    const COUNT = 'COUNT(team_margins.*)';
    const COUNT_DISTINCT = 'COUNT(DISTINCT team_margins.*)';
}
