<?php 
$c = new Criteria();
$c->add(AdjudicatorAllocationPeer::TYPE, AdjudicatorAllocation::ADJUDICATOR_TYPE_TRAINEE, Criteria::NOT_EQUAL);
$c->addAscendingOrderByColumn(AdjudicatorAllocationPeer::TYPE);
$c->addAscendingOrderByColumn(AdjudicatorAllocationPeer::ID);
$adjudicatorAllocations = $debate->getAdjudicatorAllocations($c); 
$errors = $sf_request->getErrors();
?>
<h1><?php echo $debate->getRound()->getName(); ?>- <?php echo $debate->getVenue()->getName();?>: <?php echo $debate->getTeam(DebateTeamXref::AFFIRMATIVE)->getName();?> (Affirmative) - <?php echo $debate->getTeam(DebateTeamXref::NEGATIVE)->getName();?> (Negative)</h1>
<?php echo form_tag('tournament/updateResults'); ?>
<table id="display" class="bordered-table">
    <tbody>
        <tr>
            <td><strong>Adjudicator</strong></td>
            <?php foreach($adjudicatorAllocations as $adjudicatorAllocation):?>
            <td><?php echo $adjudicatorAllocation->getAdjudicator()->getName(); ?></td> 
            <?php endforeach; ?>
        </tr>
        <tr>
            <td><strong>Voted for</strong></td>
            <?php 
            $teams_opts_for_select = array();
            foreach($debate->getDebateTeamXrefs() as $debateTeamXref)
            {
                $teams_opts_for_select[$debateTeamXref->getTeamId()] = $debateTeamXref->getTeam()->getName();
            }
            
            $adjudicatorVotes = $sf_request->getParameter('adjudicator_votes', array());
            $tabindex = 1;
            foreach($adjudicatorAllocations as $adjudicatorAllocation):
            ?>
            <td>
                <?php
                echo select_tag(
                    "adjudicator_votes[".$adjudicatorAllocation->getId()."]", 
                    options_for_select(
                        $teams_opts_for_select, 
                        $adjudicatorAllocation->isComplete() ? 
                        $adjudicatorAllocation->getTeamByScore(1)->getId() :
                        (isset($adjudicatorVotes[$adjudicatorAllocation->getId()]) ? 
                        $adjudicatorAllocation->getId() : null)
                    ),
                    array('class' => 'adjudicator_votes span3', 'tabindex' => $tabindex)
                );
                if ($tabindex == 1) 
                {
                    $tabindex += 17;
                }
                else
                {
                    $tabindex += 9;
                }
               
                ?>
                <span class="error"><?php echo isset($errors['adjudicator_votes'][$adjudicatorAllocation->getId()]) ? $errors['adjudicator_votes'][$adjudicatorAllocation->getId()] : null; ?></span>
            </td>
            <?php endforeach; ?>
        </tr>
    </tbody>
</table>
<table class="zebra-striped bordered-table condensed-table">
    <thead>
        <tr>
            <th colspan="<?php echo (3 + $debate->countAdjudicatorAllocations($c)); ?>">GOVERNMENT</th>
            <th colspan="<?php echo (3 + $debate->countAdjudicatorAllocations($c)); ?>">OPPOSITION</th>
        </tr>
        <tr>
            <th id="<?php echo "team_name_" + $debate->getTeam(DebateTeamXref::AFFIRMATIVE)->getId();?>"><?php echo $debate->getTeam(DebateTeamXref::AFFIRMATIVE)->getName();?></th>
            <th>Speaker</th>
            <?php foreach($adjudicatorAllocations as $adjudicatorAllocation):?>
            <th><?php echo $adjudicatorAllocation->getAdjudicator()->getName(); ?></th> 
            <?php endforeach; ?>
            <th>Average</th>
            <th id="<?php echo "team_name_" + $debate->getTeam(DebateTeamXref::NEGATIVE)->getId();?>"><?php echo $debate->getTeam(DebateTeamXref::NEGATIVE)->getName();?></th>
            <th>Speaker</th>
            <?php foreach($adjudicatorAllocations as $adjudicatorAllocation):?>
            <th><?php echo $adjudicatorAllocation->getAdjudicator()->getName(); ?></th> 
            <?php endforeach; ?>
            <th>Average</th>
        </tr>
    </thead>
    <tbody>
    <?php
    $count = 0;
    foreach(SpeakerScoreSheet::getSpeakerPositions() as $speakerPosition => $description)
    {
        speaker_entry_row($speakerPosition, $description, $debate, $adjudicatorAllocations, $sf_request->getParameter('speaker_scores'), $errors, $count);
        $count++;
    }
    ?>
        <tr>
            <td colspan="2"><strong>TOTAL AFF SCORES</strong></td>
            <?php foreach($adjudicatorAllocations as $adjudicatorAllocation):?>
            <td id="<?php echo "total_speaker_scores_".$debate->getDebateTeamXref(DebateTeamXref::AFFIRMATIVE)->getId()."_".$adjudicatorAllocation->getId(); ?>"><?php echo $adjudicatorAllocation->getTeamTotalSpeakerScore($debate->getDebateTeamXref(DebateTeamXref::AFFIRMATIVE));?></td>
            <?php endforeach; ?>
            <td id="<?php echo "total_average_speaker_scores_".$debate->getDebateTeamXref(DebateTeamXref::AFFIRMATIVE)->getId(); ?>">0</td>
            <td colspan="2"><strong>TOTAL NEG SCORES</strong></td>
            <?php foreach($adjudicatorAllocations as $adjudicatorAllocation):?>
            <td id="<?php echo "total_speaker_scores_".$debate->getDebateTeamXref(DebateTeamXref::NEGATIVE)->getId()."_".$adjudicatorAllocation->getId(); ?>"><?php echo $adjudicatorAllocation->getTeamTotalSpeakerScore($debate->getDebateTeamXref(DebateTeamXref::NEGATIVE));?></td>
            <?php endforeach; ?>
            <td id="<?php echo "total_average_speaker_scores_".$debate->getDebateTeamXref(DebateTeamXref::NEGATIVE)->getId(); ?>">0</td>
        </tr>
    </tbody>
</table>
<?php echo input_hidden_tag("id", $debate->getId()); ?>
<?php echo input_hidden_tag("affirmative_team_id", $debate->getDebateTeamXref(DebateTeamXref::AFFIRMATIVE)->getTeamId()); ?>
<?php echo input_hidden_tag("negative_team_id", $debate->getDebateTeamXref(DebateTeamXref::NEGATIVE)->getTeamId()); ?>
<?php echo input_hidden_tag("affirmative_debate_team_xref_id", $debate->getDebateTeamXref(DebateTeamXref::AFFIRMATIVE)->getId()); ?>
<?php echo input_hidden_tag("negative_debate_team_xref_id", $debate->getDebateTeamXref(DebateTeamXref::NEGATIVE)->getId()); ?>
<?php echo submit_tag("Save changes", array("class" => "btn primary", 'tabindex' => 36)); ?>
</form>

<?php
function debater_select_tag($name, $debaters, $selectedDebaterId, $options = array())
{
    $opts = array();
    foreach($debaters as $debater)
    {
        $opts[$debater->getId()] = $debater->getName();
    }
    return select_tag($name, options_for_select($opts, !is_null($selectedDebaterId) ? $selectedDebaterId : null), $options);
}

function speaker_entry_row($speakerPosition, $description, $debate, $adjudicatorAllocations, $speakerScores, $errors, $count)
{
?>
        <tr>
            <td><strong>AFF <?php echo $description;?></strong></td>
            <td>
                <?php 
                echo debater_select_tag(
                    "speaker_scores[".$debate->getDebateTeamXref(DebateTeamXref::AFFIRMATIVE)->getId()."][".$speakerPosition."][debater_id]",
                    $debate->getTeam(DebateTeamXref::AFFIRMATIVE)->getDebaters(),
                    !is_null($debate->getDebateTeamXref(DebateTeamXref::AFFIRMATIVE)->getSpeaker($speakerPosition)) ? 
                    $debate->getDebateTeamXref(DebateTeamXref::AFFIRMATIVE)->getSpeaker($speakerPosition)->getId() :
                    (isset($speakerScores[$debate->getDebateTeamXref(DebateTeamXref::AFFIRMATIVE)->getId()][$speakerPosition]['debater_id']) ? 
                    $speakerScores[$debate->getDebateTeamXref(DebateTeamXref::AFFIRMATIVE)->getId()][$speakerPosition]['debater_id'] : null),
                    array('class' => 'span4', "tabindex" => 2 + $count)
                ); 
                ?>
                <span class="error"><?php echo isset($errors['speaker_scores'][$debate->getDebateTeamXref(DebateTeamXref::AFFIRMATIVE)->getId()][$speakerPosition]['debater_id']) ? $errors['speaker_scores'][$debate->getDebateTeamXref(DebateTeamXref::AFFIRMATIVE)->getId()][$speakerPosition]['debater_id'] : null; ?></span>
            </td>
            <?php
                $affHorizontalIndex = 6;
            ?>
            <?php foreach($adjudicatorAllocations as $adjudicatorAllocation):?>
            <td>
                <?php
                echo input_tag(
                    "speaker_scores[".$debate->getDebateTeamXref(DebateTeamXref::AFFIRMATIVE)->getId()."][".$speakerPosition."][scores][".$adjudicatorAllocation->getId()."]",
                    $adjudicatorAllocation->hasSpeakerScoreSheetForDebateAndSpeakerPosition
                    (
                        $speakerPosition,
                        $debate->getDebateTeamXref(DebateTeamXref::AFFIRMATIVE)
                    ) ? $adjudicatorAllocation->getSpeakerScoreSheetByDebateAndSpeakerPosition
                    (
                        $speakerPosition,
                        $debate->getDebateTeamXref(DebateTeamXref::AFFIRMATIVE)
                    )->getScore() : 
                    (isset($speakerScores[$debate->getDebateTeamXref(DebateTeamXref::AFFIRMATIVE)->getId()][$speakerPosition]['scores'][$adjudicatorAllocation->getId()]) ?
                    $speakerScores[$debate->getDebateTeamXref(DebateTeamXref::AFFIRMATIVE)->getId()][$speakerPosition]['scores'][$adjudicatorAllocation->getId()] : 0),
                    array('size' => 3, 'tabindex' => $affHorizontalIndex + $count, 'class' => "span2 speaker_scores speaker_scores_" . $debate->getDebateTeamXref(DebateTeamXref::AFFIRMATIVE)->getId() . "_" . $adjudicatorAllocation->getId() . " speaker_scores_for_average_" . $debate->getDebateTeamXref(DebateTeamXref::AFFIRMATIVE)->getId() . "_" . $speakerPosition)
                );

                    if ($affHorizontalIndex == 6)
                    {
                        $affHorizontalIndex += 13; 
                    }
                    else
                    {
                        $affHorizontalIndex += 9;
                    }
                ?>
                <span class="error"><?php echo isset($errors['speaker_scores'][$debate->getDebateTeamXref(DebateTeamXref::AFFIRMATIVE)->getId()][$speakerPosition]['scores'][$adjudicatorAllocation->getId()]) ? $errors['speaker_scores'][$debate->getDebateTeamXref(DebateTeamXref::AFFIRMATIVE)->getId()][$speakerPosition]['scores'][$adjudicatorAllocation->getId()] : null; ?></span>
            </td> 
            <?php endforeach; ?>
            <td id="<?php echo "speaker_scores_".$debate->getDebateTeamXref(DebateTeamXref::AFFIRMATIVE)->getId()."_".$speakerPosition."_average_score"; ?>" class="<?php echo 'average_speaker_score_' . $debate->getDebateTeamXref(DebateTeamXref::AFFIRMATIVE)->getId();?>"><?php echo $debate->getDebateTeamXref(DebateTeamXref::AFFIRMATIVE)->getSpeakerScoreForPosition($speakerPosition);?></td>
            
            <td><strong>NEG <?php echo $description;?></strong></td>
            <td>
                <?php 
                echo debater_select_tag(
                    "speaker_scores[".$debate->getDebateTeamXref(DebateTeamXref::NEGATIVE)->getId()."][".$speakerPosition."][debater_id]",
                    $debate->getTeam(DebateTeamXref::NEGATIVE)->getDebaters(),
                    !is_null($debate->getDebateTeamXref(DebateTeamXref::NEGATIVE)->getSpeaker($speakerPosition)) ? 
                    $debate->getDebateTeamXref(DebateTeamXref::NEGATIVE)->getSpeaker($speakerPosition)->getId() :
                    (isset($speakerScores[$debate->getDebateTeamXref(DebateTeamXref::NEGATIVE)->getId()][$speakerPosition]['debater_id']) ? 
                    $speakerScores[$debate->getDebateTeamXref(DebateTeamXref::NEGATIVE)->getId()][$speakerPosition]['debater_id'] : null),
                    array('class' => 'span4', 'tabindex' => 10 + $count)
                ); 
                ?>
                <span class="error"><?php echo isset($errors['speaker_scores'][$debate->getDebateTeamXref(DebateTeamXref::NEGATIVE)->getId()][$speakerPosition]['debater_id']) ? $errors['speaker_scores'][$debate->getDebateTeamXref(DebateTeamXref::NEGATIVE)->getId()][$speakerPosition]['debater_id'] : null; ?></span>
            </td>
            <?php
                $negHorizontalIndex = 14;
            ?>
            <?php foreach($adjudicatorAllocations as $adjudicatorAllocation):?>
            <td>
                <?php
                echo input_tag(
                    "speaker_scores[".$debate->getDebateTeamXref(DebateTeamXref::NEGATIVE)->getId()."][".$speakerPosition."][scores][".$adjudicatorAllocation->getId()."]",
                    $adjudicatorAllocation->hasSpeakerScoreSheetForDebateAndSpeakerPosition
                    (
                        $speakerPosition,
                        $debate->getDebateTeamXref(DebateTeamXref::NEGATIVE)
                    ) ? $adjudicatorAllocation->getSpeakerScoreSheetByDebateAndSpeakerPosition
                    (
                        $speakerPosition,
                        $debate->getDebateTeamXref(DebateTeamXref::NEGATIVE)
                    )->getScore() :                     
                    (isset($speakerScores[$debate->getDebateTeamXref(DebateTeamXref::NEGATIVE)->getId()][$speakerPosition]['scores'][$adjudicatorAllocation->getId()]) ?
                    $speakerScores[$debate->getDebateTeamXref(DebateTeamXref::NEGATIVE)->getId()][$speakerPosition]['scores'][$adjudicatorAllocation->getId()] : 0),
                    array('size' => 3, 'tabindex' => $negHorizontalIndex + $count, 'class' => "span2 speaker_scores speaker_scores_" . $debate->getDebateTeamXref(DebateTeamXref::NEGATIVE)->getId() . "_" . $adjudicatorAllocation->getId() . " speaker_scores_for_average_" . $debate->getDebateTeamXref(DebateTeamXref::NEGATIVE)->getId() . "_" . $speakerPosition)
                );
                $negHorizontalIndex += 9; 
                ?>
                <span class="error"><?php echo isset($errors['speaker_scores'][$debate->getDebateTeamXref(DebateTeamXref::NEGATIVE)->getId()][$speakerPosition]['scores'][$adjudicatorAllocation->getId()]) ? $errors['speaker_scores'][$debate->getDebateTeamXref(DebateTeamXref::NEGATIVE)->getId()][$speakerPosition]['scores'][$adjudicatorAllocation->getId()] : null; ?></span>
            </td> 
            <?php endforeach; ?>
            <td id="<?php echo "speaker_scores_".$debate->getDebateTeamXref(DebateTeamXref::NEGATIVE)->getId()."_".$speakerPosition."_average_score"; ?>" class="<?php echo 'average_speaker_score_' . $debate->getDebateTeamXref(DebateTeamXref::NEGATIVE)->getId();?>"><?php echo $debate->getDebateTeamXref(DebateTeamXref::NEGATIVE)->getSpeakerScoreForPosition($speakerPosition);?></td>
        </tr>
<?php
}
?>
