<?php	
	require_once('appvars.php');
	require_once('classes/YvesSlider.php');
	
	//$old_picture = $_POST['old_picture'];
	$new_picture = $_FILES['new_picture']['name'];
	$new_picture_type = $_FILES['new_picture']['type'];
	$new_picture_size = $_FILES['new_picture']['size']; 
	$error = '';
	$image_file_name = '';
	
	list($new_picture_width, $new_picture_height) = getimagesize($_FILES['new_picture']['tmp_name']);
	
	
	// Validate and move the uploaded picture file, if necessary
	if (!empty($new_picture)) {
	
		if (($new_picture_type == 'image/gif') || ($new_picture_type == 'image/jpeg') || ($new_picture_type == 'image/pjpeg') ||
		($new_picture_type == 'image/png') && ($new_picture_size > 0)) {
		
			if (isset($_FILES['new_picture'])){
			
				if ($_FILES['new_picture']['error'] == 0) {
					
					// Move the file to the target upload folder
					$target = 'upload/' . basename($new_picture);
					
					if (move_uploaded_file($_FILES['new_picture']['tmp_name'], $target)) {
						/*
						// The new picture file move was successful, now make sure any old picture is deleted
						if (!empty($old_picture) && ($old_picture != $new_picture)) {
							
							@unlink(MM_UPLOADPATH . $old_picture);
							$image_file_name = $new_picture;
						}*/
						
						require_once('../../../wp-config.php');
						$yslider = new YvesSlider();
						
						//insert image file name to the database
						$image_file_name = $new_picture;
						$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD,DB_NAME) or die('Yves Slider Error conecting to database.');
						$query = "INSERT INTO $yslider->image_table_name (time, image_file_name, image_alt_text)
								  VALUES('".current_time('mysql')."', '$image_file_name', 'picture')";
						mysqli_query($dbc, $query) or die(mysqli_error($dbc));
						mysqli_close($dbc);
						
						$success = "<p class=success>Your image successfully added.</p>";
						header('Location: '.$_SERVER['HTTP_REFERER']."&success=$success&mage_file_name=$image_file_name");
					}
					else {
						
						// The new picture file move failed, so delete the temporary file and set the error flag
						@unlink($_FILES['new_picture']['tmp_name']);
						$error = $target."<p class=error>Sorry, there was a problem uploading your picture.</p>";
						header('Location: '.$_SERVER['HTTP_REFERER']."&error=$error");
					}
				}
			}
			else {
				
				// The new picture file is not valid, so delete the temporary file and set the error flag
				@unlink($_FILES['new_picture']['tmp_name']);
				$error = "<p class=error>Your picture must be a GIF, JPEG, or PNG image file no greater than " . (MM_MAXFILESIZE / 1024) .
				" KB and " . MM_MAXIMGWIDTH . "x" . MM_MAXIMGHEIGHT . " pixels in size.</p>";
				//header('Location: '.$_SERVER['HTTP_REFERER']."&error=$error");
			}
		}
	}		
?>