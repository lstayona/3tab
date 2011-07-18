<?php
function get_adjudicator_select_options($adjudicators = array())
{
    $select_options = array();

    foreach($adjudicators as $adjudicator)
    {
        $select_options[$adjudicator->getId()] = $adjudicator->getInfoPlus();
    }

    return $select_options;
}

function adjudicator_select_tag($name, $select_options = null, $selected = null, $include_blank = true, $html_options = array())
{
    if (is_null($select_options)) {
        $select_options = get_adjudicator_select_options(AdjudicatorPeer::getAdjudicatorsByTestScore());
    }

    if ($include_blank) {
        $select_options = array('' => '') + $select_options;
    }

    return select_tag($name, options_for_select($select_options, $selected), $html_options);
}
