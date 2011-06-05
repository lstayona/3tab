<?php

 class MiniDebate
 {
	protected $debateId;
	protected $energy;
	protected $teamIds;
	
	function setDebateId($v, $bubble=false, $con=null)
	{
		$this->debateId = $v;
		$this->setTeamIds($con);
		$this->calculateEnergy($bubble, $con);
	}
	
	function setTeamIds($connection = null)
	{
		if(is_null($connection))
        {
            $connection = Propel::getConnection();
        }
		
		$query = 'SELECT team_id FROM debates, debates_teams_xrefs, teams  WHERE 
					debates.id = debates_teams_xrefs.debate_id AND 
					debates_teams_xrefs.team_id = teams.id AND debates.id = %s';
		$query = sprintf($query, $this->debateId);
		$statement = $connection->prepareStatement($query);
		$result = $statement->executeQuery();
		$result->next();
		$this->teamIds[0] = $result->getInt('team_id');
		$result->next();
		$this->teamIds[1] = $result->getInt('team_id');			
	}
	
	function setEnergy($v)
	{
		$this->energy = $v;
	}
		
	function calculateEnergy($bubble=false, $con=null)
	{	
		if(is_null($con))
        {
            $con = Propel::getConnection();
        }
		$stmt = $con->createStatement();
		$query = "SELECT  team_scores.* FROM team_scores, ".
						"teams WHERE teams.id = team_scores.team_id AND (team_scores.team_id = %d OR ".
						"team_scores.team_id = %d) ORDER BY team_scores.total_team_score DESC, ".
						"team_scores.total_speaker_score DESC, team_scores.total_margin DESC";
		$query = sprintf($query, $this->teamIds[0], $this->teamIds[1]);
		$rs = $stmt->executeQuery($query, ResultSet::FETCHMODE_NUM);
		$teamScores = TeamScorePeer::populateObjects($rs);
		
		$this->energy = $teamScores[0]->getTotalTeamScore() * 300;
		$this->energy += $teamScores[1]->getTotalTeamScore() * 300;
		$this->energy += $teamScores[0]->getTotalSpeakerScore();
		$this->energy += $teamScores[1]->getTotalSpeakerScore();
		$this->energy += $teamScores[0]->getTotalMargin();
		$this->energy += $teamScores[1]->getTotalMargin();
		//$team1 = TeamPeer::retrieveByPk($this->teamIds[0]);
		//$team2 = TeamPeer::retrieveByPk($this->teamIds[1]);
		//$this->energy = $team1->getTotalTeamScore() * 300;
		//$this->energy += $team2->getTotalTeamScore() * 300;
		//$this->energy += $team1->getTotalSpeakerScore();
		//$this->energy += $team2->getTotalSpeakerScore();
		//$this->energy += $team1->getTotalMargin();
		//$this->energy += $team2->getTotalMargin();
		
		if($bubble)
		{
				if($teamScores[0]->getTotalTeamScore() == 4 || 
				   $teamScores[1]->getTotalTeamScore() == 4 ||
				   $teamScores[0]->getTotalTeamScore() == 5 || 
				   $teamScores[1]->getTotalTeamScore() == 5)
				{
					$this->energy +=(6-$teamScores[0]->getTotalTeamScore()) * 300;
					$this->energy +=(6-$teamScores[1]->getTotalTeamScore()) * 300;
				}
				if(RoundPeer::getCurrentRound()->getId() == 6 &&
					($teamScores[0]->getTotalTeamScore() == 3 || 
					$teamScores[1]->getTotalTeamScore() == 3))
				{
					$this->energy += 100;
				}
				if($teamScores[0]->getTotalTeamScore() >= 6 &&
				   $teamScores[1]->getTotalTeamScore() >= 6)
				{
					$this->energy -= ($teamScores[0]->getTotalTeamScore()-5) * 310;
					$this->energy -= ($teamScores[1]->getTotalTeamScore()-5) * 310;
				}
		}
	}
	
	function getDebateId()
	{
		return $this->debateId;
	}
	
	function getTeamIds()
	{
		return $this->teamIds;
	}
	
	function getEnergy()
	{
		return $this->energy;
	}
	
	static function compDebate($a, $b)
	{
		if($a->getEnergy() == $b->getEnergy())
		{
			return 0;
		}
		return ($a->getEnergy() < $b->getEnergy()) ? +1 : -1;
	}
 }
 
 ?>
