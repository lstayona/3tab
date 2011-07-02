<script type="text/javascript">
jQuery(document).ready(function () {	
	jQuery("#subnav").hide();
	jQuery(".nav-admin").click(function() {
		jQuery("#subnav").toggle(300);
	});
});
</script>
<?php 
$adjudicatorAllocations = $debate->getAdjudicatorAllocations(); 
$errors = $sf_request->getErrors();
?>
<h1><?php echo $debate->getRound()->getName(); ?>- <?php echo $debate->getVenue()->getName();?>: <?php echo $debate->getTeam(DebateTeamXref::AFFIRMATIVE)->getName();?> (Affirmative) - <?php echo $debate->getTeam(DebateTeamXref::NEGATIVE)->getName();?> (Negative)</h1>
<hr />
<?php echo form_tag('tournament/updateResults'); ?>
<table id="display">
    <tbody>
        <tr>
            <td>Adjudicator</td>
            <?php foreach($adjudicatorAllocations as $adjudicatorAllocation):?>
            <td><?php echo $adjudicatorAllocation->getAdjudicator()->getName(); ?></td> 
            <?php endforeach; ?>
        </tr>
        <tr>
            <td>Voted for</td>
            <?php 
            $teams_opts_for_select = array();
            foreach($debate->getDebateTeamXrefs() as $debateTeamXref)
            {
                $teams_opts_for_select[$debateTeamXref->getTeamId()] = $debateTeamXref->getTeam()->getName();
            }
            
            $adjudicatorVotes = $sf_request->getParameter('adjudicator_votes', array());
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
                    array('class' => 'adjudicator_votes')
                );
                ?>
                <span class="error"><?php echo isset($errors['adjudicator_votes'][$adjudicatorAllocation->getId()]) ? $errors['adjudicator_votes'][$adjudicatorAllocation->getId()] : null; ?></span>
            </td>
            <?php endforeach; ?>
        </tr>
    </tbody>
</table>
<table>
    <thead>
        <tr>
            <th colspan="<?php echo (3 + $debate->countAdjudicatorAllocations()); ?>">AFFIRMATIVE</th>
            <th colspan="<?php echo (3 + $debate->countAdjudicatorAllocations()); ?>">NEGATIVE</th>
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
    foreach(SpeakerScoreSheet::getSpeakerPositions() as $speakerPosition => $description)
    {
        speaker_entry_row($speakerPosition, $description, $debate, $adjudicatorAllocations, $sf_request->getParameter('speaker_scores'), $errors);
    }
    ?>
        <tr>
            <td colspan="2">TOTAL AFF SCORES</td>
            <?php foreach($adjudicatorAllocations as $adjudicatorAllocation):?>
            <td id="<?php echo "total_speaker_scores_".$debate->getDebateTeamXref(DebateTeamXref::AFFIRMATIVE)->getId()."_".$adjudicatorAllocation->getId(); ?>"><?php echo $adjudicatorAllocation->getTeamTotalSpeakerScore($debate->getDebateTeamXref(DebateTeamXref::AFFIRMATIVE));?></td>
            <?php endforeach; ?>
            <td id="<?php echo "total_average_speaker_scores_".$debate->getDebateTeamXref(DebateTeamXref::AFFIRMATIVE)->getId(); ?>">0</td>
            <td colspan="2">TOTAL NEG SCORES</td>
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
<?php echo submit_tag(); ?>
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

function speaker_entry_row($speakerPosition, $description, $debate, $adjudicatorAllocations, $speakerScores, $errors)
{
?>
        <tr>
            <td>AFF <?php echo $description;?></td>
            <td>
                <?php 
                echo debater_select_tag(
                    "speaker_scores[".$debate->getDebateTeamXref(DebateTeamXref::AFFIRMATIVE)->getId()."][".$speakerPosition."][debater_id]",
                    $debate->getTeam(DebateTeamXref::AFFIRMATIVE)->getDebaters(),
                    !is_null($debate->getDebateTeamXref(DebateTeamXref::AFFIRMATIVE)->getSpeaker($speakerPosition)) ? 
                    $debate->getDebateTeamXref(DebateTeamXref::AFFIRMATIVE)->getSpeaker($speakerPosition)->getId() :
                    (isset($speakerScores[$debate->getDebateTeamXref(DebateTeamXref::AFFIRMATIVE)->getId()][$speakerPosition]['debater_id']) ? 
                    $speakerScores[$debate->getDebateTeamXref(DebateTeamXref::AFFIRMATIVE)->getId()][$speakerPosition]['debater_id'] : null)
                ); 
                ?>
                <span class="error"><?php echo isset($errors['speaker_scores'][$debate->getDebateTeamXref(DebateTeamXref::AFFIRMATIVE)->getId()][$speakerPosition]['debater_id']) ? $errors['speaker_scores'][$debate->getDebateTeamXref(DebateTeamXref::AFFIRMATIVE)->getId()][$speakerPosition]['debater_id'] : null; ?></span>
            </td>
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
                    array('size' => 5, 'class' => "speaker_scores speaker_scores_" . $debate->getDebateTeamXref(DebateTeamXref::AFFIRMATIVE)->getId() . "_" . $adjudicatorAllocation->getId() . " speaker_scores_for_average_" . $debate->getDebateTeamXref(DebateTeamXref::AFFIRMATIVE)->getId() . "_" . $speakerPosition)
                ); 
                ?>
                <span class="error"><?php echo isset($errors['speaker_scores'][$debate->getDebateTeamXref(DebateTeamXref::AFFIRMATIVE)->getId()][$speakerPosition]['scores'][$adjudicatorAllocation->getId()]) ? $errors['speaker_scores'][$debate->getDebateTeamXref(DebateTeamXref::AFFIRMATIVE)->getId()][$speakerPosition]['scores'][$adjudicatorAllocation->getId()] : null; ?></span>
            </td> 
            <?php endforeach; ?>
            <td id="<?php echo "speaker_scores_".$debate->getDebateTeamXref(DebateTeamXref::AFFIRMATIVE)->getId()."_".$speakerPosition."_average_score"; ?>" class="<?php echo 'average_speaker_score_' . $debate->getDebateTeamXref(DebateTeamXref::AFFIRMATIVE)->getId();?>"><?php echo $debate->getDebateTeamXref(DebateTeamXref::AFFIRMATIVE)->getSpeakerScoreForPosition($speakerPosition);?></td>
            
            <td>NEG <?php echo $description;?></td>
            <td>
                <?php 
                echo debater_select_tag(
                    "speaker_scores[".$debate->getDebateTeamXref(DebateTeamXref::NEGATIVE)->getId()."][".$speakerPosition."][debater_id]",
                    $debate->getTeam(DebateTeamXref::NEGATIVE)->getDebaters(),
                    !is_null($debate->getDebateTeamXref(DebateTeamXref::NEGATIVE)->getSpeaker($speakerPosition)) ? 
                    $debate->getDebateTeamXref(DebateTeamXref::NEGATIVE)->getSpeaker($speakerPosition)->getId() :
                    (isset($speakerScores[$debate->getDebateTeamXref(DebateTeamXref::NEGATIVE)->getId()][$speakerPosition]['debater_id']) ? 
                    $speakerScores[$debate->getDebateTeamXref(DebateTeamXref::NEGATIVE)->getId()][$speakerPosition]['debater_id'] : null)
                ); 
                ?>
                <span class="error"><?php echo isset($errors['speaker_scores'][$debate->getDebateTeamXref(DebateTeamXref::NEGATIVE)->getId()][$speakerPosition]['debater_id']) ? $errors['speaker_scores'][$debate->getDebateTeamXref(DebateTeamXref::NEGATIVE)->getId()][$speakerPosition]['debater_id'] : null; ?></span>
            </td>
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
                    array('size' => 5, 'class' => "speaker_scores speaker_scores_" . $debate->getDebateTeamXref(DebateTeamXref::NEGATIVE)->getId() . "_" . $adjudicatorAllocation->getId() . " speaker_scores_for_average_" . $debate->getDebateTeamXref(DebateTeamXref::NEGATIVE)->getId() . "_" . $speakerPosition)
                ); 
                ?>
                <span class="error"><?php echo isset($errors['speaker_scores'][$debate->getDebateTeamXref(DebateTeamXref::NEGATIVE)->getId()][$speakerPosition]['scores'][$adjudicatorAllocation->getId()]) ? $errors['speaker_scores'][$debate->getDebateTeamXref(DebateTeamXref::NEGATIVE)->getId()][$speakerPosition]['scores'][$adjudicatorAllocation->getId()] : null; ?></span>
            </td> 
            <?php endforeach; ?>
            <td id="<?php echo "speaker_scores_".$debate->getDebateTeamXref(DebateTeamXref::NEGATIVE)->getId()."_".$speakerPosition."_average_score"; ?>" class="<?php echo 'average_speaker_score_' . $debate->getDebateTeamXref(DebateTeamXref::NEGATIVE)->getId();?>"><?php echo $debate->getDebateTeamXref(DebateTeamXref::NEGATIVE)->getSpeakerScoreForPosition($speakerPosition);?></td>
        </tr>
<?php
}
?>
