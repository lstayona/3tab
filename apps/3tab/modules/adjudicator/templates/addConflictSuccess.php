<?php
use_helper('Object');
use_helper('Bootstrap');
?>

<h1>Add Conflict</h1>

<?php echo form_tag('adjudicator/createConflict') ?>
	<fieldset>
		<div class="clearfix control-group">
			<label>Adjudicator name</label>
			<div class="input"><?php echo $adjudicator->getName(); ?></div>
		</div>
		<div class="clearfix control-group">
			<label>Adjudicator institution</label>
			<div class="input"><?php echo $adjudicator->getInstitution()->getName(); ?></div>
		</div>
		<div class="clearfix control-group">
			<label>Conflict with</label>
			<div class="input"><?php echo select_tag('teamId', objects_for_select($teams, 'getId', 'getName')) ?></div>
		</div>
	</fieldset>
	<?php echo object_input_hidden_tag($adjudicator, 'getId') ?>
	<div id="button">
		<?php echo submit_tag('Save', array('class' => 'btn primary')) ?>
		<?php if ($adjudicator->getId()): ?>
		  &nbsp;<?php echo link_to('Cancel', 'adjudicator/edit?id='.$adjudicator->getId(), array('class' => 'btn')) ?>
		<?php else: ?>
		  &nbsp;<?php echo link_to('Cancel', 'adjudicator/list', array('class' => 'btn')) ?>
		<?php endif; ?>
	</div>
</form>
