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
        </tr>
    </thead>
    <tbody>
<?php 
	
	$debates = $round->getDebates();
	$randoms = array();
	foreach($debates as $number => $debate)
	{
		$randoms[$number] = rand();
	}
	arsort($randoms);
	
?>  

<?php foreach ($randoms as $number => $random): ?>
<?php $debate = $debates[$number];?>
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
				$c->add(AdjudicatorAllocationPeer::TYPE, AdjudicatorAllocation::ADJUDICATOR_TYPE_TRAINEE, Criteria::NOT_EQUAL);
				$c->addAscendingOrderByColumn(AdjudicatorAllocationPeer::TYPE);
				$c->addAscendingOrderByColumn(AdjudicatorAllocationPeer::ID);
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
        </tr>
<?php
endforeach;

?>
    </tbody>
</table>
<div id="button">
<?php echo link_to("Back", 'tournament/index'); ?>
</div>
