<?php
session_start ();
if (! isset ( $_SESSION ['username'] )) {
	header ( "Location: index.php" );
} else {
include "dbConnect.php";
function getUserInfo($userID) {
	global $con;
	$sql = "SELECT * FROM User WHERE UserID = '$userID'";
	
	$result = mysqli_query ( $con, $sql ) or die ( "Failed: " . mysqli_error ( $con ) );
	$numrows = mysqli_num_rows ( $result );
	
	if ($numrows == 1) {
		// $data = mysql_fetch_array ( $result, MYSQL_ASSOC );
		$data = mysqli_fetch_array ( $result, MYSQL_ASSOC );
		return $data;
	} else {
		echo "Cannot find UserID: $userID";
	}
}
function isEditable($userID) {
	return $userID == $_SESSION ['username'] ? true : false;
}
function isTutor($userID) {
	global $con;
	$sql = "SELECT * FROM Tutor WHERE TutorID = '$userID'";
	$result = mysqli_query ( $con, $sql ) or die ( "Failed: " . mysqli_error ( $con ) );
	return mysqli_num_rows ( $result ) == 1 ? TRUE : FALSE;
}
function getTimeTable($tutorID) {
	global $con;
	$date = date ( "Y-m-d" );
	$sql = "SELECT * FROM TimeTable WHERE TutorID = '$tutorID' AND Date >= $date";
	$result = mysqli_query ( $con, $sql ) or die ( "Failed: " . mysqli_error ( $con ) );
	
	return $result;
}
function populateViewInfoForm($userID) {
	$userInfo = getUserInfo ( $userID );
	$firstName = $userInfo ['FirstName'];
	$lastName = $userInfo ['LastName'];
	$name = $firstName . " " . $lastName;
	$email = $userInfo ['Email'];
	$phone = $userInfo ['Phone'];
	$school = $userInfo ['School'];
	$major = $userInfo ['Major'];
	
	echo "<form id='viewInfoForm'>

		  	<table cellpadding='0' cellspacing='0' border='0'>
		  		<tr>
			  		<td width=160px;><label>First Name:</label></td>
					<td id='tdFirstName'>$firstName</td>
				</tr>
				<tr>
					<td><label>Last Name:</label></td>
					<td id='tdLastName'>$lastName</td>
				</tr>
				<tr>
					<td><label>Email:</label></td>
					<td id='tdEmail'>$email</td>
				</tr>
				<tr>
					<td><labe>Phone:</label></td>
					<td id='tdPhone'>$phone</td>
				</tr>
				<tr>
					<td><label>School:</label></td>
					<td id='tdSchool'>$school</td>
				</tr>
				<tr>
					<td><label>Major:</label></td>
					<td id='tdMajor'>$major</td>
				</tr>";
	
	if (isEditable ( $userID )) {
		echo "<tr><td colspan='3' align='right'><input id='editInfoButton' type='button' value='Edit' onclick='onEditInfo()' /></td></tr>";
	}
	
	echo "</table>
		</form>
		  </div>";
}
function populateCourseAndRatings($tutorID) {
	$coursesAndRatings = getCoursesAndRatings ( $tutorID );
	
	echo "<table>";
	foreach ( $coursesAndRatings as $data ) {
		$courseId = $data ['CourseID'];
		$courseName = $data ['CourseName'];
		$rating = $data ['Rating'];
		echo "<tr>";
		echo "<td>$courseId</td>";
		echo "<td>$courseName</td>";
		if (! empty ( $rating )) {
			echo "<td><span class='stars'>$rating</span></td>";
		}
		echo "</tr>";
	}
	
	if (isEditable ( $tutorID ) == true) {
		echo "<tr>
				<td colspan='3' align='right'><input id='editCourseButton' type='button' value='Edit' onclick='onEditCourse()' /></td>
			  </tr>";
	}
	
	echo "</table>";
}
function populateEditCourseView($userID) {
	if (isEditable ( $userID ) == true) {
		$coursesAndRatings = getCoursesAndRatings ( $userID );
		echo "<table id='editCoursesTable'>";
		foreach ( $coursesAndRatings as $data ) {
			$courseId = $data ['CourseID'];
			$courseName = $data ['CourseName'];
			echo "<tr id=$courseId>";
			echo "<td>$courseId</td>";
			echo "<td>$courseName</td>";
			
			$tmp = '"' . $courseId . '"';
			echo "<td><a onclick='onRemoveCourse($tmp)'>Remove</a></td>";
			echo "</tr>";
		}
		
		echo "</table>";
		
		echo "<table>";
		$courseList = getCourses ();
		echo "<tr>";
		echo "<td colspan='2'><a>Add new course:</a><select id='newCourse' style='margin-left:5px;'>";
		
		foreach ( $courseList as $key => $value ) {
			// $tmp_result = $key . " " . $value;
			echo "<option value=" . $key . ">$value</option>";
		}
		
		echo "</select></td>";
		echo "<td align='right'><a onclick='onAddNewCourse()'>Go</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td align='right'><input id='doneUpdateButton' type='button' value='Done' onclick='onDoneUpdate()' /></td>";
		echo "<td align='right'><input id='cancleUpdateButton' type='button' value='Cancel' onclick='onCancleEditCourse()' /></td>";
		echo "</tr>";
		echo "</table>";
	}
}
function getCourses() {
	global $con;
	$query = "SELECT CourseID, CourseName FROM Course;";
	$result = mysqli_query ( $con, $query ) or die ( "Failed: " . mysqli_error ( $con ) );
	$courseList = array ();
	
	// while($row = mysql_fetch_assoc($result)) {
	while ( $row = mysqli_fetch_assoc ( $result ) ) {
		$courseList [$row ['CourseID']] = $row ['CourseName'];
	}
	
	return $courseList;
}
function getCoursesAndRatings($tutorID) {
	global $con;
	
	$query = "SELECT CO.CourseID, C.CourseName, AVG(R.Rating) as Rating
			FROM CourseOffer CO
			INNER JOIN Course C
			ON CO.CourseID = C.CourseID
			LEFT JOIN (SELECT * FROM Rating WHERE TutorID = '$tutorID') as R
			ON CO.CourseID = R.CourseID
			WHERE CO.TutorID = '$tutorID'
			GROUP BY CO.CourseID";
	$result = mysqli_query ( $con, $query ) or die ( "Failed: " . mysqli_error ( $con ) );
	$num_rows = mysqli_num_rows ( $result );
	$coursesAndRatings = array ();
	
	if ($num_rows > 0) {
		while ( $row = mysqli_fetch_array ( $result ) ) {
			array_push ( $coursesAndRatings, $row );
		}
	}
	
	return $coursesAndRatings;
}
}
?>