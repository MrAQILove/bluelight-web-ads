<?php
if (!defined('WEB_ROOT')) {
	exit;
}

function addtionalCoOrdinator($nameISCalled, $emailISCalled, $branchId)
{
	$strSQL2 = "SELECT ac.additional_contacts_id, ac.additional_contacts_title, ac.additional_contacts_first_name, ac.additional_contacts_last_name, ac.additional_contacts_email
				FROM tbl_contacts c
				INNER JOIN tbl_additional_contacts ac ON c.contacts_branch_id = ac.additional_contacts_branch_id
				WHERE contacts_branch_id = '$branchId'
				ORDER BY contacts_id";

	$result2		= dbQuery($strSQL2) or die( $strSQL2."<br /><br />". mysql_error());
	$numAds2		= dbNumRows($result2);

	if ($numAds2) 
	{
		$i = 1;
		$j = 1;
		while ($row = dbFetchAssoc($result2)) 
		{
			extract($row);

			if ($nameISCalled) 
			{
				echo '
					<tr> 
						<td class="label">Addional Contact Name ' .$i.':</td>
						<td class="content">
							<table border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td>
								<input type="hidden" name="hidadditional_contacts_id' .$i.'" id="hidadditional_contacts_id' .$i.'" value="'.$additional_contacts_id.'">
								<input name="txtadditional_contacts_title' .$i.'" type="text" class="box" id="txtadditional_contacts_title' .$i.'" value="'.$additional_contacts_title.'" size="15" maxlength="15">
								</td>
								<td>&nbsp;</td>
								<td><input name="txtadditional_contacts_first_name' .$i.'" type="text" class="box" id="txtadditional_contacts_first_name' .$i.'" value="'.$additional_contacts_first_name.'" size="25" maxlength="25"></td>
								<td>&nbsp;</td>
								<td><input name="txtadditional_contacts_last_name' .$i.'" type="text" class="box" id="txtadditional_contacts_last_name' .$i.'" value="'.$additional_contacts_last_name.'" size="25" maxlength="25"></td>
							</tr>
							</table>
						</td>
					</tr>';
			}

			if ($emailISCalled) {
				if (!empty($additional_contacts_email)) {
					echo '
					<tr> 
						<td class="label">Addional Contact Email Address ' .$j.':</td>
						<td class="content"><input name="txtadditional_contacts_email' .$j.'" type="text" class="box" id="txtadditional_contacts_email' .$j.'" value="'.$additional_contacts_email.'" size="50" maxlength="50"></td>
					</tr>
					'."\n";
				}
			}
		
			$i += 1;
			$j += 1;
		}
	}					
}

if (isset($_GET['contactId']) && (int)$_GET['contactId'] > 0) {
	$contactId = (int)$_GET['contactId'];
} 

else {
	$contactId = 0;
}

$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;';

$sql = "SELECT *
		FROM tbl_contacts c
		INNER JOIN tbl_state s ON c.state_id = s.state_id
		INNER JOIN tbl_branch b ON b.contacts_id = c.contacts_id
		WHERE c.contacts_id = '$contactId'";

$result = mysql_query($sql) or die('Cannot get Contact Details. ' . mysql_error());

$row = mysql_fetch_assoc($result);
extract($row);
?> 
<p class="errorMessage"><?php echo $errorMessage; ?></p>
<form action="processContactDetails.php?action=modify" method="post" enctype="multipart/form-data" name="frmModifyContactDetails" id="frmModifyContactDetails">
<table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="entryTable">
<?php
if (!empty($additional_contacts))
{
	echo '<input type="hidden" name="hidcontacts_branch_id" id="hidcontacts_branch_id" value="'.$contacts_branch_id.'">'."\n";
	echo '<input type="hidden" name="hidadditional_contacts" id="hidadditional_contacts" value="'.$additional_contacts.'">'."\n";
}

else {
	echo '<input type="hidden" name="hidcontacts_branch_id" id="hidcontacts_branch_id" value="0">'."\n";
	echo '<input type="hidden" name="hidadditional_contacts" id="hidadditional_contacts" value="0">'."\n";
}
?>
<tr> 
	<td class="label">Contact ID:</td>
	<td class="content">
	<input name="hidcontacts_id" type="hidden" id="hidcontacts_id" value="<?php echo $contacts_id; ?>">
	<?php echo $contacts_id; ?></td>
</tr>

<tr> 
	<td class="label">Contact Name:</td>
	<td class="content">
		<table border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td><input name="txtcontacts_title" type="text" class="box" id="txtcontacts_title" value="<?php echo $contacts_title; ?>" size="15" maxlength="15"></td>
			<td>&nbsp;</td>
			<td><input name="txtcontacts_first_name" type="text" class="box" id="txtcontacts_first_name" value="<?php echo $contacts_first_name; ?>" size="25" maxlength="25"></td>
			<td>&nbsp;</td>
			<td><input name="txtcontacts_last_name" type="text" class="box" id="txtcontacts_last_name" value="<?php echo $contacts_last_name; ?>" size="25" maxlength="25"></td>
		</tr>
		</table>
	</td>
</tr>

<?php
if ($additional_contacts == "1") {
	addtionalCoOrdinator("1", "0", $branch_id);
}
?>

<tr> 
	<td class="label">Office Address:</td>
	<td class="content">
		<table border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td colspan="5"><input name="txtcontacts_address1" type="text" class="box" id="txtcontacts_address1" value="<?php echo $contacts_address1; ?>" size="50" maxlength="50"></td>
		</tr>

		<tr>
			<td colspan="5"><input name="txtcontacts_address2" type="text" class="box" id="txtcontacts_address2" value="<?php echo $contacts_address2; ?>" size="50" maxlength="50"></td>
		</tr>

		<tr>
			<td><input name="txtcontacts_suburb" type="text" class="box" id="txtcontacts_suburb" value="<?php echo $contacts_suburb; ?>" size="25" maxlength="25"></td>
			<td>&nbsp;</td>
			<td>
			<div class="styled-select1">
				<?php

				$sql = "SELECT * 
						FROM tbl_state";

				$result = dbQuery($sql);

				if (dbNumRows($result) > 0) 
				{
					echo '<select name="txtcontacts_state_id">';
					while($row = dbFetchAssoc($result)) 
					{
						//extract($row);
						$options = "<option value=".$row['state_id'];
						if ($state_id == $row['state_id']) {
							$options.= " selected";
						}
						
						$options .= ">".$row['state_abbr']."</option>\r\n";

						echo $options;
					}
					
					echo '</select>';
				}
				?>
			</div>
			</td>
			<td>&nbsp;</td>
			<td><input name="txtcontacts_postal_code" type="text" class="box" id="txtcontacts_postal_code" value="<?php echo $contacts_postal_code; ?>" size="5" maxlength="5"></td>
		</tr>
		</table>
	</td>
</tr>

<?php
// List if Postal Address is given
if (!empty($contacts_postal_address1)) 
{
?>
	<tr> 
		<td class="label">Postal Address:</td>
		<td class="content">
			<table border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td colspan="5"><input name="txtcontacts_postal_address1" type="text" class="box" id="txtcontacts_postal_address1" value="<?php echo $contacts_postal_address1; ?>" size="50" maxlength="50"></td>
			</tr>

			<tr>
				<td colspan="5"><input name="txtcontacts_postal_address2" type="text" class="box" id="txtcontacts_postal_address2" value="<?php echo $contacts_postal_address2; ?>" size="50" maxlength="50"></td>
			</tr>

			<tr>
				<td><input name="txtcontacts_postal_suburb" type="text" class="box" id="txtcontacts_postal_suburb" value="<?php echo $contacts_postal_suburb; ?>" size="25" maxlength="25"></td>
				<td>&nbsp;</td>
				<td>
				<div class="styled-select1">
					<?php

					$sql = "SELECT * 
							FROM tbl_state";

					$result = dbQuery($sql);

					if (dbNumRows($result) > 0) 
					{
						echo '<select name="txtcontacts_postal_state_id">';
						while($row = dbFetchAssoc($result)) 
						{
							//extract($row);
							$options = "<option value=".$row['state_id'];
							if ($contacts_postal_state_id == $row['state_id']) {
								$options.= " selected";
							}
							
							$options .= ">".$row['state_abbr']."</option>\r\n";

							echo $options;
						}
						
						echo '</select>';
					}
					?>
				</div>
				</td>
				<td>&nbsp;</td>
				<td><input name="txtcontacts_postal_code1" type="text" class="box" id="txtcontacts_postal_code1" value="<?php echo $contacts_postal_code1; ?>" size="5" maxlength="5"></td>
			</tr>
			</table>
		</td>
	</tr>
<?php
}

else
{
?>
	<tr> 
		<td class="label">Postal Address:</td>
		<td class="content">
			<table border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td colspan="5"><input name="txtcontacts_postal_address1" type="text" class="box" id="txtcontacts_postal_address1" value="" size="50" maxlength="50"></td>
			</tr>

			<tr>
				<td colspan="5"><input name="txtcontacts_postal_address2" type="text" class="box" id="txtcontacts_postal_address2" value="" size="50" maxlength="50"></td>
			</tr>

			<tr>
				<td><input name="txtcontacts_postal_suburb" type="text" class="box" id="txtcontacts_postal_suburb" value="" size="25" maxlength="25"></td>
				<td>&nbsp;</td>
				<td>
				<div class="styled-select1">
					<?php

					$sql = "SELECT * 
							FROM tbl_state";

					$result = dbQuery($sql);

					if (dbNumRows($result) > 0) 
					{
						echo '<select name="txtcontacts_postal_state_id">'."\n";
						echo "<option value=''>-- Choose a State --</option>\n";
						while($row = dbFetchAssoc($result)) 
						{
							//extract($row);
							$options = "<option value=".$row['state_id'];
							if ($contacts_postal_state_id == $row['state_id']) {
								$options.= " selected";
							}
							
							$options .= ">".$row['state_abbr']."</option>\r\n";

							echo $options;
						}
						
						echo '</select>';
					}
					?>
				</div>
				</td>
				<td>&nbsp;</td>
				<td><input name="txtcontacts_postal_code1" type="text" class="box" id="txtcontacts_postal_code1" value="" size="5" maxlength="5"></td>
			</tr>
			</table>
		</td>
	</tr>
<?php
}
?>

<tr> 
	<td class="label">Phone No:</td>
	<td class="content"><input name="txtcontacts_phone" type="text" class="box" id="txtcontacts_phone" value="<?php echo $contacts_phone; ?>" size="15" maxlength="15"></td>
</tr>

<tr> 
	<td class="label">Fax No:</td>
	<td class="content"><input name="txtcontacts_fax" type="text" class="box" id="txtcontacts_fax" value="<?php echo $contacts_fax; ?>" size="15" maxlength="15"></td>
</tr>

<tr> 
	<td class="label">Email Address:</td>
	<td class="content"><input name="txtcontacts_email" type="text" class="box" id="txtcontacts_email" value="<?php echo $contacts_email; ?>" size="50" maxlength="50"></td>
</tr>

<?php
if ($additional_contacts == "1") {
	addtionalCoOrdinator("0", "1", $branch_id);
}
?>
</table>

<table border="0">
<tr><td>&nbsp;</td></tr>

<tr>
	<td> 
	<input name="btnModifyContactDetails" type="button" id="btnModify" value="Save Modification" onClick="checkModifyContactDetailsForm();" class="btnSubmit">&nbsp;&nbsp;
	<input name="btnCancel" type="button" id="btnCancel" value="Cancel" onClick="window.location.href='index.php';" class="btnSubmit">  
	</td>
</tr>
</table>
</form>