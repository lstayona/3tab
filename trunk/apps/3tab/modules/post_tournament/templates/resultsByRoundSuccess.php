<script type="text/javascript">
jQuery(document).ready(function () {	
	jQuery("#subnav").hide();
	jQuery(".nav-admin").click(function() {
		jQuery("#subnav").toggle(300);
	});
});
</script>

<h1>Results By Round</h1>
<table>
    <thead>
        <tr>
            <th>Round</th>
            <th>Results</th>
        </tr>
    </thead>
    <tbody>
<?php
foreach($rounds as $round):
?>
    <tr>
        <td><?php echo $round->getName(); ?></td>
        <td><?php echo link_to("View Results", "post_tournament/viewMatchups?id=".$round->getId()) ?></td>
	</tr>
<?php
endforeach;
?>
    </tbody>
</table>
<div id="button">
<?php echo link_to ('back', 'post_tournament/index') ?>
</div>