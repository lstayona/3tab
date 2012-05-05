<?php use_helper('Object'); ?>
<?php use_helper('3tabForm'); ?>
<h1>Draft matchups for <?php echo $round->getName();?></h1>
<?php if ($sf_request->hasErrors()):?>
<div class="alert-message error">
    <?php foreach($sf_request->getErrors() as $name => $error): ?>
    <span id="<?php echo $name; ?>"><?php echo $error; ?></span><br />
    <?php endforeach; ?>
</div>
<?php endif; ?>
<?php echo form_tag('tournament/confirmAdjudicatorAllocation'); ?>
<br clear="all">
<table id="display" class="zebra-striped bordered-table">
    <thead>
        <tr>
            <th>Venue</th>
            <th>Aff</th>
            <th>Neg</th>
	        <th>Bracket</th>
			<th>Chair</th>
			<th>Panelist 1</th>
			<th>Panelist 2</th>
        </tr>
    </thead>
    <tbody>	
<?php
$select_options = get_adjudicator_select_options(AdjudicatorPeer::getAdjudicatorsByTestScore());
foreach($adjudicatorAllocations as $number => $allocation):
?>
        <tr>			
            <td>
                <?php echo $allocation[0]->getDebate()->getVenue()->getName();?>
				<?php echo input_hidden_tag("debateId[$number]", $allocation[0]->getDebate()->getId()); ?>
            </td>
            <td>
                <?php echo $allocation[0]->getDebate()->getTeam(DebateTeamXref::AFFIRMATIVE)->getName();?>
            </td>
            <td>
                <?php echo $allocation[0]->getDebate()->getTeam(DebateTeamXref::NEGATIVE)->getName(); ?>
            </td>
	    <td>
                <?php echo $allocation[0]->getDebate()->getBracket() ?>
            </td>
			<?php 
				if(count($allocation) < 1)
				{
					$allocation[0] = new AdjudicatorAllocation();
				}
			?>
			<td>
                <?php echo adjudicator_select_tag("adjudicatorId[$number][0]", $select_options, $sf_request->getParameter("adjudicatorId[$number][0]", $allocation[0]->getAdjudicatorId()), true, array("class" => "adjudicator_selector")); ?>
                <?php echo input_hidden_tag("previous_adjudicator_value[$number][0]"); ?>
                <?php echo input_hidden_tag("previous_adjudicator_text[$number][0]"); ?>
            </td>
			<?php 
				if(count($allocation) < 2)
				{
					$allocation[1] = new AdjudicatorAllocation();
				}
			?>
			<td>
                <?php echo adjudicator_select_tag("adjudicatorId[$number][1]", $select_options, $sf_request->getParameter("adjudicatorId[$number][1]", $allocation[1]->getAdjudicatorId()), true, array("class" => "adjudicator_selector")); ?>
                <?php echo input_hidden_tag("previous_adjudicator_value[$number][1]"); ?>
                <?php echo input_hidden_tag("previous_adjudicator_text[$number][1]"); ?>
            </td>
			<?php 
				if(count($allocation) < 3)
				{
					$allocation[2] = new AdjudicatorAllocation();
				}
			?>
			<td>            
                <?php echo adjudicator_select_tag("adjudicatorId[$number][2]", $select_options, $sf_request->getParameter("adjudicatorId[$number][2]", $allocation[2]->getAdjudicatorId()), true, array("class" => "adjudicator_selector")); ?>
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
