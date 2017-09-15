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

$sql = "SELECT *
        FROM tbl_product pd, tbl_category cat, tbl_location loc
		WHERE pd.pd_id = $productId
		AND pd_location_id = location_id
		AND pd.cat_id = cat.cat_id";
$result = mysql_query($sql) or die('Cannot get product. ' . mysql_error());

$row = mysql_fetch_assoc($result);
extract($row);

if ($pd_image) {
	$pd_image = WEB_ROOT . 'images/product/' . $pd_image;
} 

else {
	$pd_image = WEB_ROOT . 'images/no-image-large.png';
}

?>
<p>&nbsp;</p>
<form action="processProduct.php?action=addProduct" method="post" enctype="multipart/form-data" name="frmAddProduct" id="frmAddProduct">
<table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="entryTable">
<tr> 
	<td class="label">Web Ad ID:</td>
	<td class="content"><?php echo $pd_id; ?></td>
</tr>
<tr> 
	<td class="label">Type:</td>
	<td class="content">
	<?php 
	switch ($cat_parent_id)
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
		echo "Listing";
		break;
	}
	?>
	</td>
</tr>

<tr> 
	<td class="label">Campaign (Web Ad Duration):</td>
	<td class="content"><?php echo $cat_name; ?></td>
</tr>

<tr> 
	<td class="label">Booking No.:</td>
	<td class="content"> <?php echo $pd_booking_no; ?></td>
</tr>

<tr> 
	<td class="label">Client:</td>
	<td class="content"> <?php echo $pd_name; ?></td>
</tr>

<tr> 
	<td class="label">Link:</td>
	<td class="content">
	<?php 
	if (!empty($pd_link)) {
		echo '<a href="http://'.$pd_link.'" target="_new">'.$pd_link.'</a>'; 
	}
	else {
		echo '<No Web Address given>';
	}

	?>
	</td>
</tr>

<tr> 
	<td class="label">Website Location:</td>
	<td class="content"><?php echo $location_name; ?> </td>
</tr>

<?php 
if ($cat_parent_id == 4)
{
	echo '
		<tr> 
			<td class="label">Details:</td>
			<td class="content">'.$pd_description.'</td>
		</tr>
		';
}
else
{
	echo '
		<tr> 
			<td class="label">Artwork:</td>
			<td class="content"><img src="'.$pd_image.'"></td>
		</tr>
		';
}
?>
</table>

<table>
<tr><td colspan="2">&nbsp;</td></tr>

<tr>
	<td colspan="2">
	<?php
	switch ($cat_parent_id)
	{
		case 1:
		echo "<input name=\"btnModifyProduct\" type=\"button\" id=\"btnModifyProduct\" value=\"Modify Leaderboard Banner\" onClick=\"window.location.href='index.php?view=modify&productId=<?php echo $productId; ?>';\" class=\"btnSubmit\">";
		break;

		case 2:
		echo "Medium Rec Banner";
		break;

		case 3:
		echo "Skyscraper Banner";
		break;

		case 4:
		echo "Listing";
		break;
	}
	?>
	&nbsp;&nbsp;
	<input name="btnBack" type="button" id="btnBack" value=" Back " onClick="window.history.back();" class="btnSubmit">
	</td>
</tr>
</table>
</form>
<p align="center">&nbsp;</p>