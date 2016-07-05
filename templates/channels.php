<section id="lead">
	<div class="page">
		<h2>Channels</h2>
		<p>
		<?
		if (isset($data['channels'])) {
			foreach ($data['channels'] as $c) {
				echo '<a href="' . WWW_PATH . 'channel/' . $c['category_slug'] . '/">' . $c['category_name'] . '</a><br />';
			}
		}
		?>
		</p>
	</div>
</section>
			
		