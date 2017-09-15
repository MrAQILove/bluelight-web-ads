<?php
if (!defined('WEB_ROOT')) {
	exit;
}

$catId = (isset($_GET['catId']) && $_GET['catId'] > 0) ? $_GET['catId'] : 0;

$categoryList = buildCategoryOptions($catId);
?> 
<p>&nbsp;</p>
<form action="processProduct.php?action=addProduct" method="post" enctype="multipart/form-data" name="frmAddProduct" id="frmAddProduct">
<input type="hidden" name="catId" value="<?php echo $catId; ?>">
<table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="entryTable">
<tr><td colspan="2" id="entryTableHeader">Add a Web Advert</td></tr>

<tr> 
	<td width="150" class="label">Advert Type:</td>
	<td class="content"> 
	<?php	
	/*
	switch ($catId)
	{
		case ($catId == 5 || $catId == 9 || $catId == 13 || $catId == 17 || $catId == 21 || $catId == 25 || $catId == 29 ):
			echo "<b>Leaderboard Banner</b>";
			break;

		case ($catId == 6 || $catId == 10 || $catId == 14 || $catId == 18 || $catId == 22 || $catId == 26 || $catId == 30 ):
			echo "<b>Medium Rec Banner</b>";
			break;

		case ($catId == 7 || $catId == 11 || $catId == 15 || $catId == 19 || $catId == 23 || $catId == 27 || $catId == 31):
			echo "<b>Skyscraper Banner</b>";
			break;

		case ($catId == 8 || $catId == 12 || $catId == 16 || $catId == 20 || $catId == 24 || $catId == 28 || $catId == 32):
			echo "<b>Sponsors Listing</b>";
			break;
	}
	*/

	$checkListingID = array(8, 12, 16, 20, 24, 28, 32, 36, 40, 44, 48, 52, 56, 60, 64, 68, 72, 76, 80, 84, 88, 92, 96, 100, 104, 108, 112, 116, 120, 124, 128, 132);
	if(in_array($catId, $checkListingID)) {
		echo "<b>Sponsors Listing</b>";
	}
	?>
	</td>
</tr>

<tr> 
	<td width="150" class="label">Campaign:</td>
	<td class="content"> 
	<div class="styled-select">
		<select name="cboCategory" id="cboCategory">
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
				echo "<select name='txtStateID'>\n";
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
	<?php
	$checkId = array(8, 12, 16, 20, 24, 28, 32, 36, 40, 44, 48, 52, 56, 60, 64, 68, 72, 76, 80, 84, 88, 92, 96, 100, 104, 108, 112, 116, 120, 124, 128, 132);
	if(in_array($catId, $checkId)) {
		echo 'Where do you want to place the Web Advert Listing? <br /><br />'. "\n";
	}

	else {	
		echo 'Where do you want to place the Web Advert Banner? <br /><br />'. "\n";
	}
	?>
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
				echo "<select name='txtLocationID'>\n";
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
	<td width="150" class="label">Booking No.:</td>
	<td class="content"> <input type="text" id="txtBookingNo" name="txtBookingNo" size="50" maxlength="100"></td>
</tr>

<tr> 
	<td width="150" class="label">Name:</td>
	<td class="content"> <input type="text" id="txtName" name="txtName" size="50" maxlength="100"></td>
</tr>

<?php
	$checkId = array(8, 12, 16, 20, 24, 28, 32, 36, 40, 44, 48, 52, 56, 60, 64, 68, 72, 76, 80, 84, 88, 92, 96, 100, 104, 108, 112, 116, 120, 124, 128, 132);
	if(in_array($catId, $checkId))
	{
		echo '
			<tr> 
				<td width="150" class="label">Description:</td>
				<td class="content"><textarea name="txtDescription" cols="50" rows="4" class="box" id="txtDescription"></textarea></td>
			</tr>
		';
	}

	else 
	{
		echo '
			<tr> 
				<td width="150" class="label">Artwork:</td>
				<td class="content"> <input name="fleImage" type="file" id="fleImage" class="box"></td>
			</tr>
			';
	}
//}
?>
<tr> 
	<td width="150" class="label">Link:</td>
	<td class="content"> <input name="txtLink" type="text" id="txtLink" size="50" maxlength="100"></td>
</tr>

<tr> 
	<td width="150" class="label">Start Date:</td>
	<td class="content"><input type="text" name="start_date" id="start_date" /></td>
</tr>

<tr> 
	<td width="150" class="label">End Date:</td>
	<td class="content"><input type="text" name="end_date" id="end_date" /></td>
</tr>
</table>

<table>
<tr><td colspan="2">&nbsp;</td></tr>

<tr>
	<td colspan="2">
	<div class="buttons">
	<?php
		/*
		switch ($catId)
		{
			case ($catId == 5 || $catId == 9 || $catId == 13 || $catId == 17 || $catId == 21):
				echo "<button name=\"btnAddProduct\" id=\"btnAddProduct\" onClick=\"addLeaderboardBanner();\" class=\"btnSubmit\">Add Banner</button>&nbsp;&nbsp;";
				break;

			case ($catId == 6 || $catId == 10 || $catId == 14 || $catId == 18 || $catId == 22):
				echo "<button name=\"btnAddProduct\" id=\"btnAddProduct\" onClick=\"addMediumRecBanner();\" class=\"btnSubmit\">Add Banner</button>&nbsp;&nbsp;";
				break;

			case ($catId == 7 || $catId == 11 || $catId == 15 || $catId == 19 || $catId == 23):
				echo "<button name=\"btnAddProduct\" id=\"btnAddProduct\" onClick=\"addSkyscraperBanner();\" class=\"btnSubmit\">Add Banner</button>&nbsp;&nbsp;";
				break;

			
			case ($catId == 8 || $catId == 12 || $catId == 16 || $catId == 20 || $catId == 24):
				echo "<button name=\"btnAddProduct\" id=\"btnAddProduct\" onClick=\"addListing();\" class=\"btnSubmit\">Add Listing</button>&nbsp;&nbsp;";
				break;
		}
		*/

		$checkListingID = array(8, 12, 16, 20, 24, 28, 32, 36, 40, 44, 48, 52, 56, 60, 64, 68, 72, 76, 80, 84, 88, 92, 96, 100, 104, 108, 112, 116, 120, 124, 128, 132);
		if(in_array($catId, $checkListingID)) {
			echo "<button name=\"btnAddProduct\" id=\"btnAddProduct\" onClick=\"addListing();\" class=\"btnSubmit\">Add Listing</button>&nbsp;&nbsp;";
		}

		?>
		<button onClick="window.location.href='index.php';" class="btnSubmit" id="btnCancel">Cancel</button>
	</div>
	</td>
</tr>
</table>
</form>
<p>&nbsp;</p>
