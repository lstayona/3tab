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
			<th>Bracket</th>
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
			<td>
                <?php echo $debate->getBracket(); ?>
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
