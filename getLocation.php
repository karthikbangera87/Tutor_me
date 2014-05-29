<?php
include "dbConnect.php";
global $con;

$date = $_GET ['date'];
$beginTime = $_GET ['beginTime'];
$endTime = $_GET ['endTime'];
$parseDate = $date;

$query = "SELECT * FROM Location WHERE LocationID NOT IN ( SELECT LocationID FROM Schedule S WHERE S.Date = '$parseDate' AND ( (S.BeginTime <= '$beginTime' AND S.EndTime > '$beginTime') OR (S.BeginTime < '$endTime' AND S.EndTime >= '$endtime' ) ) )";
$results = mysqli_query ( $con, $query ) or die ( "SQL Error: " . mysqli_errno ( $con ) );

$num_rows = mysqli_num_rows ( $results );
if ($num_rows > 0) {
	echo "<option selected disabled value=''>Select location</option>";
	while ( $row = mysqli_fetch_array ( $results, MYSQL_ASSOC ) ) {
		$loc_id = $row ['LocationID'];
		$loc = $row ['Building'] . " " . $row ['Floor'] . " Fl." . " Room " . $row ['Room'];
		echo "<option value='$loc_id'>$loc</option>";
	}
} else {
	// populate option with value no available location
	echo "<option selected disabled value=''>Not available</option>";
}
?>