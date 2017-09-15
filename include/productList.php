<?php
if (!defined('WEB_ROOT')) {
	exit;
}

if (isset($_GET['c']) && $_GET['c'] > 0) {
	$categoryId = $_GET['c'];
} 

else {
	// redirect to index.php if product id is not present
	header('Location: index.php');
}

switch ($categoryId)
{
	case 1:
		$productsPerRow = 1;
		break;

	case 2:
		$productsPerRow = 3;
		break;

	case 3:
		$productsPerRow = 7;
		break;
}

$productsPerPage = 10;

//$productList    = getProductList($catId);
$children		= array_merge(array($catId), getChildCategories(NULL, $catId));
$children		= ' (' . implode(', ', $children) . ')';

/*
$sql = "SELECT pd_id, pd_name, pd_price, pd_thumbnail, pd_qty, c.cat_id
		FROM tbl_product pd, tbl_category c
		WHERE pd.cat_id = c.cat_id AND pd.cat_id IN $children 
		ORDER BY pd_name";
*/

$sql = "SELECT pd.*, c.cat_id
		FROM tbl_product pd, tbl_category c
		WHERE pd.cat_id = c.cat_id AND pd.cat_id IN $children 
		ORDER BY pd_name";

$result     = dbQuery(getPagingQuery($sql, $productsPerPage));
$pagingLink = getPagingLink($sql, $productsPerPage, "c=$catId");
$numProduct = dbNumRows($result);

// the product images are arranged in a table. to make sure
// each image gets equal space set the cell width here
$columnWidth = (int)(100 / $productsPerRow);
?>
<table width="100%" border="0" cellspacing="0" cellpadding="5">
<?php 
if ($numProduct > 0 ) 
{
	$i = 0;
	while ($row = dbFetchAssoc($result)) 
	{
		extract($row);
		if ($pd_thumbnail) {
			$pd_thumbnail = WEB_ROOT . 'images/product/' . $pd_thumbnail;
		} 
		
		else {
			$pd_thumbnail = WEB_ROOT . 'images/no-image-small.png';
		}
	
		if ($i % $productsPerRow == 0) {
			echo '<tr>';
		}

		// format how we display the price
		//$pd_price = displayAmount($pd_price);
		
		//echo "<td width=\"$columnWidth%\" align=\"center\"><a href=\"" . $_SERVER['PHP_SELF'] . "?c=$catId&p=$pd_id" . "\"><img src=\"$pd_thumbnail\" border=\"0\"><br>$pd_name</a><br>Price : $pd_price";

		echo "<td width=\"$columnWidth%\" align=\"center\"><a href=\"" . $_SERVER['PHP_SELF'] . "?c=$catId&p=$pd_id" . "\"><img src=\"$pd_thumbnail\" border=\"0\">";

		// if the product is no longer in stock, tell the customer
		//if ($pd_qty <= 0) { echo "<br>Out Of Stock"; }
		
		echo "</td>\r\n";
	
		if ($i % $productsPerRow == $productsPerRow - 1) {
			echo '</tr>';
		}
		
		$i += 1;
	}
	
	if ($i % $productsPerRow > 0) {
		echo '<td colspan="' . ($productsPerRow - ($i % $productsPerRow)) . '">&nbsp;</td>';
	}
	
} 
else {
	echo '<tr><td width="100%" align="center" valign="center">No Webs in this campaign</td></tr>';
}	
?>
</table>
<p align="center"><?php echo $pagingLink; ?></p>