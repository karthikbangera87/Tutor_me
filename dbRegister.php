<?php

/* Inserts the user registration information into the database and sends an email to the user for confirmation */

include "dbConnect.php";

if (isset ( $_POST ) && ! empty ( $_POST )) {
	if (isset ( $_POST ['commit'] ) && ($_POST ['commit'] == 'Sign up')) {
		$email = $_POST ['email'];
		$username = $_POST ['username'];
		$password = $_POST ['password'];
		// check those optional choices
		$fname = (! empty ( $_POST ['fname'] )) ? $_POST ['fname'] : "";
		$lname = (! empty ( $_POST ['lname'] )) ? $_POST ['lname'] : "";
		$phone = (! empty ( $_POST ['phone'] )) ? $_POST ['phone'] : "";
		$major = (! empty ( $_POST ['major'] )) ? $_POST ['major'] : "";
		$school = (! empty ( $_POST ['school'] )) ? $_POST ['school'] : "";
		$status = 'no';
		$role = $_POST ['role'];
		
		$query1 = "SELECT * FROM User WHERE UserID = '$username'";
		$result = mysqli_query ( $con, $query1 );
		$no_rows = mysqli_num_rows ( $result );
		if ($no_rows > 0) {
			?>
<script type="text/javascript">
  				alert("Username already exists. Please select another username.");
				document.location.href = 'register.php';
				</script>
<?php
		}
		
		$query2 = "SELECT * FROM User WHERE Email = '$email'";
		$result = mysqli_query ( $con, $query2 );
		$no_rows = mysqli_num_rows ( $result );
		if ($no_rows > 0) {
			?>
<script type="text/javascript">
  				alert("Email already registered. Please proceed to login.");
				document.location.href = 'index.php';
				</script>
<?php
		exit();
		}
		
		$query3 = "INSERT INTO User (UserID, Password, FirstName, LastName, Email, Phone, Major, School, Status) VALUES ('$username', '$password', '$fname', '$lname', '$email', '$phone', '$major', '$school', '$status')";
		
		$result = mysqli_query ( $con, $query3 );
		if ($result) {
			if ($role == 'tutor') {
				$query5 = "INSERT INTO Tutor VALUES ('$username')";
				mysqli_query ( $con, $query5 );
			}
			
			require 'mailInitRegistration.php';
			
			$to = $email;
			$name = $username; // Recipient's name
			$actLink = 'http://www.cs.indiana.edu/cgi-pub/sauchakr/tutor/registrationConfirmation.php?userid=' . $username;
			
			$mail->AddAddress ( $to, $name );
			$mail->Subject = "Registration Confirmation";
			
			$body = "";
			$body .= "Hello " . $username . ":<br />";
			$body .= "Please click on the link below to confirm your registration with Tutor Me!!<br />";
			$body .= '<a href="' . $actLink . '">' . $actLink . "</a><br />";
			$body .= "<br />Thank you <br /> Tutor me!<br />";
			
			$mail->Body = $body; // HTML Body
			$mail->AltBody = $body; // Text Body
			if (! $mail->Send ()) {
				echo "Mailer Error: " . $mail->ErrorInfo;
			} else {
				?>
<script type="text/javascript">
  				alert("An email has been sent to you at the address provided. Please follow the link in the email to complete registration.");
  				document.location.href = 'index.php';
				</script>
<?php
			}
		} 

		else {
			die ( "Database query failed" . mysqli_error ( $con ) );
		}
	}
}

include "dbClose.php";

?>
