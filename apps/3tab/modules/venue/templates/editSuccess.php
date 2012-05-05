<?php 
use_helper('Object');
use_helper('Bootstrap');
?>
<?php if ($sf_request->hasParameter('id')): ?>
<h1>Edit Venue</h1>
<?php else: ?>
<h1>Create Venue</h1>
<?php endif; ?>

<?php if ($sf_request->hasErrors()): ?>
<div class="alert-message error">There were errors in the submitted data.</div>
<?php endif; ?>

<?php echo form_tag('venue/update') ?>
    <?php echo object_input_hidden_tag($venue, 'getId') ?>
    <fieldset>
        <!-- Name input field -->
        <?php echo bootstrap_stateful_form_control('name', 'Name', object_input_tag($venue, 'getName', array ('size' => 20, 'class' => 'xlarge')), array("error" => $sf_request->getErrors())); ?>
        <!-- Active checkbox -->
        <?php echo bootstrap_stateful_form_control('active', 'Active', object_checkbox_tag($venue, 'getActive', array ()), array("error" => $sf_request->getErrors())); ?>
        <!-- Priority input field -->
        <?php echo bootstrap_stateful_form_control('priority', 'Priority', object_input_tag($venue, 'getPriority', array ('size' => 5, 'class' => 'xlarge')), array("error" => $sf_request->getErrors())); ?>
        <div id="button">
            <?php echo submit_tag('Save', array('class' => 'btn primary')) ?>
            <?php if ($venue->getId()): ?>
            &nbsp;<?php echo link_to('Delete', 'venue/delete?id='.$venue->getId(), array('post' => true, 'confirm' => 'Are you sure?', 'class' => 'btn')) ?>
            &nbsp;<?php echo link_to('Cancel', 'venue/show?id='.$venue->getId(), array('class' => 'btn')) ?>
            <?php else: ?>
            &nbsp;<?php echo link_to('Cancel', 'venue/list', array('class' => 'btn')) ?>
            <?php endif; ?>
        </div>
    </fieldset>
</form>
