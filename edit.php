<?php
$pagetitle = "Edit Funko Pop";
include_once ('header.php');
$editid = mysqli_real_escape_string($con, $_GET['id']);
$updatepop = (isset($_POST['update']) ? $_POST['update'] : null);
$updatepop = mysqli_real_escape_string($con, $updatepop);
if (isset($_SESSION['userid']) && ($_SESSION['username'])) {
    if ($updatepop == "yes") {
        $fid = mysqli_real_escape_string($con, $_POST['funkoid']);
        $fuid = mysqli_real_escape_string($con, $_POST['userid']);
        $fno = mysqli_real_escape_string($con, $_POST['popno']);
        $fname = mysqli_real_escape_string($con, $_POST['popname']);
        $fpcid = mysqli_real_escape_string($con, $_POST['popcollectionid']);
        $fdate = mysqli_real_escape_string($con, $_POST['inserteddate']);
        list ($y, $m, $d) = explode('-', $fdate);
        if (!checkdate($m, $d, $y)) {
            echo 'Date is invalid ' . $fdate . '<BR />';
            echo 'Date format is YYYY-MM-DD / 1977-06-07<BR />';
            echo 'Please click <A HREF="edit.php?id=' . $fid . '" CLASS="navlink">HERE</A> to try again';
            include_once ('footer.php');
            exit();
        }
        $sqlupdate = "UPDATE `pops` SET `popno` = $fno, `popname` = '$fname', `popcollectionid` = $fpcid, `inserteddate` = '$fdate' WHERE `funkoid` = $fid AND `userid` = $userid";
        if (!$result = $con->query($sqlupdate)){
            die ('There was an error running the query [' . $con->error . ']');
        }
        echo $fname . ' info successfully updated, returning to editor.';
        header("refresh:2;url=edit.php?id=$fid");
        include_once ('footer.php');
        exit();
    } else {
        echo 'Editing data <BR />';
        if (!$editid == "") {
            $sqlfind = "SELECT * FROM (pops INNER JOIN popcollection ON pops.popcollectionid = popcollection.popcollectionid) WHERE `funkoid` = $editid AND `userid` = $userid";
            if (!$result = $con->query($sqlfind)){
                die ('There was an error running the query [' . $con->error . ']');
            }
            echo '<FORM METHOD="POST" ACTION="edit.php"><TABLE BORDER="1"><TR><TD>Pop No</TD><TD>Pop Name</TD><TD>Purchase Date</TD><TD>Pop Collection</TD></TR>';
            while ($row = $result->fetch_array()){
                $fid = $row['funkoid'];
                $fuid = $row['userid'];
                $fno = $row['popno'];
                $fname = $row['popname'];
                $fpcid = $row['popcollectionid'];
                $fdate = $row['inserteddate'];
                $fcollection = $row['popcollection'];
                $_SESSION['popno'] = $fno;
                $_SESSION['popname'] = $fname;
                echo '<TR><TD><INPUT TYPE="HIDDEN" NAME="funkoid" VALUE="' . $fid . '"><INPUT TYPE="HIDDEN" NAME="userid" VALUE="' . $fuid . '">';
                echo '<INPUT TYPE="NUMBER" NAME="popno" SIZE="4" MIN="1" MAX="9999" VALUE="' . $fno . '"></TD><TD><INPUT SIZE="75" TYPE="TEXT" NAME="popname" VALUE="' . $fname . '"></TD>';
                echo '<TD><INPUT TYPE="DATE" NAME="inserteddate" VALUE="' . $fdate . '"></TD><TD><SELECT NAME="popcollectionid"><OPTION VALUE="' . $fpcid . '">' . $fcollection . '</OPTION>';
                $sqlfpc = "SELECT * FROM popcollection ORDER BY popcollection ASC";
                if (!$result2 = $con->query($sqlfpc)){
                    die ('There was an error running the query [' . $con->error . ']');
                }
                while ($row2 = $result2->fetch_array()){
                    $fpcid2 = $row2['popcollectionid'];
                    $fcollection2 = $row2['popcollection'];
                    echo '<OPTION VALUE="' . $fpcid2 . '">' . $fcollection2 . '</OPTION>';
                }
                echo '</SELECT></TD></TR>';
            }
            echo '</TABLE>';
            echo '<INPUT TYPE="HIDDEN" NAME="update" VALUE="yes">';
			echo '<INPUT TYPE="SUBMIT" VALUE="Update Funko Pop"></FORM><BR />';
			$sqlimage = "SELECT popimages.imageid, popimages.imagepath FROM popimages WHERE popimages.funkoid = $fid AND popimages.userid = $fuid";
			if (!$result3 = $con->query($sqlimage)){
                die ('There was an error running the query [' . $con->error . ']');
            }
			if (mysqli_num_rows($result3) == 1) {
				$row3 = mysqli_fetch_array($result3);
				echo '<IMG SRC="images/' . $row3['imagepath'] . '" ALT="' . $fname . '"><BR />';
				$_SESSION['imageid'] = $row3['imageid'];
				$_SESSION['imagepath'] = $row3['imagepath'];
				$_SESSION['image'] = "existing";
			} else {
				echo '<IMG SRC="images/no-image-available.jpg">';
				$_SESSION['image'] = "default";
			}
			echo '<FORM METHOD="POST" ACTION="imageupload.php"><input type="hidden" name="uploadyn" value="change"><INPUT TYPE="HIDDEN" NAME="funkoid" VALUE="' . $fid . '">';
			echo '<INPUT TYPE="SUBMIT" VALUE="Change Image"></FORM><BR /><BR />';
        } else {
        echo 'Please select a Funko Pop to edit!';
        }
    }
	echo 'Retun to <A HREF="list.php" CLASS="navlink">Funko Pop list</A><BR />';
}
include_once 'footer.php';
?>