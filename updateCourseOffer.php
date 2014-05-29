<?php
session_start ();
if (! isset ( $_SESSION ['username'] )) {
	header ( "Location: index.php" );
} else {
include "dbConnect.php";
include "getProfileInfo.php";

$addedCourses = json_decode ( $_POST ['addedCourses'] );
$deletedCourses = json_decode ( $_POST ['deletedCourses'] );
$userID = $_SESSION ['username'];

if (! empty ( $addedCourses )) {
	// mysqli_multi_query().
	foreach ( $addedCourses as $courseID ) {
		$query = "INSERT INTO CourseOffer VALUES ('$courseID', '$userID')";
		// $result = mysql_query($query) or die( "Failed: " . mysql_error($con) );
		$result = mysqli_query ( $con, $query ) or die ( "Failed: " . mysqli_error ( $con ) );
	}
}

if (! empty ( $deletedCourses )) {
	foreach ( $deletedCourses as $courseID ) {
		$query = "DELETE FROM CourseOffer WHERE TutorID = '$userID' and CourseID = '$courseID'";
		// $result = mysql_query($query) or die( "Failed: " . mysql_error($con) );
		$result = mysqli_query ( $con, $query ) or die ( "Failed: " . mysqli_error ( $con ) );
	}
}

echo populateCourseAndRatings ( $userID );
}
?>