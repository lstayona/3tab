<?php

/**
 * Subclass for performing query and update operations on the 'debates_teams_xrefs' table.
 *
 * 
 *
 * @package lib.model
 */ 
class DebateTeamXrefPeer extends BaseDebateTeamXrefPeer
{
    public static function createDebateTeamXref($debate, $team, $position)
	{
        $xref = new DebateTeamXref();
        $xref->setDebate($debate);
        $xref->setTeamId($team);
        $xref->setPosition($position);
        
        $debate->addDebateTeamXref($xref);
        
		return $xref;	
	}
}
