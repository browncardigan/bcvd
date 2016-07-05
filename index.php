<? include('_conf.php'); ?>
<html>
<head>
<title>BC/VD</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="<?= WWW_PATH; ?>assets/css/master.css" />
<script src="<?= WWW_PATH; ?>assets/jwplayer/jwplayer.js"></script>
<script>jwplayer.key="XeQ11ookkj3bYVewe11wbxQo8ePYCl8NPdaauQ==";</script>
</head>
<body>	

<h1>BC/VD</h1>

<nav>
	<div>
		<h2><a href="<?= WWW_PATH; ?>">BC/VD____</a></h2>
		<ul>
			<li><a href="<?= WWW_PATH; ?>all/">All</a></li>
			<li><a href="<?= WWW_PATH; ?>popular/">Popular</a></li>
			<li><a href="<?= WWW_PATH; ?>channels/">Channels</a></li>
		</ul>
	</div>
</nav>

<section id="main">
	<div class="page">
		<?= $site->html; ?>
	</div>
</section>

<div id="debug">
<?php
if (count($site->queries) > 0) {
	foreach ($site->queries as $q) {
		echo '<p>' . $q . '</p>'; 
	}
}
?>
</div>
	
</body>
</html>
