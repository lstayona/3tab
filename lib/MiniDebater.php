<?php
class MiniDebater
{
    protected $speakerId;
    protected $speakerScore;
    
    function setSpeakerId($v)
    {
        $this->speakerId = $v;
    }
    
    function setSpeakerScore($v)
    {
        $this->speakerScore = $v;
    }
    
    function getSpeakerId()
    {
        return $this->speakerId;
    }
    
    function getSpeakerScore()
    {
        return $this->speakerScore;
    }
    
    static function compDebater($a, $b)
    {
        if($a->getSpeakerScore() == $b->getSpeakerScore())
        {
            return 0;
        }
        return ($a->getSpeakerScore() < $b->getSpeakerScore()) ? +1 : -1;
    }
}
?>
