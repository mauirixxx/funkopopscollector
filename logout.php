<?php
$pagetitle = "Logging Out";
include_once ('header.php');
$logout = $_GET['action'];
if ($logout == "logout"){
	session_unset();
	session_destroy();
	header("refresh:2;url=index.php");
	echo '<CENTER>You have been logged out ...<BR />Returning to login screen in a few seconds</CENTER>';
} else if (isset($_POST['logout'])){
	session_unset();
	session_destroy();
	header("refresh:2;url=index.php");
	echo '<CENTER>You have been logged out ...<BR />Returning to login screen in a few seconds</CENTER>';
} else {
	echo '<CENTER>Something went wrong, you haven\'t been logged out!<BR /><BR />Please click <A HREF="logout.php" CLASS="navlink">HERE</A> to try again</CENTER>';
}
include_once ('footer.php');
?>