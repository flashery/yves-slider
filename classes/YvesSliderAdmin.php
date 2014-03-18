<?php
	require_once("YvesSlider.php");
	
	class YvesSliderAdmin extends YvesSlider{
		
		public function __construct() {
			
			parent::__construct();
			
			add_action('admin_menu', array($this, 'register_slider_menu'));
		}
		
/***************************************************************************************
						FUNCTION FOR CREATING THE ADMIN UI
 ***************************************************************************************/
		public function create_admin_UI(){
			
			global $wpdb;
			
			$images_count = count($wpdb->get_col( "SELECT image_file_name FROM " . $this->image_table_name ));
			
			$images_settings = $wpdb->get_row("SELECT * FROM $this->slider_table_name WHERE slider_id = 1", ARRAY_A);
			
			$admin_UI = "	 
					<div class='wrap'>
						<div id='admin-pane' class='pane'>
							<h2>Settings</h2>
							<p>On this page, you will configure all the aspects of this plugins.</p>
							".$_GET['error'].$_GET['success']."
							<!--===============================================================================================================-->
							<!--============================================== UPLOAD FORM FIELD ==============================================-->
							<!--===============================================================================================================-->
							<form enctype='multipart/form-data' method='post' action='".WP_PLUGIN_URL."/yves-slider/upload.php' method='post' id='copyright-notices-conf-form'>
							<h3>
								<label for='copyright_text'>Upload an image here:</label>
							</h3>
							<p>
								<input type='file' name='new_picture' placeholder='Upload Image' />
							</p>
							<p class='submit'>
								<input type='submit' name='submit' value='Upload' />
							</p>
							</form>
							<!--=================================================================================================================-->
							<!--============================================== SETTINGS FORM FIELD ==============================================-->
							<!--=================================================================================================================-->
							<form enctype='multipart/form-data' method='post' action='".WP_PLUGIN_URL."/yves-slider/settings.php' method='post' id='copyright-notices-conf-form'>
							<h3>
								<label>Below are the settings for your slider</label>
							</h3>
							<h4>
								<label for='imagestodisplay'>Images to display:</label>
							</h4>
							<p>
								<input type='text' name='imagestodisplay' value='".$images_count."' />
							</p>
							<h4>
								<label for='image_height'>Image height:</label>
							</h4>
							<p>
								<input type='text' name='image_height' value='".$images_settings['image_height']."' />
							</p>
							<h4>
								<label for='image_width'>Image width:</label>
							</h4>
							<p>
								<input type='text' name='image_width' value='".$images_settings['image_width']."' />
							</p>
							<p class='submit'>
								<input type='submit' name='submit' value='Update' />
							</p>
							</form>
						</div>
						<div id='preview-slider' class='pane'>
							<h3>Your Images Uploaded</h3>
							".$this->list_images()."
							".$this->create_yslider()." </div>
						<div class='clearer'></div>
					</div>
				  ";
			 
			print($admin_UI);	
			$images = scandir(ABSPATH.'/wp-content/plugins/yves-slider/upload');
			
			print_r(scandir(ABSPATH.'/wp-content/plugins/yves-slider/'));
			
		   foreach($images as $image){
			   
			   echo $image.'<br>';
		   }
		}
		
		
/***************************************************************************************
				FUNCTION FOR LESTING IMAGES IN THE ADMIN UI
 ***************************************************************************************/
		public function list_images(){
			
			global $wpdb;
			
			$images = $wpdb->get_col( "SELECT image_file_name FROM " . $this->image_table_name );
			
			$display = "<ul>";
			
			for($count = 0; $count < count($images); $count++) {
				
				$display .= "<li><img src='".$this->TIMTHUMB_DIR."?src=".$this->MM_UPLOADPATH."/".$images[$count]."&w=50&h=50&q=100' /></li>"; 
				//var_dump($images);
				
			}
			$display .= "</ul>";
			
			return $display;

		}	
		
		
/***************************************************************************************
				FUNCTION FOR REGISTERING THE SLIDER MENU
 ***************************************************************************************/
		public function register_slider_menu() {
			
			 add_menu_page($this->slidername, $this->slidername, 'administrator', $this->slug, array(
	
				$this,
	
				'create_admin_UI'
	
			), plugins_url('yves-slider/images/slider_icon.png'));
	
		}
	}
?>
