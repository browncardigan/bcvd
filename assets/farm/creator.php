<?php

function createThumbnail($f) {
	$thumb_width = 300;
	$thumb_height = 300;
	if (file_exists($f)) {
		list($width, $height) = getimagesize($f);
		$f2 = imagecreatefromjpeg($f);
		if ($width > $height) {
			$y = 0;
		  	$x = ($width - $height) / 2;
		  	$smallest_side = $height;
		} 
		else {
		  	$x = 0;
		  	$y = ($height - $width) / 2;
		  	$smallest_side = $width;
		}
		$thumb = imagecreatetruecolor($thumb_width, $thumb_height);
		imagecopyresampled($thumb, $f2, 0, 0, $x, $y, $thumb_width, $thumb_height, $smallest_side, $smallest_side);
		imagejpeg($thumb, str_replace('.', '-thumb.', $f));
		header('Content-type: image/jpeg');
		imagejpeg($thumb);
	}
}

?>