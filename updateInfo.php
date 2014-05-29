<?php
session_start ();
if (! isset ( $_SESSION ['username'] )) {
	header ( "Location: index.php" );
} else {
include "dbConnect.php";
include "getProfileInfo.php";

$userId = $_SESSION ['username'];
$firstName = $_POST ['firstName'];
$lastName = $_POST ['lastName'];
$email = $_POST ['email'];
$phone = $_POST ['phone'];
$major = $_POST ['major'];
$school = $_POST ['school'];

$update_user = mysqli_query ( $con, "UPDATE User SET FirstName = '$firstName', LastName = '$lastName', Email = '$email', Phone = '$phone', Major = '$major', School = '$school' WHERE UserId = '$userId'" ) or die ( "Failed" . mysqli_error ( $con ) );

return populateViewInfoForm ( $userId );
}
?>