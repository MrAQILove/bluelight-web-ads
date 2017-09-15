<?php
if (!defined('WEB_ROOT')) {
	exit;
}

$self = WEB_ROOT . 'admin/index.php';

function whichBanner($bannerType)
{
	$current_year = date("Y");
	
	if (isset($_GET['catId']) && (int)$_GET['catId'] >= 0) {
		$catId = (int)$_GET['catId'];
	}

	else {
		$catId = 0;
	}

	/* Put this back JANUARY 5, 2015 */
	/*
	$sql = "SELECT * 
			FROM tbl_category 
			WHERE cat_parent_id = $bannerType
			AND cat_year_created = '$current_year'
			AND cat_active ='1'";
	*/

	/* DELETE THIS ON JANUARY 5, 2015 */
	$sql = "SELECT * 
			FROM tbl_category 
			WHERE cat_parent_id = $bannerType
			AND cat_active ='1'";
	

	$result = dbQuery($sql);

	if (dbNumRows($result) > 0) 
	{
?>
		<select OnChange="goto_byselect(this, 'self')">
		<option>Select Campaign</option>
<?php
		while($row = dbFetchAssoc($result)) 
		{
			extract($row);
			$options = "<option value=\"/php/web-ads/admin/product/index.php?catId=$cat_id\"";
			if ($cat_id == $catId) {
				$options.= " selected";
			}
			
			$options .= ">$cat_name</option>\r\n";

			echo $options;
		}
		
		echo '</select>';
	}
}

function whichState()
{
	if (isset($_GET['stateId']) && (int)$_GET['stateId'] >= 0) {
		$stateId = (int)$_GET['stateId'];
	}

	else {
		$stateId = 0;
	}

	$sql = "SELECT *   
			FROM tbl_state";

	$result = dbQuery($sql);

	if (dbNumRows($result) > 0) 
	{
?>
		<select OnChange="goto_byselect(this, 'self')">
		<option>Select State</option>
<?php
		while($row = dbFetchAssoc($result)) 
		{
			extract($row);
			$options = "<option value=\"/php/web-ads/admin/contact-details/index.php?stateId=$state_id\"";
			if ($state_id == $stateId) {
				$options.= " selected";
			}
			
			$options .= ">$state_abbr</option>\r\n";

			echo $options;
		}
		
		echo '</select>';
	}
}

function whichLocation()
{
	if (isset($_GET['locationId']) && (int)$_GET['locationId'] >= 0) {
		$locationId = (int)$_GET['locationId'];
	}

	else {
		$locationId = 0;
	}

	$current_year = date("Y");

	/*
	$sql = "SELECT *   
			FROM tbl_location l
			INNER JOIN tbl_product p ON p.pd_location_id = l.location_id
			INNER JOIN tbl_category c ON c.cat_id = p.cat_id
			WHERE location_id IN (20,21,25,26,29,30)
			AND cat_year_created = '$current_year'
			AND cat_active ='1'";
	*/

	$sql = "SELECT *   
			FROM tbl_location l
			WHERE location_id IN (20,21,25,26,29,30)";

	$result = dbQuery($sql);

	if (dbNumRows($result) > 0) 
	{
?>
		<select OnChange="goto_byselect(this, 'self')">
		<option>Select Ad Location</option>
<?php
		while($row = dbFetchAssoc($result)) 
		{
			extract($row);
			$options = "<option value=\"/php/web-ads/admin/product/index.php?locationId=$location_id\"";
			if ($location_id == $locationId) {
				$options.= " selected";
			}
			
			$options .= ">$location_name</option>\r\n";

			echo $options;
		}
		
		echo '</select>';
	}
}

$pageTitle = 'Blue Light Web Ad Admin';
?>
<html lang="en">
<head>
	<title><?php echo $pageTitle; ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<link rel="stylesheet" type="text/css" href="<?php echo WEB_ROOT;?>admin/include/admin.css">
	<link rel="stylesheet" type="text/css" href="<?php echo WEB_ROOT;?>admin/include/font-awesome.css">
	<link rel="stylesheet" href="<?php echo WEB_ROOT;?>admin/css/jquery-ui.css" />
	<script language="javascript" type="text/javascript" src="<?php echo WEB_ROOT;?>library/common.js"></script>
	<?php
	$n = count($script);
	for ($i = 0; $i < $n; $i++) 
	{
		if ($script[$i] != '') {
			echo '<script language="javascript" type="text/javascript" src="' . WEB_ROOT. 'admin/library/' . $script[$i]. '"></script>'."\n";
		}
	}
	?>
	<script language="javascript" type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.js"></script>
	<script language="javascript" type="text/javascript" src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
	<script type="text/javascript">
	$(function() {
		$( "#start_date" ).datepicker({
			showOn: "button",
			buttonImage: "<?php echo WEB_ROOT;?>admin/images/calendar.png",
			buttonImageOnly: true
		});

		$( "#end_date" ).datepicker({
			showOn: "button",
			buttonImage: "<?php echo WEB_ROOT;?>admin/images/calendar.png",
			buttonImageOnly: true
		});
	});
	</script>
	<script language="javascript">
	<!--
	function goto_byselect(sel, targetstr)
	{
	   var index = sel.selectedIndex;
	   if (sel.options[index].value != '') 
	   {
		  if (targetstr == 'blank') {
			 window.open(sel.options[index].value, 'win1');
		  } 
		  
		  else 
		  {
			 var frameobj;
			 if (targetstr == '') targetstr = 'self';
			 if ((frameobj = eval(targetstr)) != null)
			 frameobj.location = sel.options[index].value;
		  }
	   }
	}
	// -->
	</script>

	<script language=JavaScript>
	function reload(form)
	{
		var selected_value=frmAddContactDetails.state.options[frmAddContactDetails.state.options.selectedIndex].value;
		self.location='index.php?view=add&state=' + selected_value ;   
	}
	</script>
	<script type="text/javascript">
	$(document).ready(function() 
	{
		var MaxInputs       = 3; //maximum input boxes allowed
		var InputsWrapper   = $("#InputsWrapper"); //Input boxes wrapper ID
		var AddButton       = $("#AddMoreFileBox"); //Add button ID

		var x = InputsWrapper.length; //initlal text box count
		var FieldCount=1; //to keep track of text box added

		$(AddButton).click(function (e)  //on add input button click
		{
			if(x <= MaxInputs) //max input box allowed
			{
				FieldCount++; //text box added increment
				//add input box
				$(InputsWrapper).append('<table border="0" cellpadding="0" cellspacing="0" width="100%" id="ContactDetails"><tr><td width="150">Name '+ FieldCount +':</td><td><input type="text" name="txtcontacts_title_'+ FieldCount +'" id="txtcontacts_title_'+ FieldCount +'" value="Title '+ FieldCount +'" size="15" maxlength="15" /><input type="text" name="txtcontacts_first_name_'+ FieldCount +'" id="txtcontacts_first_name_'+ FieldCount +'" value="First Name '+ FieldCount +'"" size="25" maxlength="25"> <input type="text" name="txtcontacts_last_name_'+ FieldCount +'" id="txtcontacts_last_name_'+ FieldCount +'" value="Last Name '+ FieldCount +'"" size="25" maxlength="25"> <a href="#" class="removeclass">[&times;]</a></td></tr></table>');
				x++; //text box increment
			}
		return false;
		});

		$("body").on("click",".removeclass", function(e){ //user click on remove text
			if( x > 1 ) {
				//$(this).parent('table').remove(); //remove text box
				$("#ContactDetails").remove();
				x--; //decrement textbox
			}
			return false;
		})

	});

	$(document).ready(function() 
	{
		var MaxInputs_P       = 2; //maximum input boxes allowed
		var InputsWrapper_P   = $("#InputsWrapper_P"); //Input boxes wrapper ID
		var AddButton_P       = $("#AddMoreFileBox_P"); //Add button ID

		var x_P = InputsWrapper_P.length; //initlal text box count
		var FieldCount_P = 1; //to keep track of text box added

		$(AddButton_P).click(function (e)  //on add input button click
		{
			if(x_P <= MaxInputs_P) //max input box allowed
			{
				FieldCount_P++; //text box added increment
				//add input box
				$(InputsWrapper_P).append('<table border="0" cellpadding="0" cellspacing="0" width="100%" id="ContactDetails_P"><tr><td width="150">Phone No. '+ FieldCount_P +':</td><td><input type="text" name="txtcontacts_phone_'+ FieldCount_P +'" id="txtcontacts_phone_'+ FieldCount_P +'" value="Phone No. '+ FieldCount_P +'" size="15" maxlength="15" /> <a href="#" class="removeclass">[&times;]</a></td></tr></table>');
				x_P++; //text box increment
			}
		return false;
		});

		$("body").on("click",".removeclass", function(e){ //user click on remove text
			if( x_P > 1 ) {
				//$(this).parent('table').remove(); //remove text box
				$("#ContactDetails_P").remove();
				x_P--; //decrement textbox
			}
			return false;
		})

	});

	$(document).ready(function() 
	{
		var MaxInputs_F       = 2; //maximum input boxes allowed
		var InputsWrapper_F   = $("#InputsWrapper_F"); //Input boxes wrapper ID
		var AddButton_F       = $("#AddMoreFileBox_F"); //Add button ID

		var x_F = InputsWrapper_F.length; //initlal text box count
		var FieldCount_F = 1; //to keep track of text box added

		$(AddButton_F).click(function (e)  //on add input button click
		{
			if(x_F <= MaxInputs_F) //max input box allowed
			{
				FieldCount_F++; //text box added increment
				//add input box
				$(InputsWrapper_F).append('<table border="0" cellpadding="0" cellspacing="0" width="100%" id="ContactDetails_F"><tr><td width="150">Fax No. '+ FieldCount_F +':</td><td><input type="text" name="txtcontacts_fax_'+ FieldCount_F +'" id="txtcontacts_fax_'+ FieldCount_F +'" value="Fax No. '+ FieldCount_F +'" size="15" maxlength="15" /> <a href="#" class="removeclass">[&times;]</a></td></tr></table>');
				x_F++; //text box increment
			}
		return false;
		});

		$("body").on("click",".removeclass", function(e){ //user click on remove text
			if( x_F > 1 ) {
				//$(this).parent('table').remove(); //remove text box
				$("#ContactDetails_F").remove();
				x_F--; //decrement textbox
			}
			return false;
		})

	});

	$(document).ready(function() 
	{
		var MaxInputs_E       = 2; //maximum input boxes allowed
		var InputsWrapper_E   = $("#InputsWrapper_E"); //Input boxes wrapper ID
		var AddButton_E       = $("#AddMoreFileBox_E"); //Add button ID

		var x_E = InputsWrapper_E.length; //initlal text box count
		var FieldCount_E = 1; //to keep track of text box added

		$(AddButton_E).click(function (e)  //on add input button click
		{
			if(x_E <= MaxInputs_E) //max input box allowed
			{
				FieldCount_E++; //text box added increment
				//add input box
				$(InputsWrapper_E).append('<table border="0" cellpadding="0" cellspacing="0" width="100%" id="ContactDetails_E"><tr><td width="150">Email Address '+ FieldCount_E +':</td><td><input type="text" name="txtcontacts_email_'+ FieldCount_E +'" id="txtcontacts_email_'+ FieldCount_E +'" value="Email Address '+ FieldCount_E +'" size="50" maxlength="50" /> <a href="#" class="removeclass">[&times;]</a></td></tr></table>');
				x_E++; //text box increment
			}
		return false;
		});

		$("body").on("click",".removeclass", function(e){ //user click on remove text
			if( x_E > 1 ) {
				//$(this).parent('table').remove(); //remove text box
				$("#ContactDetails_E").remove();
				x_E--; //decrement textbox
			}
			return false;
		})

	});

	
	$(document).ready(function() {
		$('input[type="radio"]').click(function() {
			// Add another Bluelight Co-Ordinator
			if($(this).attr("value")== "Y1") {
                $("#toggleCoOrdinator").show(1000);
            }
			else {
				 $("#toggleCoOrdinator").hide(1000);
            }

			// Add another Postal Address
			if($(this).attr("value")== "Y2") {
				 $("#togglePostalAddress").show(1000);
            }
			else {
				 $("#togglePostalAddress").hide(1000);
            }

			// Add another Phone No.
			if($(this).attr("value")== "Y3") {
				 $("#togglePhoneNo").show(1000);
            }
			else {
				 $("#togglePhoneNo").hide(1000);
            }

			// Add another Fax No.
			if($(this).attr("value")== "Y4") {
				 $("#toggleFaxNo").show(1000);
            }
			else {
				 $("#toggleFaxNo").hide(1000);
            }

			// Add another Email Address
			if($(this).attr("value")== "Y5") {
				 $("#toggleEmailAddress").show(1000);
            }
			else {
				 $("#toggleEmailAddress").hide(1000);
            }
		});
	});
	</script>
	<!--[if lt IE 9]>
		<script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE9.js"></script>
	<![endif]-->
</head>
<body>
<table width="1300" border="0" align="center" cellpadding="0" cellspacing="1" class="graybox">
<tr>
	<td colspan="2" align="right" bgcolor="#ffffff"><img src="<?php echo WEB_ROOT; ?>admin/include/banner-top.png" width="750" height="75"></td>
</tr>

<tr>
	<td width="250" valign="top" class="navArea">
	<!--/* start page */-->
	<div id="sidebar" class="sidebar1">
		<ul>
			<li><h2>Welcome <!--<%=strLogginName%>, </b>[<i><%=ShowAdmStatus%></i>]--></h2>
				<ul>
					<?php
					$MainNav = Array();
					$MainNav[] = Array('url' => '/php/web-ads/admin/', 'label' => 'HOME');
					$MainNav[] = Array('url' => '/php/web-ads/admin/product/', 'label' => 'LIST ALL ADS');
					$MainNav[] = Array('url' => '/php/web-ads/admin/category/', 'label' => 'CAMPAIGN');

					foreach($MainNav as $Nav)
					{
						if($Nav['url'] == $_SERVER['REQUEST_URI']) {
							$class = ' class="hover"';
						}
						
						else {
							$class = '';
						}

						echo "<li {$class}><a href=\"{$Nav['url']}\">{$Nav['label']}</a></li>\n";
					}
					
					
					
					/*
					if ($_SERVER['REQUEST_URI'] == "/php/web-ads/admin/") { echo '<li class="hover"><a href="/php/web-ads/admin/">Home</a></li>'."\n"; }
					else { echo '<li><a href="/php/web-ads/admin/">Home</a></li>'."\n"; }

					if ($_SERVER['REQUEST_URI'] == "/php/web-ads/admin/category") { 
						echo '<li class="hover"><a href="/php/web-ads/admin/category">Categories</a></li>'."\n"; 
					}
					else { 
						echo '<li><a href="/php/web-ads/admin/category">Categories</a></li>'."\n"; 
					}
					*/
					?>
					<li>LIST ALL ADS BY LOCATION <br />
						<div class="styled-select">
							<?php whichLocation(); ?>
						</div>
					</li>
					<li>LEADERBOARD BANNERS <br />
						<div class="styled-select">
							<?php whichBanner("1"); ?>
						</div>
					</li>
					<li><a href="/php/web-ads/admin/upload/leaderboard.php">Upload LEADERBOARD BANNERS</a></li>
					
					<li>MEDIUM REC BANNERS <br />
						<div class="styled-select">
							<?php whichBanner("2"); ?>
						</div>
					</li>
					<li><a href="/php/web-ads/admin/upload/mediumrec.php">Upload MEDIUM REC BANNERS</a></li>

					<li>SKYSCRAPER BANNERS <br />
						<div class="styled-select">
							<?php whichBanner("3"); ?>
						</div>
					</li>
					<li><a href="/php/web-ads/admin/upload/skyscraper.php">Upload SKYSCRAPER BANNERS</a></li>

					<li>LISTINGS <br />
						<div class="styled-select">
							<?php whichBanner("4"); ?>
						</div>
					</li>

					<li>BLUE LIGHT BRANCH CONTACT DETAILS <br />
						<div class="styled-select">
							<?php whichState(); ?>
						</div>
					</li>
					<?php 
					if ($_SERVER['REQUEST_URI'] == "/php/web-ads/admin/user/") { echo '<li class="hover"><a href="/php/web-ads/admin/user">USERS</a></li>'."\n"; }
					else { echo '<li><a href="/php/web-ads/admin/user/">USERS</a></li>'."\n"; }
					?>
					<li><a href="/php/web-ads/admin/product/index.php?logout">LOGOUT</a></li>
				</ul>
			</li>
		</ul>
	</div>
	</td>
    <td width="1150" valign="top" class="contentArea">
		<table width="100%" border="0" cellspacing="0" cellpadding="20">
		<tr>
			<td><?php require_once $content; ?></td>
		</tr>
		</table>
	</td>
</tr>
</table>
<p>&nbsp;</p>
<p class="copyright">Copyright &copy; <?php echo date('Y'); ?> <a href="http://www.cwaustral.com.au">Countrywide Austral Pty Ltd</a></p>
</body>
</html>
