<?php
require_once '../../library/config.php';
require_once '../library/functions.php';

checkUser();

$action = isset($_GET['action']) ? $_GET['action'] : '';

switch ($action) {
	
	case 'add' :
		addContactDetails();
		break;
		
	case 'modify' :
		modifyContactDetails();
		break;
		
	case 'delete' :
		deleteContactDetails();
		break;
    

	default :
	    // if action is not defined or unknown
		// move to main user page
		header('Location: index.php');
}


function addContactDetails()
{
	$t_contacts_title_1			= $_POST['txtcontacts_title_1'];
	$t_contacts_first_name_1	= $_POST['txtcontacts_first_name_1'];
	$t_contacts_last_name_1		= $_POST['txtcontacts_last_name_1'];

	if ($_POST['chkCoOrdinator'] == "Y1")
	{
		$t_contacts_title_2			= $_POST['txtcontacts_title_2'];
		$t_contacts_first_name_2	= $_POST['txtcontacts_first_name_2'];
		$t_contacts_last_name_2		= $_POST['txtcontacts_last_name_2'];

		$t_contacts_title_3			= $_POST['txtcontacts_title_3'];
		$t_contacts_first_name_3	= $_POST['txtcontacts_first_name_3'];
		$t_contacts_last_name_3		= $_POST['txtcontacts_last_name_3'];

		$t_contacts_title_4			= $_POST['txtcontacts_title_4'];
		$t_contacts_first_name_4	= $_POST['txtcontacts_first_name_4'];
		$t_contacts_last_name_4		= $_POST['txtcontacts_last_name_4'];
	}

	$t_contacts_address1		= $_POST['txtcontacts_address1'];
	$t_contacts_address2		= $_POST['txtcontacts_address2'];
	$t_contacts_suburb			= $_POST['txtcontacts_suburb'];
	$t_contacts_state_id		= $_POST['txtcontacts_state_id'];
	$t_contacts_postal_code		= $_POST['txtcontacts_postal_code'];
	$t_contacts_branch_id		= $_POST['txtcontacts_branch_id'];

	if ($_POST['chkPostalAddress'] == "Y2")
	{
		$t_contacts_postal_address1			= $_POST['txtcontacts_postal_address1'];
		$t_contacts_postal_address2			= $_POST['txtcontacts_postal_address2'];
		$t_contacts_postal_suburb			= $_POST['txtcontacts_postal_suburb'];
		$t_contacts_postal_state_id			= $_POST['txtcontacts_postal_state_id'];
		$t_contacts_postal_code1			= $_POST['txtcontacts_postal_code1'];
	}

	else
	{
		$t_contacts_postal_address1			= NULL;
		$t_contacts_postal_address2			= NULL;
		$t_contacts_postal_suburb			= NULL;
		$t_contacts_postal_state_id			= NULL;
		$t_contacts_postal_code1			= NULL;
	}
		
	$t_contacts_phone_1			= $_POST['txtcontacts_phone_1'];
	
	if ($_POST['chkPhoneNo'] == "Y3") 
	{
		$t_contacts_phone_2		= $_POST['txtcontacts_phone_2'];
		$t_contacts_phone_3		= $_POST['txtcontacts_phone_3'];
	}
	
	$t_contacts_fax_1			= $_POST['txtcontacts_fax_1'];
	
	if ($_POST['chkFaxNo'] == "Y4") 
	{
		$t_contacts_fax_2		= $_POST['txtcontacts_fax_2'];
		$t_contacts_fax_3		= $_POST['txtcontacts_fax_3'];
	}
	
	$t_contacts_email_1			= $_POST['txtcontacts_email_1'];

	if ($_POST['chkEmailAddress'] == "Y5") 
	{
		$t_contacts_email_2		= $_POST['txtcontacts_email_2'];
		$t_contacts_email_3		= $_POST['txtcontacts_email_3'];
	}
	
	// check if the Contact Name is taken
	$strSQL = "SELECT contacts_first_name, contacts_last_name
	        FROM tbl_contacts
			WHERE contacts_first_name = '$t_contacts_first_name_1'
			AND contacts_last_name = '$t_contacts_last_name_1'";

	$result = dbQuery($strSQL) or die( $strSQL."<br /><br />". mysql_error());
	
	if (dbNumRows($result) == 1) {
		header('Location: index.php?view=add&error=' . urlencode('Contact Name already taken. Choose another one'));	
	} 
	
	else 
	{			
		$strSQL   = "INSERT INTO tbl_contacts 
					(
						contacts_title, 
						contacts_first_name, 
						contacts_last_name, 
						contacts_address1, 
						contacts_address2, 
						contacts_suburb, 
						state_id, 
						contacts_postal_code, 
						contacts_postal_address1, 
						contacts_postal_address2, 
						contacts_postal_suburb, 
						contacts_postal_state_id, 
						contacts_postal_code1, 
						contacts_phone, 
						contacts_fax, 
						contacts_email, 
						contacts_branch_id, 
						additional_contacts
					)
					VALUES 
					(
						'$t_contacts_title_1', 
						'$t_contacts_first_name_1',
						'$t_contacts_last_name_1',
						'$t_contacts_address1',
						'$t_contacts_address2',
						'$t_contacts_suburb',
						'$t_contacts_state_id',
						'$t_contacts_postal_code',
						'$t_contacts_postal_address1',
						'$t_contacts_postal_address2',
						'$t_contacts_postal_suburb',
						'$t_contacts_postal_state_id',
						'$t_contacts_postal_code1',
						'$t_contacts_phone_1',
						'$t_contacts_fax_1',
						'$t_contacts_email_1',
						'$t_contacts_branch_id',
						'$t_additional_contacts
					)";
	
		mysql_query($strSQL);
		$contacts_id = mysql_insert_id();
		
		if(isset($t_additional_contacts)) 
		{
			if ( (!empty($t_contacts_title_2) && (!empty($t_contacts_title_3) && (!empty($t_contacts_title_4) )
			{
				$multi = array	(
									array(
										'contacts_id' => 'contacts_id' ,
										'additional_contacts_title' => '$t_contacts_title_2' ,
										'additional_contacts_first_name' => '$t_contacts_first_name_2',
										'additional_contacts_last_name' => '$t_contacts_last_name_2',
										'additional_contacts_branch_id' => '$t_contacts_branch_id',
										'additional_contacts_phone' => '$t_contacts_phone_2',
										'additional_contacts_fax' => '$t_contacts_fax_2',
										'additional_contacts_email' => '$t_contacts_email_2'
									),
									array(
										'contacts_id' => 'contacts_id' ,
										'additional_contacts_title' => '$t_contacts_title_3' ,
										'additional_contacts_first_name' => '$t_contacts_first_name_3',
										'additional_contacts_last_name' => '$t_contacts_last_name_3',
										'additional_contacts_branch_id' => '$t_contacts_branch_id',
										'additional_contacts_phone' => '$t_contacts_phone_3',
										'additional_contacts_fax' => '$t_contacts_fax_3',
										'additional_contacts_email' => '$t_contacts_email_3'
									),
									array(
										'contacts_id' => 'contacts_id' ,
										'additional_contacts_title' => '$t_contacts_title_4' ,
										'additional_contacts_first_name' => '$t_contacts_first_name_4',
										'additional_contacts_last_name' => '$t_contacts_last_name_4',
										'additional_contacts_branch_id' => '$t_contacts_branch_id',
										'additional_contacts_phone' => '$t_contacts_phone_4',
										'additional_contacts_fax' => '$t_contacts_fax_4',
										'additional_contacts_email' => '$t_contacts_email_4'
									)
								);
				$new = array();
				foreach($multi as $key=>$value) {
					$new[] = "'".implode("', '", $value)."'";
				}
				$query = "(".implode("), (", $new).")";
				
				$strSQL   = "INSERT INTO tbl_additional_contacts 
						(
						contacts_id,
						additional_contacts_title,
						additional_contacts_first_name,
						additional_contacts_last_name,
						additional_contacts_branch_id,
						additional_contacts_phone,
						additional_contacts_fax,
						additional_contacts_email
						)
						VALUES ($query)";

			//mysql_query($strSQL) or die( $strSQL."<br /><br />". mysql_error());
			echo $strSQL;
		}
		
		//dbQuery($strSQL) or die( $strSQL."<br /><br />". mysql_error());
		header('Location: index.php');	
	}
}

/*
	Modify a Contact Details
*/
function modifyContactDetails()
{
	$h_contacts_id						= (int)$_POST['hidcontacts_id'];	
	$t_contacts_title					= $_POST['txtcontacts_title'];
	$t_contacts_first_name				= $_POST['txtcontacts_first_name'];
	$t_contacts_last_name				= $_POST['txtcontacts_last_name'];
	$t_contacts_address1				= $_POST['txtcontacts_address1'];
	$t_contacts_address2				= $_POST['txtcontacts_address2'];
	$t_contacts_suburb					= $_POST['txtcontacts_suburb'];
	$t_contacts_state_id				= $_POST['txtcontacts_state_id'];
	$t_contacts_postal_code				= $_POST['txtcontacts_postal_code'];

	if (!empty($_POST['txtcontacts_postal_address1']))
	{
		$t_contacts_postal_address1			= $_POST['txtcontacts_postal_address1'];
		$t_contacts_postal_address2			= $_POST['txtcontacts_postal_address2'];
		$t_contacts_postal_suburb			= $_POST['txtcontacts_postal_suburb'];
		$t_contacts_postal_state_id			= $_POST['txtcontacts_postal_state_id'];
		$t_contacts_postal_code1			= $_POST['txtcontacts_postal_code1'];
	}

	else
	{
		$t_contacts_postal_address1			= NULL;
		$t_contacts_postal_address2			= NULL;
		$t_contacts_postal_suburb			= NULL;
		$t_contacts_postal_state_id			= NULL;
		$t_contacts_postal_code1			= NULL;
	}

	$t_contacts_phone					= $_POST['txtcontacts_phone'];
	$t_contacts_fax						= $_POST['txtcontacts_fax'];
	$t_contacts_email					= $_POST['txtcontacts_email'];
	$h_contacts_branch_id				= $_POST['hidcontacts_branch_id'];
	$h_additional_contacts				= $_POST['hidadditional_contacts'];

	$h_additional_contacts_id1			= $_POST['hidadditional_contacts_id1'];
	$h_additional_contacts_id2			= $_POST['hidadditional_contacts_id2'];

	$t_additional_contacts_title1		= $_POST['txtadditional_contacts_title1'];
	$t_additional_contacts_first_name1	= $_POST['txtadditional_contacts_first_name1'];
	$t_additional_contacts_last_name1	= $_POST['txtadditional_contacts_last_name1']; 
	$t_additional_contacts_email1		= $_POST['txtadditional_contacts_email1'];

	$t_additional_contacts_title2		= $_POST['txtadditional_contacts_title2'];
	$t_additional_contacts_first_name2	= $_POST['txtadditional_contacts_first_name2'];
	$t_additional_contacts_last_name2	= $_POST['txtadditional_contacts_last_name2']; 
	$t_additional_contacts_email2		= $_POST['txtadditional_contacts_email2'];
	
	if (!empty ($h_additional_contacts))
	{
		$strSQL   = "UPDATE tbl_contacts C, tbl_additional_contacts AC
					  SET 
					  C.contacts_title = '$t_contacts_title',
					  C.contacts_first_name = '$t_contacts_first_name',
					  C.contacts_last_name = '$t_contacts_last_name',
					  C.contacts_address1 = '$t_contacts_address1',
					  C.contacts_address2 = '$t_contacts_address2',
					  C.contacts_suburb = '$t_contacts_suburb',
					  C.state_id = '$t_contacts_state_id',
					  C.contacts_postal_code = '$t_contacts_postal_code',		  
					  C.contacts_postal_address1 = '$t_contacts_postal_address1',
					  C.contacts_postal_address2 = '$t_contacts_postal_address2',
					  C.contacts_postal_suburb = '$t_contacts_postal_suburb',
					  C.contacts_postal_state_id = '$t_contacts_postal_state_id',
					  C.contacts_postal_code1 = '$t_contacts_postal_code1',
					  C.contacts_phone = '$t_contacts_phone',
					  C.contacts_fax = '$t_contacts_fax',
					  C.contacts_email = '$t_contacts_email',
					  C.contacts_branch_id = '$h_contacts_branch_id',
					  C.additional_contacts = '$h_additional_contacts',
					  
					  AC.additional_contacts_title = CASE AC.additional_contacts_id
							WHEN $h_additional_contacts_id1 THEN '$t_additional_contacts_title1'
							WHEN $h_additional_contacts_id2 THEN '$t_additional_contacts_title2'
						END,

						AC.additional_contacts_first_name = CASE AC.additional_contacts_id
							WHEN $h_additional_contacts_id1 THEN '$t_additional_contacts_first_name1'
							WHEN $h_additional_contacts_id2 THEN '$t_additional_contacts_first_name2'
						END,

						AC.additional_contacts_last_name = CASE AC.additional_contacts_id 
							WHEN $h_additional_contacts_id1 THEN '$t_additional_contacts_last_name1'
							WHEN $h_additional_contacts_id2 THEN '$t_additional_contacts_last_name2'
						END,

						AC.additional_contacts_email = CASE AC.additional_contacts_id 
							WHEN $h_additional_contacts_id1 THEN '$t_additional_contacts_email1'
							WHEN $h_additional_contacts_id2 THEN '$t_additional_contacts_email2'
						END

						WHERE 
							AC.additional_contacts_id IN ('$h_additional_contacts_id1', '$h_additional_contacts_id2')
					  AND C.contacts_branch_id = AC.additional_contacts_branch_id
					  AND C.contacts_id = $h_contacts_id";
	}


	else 
	{
		$strSQL   = "UPDATE tbl_contacts
					  SET 
					  contacts_title = '$t_contacts_title',
					  contacts_first_name = '$t_contacts_first_name',
					  contacts_last_name = '$t_contacts_last_name',
					  contacts_address1 = '$t_contacts_address1',
					  contacts_address2 = '$t_contacts_address2',
					  contacts_suburb = '$t_contacts_suburb',
					  state_id = '$t_contacts_state_id',
					  contacts_postal_code = '$t_contacts_postal_code',
					  contacts_postal_address1 = '$t_contacts_postal_address1',
					  contacts_postal_address2 = '$t_contacts_postal_address2',
					  contacts_postal_suburb = '$t_contacts_postal_suburb',
					  contacts_postal_state_id = '$t_contacts_postal_state_id',
					  contacts_postal_code1 = '$t_contacts_postal_code1',
					  contacts_phone = '$t_contacts_phone',
					  contacts_fax = '$t_contacts_fax',
					  contacts_email = '$t_contacts_email',
					  contacts_branch_id = '$h_contacts_branch_id',
					  additional_contacts = '$h_additional_contacts'
					  WHERE contacts_id = $h_contacts_id";
	}

	dbQuery($strSQL);
	header('Location: index.php?stateId=$t_contacts_state_id');	

}

/*
	Remove a Contact Details
*/
function deleteContactDetails()
{
	if (isset($_GET['contacts_id']) && (int)$_GET['contacts_id'] > 0) {
		$contactsId = (int)$_GET['contacts_id'];
	} else {
		header('Location: index.php');
	}
	
	
	$sql = "DELETE FROM tbl_contacts 
	        WHERE contacts_id = $contactsId";
	dbQuery($sql);
	
	header('Location: index.php');
}
?>