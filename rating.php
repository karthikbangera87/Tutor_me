

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Tutor Me!!</title>
<link rel="stylesheet" href="js/slick/slick.grid.css" type="text/css" />
<link rel="stylesheet" href="js/slick/controls/slick.pager.css"
	type="text/css" />
<link rel="stylesheet"
	href="js/slick/css/smoothness/jquery-ui-1.8.16.custom.css"
	type="text/css" />
<link rel="stylesheet" href="js/slick/examples/examples.css"
	type="text/css" />
<link rel="stylesheet" href="js/slick/controls/slick.columnpicker.css"
	type="text/css" />
<link rel="stylesheet" href="css/style.css" type="text/css" media="all" />
<!--<link href='http://fonts.googleapis.com/css?family=Raleway:400,900,800,700,600,500,300,200,100' rel='stylesheet' type='text/css'>-->

<script src="js/jquery-1.8.0.min.js" type="text/javascript"></script>
<link rel="stylesheet" href="css/jquery-ui.css" />
<script src="js/jquery-1.9.1.js"></script>
<script src="js/jquery-ui.js"></script>
<link rel="stylesheet" href="/resources/demos/style.css" />
<script src="js/jquery.carouFredSel-5.5.0-packed.js"
	type="text/javascript"></script>
<script src="js/functions.js" type="text/javascript"></script>
<script>
			function openLanding() {
				window.open("tutorLanding.html", "_self");
			}
		</script>
</head>
<body>
    <?php
				include "dbConnect.php";
				session_start ();
				$scheduleID = $_GET ['scheduleid'];
				$username = $_SESSION ['username'];
				$result = mysqli_query ( $con, "select * from Schedule where ScheduleID='$scheduleID'" );
				$no_rows = mysqli_num_rows ( $result );
				
				if ($no_rows == 0) {
					?>
	
	<?php
				} else {
					while ( $row = mysqli_fetch_array ( $result, MYSQL_ASSOC ) ) {
						$tutorID = $row ['TutorID'];
						$courseID = $row ['CourseID'];
						$date = $row ['Date'];
					}
				}
				$result1 = mysqli_query ( $con, "select Rating from Rating where UserID='$username' and TutorID='$tutorID'" );
				$no_rows1 = mysqli_num_rows ( $result1 );
				
				if ($no_rows1 > 0) {
					?>
	<script type="text/javascript">
  		alert("You've already rated this tutor.");
  		document.location.href = 'studentHome.php';
	</script>
	<?php
				}
				
				$_SESSION ['tutorid_rate'] = $tutorID;
				$_SESSION ['courseid_rate'] = $courseID;
				$_SESSION ['date_rate'] = $date;
				
				?>
		<div class="shell">
		<div class="container">
			<header id="header">
				<img id="logo" src="css/images/logo.png" onClick="openLanding()" />
				<div class="cl">&nbsp;</div>
			</header>
			<nav id="navigation">
				<ul>
					<li class="active"><a href="#">Home</a></li>
					<li><a href="#">About us</a></li>
					<li><a href="#">Contacts</a></li>
				</ul>
				<div class="cl">&nbsp;</div>
			</nav>
			<div id="leftNavigation">
				<ul class="nav">
					<li><a href="tutorCreateProfile.html">Edit Profile</a></li>
					<li><a href="#">Search Tutors</a></li>
					<li><a href="#logoff.html">Log off</a></li>
				</ul>
			</div>
			<div id="userProfileDiv" style="position: relative"
				style="width:100%;">
				<div class="search">
					<form id="searchForm" action="dbRating.php" method="post">
						<h4>Tutor Rating</h4>
						<br />
						<table cellpadding="0" cellspacing="0" border="0">

							<tr>
								<td><label for="tutorName">Tutor:</label></td>
								<td><?php
								echo "<input id='tutorID' name='tutorID' value=$tutorID type='name' class='field' readonly />";
								?></td>
							</tr>
							<tr>
								<td><label for="course">Course:</label></td>
								<td><?php
								echo "<input  id='courseID' name='courseID' type='name' class='field' value=$courseID readonly/>";
								?></td>
							</tr>
							<tr>
								<td><label for="datepicker">Date:</label></td>
								<td><?php
								echo "<input  id='date' name='date' type='name' class='field' value=$date readonly/>";
								?></td>
							</tr>
							<tr>
								<td><label for="rating">Rating:</label></td>
								<td><input type="radio" name="rating" id="rating1" value="1">
									1&#09;&#09;&#09;&nbsp;&nbsp;&nbsp; <input type="radio"
									name="rating" id="rating2" value="2">
									2&#09;&#09;&#09;&nbsp;&nbsp;&nbsp; <input type="radio"
									name="rating" id="rating3" value="3">
									3&#09;&#09;&#09;&nbsp;&nbsp;&nbsp; <input type="radio"
									name="rating" id="rating4" value="4">
									4&#09;&#09;&#09;&nbsp;&nbsp;&nbsp; <input type="radio"
									name="rating" id="rating5" value="5"> 5</td>
								<td><input type="submit" value="submit" align="left"></td>
							</tr>
						</table>
						<div class="cl">&nbsp;</div>
					</form>
				</div>

			</div>
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
					<!-- end of footer -->
				</div>
			</div>
		</div>
	</div>
</body>
</html>

