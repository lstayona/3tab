<?php 
use_helper('Object');
use_helper('Bootstrap');
?>
<?php if ($sf_request->hasParameter('id')): ?>
<h1>Edit Institution</h1>
<?php else: ?>
<h1>Create Institution</h1>
<?php endif; ?>

<?php if ($sf_request->hasErrors()): ?>
<div class="alert-message error">There were errors in the submitted data.</div>
<?php endif; ?>

<?php echo form_tag('institution/update') ?>
    <fieldset>
        <!-- Code input field -->
        <?php echo bootstrap_stateful_form_control('code', 'Code', object_input_tag($institution, 'getCode', array ('size' => 40, 'id' => 'code', "name" => "code", 'class' => 'xlarge')), array("error" => $sf_request->getErrors())); ?>
        <!-- Name input field -->
        <?php echo bootstrap_stateful_form_control('name', 'Name', object_input_tag($institution, 'getName', array ('size' => 40, 'id' => 'name', "name" => "name", 'class' => 'xlarge')), array("error" => $sf_request->getErrors())); ?>
        <?php echo object_input_hidden_tag($institution, 'getId') ?>
        <div id="actions">
            <?php echo submit_tag('Save', array('class' => 'btn primary')) ?>
            <?php if ($institution->getId()): ?>
                &nbsp;<?php echo link_to('Delete', 'institution/delete?id='.$institution->getId(), array('post' => true, 'confirm' => 'Are you sure?', 'class' => 'btn')) ?>
                &nbsp;<?php echo link_to('Cancel', 'institution/show?id='.$institution->getId(), array('class' => 'btn')) ?>
            <?php else: ?>
                &nbsp;<?php echo link_to('Cancel', 'institution/list', array('class' => 'btn')) ?>
            <?php endif; ?>
        </div>
    </fieldset>
</form>
