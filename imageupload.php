<?php
$pagetitle = "Image Uploader";
include_once ('header.php');
include_once ('smart_resize_image.function.php');
$uploadedimage = mysqli_real_escape_string($con, $_POST['uploadyn']);
$funkoid = mysqli_real_escape_string($con, $_POST['funkoid']);
$imageid = $_SESSION['imageid'];
$uploadyn = $_SESSION['image'];
$remimage = $_SESSION['imagepath'];
#
# File name should be a combo of the time (so no 2 images are named the same),
# pop number, pop name, and username of uploader.
# For example: 1497650696_147_C2-B5_funkybeast808.jpg
# 
if (isset($_SESSION['userid'])){
	if ($uploadedimage == "default") {
		extract($_POST);
		$UploadedFileName = $_FILES['uploadedfile']['name'];
		$extension = end(explode(".", $UploadedFileName));
		if($UploadedFileName != '') {
			$upload_directory = "images/"; //This is the folder which you created just now
			$TargetPath=time()."_".$_SESSION['popno']."_".$_SESSION['popname']."_".$uname.".".$extension;
			if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $upload_directory.$TargetPath)) {
				$resized = $upload_directory.$TargetPath;
				smart_resize_image ($upload_directory.$TargetPath, null, 230, 300, true, $resized, false, false, 100);
				$insertfile = "INSERT INTO funkopops.popimages (funkoid, userid, imagepath) VALUES ($funkoid, $userid, '$TargetPath')";
				if (!$addpath = $con->query($insertfile)) {
					die ('There was an error running the query: [' . $con->error . ']');
				}
			}
		}
		echo 'You have successfully uploaded a new image.<BR />';
		echo 'Redirecting back to editor.<BR />';
		header("refresh:2;url=edit.php?id=$funkoid");
		include_once ('footer.php');
		exit();
	} else if ($uploadedimage == "existing") {
		extract($_POST);
		$UploadedFileName = $_FILES['uploadedfile']['name'];
		$extension = end(explode(".", $UploadedFileName));
		if($UploadedFileName != '') {
			$upload_directory = "images/"; //This is the folder which you created just now
            $TargetPath=time()."_".$_SESSION['popno']."_".$_SESSION['popname']."_".$uname.".".$extension;
			if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $upload_directory.$TargetPath)) {
				$resized = $upload_directory.$TargetPath;
				smart_resize_image ($upload_directory.$TargetPath, null, 250, 0, true, $resized, false, false, 100);
				$insertfile = "UPDATE funkopops.popimages SET imagepath = ('$TargetPath') WHERE imageid = $imageid AND funkoid = $funkoid AND userid = $userid";
				if (!$addpath = $con->query($insertfile)) {
					die ('There was an error running the query: [' . $con->error . ']');
				}
			}
		}
		if (file_exists("images/$remimage")) {
			unlink("images/$remimage");
		} else {
			echo 'Image ' . $remimage . ' was NOT deleted.<BR />';
		}
		echo 'You have successfully updated the image.<BR />';
		echo 'Redirecting back to editor.<BR />';
		header("refresh:2;url=edit.php?id=$funkoid");
		include_once ('footer.php');
		exit();
	} else {
		$fid = $funkoid;
		echo '<form action="imageupload.php" method="post" enctype="multipart/form-data">';
		echo 'Filename: <input type="hidden" name="funkoid" value="' . $fid . '">';
		echo '<input type="hidden" name="uploadyn" value="' . $uploadyn . '">';
		echo '<input type="file" name="uploadedfile"><br>';
		echo '<input type="submit" value="Upload image"></form>';
	}
} else {
	echo 'Please login <A HREF="index.php" CLASS="navlink">HERE</A> before continuing.<BR />';
}
include_once ('footer.php');
?>