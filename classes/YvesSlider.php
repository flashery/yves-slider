<?php
	
	class YvesSlider {
		
		public $slidername;
		
		public $yves_slider_admin;
		
		public $yves_db_version;
		
		public $slider_table_name;
		
		public $image_table_name;
		
		public $slug;
		
		public $MM_UPLOADPATH;
		
		public $IMGPATH;
		
		public $TIMTHUMB_DIR;
		
		public $defaults = array();
		
		
		public function __construct() {
			
			global $wpdb;
			
			$this->defaults = array(
									'image_width'  => 552,
									'image_height' => 447,
									'image_size' =>  32000,
									'image_thumb_width' => 52,
									'image_thumb_height' => 47
									);
			
			$this->slidername = 'Yves Slider';
			
			$this->yves_db_version = '1.0';
			
			$this->slider_table_name = $wpdb->prefix . "yves_slider";
			
			$this->image_table_name = $wpdb->prefix . "yves_slider_images";;
			
			$this->slug = 'yves-slider';
			
			$this->MM_UPLOADPATH = WP_PLUGIN_URL.'/yves-slider/upload/';
			
			$this->IMGPATH = WP_PLUGIN_URL.'/yves-slider/images/';
			
			$this->TIMTHUMB_DIR = WP_PLUGIN_URL.'/yves-slider/lib/timthumb.php';
			
			$this->slug = 'yves-slider';
			
			
			
			/*========================== Short Codes */	
			
			add_shortcode('yslider', array($this, 'create_yslider'));
			
			/*========================== Action Hooks */
			
			add_action('wp_enqueue_scripts', array($this,'my_scripts'));
			
			add_action('wp_head', array($this,'my_styles'));//Use when css is inside my php code therefore append it as inline css on the header of html
			
			//add_action('wp_enqueue_scripts', array($this,'my_styles'));//Use when css is another file e.g style.css 
			 
			//Load Stylsheets and scripts
			if (isset($_GET['page']) && $_GET['page'] == $this->slug) {
				
				add_action('admin_print_scripts', array($this,'my_scripts'));
				
				add_action('admin_print_styles', array($this,'my_styles'));
				
			}
			
		}

/***************************************************************************************
					FUNCTION FOR INITIALIZING AND INSTALLING THE PLUGIN
 ***************************************************************************************
		public static function init() {
		
			register_activation_hook(MYPLUGIN_FILE, array('YvesSlider', 'yslider_install'));//Installing data
			
		}
		
/***************************************************************************************
						FUNCTION FOR CREATING THE SLIDER
 ***************************************************************************************/		
		public function create_yslider() {
			global $wpdb;
											
			$slider = "";
			
			$slider = "<div id='yves-slider'>";
			
        	$images = $wpdb->get_col( "SELECT image_file_name FROM " . $this->image_table_name );
			
			$images_settings = $wpdb->get_row("SELECT * FROM $this->slider_table_name WHERE slider_id = 1", ARRAY_A);
										
    		$slider .= "<ul id='nav-slider'>";
       
			//Display the slider navigation
			for($count = 0; $count < count($images); $count++) {
				
				if(count($images) == 0){
	  
					$slider .= "<li onclick='clickLI(". $this->MM_UPLOADPATH."/".$images[$count] .")' class='active'>". $count ."</li>";
                    
				}else{
                
					$slider .= "<li onclick='clickLI(". $this->MM_UPLOADPATH."/".$images[$count] .")' class='inactive'>". $count ."</li>";
                    
				} 
			}
			
			$slider .= "</ul>";

    	  //Display the images
			for($count = 0; $count < count($images); $count++) {
				
				if(count($images) == 0){
					
					$slider .=  "<img src='".$this->TIMTHUMB_DIR."?src=".$this->MM_UPLOADPATH."/".$images[$count]."&w=".$images_settings['image_width']."&h=".$images_settings['image_height']."&q=100' />";
					
				}else{
					
					$slider .=  "<img src='".$this->TIMTHUMB_DIR."?src=".$this->MM_UPLOADPATH."/".$images[$count]."&w=".$images_settings['image_width']."&h=".$images_settings['image_height']."&q=100' />";
					
				}
			}

			$slider .= "</div>";
			
			return $slider;
		}
		
/***************************************************************************************
				FUNCTION FOR INCLUDING STYLESHEET AND JAVASCRIPT FOR ADMIN UI
 ***************************************************************************************/
 
		//Function Load Scripts
		public function my_scripts() {
			
			wp_enqueue_script('my-slider');
			
			wp_register_script('my-slider', WP_PLUGIN_URL.'/yves-slider/js/yslider.js', array('jquery'));
			
		}
		
		//Function load style 
		public function my_styles() {
			
			$height = $this->defaults['image_height'].'px';
			$width  = $this->defaults['image_width'].'px';
			
			//wp_enqueue_style('my-stye');
			//wp_register_style('my-stye', WP_PLUGIN_URL.'/yves-slider/css/yslider.css');
				
			
			 echo "<style type='text/css'>
			 		.pane { float:left; }
					#preview-slider { margin-left: 20px; width: 700px; }
					#preview-slider ul li { display: inline-block; list-style: none outside none; margin: 5px; }
					.success { color:#690; }
					.error { color:#F00; }
					#yves-slider img { left: 0; position: absolute; top: 0; z-index: 1; }
					#yves-slider img.active { z-index: 3; }
					#yves-slider { position: relative; height: ".$this->defaults['image_height'].'px'."; width: ".$this->defaults['image_width'].'px'."; }
					.clearer { clear:both; }
					#yves-slider ul#nav-slider { background: none repeat scroll 0 0 rgba(255, 255, 255, 0.5); height: 20px; padding: 10px 0; margin:0; position: relative; z-index: 9999; width:100%; }
					#yves-slider ul#nav-slider li { background: none repeat scroll 0 0 #073242; cursor: pointer; display: inline; font-family: Arial, Helvetica, sans-serif; font-size: 12px; height: 28px; padding: 2px 5px; margin:0 5px; width: 28px; }	
					</style>";

    	}
		
/***************************************************************************************
				FUNCTION FOR INSTALLING THE DATABASE TABLE
 ***************************************************************************************
 
		public static function yslider_install() {
		   require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			
		   //global $wpdb;
	   	   //global $yves_db_version;
		   
		   $image_table_name = $wpdb->prefix . "yves_slider_image";
	  	   
		   $slider_table_name = $wpdb->prefix . "yves_slider";
		   
		   $image_table = "CREATE TABLE $image_table_name (
							  image_id mediumint(9) NOT NULL AUTO_INCREMENT,
							  time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
							  image_alt_text text NOT NULL,
							  image_file_name VARCHAR(55) DEFAULT '' NOT NULL,
							  UNIQUE (image_id)
						  )";
							
		   dbDelta($image_table);
		   
		   $slider_settings = "CREATE TABLE $slider_table_name (
								  slider_id mediumint(9) NOT NULL AUTO_INCREMENT,
								  slider_height INT(10) DEFAULT '0' NOT NULL,
								  slider_width INT(10) DEFAULT '0' NOT NULL,
								  image_height INT(10) DEFAULT '0' NOT NULL,
								  image_width INT(10) DEFAULT '0' NOT NULL,
								  PRIMARY KEY (slider_id ), 
								  UNIQUE (slider_id)
							  )";
							  
		   dbDelta($slider_settings);
							  
		   //add_option("yves_db_version", $yves_db_version);
		   
		}*/
		
	}

?>