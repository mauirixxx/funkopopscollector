<?php
$pagetitle = "Funko Pop Search";
include_once ('header.php');
if (isset($_SESSION['userid']) && ($_SESSION['username'])) {
	echo '<BODY onLoad="document.funkosearch.searchname.focus()">';
	$searchtype = (isset($_POST['stype']) ? $_POST['stype'] : null);
	$searchtype = mysqli_real_escape_string($con, $searchtype);
	$searchname = (isset($_POST['searchname']) ? $_POST['searchname'] : null);
	$searchname = mysqli_real_escape_string($con, $searchname);
	$searchcollection = (isset($_POST['collectionid']) ? $_POST['collectionid'] : $_GET[cid']);
	$searchcollection = mysqli_real_escape_string($con, $searchcollection);
	if (!empty($searchname) || !empty($searchcollection)) {
		if ($searchtype == "name") {
			$sqlsearch = "SELECT * FROM (pops INNER JOIN popcollection ON pops.popcollectionid = popcollection.popcollectionid) WHERE `popname` LIKE '%$searchname%' AND `userid` = $userid ORDER BY popcollection.popcollection, pops.popno ASC";
			$sqlcount = "SELECT COUNT(*) as count FROM (pops INNER JOIN popcollection ON pops.popcollectionid = popcollection.popcollectionid) WHERE `popname` LIKE '%$searchname%' AND `userid` = $userid";
		} else if ($searchtype == "group") {
			$sqlsearch = "SELECT * FROM (pops INNER JOIN popcollection ON pops.popcollectionid = popcollection.popcollectionid) WHERE `pops`.`popcollectionid` = $searchcollection AND `userid` = $userid ORDER BY popno ASC";
			$sqlcount = "SELECT COUNT(*) as count FROM (pops INNER JOIN popcollection ON pops.popcollectionid = popcollection.popcollectionid) WHERE `pops`.`popcollectionid` = $searchcollection AND `userid` = $userid";
		} else {
			echo 'No search type defined, please try again!';
			include_once ('footer.php');
			exit();
		}
		if (!$result = $con->query($sqlsearch)){
			die ('There was an error running the query [' . $con->error . ']');
		}
		$count = mysqli_query($con, $sqlcount);
		$row3 = mysqli_fetch_array($count);
		if ($row3['count'] > 1) {
			echo 'There are ' . $row3['count'] . ' Funko Pops in the search results<BR />Click the Pop # to edit the data<BR />';
		} else {
			echo 'There is ' . $row3['count'] . ' Funko Pop in the search results<BR />Click the Pop # to edit the data<BR />';
		}
		echo '<TABLE BORDER="0">';
		echo '<TR><TD>Pop #</TD><TD>Pop Name</TD><TD>Date Added</TD><TD>Pop Collection</TD></TR>';
		if (mysqli_num_rows($result) > 0) {
			while ($row = $result->fetch_array()){
				echo '<TR><TD><A HREF="edit.php?id=' . $row['funkoid'] . '">' . $row['popno'] . '</A></TD><TD>' . $row['popname'] . '</TD><TD>' . $row['inserteddate'] . '</TD><TD>' . $row['popcollection'] . '</TD></TR>';
			}
		} else {
			echo 'No results found!<BR />';
		}
		echo '</TABLE><BR />Click <A HREF="search.php" CLASS="navlink">here</A> to search again.<BR />';
	} else {
		echo 'Please search for a Funko Pop name! <BR />';
		echo '<FORM ACTION="search.php" METHOD="POST" NAME="funkosearch">Funko Pop name to search for: <INPUT TYPE="TEXT" NAME="searchname" SIZE="30"><BR /><BR />';
		//echo 'Funko Pop number to search for: <INPUT TYPE="NUMBER" NAME="searchno" MIN="1" MAX="9999"><BR />';
		echo '<INPUT TYPE="HIDDEN" NAME="stype" VALUE="name"><INPUT TYPE="SUBMIT" VALUE="Search for a Pop"></FORM><BR /><BR />';
		$sqlfpc = "SELECT DISTINCT `popcollection`.`popcollectionid`, `popcollection`.`popcollection` FROM (popcollection INNER JOIN pops ON popcollection.popcollectionid = pops.popcollectionid) WHERE `pops`.`userid` = $userid ORDER BY popcollection.popcollection ASC";
		if (!$result2 = $con->query($sqlfpc)){
			die ('There was an error running the query [' . $con->error . ']');
		}
		echo 'Or find all Funko Pops by collection: <FORM ACTION="search.php" METHOD="POST"><SELECT NAME="collectionid">';
		while ($row2 = $result2->fetch_array()){
			$pcid = $row2['popcollectionid'];
			$pcname = $row2['popcollection'];
			echo '<OPTION VALUE="' . $pcid . '">' . $pcname . '</OPTION>';
		}
		echo '</SELECT><INPUT TYPE="HIDDEN" NAME="stype" VALUE="group"><INPUT TYPE="SUBMIT" VALUE="List group"></FORM>';
	}
}
include_once ('footer.php');
?>