<!DOCTYPE html>
<HTML>
<HEAD>
<link rel="stylesheet" type="text/css" href="style.css">
<?php
session_start();
$uname = (isset($_SESSION['username']) ? $_SESSION['username'] : null);
$userid = (isset($_SESSION['userid']) ? $_SESSION['userid'] : null);
include_once ('connect.php');
$con = @new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);
if ($con->connect_errno){
	die ('Unable to connect to database [' . $db->connect_errno . ']');
}
if (!$userid){
	echo '<TITLE>Please login first</TITLE></HEAD><BODY>';
	echo '<CENTER><FORM ACTION="login.php" METHOD="POST">Username:<INPUT TYPE="TEXT" NAME="username" SIZE="20"><BR />';
	echo 'Password:<INPUT TYPE="PASSWORD" NAME="password" SIZE="20"><BR />';
	echo '<INPUT TYPE="SUBMIT" VALUE="Login ..."></FORM></CENTER>';
} else {
	echo '<TITLE>' . $pagetitle . '</TITLE></HEAD><BODY><CENTER>';
	echo '(<A HREF="index.php" CLASS="navlink">Home</A>) (<A HREF="search.php" CLASS="navlink">SEARCH</A>) (<A HREF="logout.php?action=logout" CLASS="navlink">Logout ' . $uname . '</A>)<HR><BR / >';
}
?>