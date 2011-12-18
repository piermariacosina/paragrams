<?php
/*
 * This page displays a single event, called during the em_content() if this is an event page.
 * You can override the default display settings pages by copying this file to yourthemefolder/plugins/events-manager/templates/ and modifying it however you need.
 * You can display events however you wish, there are a few variables made available to you:
 * 
 * $args - the args passed onto EM_Events::output() 
 */
global $EM_Event, $bp;

/* @var $EM_Event EM_Event */
if( $EM_Event->event_status == 1 ){
	echo $EM_Event->output_single();
}else{
	echo get_option('dbem_no_events_message');
}?>


<!--Embed user gallery in the event-->
 <?php echo do_shortcode('[bp-gallery owner_type="user" owner_id="'.$EM_Event->event_owner.'" max="3"  ]');?>
<!-- end of gallery -->

<?php
if(testimonial_current_user_can_write_event($EM_Event->event_owner))?>
	<?php if ($EM_Event->event_owner == $bp->loggedin_user->id)?>
	<a href="<?php echo bp_core_get_user_domain($EM_Event->event_owner)?><?php echo $bp->testimonials->root_slug; ?>/create/">leave a testimonial</a>
 
<?php $args = array(
                'user_id'=> $EM_Event->event_owner 
        );
 
if(bp_has_testimonials($args)):?>
<div id="pag-top" class="pagination">
 
		<div class="pag-count" id="testimonial-count-top">
 
			<?php bp_testimonials_pagination_count(); ?>
 
		</div>
 
		<div class="pagination-links" id="testimonial-pag-top">
 
			<?php bp_testimonials_pagination_links(); ?>
 
		</div>
 
	</div>
 
	<?php do_action( 'bp_before_testimonials_list' ); ?>
<ul id="testimonial-list" class="item-list" role="main">
<?php while(bp_testimonials()):bp_the_testimonial();
 
        bp_testimonials_load_template('testimonials/entry.php')
?>  
 
<?php endwhile;?>
</ul>
<?php else:?>
<div class="error" id="message">
    <?php _e('There is no testimonial available at the moment!','testimonials');?>
</div>
<?php endif;?>