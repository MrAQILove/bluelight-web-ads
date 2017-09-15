<?php
require_once '../../library/config.php';
require_once '../library/functions.php';

checkUser();

$action = isset($_GET['action']) ? $_GET['action'] : '';

switch ($action) 
{	
	case 'addProduct' :
		addProduct();
		break;
		
	case 'modifyProduct' :
		modifyProduct();
		break;
		
	case 'deleteProduct' :
		deleteProduct();
		break;
	
	case 'deleteImage' :
		deleteImage();
		break;
    

	default :
	    // if action is not defined or unknown
		// move to main product page
		header('Location: index.php');
}


function addProduct()
{
    $catId				= $_POST['cboCategory'];
	$cat_parent_id		= $_POST['catId'];
	$booking_number		= $_POST['txtBookingNo'];
    $name				= $_POST['txtName'];
	$link				= $_POST['txtLink'];
	$state_id			= (int)$_POST['txtStateID'];
	$location_id		= (int)$_POST['txtLocationID'];
	
	$start_date	= convertDate($_POST['start_date']);
	$end_date	= convertDate($_POST['end_date']);

	
	$checkListingID = array(8, 12, 16, 20, 24, 28, 32, 36, 40, 44, 48, 52, 56, 60, 64, 68, 72, 76, 80, 84, 88, 92, 96, 100, 104, 108, 112, 116, 120, 124, 128, 132);
	if(in_array($cat_parent_id, $checkListingID)) {
		$cat_parent_id = 4;
	}
	
	if ($cat_parent_id != 4)
	{
		$images = uploadProductImage('fleImage', SRV_ROOT . 'images/product/', $cat_parent_id);

		$mainImage = $images['image'];
		$thumbnail = $images['thumbnail'];
		
		$insert_query = 'INSERT INTO tbl_product ( cat_id, pd_booking_no, pd_name, pd_link, pd_state_id, pd_location_id, pd_image, pd_thumbnail, pd_start_date, pd_end_date )
					VALUES
					(
					"' . $catId . '",
					"' . $booking_number. '",
					"' . $name . '",
					"' . $link . '",
					"' . $state_id . '",
					"' . $location_id . '",
					"' . $mainImage . '",
					"' . $thumbnail . '",
					"' . $start_date . '",
					"' . $end_date . '"
					)'; 
	}
	
	else
	{
		$description		= $_POST['txtDescription'];

		$insert_query = 'INSERT INTO tbl_product ( cat_id, pd_booking_no, pd_name, pd_link, pd_description, pd_state_id, pd_location_id, pd_start_date, pd_end_date )
					VALUES
					(
					"' . $catId . '",
					"' . $booking_number. '",
					"' . $name . '",
					"' . $link . '",
					"' . $description . '",
					"' . $state_id . '",
					"' . $location_id . '",
					"' . $start_date . '",
					"' . $end_date . '"
					)';  
	}

	$result = dbQuery($insert_query);
	
	header("Location: index.php?catId=$catId");	
}

/*
	Upload an image and return the uploaded image name 
*/
function uploadProductImage($inputName, $uploadDir, $cat_parent_id)
{
	$image     = $_FILES[$inputName];
	$imagePath = '';
	$thumbnailPath = '';
	
	// if a file is given
	if (trim($image['tmp_name']) != '') 
	{
		$ext = substr(strrchr($image['name'], "."), 1); //$extensions[$image['type']];

		// generate a random new file name to avoid name conflict
		$imagePath = md5(rand() * time()) . ".$ext";
		
		list($width, $height, $type, $attr) = getimagesize($image['tmp_name']); 

		// make sure the image width does not exceed the
		// maximum allowed width
		if (LIMIT_PRODUCT_WIDTH && $width > MAX_PRODUCT_IMAGE_WIDTH) 
		{
			$result    = createThumbnail($image['tmp_name'], $uploadDir . $imagePath, MAX_PRODUCT_IMAGE_WIDTH);
			$imagePath = $result;
		} 
		
		else {
			$result = move_uploaded_file($image['tmp_name'], $uploadDir . $imagePath);
		}	
		
		if ($result) 
		{
			// create thumbnail
			$thumbnailPath =  md5(rand() * time()) . ".$ext";

			switch ($cat_parent_id)
			{
				case 1:
				$result = createThumbnail($uploadDir . $imagePath, $uploadDir . $thumbnailPath, 728);
				break;

				case 2:
				$result = createThumbnail($uploadDir . $imagePath, $uploadDir . $thumbnailPath, 300);
				break;

				case 3:
				$result = createThumbnail($uploadDir . $imagePath, $uploadDir . $thumbnailPath, 120);
				break;
			}
			
			// create thumbnail failed, delete the image
			if (!$result) 
			{
				unlink($uploadDir . $imagePath);
				$imagePath = $thumbnailPath = '';
			} 
			
			else {
				$thumbnailPath = $result;
			}	
		} 
		
		else {
			// the product cannot be upload / resized
			$imagePath = $thumbnailPath = '';
		}
	}

	return array('image' => $imagePath, 'thumbnail' => $thumbnailPath);
}

/*
	Modify a product
*/
function modifyProduct()
{
	$productId		= (int)$_GET['productId'];	
    $catId			= $_POST['cboCategory'];
	$cat_parent_id	= $_POST['cat_parent_id'];
	$booking_number	= $_POST['txtBookingNo'];
    $name			= $_POST['txtName'];
	$link			= $_POST['txtLink'];
	$state_id		= (int)$_POST['txtStateID'];
	$location_id	= (int)$_POST['txtLocationID'];
	
	$start_date	= convertDate($_POST['start_date']);
	$end_date	= convertDate($_POST['end_date']);
	
	if ($cat_parent_id != 4)
	{
		$images = uploadProductImage('fleImage', SRV_ROOT . 'images/product/', $cat_parent_id);

		$mainImage = $images['image'];
		$thumbnail = $images['thumbnail'];

		// if uploading a new image
		// remove old image
		if ($mainImage != '') 
		{
			_deleteImage($productId);
			
			$mainImage = "'$mainImage'";
			$thumbnail = "'$thumbnail'";
		} 
		
		else 
		{
			// if we're not updating the image
			// make sure the old path remain the same
			// in the database
			$mainImage = 'pd_image';
			$thumbnail = 'pd_thumbnail';
		}
				
		$update_query   = "UPDATE tbl_product 
				  SET cat_id = $catId, 
						pd_booking_no = '$booking_number',
						pd_name = '$name', 
						pd_link = '$link', 
						pd_state_id = '$state_id', 
						pd_location_id = '$location_id',
						pd_image = $mainImage, 
						pd_thumbnail = $thumbnail,
						pd_start_date = '$start_date', 
						pd_end_date = '$end_date' 
				  WHERE pd_id = '$productId'";
	}

	else
	{		
		$description	= $_POST['txtDescription'];

		$update_query   = "UPDATE tbl_product 
				  SET cat_id = $catId, 
						pd_booking_no = '$booking_number',
						pd_name = '$name', 
						pd_link = '$link', 
						pd_description = '$description',
						pd_state_id = '$state_id', 
						pd_location_id = '$location_id',
						pd_start_date = '$start_date', 
						pd_end_date = '$end_date' 
				  WHERE pd_id = '$productId'";
	}

	$result = dbQuery($update_query);
	
	header('Location: index.php');			  
}

/*
	Remove a product
*/
function deleteProduct()
{
	if (isset($_GET['productId']) && (int)$_GET['productId'] > 0) {
		$productId = (int)$_GET['productId'];
	} else {
		header('Location: index.php');
	}
	
	// remove any references to this product from
	// tbl_order_item and tbl_cart
	/*
	$sql = "DELETE FROM tbl_order_item
	        WHERE pd_id = $productId";
	
	dbQuery($sql);
			
	$sql = "DELETE FROM tbl_cart
	        WHERE pd_id = $productId";	
	
	dbQuery($sql);
	*/
	
	// get the image name and thumbnail
	$sql = "SELECT pd_image, pd_thumbnail
	        FROM tbl_product
			WHERE pd_id = $productId";
			
	$result = dbQuery($sql);
	$row    = dbFetchAssoc($result);
	
	// remove the product image and thumbnail
	if ($row['pd_image']) {
		unlink(SRV_ROOT . 'images/product/' . $row['pd_image']);
		unlink(SRV_ROOT . 'images/product/' . $row['pd_thumbnail']);
	}
	
	// remove the product from database;
	$sql = "DELETE FROM tbl_product 
	        WHERE pd_id = $productId";
	dbQuery($sql);
	
	header('Location: index.php?catId=' . $_GET['catId']);
}


/*
	Remove a product image
*/
function deleteImage()
{
	if (isset($_GET['productId']) && (int)$_GET['productId'] > 0) {
		$productId = (int)$_GET['productId'];
	} else {
		header('Location: index.php');
	}
	
	$deleted = _deleteImage($productId);

	// update the image and thumbnail name in the database
	$sql = "UPDATE tbl_product
			SET pd_image = '', pd_thumbnail = ''
			WHERE pd_id = $productId";
	dbQuery($sql);		

	header("Location: index.php?view=modify&productId=$productId");
}

function _deleteImage($productId)
{
	// we will return the status
	// whether the image deleted successfully
	$deleted = false;
	
	$sql = "SELECT pd_image, pd_thumbnail 
	        FROM tbl_product
			WHERE pd_id = $productId";
	$result = dbQuery($sql) or die('Cannot delete product image. ' . mysql_error());
	
	if (dbNumRows($result)) {
		$row = dbFetchAssoc($result);
		extract($row);
		
		if ($pd_image && $pd_thumbnail) {
			// remove the image file
			$deleted = @unlink(SRV_ROOT . "images/product/$pd_image");
			$deleted = @unlink(SRV_ROOT . "images/product/$pd_thumbnail");
		}
	}
	
	return $deleted;
}

/* Convert SQL date to normal date */
function convertDate($sql_date) 
{
	$date = strtotime($sql_date);
	$final_date = date("Y-m-d H:i:s", $date);
	return $final_date;
}

function convertDateFromSQL($dateFromSQL) 
{
	$date = strtotime($dateFromSQL);
	$final_date = date("F j, Y", $date);
	return $final_date;
}
?>