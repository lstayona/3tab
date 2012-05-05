<script type="text/javascript">
jQuery(document).ready(function () {	
	jQuery("#subnav").hide();
	jQuery(".nav-admin").click(function() {
		jQuery("#subnav").toggle(300);
	});
});
</script>
<h1>Matchups for <?php echo $round->getName();?></h1>
<table id="big" class="zebra-striped bordered-table">
    <thead>
        <tr>
            <th>Venue</th>
            <th>Affirmative</th>
            <th>Negative</th>
			<th>Panel</th>
			<th>Trainees</th>
        </tr>
    </thead>
    <tbody>
<?php
$c = new Criteria();
$c->addAscendingOrderByColumn("RANDOM()");
foreach($round->getDebates($c) as $number => $debate):
?>
        <tr>
            <td style="font-size: 140%">
                <?php echo $debate->getVenue()->getName(); ?>
            </td>
            <td style="font-size: 140%">
                <?php echo $debate->getTeam(DebateTeamXref::AFFIRMATIVE)->getName(); ?>
            </td>
            <td style="font-size: 140%">
                <?php echo $debate->getTeam(DebateTeamXref::NEGATIVE)->getName(); ?>
            </td>
			<?php 
				$c = new Criteria();
				$c->addAscendingOrderByColumn(AdjudicatorAllocationPeer::TYPE);
				$adjudicatorAllocations = $debate->getAdjudicatorAllocations($c); 
				$chair = $adjudicatorAllocations[0]->getAdjudicator();
			?>
			<td>
                <ul>
                <?php
                foreach ($adjudicatorAllocations as $adjudicatorAllocation):
                    if ($adjudicatorAllocation->getType() == AdjudicatorAllocation::ADJUDICATOR_TYPE_CHAIR) {
                ?>
                    <li style="font-weight: bold; font-size: 120%"><?php echo $adjudicatorAllocation->getAdjudicator()->getName(); ?></li>
                <?php
                    } elseif ($adjudicatorAllocation->getType() == AdjudicatorAllocation::ADJUDICATOR_TYPE_PANELIST) {
                ?>
                    <li style="font-size: 120%"><?php echo $adjudicatorAllocation->getAdjudicator()->getName(); ?></li>
                <?php
                    }
                endforeach;
                ?>
                </ul>
			</td>
			<?php
				$trainees = $chair->getTrainees($round);
			?>
			<td>
				<?php
					if(count($trainees) > 0)
					{
                ?>
                <ul>
                <?php
                        foreach ($trainees as $trainee)
                        {
                ?>
						<li><?php echo $trainee->getName(); ?></li>
                <?php
                        }
                ?>
                </ul>
                <?php
					}
				?>
			</td>
        </tr>
<?php
endforeach;

?>
    </tbody>
</table>
