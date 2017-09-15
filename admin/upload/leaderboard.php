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
	<title>Image upload</title>
	<link href='http://fonts.googleapis.com/css?family=Boogaloo' rel='stylesheet' type='text/css'>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
	<script type="text/javascript" src="js/multiupload.js"></script>
	<script type="text/javascript">
	var config = {
		support : "image/jpg,image/png,image/bmp,image/jpeg,image/gif",		// Valid file formats
		form: "demoFiler",					// Form ID
		dragArea: "dragAndDropFiles",		// Upload Area ID
		uploadUrl: "upload.php"				// Server side upload url
	}
	$(document).ready(function(){
		initMultiUploader(config);
	});
	</script>

	<script type="text/javascript" src="js/jquery.ui.core.js"></script>
	<script type="text/javascript" src="js/jquery.ui.widget.js"></script>
	<script type="text/javascript" src="js/jquery-ui-1.8.14.custom.min.js"></script>
	<script type="text/javascript">
	$(function() {
		$( "#input_5" ).datepicker({
			showOn: "button",
			buttonImage: "images/calendar.png",
			buttonImageOnly: true
		});

		$( "#input_6" ).datepicker({
			showOn: "button",
			buttonImage: "images/calendar.png",
			buttonImageOnly: true
		});
	});
	</script>

	<link rel="stylesheet" type="text/css" href="css/style.css" />
	<link rel="stylesheet" type="text/css" href="css/ui-lightness/jquery-ui-1.8.14.custom.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo WEB_ROOT;?>admin/include/admin.css">
</head>
<body lang="en">
<center><h1 class="title">Multiple Drag and Drop File Upload - Leaderboard Banner</h1></center>
<div id="dragAndDropFiles" class="uploadArea">
	<h1>Drop Artwork Here</h1>
</div>
<form name="demoFiler" id="demoFiler" enctype="multipart/form-data">
<input type="hidden" name="cat_parent_id" id="input_1" value="1" />
<!--
<input type="hidden" name="catId"	id="input_2" value="9" />
<input type="hidden" name="state_id" id="input_3" value="2" />
<input type="hidden" name="location_id" id="input_4" value="20" />
-->
<!--<input type="hidden" name="start_date" id="input_5" value="2014-02-01" />
<input type="hidden" name="end_date" id="input_6" value="2014-02-31" />-->

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
	<td width="150" class="label">Start Date:</td>
	<td class="content"><input type="text" name="start_date" id="input_5" value="" /></td>
</tr>

<tr> 
	<td width="150" class="label">End Date:</td>
	<td class="content"><input type="text" name="end_date" id="input_6" value="" /></td>
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
	Where do you want to place the Web Advert? <br /><br />
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
	<td width="150" class="label">Artwork:</td>
	<td class="content">
	<input type="file" name="multiUpload" id="multiUpload" multiple />
	<!--<input type="submit" name="submitHandler" id="submitHandler" value="Upload" class="buttonUpload" />-->
	</td>
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