// JavaScript Document
function checkCategoryForm()
{
    with (window.document.frmCategory) {
		if (isEmpty(txtName, 'Enter category name')) {
			return;
		} 
		
		//else if (isEmpty(mtxDescription, 'Enter category description')) {
		//	return;
		//} 
		
		else {
			submit();
		}
	}
}

function addCategory(parentId)
{
	targetUrl = 'index.php?view=add';
	if (parentId != 0) {
		targetUrl += '&parentId=' + parentId;
	}
	
	window.location.href = targetUrl;
}

function modifyCategory(catId)
{
	window.location.href = 'index.php?view=modify&catId=' + catId;
}

function deleteCategory(catId)
{
	if (confirm('Deleting category will also delete all products in it.\nContinue anyway?')) {
		window.location.href = 'processCategory.php?action=delete&catId=' + catId;
	}
}

function activateCampaign(catParentId, catId)
{
	if (confirm('Are you sure you want to activate this Campaign?')) {
		window.location.href = 'processCategory.php?action=activate&catParentId='+ catParentId +'&catId=' + catId;
	}
}

function deactivateCampaign(catParentId, catId)
{
	if (confirm('Are you sure you want to de-activate this Campaign?')) {
		window.location.href = 'processCategory.php?action=deactivate&catParentId='+ catParentId +'&catId=' + catId;
	}
}

function deleteImage(catId)
{
	if (confirm('Delete this image?')) {
		window.location.href = 'processCategory.php?action=deleteImage&catId=' + catId;
	}
}