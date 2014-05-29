<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Tutor Me!!</title>
<link rel="stylesheet" href="css/jquery-ui.css" />
<link rel="stylesheet" href="/resources/demos/style.css" />
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

<script src="js/jquery-1.8.0.min.js" type="text/javascript"></script>
<script src="js/jquery-1.9.1.js"></script>
<script src="js/jquery-ui.js"></script>
<script src="js/jquery.carouFredSel-5.5.0-packed.js"
	type="text/javascript"></script>
<script src="js/functions.js" type="text/javascript"></script>

<script type="text/javascript">
$( document ).ready(function() {
	$('span.stars').stars();
	
	$("#editInfoForm").submit(function(event) {
	    event.preventDefault();
	    var values = $(this).serialize();

	    $.ajax({
	        url: "updateInfo.php",
	        type: "post",
	        data: values,
	        success: function(data){
	        	$( "#viewInfo" ).html( data );
	        	$( "#viewInfo" ).css( "display", "block" );
	        	$( "#editInfo" ).css( "display", "none" );
	        },
	        error:function(){
	            alert("failure");
	        }
	    });
	});

});

$.fn.stars = function() {
	return $(this).each(function() {
		$(this).html($('<span />').width(Math.max(0, (Math.min(5, parseFloat($(this).html())))) * 16));
	});
}

function onEditInfo()
{
	var firstName = document.getElementById("tdFirstName").textContent;
	var lastName = document.getElementById("tdLastName").textContent;
	var email = document.getElementById("tdEmail").textContent;
	var phone = document.getElementById("tdPhone").textContent;
	var school = document.getElementById("tdSchool").textContent;
	var major = document.getElementById("tdMajor").textContent;

	// Populate values to editInfo form
	$( "#firstName" ).val( firstName );
	$( "#lastName" ).val( lastName );
	$( "#email" ).val( email );
	$( "#phone" ).val( phone );
	$( "#school" ).val( school );
	$( "#major" ).val( major );

	$( "#viewInfo" ).css( "display", "none" );
	$( "#editInfo" ).css( "display", "block" );
}

function onCancelUpdateInfo()
{
	$( "#editInfo" ).css( "display", "none" );
	$( "#viewInfo" ).css( "display", "block" );
}

function onEditCourse()
{
	$( "#viewCoursesAndRating" ).css( "display", "none" );
	$( "#editCourses" ).css( "display", "block" );
}

window.deletedCourses = [];
window.addedCourses = [];

function onAddNewCourse()
{
	var sel = document.getElementById( "newCourse" );
	var existed = document.getElementById( sel.value );
	if( existed == null )
	{
		var table = document.getElementById("editCoursesTable");
		var row = table.insertRow(-1);
		var cell1 = row.insertCell(0);
		var cell2 = row.insertCell(1);
		var cell3 = row.insertCell(2);
		
		row.setAttribute("id", sel.value, 0);
		cell1.innerHTML = sel.value;
		cell2.innerHTML= sel.options[sel.selectedIndex].text;

		var temp = '"' + sel.value + '"';
		cell3.innerHTML = "<a onclick='onRemoveCourse(" + temp + ")'>Remove</a>";

		var index = deletedCourses.indexOf(sel.value);
		if( index > -1 )
		{
			deletedCourses.splice(index, 1);
		}
		else
		{
			addedCourses.push( sel.value );
		}
	}
	else
	{
		alert("You have already added this course!");
	}
}

function onRemoveCourse(rowId)
{
	var conf = confirm( "Please confirm to remove " + rowId + " from your courses." );
	if (conf == true)
	{
		var removeElement = document.getElementById( rowId );
		removeElement.parentNode.removeChild( removeElement );

		var index = addedCourses.indexOf(rowId);
		if( index > -1 )
		{
			addedCourses.splice(index, 1);
		}
		else
		{
			deletedCourses.push( rowId );
		}
	}
}

function onDoneUpdate()
{
	if( addedCourses.length > 0 || deletedCourses.length > 0)
	{
		var conf = confirm( "Please confirm to update your change." );
		if (conf == true)
		{
			$.post("updateCourseOffer.php", 
					{addedCourses: JSON.stringify(addedCourses),
					 deletedCourses: JSON.stringify(deletedCourses) }, 
					function(data){
						addedCourses.length = 0;
						deletedCourses.length = 0;
						$( "#viewCoursesAndRating" ).html( data );
	        			$( "#editCourses" ).css( "display", "none" );
	        			$( "#viewCoursesAndRating" ).css( "display", "block" );
	        			location.reload();
			});
		}
	}
	else
	{
		onCancleEditCourse();
	}
}

function onCancleEditCourse()
{
	if( addedCourses.length > 0 || deletedCourses.length > 0 )
	{
		$.post("getEditCoursesView.php", 
				function(data){
					addedCourses.length = 0;
					deletedCourses.length = 0;
					$( "#editCourses" ).html( data );
	    			$( "#editCourses" ).css( "display", "none" );
	    			$( "#viewCoursesAndRating" ).css( "display", "block" );
		});
	}
	else
	{
		$( "#editCourses" ).css( "display", "none" );
		$( "#viewCoursesAndRating" ).css( "display", "block" );
	}
}

</script>

<style type="text/css">
span.stars,span.stars span {
	display: block;
	background: url(css/images/stars.png) 0 -16px repeat-x;
	width: 80px;
	height: 16px;
}

span.stars span {
	background-position: 0 0;
}
</style>

<?php
session_start ();
if (! isset ( $_SESSION ['username'] )) {
	header ( "Location: index.php" );
} else {
include "dbConnect.php";
include "getProfileInfo.php";
$userID = ! empty ( $_GET ['tutorid'] ) ? $_GET ['tutorid'] : $_SESSION ['username'];
}
?>
</head>
<body>
	<div class="shell">
		<div class="container" style="height: 1000px;">
			<!-- Header -->
			<header id="header">
				<img id="logo" src="css/images/logo.png" onClick="openLanding()" />
				<div class="cl">&nbsp;</div>
			</header>
			<!-- End of Header -->

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
					}
					?>
			        <li><a href="logoff.php">Log off</a></li>
				</ul>
			</div>
			<!-- End of Left Navigation -->

			<!-- Profile -->
			<div id="userScheduleDiv" style="position: relative"
				style="width:100%; height:100%">
				<?php echo("<h2>$userID's Profile</h2>")?>
				<br />
				<div id="generalInfo">
					<h3>Personal Information</h3>
					<div id="viewInfo">
						<?php populateViewInfoForm($userID)?>
					</div>
					<div id="editInfo" style="display: none;">
						<form id="editInfoForm" method="post" action="">
							<table>
								<tr>
									<td><label for="firstName">First Name:</label></td>
									<td><?php echo "<input id='firstName' name='firstName' type='name' class='field' />" ?></td>
								</tr>
								<tr>
									<td><label for="lastName">Last Name:</label></td>
									<td><?php echo "<input id='lastName' name='lastName' type='name' class='field' />" ?></td>
								</tr>
								<tr>
									<td><label for="email">Email:</label></td>
									<td><?php echo "<input id='email' name='email' type='name' class='field' readonly />" ?></td>
								</tr>
								<tr>
									<td><label for="phone">Phone:</label></td>
									<td><?php echo "<input id='phone' name='phone' type='name' class='field' />" ?></td>
								</tr>
								<tr>
									<td><label for="school">School:</label></td>
									<td><?php echo "<input id='school' name='school' type='name' class='field' />" ?></td>
								</tr>
								<tr>
									<td><label for="major">Major:</label></td>
									<td><?php echo "<input id='major' name='major' type='name' class='field' />" ?></td>
								</tr>
								<tr>
									<td align="right"><input id="updateInfoButton" type="submit"
										value="Update" /></td>
									<td align="right"><input id="cancelInfoButton" type="button"
										value="Cancel" onclick="onCancelUpdateInfo()" /></td>
								</tr>
							</table>
						</form>
					</div>
				</div>
				<br />
				<?php
				if (isTutor ( $userID )) {
					echo "<div id='tutorInfo'>";
					echo "<h3 style='margin-left:200px;'>Courses and Ratings</h3>";
					echo "<div id='viewCoursesAndRating' style='margin-left:200px;'>";
					populateCourseAndRatings ( $userID );
					echo "</div>";
					echo "<div id='editCourses' style='margin-left:200px;display: none;'>";
					populateEditCourseView ( $userID );
					echo "</div>";
					echo "<br />";
					
					echo "<div id='timetable' style='margin-left:200px;'>";
					echo "<h3>Timetable</h3>";
					echo "<div id='myGrid' style='width: 240px; height: 200px;'>";
					echo "</div>";
					$time_table = getTimeTable ( $userID );
					$data = '';
					$i = 0;
					while ( $row = mysqli_fetch_array ( $time_table, MYSQL_ASSOC ) ) {
						$data .= '
							        	data[' . $i . '] = {
									Date: "' . $row ['Date'] . '",
							              StartTime: "' . $row ['BeginTime'] . '",
									EndTime: "' . $row ['EndTime'] . '"
							        };
							    ';
						$i ++;
					}
					
					if (isEditable ( $userID ) == true) {
						echo "<a href='addTimeTable.php'>Add new...</a>";
					}
					
					echo "</div>";
				}
				?>
			
			
			</div>
			<!-- End of Profile -->

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
	<script src="js/slick/lib/jquery.event.drag-2.2.js"></script>
	<script src="js/slick/slick.core.js"></script>
	<script src="js/slick/slick.dataview.js"></script>
	<script src="js/slick/slick.formatters.js"></script>
	<script src="js/slick/slick.grid.js"></script>
	<script>
		var grid;
	
		var columns = [
		    {id: "Date", name: "Date", field: "Date"},
		    {id: "StartTime", name: "From", field: "StartTime"},
		    {id: "EndTime", name: "To", field: "EndTime"}
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
</body>
</html>
