<?php

/* Gets the available timings of the selected tutor for a given date. */

include "dbConnect.php";
include "getTimeTable.php";
include "getSchedule.php";
include "utils.php";
global $con;

session_start ();
$tutorID = $_GET ['tutorID'];
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
function getAvailableTime($tutorID, $date) {
	$parseDate = $date;
	$timetable = getTimeTable ( $tutorID, $parseDate );
	$schedule_time = getScheduleTime ( $tutorID, $parseDate );
	
	return flip_isset_diff ( $timetable, $schedule_time );
}

?>