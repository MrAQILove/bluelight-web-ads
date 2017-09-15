<?php 
require_once '../../library/config.php'; 
require_once '../library/functions.php';

$catId = (isset($_GET['catId']) && $_GET['catId'] > 0) ? $_GET['catId'] : 0;

$categoryList = buildCategoryOptions($catId);
?>

<!DOCTYPE>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>CSV File Upload</title>
	<link href='http://fonts.googleapis.com/css?family=Boogaloo' rel='stylesheet' type='text/css'>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
	<script type="text/javascript" src="js/multiupload.js"></script>
	<script type="text/javascript">
	var config = {
		// Valid file formats
		support: "text/x-comma-separated-values,text/comma-separated-values,application/octet-stream,application/vnd.ms-excel,text/csv,application/csv,application/excel,application/vnd.msexcel",
		form: "demoFiler",					// Form ID
		dragArea: "dragAndDropFiles",		// Upload Area ID
		uploadUrl: "upload.php"				// Server side upload url
	}
	$(document).ready(function(){
		initMultiUploader(config);
	});
	</script>
	<link rel="stylesheet" type="text/css" href="css/style.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo WEB_ROOT;?>admin/include/admin.css">
</head>
<body lang="en">
<center><h1 class="title">Drag and Drop CSV File Upload - Sponsor Listing</h1></center>
<div id="dragAndDropFiles" class="uploadArea">
	<h1>Drop CSV File Here</h1>
</div>
<form name="demoFiler" id="demoFiler" enctype="multipart/form-data">
<input type="hidden" name="ad_type" id="input_0" value="Listing" />
<input type="hidden" name="cat_parent_id" id="input_1" value="4" />
<input type="hidden" name="start_date" id="input_5" value="2013-08-01" />
<input type="hidden" name="end_date" id="input_6" value="2013-10-31" />

<table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="entryTable">
<tr> 
	<td width="150" class="label">Campaign:</td>
	<td class="content">
	<div class="styled-select">
		<select name="cboCategory" id="input_2">
		<option value="" selected>-- Choose Campaign --</option>
		<?php echo $categoryList; ?>	 
		</select>
	</div>
	</td>
</tr>

<tr> 
	<td width="150" class="label">State:</td>
	<td class="content">
	<div class="styled-select">
		<?php
		// Form a query to populate the combo-box
		$query = "SELECT * FROM tbl_state;";

		// Successful query?
		if($result = mysql_query($query))  
		{
			// If there are results returned, prepare combo-box
			if($success = mysql_num_rows($result) > 0) 
			{
				// Start combo-box
				echo '<select id="input_3">'."\n";
				echo "<option>-- Choose Web Advert State --</option>\n";

				// For each item in the results...
				while ($row = mysql_fetch_array($result))
					// Add a new option to the combo-box
					echo "<option value='$row[state_id]'>$row[state_abbr]</option>\n";

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
	Where do you want to place the Web Advert Listing? <br /><br />
	<div class="styled-select">
		<?php
		// Form a query to populate the combo-box
		$query = "SELECT * FROM tbl_location;";

		// Successful query?
		if($result = mysql_query($query))  
		{
			// If there are results returned, prepare combo-box
			if($success = mysql_num_rows($result) > 0) 
			{
				// Start combo-box
				echo '<select id="input_4">'."\n";
				echo "<option>-- Choose Web Advert Location --</option>\n";

				// For each item in the results...
				while ($row = mysql_fetch_array($result))
					// Add a new option to the combo-box
					echo "<option value='$row[location_id]'>$row[location_name]</option>\n";

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
	<td width="150" class="label">CSV File:</td>
	<td class="content"><input type="file" name="multiUpload" id="multiUpload" multiple /></td>
</tr>
</table>

<table>
<tr><td colspan="3">&nbsp;</td></tr>

<tr>
	<td><input type="submit" name="submitHandler" id="submitHandler" value="Upload" class="buttonUpload" /></td>
	<td>&nbsp;&nbsp;</td>
	<td><div class="buttons"><button onClick="window.location.href='../index.php';" class="btnSubmit" id="btnCancel">Cancel</button></div></td>
</tr>
</table>
</form>
<div class="progressBar">
	<div class="status"></div>
</div>
	
</body>
</html>