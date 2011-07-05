<script type="text/javascript">
jQuery(document).ready(function () {	
	jQuery("#subnav").hide();
	jQuery(".nav-admin").click(function() {
		jQuery("#subnav").toggle(300);
	});
});
</script>
<?php use_helper('Object') ?>
<h1>Draft Trainee Allocations For <?php echo $round->getName();?></h1>
<?php echo form_tag('tournament/confirmTraineeAllocation'); ?>
<?php if ($sf_request->hasErrors()): ?>
<ul class="error">
<?php foreach($sf_request->getErrors() as $name => $error): ?>
    <li id="<?php echo $name; ?>"><?php echo $error; ?></li>
  <?php endforeach; ?>
</ul>
<?php endif; ?>
<table>
    <thead>
        <tr>
			<th>Debate</th>
			<th>Chair</th>
			<th>Trainee 1</th>
			<th>Trainee 2</th>
			<th>Trainee 3</th>
        </tr>
    </thead>
    <tbody>			
<?php
foreach($round->getDebates() as $number => $debate):
?>
        <tr>	
			<td><?php echo $debate->getInfo(); ?></td>
            <?php $chair = $debate->getChair(); ?>
            <td><?php echo $chair->getName(); ?></td>
			<?php echo input_hidden_tag("chairs[$number]", $chair->getId()); ?>
			<td>
			<?php echo select_tag("trainees[$number][0]", objects_for_select(
					  $trainees,
					  'getId',
					  'getInfo',
					  $sf_request->getParameter("trainees[$number][0]"),
					  'include_blank = true'
					)) ?>
			</td>
			<td>
			<?php echo select_tag("trainees[$number][1]", objects_for_select(
					  $trainees,
					  'getId',
					  'getInfo',
					  $sf_request->getParameter("trainees[$number][1]"),
					  'include_blank = true'
					)) ?>
			</td>
			<td>
			<?php echo select_tag("trainees[$number][2]", objects_for_select(
					  $trainees,
					  'getId',
					  'getInfo',
					  $sf_request->getParameter("trainees[$number][2]"),
					  'include_blank = true'
					)) ?>
			</td>
        </tr>
<?php
endforeach;
?>
    </tbody>
</table>
<div align="center">
    <?php echo input_hidden_tag('id', $round->getId()); ?>
    <?php echo submit_tag("Confirm");?>
</div>	
</form>
