<?php
session_start ();
if (! isset ( $_SESSION ['username'] )) {
	header ( "Location: index.php" );
} else {
include "getProfileInfo.php";
$userID = $_SESSION ['username'];
echo populateEditCourseView ( $userID );
}
?>