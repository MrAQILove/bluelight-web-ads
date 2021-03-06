<?php
function convertDateFromSQL($dateFromSQL) 
{
	$date = strtotime($dateFromSQL);
	$final_date = date("F j, Y", $date);
	return $final_date;
}

if (!defined('WEB_ROOT')) {
	exit;
}

$sql = "SELECT *
        FROM tbl_user
		ORDER BY user_name";
$result = dbQuery($sql);

?> 
<p>&nbsp;</p>
<form action="processUser.php?action=addUser" method="post"  name="frmListUser" id="frmListUser">
<table width="100%" border="0" align="center" cellpadding="2" cellspacing="1" class="text">
	<tr align="center" id="listTableHeader"> 
		<td>Name</td>
		<td>Username</td>
		<td width="120">Register Date</td>
		<td width="120">Last login</td>
		<td width="120">Change Password</td>
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
		<td align="center"><?php echo $user_fullname; ?></td>
		<td align="center"><?php echo $user_name; ?></td>
		<td width="120" align="center"><?php echo convertDateFromSQL($user_regdate); ?></td>
		<td width="120" align="center"><?php echo convertDateFromSQL($user_last_login); ?></td>
		<td width="120" align="center"><a href="javascript:changePassword(<?php echo $user_id; ?>);">Change Password</a></td>
		<td width="70" align="center"><a href="javascript:deleteUser(<?php echo $user_id; ?>);">Delete</a></td>
	</tr>
<?php
} // end while

?>
	<tr> 
		<td colspan="5">&nbsp;</td>
	</tr>
	
	<tr> 
		<td colspan="5" align="right"><input name="btnAddUser" type="button" id="btnAddUser" value="Add User" class="btnSubmit" onClick="addUser()"></td>
	</tr>
	</table>
 <p>&nbsp;</p>
</form>