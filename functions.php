<?php

// ====================================
// = WordPress 2.9+ Thumbnail Support =
// ====================================
add_theme_support( 'post-thumbnails' );
set_post_thumbnail_size( 299, 9999 ); // 299 pixels wide by 375 pixels tall, set last parameter to true for hard crop mode
add_image_size( 'background', 299, 9999 ); // Set thumbnail size


// ===========================
// = WordPress 3.0+ Nav Menu =
// ===========================
if ( function_exists( 'register_nav_menus' ) )
{
	register_nav_menus(
	array(
		'custom-menu'=>__('Custom menu'),
		)
		);
}
function custom_menu(){
	global $bp;
	echo '<ul id="top-menu">';
	if ( function_exists( 'wp_nav_menu' ) )
		wp_nav_menu( array( 'theme_location' => 'custom-menu','fallback_cb'=> 'custom_menu','container' => 'ul','menu_id' => 'top-menu', ) );
	if( is_user_logged_in() )
	{
		$bp_user_link = $bp->loggedin_user->domain;
		$bp_user_name = ucfirst ( $bp->loggedin_user->fullname );
		echo '<li id="menu-item" class="menu-item"><a href="'.$bp_user_link.'">Ciao '.$bp_user_name.'</a></li>';
	}else {
		echo '<li id="menu-item" class="menu-item"><a href="'.get_option('siteurl').'/'.BP_REGISTER_SLUG.'"/>Join/Partecipa</a></li>';
	}
	echo '</ul>';
}

function user_domain(){
	global $bp;
			$bp_user_link = $bp->loggedin_user->domain;
			return $bp_user_link;
}

// =====================================
// = WP 3.0+ Custom Background Support =
// =====================================
if ( function_exists( 'add_custom_background' ) )
	{ add_custom_background(); }


// =================================
// = Change default excerpt symbol =
// =================================
function imbalance_excerpt($text) { return str_replace('[...]', '...', $text); } add_filter('the_excerpt', 'imbalance_excerpt');

// ======================
// = Browser body class =
// ======================
add_filter('body_class','browser_body_class');

function browser_body_class($classes = '') {
	global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;

	if($is_lynx) $classes[] = 'lynx';
	elseif($is_gecko) $classes[] = 'gecko';
	elseif($is_opera) $classes[] = 'opera';
	elseif($is_NS4) $classes[] = 'ns4';
	elseif($is_safari) $classes[] = 'safari';
	elseif($is_chrome) $classes[] = 'chrome';
	elseif($is_IE) $classes[] = 'ie';
	else $classes[] = 'unknown';

	if($is_iphone) $classes[] = 'iphone';
	return $classes;
}

// =================================
// = Add comment callback function =
// =================================
function paragrams_comments($comment, $args, $depth) {
	$default = urlencode(get_bloginfo('template_directory') . '/images/default-avatar.png');
	$GLOBALS['comment'] = $comment; ?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
		<div id="comment-<?php comment_ID(); ?>">
			<div class="comment-author vcard">
				<?php 
			$myavatar = get_bloginfo('template_directory') . '/images/gravatar.png';
			echo get_avatar($comment,$size='55',$default ); ?>
			<?php printf(__('<cite class="fn">%s</cite> <span class="says">wrote:</span>'), get_comment_author_link()) ?>
		</div>
		<?php if ($comment->comment_approved == '0') : ?>
			<em><?php _e('Your comment is awaiting moderation.') ?></em>
			<br />
		<?php endif; ?>

		<div class="comment-meta commentmetadata"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php printf(__('%1$s at %2$s'), get_comment_date(),  get_comment_time()) ?></a><?php edit_comment_link(__('(Edit)'),'  ','') ?></div>

		<?php comment_text() ?>

		<div class="reply">
			<?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
		</div>
	</div>
	<?php
}

// ====================
// = Add Options Page =
// ====================
function themeoptions_admin_menu()
{
	// here's where we add our theme options page link to the dashboard sidebar
	add_theme_page("Theme Options", "Theme Options", 'edit_themes', basename(__FILE__), 'themeoptions_page');
}

function themeoptions_page()
{
	if ( $_POST['update_themeoptions'] == 'true' ) { themeoptions_update(); }  //check options update
	// here's the main function that will generate our options page
	?>
	<div class="wrap">
		<div id="icon-themes" class="icon32"><br /></div>
		<h2>PARAGRAMS Theme Options</h2>

		<form method="POST" action="">
			<input type="hidden" name="update_themeoptions" value="true" />

			<h3>Your social links</h3>


			<table width="90%" border="0">
				<tr>
					<td valign="top" width="50%"><p><label for="fbkurl">Facebook URL</label><br /><input type="text" name="fbkurl" id="fbkurl" size="32" value="<?php echo get_option('paragrams_fbkurl'); ?>"/></p><p><small><strong>example:</strong><br /><em>http://www.facebook.com/wpshower</em></small></p></td>
					<td valign="top" width="50%"><p><label for="twturl">Twitter URL</label><br /><input type="text" name="twturl" id="twturl" size="32" value="<?php echo get_option('paragrams_twturl'); ?>"/></p><p><small><strong>example:</strong><br /><em>http://twitter.com/wpshower</em></small></p>
					</td>
				</tr>
			</table>

			<h3>Custom logo</h3>


			<table width="90%" border="0">
				<tr>
					<td valign="top" width="50%"><p><label for="custom_logo"><strong>URL to your custom logo</strong></label><br /><input type="text" name="custom_logo" id="custom_logo" size="32" value="<?php echo get_option('paragrams_custom_logo'); ?>"/></p><p><small><strong>Usage:</strong><br /><em><a href="<?php bloginfo("url"); ?>/wp-admin/media-new.php">Upload your logo</a> (483 x 100px) using WordPress Media Library and insert its URL here</em></small></p></td>
					<td valign="top"width="50%"><p>
						<?php         		
					ob_start();
					ob_implicit_flush(0);
					echo get_option('paragrams_custom_logo'); 
					$my_logo = ob_get_contents();
					ob_end_clean();
					if (
						$my_logo == ''
						): ?>
						<a href="<?php bloginfo("url"); ?>/">
							<img src="<?php bloginfo('template_url'); ?>/images/logo.png" alt="<?php bloginfo('name'); ?>"></a>
						<?php else: ?>
							<a href="<?php bloginfo("url"); ?>/"><img src="<?php echo get_option('paragrams_custom_logo'); ?>"></a>       		
						<?php endif ?>
					</p>
				</td>
			</tr>
		</table>			

		<p><input type="submit" name="search" value="Update Options" class="button button-primary" /></p>
	</form>

</div>
<?php
}

add_action('admin_menu', 'themeoptions_admin_menu');

/**
 * Register our sidebars and widgetized areas. Also register the default Epherma widget.
 *
 * @since Twenty Eleven 1.0
 */
function twentyeleven_widgets_init() {

	register_sidebar( array(
		'name' => __( 'Header horizontal', 'twentyeleven' ),
		'id' => 'header-sidebar',
		'description' => __( 'Sidebar widget for header', 'twentyeleven' ),
	) );

	register_sidebar( array(
		'name' => __( 'Events horizontal', 'twentyeleven' ),
		'id' => 'events-sidebar',
		'description' => __( 'Event widget for header', 'twentyeleven' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Footer Area One', 'twentyeleven' ),
		'id' => 'sidebar-3',
		'description' => __( 'An optional widget area for your site footer', 'twentyeleven' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Footer Area Two', 'twentyeleven' ),
		'id' => 'sidebar-4',
		'description' => __( 'An optional widget area for your site footer', 'twentyeleven' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Footer Area Three', 'twentyeleven' ),
		'id' => 'sidebar-5',
		'description' => __( 'An optional widget area for your site footer', 'twentyeleven' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
}
add_action( 'widgets_init', 'twentyeleven_widgets_init' );


/**
 * Count the number of footer sidebars to enable dynamic classes for the footer
 */
function twentyeleven_footer_sidebar_class() {
	$count = 0;

	if ( is_active_sidebar( 'sidebar-3' ) )
		$count++;

	if ( is_active_sidebar( 'sidebar-4' ) )
		$count++;

	if ( is_active_sidebar( 'sidebar-5' ) )
		$count++;

	$class = '';

	switch ( $count ) {
		case '1':
			$class = 'one';
			break;
		case '2':
			$class = 'two';
			break;
		case '3':
			$class = 'three';
			break;
	}

	if ( $class )
		echo 'class="' . $class . '"';
}
// ====================
// = Add Video Box Using oEmbed =
// ====================
/*/ Update options function*/
function comedanonna_printVideoContent( $p = null, $size = 'medium' )
{
	global $post;
	
	$post_id = is_null( $p ) ? $post->ID : $p;
	
	$video_url = ( get_post_meta($post_id, 'attached_video', true ) ) ? get_post_meta($post_id, 'attached_video', true ) : false;
	
	if( $video_url )
	{
		require_once( ABSPATH . WPINC . '/class-oembed.php' );
		$oembed = _wp_oembed_get_object();
		$o = $oembed->discover( $video_url );
		$img = get_the_post_thumbnail( $post_id, $size );
		if( !$o ) return ( $img ) ? $img : 'No content to display';
		$r = $oembed->fetch( $o, $video_url );
		return ( $img ) ? '<a href="'.$video_url.'" title="'.$r->title.'" class="profileVideoLinks" rel="prettyPhoto">'.$img.'</a>' : $r->html;
	}
	return false;
}
/*
function themeoptions_update()
{
	// this is where validation would go
	update_option('paragrams_fbkurl', 	$_POST['fbkurl']);
	update_option('paragrams_twturl', 	$_POST['twturl']);
	update_option('paragrams_custom_logo', 	$_POST['custom_logo']);
}
function overrideEventsOutput( $output, $events, $args )
{
	$output = '';
	$output .= '<ul class="mcol">';
	foreach($events as $event)
	{

		$output .= '<li class="article">';
		echo "fooo ".$event->image_url;
		$imgId = get_attachment_id_from_src( $event->image_url );
		$img = wp_get_attachment_image_src( $imgId, 'medium');
		$output .= $img[0];
		$output .= '</li>';
	}
	$output .= '</ul>';
	return $output;
}
add_filter('em_events_output', 'overrideEventsOutput', 10, 3);

function get_attachment_id_from_src ($image_src) 
{
	global $wpdb;
	$query = "SELECT ID FROM {$wpdb->posts} WHERE guid='$image_src'";
	$id = $wpdb->get_var($query);
	return $id;
}
*/

if (!function_exists('load_my_scripts')) {
    function load_my_scripts() {
    	global $wp_query;
    	if ( !is_admin() ) 
    	{
	    	$p = $wp_query->get_queried_object();
	    	if( defined(BP_GALLERY_PLUGIN_URL) ) wp_dequeue_script('jqueryui');
			wp_enqueue_script('dialog-theme-script', get_bloginfo('template_url').'/js/jquery-ui.custom.min.js', array('jquery'), '1.8.162', false );
			wp_enqueue_script('booking-event-theme-script', get_bloginfo('template_url').'/js/js.js', array('jquery'), '0.1', false );
			wp_localize_script( 'booking-event-theme-script', 'Siteinfo', array( 'slug'=>$p->post_name,'site_url' => get_bloginfo('template_url') ) );
    	}
    }
	add_action('wp_print_scripts', 'load_my_scripts');
}


if( !function_exists('load_my_styles'))
{
	function load_my_styles()
	{
		wp_register_style( 'dialog-theme-style', get_bloginfo('template_url').'/js/css/jquery-ui-dialog.css', '', '1.8.16');
		wp_enqueue_style('dialog-theme-style');
	}
	add_action('wp_print_styles', 'load_my_styles');
}


/*
 * Sum donation with fixed fee amount before sending data to DB and PayPal
 * @params array() $paypal_vars payment variables to override
 * @$EM_Booking the booking object
 * @$obj the gateway object
 */
function booking_helper_overrideBooking( $paypal_vars, $EM_Booking, $obj )
{
	$donate = ( $_REQUEST['donate'] ) ? $_REQUEST['donate'] : 0;
	
	$commssion = 3.5;
	
	$paypal_vars['donate'] = $donate;
	
	$count = count($EM_Booking->tickets_bookings->tickets_bookings);
	
	if( $count > 0)
	{
		for( $i=1; $i <= $count; $i++ )
		{
		 	$paypal_vars['amount_'.$i] = $paypal_vars['amount_'.$i] + $paypal_vars['donate'];
		 	$paypal_vars['amount_'.$i] = $paypal_vars['amount_'.$i] + ( $paypal_vars['amount_'.$i] / 100 ) * $commssion;
		}
	}
	return $paypal_vars;
}
add_filter( 'em_gateway_paypal_get_paypal_vars', 'booking_helper_overrideBooking', 10, 3 );
////sto facendo prova commit


//can user write testimonial
function testimonial_current_user_can_write_event($user_event_id){
	global $bp;
   $can_write=false;
   $current_user_id = $bp->loggedin_user->id;
    if(is_user_logged_in()&&!bp_is_my_profile()&&($current_user_id!=$user_event_id))
        $can_write=true;
    
    return apply_filters('bp_testimonials_can_user_write',$can_write);
}

add_filter('em_event_output_placeholder','my_em_styles_placeholders',1,3);
function my_em_styles_placeholders($replace, $EM_Event, $result){
	global $wp_query, $wp_rewrite;
	
	
	
	switch( $result ){
		case '#_DONATION_COOK':
			
			$replace=BookingHelperRender::getAmounts($EM_Event,"cook");
			break;
		case '#_DONATION_CHARITY':
				
			$replace=BookingHelperRender::getAmounts($EM_Event,"charity");
			break;
		case '#_DONATION_DEVELOPER':
					
			$replace=BookingHelperRender::getAmounts($EM_Event,"dev");
			break;
	}
	return $replace;
}

?>
