<?php
/*
Plugin Name: Field to Fork Farm Produce Display
Description: Field to Fork Farm Produce Display by Season
Author: Mike iLL 
Author URI: http://www.mZoo.org
*/

add_action( 'init', 'farm_produce_cpt' );

function farm_produce_cpt() {

register_post_type( 'produce', array(
  'labels' => array(
    'name' => 'Produce',
    'singular_name' => 'Produce',
   ),
  'description' => 'Produce to show on website.',
  'public' => true,
  'menu_position' => 20,
  'supports' => array( 'title', 'editor', 'custom-fields' )
));
}


if(function_exists("register_field_group"))
{
	register_field_group(array (
		'id' => 'acf_produce',
		'title' => 'Produce',
		'fields' => array (
			array (
				'key' => 'field_5644c3068a94c',
				'label' => 'Start of Season',
				'name' => 'start_of_season',
				'type' => 'date_picker',
				'instructions' => 'Select the date around which this produce is likely to become available.',
				'date_format' => 'yymmdd',
				'display_format' => 'dd/mm/yy',
				'first_day' => 1,
			),
			array (
				'key' => 'field_5644c3888a94f',
				'label' => 'End of Season',
				'name' => 'end_of_season',
				'type' => 'date_picker',
				'instructions' => 'Select the date around which this produce is likely to be out of season.',
				'date_format' => 'yymmdd',
				'display_format' => 'dd/mm/yy',
				'first_day' => 1,
			),
			array (
				'key' => 'field_5644c4a1a18d9',
				'label' => 'Produce Image',
				'name' => 'produce_image',
				'type' => 'image',
				'instructions' => 'Upload an image to display with this produce item.',
				'save_format' => 'object',
				'preview_size' => 'medium',
				'library' => 'all',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'produce',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'no_box',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
}


/*
function set_available_acfs()
	{
	
		$metabox_ids     = array();
		$available_acfs  = array();
		$acf_groups 		= $available_acfs;

        // Get ACF field groups
		$acfs = apply_filters("acf/get_field_groups", array());
		mz_pr($acfs);

		if($acfs)
		{
			foreach($acfs as $acf)
			{
                // Get ACF options
				$acf["options"] = apply_filters("acf/field_group/get_options", array(), $acf["id"]);

                // Need to show this ACF field group?
				$show = in_array($acf["id"], $metabox_ids) ? 1 : 0;

				if(!$show)
				{
					continue;
				}

				if(!isset($available_acfs[$acf["id"]]))
				{
					$available_acfs[$acf["id"]] = array(
						"id"    => $acf["id"],
						"title" => $acf["title"]
						);
				}
			}
		}
		mz_pr($available_acfs);
	}
*/

function add_shortcodes() {
 	
 		//$produce_display = new MZ_Mindbody_Schedule_Display();

			//add_shortcode('field-to-fork-produce-display', array($schedule_display, 'field_to_fork_produce_display'));
			add_shortcode('field-to-fork-produce-display', 'field_to_fork_produce_display');
}

require_once('lib/produce.php');
add_shortcodes();

if ( ! function_exists( 'mz_pr' ) ) {
	function mz_pr($message) {
		echo "<pre>";
		print_r($message);
		echo "</pre>";
	}
}
