// JavaScript Document
function checkContactDetailsForm()
{
	with (window.document.frmModifyContactDetails) {
		if (isEmpty(txtcontacts_first_name_1, 'Please Enter Contact\'s First Name')) {
			return;
		} 
		
		else if (isEmpty(txtcontacts_last_name_1, 'Please Enter Contact\'s Last Name')) {
			return;
		}
		
		else if (isEmpty(txtcontacts_email_1, 'Please Enter Contact\'s Email Address')) {
			return;
		}
		
		else {
			submit();
		}
	}
}

function addContactDetails()
{
	window.location.href = 'index.php?view=add';
}

function modifyContactDetails(contactId)
{
	window.location.href = 'index.php?view=modify&contactId=' + contactId;
}

function deleteContactDetails(contactId)
{
	if (confirm('Delete this Contact Details?')) {
		window.location.href = 'processContactsDetails.php?action=delete&contactId=' + contactId;
	}
}