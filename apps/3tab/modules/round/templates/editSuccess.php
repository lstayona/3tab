<?php 
use_helper('Object') ;
use_helper('Bootstrap');
?>
<?php if($sf_request->hasParameter('id')): ?>
<h1>Edit Round</h1>
<?php else: ?>
<h1>Create Round</h1>
<?php endif; ?>

<?php if ($sf_request->hasErrors()): ?>
<div class="alert-message error">There were errors in the submitted data.</div>
<?php endif; ?>

<?php echo form_tag('round/update') ?>
    <?php echo object_input_hidden_tag($round, 'getId') ?>
    <fieldset>
        <!-- Name input field -->
        <?php echo bootstrap_stateful_form_control('name', 'Name', object_input_tag($round, 'getName', array ('size' => 20, 'id' => 'name', "name" => "name", 'class' => 'xlarge')), array("error" => $sf_request->getErrors())); ?>
        <!-- Type select box -->
        <?php echo bootstrap_stateful_form_control('type', 'Type', select_tag("type", options_for_select(array(Round::ROUND_TYPE_RANDOM => "Random", Round::ROUND_TYPE_PRELIMINARY => "Preliminary", Round::ROUND_TYPE_BUBBLE => "Bubble"), $sf_request->getParameter('type', $round->getType()))), array("error" => $sf_request->getErrors())); ?>
        <!-- Feedback weightage input field -->
        <?php echo bootstrap_stateful_form_control('feedback_weightage', 'Feedback weightage', object_input_tag($round, 'getFeedbackWeightage', array ('size' => 5, 'id' => 'feedback_weightage', "name" => "feedback_weightage", 'class' => 'xlarge')), array("error" => $sf_request->getErrors())); ?>
        <!-- Preceded by round select box -->
        <?php echo bootstrap_stateful_form_control('preceded_by_round_id', 'Preceded by round', object_select_tag($round, 'getPrecededByRoundId', array ('related_class' => 'Round','text_method' => 'getName', 'include_blank' => true)), array("error" => $sf_request->getErrors())); ?>
    </fieldset>
    <div id="button">
        <?php echo submit_tag('Save', array('class' => 'btn primary')) ?>
        &nbsp;<?php echo link_to('Delete', 'round/delete?id='.$round->getId(), array('post' => true, 'confirm' => 'Are you sure?', 'class' => 'btn')) ?>
        <?php if ($round->getId()): ?>
          &nbsp;<?php echo link_to('Cancel', 'round/show?id='.$round->getId(), array('class' => 'btn')) ?>
        <?php else: ?>
          &nbsp;<?php echo link_to('Cancel', 'round/list', array('class' => 'btn')) ?>
        <?php endif; ?>
    </div>
</form>
