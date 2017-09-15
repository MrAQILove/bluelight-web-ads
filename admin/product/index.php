<?php
require_once '../../library/config.php';
require_once '../library/functions.php';

$_SESSION['login_return_url'] = $_SERVER['REQUEST_URI'];
checkUser();

$view = (isset($_GET['view']) && $_GET['view'] != '') ? $_GET['view'] : '';

if (isset($_GET['catId']) && (int)$_GET['catId'] > 0) {
	$catId = (int)$_GET['catId'];
} 

else {
	$catId = 0;
}

switch ($view) 
{
	case 'list' :
		$content 	= 'list.php';
	
		$checkLeaderboardID = array(5, 10, 13, 17, 21, 25, 29, 33, 37, 41, 45, 49, 53, 57, 61, 65, 69, 73, 77, 81, 85, 89, 93, 97, 101, 105, 109, 113, 117, 121, 125, 129);
			if(in_array($catId, $checkLeaderboardID)) {
				$pageTitle 	= 'Blue Light Admin Control Panel - View Leaderboard Banner Ads';
		}

		$checkMediumRecID = array(6, 11, 14, 18, 22, 26, 30, 34, 38, 42, 46, 50, 54, 58, 62, 66, 70, 74, 78, 82, 86, 90, 94, 98, 102, 106, 110, 114, 118, 122, 126, 130);
			if(in_array($catId, $checkMediumRecID)) {
				$pageTitle 	= 'Blue Light Admin Control Panel - View Medium Rec Banner Ads';
		}

		$checkSkyscraperID = array(7, 11, 15, 19, 23, 27, 31, 35, 39, 43, 47, 51, 55, 59, 63, 67, 71, 75, 79, 83, 87, 91, 95, 99, 103, 107, 111, 115, 119, 123, 127, 131);
			if(in_array($catId, $checkSkyscraperID)) {
				$pageTitle 	= 'Blue Light Admin Control Panel - View Skyscraper Banner Ads';
		}

		$checkListingID = array(8, 12, 16, 20, 24, 28, 32, 36, 40, 44, 48, 52, 56, 60, 64, 68, 72, 76, 80, 84, 88, 92, 96, 100, 104, 108, 112, 116, 120, 124, 128, 132);
			if(in_array($catId, $checkListingID)) {
				$pageTitle 	= 'Blue Light Admin Control Panel - View Sponsors Listing Ads';
		}
		break;

	case 'add' :
		$content 	= 'add.php';		
		$pageTitle 	= 'Blue Light Admin Control Panel - Add Product';
		break;

	case 'modify' :
		$content 	= 'modify.php';		
		$pageTitle 	= 'Blue Light Admin Control Panel - Modify Product';
		break;

	case 'detail' :
		$content    = 'detail.php';
		$checkLeaderboardID = array(5, 10, 13, 17, 21, 25, 29, 33, 37, 41, 45, 49, 53, 57, 61, 65, 69, 73, 77, 81, 85, 89, 93, 97, 101, 105, 109, 113, 117, 121, 125, 129);
			if(in_array($catId, $checkLeaderboardID)) {
				$pageTitle 	= 'Blue Light Admin Control Panel - View Leaderboard Banner Ad Details';
		}

		$checkMediumRecID = array(6, 11, 14, 18, 22, 26, 30, 34, 38, 42, 46, 50, 54, 58, 62, 66, 70, 74, 78, 82, 86, 90, 94, 98, 102, 106, 110, 114, 118, 122, 126, 130);
			if(in_array($catId, $checkMediumRecID)) {
				$pageTitle 	= 'Blue Light Admin Control Panel - View Medium Rec Banner Ad Details';
		}

		$checkSkyscraperID = array(7, 11, 15, 19, 23, 27, 31, 35, 39, 43, 47, 51, 55, 59, 63, 67, 71, 75, 79, 83, 87, 91, 95, 99, 103, 107, 111, 115, 119, 123, 127, 131);
			if(in_array($catId, $checkSkyscraperID)) {
				$pageTitle 	= 'Blue Light Admin Control Panel - View Skyscraper Banner Ad Details';
		}

		$checkListingID = array(8, 12, 16, 20, 24, 28, 32, 36, 40, 44, 48, 52, 56, 60, 64, 68, 72, 76, 80, 84, 88, 92, 96, 100, 104, 108, 112, 116, 120, 124, 128, 132);
			if(in_array($catId, $checkListingID)) {
				$pageTitle 	= 'Blue Light Admin Control Panel - View Sponsors Listing Ad Details';
		}
		break;
		
	default :
		$content 	= 'list.php';		
		$checkLeaderboardID = array(5, 10, 13, 17, 21, 25, 29, 33, 37, 41, 45, 49, 53, 57, 61, 65, 69, 73, 77, 81, 85, 89, 93, 97, 101, 105, 109, 113, 117, 121, 125, 129);
			if(in_array($catId, $checkLeaderboardID)) {
				$pageTitle 	= 'Blue Light Admin Control Panel - View Leaderboard Banner Ads';
		}

		$checkMediumRecID = array(6, 11, 14, 18, 22, 26, 30, 34, 38, 42, 46, 50, 54, 58, 62, 66, 70, 74, 78, 82, 86, 90, 94, 98, 102, 106, 110, 114, 118, 122, 126, 130);
			if(in_array($catId, $checkMediumRecID)) {
				$pageTitle 	= 'Blue Light Admin Control Panel - View Medium Rec Banner Ads';
		}

		$checkSkyscraperID = array(7, 11, 15, 19, 23, 27, 31, 35, 39, 43, 47, 51, 55, 59, 63, 67, 71, 75, 79, 83, 87, 91, 95, 99, 103, 107, 111, 115, 119, 123, 127, 131);
			if(in_array($catId, $checkSkyscraperID)) {
				$pageTitle 	= 'Blue Light Admin Control Panel - View Skyscraper Banner Ads';
		}

		$checkListingID = array(8, 12, 16, 20, 24, 28, 32, 36, 40, 44, 48, 52, 56, 60, 64, 68, 72, 76, 80, 84, 88, 92, 96, 100, 104, 108, 112, 116, 120, 124, 128, 132);
			if(in_array($catId, $checkListingID)) {
				$pageTitle 	= 'Blue Light Admin Control Panel - View Sponsors Listing Ads';
		}
}

$script    = array('product.js');
require_once '../include/template.php';
?>
