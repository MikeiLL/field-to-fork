<?php

function field_to_fork_produce_display( $atts, $account=0 ) {

$atts = shortcode_atts( array(
			'title' => 'Produce'
				), $atts );
				
		$title = $atts['title']; 
		
		$plugins_dir = plugin_dir_path( __file__ );
		$plugins_dir = str_replace("/field-to-fork/lib/", "", $plugins_dir);
		//include_once($plugins_dir.'/advanced-custom-fields/acf.php');		

$result = '<div class="col">
				<h2 class="text-center"><?=$title?></h2>';


						$posts = get_posts(array(
							'posts_per_page'	=> -1,
							'post_type'			=> 'produce',
							'orderby'				=> 'title',
							'order' 				=> 'ASC'
						));

						if( $posts ): ?>

							<?php foreach( $posts as $post ):

								setup_postdata( $post );

								?>

								<?php if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it. 
								$result	.=		'<a href="<?php the_permalink(); ?>">';

															the_post_thumbnail('thumb', array( 'class'	=> "img-responsive img-center"));
														}  
														
								$result	.=		'</a>';


								$result	.=		'<h4><a href="<?php the_permalink(); ?>">' . the_title() . '</a></h4>';

								$result	.=		'<p>' . the_excerpt() . '</p>';
									if ( ! function_exists( 'get_field' ) ) {
									  die('not there');
									  } 
									mz_pr(function_exists('get_field'));

									mz_pr(get_field('produce_image')); 
									mz_pr("nothing to see here"); 
									$produce_thumbnail = get_field('produce_image')['sizes']['thumbnail'];
									
									$result	.=		'<img src="<?=$produce_thumbnail?>" class="img-responsive field_to_fork_thumb <?php the_title(); ?>">';



							$result	.=		'</a>';

							endforeach; 

							wp_reset_postdata(); 

						endif; 
			$result	.=		'</div><!-- end span 6-->';
			return $result;
  } ?>