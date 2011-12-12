<?php
/*
 * This page displays a single event, called during the em_content() if this is an event page.
 * You can override the default display settings pages by copying this file to yourthemefolder/plugins/events-manager/templates/ and modifying it however you need.
 * You can display events however you wish, there are a few variables made available to you:
 * 
 * $args - the args passed onto EM_Events::output() 
 */
global $EM_Event;
/* @var $EM_Event EM_Event */
if( $EM_Event->status == 1 ){
	echo $EM_Event->output_single();
}else{
	echo get_option('dbem_no_events_message');
}
 
if(testimonial_current_user_can_write_event($EM_Event->event_owner))
    bp_testimonials_post_form();

$args = array(
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