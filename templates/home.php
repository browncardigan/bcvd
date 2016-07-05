
<h2>Welcome...</h2>

<div class="squares">
	<?
	foreach ($data['videos'] as $v) {
		$this->renderElement('video_list', $v);
	}
	?>
</section>
