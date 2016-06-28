<? include('_conf.php'); ?>
<html>
<head>
<title>BC/VD</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="<?= WWW_PATH; ?>assets/css/master.css" />
</head>
<body>
	
<h1>BC/VD</h1>

<nav>
	<div>
		<h2><a href="<?= WWW_PATH; ?>">&nbsp; BC/VD____</a></h2>
		<ul>
			<li><a href="<?= WWW_PATH; ?>popular/">Popular</a></li>
			<li><a href="<?= WWW_PATH; ?>channels/">Channels</a></li>
		</ul>
	</div>
</nav>

<section id="lead">
	<div>
		<a href="<?= WWW_PATH; ?>post/mate/"><img src="<?= WWW_PATH; ?>assets/temp/mate.jpg" /></a>
	</div>
</section>

<section id="squares">
	<? for ($i=0; $i<12; $i++) { ?>
		<div class="sq">
			<a href="<?= WWW_PATH; ?>post/warne/"><img src="<?= WWW_PATH; ?>assets/temp/warne.jpg" /></a>
		</div>
	<? } ?>
</section>
	
</body>
</html>
