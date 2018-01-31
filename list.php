<?php
$pagetitle = "Funko Pop Complete List";
include_once ('header.php');
if (isset($_SESSION['userid'])){
	$sql = "SELECT * FROM (pops INNER JOIN popcollection ON pops.popcollectionid = popcollection.popcollectionid) WHERE `userid` = $userid ORDER BY `popcollection`, `popno`, `inserteddate` ASC";
	$sqlcount = "SELECT COUNT(*) FROM (pops INNER JOIN popcollection ON pops.popcollectionid = popcollection.popcollectionid) WHERE `userid` = $userid";
	if (!$result = $con->query($sql)){
		die ('There was an error running the query [' . $con->error . ']');
	}
	$count = mysqli_query($con, $sqlcount);
	$row3 = mysqli_fetch_array($count);
	if ($row3[0] <> 1) {
		echo 'You have <B>' . $row3[0] . '</B> Funko Pops!<BR />Click the Pop # to edit the data<BR />';
	} else {
		echo 'You have ' . $row3[0] . ' Funko Pop - go buy some more, it\s lonely!<BR />Click the Pop # to edit the data<BR />';
	}
	echo '<TABLE BORDER="0">';
	echo '<TR><TD>Pop #</TD><TD>Pop Name</TD><TD>Date Added</TD><TD>Pop Collection</TD></TR>';
	if (mysqli_num_rows($result) > 0) {
		while ($row = $result->fetch_array()){
			echo '<TR><TD><A HREF="edit.php?id=' . $row['funkoid'] . '">' . $row['popno'] . '</A></TD><TD>' . $row['popname'] . '</TD><TD>' . $row['inserteddate'] . '</TD><TD>' . $row['popcollection'] . '</TD></TR>';
		}
	}
	echo '</TABLE>';
}
include_once ('footer.php');
?>