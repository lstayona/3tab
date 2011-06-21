<?php

/**
 * Subclass for representing a row from the 'team_score_sheets' table.
 *
 * 
 *
 * @package lib.model
 */ 
class SpeakerScoreSheet extends BaseSpeakerScoreSheet
{
	const FIRST_SPEAKER  = 1;
	const SECOND_SPEAKER = 2;
	const THIRD_SPEAKER  = 3;
	const REPLY_SPEAKER  = 4;
	
    
    public static function getSpeakerPositions()
    {
        return array(
            SpeakerScoreSheet::FIRST_SPEAKER => 1,
            SpeakerScoreSheet::SECOND_SPEAKER => 2,
            SpeakerScoreSheet::THIRD_SPEAKER => 3,
            SpeakerScoreSheet::REPLY_SPEAKER => "REPLY"
        );
    }
}
