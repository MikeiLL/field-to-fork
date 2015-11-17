<?php

function field_to_fork_produce_display( $atts ) {

  $atts = shortcode_atts( array(
  'title' => 'Produce',
  'ignore_year' => 0,
  'exclude_season' => 0
    ), $atts );

  $title = $atts['title']; 
  $ignore_year = $atts['ignore_year']; 
  $exclude_season = $atts['exclude_season'];
  
  if ($exclude_season == 0):
  //get current month
  $currentMonth=DATE("m");
 
  //retrieve season
  IF ($currentMonth>="03" && $currentMonth<="05")
    $season = "Spring";
  ELSEIF ($currentMonth>="06" && $currentMonth<="08")
    $season = "Summer";
  ELSEIF ($currentMonth>="09" && $currentMonth<="11")
    $season = "Fall";
  ELSE
    $season = "Winter";
  else:
    $season = "";
  endif;
  
  $result = '<div class="col">';
  
  if ($season != "")
    $result .= '<h2>Happy '.$season.'</h2>';

  
  $result .= '<h3 class="text-center field-to-fork-page-title">'.$title.'</h3>';
  

  $posts = get_posts(array(
  'posts_per_page'	=> -1,
  'post_type'			=> 'produce',
  'orderby'				=> 'title',
  'order' 				=> 'ASC'
  ));


  if( $posts ): ?>

  <?php foreach( $posts as $post ):

    setup_postdata( $post, $post->ID );
    
      $start_of_season = get_field('start_of_season', $post->ID);
      $end_of_season = get_field('end_of_season', $post->ID);
      $in_season = 0;
      
      if ($ignore_year == 1):
          $date_format = 'm-d';
          $season = new Season();
          $season_start = explode('-', date_i18n($date_format,strtotime($start_of_season)));
          $season_end = explode('-', date_i18n($date_format,strtotime($end_of_season)));
          $season->setStart($season_start[0], $season_start[1]);
          $season->setEnd($season_end[0], $season_end[1]);
          if (0 == $season->isActiveForDate(new DateTime('NOW')))
            continue;
          $in_season = 1;

      else:
          $date_format = 'Y-m-d';
          if ((date_i18n($date_format,strtotime('today')) > date_i18n($date_format,strtotime($start_of_season))) &&
        (date_i18n($date_format,strtotime('today')) < date_i18n($date_format,strtotime($end_of_season))))
              $in_season = 1;
      endif;
      

      if ($in_season == 1):

    ?>
    
    <?php if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it. 
    $result	.=		'<a href="<?php the_permalink(); ?>">';

                  the_post_thumbnail('thumb', array( 'class'	=> "img-responsive img-center"));
                }  
            
    $result	.=		'</a>';

    $result	.=		'<h4><a class="produce_item_title" href="' . get_the_permalink($post->ID) . '">' . get_the_title($post->ID) . '</a></h4>';

    $result	.=		'<p class="produce_item_excerpt">' . get_the_excerpt() . '</p>';

      $produce_thumbnail = get_field('produce_image', $post->ID)['sizes']['thumbnail'];
      if(isset($produce_thumbnail)) {
          $result	.=		'<img src="'.$produce_thumbnail.'" class="img-responsive field_to_fork_thumb '.str_replace(' ', '_', get_the_title($post->ID)).'">';
        }

      $result	.=		'</a>';
      
      endif; //  ./if between dates (in season)

      endforeach; 

      wp_reset_postdata(); 
      
    endif; // ./if posts
  $result	.=		'</div><!-- end span 6-->';

  return $result;
  } ?>