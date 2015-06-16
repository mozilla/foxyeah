<?php 
	/**
	* Custom Post Types
	**/
	

	function foxyeah_cpt() {
		//Images
		register_post_type( 'image', array(
		  'labels' => array(
		    'name' => 'Images',
		    'singular_name' => 'Image',
		   ),
		  'description' => 'Images',
		  'public' => true,
		  'menu_position' => 5,
		));


		//Video
		register_post_type( 'video', array(
		  'labels' => array(
		    'name' => 'Videos',
		    'singular_name' => 'Video',
		   ),
		  'description' => 'Youtube videos',
		  'public' => true,
		  'menu_position' => 5,
		));	

		//Evergreen
		register_post_type( 'evergreen', array(
		  'labels' => array(
		    'name' => 'Evergreens',
		    'singular_name' => 'Evergreen',
		   ),
		  'description' => 'Evergreen content pieces',
		  'public' => true,
		  'menu_position' => 5,
		));	

		//Holiday
		register_post_type( 'holiday', array(
		  'labels' => array(
		    'name' => 'Holidays',
		    'singular_name' => 'Holiday',
		   ),
		  'description' => 'Holiday content pieces',
		  'public' => true,
		  'menu_position' => 5,
		));
	}
	add_action( 'init', 'foxyeah_cpt' );

	// RSS Stuff
	function myfeed_request($qv) {

		if (isset($qv['feed']))
			$qv['post_type'] = get_post_types();
			
		return $qv;
	}
	add_filter('request', 'myfeed_request');



	// Image resizing
	// add_action( 'after_setup_theme', 'foxy_setup_theme' );
	// function foxy_setup_theme() {
	//   add_image_size( 'category-thumb', 300 ); // 300 pixels wide (and unlimited height)
	//   add_image_size( 'medium', 550, 180, true ); // (cropped)
	// }
	update_option('medium_size_w', 550 );
	update_option('large_size_w', 1100);
?>