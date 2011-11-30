	<div id="sidebar">
		<ul>
			<?php 	/* Widgetized sidebar, if you have the plugin installed. */
			if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar() ) : ?>

			<li>No sidebar content for now</li>

			<?php endif; ?>
		</ul>
	</div>

