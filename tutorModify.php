<?php
include "dbConnect.php";
$scheduleID = $_GET ["scheduleID"];

$query1 = "update Schedule set Status='Pending' WHERE ScheduleID='" . $scheduleID . "';";
$result1 = mysqli_query ( $con, $query1 );

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
// get the Email
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
$mail->Subject = "Schedule Modified";

$body = "";
$body .= "Hello " . $name . ":<br />";
$body .= "<strong>" . $userID . "</strong> just modified the schedule on <strong>" . $courseID . "</strong>, please check the updated information.<br />";
$body .= $locationBody;
$body .= $timeBody;
$body .= "Do you agree on that? If so, please click the link below. <br />";
$body .= '<a href="' . $actLink . '">' . $actLink . "</a><br />";
$body .= "If you don't agree on that: <br />";
$body .= '<a href="' . $rejLink . '">' . $rejLink . "</a><br />";
$body .= $endBody;

$mail->Body = $body; // HTML Body
$mail->AltBody = $body; // Text Body
if (! $mail->Send ()) {
	echo "Mailer Error: " . $mail->ErrorInfo;
}

/*
 * $to=$userID . "@indiana.edu"; //to user $name=$userID; // Recipient's name $mail->AddAddress($to,$name); $body = ""; $body .= "Hello " . $name . ":<br />"; $body .= "You just modified the schedule with <strong>". $tutorID . "</strong> on <strong>" . $courseID . "</strong>, now please wait for tutor's confirmation.<br />"; $body .= "The updated information:<br />"; $body .= $locationBody; $body .= $timeBody; $body .= $endBody; $mail->Body = $body; //HTML Body $mail->AltBody = $body; //Text Body if(!$mail->Send()) { echo "Mailer Error: " . $mail->ErrorInfo; }
 */

header ( 'Refresh:5; url=studentHome.php' );
echo "The updated schedule has been sent to tutor, you'll be redirected to your home page in a few seconds....<br />";
?>