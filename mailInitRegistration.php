
<?php
require './PHPMailer-master/class.phpmailer.php';
require './PHPMailer-master/class.smtp.php';

$mail = new PHPMailer ();
$mail->IsSMTP (); // set mailer to use SMTP
$mail->Host = "ssl://smtp.gmail.com"; // specify main and backup server
$mail->Port = 465; // set the port to use
$mail->SMTPAuth = true; // turn on SMTP authentication
$mail->Username = "facethecheetah@gmail.com"; // your SMTP username or your gmail username
                                              
// include 'mail_password.php'; //includes my password
$mail->Password = "vickysmash"; // your SMTP password or your gmail password

$from = "facethecheetah@gmail.com"; // Reply to this email
$mail->From = $from;
$mail->FromName = "Tutor me!"; // Name to indicate where the email came from when the recepient received
$mail->WordWrap = 50; // set word wrap
$mail->IsHTML ( true ); // send as HTML
?>