<?php
require_once 'config.php';

function displayAds($id, $loc_id)
{
	switch ($id)
	{
		case 1:
			$productsPerRow = 1;
			break;

		case 2:
			$productsPerRow = 2;
			break;

		case 3:
			$productsPerRow = 6;
			break;
	}

	// Current date
	$current_date = date( 'Y-m-d', time() );

	$children		= array_merge(array($id), getChildCategories(NULL, $id));
	$children		= ' (' . implode(', ', $children) . ')';

	/*
	$sql = "SELECT pd.*, c.cat_id
			FROM tbl_product pd 
			INNER JOIN tbl_category c ON pd.cat_id = c.cat_id
			WHERE pd.pd_start_date <= '$current_date' AND pd.pd_end_date >= '$current_date'
			AND pd.cat_id IN $children
			AND pd_location_id = '$loc_id'
			AND c.cat_name = 'June - August 2013'
			ORDER BY pd_booking_no ASC";
	*/

	$sql = "SELECT pd.*, c.cat_id
			FROM tbl_product pd 
			INNER JOIN tbl_category c ON pd.cat_id = c.cat_id
			WHERE pd.pd_start_date <= '$current_date' AND pd.pd_end_date >= '$current_date'
			AND pd.cat_id IN $children
			AND pd_location_id = '$loc_id'
			ORDER BY pd_booking_no ASC";


	$result		= dbQuery($sql) or die( $sql."<br /><br />". mysql_error() );
	$numAds		= dbNumRows($result);

	// the product images are arranged in a table. to make sure
	// each image gets equal space set the cell width here
	$columnWidth = (int)(100 / $productsPerRow);

	echo '<table border="0" cellpadding="0" cellspacing="0" width="100%">'."\n";

	if ($numAds > 0 ) 
	{
		$i = 0;
		while ($row = dbFetchAssoc($result)) 
		{
			extract($row);
			
			if ($pd_thumbnail) {
				$pd_thumbnail = WEB_ROOT . 'images/product/' . $pd_thumbnail;
			} 
			
			else {
				$pd_thumbnail = WEB_ROOT . 'images/no-image-small.png';
			}
			

			$checkProductID = array(1065, 1066, 1067, 1068, 1069, 1070, 1071, 1072, 1073, 1074, 1075, 1076, 1077, 1078, 1079, 1080, 1081, 1082, 1083, 1084, 1084, 1085, 1086, 1087, 1088, 1089, 1090, 1091, 1092, 1093, 1094, 1095);

			if ($pd_id == 1096) {
				$webad = '<img src="'.$pd_thumbnail .'" width="300" height="250" border="0">';
			}

			else if(in_array($pd_id, $checkProductID)) {
				$webad = '<img src="'.$pd_thumbnail .'" width="120" height="600" border="0">';
			}
		
			else {	
				$webad = '<img src="'.$pd_thumbnail .'" border="0">';
			}
		
			if ($i % $productsPerRow == 0) {
				echo '<tr>'."\n";
			}

			if (!empty($pd_link) && ($pd_link != "NULL")) {
				echo '<td width="'.$columnWidth.'%" align="center"><a href="http://'.$pd_link.'" target="_new">'.$webad.'</a></td>'."\n";
			}

			else {
				echo '<td width="'.$columnWidth.'%" align="center">'.$webad.'</td>'."\n";
			}

			switch ($id)
			{
				case 2:
					echo '<td><img src="../images/spacer.gif" width="5" height="5" border="0"></td>'."\n";
					break;

				case 3:
					echo '<td><img src="../images/spacer.gif" width="1" height="1" border="0"></td>'."\n";
					break;
			}
			
			if ($i % $productsPerRow == $productsPerRow - 1) {
				echo '</tr>'."\n";
				echo '<tr><td><img src="../images/spacer.gif" width="1" height="5" border="0"></td></tr>'."\n\n";
			}
			
			$i += 1;
		}
		
		if ($i % $productsPerRow > 0) {
			//echo '<td colspan="' . ($productsPerRow - ($i % $productsPerRow)) . '">&nbsp;</td>'."\n";
			echo '<td>&nbsp;</td>'."\n";
			echo '</tr>'."\n";
		}
		
	} 
	else {
		echo '<tr><td width="100%" align="center" valign="center">No Web Ads in this campaign</td></tr>'."\n";
	}	
	
	echo '</table>'."\n";
}

function displayLeaderboard($loc_id, $campaign)
{
	// Current date
	$current_date = date( 'Y-m-d', time() );

	$sql = "SELECT pd.*, c.cat_id
			FROM tbl_product pd 
			INNER JOIN tbl_category c ON pd.cat_id = c.cat_id
			WHERE pd.pd_start_date <= '$current_date' AND pd.pd_end_date >= '$current_date'
			AND pd_location_id = '$loc_id'
			AND c.cat_name = '$campaign'
			ORDER BY pd_booking_no ASC";

	$result		= dbQuery($sql) or die( $sql."<br /><br />". mysql_error() );
	$numAds		= dbNumRows($result);

	if ($numAds > 0 ) 
	{
		while ($row = dbFetchAssoc($result)) 
		{
			extract($row);
			
			$pd_image = WEB_ROOT . 'images/product/' . $pd_image;

			echo '<img src="'.$pd_image.'" border="0" alt="">'."\n";
		}
				
	}
	
	else {
		echo '<img src="images/leaderboard-banner.jpg" width="728" height="90" border="0" alt="">'."\n";
	}	
}

// Display Leaderboard Banner on Homepage
function displayLeaderboardHomepage($loc_id)
{
	// Current date
	$current_date = date( 'Y-m-d', time() );

	$sql = "SELECT pd.*, c.cat_id
			FROM tbl_product pd 
			INNER JOIN tbl_category c ON pd.cat_id = c.cat_id
			WHERE pd.pd_start_date <= '$current_date' AND pd.pd_end_date >= '$current_date'
			AND pd.cat_id IN (49)
			AND pd_location_id = '$loc_id'
			ORDER BY pd_booking_no ASC";

	$result		= dbQuery($sql) or die( $sql."<br /><br />". mysql_error() );
	$numAds		= dbNumRows($result);

	if ($numAds > 0 ) 
	{
		while ($row = dbFetchAssoc($result)) 
		{
			extract($row);
			
			$pd_image = WEB_ROOT . 'images/product/' . $pd_image;

			//echo '<img src="'.$pd_image.'" border="0" alt="">'."\n";

			echo 'myAd.Ad("'.$pd_image.'", "", "_self", "'.$pd_name.'");'."\n";
		}
				
	}
}
//

function displayMediumRec($loc_id, $campaign)
{
	// Current date
	$current_date = date( 'Y-m-d', time() );

	$sql = "SELECT pd.*, c.cat_id
			FROM tbl_product pd 
			INNER JOIN tbl_category c ON pd.cat_id = c.cat_id
			WHERE pd.pd_start_date <= '$current_date' AND pd.pd_end_date >= '$current_date'
			AND pd.cat_id = '6'
			AND pd_location_id = '$loc_id'
			AND c.cat_name = '$campaign'
			ORDER BY pd_booking_no ASC";


	$result		= dbQuery($sql) or die( $sql."<br /><br />". mysql_error() );
	$numAds		= dbNumRows($result);

	if ($numAds > 0 ) 
	{
		while ($row = dbFetchAssoc($result)) 
		{
			extract($row);
			
			$pd_image = WEB_ROOT . 'images/product/' . $pd_image;

			echo '<p><img src="'.$pd_image.'" border="0" alt=""></p>'."\n";
		}
				
	}
	
	else {
		echo '<p><img src="images/medium-rec-01.jpg" width="300" height="250" border="0" alt=""></p>'."\n";
	}	
}

function displayListing($loc_id)
{
	// Current date
	$current_date = date( 'Y-m-d', time() );

	$sql = "SELECT pd.*, c.cat_id
			FROM tbl_product pd 
			INNER JOIN tbl_category c ON pd.cat_id = c.cat_id
			WHERE pd.pd_start_date <= '$current_date' AND pd.pd_end_date >= '$current_date'
			AND pd.cat_id IN (36, 40, 44, 48, 52, 56, 60, 64, 68, 72, 76, 80, 84, 88, 92, 96, 100, 104, 108, 112, 116, 120, 124, 128, 132)
			AND pd_location_id = '$loc_id'
			ORDER BY pd_booking_no ASC";
	
	/**/

	$result		= dbQuery($sql) or die( $sql."<br /><br />". mysql_error() );
	$numAds		= dbNumRows($result);

	if ($numAds > 2 ) 
	{
		echo '<ul id="vertical-ticker">'."\n";

		while ($row = dbFetchAssoc($result)) 
		{
			extract($row);
			
			echo '<li>'."\n";
			if (!empty($pd_link)) {
				echo '<a href="http://'.$pd_link.'" target="_new"><b>'.$pd_name.'</b></a><br />'."\n";
			}

			else {
				echo '<b>'.$pd_name.'</b><br />'."\n";
			}
			echo $pd_description."\n";
			echo '</li>'."\n\n";
		}

		echo '</ul>'."\n";
	}

	elseif ($numAds = 2 ) 
	{
		echo '<ul>'."\n";

		while ($row = dbFetchAssoc($result)) 
		{
			extract($row);
			
			echo '<li>'."\n";
			if (!empty($pd_link)) {
				echo '<a href="http://'.$pd_link.'" target="_new"><b>'.$pd_name.'</b></a><br />'."\n";
			}

			else {
				echo '<b>'.$pd_name.'</b><br />'."\n";
			}
			echo $pd_description."\n";
			echo '</li>'."\n\n";
		}

		echo '</ul>'."\n";
	}
	
	else 
	{
		echo '<p>No Local Sponsors listed.</p>'."\n";
		echo '<p>
				<!--<span class="small">-->
				PUT YOUR AD HERE! <br />
				For more information, please contact <b>Tony Cornish</b> on <b>03 9937 0200</b> or email him at <b><a href="mailto:tcornish@cwaustral.com.au">tcornish@cwaustral.com.au</a></b>.
				<!--</span>-->
			</p>'."\n";
	}	
}

function displayAllListings()
{
	// Current date
	$current_date = date( 'Y-m-d', time() );

	$sql = "SELECT pd.*, c.cat_id
			FROM tbl_product pd 
			INNER JOIN tbl_category c ON pd.cat_id = c.cat_id
			WHERE pd.pd_start_date <= '$current_date' AND pd.pd_end_date >= '$current_date'
			AND pd.cat_id IN (36, 40, 44, 48, 52, 56, 60, 64, 68, 72, 76, 80, 84, 88, 92, 96, 100, 104, 108, 112, 116, 120, 124, 128, 132)
			ORDER BY pd_booking_no ASC";

			//AND pd.cat_id IN (8, 12, 16, 20, 24, 28)
			//ORDER BY pd_booking_no DESC";


	$result		= dbQuery($sql) or die( $sql."<br /><br />". mysql_error() );
	$numAds		= dbNumRows($result);

	if ($numAds > 0 ) 
	{
		while ($row = dbFetchAssoc($result)) 
		{
			extract($row);
			
			echo '<li>'."\n";
			echo '<b>'.$pd_name.'</b><br />'."\n";
			echo $pd_description."\n";
			echo '</li>'."\n\n";
		}
				
	}
	
	else 
	{
		echo '<p>No Local Sponsors listed.</p>'."\n";
		echo '<p>
				<!--<span class="small">-->
				PUT YOUR AD HERE! <br />
				For more information, please contact <b>Tony Cornish</b> on <b>03 9937 0200</b> or email him at <b><a href="mailto:tcornish@cwaustral.com.au">tcornish@cwaustral.com.au</a></b>.
				<!--</span>-->
			</p>'."\n";
	}	
}

function convertDateFromSQL($dateFromSQL) 
{
	$date = strtotime($dateFromSQL);
	$final_date = date("F j, Y", $date);
	return $final_date;
}

function convertTimeFromSQL($timefromSQL)
{
	$time = strftime('%I:%M %p', strtotime($timefromSQL));
	return $time;
}

function getDateFormatFromSQL($format, $dateFromSQL) 
{
	$date = strtotime($dateFromSQL);
	$final_day = date($format, $date);
	return $final_day;
}

function displayTimetable($branchId)
{
	// Current date
	$current_date = date( 'Y-m-d', time() );

	$strSQL = "SELECT *
			FROM tbl_timetable t 
			INNER JOIN tbl_branch b ON t.branch_id = b.branch_id
			INNER JOIN tbl_venues v ON t.venues_id = v.venues_id
			WHERE t.timetable_date >= '$current_date'
			AND t.branch_id = '$branchId'";

	$result		= dbQuery($strSQL) or die( $strSQL."<br /><br />". mysql_error() );
	$numAds		= dbNumRows($result);
	
	echo '
		<table id="gradient-style" summary="Dance Dates &amp; Times">
			<thead>
				<tr>
					<th scope="col"><img src="../images/spacer.gif" width="1" height="10" border="0" alt=""></th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<td>&nbsp;</td>
				</tr>
			</tfoot>
			<tbody>
		';
		
	if ($numAds > 0 ) 
	{
		while ($row = dbFetchAssoc($result)) 
		{
			extract($row);

			if ( ($timetable_age == "Primary School Age") || ($timetable_age == "4 - 10 Y.O.") || ($timetable_age == "8 - 12 Y.O.") || ($timetable_age == "Year 1 - Year 3") || ($timetable_age == "Year 4 - Year 7") || ($timetable_age == "Kindergarten - Year 6") ) {
				$timetable_title = 'Junior Disco';
			}
				
			else {
				$timetable_title = 'Senior Disco';
			}
				
			echo '
			<tr>
			<td>';
?>
				<div class="event_detail_container">
					<a href="#"><div class="event-photos" style="background: url('/demo-v2/rt/media/com_ohanah/attachments_thumbs/1632543648-event-flyer.png'); background-size: 100% 100%"></div></a>
						
					<div class="event_date_flyer_container">
						<div class="event_date"  id="event_date_day">	
							<div class="event_date_day"><?php echo getDateFormatFromSQL("d", $timetable_date);?></div>
							<div class="event_date_month"><?php echo strtoupper(getDateFormatFromSQL("M", $timetable_date));?></div>
							<div class="event_date_year"><?php echo date("Y", strtotime($timetable_date));?></div>
						</div>
					</div>
						
					<div class="event_detail_title">
						<span class="event"><?php echo $timetable_title; ?></span>
					</div>
		
					<div class="event_detail_location">
						<div class="location_icon"></div>
						<span class="location"><?php echo $venues_name; ?></span>
					</div>
		
					<div class="event-short-description">
						<p>
						<b>Start Time:</b> <?php echo convertTimeFromSQL($timetable_start_time); ?>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
						<b>End Time:</b> <?php echo convertTimeFromSQL($timetable_end_time); ?><br />
						<b>Age Group:</b> <?php echo $timetable_age; ?>
						</p>

						<?php
						if (!empty($timetable_note)) {
							echo '<p>'.$timetable_note.'</p>'."\n";
						}
						?>
					</div>
					
					<div id="event-container-info">
						<!--<span style="float: right; padding-left:8px"><a href="#" class="readon register-link-button"><span>Read more</span></a></span>
						<span class="event-places-left" style="float: right">Places left: 443</span>
						<span class="event-places-left" style="float: right">&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;</span>-->								
						<span class="event-ticket-cost" style="float: right"><b>Cost:</b> <?php echo '$'.$timetable_price; ?></span>
						<div class="ticket_icon" style="float: right"></div>
						<span class="event-category-link" style="float: left"><?php echo $timetable_title; ?></span>
						<span class="event-venue-link" style="float: left">&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;@ <?php echo $venues_name; ?></span>	
					</div>
				</div>
			</td>
			</tr>
			<?php

		}
				
	}
		
	else 
	{
		echo '<tr>'."\n";
		echo '<td><span class="no-event">No dance dates &amp; times listed</span></td>'."\n";
		echo '</tr>'."\n";
	}

	echo '					
		</tbody>
	</table>
	';

	if ($numAds > 0 )
	{
		echo '<h4>additional notes:</h4>
					<ul class="list2">
						<li>No alcohol or pass-outs.</li>
						<li>All the latest hits to dance to;</li>
						<li>Major door prize;</li>
						<li>Many other prizes to be won;</li>
						<li>Drinks &amp; snacks available at our canteen.</li>
					</ul>
		'."\n";
	}
}

function displayUpcomingEvents()
{
	// current date
	$current_date = date( 'Y-m-d', time() );

	$strSQL = "SELECT *
			FROM tbl_timetable t 
			INNER JOIN tbl_branch b ON t.branch_id = b.branch_id
			INNER JOIN tbl_venues v ON t.venues_id = v.venues_id
			INNER JOIN tbl_state s ON v.state_id = s.state_id
			INNER JOIN tbl_contacts c ON b.contacts_id = c.contacts_id
			WHERE t.timetable_date >= '$current_date'
			ORDER BY timetable_date ASC
			LIMIT 5";


	$result				= dbQuery($strSQL) or die( $strSQL."<br /><br />". mysql_error() );
	$numUpcomingEvents	= dbNumRows($result);

	if ($numUpcomingEvents > 0 ) 
	{
		$i = 0;
		
		$class = array("createdate","createdate2","createdate3","createdate4","createdate5");

		while ($row = dbFetchAssoc($result)) 
		{
			extract($row);

			if ( ($timetable_age == "Primary School Age") || ($timetable_age == "4 - 10 Y.O.") || ($timetable_age == "8 - 12 Y.O.") || ($timetable_age == "Year 1 - Year 3") || ($timetable_age == "Year 4 - Year 7") || ($timetable_age == "Kindergarten - Year 6") ) {
				$timetable_title = 'Junior Disco';
			}
			
			else {
				$timetable_title = 'Senior Disco';
			}

			$location	= $venues_address1.', '.$venues_suburb.'&nbsp;'.$state_abbr.'&nbsp;'.$venues_postal_code;
			$time		= convertTimeFromSQL($timetable_start_time). ' - '.convertTimeFromSQL($timetable_end_time);
			$contact	= $contacts_first_name.'&nbsp;'.strtoupper($contacts_last_name);
		?>
			<div class="item contentpaneopen"> 
				<span class="<?php echo $class[$i]; ?>"><?php echo getDateFormatFromSQL("d", $timetable_date).'.'.getDateFormatFromSQL("m", $timetable_date);?></span> 
				<span class="">
					<p>
					<?php echo $branch_name. ' Blue Light Disco';?> <br />
					Event: <?php echo $timetable_title; ?><br />
					Date: <?php echo convertDateFromSQL($timetable_date); ?>
					</p>
				</span> 
				<span class="readmore4"><a href="#inline-<?php echo $timetable_id; ?>" rel="prettyPhoto[<?php echo $branch_name.$timetable_id; ?>]">more</a></span>
				<div style="clear: both;"></div>
			</div>

			<div id="inline-<?php echo $timetable_id; ?>" class="hide">
				<div class="inside">
					<span class="strong"><?php echo $timetable_title; ?></span><br /><br />
					<ul class="list-p1">
						<li>Date: <?php echo convertDateFromSQL($timetable_date); ?></li>
						<li>Venue: <?php echo $venues_name; ?></li>
						<li>Location: <?php echo $location; ?></li>
						<li>Time: <?php echo $time; ?></li>
						<li>Age Group: <?php echo $timetable_age; ?></li>
						<li>Cost: $<?php echo $timetable_price; ?></li>
					</ul>

					<ul class="list-p2">
						<li>Please contact <?php echo $contact; ?> for more information.</li>
						<li>No alcohol or pass-outs.</li>
						<li>All the latest hits to dance to;</li>
						<li>Major door prize;</li>
						<li>Many other prizes to be won;</li>
						<li>Drinks &amp; snacks available at our canteen.</li>
					</ul>
				</div>
			</div>
		<?php

			$i < 5 ? $i++ : $i = 0;
		} // end while
	}
	
	else {
		echo '<p>No upcoming event</p>';
	}
}


function displayLatestEvent()
{
	// current date
	$current_date = date( 'Y-m-d', time() );

	$strSQL = "SELECT *
			FROM tbl_timetable t 
			INNER JOIN tbl_branch b ON t.branch_id = b.branch_id
			INNER JOIN tbl_venues v ON t.venues_id = v.venues_id
			INNER JOIN tbl_state s ON v.state_id = s.state_id
			INNER JOIN tbl_contacts c ON b.contacts_id = c.contacts_id
			WHERE t.timetable_date >= '$current_date'
			ORDER BY timetable_date ASC
			LIMIT 2";


	$result	= dbQuery($strSQL) or die( $strSQL."<br /><br />". mysql_error() );
	
	//let's get the number of rows in our result so we can use it in a for loop
	$numLatestEvent	= dbNumRows($result);

	if ($numLatestEvent > 0 ) 
	{
		//while ($row = dbFetchAssoc($result)) 
		echo '<div class="item column-2 grey_text">';
		echo '<h2>latest <span class="style2">event</span></h2>';
		
		for($i = 0; $i < $numLatestEvent; $i++) 
		{
			//get a row from our result set
			$row = mysql_fetch_array($result);
		
			extract($row);

			if ( ($timetable_age == "Primary School Age") || ($timetable_age == "4 - 10 Y.O.") || ($timetable_age == "8 - 12 Y.O.") || ($timetable_age == "Year 1 - Year 3") || ($timetable_age == "Year 4 - Year 7") || ($timetable_age == "Kindergarten - Year 6") ) {
				$timetable_title = 'Junior Disco';
			}
			
			else {
				$timetable_title = 'Senior Disco';
			}

			$location	= $venues_address1.', '.$venues_suburb.'&nbsp;'.$state_abbr.'&nbsp;'.$venues_postal_code;
			$time		=	convertTimeFromSQL($timetable_start_time). ' - '.convertTimeFromSQL($timetable_end_time);
			$contact	= $contacts_first_name.'&nbsp;'.strtoupper($contacts_last_name);
		?>
			
			<h4><?php echo $branch_name; ?><br /><span class="style4">Blue Light</span> <?php echo $timetable_title; ?></h4>
			<ul class="list2">
				<li>TIME: <?php echo $time; ?></li>
				<li>AGE: <?php echo $timetable_age; ?></li>
			</ul>
		<?php
		}
		?>	
			<ul class="list2-i">
				<li>DATE: <?php echo strtoupper(convertDateFromSQL($timetable_date)); ?></li>
				<li>VENUE: <?php echo $venues_name; ?></li><br />
				<li>ADDRESS: <?php echo $location; ?></li><br />
				<li>COST: $<?php echo $timetable_price; ?></li>
			</ul>
		
			<p class="readmore"><a href="#latest-<?php echo $timetable_id; ?>" rel="prettyPhoto[<?php echo $branch_name; ?>]">read more</a></p>
			<div class="item-separator"></div>
		</div>
		
		<div id="latest-<?php echo $timetable_id; ?>" class="hide">
			<div class="inside">
				<ul class="list-p2">
					<li>Please contact <?php echo $contact; ?> for more information.</li>
					<li>No alcohol or pass-outs.</li>
					<li>All the latest hits to dance to;</li>
					<li>Major door prize;</li>
					<li>Many other prizes to be won;</li>
					<li>Drinks &amp; snacks available at our canteen.</li>
				</ul>
			</div>
		</div>
	<?php
	}
	
	else {
		echo '
			<div class="item column-2 grey_text">
				<!--<h2>latest <span class="style2">event</span></h2>-->
				<h2><span class="style4">blue light</span> magazine</h2>
				<p><a href="https://cwa.carmacloud.com/files/1412/11142-3679-84608476/"><img src="images/Blue-Light-Summer-2014-small.jpg"></a></p>
				<p class="readmore2"><a href="https://cwa.carmacloud.com/files/1412/11142-3679-84608476/">view magazine</a></p>
				<div class="item-separator"></div>
			</div>
			';
	}
}
?>