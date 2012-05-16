<?php use_helper('Object') ?>
<h1>Draft Trainee Allocations For <?php echo $round->getName();?></h1>
<?php if ($sf_request->hasErrors()):?>
<div class="alert-message error">
    <?php foreach($sf_request->getErrors() as $name => $error): ?>
    <span id="<?php echo $name; ?>"><?php echo $error; ?></span><br />
    <?php endforeach; ?>
</div>
<?php endif; ?>
<?php echo form_tag('tournament/confirmTraineeAllocation'); ?>
<table class="zebra-striped bordered-table">
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
foreach($debates as $number => $debate):
?>
        <tr>	
			<td><?php echo $debate->getInfo(); ?></td>
            <?php $chair = $debate->getChair(); ?>
            <td><?php echo $chair->getName(); ?></td>
			<?php echo input_hidden_tag("debates[$number]", $debate->getId()); ?>
			<td>
			<?php echo select_tag("trainees[$number][0]", objects_for_select(
					  $trainees,
					  'getId',
					  'getInfo',
					  $sf_request->getParameter("trainees[$number][0]"),
					  'include_blank = true'
					), array("class" => "adjudicator_selector")) ?>
            <?php echo input_hidden_tag("previous_adjudicator_value[$number][0]"); ?>
            <?php echo input_hidden_tag("previous_adjudicator_text[$number][0]"); ?>
			</td>
			<td>
			<?php echo select_tag("trainees[$number][1]", objects_for_select(
					  $trainees,
					  'getId',
					  'getInfo',
					  $sf_request->getParameter("trainees[$number][1]"),
					  'include_blank = true'
					), array("class" => "adjudicator_selector")) ?>
            <?php echo input_hidden_tag("previous_adjudicator_value[$number][1]"); ?>
            <?php echo input_hidden_tag("previous_adjudicator_text[$number][1]"); ?>
			</td>
			<td>
			<?php echo select_tag("trainees[$number][2]", objects_for_select(
					  $trainees,
					  'getId',
					  'getInfo',
					  $sf_request->getParameter("trainees[$number][2]"),
					  'include_blank = true'
					), array("class" => "adjudicator_selector")) ?>            
            <?php echo input_hidden_tag("previous_adjudicator_value[$number][2]"); ?>
            <?php echo input_hidden_tag("previous_adjudicator_text[$number][2]"); ?>
			</td>
        </tr>
<?php
endforeach;
?>
    </tbody>
</table>
<div align="center">
    <?php echo input_hidden_tag('id', $round->getId()); ?>
    <?php echo submit_tag("Confirm", array('class' => 'btn primary'));?>
</div>	
</form>
