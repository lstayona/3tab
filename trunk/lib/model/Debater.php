<?php

/**
 * Subclass for representing a row from the 'debaters' table.
 *
 * 
 *
 * @package lib.model
 */ 
class Debater extends BaseDebater
{
	public function save($con = null)
	{
		if($this->countSpeakerScores(new Criteria(), true, $con) == 0)
		{
			$speakerScore = new SpeakerScore();
			$speakerScore->setDebater($this);
			$this->addSpeakerScore($speakerScore);			
		}
        parent::save($con);
	}

    public function delete($con = null)
    {
        $this->getSpeakerScore($con)->delete($con);
        parent::delete($con);
    }
	
    public function getSpeakerScore($con = null)
    {
        $speakerScores = $this->getSpeakerScores(null, $con);

        if (count($speakerScores) > 1) {
            throw new Exception("More than one object found. There should only one and only one entry in the speaker_scores table per debater.");
        } else if (count($speakerScores) < 1) {
            throw new Exception("No objects found.");
        } else {
            return $speakerScores[0];
        }
    }

    public function deriveTotalSpeakerScore($con = null)
    {
        if (!($con instanceof Connection)) {
            $con = Propel::getConnection();
        }
        $sql = "SELECT SUM(COALESCE(debater_results.averaged_score, 0.00)) AS total_debater_speaker_score " .
        "FROM debaters " .
        "LEFT JOIN debater_results ON debater_results.debater_id = debaters.id " .
        "WHERE debaters.id = ? AND debater_results.speaking_position <> ?";
        $stmt = $con->prepareStatement($sql);
        $stmt->setInt(1, $this->getId());
        $stmt->setInt(2, SpeakerScoreSheet::REPLY_SPEAKER);
        $rs = $stmt->executeQuery();
        $rs->next();

        return $rs->getFloat('total_debater_speaker_score');
	}

    public function getDebaterResult($debateTeamXrefId, $speakingPosition, $con = null)
    {
        $criteria = new Criteria();
        $criteria->add(DebaterResultPeer::DEBATE_TEAM_XREF_ID, $debateTeamXrefId);
        $criteria->add(DebaterResultPeer::SPEAKING_POSITION, $speakingPosition);
        
        $debaterResults = $this->getDebaterResults($criteria, $con);

        if (count($debaterResults) > 1) {
            throw new Exception("Cannot have more than one DebaterResult for a Debater object");
        } else if (count($debaterResults) < 1) {
            return null;
        } else {
            return $debaterResults[0];
        }
    }

    public function hasCheckedIn($round, $con = null)
    {
        $c = new Criteria();
        $c->add(DebaterCheckinPeer::ROUND_ID, $round->getId());

        return $this->countDebaterCheckins($c, false, $con) > 0 ? true : false;
    }
}
