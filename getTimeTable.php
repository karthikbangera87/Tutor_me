<?php
include "dbConnect.php";
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
?>