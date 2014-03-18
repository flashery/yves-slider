<?php
/*

Plugin Name: Yves Slider

Description: This plugin for testing

Author: Yves Gonzaga

Version: 1.0

Author URI: http://flashery.cu.cc

*/
	define( 'MYPLUGIN_FILE', __FILE__ );

	require_once("classes/YvesSlider.php");
	require_once("classes/YvesSliderAdmin.php");
	
	new YvesSlider();
	new YvesSliderAdmin();
	
	register_activation_hook(__FILE__, 'yslider_install');
	register_activation_hook(__FILE__,'yslider_install_data');
	
/***************************************************************************************
						FUNCTION FOR CREATING THE DATABASE
 ***************************************************************************************/		
 
	global $yves_db_version;
	$yves_db_version = "1.0";
	
	function yslider_install() {
			
		   require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			
		   global $wpdb;
	   	   global $yves_db_version;
		   $yslider = new YvesSlider();
	  	   
		   $slider_table_name = $wpdb->prefix . "yves_slider";
		   
		   $image_table = "CREATE TABLE $yslider->image_table_name (
							  image_id mediumint(9) NOT NULL AUTO_INCREMENT,
							  time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
							  image_alt_text VARCHAR(55) DEFAULT '' NOT NULL,
							  image_file_name VARCHAR(55) DEFAULT '' NOT NULL,
							  slider_id mediumint(9) NOT NULL,
							  UNIQUE (image_id)
						  )";
							
		   dbDelta($image_table);
		   
		   $slider_settings = "CREATE TABLE $yslider->slider_table_name (
								  slider_id mediumint(9) NOT NULL AUTO_INCREMENT,
								  slider_name VARCHAR(55) DEFAULT '' NOT NULL,
								  slider_height INT(10) DEFAULT '0' NOT NULL,
								  slider_width INT(10) DEFAULT '0' NOT NULL,
								  image_height INT(10) DEFAULT '0' NOT NULL,
								  image_width INT(10) DEFAULT '0' NOT NULL,
								  PRIMARY KEY (slider_id ), 
								  UNIQUE (slider_id)
							  )";
							  
		   dbDelta($slider_settings);
							  
		   add_option("yves_db_version", $yves_db_version);
		   
	}
	
/***************************************************************************************
				FUNCTION FOR INSERTING NEW DATA ON THE DATABASE TABLE
 ***************************************************************************************/
 
 	function yslider_install_data() {
		
	   global $wpdb;
	   $yslider = new YvesSlider();
	   $images = scandir(ABSPATH.'/wp-content/plugins/yves-slider/upload');
	   foreach($images as $image){
		   
		   if( $image !== "." && $image !== ".."){
			   $file_info = pathinfo( $image );
			   $image_alt_text = $file_info[ 'filename' ];		
			   	   
			   $wpdb->insert( $yslider->image_table_name, array( 
								'time' => current_time('mysql'), 
								'image_alt_text' => $image_alt_text, 
								'image_file_name' => $image, 
								'slider_id'=> 1 ) 
							);
		   }
		   
	   }
	   
	  		
					
	   $wpdb->insert( $yslider->slider_table_name, array( 
						'slider_name' => 'Yslider Sample', 
						'slider_height' => $yslider->defaults['image_height'], 
						'slider_width' => $yslider->defaults['image_width'],
						'image_height' => $yslider->defaults['image_height'],
						'image_width' => $yslider->defaults['image_width']) 
				    );
								
	   
	}
	
/***************************************************************************************
						FUNCTION FOR DISPLAYING THE SLIDER
 ***************************************************************************************/	
 
	function display_yslider(){
		$yslider = new YvesSlider();
		return $yslider->create_yslider();
	}
	
?>