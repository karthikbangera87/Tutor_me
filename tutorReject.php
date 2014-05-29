<?php
include "dbConnect.php";
$scheduleID = $_GET ["scheduleID"];
$query = "UPDATE Schedule SET Status='Rejected' WHERE ScheduleID='" . $scheduleID . "';";
$result = mysqli_query ( $con, $query );
$notice = "";
if ($result) {
	$notice .= "You have rejected the request. Now you may close the browser window...<br />";
} else {
	die ( "Database query failed. " . mysqli_error ( $con ) );
}
$query = "SELECT * FROM Schedule WHERE ScheduleID='" . $scheduleID . "';";
$result = mysqli_query ( $con, $query );
if (! $result) {
	die ( "Database query failed" . mysqli_error ( $con ) );
}
$row = mysqli_fetch_assoc ( $result );
$tutorID = $row ["TutorID"];
$userID = $row ["UserID"];
$courseID = $row ["CourseID"];
$locationID = $row ["LocationID"];
$date = $row ["Date"];
$beginTime = $row ["BeginTime"];
$endTime = $row ["EndTime"];
/*
 * $notice .= 'Do you want to send an email to the student? <a href="mailto:' . $userID . '@indiana.edu?Subject=Not%20a%20appropriate%20schedule" target="_top"> Send an email</a>';
 */
// get the email
$query = "SELECT Email from User WHERE UserID='" . $tutorID . "';";
$result = mysqli_query ( $con, $query );
if (! $result) {
	die ( "Database query failed" . mysqli_error ( $con ) );
}
$row = mysqli_fetch_assoc ( $result );
$tutorEmail = $row ["Email"];
$query = "SELECT Email from User WHERE UserID='" . $userID . "';";
$result = mysqli_query ( $con, $query );
if (! $result) {
	die ( "Database query failed" . mysqli_error ( $con ) );
}
$row = mysqli_fetch_assoc ( $result );
$userEmail = $row ["Email"];
// get the name of location
$query = "SELECT * FROM Location WHERE LocationID='" . $locationID . "';";
$result = mysqli_query ( $con, $query );
if (! $result) {
	die ( "Database query failed" . mysqli_error ( $con ) );
}
$row = mysqli_fetch_assoc ( $result );
$building = $row ["Building"];
$floor = $row ["Floor"];
$room = $row ["Room"];
$capacity = $row ["Capacity"];

mysqli_free_result ( $result );

include "dbClose.php";
?>
<?php

require 'mailInit.php';

$to = $userEmail;
$name = $userID; // Recipient's name
$mail->AddAddress ( $to, $name );
$mail->Subject = "Appointment Rejected";

$body = "";
$body .= "Hello " . $name . ":<br />";
$body .= "Your request(ScheduleID" . $scheduleID . ")  with <strong>" . $tutorID . "</strong> on <strong>" . $courseID . "</strong> has been rejected. Please find the schedule details below...<br />";

$body .= $locationBody;
$body .= $timeBody;
$body .= $endBody;

$mail->Body = $body; // HTML Body
$mail->AltBody = $body; // Text Body
if (! $mail->Send ()) {
	echo "Mailer Error: " . $mail->ErrorInfo;
}
echo $notice;
?>