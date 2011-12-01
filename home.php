<?php
/*
Template Name: Home structure
*/
?>
<?php get_header(); ?> 
<div id="intro">
	<div class="intro_wrapper">
		 <div id="the_video">
		 <?php 
		 echo comedanonna_printVideoContent( 55, 'original'  );
		 ?>
		 </div>
		 <div class="text">
		 	<?php 
		 		$post_id=40;
		 		$abstract_post=get_post($post_id);
		 		echo $abstract_post->post_content;
		 	?>
		 	<div class="buttons">
			 	<div class="faq"><a href="<?php bloginfo('url');?>/questions"><span class="eng">FAQ</span><hr/><span class="ita">Domande frequenti</span></a></div>
			 	<div class="explore"><a href="#"><span class="eng">Explore</span><hr/><span class="ita">Scopri</span></a></div>
		 	</div>
		</div>
	</div>
</div>
              <ul class="mcol">
              
              <?php $my_query = new WP_Query( "cat=5" );
                 if ( $my_query->have_posts() ) { 
                     while ( $my_query->have_posts() ) { 
                         $my_query->the_post(); ?>
              	<li class="article">
	               
	                <?php get_template_part( 'home-feature', get_post_format() ); ?>
                    	
                </li>
            <?php 
            wp_reset_postdata();
            }} ?>
            </ul>
 
<?php get_footer(); ?>
