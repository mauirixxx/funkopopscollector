<?php
$pagetitle = "Funko Pop Collection Database";
include_once ('header.php');
if (isset($_SESSION['userid'])){
	echo 'Enter new Funko Pop <A HREF="newfunko.php" CLASS="navlink">here</A><BR /><BR />';
	echo 'Search for existing Funko Pop <A HREF="search.php" CLASS="navlink">here</A><BR /><BR />';
	echo 'List ALL Funko Pops <A HREF="list.php" CLASS="navlink">here</A><BR /><BR />';
	echo 'Add a new Funko Pop group <A HREF="collection.php" CLASS="navlink">here</A><BR />';
}
include_once ('footer.php');
?>