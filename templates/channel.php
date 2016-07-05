<section id="squares">
	<div class="page">
		<? if (isset($data['videos'])) { ?>
			<h2><?= $data['category_name']; ?></h2>
			<?
			foreach ($data['videos'] as $v) {
				$this->renderElement('video_list', $v);
			}

			?>
		<? } else { ?><p>Sorry, no videos for this channel yet.</p><? } ?>
	</div>
</section>