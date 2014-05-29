<!doctype html>
<html>

<!-- Home page of the tutor. Displays Confirmed and Pending appointments -->

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
  $(function() {
    $( "#datepicker" ).datepicker();
  });
  function openLanding()
	{
	window.open("index.php","_self")
	}
  </script>
</head>
<body>
<?php
include "dbConnect.php";
session_start ();
if (! isset ( $_SESSION ['username'] )) {
	header ( "Location: index.php" );
} else {
	
	$username = $_SESSION ['username'];
	$result = mysqli_query ( $con, "select * from Schedule where TutorID='$username' and Status='Approved'" );
	$no_rows = mysqli_num_rows ( $result );
	
	if ($no_rows == 0) {
		?>
	
	<?php
	} else {
		$data = '';
		$i = 0;
		while ( $row = mysqli_fetch_array ( $result, MYSQL_ASSOC ) ) {
			$data .= '
        data[' . $i . '] = {
			ScheduleID: "' . $row ['ScheduleID'] . '",
			UserID: "' . $row ['UserID'] . '",
            TutorID: "' . $row ['TutorID'] . '",
			CourseID: "' . $row ['CourseID'] . '",
			LocationID: "' . $row ['LocationID'] . '",
			Date: "' . $row ['Date'] . '",
            StartTime: "' . $row ['BeginTime'] . '",
			EndTime: "' . $row ['EndTime'] . '",
			Status: "' . $row ['Status'] . '"
        };
    	';
			$i ++;
		}
	}
	
	$result1 = mysqli_query ( $con, "select * from Schedule where TutorID='$username' and Status='Pending'" );
	$no_rows1 = mysqli_num_rows ( $result1 );
	if ($no_rows1 == 0) {
		?>
	
	<?php
	} else {
		$data1 = '';
		$i = 0;
		while ( $row = mysqli_fetch_array ( $result1, MYSQL_ASSOC ) ) {
			$data1 .= '
        data1[' . $i . '] = {
			ScheduleID: "' . $row ['ScheduleID'] . '",
			UserID: "' . $row ['UserID'] . '",
            TutorID: "' . $row ['TutorID'] . '",
			CourseID: "' . $row ['CourseID'] . '",
			LocationID: "' . $row ['LocationID'] . '",
			Date: "' . $row ['Date'] . '",
            StartTime: "' . $row ['BeginTime'] . '",
			EndTime: "' . $row ['EndTime'] . '",
			Status: "' . $row ['Status'] . '"
        };
    	';
			$i ++;
		}
	}
}
include "dbClose.php";
?>
<div class="shell">
		<div class="container">
			<header id="header">
				<img id="logo" src="css/images/logo.png" onClick="openLanding()" />
				<label style="float: right; margin-right: 50px;">Welcome <?php echo $username ?></label>
				<div class="cl">&nbsp;</div>
			</header>
			<div id="leftNavigation">
				<ul class="nav">
					<li><a href="#">Home</a></li>
					<li><a href="profile.php">My Profile</a></li>
					<li><a href="logoff.php">Log off</a></li>
				</ul>
			</div>
			<div id="userProfileDiv">
				<table width="100%">
					<tr>
						<td valign="top" width="50%"><div class="grid-header"
								style="width: 640px;">
								<label>Confirmed Appointments</label>
							</div>
							<div id="myGrid" style="width: 640px; height: 125px;"></div></td>
					</tr>
				</table>

				<table width="100%">
					<tr>
						<td valign="top" width="50%"><div class="grid-header"
								style="width: 640px;">
								<label>Pending Appointments</label>
							</div>
							<div id="myGrid1" style="width: 640px; height: 125px;"></div></td>
					</tr>
				</table>
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
	<script src="js/slick/lib/jquery.event.drag-2.2.js"></script>
	<script src="js/slick/slick.core.js"></script>
	<script src="js/slick/slick.dataview.js"></script>
	<script src="js/slick/slick.formatters.js"></script>
	<script src="js/slick/slick.grid.js"></script>
	<script>
function formatter(row, cell, value, columnDef, dataContext) {
        return value;
    }
	
  var grid;
  var columns = [
    {id: "ScheduleID", name: "Schedule ID", field: "ScheduleID"},
	{id: "TutorID", name: "Student Name", field: "UserID"},
	{id: "CourseID", name: "Course ID", field: "CourseID"},
	{id: "LocationID", name: "Location", field: "LocationID"},
    {id: "Date", name: "Date", field: "Date"},
    {id: "StartTime", name: "From", field: "StartTime"},
    {id: "EndTime", name: "To", field: "EndTime"},
	{id: "Status", name: "Status", field: "Status"}
  ];

  var options = {
    enableCellNavigation: true,
    enableColumnReorder: false
  };

  $(function () {
     var data = [];
        <?=$data?> 
        grid = new Slick.Grid($("#myGrid"), data, columns, options);
  });
</script>
	<script>
function formatter(row, cell, value, columnDef, dataContext) {
        return value;
    }
	
  var grid1;
  var columns1 = [
    {id: "ScheduleID", name: "Schedule ID", field: "ScheduleID"},
	{id: "UserID", name: "Student Name", field: "UserID"},
	{id: "CourseID", name: "Course ID", field: "CourseID"},
	{id: "LocationID", name: "Location", field: "LocationID"},
    {id: "Date", name: "Date", field: "Date"},
    {id: "StartTime", name: "From", field: "StartTime"},
    {id: "EndTime", name: "To", field: "EndTime"},
	{id: "Status", name: "Status", field: "Status"}
  ];

  var options = {
    enableCellNavigation: true,
    enableColumnReorder: false
  };

  $(function () {
     var data1 = [];
        <?=$data1?> 
        grid1 = new Slick.Grid($("#myGrid1"), data1, columns1, options);
  });
</script>
</body>
</html>
