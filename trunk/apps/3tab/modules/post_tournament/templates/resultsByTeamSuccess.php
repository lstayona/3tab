<script type="text/javascript">
jQuery(document).ready(function () {	
	jQuery("#subnav").hide();
	jQuery(".nav-admin").click(function() {
		jQuery("#subnav").toggle(300);
	});
});
</script>

<h1>Results By Team</h1>
<table>
    <thead>
        <tr>
            <th>Team</th>
<?php
$criteria = new Criteria();
$criteria->addAscendingOrderByColumn(RoundPeer::NAME);
foreach (RoundPeer::doSelect($criteria) as $round):
?>
            <th><?php echo $round->getName(); ?>
<?php
endforeach;
?>
        </tr>
    </thead>
    <tbody>
<?php
foreach($teams as $team):
?>
    <tr>
        <td><?php echo $team->getName(); ?></td>
<?php
    $criteria = new Criteria();
    $criteria->addAscendingOrderByColumn(RoundPeer::NAME);
    foreach (RoundPeer::doSelect($criteria) as $round):
?>
        <td><?php echo link_to($team->getWinLossText($round->getId()), "post_tournament/viewScoreSheets?debateId=".$team->getDebate($round->getId())->getId()); ?></td>
<?php
    endforeach;
?>
	</tr>
<?php
endforeach;
?>
    </tbody>
</table>
<div id="button">
<?php echo link_to ('back', 'post_tournament/index') ?>
</div>
