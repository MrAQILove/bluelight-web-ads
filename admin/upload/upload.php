<?php
require_once '../../library/config.php';

function get_file_extension($file_name) {
    return end(explode('.',$file_name));
}
 
function errors($error)
{
	if (!empty($error))
    {
		$i = 0;
        while ($i < count($error))
		{
			$showError.= '<div class="msg-error">'.$error[$i].'</div>';
            $i ++;
		}
        return $showError;
    }// close if empty errors
} // close function

function ConvertDate($sql_date) 
{
	$date = strtotime($sql_date);
	$final_date = date("Y-m-d H:i:s", $date);
	return $final_date;
}

if($_SERVER['REQUEST_METHOD'] == "POST")
{
	$ad_type = $_POST['ad_type'];

	if ($ad_type == 'Listing')
	{
		$target			= "../../images/csv/";  
		$target			= $target . basename( $_FILES['file']['name']);

		$catId			= $_POST['catId'];

		$start_date	= ConvertDate($_POST['start_date']);
		$end_date	= ConvertDate($_POST['end_date']);

		if(get_file_extension($_FILES['file']['name'])!= 'csv')
		{
			$error[] = 'Only CSV files accepted!';
		}

		if(move_uploaded_file($_FILES['file']['tmp_name'], $target)) 
		{
			if (!$error)
			{
				$tot = 0;
				$handle = fopen($_FILES['file']['tmp_name'], "r");
				while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) 
				{
					for ($c=0; $c < 1; $c++) 
					{
						//only run if the first column is not equal to pd_booking_no
						if($data[0] != 'pd_booking_no')
						{
							mysql_query("INSERT INTO tbl_product (
							cat_id,
							pd_booking_no,
							pd_name,
							pd_link,
							pd_description,
							pd_state_id, 
							pd_location_id, 
							pd_image, 
							pd_thumbnail, 
							pd_start_date, 
							pd_end_date )
							VALUES (
							'$catId',
							'".mysql_real_escape_string($data[0])."',
							'".mysql_real_escape_string($data[1])."',
							'".mysql_real_escape_string($data[2])."',
							'".mysql_real_escape_string($data[3])."',
							'".mysql_real_escape_string($data[4])."',
							'".mysql_real_escape_string($data[5])."',
							'".mysql_real_escape_string($data[6])."',
							'".mysql_real_escape_string($data[7])."',
							'".mysql_real_escape_string($data[8])."',
							'".mysql_real_escape_string($data[9])."'
							)") or die(mysql_error());
						}
						$tot++;
					} // end for
				} // end while
				
				fclose($handle);
				$content.= "<div class='success' id='message'> CSV File Imported, $tot records added </div>";
			}// end no error
		}// close if file has been moved.
		
		//redirect
		header('Location: outcome.php?success=1'); 
		die; 
	}

	// If file upload is not Listing
	else
	{
		$target = "../../images/product/";  
		$allowedExts = array("jpg", "jpeg");
		$extension = end(explode(".", $_FILES["file"]["name"]));
		$target = $target . basename( $_FILES['file']['name']);
			
		$catId			= $_POST['catId'];
		$cat_parent_id	= $_POST['cat_parent_id'];
		$state_id		= $_POST['state_id'];
		$location_id	= $_POST['location_id'];
		//$start_date		= $_POST['start_date'];
		//$end_date		= $_POST['end_date'];

		$start_date	= ConvertDate($_POST['start_date']);
		$end_date	= ConvertDate($_POST['end_date']);

		//Function to generate image thumbnails
		function make_thumb($src, $dest, $desired_width) 
		{
			/* read the source image */
			$source_image = imagecreatefromjpeg($src);
			$width = imagesx($source_image);
			$height = imagesy($source_image);
			
			/* find the "desired height" of this thumbnail, relative to the desired width  */
			$desired_height = floor($height * ($desired_width / $width));
			
			/* create a new, "virtual" image */
			$virtual_image = imagecreatetruecolor($desired_width, $desired_height);
			
			/* copy source image at a resized size */
			imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
			
			/* create the physical thumbnail image to its destination with 100% quality*/
			imagejpeg($virtual_image, $dest,100);
		}

		//check for allowed extensions
		if ((($_FILES["file"]["type"] == "image/jpg") || ($_FILES["file"]["type"] == "image/jpeg")) && in_array($extension, $allowedExts))
		{
			$webAds = $_FILES["file"]["name"];
			if (file_exists("../../images/product/" . $webAds)) {
				die( '<div class="error">Sorry <b>'. $webAds . '</b> already exists</div>');
			}
			
			if(move_uploaded_file($_FILES['file']['tmp_name'], $target)) 
			{
				$pd_name			= !empty($pd_name) ? "'$pd_name'" : "NULL";
				$pd_link			= !empty($pd_link) ? "'$pd_link'" : "NULL";
				$pd_description		= !empty($pd_description) ? "'$pd_description'" : "NULL";
				$pd_thumbnail		= !empty($pd_thumbnail) ? "'$pd_thumbnail'" : "NULL";
				
				// Removing non digits in a string
				$pattern = '/[^0-9]*/';
				$pd_booking_no	= preg_replace($pattern,'', $webAds);
				$thumbname		= preg_replace($pattern,'', $webAds);

				$insert_query = "INSERT INTO tbl_product ( cat_id, pd_booking_no, pd_name, pd_link, pd_description, pd_state_id, pd_location_id, pd_image, pd_thumbnail, pd_start_date, pd_end_date )
					VALUES ('$catId', '$pd_booking_no', '$pd_name', '$pd_link', '$pd_description', '$state_id', '$location_id', '$webAds', '$pd_thumbnail', '$start_date', '$end_date')";  
					
				mysql_query($insert_query); 
				$sql = "SELECT MAX(pd_id) FROM tbl_product";
				$max = mysql_query($sql);
				$row = mysql_fetch_array($max);
				$maxId = $row['MAX(pd_id)'];
					
				$type = $_FILES["file"]["type"];
				switch($type)
				{
					case "image/jpeg":
						$ext = ".jpeg";
					break;
						
					case "image/jpg";
						$ext = ".jpg";
					break;			
				}
				
				$thumbnail = $thumbname."_thumb_". $maxId. $ext ."";

				//define arguments for the make_thumb function
				$source = "../../images/product/" . $webAds;
				$destination = "../../images/product/" . $thumbnail;
					
				//specify your desired width for your thumbnails
				switch ($cat_parent_id)
				{
					case 1:
						$width = "728";
					break;

					case 2:
						$width = "300";
					break;

					case 3:
						$width = "120";
					break;
				}
								 
				//Finally call the make_thumb function
				make_thumb($source,$destination,$width);
					
				$update_query   = "UPDATE tbl_product 
					SET pd_thumbnail = '$thumbnail'
					WHERE pd_id = '$maxId'";

				$result = dbQuery($update_query);

				echo($_POST['index']); // to validate 
			}	 
				
			else {
				$msg = '<div class="error">Sorry, there was a problem uploading your file.</div>';
			}

			exit;
		}
			
		else {
			$msg = '<div class="error">The file type you are trying to upload is not allowed!</div>';
		}
	}
}
?>