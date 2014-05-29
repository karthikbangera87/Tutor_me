<?php

/* Inserts the Tutor's timetable into the database. Redirects to profile.php */

include "dbConnect.php";
global $con;

if (isset ( $_POST ) && ! empty ( $_POST )) {
	$notice = "";
	if (isset ( $_POST ['commit'] ) && ($_POST ['commit'] == 'Submit')) {
		$username = $_POST ['username'];
		$timeSlotNum = $_POST ['timeSlotNum'];
		$timeSlotList = array ();
		
		for($i = 0; $i < $timeSlotNum; $i ++) {
			$date_txt = 'datepicker' . $i;
			$startTime_txt = 'startTime' . $i;
			$endTime_txt = 'endTime' . $i;
			
			if ($_POST [$date_txt] != 'Select a date') {
				$date_raw = $_POST [$date_txt];
				$date = date ( "Y-m-d H:i:s", strtotime ( $date_raw ) );
				$startTime_raw = $_POST [$startTime_txt];
				$startTime = gmdate ( "H:i:s", $startTime_raw * 3600 );
				$endTime_raw = $_POST [$endTime_txt];
				$endTime = gmdate ( "H:i:s", $endTime_raw * 3600 );
				$item = array (
						$date,
						$startTime,
						$endTime 
				);
				array_push ( $timeSlotList, $item );
			}
		}
		
		foreach ( $timeSlotList as $item ) {
			$date = $item [0];
			$startTime = $item [1];
			$endTime = $item [2];
			
			$query = "INSERT INTO TimeTable (TutorID, Date, BeginTime, EndTime) VALUES ('$username', '$date', '$startTime', '$endTime')";
			$result = mysqli_query ( $con, $query );
			
			if ($result) {
				$notice .= "Insert operation successful! ";
				echo "<script>alert($notice);</script>";
			} else {
				die ( "Database query failed. " . mysqli_error ( $con ) );
			}
		}
		header ( 'Location: profile.php' );
	} else {
		echo 'Invalid submit';
	}
} else {
	echo 'No $_POST found';
}

mysqli_free_result ( $result );
include "dbClose.php";

?>