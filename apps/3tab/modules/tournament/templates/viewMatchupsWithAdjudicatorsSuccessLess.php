<script type="text/javascript">
jQuery(document).ready(function () {	
	jQuery("#subnav").hide();
	jQuery(".nav-admin").click(function() {
		jQuery("#subnav").toggle(300);
	});
});
</script>
<h1>Matchups for <?php echo $round->getName();?></h1>
<table id="big">
    <thead>
        <tr>
            <th>Venue</th>
            <th>Affirmative</th>
            <th>Negative</th>
			<th>Chair</th>
			<th>Panel 1</th>
			<th>Panel 2</th>
			<th>Trainee 1</th>
        </tr>
    </thead>
    <tbody>
<?php
foreach($round->getDebates() as $number => $debate):
?>
        <tr>
            <td>
                <?php echo $debate->getVenue()->getName(); ?>
            </td>
            <td>
                <?php echo $debate->getTeam(DebateTeamXref::AFFIRMATIVE)->getName(); ?>
            </td>
            <td>
                <?php echo $debate->getTeam(DebateTeamXref::NEGATIVE)->getName(); ?>
            </td>
			<?php 
				$c = new Criteria();
				$c->addAscendingOrderByColumn(AdjudicatorAllocationPeer::TYPE);
				$adjudicatorAllocations = $debate->getAdjudicatorAllocations($c); 
				$chair = $adjudicatorAllocations[0]->getAdjudicator();
			?>
			<td>
				<?php echo $adjudicatorAllocations[0]->getAdjudicator()->getInfo(); ?>
			</td>
			<td>
				<?php 
					if(count($adjudicatorAllocations) > 1)
					{
						echo $adjudicatorAllocations[1]->getAdjudicator()->getInfo(); 
					}
				?>
			</td>
			<td>
				<?php 
					if(count($adjudicatorAllocations) > 1)
					{
						echo $adjudicatorAllocations[2]->getAdjudicator()->getInfo(); 
					}
				?>
			</td>
			<?php
				$trainees = $chair->getTrainees($round);
			?>
			<td>
				<?php
					if(count($trainees) > 0)
					{
						echo $trainees[0]->getInfo();
					}
				?>
			</td>
        </tr>
<?php
endforeach;

?>
    </tbody>
</table>
<div id="button">
<?php echo link_to("Back", 'tournament/index'); ?>
</div>
