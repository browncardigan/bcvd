<?php
	
if (isset($_GET['f'])) {
	$f = $_GET['f'];
	if (strstr($f, '-thumb')) {
		require_once("../creator.php");
		$f = str_replace('-thumb', '', $f);
		createThumbnail($f);
	}
}

?>