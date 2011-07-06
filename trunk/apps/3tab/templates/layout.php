<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>

<?php include_http_metas() ?>
<?php include_metas() ?>

<?php include_title() ?>

<link rel="shortcut icon" href="/favicon.ico" />

</head>
<body>
	
<div id="container">
<!-- header -->
<div id="header_right">
	<div id="header_left"></div>
</div>

<br clear="all" />
<!-- nav bar -->
<?php if (!in_array($sf_request->getParameter('module'), array('post_tournament', 'checkin'))):?>
<div id="navigation">
<ul id="nav">
	<li><?php echo link_to("Tournament", "tournament/index", array('title' => 'Tournament', 'absolute' => true)); ?></li>
	<li><?php echo link_to("Team > Rankings", "team/viewRankings", array('title' => 'Team > View Rankings', 'absolute' => true)); ?></li>
	<li><?php echo link_to("Team > Speaker Rankings", "team/viewSpeakerRankings", array('title' => 'Team > View Speaker Rankings')); ?></li>
	<li class="nav-admin"><?php echo link_to("Control Panel", "#", array('title' => 'Control Panel View')); ?></li>
</ul>
<ul id="subnav">
	<li><?php echo link_to("Institution", "institution/index", array('title' => 'Institution')); ?> &nbsp;| </li>
	<li><?php echo link_to("Venue", "venue/index", array('title' => 'Venue')); ?> &nbsp;| </li>
	<li><?php echo link_to("Round", "round/index", array('title' => 'Round')); ?> &nbsp;| </li>
	<li><?php echo link_to("Team", "team/index", array('title' => 'Team')); ?> &nbsp;| </li>
	<li><?php echo link_to("Debater", "debater/index", array('title' => 'Debater')); ?> &nbsp;| </li>
	<li><?php echo link_to("Adjudicator", "adjudicator/index", array('title' => 'Adjudicator')); ?> &nbsp;| </li>
	<li><?php echo link_to("Import", "import/index", array('title' => 'Import')); ?></li>
</ul>
</div>
<?php endif; ?>
<br clear="all" />
<?php echo $sf_data->getRaw('sf_content') ?>
</div>


<div id="footer">
	<p>Copyright &copy; 2008 code-monkeys</p>
	<p>
		3tab is developed by Suthen "Tate" Thomas and Edwin "Clansman" Law.<br/>
		3tab stylesheet is scripted by n.g.
	</p>

</div>
</body>
</html>
