<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Tutor Me!!</title>
<link rel="stylesheet" href="css/style.css" type="text/css" media="all" />
<!--<link href='http://fonts.googleapis.com/css?family=Raleway:400,900,800,700,600,500,300,200,100' rel='stylesheet' type='text/css'> -->
<script src="js/jquery-1.8.0.min.js" type="text/javascript"></script>
<link rel="stylesheet" href="css/jquery-ui.css" />
<script src="js/jquery-1.9.1.js"></script>
<script src="js/jquery-ui.js"></script>
<link rel="stylesheet" href="/resources/demos/style.css" />
<!--[if lt IE 9]>
		<script src="js/modernizr.custom.js"></script>
	<![endif]-->
<script src="js/jquery.carouFredSel-5.5.0-packed.js"
	type="text/javascript"></script>
<script src="js/functions.js" type="text/javascript"></script>
<script>
  $(function() {
    $( "#datepicker" ).datepicker({
    minDate: 0,
	maxDate: '+2w',
    dateFormat: 'yy-mm-dd'
});
  });
  function openHome()
	{
	window.open("tutorHome.html","_self")
	}
  </script>
</head>
<body>
<?php
include "dbConnect.php";
$result1 = mysqli_query ( $con, "select CourseID from Course" );
?>

  <div class="shell">
		<div class="container">
			<header id="header">
				<img id="logo" src="css/images/logo.png" />
			</header>
			<div id="sliderLoginContainer">
				<div class="slider">
					<ul>
						<li id="img1">
							<div class="slide-cnt">
								<h2>Rate your tutor</h2>
								<p>Our rating system helps bifurcate the heroes from the zeroes.
									So not just anybody can be a star tutor. The experience not
									only helps students but also hone the skills of the tutors
									thereby giving them encouragement for taking teaching as a
									future profession.</p>
							</div> <img src="css/images/thumb.jpg" alt="" />
						</li>
						<li id="img2">
							<div class="slide-cnt">
								<h2>Hassle Free Learning</h2>
								<p>We make sure that two sessions never interfere with each
									other so that students can get a hassle-free environment. The
									users can modify their time-table according to other
									commitments like assignments. The malleability of the system
									helps making it a hit with the target users.</p>
							</div> <img src="css/images/thumb2.png" alt="" />
						</li>
						<li id="img3">
							<div class="slide-cnt">
								<h2>Students for Students</h2>
								<p>Tutors sign up for free and set their own hourly rates, the
									students search tutors schedule them and pay them using TutorMe
									with no added fees or surcharges. The system is created to
									promote student success.</p>
							</div> <img src="css/images/thumb3.png" alt="" />
						</li>
					</ul>
				</div>
				<div id="loginContainer">
					<form id="loginForm" action="dbLoginTest.php" method="post">
						<label for="username">Username:</label> <input id="username"
							name="username" type="name"> <label for="password">Password:</label>
						<input id="password" name="password" type="password"> <input
							type="submit" value="Login" style="margin-top: 10px;">
					</form>
					<br></br> <a href="register.php"
						style="float: right; margin-right: 30px; margin-top: 0px;">Register
						Now!!</a>
				</div>
			</div>
			<!-- search -->
			<div id="searchContainer">
				<div class="search">
					<form id="searchForm" action="showResult.php" method="post">
						<h4>Tutor Search</h4>
						</br> <label for="course">Course:</label> <select id="course"
							name="course" id="course">
				<?php
				while ( $row = mysqli_fetch_array ( $result1 ) )
					echo ("<option value = '" . $row ['CourseID'] . "'>" . $row ['CourseID'] . "</option>");
				?></select> <label for="datepicker">Date:</label> <input
							id="datepicker" name="datepicker" type="name" class="field"
							value="Enter Date here" title="Enter Date here"> </input> <input
							type="submit" name="searchBox" value="Search">
						<div class="cl">&nbsp;</div>
					</form>
				</div>
				<!-- end of search -->
			</div>
			<div id="aboutUs">

				<h4>About Us</h4>
				<p>
					Tutor me is a place where students come together to organize peer
					tutoring. It gives a new facet to learning as it gives a very
					different ambience as compared to the classroom environment. The
					application offers majority of the courses offered by School of
					Informatics and Computing. We yearn to grow with each passing year.<br />
				</p>
			</div>
			<!-- footer -->
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
