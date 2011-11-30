<?php
// ===========
// = Sidebar =
// ===========
if ( function_exists('register_sidebar') )
	{ register_sidebar(); }

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
		return ( $img ) ? '<a href="'.$video_url.'" title="'.$r->title.'" class="profileVideoLinks" rel="wp-video-lightbox">'.$img.'</a>' : $r->html;
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


if (function_exists('load_my_scripts')) {
    function load_my_scripts() {
    	if (!is_admin()) {
		wp_register_script('image_appear', bloginfo('template_url').'/js/image_appear.js'__FILE__), array('jquery'), '0.1', true );
		wp_enqueue_script('image_appear');
    	}
    }
}
add_action('init', 'load_my_scripts');*/

?>
