<!doctype html>
<html>

<!-- This page allows a Tutor to add his/her timetable to the database. Redirects to dbTimeSheet.php -->

<head>
<meta charset="utf-8">
<title>Tutor Me!!</title>
<link rel="stylesheet" href="css/style.css" type="text/css" media="all" />

<script src="js/jquery-1.8.0.min.js" type="text/javascript"></script>
<link rel="stylesheet" href="css/jquery-ui.css" />
<script src="js/jquery-1.9.1.js"></script>
<script src="js/jquery-ui.js"></script>
<script src="js/jquery.carouFredSel-5.5.0-packed.js"
	type="text/javascript"></script>
<script src="js/functions.js" type="text/javascript"></script>
<?php
$POST = array ();
session_start ();

$username = $_SESSION ['username'];
?>

  <script>
  var timeSlotNum=0;
  
  function change_form()
  {
		document.timeSheet.action ="dbTimeSheet.php";
  }

  function add_time(){  
	var newSlot = "<tr>" 
					+ "<td>"
					+ "<input id='datepicker" + timeSlotNum  + "'"
					+ " type='name' name='datepicker" + timeSlotNum + "'"
					+ " value='Select a date' onchange='onDateChange(" + timeSlotNum + ")'/>"
					+ "</td>"
					+ "<td>"
					+ "<select id='startTime" + timeSlotNum + "'" + " name='startTime" + timeSlotNum + "'" + " onchange='onBeginTimeChange(" + timeSlotNum + ")'>"
					+ "<option selected>Begin time</option>"
					+ "</select>"
					+ "</td>"
					+ "<td>"
					+ "<select id='endTime" + timeSlotNum + "'" + " name='endTime" + timeSlotNum + "'" + ">"
					+ "<option selected>End time</option>"
					+ "</select>"
					+ "</td>"
					+ "</tr>";

	$("#timeTableBody").append(newSlot);

	var datepickerId = "#datepicker" + timeSlotNum;
	$(datepickerId).datepicker(
			{ minDate: new Date(),
			  maxDate: "+2w",
			  dateFormat: 'yy-mm-dd' } );
	 
	timeSlotNum++;
	$("#timeSlotNum").val(timeSlotNum);
  }

  function onDateChange(id)
  {
	  var datepickerId = "datepicker" + id;
	  var date = document.getElementById( datepickerId ).value;
	  if( date != "" )
	  {
		  $.post("getAvailableTimetable.php", 
					{parseDate: date}, 
					function(data){
				        var beginTimeId = "#startTime" + id;
			        	$( beginTimeId ).html(data);
			        	var endTimeId = "#endTime" + id;
				        $( endTimeId ).html("<option selected>End Time</option>");
			});
	  }
  }

  function onBeginTimeChange(id)
  {
	  var beginTimeId = "startTime" + id;
	  var endTimeId = "endTime" + id;
	  var beginTime = document.getElementById( beginTimeId );
	  var endTime = document.getElementById( endTimeId );
	  var selIndex = beginTime.selectedIndex;

	  // Empty endtime options
	  endTime.options.length = 1;
	  for( var i = selIndex+1; i < beginTime.options.length; i++ )
  	  {
	  	  var size = endTime.options.length;
	  	  if( size == 1 )
		  {
			  var btime = beginTime.options[selIndex].text;
			  var stime = beginTime.options[i].text;
			  if( isTimeWithInRange(btime,stime) )
			  {
				  var opt = document.createElement("option");
				  opt.text = stime;
				  opt.value = stime;
				  endTime.add(opt, null);
			   }
  		}
  		else
  		{
  			var time1 = endTime.options[size-1].text;
  			var time2 = beginTime.options[i].text;
  			if( isTimeWithInRange(time1, time2) )
  			{
  		 		var opt = document.createElement("option");
  		        opt.text = time2;
  		        opt.value = time2;
  		        endTime.add(opt, null);
  			}
  			else
  			{
  				break;
  			}
  		}
  	}
  }

  function isTimeWithInRange(t1, t2)
  {
  	var d1 = new Date();
  	var d2 = new Date();
  	
  	t1 = t1.split(/:/);
  	t2 = t2.split(/:/);

  	d1.setHours(t1[0], t1[1]);
  	d2.setHours(t2[0], t2[1]);

  	if( d2 - d1 <= 3600000 )
  	{
  		return true;
  	}

  	return false;
  }
  
  function valid_time() {
	  var flag = true;
	  var date, datepickerID;
	  var startTime, endTime;
	  
	  for(var i=0;i<timeSlotNum;i++) {
	  	datepickerID = "#datepicker".concat(i);
	  	date = $(datepickerID).val();
	  	
		if ( date === "Select a date" && timeSlotNum === 1 ) {
			flag = false;
			alert("Please fill in your available time.");
		} else {
			startTime = $("select[name='startTime".concat(i)+"']").val();
			endTime = $("select[name='endTime".concat(i)+"']").val();
			
			if( startTime == "Begin time" && endTime == "End time" ) {
				flag = false;
				alert('Begin time and end time cannot be null.');
			}
		}
	  }
	  return flag;
  }
  
  function get_info() {
	flag2 = valid_time();
	if (flag2) {
		change_form();	
	}
  } 		  
  
  </script>
</head>
<body>
	<div class="shell">
		<div class="container">
			<header id="header">
				<img id="logo" src="css/images/logo.png" alt="logo"
					onClick="openLanding()" />
				<div class="cl">&nbsp;</div>
			</header>
			<nav id="navigation">
				<ul>
					<li class="active"><a href="#">home</a></li>
					<li><a href="#">about us</a></li>
					<li><a href="#">contacts</a></li>
				</ul>
				<div class="cl">&nbsp;</div>
			</nav>
			<div id="leftNavigation">
				<ul class="nav">
					<li><a href="tutorHome.php">Home</a></li>
					<li><a href="profile.php">My Profile</a></li>
					<li><a href="logoff.php">Log off</a></li>
				</ul>
			</div>

			<div id="userProfileDiv">
				<!-- editprofile -->
				<h3>Add timetable</h3>
				<hr />
				<br />
				<div id="editprofile">
					<div id="courseInfo">
						<form name="timeSheet" action="" method="post">
							<input type='hidden' name='username' value="<?=$username?>" /> <input
								type="hidden" id='timeSlotNum' name="timeSlotNum" value="" />
							<p>Please fill in your available time.</p>
							<div id="timeSlot">
								<table id="timeTable">
									<thead>
										<tr>
											<td style="padding-left: 30px">Available Date</td>
											<td style="padding-left: 30px">Begin Time</td>
											<td style="padding-left: 30px">End Time</td>
										</tr>
									</thead>
									<tbody id="timeTableBody">
									</tbody>
								</table>
							</div>
							<input type="button" onclick="add_time();" value="Add" /> <input
								type="submit" name="commit" onclick="get_info();" value="Submit" />
						</form>
						<div class="cl">&nbsp;</div>
					</div>
				</div>
				<!--end for editprofile-->
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
				</div>
				<!--end for footer-->
			</div>
			<!--end for footerContainer-->
		</div>
		<!--end of container-->
	</div>
	<!--end of shell-->
</body>
<script>
add_time();
</script>
</html>
