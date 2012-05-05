<?php 
use_helper('Object');
use_helper('Bootstrap');
?>
<?php if(!$sf_request->hasParameter('id')): ?>
<h1>Create Team</h1>
<?php else: ?>
<h1>Edit Team</h1>
<?php endif; ?>

<?php if ($sf_request->hasErrors()): ?>
<div class="alert-message error">There were errors in the submitted data.</div>
<?php endif; ?>

<?php echo form_tag('team/update') ?>

    <?php echo object_input_hidden_tag($team, 'getId') ?>
    <fieldset>
        <!-- Name input field -->
        <?php echo bootstrap_stateful_form_control('name', 'Name', object_input_tag($team, 'getName', array ('size' => 20, 'id' => 'name', "name" => "name", 'class' => 'xlarge')), array("error" => $sf_request->getErrors())); ?>
        <!-- Institution select box -->
        <?php echo bootstrap_stateful_form_control('institution_id', 'Institution', object_select_tag($team, 'getInstitutionId', array ('related_class' => 'Institution', 'text_method' => 'getName',)), array("error" => $sf_request->getErrors())); ?>
         <!-- Swing status checkbox -->
        <?php echo bootstrap_stateful_form_control('swing', 'Swing', object_checkbox_tag($team, 'getSwing', array ()), array("error" => $sf_request->getErrors())); ?>
         <!-- Active status checkbox -->
        <?php echo bootstrap_stateful_form_control('active', 'Active', object_checkbox_tag($team, 'getActive', array ()), array("error" => $sf_request->getErrors())); ?>
        <!-- Debaters input field -->
        <?php
        $debaterErrors = $sf_request->getError('debaters');
        foreach ($team->getDebaters() as $count => $debater)
        {
            echo bootstrap_stateful_form_control('name', 'Debater ' . ($count + 1), input_tag('debaters['.$count.'][name]', $debater->getName(), array('class' => 'xlarge')), array("error" => isset($debaterErrors[$count]) ? $debaterErrors[$count] : array()));
            echo input_hidden_tag('debaters['.$count.'][debater_id]', $debater->getId());
        }
        ?>
    </fieldset>
    <div id="button">
        <?php echo submit_tag('Save', array('class' => 'btn primary')) ?>
        <?php if ($team->getId()): ?>
            &nbsp;<?php echo link_to('Delete', 'team/delete?id='.$team->getId(), array('post' => true, 'confirm' => 'Are you sure?', 'class' => 'btn danger')) ?>
            &nbsp;<?php echo link_to('Cancel', 'team/show?id='.$team->getId(), array('class' => 'btn')) ?>
        <?php else: ?>
            &nbsp;<?php echo link_to('Cancel', 'team/list', array('class' => 'btn')) ?>
        <?php endif; ?>
    </div>
</form>
