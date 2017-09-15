<?php
require_once '../../library/config.php';
require_once '../library/functions.php';

$_SESSION['login_return_url'] = $_SERVER['REQUEST_URI'];
checkUser();

$view = (isset($_GET['view']) && $_GET['view'] != '') ? $_GET['view'] : '';

switch ($view) {
	case 'list' :
		$content 	= 'list.php';		
		$pageTitle 	= 'Blue Light Admin Control Panel - View Contact Details';
		break;

	case 'add' :
		$content 	= 'add.php';		
		$pageTitle 	= 'Blue Light Admin Control Panel - Add Contact Details';
		break;

	case 'modify' :
		$content 	= 'modify.php';		
		$pageTitle 	= 'Blue Light Admin Control Panel - Modify Contact Details';
		break;

	default :
		$content 	= 'list.php';		
		$pageTitle 	= 'Blue Light Admin Control Panel - View Contact Details';
}

$script    = array('contact-details.js');

require_once '../include/template.php';
?>
