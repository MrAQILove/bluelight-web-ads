<?php 
if (!empty($_GET[success])) 
{ 
	echo "<b>Your file has been imported.</b><br><br>"; 
	
} 

else {
	$er = errors($error);
	echo $er;
}

//generic success notice 
?> 