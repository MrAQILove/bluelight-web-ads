<?php
if (!defined('WEB_ROOT')) {
	exit;
}

function convertDateFromSQL($dateFromSQL) 
{
	$date = strtotime($dateFromSQL);
	$final_date = date("F j, Y", $date);
	return $final_date;
}

if (isset($_GET['catId']) && (int)$_GET['catId'] > 0) 
{
	$catId = (int)$_GET['catId'];
	
	/* Put this back JANUARY 5, 2015 */
	
	$sql2 = " AND p.cat_id = $catId"; 
	
	
	/* DELETE THIS ON JANUARY 5, 2015 */
	/* $sql2 = " WHERE p.cat_id = $catId"; */

	$queryString = "catId=$catId";
} 

else 
{
	$catId = 0;
	$sql2  = '';
	$queryString = '';
}

if (isset($_GET['locationId']) && (int)$_GET['locationId'] > 0) 
{
	$locationId = (int)$_GET['locationId'];
	$sql3 = " AND p.pd_location_id = $locationId";
	$queryString = "locationId=$locationId";
}

else 
{
	$locationId = 0;
	$sql3  = '';
	$queryString = '';
}

// Current date
$current_date = date( 'Y-m-d', time() ); 

// for paging
// How many rows to show per page
$rowsPerPage = 20;

/* Put this back JANUARY 5, 2015 */

$sql = "SELECT *
		FROM tbl_product p 
		INNER JOIN tbl_category c ON p.cat_id = c.cat_id
		INNER JOIN tbl_location l ON p.pd_location_id = l.location_id
		WHERE p.pd_start_date <= '$current_date' AND p.pd_end_date >= '$current_date'
		$sql2
		$sql3
		ORDER BY pd_id DESC";


/* DELETE THIS ON JANUARY 5, 2015 */
/*$sql = "SELECT *
		FROM tbl_product p 
		INNER JOIN tbl_category c ON p.cat_id = c.cat_id
		INNER JOIN tbl_location l ON p.pd_location_id = l.location_id
		$sql2
		$sql3
		ORDER BY pd_id DESC";
*/

$result     = dbQuery(getPagingQuery($sql, $rowsPerPage));
$pagingLink = getPagingLink($sql, $rowsPerPage, $queryString);

$categoryList = buildCategoryOptions($catId);
?> 
<table width="100%" border="0" cellspacing="0" cellpadding="2" class="text">
<tr>
	<td align="right">View Web Ads in:
	<div class="styled-select">
		<select name="cboCategory" class="box" id="cboCategory" onChange="viewProduct();">
		<option selected>All Category</option>
		<?php echo $categoryList; ?>
		</select>
	</div>
	</td>
</tr>
</table>
<br />

<?php
$checkLeaderboardID = array(5, 10, 13, 17, 21, 25, 29, 33, 37, 41, 45, 49, 53, 57, 61, 65, 69, 73, 77, 81, 85, 89, 93, 97, 101, 105, 109, 113, 117, 121, 125, 129);
	if(in_array($catId, $checkLeaderboardID)) {
		echo "<h2>Leaderboard Banner Ads</h2>";
}

$checkMediumRecID = array(6, 11, 14, 18, 22, 26, 30, 34, 38, 42, 46, 50, 54, 58, 62, 66, 70, 74, 78, 82, 86, 90, 94, 98, 102, 106, 110, 114, 118, 122, 126, 130);
	if(in_array($catId, $checkMediumRecID)) {
		echo "<h2>Medium Rec Banner Ads</h2>";
}

$checkSkyscraperID = array(7, 11, 15, 19, 23, 27, 31, 35, 39, 43, 47, 51, 55, 59, 63, 67, 71, 75, 79, 83, 87, 91, 95, 99, 103, 107, 111, 115, 119, 123, 127, 131);
	if(in_array($catId, $checkSkyscraperID)) {
		echo "<h2>Skyscraper Banner Ads</h2>";
}

$checkListingID = array(8, 12, 16, 20, 24, 28, 32, 36, 40, 44, 48, 52, 56, 60, 64, 68, 72, 76, 80, 84, 88, 92, 96, 100, 104, 108, 112, 116, 120, 124, 128, 132);
	if(in_array($catId, $checkListingID)) {
		echo "<h2>Sponsors Listing</h2>";
}
?>
<table width="100%" border="0" align="center" cellpadding="2" cellspacing="1" class="text">
<tr> 
	<td colspan="7" align="center"><?php echo $pagingLink; ?></td>
</tr>

<tr align="center" id="listTableHeader"> 
	<td>Booking No.</td>
	<td>Business Name</td>
	<td>Ad Type</td>
	<td>Website Location</td>
	<td>Campaign</td>
	<?php
	$checkListingID = array(8, 12, 16, 20, 24, 28, 32, 36, 40, 44, 48, 52, 56, 60, 64, 68, 72, 76, 80, 84, 88, 92, 96, 100, 104, 108, 112, 116, 120, 124, 128, 132);
	if(in_array($catId, $checkListingID)) {
		echo "<td>View Listing</td>";
	}
	else {
		echo "<td>Web Ad Image</td>";
	}
	?>
	<td>Modify</td>
	<td>Delete</td>
</tr>
<?php
$parentId = 0;
if (dbNumRows($result) > 0) 
{
	$i = 0;
	while($row = dbFetchAssoc($result)) 
	{
		extract($row);
		if ($pd_thumbnail) {
			$pd_thumbnail = WEB_ROOT . 'images/product/' . $pd_thumbnail;
		} 
		
		else {
			$pd_thumbnail = WEB_ROOT . 'images/no-image-small.png';
		}	
		
		if ($i%2) {
			$class = 'row1';
		} 
		
		else {
			$class = 'row2';
		}
		
		$i += 1;
?>
	<tr class="<?php echo $class; ?>"> 
		<td align="center"><a href="index.php?view=detail&productId=<?php echo $pd_id; ?>&catId=<?php echo $cat_id; ?>"><?php echo $pd_booking_no; ?></a></td>
		<td align="center"><?php echo $pd_name; ?></td>
		<td align="center">
		<?php 
		switch ($cat_parent_id)
		{
			case 1;
			echo "Leaderboard Banner";
			break;

			case 2;
			echo "Medium Rec Banner";
			break;

			case 3;
			echo "Skyscraper Banner";
			break;

			case 4;
			echo "Listing";
			break;
		}
		?>
		</td>
		<td align="center"><?php echo $location_name; ?></td>
		<td align="center"><a href="?catId=<?php echo $cat_id; ?>"><?php echo $cat_name; ?></a></td>
		<td align="center">
		<?php 
		$checkProductID = array(1065, 1066, 1067, 1068, 1069, 1070, 1071, 1072, 1073, 1074, 1075, 1076, 1077, 1078, 1079, 1080, 1081, 1082, 1083, 1084, 1084, 1085, 1086, 1087, 1088, 1089, 1090, 1091, 1092, 1093, 1094, 1095);

		$checkListingID = array(8, 12, 16, 20, 24, 28, 32, 36, 40, 44, 48, 52, 56, 60, 64, 68, 72, 76, 80, 84, 88, 92, 96, 100, 104, 108, 112, 116, 120, 124, 128, 132);

		if ($pd_id == 1096) {
			echo '<img src="'.$pd_thumbnail .'" width="300" height="250">';
		}

		else if(in_array($pd_id, $checkProductID)) {
			echo '<img src="'.$pd_thumbnail .'" width="120" height="600">';
		}

		else if(in_array($catId, $checkListingID)) {
			if ($pd_location_id == 25) {
				echo "<a href=\"http://www.bluelight.com.au/ad-banner/vic-metro-local-sponsors.php\">View</a>";
			}
			else {
				echo "<a href=\"http://www.bluelight.com.au/ad-banner/vic-regional-local-sponsors.php\">View</a>";
			}
		}
		
		else {	
			echo '<img src="'.$pd_thumbnail .'">';
		}
		?>
		</td>
		<td align="center"><a href="javascript:modifyProduct(<?php echo $pd_id; ?>);">Modify</a></td>
		<td align="center"><a href="javascript:deleteProduct(<?php echo $pd_id; ?>, <?php echo $catId; ?>);">Delete</a></td>
	</tr>
	<?php
	} // end while
?>
	<tr> 
		<td colspan="8" align="center"><?php echo $pagingLink; ?></td>
	</tr>
<?php	
} 

else 
{
	echo '<tr><td colspan="8"><p>&nbsp;</p></td></tr>'."\n";
	echo '<tr>
			<td colspan="8" align="center">
			<p>Campaign hasn\'t started. There are no'; 
			
	$checkLeaderboardID = array(5, 10, 13, 17, 21, 25, 29, 33, 37, 41, 45, 49, 53, 57, 61, 65, 69, 73, 77, 81, 85, 89, 93, 97, 101, 105, 109, 113, 117, 121, 125, 129);
	if(in_array($catId, $checkLeaderboardID)) {
		echo " Leaderboard Banner Web Ads are listed.</p></td></tr>\n";
	}

	$checkMediumRecID = array(6, 11, 14, 18, 22, 26, 30, 34, 38, 42, 46, 50, 54, 58, 62, 66, 70, 74, 78, 82, 86, 90, 94, 98, 102, 106, 110, 114, 118, 122, 126, 130);
	if(in_array($catId, $checkMediumRecID)) {
		echo " Medium Rec Banner Web Ads are listed.</p></td></tr>\n";
	}

	$checkSkyscraperID = array(7, 11, 15, 19, 23, 27, 31, 35, 39, 43, 47, 51, 55, 59, 63, 67, 71, 75, 79, 83, 87, 91, 95, 99, 103, 107, 111, 115, 119, 123, 127, 131);
	if(in_array($catId, $checkSkyscraperID)) {
		echo " Skyscraper Banner Web Ads are listed.</p></td></tr>\n";
	}

	$checkListingID = array(8, 12, 16, 20, 24, 28, 32, 36, 40, 44, 48, 52, 56, 60, 64, 68, 72, 76, 80, 84, 88, 92, 96, 100, 104, 108, 112, 116, 120, 124, 128, 132);
	if(in_array($catId, $checkListingID)) {
		echo " Sponsor Listings are listed.</p></td></tr>\n";
	}
}

if ($catId != "0")
{
	echo'
		<tr><td colspan="8"><p>&nbsp;</p></td></tr>
	
		<tr>
			<td colspan="8">
	';
			$checkLeaderboardID = array(5, 10, 13, 17, 21, 25, 29, 33, 37, 41, 45, 49, 53, 57, 61, 65, 69, 73, 77, 81, 85, 89, 93, 97, 101, 105, 109, 113, 117, 121, 125, 129);
			if(in_array($catId, $checkLeaderboardID)) {
				echo '<button name="btnAddProduct" id="btnAddProduct" onClick="addLeaderboardBanner('.$catId.');" class="btnSubmit">Add Banner</button>&nbsp;&nbsp;';
			}

			$checkMediumRecID = array(6, 11, 14, 18, 22, 26, 30, 34, 38, 42, 46, 50, 54, 58, 62, 66, 70, 74, 78, 82, 86, 90, 94, 98, 102, 106, 110, 114, 118, 122, 126, 130);
			if(in_array($catId, $checkMediumRecID)) {
				echo '<button name="btnAddProduct" id="btnAddProduct" onClick="addMediumRecBanner('.$catId.');" class="btnSubmit">Add Banner</button>&nbsp;&nbsp;';	
			}

			$checkSkyscraperID = array(7, 11, 15, 19, 23, 27, 31, 35, 39, 43, 47, 51, 55, 59, 63, 67, 71, 75, 79, 83, 87, 91, 95, 99, 103, 107, 111, 115, 119, 123, 127, 131);
			if(in_array($catId, $checkSkyscraperID)) {
				echo '<button name="btnAddProduct" id="btnAddProduct" onClick="addSkyscraperBanner('.$catId.');" class="btnSubmit">Add Banner</button>&nbsp;&nbsp;';
			}

			$checkListingID = array(8, 12, 16, 20, 24, 28, 32, 36, 40, 44, 48, 52, 56, 60, 64, 68, 72, 76, 80, 84, 88, 92, 96, 100, 104, 108, 112, 116, 120, 124, 128, 132);
			if(in_array($catId, $checkListingID)) {
				echo '<button name="btnAddProduct" id="btnAddProduct" onClick="addListing('.$catId.');" class="btnSubmit">Add Listing</button>&nbsp;&nbsp;';
			}
		
	echo '
			</td>
		</tr>
	';
}
?>
</table>
<p>&nbsp;</p>