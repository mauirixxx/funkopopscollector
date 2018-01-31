<!DOCTYPE html>
<HTML>
<HEAD>
<link rel="stylesheet" type="text/css" href="style.css">
<TITLE>Logging in</TITLE>
</HEAD>
<BODY>
<CENTER>
<?php
include_once ('connect.php');
$con = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);
session_start();
$username = mysqli_real_escape_string($con, $_POST['username']);
$password = mysqli_real_escape_string($con, $_POST['password']);
$password = sha1($password);
if ($con->connect_errno > 0){
	die ('Unable to connect to database [' . $db->connect_errno . ']');
}
$sqllogin = "SELECT * FROM users WHERE users.username = '$username' and passwd = '$password'";
if ($result = $con->query($sqllogin)){
	$row_cnt = mysqli_num_rows($result);
	if ($row_cnt > 0){
		while ($row = $result->fetch_array()){
			$uname = $row['username'];
			$uid = $row['userid'];
			$_SESSION['username'] = $uname;
			$_SESSION['userid'] = $uid;
		}
		header("refresh:1;url=index.php");
		echo 'You have successfully logged in ...<BR />Returning to index in a few seconds</CENTER>';
	} else {
		echo 'That was not a valid username or password!<BR /><BR />';
		echo 'Please try again <A HREF="index.php" CLASS="navlink">here</A></CENTER>';
	}
}
include_once ('footer.php');
?>