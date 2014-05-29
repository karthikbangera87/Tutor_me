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
<!--[if lt IE 9]>
		<script src="js/modernizr.custom.js"></script>
	<![endif]-->
<script src="js/jquery.carouFredSel-5.5.0-packed.js"
	type="text/javascript"></script>
<script src="js/functions.js" type="text/javascript"></script>
  <?php $POST=array(); ?>
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
	<div class="shell">
		<div class="container">
			<header id="header">
				<img id="logo" src="css/images/logo.png" onClick="openLanding()" />
				<div class="cl">&nbsp;</div>
			</header>
			<div id="userProfileDiv">
				<section class="register">
					<h1>Register on Tutor Me!!</h1>
					<script>  
		  function change_form()
		  {
		  	document.information.action ="./dbRegister.php";
		  }
		  
		  function get_info() 
		  {
		  	var errlog = '';
			var email = $("input[name='email']").val();
			var gender = $("input[name='gender']").val();
		  	var username = $("input[name='username']").val();	
		  	var pwd1 = $("input[name='password']").val();
			var pwd2 = $("input[name='password2']").val();
			var fname = $("input[name='fname']").val();
			var lname = $("input[name='lname']").val();
			var phone = $("input[name='phone']").val();

			
			function valid() 
			{
				var flag = true;
				var reg1 = /^[a-z0-9]+@indiana\.edu+/;
				var reg2 = /^[a-zA-Z]+$/;
				var reg3 = /^[0-9]+$/;

		  		if(reg1.test(email) == false) {
					errlog += "->You should provide INDIANA UNIVERSITY email address ONLY without any special characters in your Username\n (Example: username@indiana.edu)\n";
		  		} 
				if(reg2.test(fname) == false) {
					errlog += "->Please Enter a valid first name - with no special characters or numbers\n";
		  		} 
				if(reg2.test(lname) == false) {
					errlog += "->Please Enter a valid last name - with no special characters or numbers\n";
		  		} 
				if(reg3.test(phone) == false) {
					errlog += "->Please provide a valid phone number - Numericals only!!\n";
		  		} 
                            if(phone.length < 10) {
					errlog += "->Please Enter a valid phone - Number cannot be less than 10 digits!!\n";
		  		} 
				if(reg2.test(username) == false) {
					errlog += "->Please Enter a valid Username - with no special characters or numbers\n";
				} if(pwd1==="" || pwd2==="") {
					errlog += "->Password cannot be empty\n";
				} if(pwd1!=pwd2) {
					errlog += "->Please make sure you enter identical passwords\n";
				} if(errlog.length!=0) {
					flag = false;
				}
				return flag;
		 	}
			
			var flag = valid();

			if (flag) 
			{
				change_form();
			} 
			else 
			{
				alert(errlog);
			}
		  } 		  
		  </script>
					<form name="information" method="post" action="">
						<div class="reg_section personal_info">
							<h3>Your Personal Information</h3>
							<input type="name" name="email" value=""
								placeholder="Your IU email*" size="2"> <br /> <input type="name"
								name="fname" value="" placeholder="First name*" size="2"
								maxlength="30" /> <input type="name" name="lname" value=""
								placeholder="Last name*" size="2" maxlength="30" /> <br /> <input
								type="name" name="phone" value="" placeholder="Phone number*"
								size="2" maxlength="10" /> <br /> <input type="name"
								name="major" value="" placeholder="Major" size="2" /> <input
								type="name" name="school" value="" placeholder="School" size="2" />
						</div>
						<div class="reg_section password">
							<h3>Your Account</h3>
							<input type="name" name="username" value=""
								placeholder="Your Username*" maxlength="30" /> <br /> <input
								type="password" name="password" value=""
								placeholder="Your Password*" maxlength="30" /> <br /> <input
								type="password" name="password2" value=""
								placeholder="Enter your Password again*" maxlength="30" /> <br />
						</div>
						<div class="reg_section password">
							<h3>Register as</h3>
							<select name="role">
								<option value="student" selected="selected">Student</option>
								<option value="tutor">Tutor</option>
							</select> <br> </br>
							<p>
								<input type="submit" name="commit" value="Sign up"
									style="float: left; margin-left: 350px;" onclick="get_info();">
							
							
							<p id="output"></p>
							</p>
					
					</form>
				</section>
			</div>
			<br /> <br />
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

</body>
</html>
