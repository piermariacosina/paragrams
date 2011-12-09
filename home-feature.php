<?php
     	if ( has_post_thumbnail() ) { ?>
     	<?php 
     	$imgsrcparam = array(
			'alt'	=> trim(strip_tags( $post->post_excerpt )),
			'title'	=> trim(strip_tags( $post->post_title )),
			);
     	$thumbID = get_the_post_thumbnail( $post->ID, 'background', $imgsrcparam ); ?>
         <span><?php echo "$thumbID"; ?></span>
     	<?php } ?>

     <h2><?php the_title(); ?></h2>
     <?php the_content(); ?>
     