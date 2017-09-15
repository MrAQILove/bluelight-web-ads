<?php
if (!defined('WEB_ROOT')) {
	exit;
}

if (isset($_GET['catId']) && (int)$_GET['catId'] >= 0) 
{
	$catParentId = (int)$_GET['catId'];
	$queryString = "&catId=$catParentId";

	/* Put this back JANUARY 5, 2015 */
	/*
	$current_year = date("Y");
	$sql2 = " AND cat_year_created = '$current_year' ORDER BY cat_id DESC";
	*/

	/* DELETE THIS ON JANUARY 5, 2015 */
	$sql2 = "	AND cat_year_created IN (2014, 2015)
				AND cat_id NOT IN (37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,72)
				ORDER BY cat_id ASC
				";
} 

else 
{
	$catParentId = 0;
	$queryString = '';
	$sql2 = " ORDER BY cat_id ASC";
}
	
// for paging
// how many rows to show per page
$rowsPerPage = 24;

/*
$sql = "SELECT cat_id, cat_parent_id, cat_name, cat_description, cat_image, cat_year_created, cat_active
        FROM tbl_category
		WHERE cat_parent_id = $catId
		AND cat_active = '1'
		$sql2";
*/

$sql = "SELECT cat_id, cat_parent_id, cat_name, cat_description, cat_image, cat_year_created, cat_active
        FROM tbl_category
		WHERE cat_parent_id = $catParentId
		$sql2";

$result     = dbQuery(getPagingQuery($sql, $rowsPerPage));
$pagingLink = getPagingLink($sql, $rowsPerPage);

switch ($catParentId)
{
	case 1:
		echo "<h2>Leaderboard Banner Campaign</h2>";
		break;

	case 2:
		echo "<h2>Medium Rec Banner Campaign</h2>";
		break;

	case 3:
		echo "<h2>Skyscraper Banner Campaign</h2>";
		break;

	case 4:
		echo "<h2>Sponsors Listing Campaign</h2>";
		break;
}
?>
<form action="processCategory.php?action=addCategory" method="post"  name="frmListCategory" id="frmListCategory">
<table width="100%" border="0" align="center" cellpadding="2" cellspacing="1" class="text">
<tr align="center" id="listTableHeader"> 
	<td>Campaign</td>
	<td>Ad Banner Type</td>
	<td>Image</td>
	<td>Modify</td>
	<td>Delete</td>
	<?php 
	if ($catParentId != 0) {
		echo '<td>Activate</td>';
		echo '<td>Active?</td>';
	}
	?>
</tr>
<?php
$cat_parent_id = 0;
if (dbNumRows($result) > 0) 
{
	$i = 0;
	
	while($row = dbFetchAssoc($result)) 
	{
		extract($row);
		
		if ($i%2) {
			$class = 'row1';
		} 
		
		else {
			$class = 'row2';
		}
		
		$i += 1;
		
		if ($cat_parent_id == 0) {
			//$cat_name = "<a href=\"index.php?catId=$cat_id\">$cat_name</a>";
			$cat_name = "<a href=\"index.php?catId=$cat_id\">List all $cat_name Campaign</a>";
		}
		
		if ($cat_image) {
			$cat_image = WEB_ROOT . 'images/category/' . $cat_image;
		} 
		
		else {
			$cat_image = WEB_ROOT . 'images/no-image-small.png';
		}		
?>
		<tr class="<?php echo $class; ?>"> 
			<td align="center"><?php echo $cat_name; ?></td>
			<td align="center">
			<?php 
			switch ($catParentId)
			{
				case 1:
					echo "Leaderboard Banner";
					break;

				case 2:
					echo "Medium Rec Banner";
					break;

				case 3:
					echo "Skyscraper Banner";
					break;

				case 4:
					echo "Sponsors Listing";
					break;
			}
			
			//echo nl2br($cat_description); 
			?>
			</td>
			<td align="center"><img src="<?php echo $cat_image; ?>"></td>
			<td align="center"><a href="javascript:modifyCategory(<?php echo $cat_id; ?>);" class="btn btn-danger"><i class="fa fa-pencil fa-fw"></i> Edit</a></td>
			<td align="center"><a href="javascript:deleteCategory(<?php echo $cat_id; ?>);" class="btn btn-danger"><i class="fa fa-trash fa-lg"></i> Delete</a></td>
			<?php 
			if ($catParentId != 0) 
			{
				if ($cat_active == '1') 
				{
					echo '<td align="center"><a href="javascript:deactivateCampaign('.$catParentId.','.$cat_id.');" class="btn btn-danger"><i class="fa fa-minus-square-o fa-lg"></i> DE-ACTIVATE</a></td>';
					echo '<td align="center"><b>YES</b></td>';
				}

				else 
				{
					echo '<td align="center"><a href="javascript:activateCampaign('.$catParentId.','.$cat_id.');" class="btn btn-danger"><i class="fa fa-plus-square-o fa-lg"></i> ACTIVATE</a></td>';
					echo '<td align="center"><b>NO</b></td>';
				}
			}
			?>
		</tr>
  <?php
	} // end while


?>
	<tr> 
		<td colspan="6" align="center"><?php echo $pagingLink; ?></td>
	</tr>
<?php	
} 

else 
{
?>
	<tr> 
		<td colspan="6" align="center">No Web Advert Categories Yet</td>
	</tr>
<?php
}
?>

<tr> 
	<td colspan="6">&nbsp;</td>
</tr>

<tr> 
	<td colspan="6">
	<?php
	switch ($catParentId)
	{
		case 1:
			echo '<input name="btnAddCategory" type="button" id="btnAddCategory" value="Add a NEW Campaign" class="btnSubmit" onClick="addCategory('.$catParentId.')">';
			echo '&nbsp;&nbsp;';
			echo "<button onClick=\"window.location='index.php';\" class=\"btnSubmit\" id=\"btnCancel\">Cancel</button>";
			break;

		case 2:
			echo '<input name="btnAddCategory" type="button" id="btnAddCategory" value="Add a NEW Campaign" class="btnSubmit" onClick="addCategory('.$catParentId.')">';
			echo '&nbsp;&nbsp;';
			echo "<button onClick=\"window.location='index.php';\" class=\"btnSubmit\" id=\"btnCancel\">Cancel</button>";
			break;

		case 3:
			echo '<input name="btnAddCategory" type="button" id="btnAddCategory" value="Add a NEW Campaign" class="btnSubmit" onClick="addCategory('.$catParentId.')">';
			echo '&nbsp;&nbsp;';
			echo "<button onClick=\"window.location='index.php';\" class=\"btnSubmit\" id=\"btnCancel\">Cancel</button>";
			break;

		case 4:
			echo '<input name="btnAddCategory" type="button" id="btnAddCategory" value="Add a NEW Campaign" class="btnSubmit" onClick="addCategory('.$catParentId.')">';
			echo '&nbsp;&nbsp;';
			echo "<button onClick=\"window.location='index.php';\" class=\"btnSubmit\" id=\"btnCancel\">Cancel</button>";
			break;

		default:
			echo "<input type=\"button\" onClick=\"document.location.href='../index.php';\" class=\"btnSubmit\" id=\"btnCancel\" value=\"Back to Main\">";
	}
	?>
	</td>
</tr>
</table>
<p>&nbsp;</p>
</form>