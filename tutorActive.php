<?php
include "dbConnect.php";
$scheduleID = $_GET ["scheduleID"];
$query = "UPDATE Schedule SET Status='Approved' WHERE ScheduleID='" . $scheduleID . "';";
$result = mysqli_query ( $con, $query );
$notice = "";
if ($result) {
	$notice .= "You have confirmed the request successfully! <br /> Now you may close this browser window !!";
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
// get Email from User
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

$to = $tutorEmail;
$name = $tutorID; // Recipient's name
$mail->AddAddress ( $to, $name );
$mail->Subject = "Appointment confirmed";

$body = "";
$body .= "Hello " . $name . ":<br />";
$body .= "You have made an appointment with " . $userID . " on <strong>" . $courseID . "</strong>.<br />";
$body .= $locationBody;
$body .= $timeBody;
$body .= $endBody;

$mail->Body = $body; // HTML Body
$mail->AltBody = $body; // Text Body
if (! $mail->Send ()) {
	echo "Mailer Error: " . $mail->ErrorInfo;
}

$to = $userEmail; // to user
$name = $userID; // Recipient's name
$mail->AddAddress ( $to, $name );

$body = "";
$body .= "Hello " . $name . ":<br />";
$body .= $tutorID . " just approved your tutor request on <strong>" . $courseID . "</strong>.<br />";
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