<?php

/**
 * Subclass for representing a row from the 'teams' table.
 *
 * 
 *
 * @package lib.model
 */ 
class Team extends BaseTeam
{
    public static function getTeamSize()
    {
        return 3;
    }
	
	public function getWinLossText($roundId, $con = null)
	{
		$win = 0;
		$loss = 0;
		foreach($this->getTeamScoreSheets($roundId, $con) as $scoreSheet)
		{
			$scoreSheet->getScore() == 0 ? $loss++ : $win++;			
		}
		if($win == 0)
		{
			return 'Loss';
		}
		else if($loss == 0)
		{
			return 'Win';
		}
		else if($win > $loss)
		{
			return 'Split Win';
		}
		else if($loss > $win)
		{
			return 'Split Loss';
		}
		return 'Error';
	}
	
	public function getDebate($roundId, $con = null)
	{
		$scoreSheets = $this->getTeamScoreSheets($roundId, $con);
		return $scoreSheets[0]->getDebateTeamXref()->getDebate();
	}
	
	public function getTeamScoreSheets($roundId, $con = null)
	{        
        if(is_null($con))
        {
            $con = Propel::getConnection();
        }
        
    	$stmt = $con->createStatement();
		$query = "SELECT team_score_sheets.* FROM debates_teams_xrefs, debates, " .
        "team_score_sheets WHERE team_id = %d AND debates.round_id = %d AND " .
		"debates_teams_xrefs.debate_id = debates.id AND team_score_sheets.".
		"debate_team_xref_id = debates_teams_xrefs.id";
		$query = sprintf($query, $this->getId(), $roundId);
		$rs = $stmt->executeQuery($query, ResultSet::FETCHMODE_NUM);
        
		return TeamScoreSheetPeer::populateObjects($rs);		
	}
	
	public function save($con = null)
	{
		parent::save($con);
		if(!$this->getTeamScores())
		{
			$teamScore = new TeamScore();
			$teamScore->setTeam($this);
			$teamScore->save($con);
			$this->addTeamScore($teamScore);
		}		
		
		$adjudicators = $this->getInstitution()->getAdjudicators();		
		foreach($adjudicators as $anAdjudicator)
		{
			$conflict = $anAdjudicator->createConflict($this, $con);
			if($conflict != null)
			{
				$conflict->save($con);				
				$this->addAdjudicatorConflict($conflict);
			}			
		}		
		parent::save($con);
		
	}
	
	public function getTeamsDebated($conn = null)
	{
		$xrefs = $this->getDebateTeamXrefs(new Criteria(), $conn);
		$teamsMet = array();
		foreach($xrefs as $anXref)
		{
			$debate = $anXref->getDebate($conn);
			if($anXref->getPosition($conn) == 1)
			{
				$teamsMet[] = $debate->getDebateTeamXref(2, $conn)->getTeam();
			}
			else if($anXref->getPosition($conn) == 2)
			{
				$teamsMet[] = $debate->getDebateTeamXref(1, $conn)->getTeam();
			}
		}
		
		return $teamsMet;
	}
	
	public function hasMetTeam($team, $conn = null)
	{
		if(in_array($team, $this->getTeamsDebated($conn)))
		{
			return true;
		}
		
		return false;
	}
	
	public function delete($con = null)
	{
		$debaters = $this->getDebaters();
		foreach($debaters as $aDebater)
		{
			//$this->forward404Unless($aDebater);
			$speakerScore = $aDebater->getSpeakerScores();
			//$this->forward404Unless($speakerScore);
			$speakerScore[0]->delete();
			$aDebater->delete();
		}
			
		$teamScore = $this->getTeamScores();
		//$this->forward404Unless($teamScore);
		$teamScore[0]->delete();
		
		$conflicts = $this->getAdjudicatorConflicts();
		foreach($conflicts as $aConflict)
		{
			$aConflict->delete();
		}
		
		parent::delete();
	}
	
	public function getTeamScore($debate, $conn=null){
		$total = 0;
		$c = new Criteria();
		$c->add(DebateTeamXrefPeer::DEBATE_ID, $debate->getId());
		$c->add(DebateTeamXrefPeer::TEAM_ID, $this->getId());
		$xref = DebateTeamXrefPeer::doSelect($c, $conn);
		$win=0;
		$loss=0;
		if($xref[0]->getTeamScoreSheets() != null)
		{
			foreach($xref[0]->getTeamScoreSheets() as $teamScoreSheet)
			{
				if($teamScoreSheet->getScore($conn) == 1)
				{
					$win++;
				}
				else if($teamScoreSheet->getScore($conn) == 0)
				{
					$loss++;
				}
				else
				{
					throw new Exception('Teams can only win or lose in Australs style.  Scores should either be 1 or 0.  Got ' . $teamScoreSheet->getScore());
				}
			}
			if($win > $loss)
			{
				$total++;
			}
			else if($win == $loss)
			{
				throw new Exception('This team had an equal number of adjudicators giving the win to it as those that gave it against it');
			}
		}
		return $total;
	}
	
	public function getTotalTeamScore($propelConn = null)
	{
		$score = $this->getTeamScores();
		return $score[0]->getTotalTeamScore();
	}
	
	public function getTotalSpeakerScore($propelConn = null)
	{
		$criteria = new Criteria();
		$criteria->add(TeamPeer::ID, $this->getId());
		$score = TeamScorePeer::doSelect($criteria);
		return $score[0]->getTotalSpeakerScore();
	}
	
	public function getTotalMargin($propelConn = null)
	{
		$criteria = new Criteria();
		$criteria->add(TeamPeer::ID, $this->getId());
		$score = TeamScorePeer::doSelect($criteria);
		return $score[0]->getTotalMargin();
	}
	
	public function getTotalTeamScoreSlow($propelConn=null)
    {
		$total = 0;
		foreach($this->getDebateTeamXrefs(null, $propelConn) as $debateTeamXref)
		{
			if($debateTeamXref->getTeamScoreSheets() != null)
			{
				$win = 0;
				$loss = 0;
				foreach($debateTeamXref->getTeamScoreSheets(null, $propelConn) as $teamScoreSheet)
				{

					if($teamScoreSheet->getScore() == 1)
					{
						$win++;
					}
					else if($teamScoreSheet->getScore() == 0)
					{
						$loss++;
					}
					else
					{
						throw new Exception('Teams can only win or lose in Australs style.  Scores should either be 1 or 0.  Got ' . $teamScoreSheet->getScore());
					}
				}
				
				if($win > $loss)
				{
					$total++;
				}
				else if($win == $loss)
				{	
					echo $win."-".$loss;
					echo $debateTeamXref->getId();
					throw new Exception('This team had an equal number of adjudicators giving the win to it as those that gave it against it');
				}
			}
		}
		
		return $total;
    }
	
	public function getTotalSpeakerScoreSlow($conn = null)
	{
		$total = 0;
		foreach($this->getDebateTeamXrefs(new Criteria(), $conn) as $xref)
		{
			$total += $xref->getSpeakerScores();
		}
		return $total;
	}
	
	public function getTotalMarginSlow($conn = null)
	{
		$margin = 0;
		foreach($this->getDebateTeamXrefs(new Criteria(), $conn) as $xref)
		{
			$margin += $xref->getMargin();
		}
		return $margin;
	}
	
	public function getTotalAffs($conn=null)
	{
		$total = 0;
		foreach($this->getDebateTeamXrefs($conn) as $xref)
		{
			if($xref->getPosition($conn) == 1)
			{
				$total++;
			}
		}
		return $total;
	}
}
