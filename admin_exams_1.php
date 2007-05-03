<?
//*
// admin_exams_1.php
// Admin Section
// Display and handle exams
// v1.0 April 19, 2007
//*

//Check if admin is logged in
session_start();
if(!session_is_registered('UserId') || $_SESSION['UserType'] != "A")
  {
    header ("Location: index.php?action=notauth");
	exit;
}

//Include global functions
include_once "common.php";
//Initiate database functions
include_once "ez_sql.php";
//Include paging class
include_once "ez_results.php";
// config
include_once "configuration.php";

//Get current year
$cyear=$_SESSION['CurrentYear'];
$year=$db->get_var("SELECT school_years_desc FROM school_years WHERE school_years_id=$cyear");

//Get action
$action=get_param("action");

$schoolid=get_param("schoolid");
$roomid=get_param("roomid");
$examdate=date("Y-m-d", strtotime(get_param("examdate")));
$subjectid=get_param("typeid");
$typeid=get_param("typeid");

if (!strlen($action))
        $action="none";
	
//Get list of school names
$sSQL="SELECT * FROM school_names ORDER BY school_names_id";
$schoolnames=$db->get_results($sSQL);
//Get list of rooms
$sSQL="SELECT * FROM school_rooms ORDER BY school_rooms_id";
$schoolrooms=$db->get_results($sSQL);
//get list of subjects
$sSQL="SELECT * FROM grade_subjects ORDER BY grade_subject_id";
$subjectcodes=$db->get_results($sSQL);
//get list of exam types
$sSQL="SELECT * FROM exams_types ORDER BY exams_types_id ASC";
$examstypes=$db->get_results($sSQL);

if ($action=="remove") {
	$id_to_delete = get_param("examid");
	$sSQL="DELETE FROM exams WHERE exams_id=$id_to_delete";
	$db->query($sSQL);
}

//Get current listing of exams
$sSQL="SELECT school_names_desc, school_rooms_desc, DATE_FORMAT(exams_date,'" . _EXAMS_DATE . "') as examdate, 
grade_subject_desc, exams_types_desc, exams_id, days_desc, exams_date 
FROM (((((exams 
INNER JOIN school_names ON exams_schoolid=school_names_id) 
INNER JOIN school_rooms ON exams_roomid=school_rooms_id) 
INNER JOIN grade_subjects ON exams_subjectid=grade_subject_id) 
INNER JOIN exams_types ON exams_typeid=exams_types_id) 
INNER JOIN tbl_days ON WEEKDAY(exams_date)+1 = days_id) 
WHERE exams_year=$cyear 
ORDER BY school_names_desc, school_rooms_desc, exams_date";
// echo $sSQL;

//Set paging appearence
$ezr->results_open = "<table width=80% cellpadding=2 cellspacing=0 border=1>";
$ezr->results_heading = "<tr class=tblhead>
<td width=10%>" . _ADMIN_EXAMS_1_ROOM . "</td>
<td width=20%>" . _ADMIN_EXAMS_1_DATE . "</td>
<td width=20%>" . _ADMIN_EXAMS_1_SUBJECT . "</td>
<td width=20%>" . _ADMIN_EXAMS_1_TYPE . "</td>
<td width=15%>&nbsp;</td>
<td width=15%>&nbsp;</td>
</tr>"; 
$ezr->results_close = "</table>";
$ezr->results_row = "<tr>
<td class=paging width=10% align=center>COL2</td>
<td class=paging width=20% align=center>COL3 (COL7)</td>
<td class=paging width=20% align=center>COL4</td>
<td class=paging width=20% align=center>COL5</td>
<td class=paging width=15% align=center>
  <a href=admin_exams_2.php?examid=COL6 class=aform>&nbsp;" . _ADMIN_EXAMS_1_DETAILS . "</a></td>
<td class=paging width=15% align=center>
  <a name=href_remove href=#  onclick=cnfremove(COL6); class=aform>&nbsp;" . _ADMIN_EXAMS_1_REMOVE. "</a></td>
</tr>";

$ezr->query_mysql($sSQL);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<title><? echo _BROWSER_TITLE?></title>
<style type="text/css" media="all">@import "student.css";</style>
<link rel="icon" href="favicon.ico" type="image/x-icon"><link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<SCRIPT>
/* Javascript function to ask confirmation before removing record */
function cnfremove(id) {
        var answer;
	answer = window.confirm("<? echo _ADMIN_ROOMS_SURE?>");
	if (answer == 1) {
	var url;
	url = "admin_exams_1?action=remove&examid=" + id;
	window.location = url; // other browsers
	href_remove.href = url; // explorer
	}
	return false;
	}
</SCRIPT>

<script type="text/javascript" language="JavaScript" src="sms.js"></script>
</head>

<body><img src="images/<? echo _LOGO?>" border="0">

<div id="Header">
<table width="100%">
  <tr>
    <td width="50%" align="left"><font size="2">&nbsp;&nbsp;<? echo date(_DATE_FORMAT); ?></font></td>
    <td width="50%"><? echo _ADMIN_EXAMS_1_UPPER?></td>
  </tr>
</table>
</div>

<div id="Content">
        <?
	if(!strlen($msgFormErr)){
	?>
	<h1><? echo _ADMIN_EXAMS_1_TITLE?></h1>
	<br>
	<?
	$ezr->display();
	?>
	<br>
	<table border="0" cellpadding="0" cellspacing="0" width="80%">
          <tr>
	    <td width="50%">&nbsp;</td>
	    <td width="50%" align="right"><a
	    href="admin_exams_3.php?action=new" class="aform"><? echo _ADMIN_EXAMS_1_ADD?></a></td>
	</tr>
	</table>
        <?
	}else{
	?>
	<h1><? echo _ERROR?></h1>
        <br>
        <h3><? echo $msgFormErr; ?></h3>
	<br>
	<?
	}
	?>
</div>
<? include "admin_menu.inc.php"; ?>
</body>

</html>
