<?php
if (!defined('WEB_ROOT')) {
	exit;
}

$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;';

@$state = $HTTP_GET_VARS['state'];
if(strlen($state) > 0 and !is_numeric($state))
{ 
	echo "Inavlid DATA.";
	exit;
}
?> 

<p class="errorMessage"><?php echo $errorMessage; ?></p>
<form action="processContactDetails.php?action=add" method="post" enctype="multipart/form-data" name="frmAddContactDetails" id="frmAddContactDetails">
<table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="entryTable">
<tr><td colspan="2" id="entryTableHeader">Add a new Contact Details</td></tr>
<tr> 
	<td width="150" class="label" valign="top">Blue Light Co-Ordinator:</td>
	<td class="content">
		<table border="0" cellpadding="0" cellspacing="0" width="100%">
		<tr>
		<td colspan="2">
			<div id="InputsWrapper">
				<table border="0" cellpadding="0" cellspacing="0" width="100%" id="ContactDetails">
				<tr>
					<td width="150">Name:</td>
					<td>
						<input id="txtcontacts_title_1" type="text" value="Title" name="txtcontacts_title_1" size="15" maxlength="15">
						<input id="txtcontacts_first_name_1" type="text" value="First Name" name="txtcontacts_first_name_1" size="25" maxlength="25">
						<input id="txtcontacts_last_name_1" type="text" value="Last Name" name="txtcontacts_last_name_1" size="25" maxlength="25">
						<!--<a class="removeclass" href="#">[×]</a>-->
					</td>
				</tr>
				</table>
			</div>
		</td>
		</tr>

		<tr><td colspan="2">&nbsp;</td></tr>
		
		<tr>
			<td width="150">&nbsp;</td>
			<td>
			<span style="color:red;">Do you want to Add another Blue Light Co-Ordinator?</span> <input id="chkCoOrdinator" type="radio" name="chkCoOrdinator" value="Y1" /> YES <input id="chkCoOrdinator" type="radio" name="chkCoOrdinator" value="N1" /> NO 
			<div id="toggleCoOrdinator" style='display:none;'>
				<a id="AddMoreFileBox" class="btn btn-info" href="#">Add Another Co-Ordinator</a>
			</div>
			</td>
		</tr>
		</table>
	</td>
</tr>

<tr> 
	<td width="150" class="label" valign="top">Office Address:</td>
	<td class="content">
		<table border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td width="150">Office Name:</td>
			<td><input type="text" name="txtcontacts_address1" id="txtcontacts_address1" size="50" maxlength="50" class="box"></td>
		</tr>

		<tr>
			<td width="150">Address:</td>
			<td><input type="text" name="txtcontacts_address2" id="txtcontacts_address2" size="50" maxlength="50" class="box"></td>
		</tr>

		<tr>
			<td width="150">Suburb:</td>
			<td><input type="text" name="txtcontacts_suburb" id="txtcontacts_suburb" size="25" maxlength="25" class="box"></td>
		</tr>

		<tr> 
			<td width="150">State:</td>
			<td>
			<div class="styled-select1">
			<?php
			//This fetches content from State table first to get the state list
		 
			$state_query = mysql_query("SELECT DISTINCT state_id, state_abbr FROM tbl_state ORDER BY state_abbr"); 
		 
			if(isset($state) and strlen($state) > 0)
			{ 
				// If the numeric value of "state" (selected state) is greater than zero we are OK
				// Then we will perform an SQL query to find all branch with that id number.

				$branch_query = mysql_query("SELECT DISTINCT branch_id, branch_name FROM tbl_branch WHERE state_id = $state AND branch_active = '1' ORDER BY branch_name"); 
			}
			
			else {
				$branch_query = mysql_query("SELECT DISTINCT branch_id, branch_name FROM tbl_branch WHERE branch_active = '1' ORDER BY branch_name"); 
			} 
		 
			echo "<select name='txtcontacts_state_id' onchange=\"reload(this.form)\">\n";
			echo "<option value=''>-- Choose a State --</option>\n";
		 
			while($qresult_state = mysql_fetch_array($state_query)) 
			{ 
				if($qresult_state['state_id'] == @$state){
					echo "<option selected value='$qresult_state[state_id]'>$qresult_state[state_abbr]</option>\n";
				}
				
				else {
					echo  "<option value='$qresult_state[state_id]'>$qresult_state[state_abbr]</option>\n";
				}
			}

			echo '</select>
			</div>
			</td>
		</tr>

		<tr> 
			<td width="150">Postcode:</td>
			<td> <input type="text" name="txtcontacts_postal_code" id="txtcontacts_postal_code" size="4" maxlength="4" class="box"></td>
		</tr>

		<tr> 
			<td width="150">Branch:</td>
			<td>
			<div class="styled-select1">
				<select name="txtcontacts_branch_id">
				<option value="">-- Choose Blue Light Branch --</option>'."\n";
		 
			while($qresult_branch = mysql_fetch_array($branch_query)) { 
				echo  "<option value='$qresult_branch[branch_id]'>$qresult_branch[branch_name]</option>\n";
			}
			
			echo "</select>";
			?>
			</div>
			</td>
		</tr>
		</table>
	</td>
</tr>

<tr> 
	<td width="150" class="label" valign="top">Postal Address:</td>
	<td class="content">
		<span style="color:red;">Do you have a Postal Address?</span> <input id="id_radio1" type="radio" name="chkPostalAddress" value="Y2" /> YES <input id="id_radio2" type="radio" name="chkPostalAddress" value="N2" /> NO
		<div id="togglePostalAddress" style='display:none;'>
			<table border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td width="150">Office Name:</td>
				<td><input type="text" name="txtcontacts_postal_address1" id="txtcontacts_postal_address1" size="50" maxlength="50" class="box"></td>
			</tr>

			<tr>
				<td width="150">Address:</td>
				<td><input type="text" name="txtcontacts_postal_address2" id="txtcontacts_postal_address2" size="50" maxlength="50" class="box"></td>
			</tr>

			<tr>
				<td width="150">Suburb:</td>
				<td><input type="text" name="txtcontacts_postal_suburb" id="txtcontacts_postal_suburb" size="25" maxlength="25" class="box"></td>
			</tr>

			<tr> 
				<td width="150">State:</td>
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
			</tr>

			<tr> 
				<td width="150">Postcode:</td>
				<td> <input type="text" name="txtcontacts_postal_code" id="txtcontacts_postal_code" size="4" maxlength="4" class="box"></td>
			</tr>
			</table>
		</div>
	</td>
</tr>

<tr> 
	<td width="150" class="label" valign="top">Phone No.:</td>
	<td class="content">
		<table border="0" cellpadding="0" cellspacing="0" width="100%">
		<tr>
		<td colspan="2">
			<div id="InputsWrapper_P">
				<table border="0" cellpadding="0" cellspacing="0" width="100%" id="ContactDetails_P">
				<tr>
					<td width="150">Phone No.:</td>
					<td>
						<input id="txtcontacts_phone_1" type="text" value="Phone No." name="txtcontacts_phone_1" size="15" maxlength="15">
						<!--<a class="removeclass" href="#">[×]</a>-->
					</td>
				</tr>
				</table>
			</div>
		</td>
		</tr>

		<tr><td colspan="2">&nbsp;</td></tr>
		
		<tr>
			<td width="150">&nbsp;</td>
			<td>
			<span style="color:red;">Do you want to Add another Phone No.?</span> <input id="chkPhoneNo" type="radio" name="chkPhoneNo" value="Y3" /> YES <input id="chkPhoneNo" type="radio" name="chkPhoneNo" value="N3" /> NO 
			<div id="togglePhoneNo" style='display:none;'>
				<a id="AddMoreFileBox_P" class="btn btn-info" href="#">Add Another Phone No.</a>
			</div>
			</td>
		</tr>
		</table>
	</td>
</tr>

<tr> 
	<td width="150" class="label" valign="top">Fax No.:</td>
	<td class="content">
		<table border="0" cellpadding="0" cellspacing="0" width="100%">
		<tr>
		<td colspan="2">
			<div id="InputsWrapper_F">
				<table border="0" cellpadding="0" cellspacing="0" width="100%" id="ContactDetails_F">
				<tr>
					<td width="150">Fax No.:</td>
					<td>
						<input id="txtcontacts_fax_1" type="text" value="Fax No." name="txtcontacts_fax_1" size="15" maxlength="15">
						<!--<a class="removeclass" href="#">[×]</a>-->
					</td>
				</tr>
				</table>
			</div>
		</td>
		</tr>

		<tr><td colspan="2">&nbsp;</td></tr>
		
		<tr>
			<td width="150">&nbsp;</td>
			<td>
			<span style="color:red;">Do you want to Add another Fax No.?</span> <input id="chkFaxNo" type="radio" name="chkFaxNo" value="Y4" /> YES <input id="chkFaxNo" type="radio" name="chkFaxNo" value="N4" /> NO 
			<div id="toggleFaxNo" style='display:none;'>
				<a id="AddMoreFileBox_F" class="btn btn-info" href="#">Add Another Fax No.</a>
			</div>
			</td>
		</tr>
		</table>
	</td>
</tr>

<tr> 
	<td width="150" class="label" valign="top">Email Address:</td>
	<td class="content">
		<table border="0" cellpadding="0" cellspacing="0" width="100%">
		<tr>
		<td colspan="2">
			<div id="InputsWrapper_E">
				<table border="0" cellpadding="0" cellspacing="0" width="100%" id="ContactDetails_E">
				<tr>
					<td width="150">Email Address:</td>
					<td>
						<input id="txtcontacts_email_1" type="text" value="Email Address" name="txtcontacts_email_1" size="50" maxlength="50">
						<!--<a class="removeclass" href="#">[×]</a>-->
					</td>
				</tr>
				</table>
			</div>
		</td>
		</tr>

		<tr><td colspan="2">&nbsp;</td></tr>
		
		<tr>
			<td width="150">&nbsp;</td>
			<td>
			<span style="color:red;">Do you want to Add another Email Address?</span> <input id="chkEmailAddress" type="radio" name="chkEmailAddress" value="Y5" /> YES <input id="chkEmailAddress" type="radio" name="chkEmailAddress" value="N5" /> NO 
			<div id="toggleEmailAddress" style='display:none;'>
				<a id="AddMoreFileBox_E" class="btn btn-info" href="#">Add Another Email Address</a>
			</div>
			</td>
		</tr>
		</table>
	</td>
</tr>
</table>

<table>
<tr><td colspan="2">&nbsp;</td></tr>

<tr>
	<td colspan="2">
	<div class="buttons">
		<input name="btnAddContactDetails" type="button" id="btnAddContactDetails" value="Add Contact Details" onClick="checkContactDetailsForm();" class="btnSubmit">&nbsp;&nbsp;
		<input name="btnCancel" type="button" id="btnCancel" value="Cancel" onClick="window.location.href='index.php';" class="btnSubmit"> 
	</div>
	</td>
</tr>
</table>
</form>
<p>&nbsp;</p>