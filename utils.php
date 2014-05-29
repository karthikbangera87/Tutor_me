<?php
// const DISPLAY_DATE_FORMAT = "m/d/Y";
// const DB_DATE_FORMAT = "Y-m-d";

// Format date from m/d/Y format to Y-m-d to pass to database
// function formatDate($dateString) {
// $date = date_create_from_format ( DISPLAY_DATE_FORMAT, $dateString );
// return date_format ( $date, DB_DATE_FORMAT );
// }

// Find the difference (set difference) between array A and array B
// To find the available time slot
function flip_isset_diff($b, $a) {
	$at = array_flip ( $a );
	$d = array ();
	foreach ( $b as $i )
		if (! isset ( $at [$i] ))
			$d [] = $i;
	return $d;
}
?>