<?
//*
// admin_users_1.php
// Admin Section
// Form to remove contacts from the web users table
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
// config
include_once "configuration.php";

$q = "select * from school_names";
$schools = $db->get_results($q);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<title><? echo _BROWSER_TITLE?></title>
<style type="text/css" media="all">@import "student.css";</style>
<SCRIPT language="JavaScript">
/* Javascript function to check if field is empty */
function submitform(fldName, frmNumb)
{
  var f = document.forms[frmNumb];
  var t = f.elements[fldName]; 
  if (t.value!="") 
	return true;
  else
	alert("<? echo _ENTER_VALUE?>");
	return false;
}

</script>
<link rel="icon" href="favicon.ico" type="image/x-icon"><link rel="shortcut icon" href="favicon.ico" type="image/x-icon">

<script type="text/javascript" language="JavaScript" src="sms.js"></script>
</head>

<body><img src="images/<? echo _LOGO?>" border="0">

<div id="Header">
<table width="100%">
  <tr>
    <td width="50%" align="left"><font size="2">&nbsp;&nbsp;<? echo date(_DATE_FORMAT); ?></font></td>
    <td width="50%"><? echo _ADMIN_USERS_1_ADMIN_AREA?></td>
  </tr>
</table>
</div>

<div id="Content">
	<h1><? echo _ADMIN_USERS_1_TITLE?></h1>
	<br>
<!-- We're removing this aren't we?
<a href="admin_add_edit_teacher_1.php?action=new" class="ahead">Add New Teacher</a>-->
	<br>
	<h2><? echo _ADMIN_USERS_1_SUBTITLE1?></h2>
	<br>
	<table border="0" cellpadding="1" cellspacing="1" width="100%">
	  <tr>
	    <td width="100%" height="45">
	      <table border="1" cellpadding="0" cellspacing="0" width="100%">
	        <tr class="trform">
	          <td width="50%" colspan="1">&nbsp;<? echo _ADMIN_USERS_1_BY_SCHOOL?></td>
	          <td width="50%" colspan="1">&nbsp;<? echo _ADMIN_USERS_1_BY_LASTNAME?></td>
		    </tr>
	        <tr>
		  <form name="srchid" method="POST" action="admin_teacher_2.php">
		  <td width="50%" class="tdinput">
		  <select size="1" name="school">
			   <option value="" selected=selected><? echo _ADMIN_USERS_1_ALL_SCHOOLS?></option>
				   <?
				   //Display Schools from table
				   foreach($schools as $school){
				   ?>
                    <option value="<? echo $school->school_names_id; ?>"><? echo $school->school_names_desc; ?></option>
				   <?
				   };
				   ?>
                  </select>
				<input type="submit" value="<? echo _ADMIN_USERS_1_SEARCH?>" name="submit" class="frmbut">
			   <input type="hidden" name="action" value="srchschool">
	          </td>
		  </form>
		  <form name="srchlname" method="POST" action="admin_teacher_2.php" onsubmit="return submitform('tlname', 1);">
		      <td width="50%" class="tdinput">
		        <input type="text" onChange="capitalizeMe(this)" name="tlname" size="25"><input type="submit" value="<? echo _ADMIN_USERS_1_SEARCH?>" name="submit" class="frmbut">
			    <input type="hidden" name="action" value="srchlname">
	          </td>
		  </form>
			    </tr>
	      </table>
	    </td>
	  </tr>
	  <tr>
	    <td width="100%">
	      <table border="1" cellpadding="0" cellspacing="0" width="100%">
		    <tr class="trform">
	          <td width="100%" colspan="4">&nbsp;<? echo _ADMIN_USERS_1_BY_LAST?></td>
	        </tr>
			<tr>
				<td width="100%" align="center">
				<?
				for($letters = 'A'; $letters != 'AA'; $letters++)
				{
				    echo "<a href='admin_webusers_teachers.php?action=letter&letter=$letters' class='aform'>$letters</a> &nbsp;";
				}
				?> 
				</td>
			</tr>
		</table>
	  </td>
	</tr>
	</table>
	<br /><br />
	<?php
		$q = "select * from web_users where web_users_type='C'";
		$info = $db->get_results($q);
//		print_r($info);
	?>
	<h2><? echo _ADMIN_USERS_1_SUBTITLE2?></h2>
	<br>
	<table border="0" cellpadding="1" cellspacing="1" width="100%">
	  <tr>
	    <td width="100%" height="45">
	      <table border="1" cellpadding="0" cellspacing="0" width="100%">
	        <tr class="trform">
	          <td width="50%" colspan="1">&nbsp;<? echo _ADMIN_USERS_1_BY_LIST?></td>
	          <td width="50%" colspan="1">&nbsp;<? echo _ADMIN_USERS_1_BY_LASTNAME?></td>
		    </tr>
	        <tr>
			   <form name="srchid" method="POST" action="admin_contact_2.php">
		       <td width="50%" class="tdinput">
			    <select size="1" name="contact">
				   <option value="" selected=selected><? echo _ADMIN_USERS_1_ALL_CONTACTS?></option>
				   <?
				   //Display Schools from table
				   foreach($info as $info1){
				   ?>
                    <option value="<? echo $info1->web_users_relid; ?>"><? echo $info1->web_users_flname; ?></option>
				   <?
				   };
				   ?>
                </select>
				<input type="submit" value="<? echo _ADMIN_USERS_1_SEARCH?>" name="submit" class="frmbut">
			   <input type="hidden" name="action" value="searchcontacts">
	          </td>
			  </form>
			  <form name="srchlname" method="POST" action="admin_contact_2.php" onsubmit="return submitform('tlname', 1);">
		      <td width="50%" class="tdinput">
		        <input type="text" onChange="capitalizeMe(this)" name="tlname" size="25"><input type="submit" value="<? echo _ADMIN_USERS_1_SEARCH?>" name="submit" class="frmbut">
			    <input type="hidden" name="action" value="srchlname">
	          </td>
				</form>
			    </tr>
	      </table>
	    </td>
	  </tr>
	  <tr>
	    <td width="100%">
	      <table border="1" cellpadding="0" cellspacing="0" width="100%">
		    <tr class="trform">
	          <td width="100%" colspan="4">&nbsp;<? echo _ADMIN_USERS_1_BY_LAST?></td>
	        </tr>
			<tr>
				<td width="100%" align="center">
				<?
				for($letters = 'A'; $letters != 'AA'; $letters++)
				{
				    echo "<a href='admin_webusers_contacts.php?action=letter&letter=$letters' class='aform'>$letters</a> &nbsp;";
				}
				?> 
				</td>
			</tr>
		</table>
	  </td>
	</tr>
	</table>
</div>
<? include "admin_menu.inc.php"; ?>
</body>

</html>
