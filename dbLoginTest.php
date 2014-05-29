<?php

/* This page tests the validity of the login credentials. If OK, redirects to the home page of student/tutor. If not, redirects back to index page */

include "dbConnect.php";

$username = $_POST ["username"];
$password = $_POST ["password"];

$result = mysqli_query ( $con, "SELECT * FROM User WHERE UserID='$username' and Password='$password'" );
$no_rows = mysqli_num_rows ( $result );

if ($no_rows == 1) {
	session_start ();
	$_SESSION ['username'] = $username;
	
	$result2 = mysqli_query ( $con, "SELECT Status FROM User WHERE UserID='$username'" );
	while ( $row = mysqli_fetch_array ( $result2, MYSQL_ASSOC ) ) {
		$status = $row ['Status'];
	}
	if ($status == "no") {
		?>
<script type="text/javascript">
  				alert("Your registration has not been confirmed yet. Please check your email for the confirmation link.");
  				document.location.href = 'index.php';
				</script>
<?php
	} else {
		$result1 = mysqli_query ( $con, "SELECT * FROM Tutor WHERE TutorID='$username'" );
		$no_rows1 = mysqli_num_rows ( $result1 );
		if ($no_rows1 == 1)
			header ( 'Location: tutorHome.php' );
		else
			header ( 'Location: studentHome.php' );
	}
} else {
	?>
<script type="text/javascript">
  		alert("Username/Password incorrect. Please try again.");
  		document.location.href = 'index.php';
		</script>
<?php
}
include "dbClose.php";
?>