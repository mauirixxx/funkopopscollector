</CENTER>
<?php
if (isset($_SESSION['userid']) && ($_SESSION['username'])) {
	echo '<BR /><BR /><CENTER><FORM METHOD="POST" ACTION="logout.php"><INPUT TYPE="HIDDEN" NAME="logout"><INPUT TYPE="SUBMIT" VALUE="Logout"></FORM></CENTER>';
}
?>
</BODY>
</HTML>