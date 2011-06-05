<?php

/**
 * Subclass for performing query and update operations on the 'teams' table.
 *
 * 
 *
 * @package lib.model
 */ 
class TeamPeer extends BaseTeamPeer
{
    // returns all teams sorted randomly
	public static function getTeamsInRandomOrder($active = true, $con = null)
	{
		$activeCondition = null;
        if($active === true)
        {
            $activeCondition = "WHERE active = true";
        }
        else if($active === false)
        {
            $activeCondition = "WHERE active = false";
        }
        
        if(is_null($con))
        {
            $con = Propel::getConnection();
        }
        
    	$stmt = $con->createStatement();
		$rs = $stmt->executeQuery(
        "SELECT teams.id, teams.name, teams.institution_id, teams.swing, " .
        "teams.active, teams.created_at, teams.updated_at FROM teams " . 
        $activeCondition . " ORDER BY RANDOM()", ResultSet::FETCHMODE_NUM);
        
		return TeamPeer::populateObjects($rs); 
	}
	/*
	
	//returns all teams in order of ranking
	public static function getTeamsByRank()
	{
		$c = new Criteria();
		//$c = where active....
		$teams = TeamPeer::doSelect($c);
		$miniTeams = array();
		foreach($teams as $team)
		{
			$miniTeam = new MiniTeam();
			$miniTeam->setTeamId($team->getId());
			$miniTeam->setTeamScore($team->getTotalTeamScore());
			$miniTeam->setSpeakerScore($team->getTotalSpeakerScore());
			$miniTeam->setMargin($team->getTotalMargin());
			$miniTeams[] = $miniTeam;
		}
		usort($miniTeams, array("MiniTeam", "compTeam"));
		$output = array();
		foreach($miniTeams as $miniTeam)
		{
			$output[] = TeamPeer::retrieveByPk($miniTeam->getTeamId());
		}
		
		return $output;
	}
	*/
   
    public static function createFromCSVLine($line, $lineNumber, $allLines, $update = true, $conn = null)
    {
        $exists = true;
        $team = TeamPeer::retrieveByName($line['name'], $conn);
        if(!is_null($team) and !$update)
        {
            return array($exists, $team);
        }
        
        if(is_null($team))
        {
            $team = new Team();
            $exists = false;
        }
        
        $team->setName($line['name']);
        $team->setSwing($line['swing']);
        $team->setActive($line['active']);
        $institution = InstitutionPeer::retrieveByCode($line['institution-code'], $conn);
        if(!is_null($institution))
        {
            $team->setInstitution($institution);
        }
        else
        {
            throw new Exception("The institution with the code '" . $line['institution-code'] . "' does not exist.");
        }
        
        return array($exists, $team);
    }
    
    public static function retrieveByName($name, $conn = null)
    {
        $c = new Criteria();
        $c->add(TeamPeer::NAME, $name);
        
        $results = TeamPeer::doSelect($c, $conn);
        
        if(count($results) < 1)
        {
            return null;
        }
        else if(count($results) > 1)
        {
            throw new Exception("More that one team returned for '" . $name . "'");
        }
        else
        {
            return $results[0];
        }
    }
}
