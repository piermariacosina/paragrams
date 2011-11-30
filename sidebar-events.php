<?php
/**
 * The Events widget areas.
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */
?>

<?php
	/* The footer widget area is triggered if any of the areas
	 * have widgets. So let's check that first.
	 *
	 * If none of the sidebars have widgets, then let's bail early.
	 */
	 

		
	// If we get this far, we have widgets. Let do this.
?>
<div id="event-sidebar" <?php twentyeleven_footer_sidebar_class(); ?>>
		<?php dynamic_sidebar( 'events-sidebar' ); ?>
</div><!-- #supplementary -->