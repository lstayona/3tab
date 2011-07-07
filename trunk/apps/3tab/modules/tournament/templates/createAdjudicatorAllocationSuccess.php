<script type="text/javascript">
jQuery(document).ready(function () {	
	jQuery("#subnav").hide();
	jQuery(".nav-admin").click(function() {
		jQuery("#subnav").toggle(300);
	});
	jQuery("h3.toggle").click(function() {
		jQuery(".toggle-window").toggle(100);
	});	
});
</script>
<?php ini_set('memory_limit', '128M') //the sort is very memory intensive ?>
<?php use_helper('Object'); ?>
<?php use_helper('3tabForm'); ?>
<h1>Draft matchups for <?php echo $round->getName();?></h1>
<?php echo form_tag('tournament/confirmAdjudicatorAllocation'); ?>
<?php if ($sf_request->hasErrors()):?>
<ul class="error">
<?php foreach($sf_request->getErrors() as $name => $error): ?>
    <li id="<?php echo $name; ?>"><?php echo $error; ?></li>
<?php endforeach; ?>
</ul>
<?php endif; ?>

<br clear="all">
<table id="display">
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
                <?php echo adjudicator_select_tag("adjudicatorId[$number][0]", $sf_request->getParameter("adjudicatorId[$number][0]", $allocation[0]->getAdjudicatorId()), true, array("class" => "adjudicator_selector")); ?>
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
                <?php echo adjudicator_select_tag("adjudicatorId[$number][1]", $sf_request->getParameter("adjudicatorId[$number][1]", $allocation[1]->getAdjudicatorId()), true, array("class" => "adjudicator_selector")); ?>
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
                <?php echo adjudicator_select_tag("adjudicatorId[$number][2]", $sf_request->getParameter("adjudicatorId[$number][2]", $allocation[2]->getAdjudicatorId()), true, array("class" => "adjudicator_selector")); ?>
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
    <?php echo submit_tag("Confirm");?>
</div>	
</form>
