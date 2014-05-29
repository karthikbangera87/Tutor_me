<?php
session_start ();
if (! isset ( $_SESSION ['username'] )) {
	header ( "Location: index.php" );
} else {
include "dbConnect.php";
include "getTimeTable.php";
include "utils.php";

$tutorID = $_SESSION ['username'];
$parseDate = $_POST ['parseDate'];

$allTime = array ();
for($i = 8; $i <= 22; $i ++) {
	$t = $i . ":00";
	$time = date_create_from_format ( 'Y-m-d H:i', $parseDate . " " . $t );
	$fdate = date_format ( $time, 'H:i' );
	array_push ( $allTime, $fdate );
}

$timetable = getTimeTable ( $tutorID, $parseDate );

$availableTimeTable = flip_isset_diff ( $allTime, $timetable );
$results = '<option selected>Begin time</option>';
foreach ( $availableTimeTable as $option ) {
	$results .= "<option value='$option'>$option</option>";
}

echo $results;
}
?>