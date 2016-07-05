<?php

$thumb_width = 300;
$thumb_height = 300;
	
if (isset($_GET['f'])) {
	
	$f = $_GET['f'];
	
	// create thumbnail
	if (strstr($f, '-thumb')) {
		$f = str_replace('-thumb', '', $f);
		if (!file_exists($f)) {
			makeLocalImage($f);
		}
		require_once("../creator.php");
		createThumbnail($f);
	}

	// just get the image
	else {
		makeLocalImage($f);
		header('content-type:image/jpeg');
		imagejpeg($f);
	}
}


function makeLocalImage($f) {
	$source = 'http://img.youtube.com/vi/' . current(explode('.', $f)) . '/hqdefault.jpg';
	$source_data = curlContents($source);
	file_put_contents($f, $source_data);
	return $source_data;
}


function curlContents($url=false, $data=array()) {
	$contents = '';
	if ($url) {
	$ch = curl_init();
	$timeout = 0; // set to zero for no timeout
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	curl_setopt($ch, CURLOPT_COOKIESESSION, true);
	if (count($data) > 0) {
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	}
	curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
	$contents = curl_exec($ch);
	if($contents === false) {
		return "ERROR: " . curl_error($ch);
	}
	curl_close($ch);
	}
	return $contents;
}

?>