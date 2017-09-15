<?php
include("db.php");
session_start();
if(isSet($_POST['username']) && isSet($_POST['password']))
{
	// username and password sent from Form
	$username = mysqli_real_escape_string($db,$_POST['username']); 
	$password = mysqli_real_escape_string($db,$_POST['password']); 
	//$password = md5(mysqli_real_escape_string($db,$_POST['password'])); 

	$result = mysqli_query($db,"SELECT user_id FROM tbl_user WHERE user_name = '$username' and user_password = '$password'");
	$count = mysqli_num_rows($result);

	$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
	
	// If result matched $myusername and $mypassword, table row must be 1 row
	if($count == 1 )
	{
		$_SESSION['plaincart_user_id'] = $row['user_id'];
		echo $row['user_id'];
	}

}
?>