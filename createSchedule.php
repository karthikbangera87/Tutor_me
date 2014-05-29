<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>

<!-- This page inserts the schedule requested by student into the database in 'Pending' status. Redirects to  tutorEmail.php. -->

<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Tutor Me!!</title>
<link rel="stylesheet" href="css/style.css" type="text/css" media="all" />
<link rel="stylesheet" href="css/jquery-ui.css" />
<script src="js/jquery-1.8.0.min.js" type="text/javascript"></script>
<script src="js/jquery-1.9.1.js"></script>
<script src="js/jquery-ui.js"></script>
<link rel="stylesheet" href="/resources/demos/style.css" />
<script src="js/jquery.carouFredSel-5.5.0-packed.js"
	type="text/javascript"></script>
<script src="js/functions.js" type="text/javascript"></script>
<script>
	function openLanding() {
		window.open("index.html", "_self")
	}
</script>
</head>
<?php
include "dbConnect.php";
include "getProfileInfo.php";
session_start ();
if (! isset ( $_SESSION ['username'] )) {
	header ( "Location: index.php" );
} else {
	$userID = $_SESSION ['username'];
	$tutorID = $_POST ["tutorID"];
	$courseID = $_POST ["courseID"];
	$locationID = $_POST ["location"];
	$parseDate = $_POST ["datepicker"];
	$beginTime = $_POST ["beginTime"];
	$endTime = $_POST ["endTime"];
	
	$schedule = mysqli_query ( $con, "INSERT INTO Schedule (UserID, TutorID, CourseID, LocationID, Date, BeginTime, EndTime, Status) VALUES ('$userID', '$tutorID', '$courseID', '$locationID', '$parseDate', '$beginTime', '$endTime', 'Pending' )" );
	$results = mysqli_query ( $con, "SELECT ScheduleID FROM Schedule where UserID='$userID' AND TutorID='$tutorID' AND Date='$parseDate' AND BeginTime='$beginTime' AND EndTime='$endTime'" );
	while ( $row = mysqli_fetch_array ( $results, MYSQL_ASSOC ) ) {
		$scheduleID = $row ['ScheduleID'];
	}
	
	header ( "Location: tutorEmail.php?scheduleID=" . $scheduleID );
}
?>

<body>
	<div class="shell">
		<div class="container">
			<!-- Header -->
			<header id="header"> <img id="logo" src="css/images/logo.png"
				onClick="openLanding()" />
			<div class="cl">&nbsp;</div>
			</header>
			<!-- End of Header -->

			<!-- Top Navigation -->
			<nav id="navigation">
			<ul>
				<li><a href="tutorHome.php">home</a></li>
				<li><a href="#">about us</a></li>
				<li><a href="#">contacts</a></li>
			</ul>
			<div class="cl">&nbsp;</div>
			</nav>
			<!-- End of Top Navigation -->

			<!-- Left Navigation -->
			<div id="leftNavigation">
				<ul class="nav">
					<?php
					if (isTutor ( $userID ) == true) {
						echo "<li><a href='tutorHome.php'>Home</a></li>";
						echo "<li><a href='profile.php'>My Profile</a></li>";
					} else {
						echo "<li><a href='studentHome.php'>Home</a></li>";
						echo "<li><a href='profile.php'>My Profile</a></li>";
						echo "<li><a href='searchTutors.php'>Search Tutors</a></li>";
						echo "<li><a href='#'>Rate Tutors</a></li>";
					}
					?>
					<li><a href="logoff.php">Log off</a></li>
				</ul>
			</div>
			<!-- End of Left Navigation -->

			<div id="userScheduleDiv" style="position: relative"
				style="width:100%;">
				<div class="scheduleComplete">
     			<?php
								if ($schedule == TRUE) {
									echo "<p>Your schedule is successfully created and is in pending status.</p>";
								} else {
									echo "<p>Fail: " . mysqli_error ( $schedule ) . "</p>";
								}
								?>
    </div>
			</div>

			<!-- Footer -->
			<div id="footerContainer">
				<div id="footer">
					<div class="footer-nav">
						<ul>
						</ul>
						<div class="cl">&nbsp;</div>
					</div>
					<p class="copy">
						&copy; Copyright 2013<span>|</span>Tutor Search - Designed by <a
							href="http://www.cs.indiana.edu/~yuqwu/courses/B561-fall13/webpage/"
							target="_blank">Advanced Database Concepts - Group_14</a>
					</p>
					<div class="cl">&nbsp;</div>
				</div>
			</div>
			<!-- End of Footer -->

		</div>
	</div>
</body>
</html>