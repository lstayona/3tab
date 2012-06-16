<script type="text/javascript">
jQuery(document).ready(function () {	
	jQuery("#subnav").hide();
	jQuery(".nav-admin").click(function() {
		jQuery("#subnav").toggle(300);
	});
});
</script>

<h1>Tournament Results</h1>
<table>
<tr>
	<td><div id="button"><?php echo link_to("View Team Rankings", "post_tournament/teamRankings") ?></div></td>
	<td><div id="button"><?php echo link_to("View Speaker Rankings", "post_tournament/speakerRankings") ?></div></td>
</tr>
</table>
<table>
<tr>
	<td><div id="button"><?php echo link_to("View Results By Round", "post_tournament/resultsByRound") ?></div></td>
	<td><div id="button"><?php echo link_to("View Results By Team", "post_tournament/resultsByTeam") ?></div></td>
	<td><div id="button"><?php //echo link_to("View Results By Adjudicator", "post_tournament/resultsByAdjudicator") ?></div></td>
</tr>
</table>
<table>
<tr>
        <td><div id="button"><?php echo link_to("View Adjudicator Feedback Scores", "post_tournament/adjudicatorRankings")?></div></td>
</tr>
</table>
</table>