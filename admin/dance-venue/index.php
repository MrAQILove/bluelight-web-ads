<?php
require_once '../../library/config.php';
require_once '../library/functions.php';

$_SESSION['login_return_url'] = $_SERVER['REQUEST_URI'];
checkUser();

$view = (isset($_GET['view']) && $_GET['view'] != '') ? $_GET['view'] : '';

switch ($view) {
	case 'list' :
		$content 	= 'list.php';		
		$pageTitle 	= 'Blue Light Admin Control Panel - View Dance Venue';
		break;

	case 'add' :
		$content 	= 'add.php';		
		$pageTitle 	= 'Blue Light Admin Control Panel - Add Dance Venue';
		break;

	case 'modify' :
		$content 	= 'modify.php';		
		$pageTitle 	= 'Blue Light Admin Control Panel - Modify Dance Venue';
		break;

	default :
		$content 	= 'list.php';		
		$pageTitle 	= 'Blue Light Admin Control Panel - View Dance Venue';
}

$script    = array('dance-venue.js');

require_once '../include/template.php';
?>
