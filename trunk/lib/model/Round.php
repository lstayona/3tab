<?php

/**
 * Subclass for representing a row from the 'rounds' table.
 *
 * 
 *
 * @package lib.model
 */ 
class Round extends BaseRound
{
	const ROUND_TYPE_RANDOM = 1;
	const ROUND_TYPE_PRELIMINARY = 2;
	const ROUND_TYPE_BREAK = 4;
	const ROUND_TYPE_BUBBLE = 8;
	
    const ROUND_STATUS_DRAFT = 1;
    const ROUND_STATUS_MATCHUPS_DRAFT = 2;
    const ROUND_STATUS_MATCHUPS_CONFIRMED = 4;
    const ROUND_STATUS_ADJUDICATOR_ALLOCATIONS_DRAFT = 8;
    const ROUND_STATUS_ADJUDICATOR_ALLOCATIONS_CONFIRMED = 16;
    const ROUND_STATUS_TRAINEE_ALLOCATIONS_CONFIRMED = 32;
	const ROUND_STATUS_RESULT_ENTRY_COMPLETE  = 64;
	const ROUND_STATUS_ADJUDICATOR_FEEDBACK_ENTRY_COMPLETE  = 128;
	const ROUND_STATUS_TRAINEE_FEEDBACK_ENTRY_COMPLETE  = 192;
    const ROUND_STATUS_COMPLETE = 256;
    const ROUND_STATUS_CANCELLED  = 1024;
	
   	public function getAllPrecedingRounds($con = null)
    {
        $precedingRounds = array();
        $previous = $this->getRoundRelatedByPrecededByRoundId($con);
        while (!is_null($previous)) {
            $precedingRounds[] = $previous;
            $previous = $previous->getRoundRelatedByPrecededByRoundId($con);
        }

        return $precedingRounds;
    }

    public function isFinalRound($con = null)
    {
       $roundsInSequence = RoundPeer::getRoundsInSequence($con);

       return $roundsInSequence[count($roundsInSequence)-1]->getId() === $this->getId();
    }

    public function isCurrentRound($propelConn = null)
    {
        $previousRound = $this->getRoundRelatedByPrecededByRoundId($propelConn);
        /* If it is the first round */
        if(is_null($previousRound))
        {
            if ($this->getStatus() < Round::ROUND_STATUS_RESULT_ENTRY_COMPLETE)
            {
                return true;
            }
        }
        /* If it is any round but the first round */
        else
        {
            if(($this->getStatus() < Round::ROUND_STATUS_RESULT_ENTRY_COMPLETE) and
              ($previousRound->getStatus() >= Round::ROUND_STATUS_RESULT_ENTRY_COMPLETE))
            {
                return true;
            }
            else
            {
                /*
                 * If this round is the final round (i.e. no other round has it as 
                 * a preceding round) it is the current round regardless of its
                 * status.
                 */
                $c = new Criteria();
                $c->add(RoundPeer::PRECEDED_BY_ROUND_ID, $this->getId());
                if (RoundPeer::doCount($c, false, $propelConn) == 0 and 
                  $previousRound->getStatus() >= Round::ROUND_STATUS_RESULT_ENTRY_COMPLETE) {
                    return true; 
                } else {
                    return false;
                }
            }
        }

        return false;
    }
    
    public function getTypeText($type = null)
    {
        if(is_null($type))
        {
            $type = $this->getType();
        }
        
        $textStatus = array(
            Round::ROUND_TYPE_RANDOM => "Random",
            Round::ROUND_TYPE_PRELIMINARY => "Preliminary",
            Round::ROUND_TYPE_BREAK => "Break",
			Round::ROUND_TYPE_BUBBLE => "Bubble"
        );
        
        return $textStatus[$type];
    }
    
    public function getStatusText($status = null)
    {
        if(is_null($status))
        {
            $status = $this->getStatus();
        }
        
        $textStatus = array(
            Round::ROUND_STATUS_DRAFT => "Draft",
            Round::ROUND_STATUS_MATCHUPS_DRAFT => "Draft Debate Matchups",
            Round::ROUND_STATUS_MATCHUPS_CONFIRMED => "Debate Matchups Confirmed",
            Round::ROUND_STATUS_ADJUDICATOR_ALLOCATIONS_DRAFT => "Draft Adjudicator Allocations",
            Round::ROUND_STATUS_ADJUDICATOR_ALLOCATIONS_CONFIRMED => "Adjudicator Allocations Confirmed",
            Round::ROUND_STATUS_TRAINEE_ALLOCATIONS_CONFIRMED => "Trainee Allocations Confirmed",
			Round::ROUND_STATUS_RESULT_ENTRY_COMPLETE => "Results Entry Complete",
			Round::ROUND_STATUS_ADJUDICATOR_FEEDBACK_ENTRY_COMPLETE => "Adjudicator Feedback Entry Complete",
			Round::ROUND_STATUS_TRAINEE_FEEDBACK_ENTRY_COMPLETE => "Trainee Feedback Entry Complete",
            Round::ROUND_STATUS_COMPLETE => "Complete",
            Round::ROUND_STATUS_CANCELLED => "Cancelled"
        );
        
        return $textStatus[$status];
    }
   
	public static function roundCompleted()
	{
		$rounds = RoundPeer::doSelect(new Criteria());
		$latestRound = $rounds[count($rounds)-1];
		if($latestRound->getUnscoredDebates() == null)
		{
			return true;
		}
		return false;
	}
		
	public function getUnscoredDebates()
	{
		$debates = $this->getDebates();
		$unscoredDebates = array();
		foreach($debates as $debate){
			$xrefs = $debate->getDebateTeamXrefs();
			$numOfAdjudicatorAllocations = $debate->countAdjudicatorAllocations();
			$numOfScoreSheets = 0;
			foreach($xrefs as $xref)
			{
				$numOfScoreSheets += $xref->countTeamScoreSheets();
			}
			//if we have enough team score sheets
			if($numOfScoreSheets < $numOfAdjudicatorAllocations * 2)
			{
				//add to the unscoredDebates array
				$unscoredDebates[]  = $debate;
			}
		}
		return $unscoredDebates;
	}
	
}
