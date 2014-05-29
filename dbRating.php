<?php

/* Inserts rating of the tutor, rated by a student, into the database. Redirects to studentHome.php */

include "dbConnect.php";
session_start ();

$username = $_SESSION ['username'];
$tutorID = $_SESSION ['tutorid_rate'];
$courseID = $_SESSION ['courseid_rate'];
$rating = $_POST ['rating'];

$result = mysqli_query ( $con, "INSERT INTO Rating values('$username', '$tutorID', '$courseID', '$rating')" );

if ($result) {
	header ( 'Location: studentHome.php' );
} else {
	die ( "Database query failed" . mysql_error () );
}
?>