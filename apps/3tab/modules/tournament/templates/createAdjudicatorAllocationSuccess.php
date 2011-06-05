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
<?php use_helper('Object') ?>
<h1>Draft matchups for <?php echo $round->getName();?></h1>
<?php echo form_tag('tournament/confirmAdjudicatorAllocation'); ?>
<?php foreach($sf_request->getErrors() as $name => $error): ?>
    <li><h2>Error: <?php echo $error ?></h2></li>
  <?php endforeach; ?>

<div id="window">
<h3 class="toggle">Unallocated Adjudicators</h3>
<div class="toggle-window">
	<?php foreach($unallocatedAdjudicators as $anAdjudicator):?>
	<?php echo $anAdjudicator->getInfoPlus(); ?>
	<br/>
	
	<?php endforeach; ?>
</div>	
</div>
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
					$allocation[0] = null;
				}
			?>
			<td>
               	<?php echo object_select_tag($allocation[0], 'getAdjudicatorId', array (
				 'related_class' => 'Adjudicator',
					  'text_method' => 'getInfo',
					  'control_name' => "adjudicatorId[$number][0]",
					  'include_blank' => true,
					)) ?>
				
            </td>
			<?php 
				if(count($allocation) < 2)
				{
					$allocation[1] = null;
				}
			?>
			<td>
                <?php echo object_select_tag($allocation[1], 'getAdjudicatorId', array (
				 'related_class' => 'Adjudicator',
					  'text_method' => 'getInfo',
					  'control_name' => "adjudicatorId[$number][1]",
					  'include_blank' => true,
					)) ?>
            </td>
			<?php 
				if(count($allocation) < 3)
				{
					$allocation[2] = null;
				}
			?>
			<td>            
				<?php echo object_select_tag($allocation[2], 'getAdjudicatorId', array (
				 'related_class' => 'Adjudicator',
					  'text_method' => 'getInfo',
					  'control_name' => "adjudicatorId[$number][2]",
					  'include_blank' => true,
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
