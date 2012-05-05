<?php 
use_helper('Object');
use_helper('Bootstrap');
?>
<?php if ($sf_request->hasParameter('id')): ?>
<h1>Edit Institution</h1>
<?php else: ?>
<h1>Create Institution</h1>
<?php endif; ?>

<?php if ($sf_flash->has("success")): ?>
<div class="alert-message success">
    <?php echo $sf_flash->get("success"); ?>
</div>
<?php endif; ?>

<?php if ($sf_request->hasErrors()): ?>
<div class="alert-message error">There were errors in the submitted data.</div>
<?php endif; ?>

<?php echo form_tag('adjudicator/update') ?>
	<fieldset>
		<?php echo object_input_hidden_tag($adjudicator, 'getId') ?>
		<!-- Name input field -->
		<?php echo bootstrap_stateful_form_control('name', 'Name', object_input_tag($adjudicator, 'getName', array ('size' => 60, 'id' => 'name', "name" => "name", 'class' => 'xlarge')), array("error" => $sf_request->getErrors())); ?>
		<!-- Adjudicator test score input field -->
		<?php echo bootstrap_stateful_form_control('test_score', 'Test score', object_input_tag($adjudicator, 'getTestScore', array ('size' => 60, 'id' => 'test_score', "name" => "test_score", 'class' => 'xlarge')), array("error" => $sf_request->getErrors())); ?>
		 <!-- Institution select box -->
        <?php echo bootstrap_stateful_form_control('institution_id', 'Institution', object_select_tag($adjudicator, 'getInstitutionId', array ('related_class' => 'Institution', 'text_method' => 'getName',)), array("error" => $sf_request->getErrors())); ?>
        <!-- Active status checkbox -->
        <?php echo bootstrap_stateful_form_control('active', 'Active', object_checkbox_tag($adjudicator, 'getActive', array ()), array("error" => $sf_request->getErrors())); ?>
	</fieldset>
	<h2>Conflicts</h2>
	<fieldset>
		<table class="bordered-table zebra-striped">
			<?php foreach($adjudicator->getAdjudicatorConflicts() as $conflict): ?>
			<tr>
				<td> <?php echo $conflict->getId(); ?> </td>
				<td> <?php echo	$conflict->getTeam()->getName(); ?> </td>
				<td> <?php echo $conflict->getTeam()->getInstitution()->getName(); ?> </td>
				<td>
				<?php if($conflict->getTeam()->getInstitutionId() != $conflict->getAdjudicator()->getInstitutionId()): ?>
				<?php echo link_to('Delete', 'adjudicator/deleteConflict?conflictId='.$conflict->getId(), array('post' => true, 'confirm' => 'Are you sure?', 'class' => 'btn danger')) ?>
				<?php else: ?>
				<?php echo "Cannot remove conflicts with teams from own institution."; ?>
				<?php endif; ?>
				</td>
			</tr>
			<?php endforeach; ?>
		</table>
		<?php echo link_to('Add conflict', 'adjudicator/addConflict?id='.$adjudicator->getId(), array('class' => 'btn')) ?>	
	</fieldset>
	<div id="button">
		<?php echo submit_tag('Save', array('class' => 'btn primary')) ?>
		<?php if ($adjudicator->getId()): ?>
			<?php echo link_to('Delete', 'adjudicator/delete?id='.$adjudicator->getId(), array('post' => true, 'confirm' => 'Are you sure?', 'class' => 'btn danger')) ?>
			&nbsp;<?php echo link_to('Cancel', 'adjudicator/show?id='.$adjudicator->getId(), array('class' => 'btn')) ?>
		<?php else: ?>
			&nbsp;<?php echo link_to('Cancel', 'adjudicator/list', array('class' => 'btn')) ?>
		<?php endif; ?>
	</div>
</form>