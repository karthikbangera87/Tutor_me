<?php
include "dbConnect.php";
function getScheduleTime($tutorID, $parseDate) {
	global $con;
	$schedule_res = mysqli_query ( $con, "SELECT S.BeginTime, S.EndTime FROM Schedule as S WHERE S.TutorID = '$tutorID' AND S.Date = '$parseDate' AND Status!='Rejected'" );
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
?>