<?php
$valid_months = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
if(isset($_REQUEST["m"]) && in_array(ucwords($_REQUEST["m"]), $valid_months) && isset($_REQUEST["d"])){
//month and day provided in query string (false directories)
	$today_month = ucfirst($_REQUEST["m"]);
	if($_REQUEST["d"] > 1 && $_REQUEST["d"] < 32){
		$today_day = (int)$_REQUEST["d"];
	} else {
		$today_day = 1;
	}
}
elseif(isset($_REQUEST["m"]) && in_array(ucwords($_REQUEST["m"]), $valid_months)) {
//only month is provided, show montly activites
	$today_month = ucfirst($_REQUEST["m"]);
	$today_day = "Monthly Activities";
}
else {
//else no query string provided, use todays date
	$today_month = ucfirst(date("F", time()));
	$today_day = date("j",time());
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="imagetoolbar" content="false" />
<meta name="copyright" content="2015 (c) Library of Virginia" />
<meta name="robots" content="index, follow" />
<link rel="shortcut icon" href="/img/va.ico" type="image/x-icon" />
<link rel="home" title="home" href="http://daybydayva.org/" />
<title><?php echo $today_month . " " . $today_day; ?> | Day By Day Family-Literacy Calendar</title>
<meta content="Library of Virginia" name="Owner" />
<meta content="Day by Day reading program" name="Description" />
<meta content="day by day reading program" name="Keywords" />
<link href='http://fonts.googleapis.com/css?family=Gorditas' rel='stylesheet' type='text/css'>
<link rel="stylesheet" type="text/css" media="screen" href="/daybyday.css" />
</head>
<body class="<?php echo $today_month . "_page day_" . $today_day;?>">
<?php
	$xml = simplexml_load_file(strtolower($today_month.".xml"));
	foreach ($xml->channel->item as $it3m) {
      if ($it3m->title == $today_month . " " . $today_day) {
		 print_out($it3m->title,$it3m->description,$today_month);
      }
	} 
?>
<?php include($_SERVER["DOCUMENT_ROOT"] . "/footer.php"); ?>
<?php
function print_out($t,$desc,$month) {
  echo '<div id="top_wrap">' . "\n";
  echo '<div class="moduletable_menuhead">';
  echo '<h3>Try a different month:</h3>';
  echo '<ul id="head_nav" class="menu"><li class="item387"><a href="/January/01"><span>January</span></a></li><li class="item388"><a href="/February/01"><span>February</span></a></li><li class="item389"><a href="/March/01"><span>March</span></a></li><li class="item390"><a href="/April/01"><span>April</span></a></li><li class="item391"><a href="/May/01"><span>May</span></a></li><li class="item392"><a href="/June/01"><span>June</span></a></li><li class="item393"><a href="/July/01"><span>July</span></a></li><li class="item394"><a href="/August/01"><span>August</span></a></li><li class="item395"><a href="/September/01"><span>September</span></a></li><li class="item396"><a href="/October/01"><span>October</span></a></li><li class="item397"><a href="/November/01"><span>November</span></a></li><li class="item398"><a href="/December/01"><span>December</span></a></li></ul>		</div>';
  echo '<div id="head_logos">';
  echo '<h1><a href="/">';
  echo '<img src="/img/logo.png" alt="Day by Day Family Literacy Calendar" class="logo"></a>';
  echo '<span class="month_button"><a href="/' . $month . '/">Monthly Activities</a></span>' . $month . '</h1>';
  echo '</div>';
  echo '<div id="subnav">';
  echo '<div class="moduletable_days">';
  echo '<ul class="menu">';
  $numofdays = cal_days_in_month(CAL_GREGORIAN, date("n", strtotime($month)), date("Y"));
  for ($i = 1; $i <= $numofdays; $i++) {
    echo '<li><a class="nav_' . $i . '" href="/' . $month . '/' . str_pad($i,2,"0",STR_PAD_LEFT) . '"><span>' . $i . '</span></a></li>';
  }
  echo '</ul></div>';
  echo '</div>';
  echo '<div id="content_container">';
  echo '<table class="contentpaneopen">';
  echo '<tbody><tr>';
  echo '<td width="100%" class="contentheading">' . $t . '</td>';
  echo '</tr>';
  echo '</tbody></table>';
  echo '<table class="contentpaneopen">';
  echo '<tbody><tr>';
  echo '<td valign="top">';
  echo $desc;
  echo '</td>';
  echo '</tr>';
  echo '</tbody></table>';
  echo '</div>';
  echo '</div>';
}
?>