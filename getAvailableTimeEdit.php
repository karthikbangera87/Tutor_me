<?php
include "dbConnect.php";
session_start ();

$tutorID = $_GET ['tutorid'];
$date = $_GET ['date'];

if (! empty ( $tutorID ) && ! empty ( $date )) {
	$availableTime = getAvailableTime ( $tutorID, $date );
	if (sizeof ( $availableTime ) > 0) {
		echo "<option selected disabled value=''>Select time</option>";
		foreach ( $availableTime as $time ) {
			echo "<option value='$time'>$time</option>";
		}
	} else {
		echo "<option selected disabled value=''>Not available</option>";
	}
} else {
	// Populate error
	// echo "<option selected disabled value=''>Not available</option>";
}
function getTimeTable($tutorID, $parseDate) {
	global $con;
	$time_table_res = mysqli_query ( $con, "SELECT BeginTime, EndTime FROM TimeTable WHERE TutorId = '$tutorID' AND Date = '$parseDate'" );
	$timetable = array ();
	$num_rows = mysqli_num_rows ( $time_table_res );
	
	if ($num_rows > 0) {
		while ( $row = mysqli_fetch_array ( $time_table_res, MYSQL_ASSOC ) ) {
			$begin_time = DateTime::createFromFormat ( 'Y-m-d H:i:s', $parseDate . " " . $row ['BeginTime'] );
			$end_time = DateTime::createFromFormat ( 'Y-m-d H:i:s', $parseDate . " " . $row ['EndTime'] );
			
			while ( $begin_time <= $end_time ) {
				$fdate = date_format ( $begin_time, 'H:i' );
				array_push ( $timetable, $fdate );
				$begin_time->add ( new DateInterval ( 'PT30M' ) );
			}
		}
	}
	return $timetable;
}
function getScheduleTime($tutorID, $parseDate) {
	global $con;
	$schedule_res = mysqli_query ( $con, "SELECT S.BeginTime, S.EndTime FROM Schedule as S WHERE S.TutorID = '$tutorID' AND S.Date = '$parseDate'" );
	$scheduledTime = array ();
	
	$num_rows = mysqli_num_rows ( $schedule_res );
	if ($num_rows > 0) {
		while ( $row = mysqli_fetch_array ( $schedule_res, MYSQL_ASSOC ) ) {
			$begin_time = DateTime::createFromFormat ( 'Y-m-d H:i:s', $parseDate . " " . $row ['BeginTime'] );
			$end_time = DateTime::createFromFormat ( 'Y-m-d H:i:s', $parseDate . " " . $row ['EndTime'] );
			
			while ( $begin_time <= $end_time ) {
				$fdate = date_format ( $begin_time, 'H:i' );
				array_push ( $scheduledTime, $fdate );
				$begin_time->add ( new DateInterval ( 'PT30M' ) );
			}
		}
	}
	
	return $scheduledTime;
}
function getAvailableTime($tutorID, $date) {
	$parseDate = $date;
	$timetable = getTimeTable ( $tutorID, $parseDate );
	$schedule_time = getScheduleTime ( $tutorID, $parseDate );
	
	return flip_isset_diff ( $timetable, $schedule_time );
}
function flip_isset_diff($b, $a) {
	$at = array_flip ( $a );
	$d = array ();
	foreach ( $b as $i )
		if (! isset ( $at [$i] ))
			$d [] = $i;
	return $d;
}

?>