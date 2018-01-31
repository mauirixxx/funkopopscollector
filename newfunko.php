<?php
$pagetitle = "Enter New Funko Pop";
include_once ('header.php');
//$insfunko = (isset($_POST['insertfunko']) ? $_POST['insertfunko'] : null);
$insfunko = mysqli_real_escape_string($con, $_POST['insertfunko']);
if (isset($_SESSION['userid'])){
	echo '<BODY onLoad="document.funkodata.popno.focus()">';
	if ($insfunko == 1){
		$popno = mysqli_real_escape_string($con, $_POST['popno']);
		$popname = mysqli_real_escape_string($con, $_POST['popname']);
		$popdate = mysqli_real_escape_string($con, $_POST['todaysdate']);
		$popcollectionid = mysqli_real_escape_string($con, $_POST['popcollectionid']);
		list ($y, $m, $d) = explode('-', $popdate);
		if (!checkdate($m, $d, $y)) {
			echo 'Date is invalid ' . $popdate . '<BR />';
			echo 'Date format is YYYY-MM-DD / 1977-06-07<BR />';
			echo 'Please click <A HREF="newfunko.php" CLASS="navlink">HERE</A> to try again';
			echo '<BR /><BR />Return to <A HREF="index.php" CLASS="navlink">home</A>.</CENTER></BODY></HTML>';
			include_once ('footer.php');
			exit();
		}
		$sqlfunkins = "INSERT INTO funkopops.pops (userid, popno, popname, popcollectionid, inserteddate) VALUES ($userid, $popno, '$popname', $popcollectionid, '$popdate')";
		if (!$funkoinsert = $con->query($sqlfunkins)){
			die ('There was an error running the query [' . $con->error . ']');
		}
		echo 'You have successfully entered ' . $popname . ' into the database!<BR />';
		echo 'Refreshing page in 2 seconds to add another pop to your collection!<BR />';
		header("refresh:2;url=newfunko.php");
	} else {
		echo '<TABLE BORDER="0">';
		echo '<FORM METHOD="POST" ACTION="newfunko.php" NAME="funkodata"><TR><TD>Pop Number: <INPUT TYPE="NUMBER" NAME="popno" MIN="1" MAX="9999" SIZE="5"></TD></TR>';
		echo '<TR><TD>Pop Name: <INPUT TYPE="TEXT" NAME="popname" SIZE="40"></TD></TR>';
		$sqlpopcollection = "SELECT * FROM popcollection ORDER BY popcollection ASC";
		if (!$results = $con->query($sqlpopcollection)){
			die ('There was an error running the query [' . $con->error . ']');
		}
		echo '<TR><TD>Pop Collection: <SELECT NAME="popcollectionid">';
		while ($row = $results->fetch_array()){
			$pcid = $row['popcollectionid'];
			$pcname = $row['popcollection'];
			echo '<OPTION VALUE="' . $pcid . '">' . $pcname . '</OPTION>';
		}
		echo '</TD></TR>';
		echo '<TR><TD>Date Purchased: <INPUT NAME="todaysdate" TYPE="DATE" PLACEHOLDER="1977-06-07" VALUE="' . date('Y-m-d') . '"></TD></TR>';
		echo '<TR><TD><INPUT TYPE="HIDDEN" NAME="insertfunko" VALUE="1"><INPUT TYPE="SUBMIT" VALUE="Add Pop to Database"></FORM></TD></TR></TABLE>';
	}
} else {
	echo 'Please login <A HREF="index.php" CLASS="navlink">HERE</A> before continuing.';
}
include_once ('footer.php');
?>