<?php
if (!defined('WEB_ROOT')) {
	exit;
}

function addtionalCoOrdinator($nameISCalled, $emailISCalled, $branchId)
{
	$strSQL2 = "SELECT *
				FROM tbl_contacts c
				LEFT JOIN tbl_additional_contacts ac ON c.contacts_branch_id = ac.additional_contacts_branch_id
				WHERE c.contacts_branch_id = '$branchId'
				ORDER BY c.contacts_id";

	$result2		= dbQuery($strSQL2) or die( $strSQL2."<br /><br />". mysql_error());
	$numAds2		= dbNumRows($result2);

	if ($numAds2) 
	{
		while ($row = dbFetchAssoc($result2)) 
		{
			extract($row);

			if ($nameISCalled) {
				echo $additional_contacts_title.'&nbsp;'.$additional_contacts_first_name.'&nbsp;'.$additional_contacts_last_name.'<br/>'."\n";
			}

			if ($emailISCalled) {
				if (!empty($additional_contacts_email)) {
					echo '<span class="white_contact">E: </span><span class="red_contact"><a href="mailto:'.$additional_contacts_email.'">'.$additional_contacts_email.'</a></span><br />'."\n";
				}
			}
		}
	}					
}

if (isset($_GET['stateId']) && (int)$_GET['stateId'] > 0) {
	$stateId = (int)$_GET['stateId'];
	$strSQL2 = " AND b.state_id = '$stateId'";
} 

else {
	$state_id = 0;
	$strSQL2  = '';
}

$strSQL = "SELECT *
		FROM tbl_branch b 
		INNER JOIN tbl_state s ON b.state_id = s.state_id
		INNER JOIN tbl_contacts c ON b.contacts_id = c.contacts_id
		WHERE b.branch_active='1'
		$strSQL2
		ORDER BY b.branch_name ASC";

$result = dbQuery($strSQL) or die( $strSQL."<br /><br />". mysql_error());

?> 
<p>&nbsp;</p>
<form action="processContactDetails.php?action=addContactDetails()" method="post" name="frmListContactDetails" id="frmListContactDetails">
<table width="100%" border="0" align="center" cellpadding="2" cellspacing="1" class="text">
	<tr align="center" id="listTableHeader"> 
		<td>Branch Name</td>
		<td>State</td>
		<td>Branch Details</td>
		<td width="70">Modify</td>
		<td width="70">Delete</td>
	</tr>
<?php
	while($row = dbFetchAssoc($result)) {
		extract($row);
	
	if ($i%2) {
		$class = 'row1';
	} 
	
	else {
		$class = 'row2';
	}
	
	$i += 1;
?>
	<tr class="<?php echo $class; ?>"> 
		<td align="center"><?php echo $branch_name; ?></td>
		<td align="center"><?php echo $state_abbr; ?></td>
		<td>
		<?php
		echo '<span class="white_contact">Blue Light Co-Ordinator:</span><br/>'."\n";
		if ($additional_contacts) 
		{
			echo $contacts_title.'&nbsp;'.$contacts_first_name.'&nbsp;'.$contacts_last_name.'<br/>'."\n";
			addtionalCoOrdinator("1", "0", $branch_id);
			echo '<br />'."\n";
		}

		else {
			echo $contacts_title.'&nbsp;'.$contacts_first_name.'&nbsp;'.$contacts_last_name.'<br/><br />'."\n";
		}

		echo '<span class="white_contact">Office Address:</span><br />'."\n";
		switch ($state_abbr)
		{
			case "NT";
				echo $contacts_address1.' <br />'."\n";
				echo $contacts_address2.' <br />'."\n";
				echo $contacts_suburb.',&nbsp;'.$state_abbr.'&nbsp;'.$contacts_postal_code.'<br /><br />'."\n";

				if (!empty($contacts_phone)) {
					echo '<span class="white_contact">Telephone:</span> '.$contacts_phone.'<br />'."\n";
				}

				if (!empty($contacts_fax)) {
					echo '<span class="white_contact">Fax:</span> '.$contacts_fax.'<br />'."\n";
				}

				if (!empty($contacts_email)) {
					echo '<span class="white_contact">E-mail: </span><span class="red_contact"><a href="mailto:'.$contacts_email.'">'.$contacts_email.'</a></span><br />'."\n";
				}
				
				break;

			case "WA";
				echo $contacts_address1.' <br />'."\n";
				echo $contacts_address2.' <br />'."\n";
				echo $contacts_suburb.',&nbsp;'.$state_abbr.'&nbsp;'.$contacts_postal_code.'<br /><br />'."\n";

				if (!empty($contacts_phone)) {
					echo '<span class="white_contact">P:</span> '.$contacts_phone.'<br />'."\n";
				}

				if ($additional_contacts) 
				{
					if (!empty($contacts_fax)) {
						echo '<span class="white_contact">F:</span> '.$contacts_fax.'<br /><br />'."\n";
					}

					if (!empty($contacts_email)) {
						echo '<span class="white_contact">E: </span><span class="red_contact"><a href="mailto:'.$contacts_email.'">'.$contacts_email.'</a></span><br />'."\n";
					}
					
					addtionalCoOrdinator("0", "1", $branch_id);
				}

				else
				{
					if (!empty($contacts_fax)) {
						echo '<span class="white_contact">F:</span> '.$contacts_fax.'<br />'."\n";
					}

					if (!empty($contacts_email)) {
						echo '<span class="white_contact">E: </span><span class="red_contact"><a href="mailto:'.$contacts_email.'">'.$contacts_email.'</a></span><br />'."\n";
					}
				}
				
				break;
			}
			?>
		</td>
		<td width="120" align="center"><a href="javascript:modifyContactDetails(<?php echo $contacts_id; ?>);">Modify</a></td>
		<td width="70" align="center"><a href="javascript:deleteContactDetails(<?php echo $contacts_id; ?>);">Delete</a></td>
	</tr>
<?php
} // end while

?>
	<tr> 
		<td colspan="6">&nbsp;</td>
	</tr>
	
	<tr> 
		<td colspan="6" align="right"><input name="btnAddContactDetails" type="button" id="btnAddContactDetails" value="Add Contact Details" class="btnSubmit" onClick="addContactDetails()"></td>
	</tr>
	</table>
 <p>&nbsp;</p>
</form>