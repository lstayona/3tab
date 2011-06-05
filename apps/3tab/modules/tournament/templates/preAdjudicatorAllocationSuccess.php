<script type="text/javascript">
jQuery(document).ready(function () {	
	jQuery("#subnav").hide();
	jQuery(".nav-admin").click(function() {
		jQuery("#subnav").toggle(300);
	});
});
</script>
<h1>Draft matchups for <?php echo $round->getName();?></h1>
<?php echo form_tag('tournament/createAdjudicatorAllocation'); ?>
<table id="display">
    <thead>
        <tr>
            <th>Venue</th>
            <th>Aff</th>
            <th>Neg</th>
			<th>Bracket</th>
			<th>Energy</th>
        </tr>
    </thead>
    <tbody>
<?php
foreach($debates as $number => $debate):
?>
        <tr>
            <td>
                <?php echo $debate->getVenue()->getName();?>
            </td>
            <td>
                <?php echo $debate->getTeam(DebateTeamXref::AFFIRMATIVE)->getName();?>
            </td>
            <td>
                <?php echo $debate->getTeam(DebateTeamXref::NEGATIVE)->getName(); ?>
            </td>			
            <td>
                <?php echo $debate->getBracket(); ?>
            </td>
			
            <td>
		<?php echo input_tag("debateEnergies[$number]", $debate->getEnergy()) ?>
            </td>
        </tr>
<?php
endforeach;
?>
    </tbody>
</table>
<div id="button">
    <?php echo input_hidden_tag('id', $round->getId()); ?>
    <?php echo submit_tag("Confirm");?>
</div>	
</form>
