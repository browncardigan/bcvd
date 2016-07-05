<? if ($data['video']['video_file']) { ?>
	<h2><?= $data['video']['title']; ?></h2>
	<div class="video-holder">
		<div class="video" id="video<?= $data['video']['item_id']; ?>"></div>
	</div>
	<script>
	var videoMate = jwplayer("video<?= $data['video']['item_id']; ?>");
	videoMate.setup({
	    file: "<?= $data['video']['video_file']; ?>",
		<? if ($data['video']['video_image']) { echo 'image: "' . $data['video']['video_image'] . '",' . "\n"; } ?>
		stretching: 'uniform',
		width: '100%',
		aspectratio: '16:9',
		skin: {
			name: "glow"
		}
	});
	</script>
	<p><a href="<?= $data['video']['permalink']; ?>vote/">VOTE YES!!!</a></p>
	<?
}
else {
	echo "<p>NO VIDEO FILE!</p>";
}
?>