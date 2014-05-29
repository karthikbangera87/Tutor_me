<?php
include "dbConnect.php";
$scheduleID = $_GET ["scheduleID"];
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
$query1 = "SELECT Email from User WHERE UserID='" . $tutorID . "';";
$result1 = mysqli_query ( $con, $query1 );
if (! $result1) {
	die ( "Database query failed" . mysqli_error ( $con ) );
}
$row1 = mysqli_fetch_assoc ( $result1 );
$tutorEmail = $row1 ["Email"];

$query2 = "SELECT Email from User WHERE UserID='" . $userID . "';";
$result2 = mysqli_query ( $con, $query2 );
if (! $result2) {
	die ( "Database query failed" . mysqli_error ( $con ) );
}
$row2 = mysqli_fetch_assoc ( $result2 );
$userEmail = $row2 ["Email"];
// get the name of location
$query3 = "SELECT * FROM Location WHERE LocationID='" . $locationID . "';";
$result3 = mysqli_query ( $con, $query2 );
if (! $result3) {
	die ( "Database query failed" . mysqli_error ( $con ) );
}
$row3 = mysqli_fetch_assoc ( $result3 );
$building = $row3 ["Building"];
$floor = $row3 ["Floor"];
$room = $row3 ["Room"];
$capacity = $row3 ["Capacity"];
include "dbClose.php";
?>
<?php

require 'mailInit.php';

$to = $tutorEmail;
$name = $tutorID; // Recipient's name

$mail->AddAddress ( $to, $name );

$mail->Subject = "Appointment Rquest";

$body = "";
$body .= "Hello " . $tutorID . ":<br />";
$body .= "Student <strong>" . $userID . "</strong> has sent you a tutor request on <strong>" . $courseID . "</strong>.<br />";
$body .= "The location is <strong>" . $building . "</strong>, <strong>" . $floor . "</strong> floor, room <strong>" . $room . "</strong>.<br />";
$body .= "Time is on <strong>" . $date . "</strong>, from <strong>" . $beginTime . "</strong> to <strong>" . $endTime . "</strong>.<br />";
$body .= "<br />Do you agree on that? If so, please click the link below. <br />";
$body .= '<a href="' . $actLink . '">' . $actLink . "</a><br />";
$body .= "If you don't agree on that: <br />";
$body .= '<a href="' . $rejLink . '">' . $rejLink . "</a><br />";
$body .= "Or this is a wrong email, please ignore it.</br>";
$body .= "<br />Thank you <br /> Tutor me!<br />";

$mail->Body = $body; // HTML Body
$mail->AltBody = $body; // Text Body
if (! $mail->Send ()) {
	echo "Mailer Error: " . $mail->ErrorInfo;
} else {
	echo "Appointment request has been sent to the tutor. You'll be redirected to your home page in a few seconds...";
}
header ( 'Refresh:5; url=studentHome.php' );
?>