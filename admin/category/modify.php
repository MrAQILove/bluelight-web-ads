<?php
if (!defined('WEB_ROOT')) {
	exit;
}

// make sure a category id exists
if (isset($_GET['catId']) && (int)$_GET['catId'] > 0) {
	$catId = (int)$_GET['catId'];
} 

else {
	header('Location:index.php');
}	
	
$sql = "SELECT *
		FROM tbl_category
		WHERE cat_id = $catId";

$result = dbQuery($sql);
$row = dbFetchAssoc($result);
extract($row);

?>
<p>&nbsp;</p>
<form action="processCategory.php?action=modify&catId=<?php echo $catId; ?>" method="post" enctype="multipart/form-data" name="frmCategory" id="frmCategory">
<table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="entryTable">
<tr> 
	<td width="150" class="label">Campaign ID:</td>
	<td class="content"><b><?php echo $catId; ?></b></td>
</tr>

<tr> 
	<td width="150" class="label">Campaign Name:</td>
	<td class="content"><input name="txtName" type="text" class="box" id="txtName" value="<?php echo $cat_name; ?>" size="30" maxlength="50"></td>
</tr>

<tr> 
	<td width="150" class="label">Campaign Description:</td>
	<td class="content"> <textarea name="mtxDescription" cols="50" rows="4" class="box" id="mtxDescription"><?php echo $cat_description; ?></textarea></td>
</tr>

<tr> 
	<td width="150" class="label">Campaign Image:</td>
	<td class="content"> 
    <input name="fleImage" type="file" id="fleImage" class="box">
	<?php
		if ($cat_image != '') {
	?>
			<br /><br />
			<img src="<?php echo WEB_ROOT . CATEGORY_IMAGE_DIR . $cat_image; ?>"><br /><br />
			<a href="javascript:deleteImage(<?php echo $cat_id; ?>);">Delete this Image?</a> 
    <?php
		}
	?>
	</td>
</tr>

<tr> 
	<td width="200" class="label">Is the Campaign currently Active ?</td>
	<td class="content">
	<div class="styled-select">
		<select name="txtActive">
		<?php
			if ($cat_active == '1') {
				$answer = "YES";
			}

			else {
				$answer = "NO";
			}

			$options = "<option value=\"$cat_active\" selected>".$answer; 
			echo $options . '</option>'. "\n";
			echo '<option value="0">NO</option>'. "\n";
			echo '</select>'. "\n";
		?>
	</div>
	</td>
</tr>
</table>

<table border="0">
<tr><td>&nbsp;</td></tr>

<tr>
	<td> 
	<input name="btnModify" type="button" id="btnModify" value="Save Modification" onClick="checkCategoryForm();" class="btnSubmit">&nbsp;&nbsp;
	<input name="btnCancel" type="button" id="btnCancel" value="Cancel" onClick="window.location.href='index.php';" class="btnSubmit">  
	</td>
</tr>
</table>
</form>