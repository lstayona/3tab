<?php
function adjudicator_select_tag($name, $selected = null, $include_blank = true, $html_options = array())
{
    $select_options = array();

    
    foreach(AdjudicatorPeer::getAdjudicatorsByTestScore() as $adjudicator)
    {
        $select_options[$adjudicator->getId()] = $adjudicator->getInfo();
    }

    if ($include_blank) {
        $select_options = array('' => '') + $select_options;
    }

    return select_tag($name, options_for_select($select_options, $selected), $html_options);
}
