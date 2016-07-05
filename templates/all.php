<h2>Is This Everything...</h2>

<div class="squares">
<?
foreach ($data['videos'] as $v) {
	$this->renderElement('video_list', $v);
}
?>
</div>