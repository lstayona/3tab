<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>

<?php include_http_metas() ?>
<?php include_metas() ?>

<?php include_title() ?>

<link rel="shortcut icon" href="/favicon.ico" />
</head>
<body>
<?php if (!in_array($sf_request->getParameter('module'), array('post_tournament', 'checkin')) and !isset($hideNavigationBar)): ?>
<div class="topbar" data-scrollspy="scrollspy">
    <div class="topbar-inner">
        <div class="container">
            <a class="brand" href="#">3tab</a>
            <ul class="nav">
                <li><?php echo link_to("Tournament Management", "tournament/index", array('title' => 'Tournament Management', 'absolute' => true)); ?></li>
                <li class="dropdown" data-dropdown="dropdown">
                    <a href="#" class="dropdown-toggle">Results</a>
                    <ul class="dropdown-menu">
                        <li><?php echo link_to("Wins Confirmation", "team/viewTeamScoreConfirmation", array('title' => 'Wins Confirmation')); ?></li>
                        <li><?php echo link_to("Team Rankings", "team/viewRankings", array('title' => 'View Rankings')); ?></li>
                        <li><?php echo link_to("Speaker Rankings", "team/viewSpeakerRankings", array('title' => 'View Speaker Rankings')); ?></li>
                        <li class="divider"></li>
                        <li><?php echo link_to("Post tournament", "post_tournament/index", array('title' => 'Post tournament')); ?></li>
                    </ul>
                </li>
                <li class="dropdown" data-dropdown="dropdown">
                    <a href="#" class="dropdown-toggle">Control Panel</a>
                    <ul class="dropdown-menu">
                        <li><?php echo link_to("Institution", "institution/index", array('title' => 'Institution')); ?></li>
                        <li><?php echo link_to("Venue", "venue/index", array('title' => 'Venue')); ?></li>
                        <li><?php echo link_to("Round", "round/index", array('title' => 'Round')); ?></li>
                        <li><?php echo link_to("Team", "team/index", array('title' => 'Team')); ?></li>
                        <li><?php echo link_to("Debater", "debater/index", array('title' => 'Debater')); ?></li>
                        <li><?php echo link_to("Adjudicator", "adjudicator/index", array('title' => 'Adjudicator')); ?></li>
                        <li class="divider"></li>
                        <li><?php echo link_to("Import", "import/index", array('title' => 'Import')); ?></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>
<?php endif; ?>

<div id="container" class="container-fluid">
<?php echo $sf_data->getRaw('sf_content') ?>
</div>
<!--
<div id="container">
	<p>Copyright &copy; 2008 code-monkeys</p>
	<p>
		3tab is developed by Suthen "Tate" Thomas and Edwin "Clansman" Law.<br/>
		3tab stylesheet is scripted by n.g.
	</p>
</div>
-->
</body>
</html>
