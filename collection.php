<?php
$pagetitle = "Add Collection";
include_once ('header.php');
if (isset($userid)){
	echo '<BODY onLoad="document.fpcform.collection.focus()">';
	$fpcname = (isset($_POST['collection']) ? $_POST['collection'] : null);
	$fpcname = mysqli_real_escape_string($con, $fpcname);
	$sqlfpcname = "INSERT INTO funkopops.popcollection (popcollection) VALUES ('$fpcname')";
	if (!empty($fpcname)) {
		if (!$result = $con->query($sqlfpcname)){
			die ('There was an error running the query [' . $con->error . ']');
		}
		echo 'You have successfully entered ' . $fpcname . ' into the database!<BR />';
		echo 'Refreshing page in 2 seconds to add another pop collection group.<BR />';
		header("refresh:2;url=collection.php");
	} else {
		echo '<TABLE BORDER="0">';
		echo '<FORM METHOD="POST" ACTION="collection.php" NAME="fpcform"><TR><TD>Collection Name: <INPUT TYPE="TEXT" NAME="collection" SIZE="25"></TD></TR>';
		echo '<TR><TD><CENTER><INPUT TYPE="SUBMIT" VALUE="Add Group to Database"></CENTER></FORM></TD></TR></TABLE>';
		echo '<BR />';
		echo 'Here\'s the existing groups: <SELECT>';
		$sqlgrouplist = "SELECT * FROM funkopops.popcollection ORDER BY popcollection ASC";
		if (!$result = $con->query($sqlgrouplist)){
			die ('There was an error running the query [' . $con->error . ']');
		}
		while ($row = $result->fetch_array()){
			$groupname = $row['popcollection'];
			echo '<OPTION VALUE="' . $groupname . '">' . $groupname . '</OPTION>';
		}
		echo '</SELECT><BR /><BR /> ';
	}
}
include_once ('footer.php');
?>