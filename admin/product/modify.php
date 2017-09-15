<?php
if (!defined('WEB_ROOT')) {
	exit;
}

// make sure a product id exists
if (isset($_GET['productId']) && $_GET['productId'] > 0) {
	$productId = $_GET['productId'];
} 

else {
	// redirect to index.php if product id is not present
	header('Location: index.php');
}

// get product info
$sql = "SELECT *
        FROM tbl_product pd, tbl_category cat
		WHERE pd.pd_id = $productId 
		AND pd.cat_id = cat.cat_id";

$result = mysql_query($sql) or die('Cannot get product. ' . mysql_error());
$row    = mysql_fetch_assoc($result);
extract($row);

// get category list
$sql = "SELECT cat_id, cat_parent_id, cat_name
        FROM tbl_category
		WHERE cat_active ='1'
		ORDER BY cat_id";

$result = dbQuery($sql) or die('Cannot get Product. ' . mysql_error());

$categories = array();
while($row = dbFetchArray($result)) 
{
	list($id, $parentId, $name) = $row;
	
	if ($parentId == 0) {
		$categories[$id] = array('name' => $name, 'children' => array());
	} 
	
	else {
		$categories[$parentId]['children'][] = array('id' => $id, 'name' => $name);	
	}
}	

//echo '<pre>'; print_r($categories); echo '</pre>'; exit;

// build combo box options
$list = '';
foreach ($categories as $key => $value) 
{
	$name     = $value['name'];
	$children = $value['children'];
	
	$list .= "<optgroup label=\"$name\">"; 
	
	foreach ($children as $child) {
		$list .= "<option value=\"{$child['id']}\"";
		
		if ($child['id'] == $cat_id) {
			$list .= " selected";
		}
		
		$list .= ">{$child['name']}</option>";
	}
	
	$list .= "</optgroup>";
}
?> 
<form action="processProduct.php?action=modifyProduct&productId=<?php echo $productId; ?>" method="post" enctype="multipart/form-data" name="frmAddProduct" id="frmAddProduct">
<input type="hidden" name="cat_parent_id" value="<?php echo $cat_parent_id;?>">
<p align="center" class="formTitle">Modify Web Advert</p>
 
<table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="entryTable">
<tr> 
	<td width="150" class="label">Campaign</td>
	<td class="content">
	<div class="styled-select">
		<select name="cboCategory" id="cboCategory">
		<?php echo $list; ?>	 
		</select>
	</div>
	</td>
</tr>

<tr> 
	<td width="150" class="label">Booking No.:</td>
	<td class="content"> <input name="txtBookingNo" type="text" class="box" id="txtBookingNo" value="<?php echo $pd_booking_no; ?>" size="50" maxlength="100"></td>
</tr>

<tr> 
	<td width="150" class="label">Name:</td>
	<td class="content"> <input name="txtName" type="text" class="box" id="txtName" value="<?php echo $pd_name; ?>" size="50" maxlength="100"></td>
</tr>

<tr> 
	<td width="150" class="label">State:</td>
	<td class="content">
	<div class="styled-select">
		<?php
		// Form a query to populate the combo-box
		$query = "SELECT * FROM tbl_state";

		// Successful query?
		if($result = mysql_query($query))  
		{
			// If there are results returned, prepare combo-box
			if($success = mysql_num_rows($result) > 0) 
			{
				// Start combo-box
				echo "<select name='txtStateID'>\n";
				echo "<option>-- Choose Advert State --</option>\n";

				// For each item in the results...
				while ($row = mysql_fetch_array($result))
				{
					//Add a new option to the combo-box 
		?>
					<option value="<?php echo $row['state_id'];?>" <?php if ($row['state_id'] == $pd_state_id) { echo "selected"; } ?>><?php echo $row['state_abbr']; ?></option>
		<?php
				}
					// End the combo-box
					echo "</select>\n";
			}
			// No results found in the database
			else 
				{ echo "No results found."; }
		}
		?>
	</div>
	</td>
</tr>

<tr> 
	<td width="150" class="label">Location:</td>
	<td class="content">
	Where do you want to place the Web Advert? <br /><br />

	<div class="styled-select">
		<?php
		// Form a query to populate the combo-box
		$query = "SELECT * FROM tbl_location";

		// Successful query?
		if($result = mysql_query($query))  
		{
			// If there are results returned, prepare combo-box
			if($success = mysql_num_rows($result) > 0) 
			{
				// Start combo-box
				echo "<select name='txtLocationID'>\n";
				echo "<option>-- Choose Advert Location --</option>\n";

				// For each item in the results...
				while ($row = mysql_fetch_array($result))
				{
					//Add a new option to the combo-box 
		?>
					<option value="<?php echo $row['location_id'];?>" <?php if ($row['location_id'] == $pd_location_id) { echo "selected"; } ?>><?php echo $row['location_name']; ?></option>
		<?php
				}
					// End the combo-box
					echo "</select>\n";
			}
			// No results found in the database
			else 
				{ echo "No results found."; }
		}
		?>
	</div>
	</td>
</tr>

<?php
if ($cat_parent_id != 4)
{
	echo '
		<tr> 
			<td width="150" class="label">Artwork:</td>
			<td class="content"> <input name="fleImage" type="file" id="fleImage" class="box">
		';
				if ($pd_thumbnail != '') 
				{
					$webad = WEB_ROOT . PRODUCT_IMAGE_DIR . $pd_thumbnail;

					$checkProductID = array(1065, 1066, 1067, 1068, 1069, 1070, 1071, 1072, 1073, 1074, 1075, 1076, 1077, 1078, 1079, 1080, 1081, 1082, 1083, 1084, 1084, 1085, 1086, 1087, 1088, 1089, 1090, 1091, 1092, 1093, 1094, 1095);

					if ($pd_id == 1096) {
						$webadimage =  '<img class="artwork" src="'.$webad.'" width="300" height="250">';
					}

					else if(in_array($pd_id, $checkProductID)) {
						$webadimage = '<img class="artwork" src="'.$webad.'" width="120" height="600">';
					}
					
					else {	
						$webadimage = '<img class="artwork" src="'.$webad.'">';
					}
			?>
			<br />
			<?php echo $webadimage; ?><br /> 
			<a href="javascript:deleteImage(<?php echo $productId; ?>);">Delete Artwork</a> 
			<?php
			}
			?>    
			</td>
		</tr>
	<?php
}
else
{
	echo '
		<tr> 
			<td width="150" class="label">Description:</td>
			<td class="content"><textarea name="txtDescription" cols="50" rows="4" class="box" id="txtDescription">'.$pd_description.'</textarea></td>
		</tr>
	';
}
?>

<tr> 
	<td width="150" class="label">Link:</td>
	<td class="content"> <input name="txtLink" type="text" id="txtLink" value="<?php echo $pd_link; ?>" size="50" maxlength="100"></td>
</tr>

<tr> 
	<td width="150" class="label">Start Date:</td>
	<td class="content"><input type="text" name="start_date" id="start_date" value="<?php echo $pd_start_date; ?>" /></td>
</tr>

<tr> 
	<td width="150" class="label">End Date:</td>
	<td class="content"><input type="text" name="end_date" id="end_date" value="<?php echo $pd_end_date; ?>" /></td>
</tr>
</table>

<table>
<tr><td colspan="2">&nbsp;</td></tr>

<tr>
	<td colspan="2">
	<div class="buttons">
		<button onClick="checkAddProductForm();" class="btnSubmit" name="btnModifyProduct" id="btnModifyProduct">Modify Banner</button>&nbsp;&nbsp;	
		<?php
		$checkLeaderboardID = array(5, 10, 13, 17, 21, 25, 29, 33, 37, 41, 45, 49, 53, 57, 61, 65, 69, 73, 77, 81, 85, 89, 93, 97);
			if(in_array($cat_id, $checkLeaderboardID)) {
		?>
				<input type="button" value="Cancel" name="btnCancel" id="btnCancel" onClick="window.location.href='index.php?catId=<?php echo $cat_id; ?>';" class="btnSubmit" />
		<?php
		}

		$checkMediumRecID = array(6, 11, 14, 18, 22, 26, 30, 34, 38, 42, 46, 50, 54, 58, 62, 66, 70, 74, 78, 82, 86, 90, 94, 98);
			if(in_array($cat_id, $checkMediumRecID)) {
		?>
				<input type="button" value="Cancel" name="btnCancel" id="btnCancel" onClick="window.location.href='index.php?catId=<?php echo $cat_id; ?>';" class="btnSubmit" />
		<?php
		}

		$checkSkyscraperID = array(7, 11, 15, 19, 23, 27, 31, 35, 39, 43, 47, 51, 55, 59, 63, 67, 71, 75, 79, 83, 87, 91, 95, 99);
			if(in_array($cat_id, $checkSkyscraperID)) {
		?>
				<input type="button" value="Cancel" name="btnCancel" id="btnCancel" onClick="window.location.href='index.php?catId=<?php echo $cat_id; ?>';" class="btnSubmit" />
		<?php
		}

		$checkListingID = array(8, 12, 16, 20, 24, 28, 32, 36, 40, 44, 48, 52, 56, 60, 64, 68, 72, 76, 80, 84, 88, 92, 96, 100);
			if(in_array($cat_id, $checkListingID)) {
		?>
				<input type="button" value="Cancel" name="btnCancel" id="btnCancel" onClick="window.location.href='index.php?catId=<?php echo $cat_id; ?>';" class="btnSubmit" />
		<?php
		}
		?>
	</div>
	</td>
</tr>
</table>
</form>
<p>&nbsp;</p>