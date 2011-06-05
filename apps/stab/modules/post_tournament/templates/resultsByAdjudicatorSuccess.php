<script type="text/javascript">
jQuery(document).ready(function () {	
	jQuery("#subnav").hide();
	jQuery(".nav-admin").click(function() {
		jQuery("#subnav").toggle(300);
	});
});
</script>

<h1>Results By Adjudicator</h1>
<table>
    <thead>
        <tr>
            <th>Adjudicator</th>
            <th>Round 1</th>
			<th>Round 2</th>
			<th>Round 3</th>
			<th>Round 4</th>
			<th>Round 5</th>
			<th>Round 6</th>
			<th>Round 7</th>
			<th>Round 8</th>
        </tr>
    </thead>
    <tbody>
<?php
foreach($adjudicator as $adjudicator):
?>
    <tr>
        <td><?php echo $adjudicator->getName(); ?></td>
        <td><?php echo link_to($team->getWinLossText($roundIds[0]), "post_tournament/viewScoreSheets?debateId=".$team->getDebate($roundIds[0])->getId()) ?></td>
		<td><?php echo link_to($team->getWinLossText($roundIds[1]), "post_tournament/viewScoreSheets?debateId=".$team->getDebate($roundIds[1])->getId()) ?></td>
		<td><?php echo link_to($team->getWinLossText($roundIds[2]), "post_tournament/viewScoreSheets?debateId=".$team->getDebate($roundIds[2])->getId()) ?></td>
		<td><?php echo link_to($team->getWinLossText($roundIds[3]), "post_tournament/viewScoreSheets?debateId=".$team->getDebate($roundIds[3])->getId())?></td>
		<td><?php echo link_to($team->getWinLossText($roundIds[4]), "post_tournament/viewScoreSheets?debateId=".$team->getDebate($roundIds[4])->getId()) ?></td>
		<td><?php echo link_to($team->getWinLossText($roundIds[5]), "post_tournament/viewScoreSheets?debateId=".$team->getDebate($roundIds[5])->getId()) ?></td>
		<td><?php echo link_to($team->getWinLossText($roundIds[6]), "post_tournament/viewScoreSheets?debateId=".$team->getDebate($roundIds[6])->getId()) ?></td>
		<td><?php echo link_to($team->getWinLossText($roundIds[7]), "post_tournament/viewScoreSheets?debateId=".$team->getDebate($roundIds[7])->getId()) ?></td>
	</tr>
<?php
endforeach;
?>
    </tbody>
</table>
<div id="button">
<?php echo link_to ('back', 'post_tournament/index') ?>
</div>