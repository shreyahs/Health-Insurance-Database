<!DOCTYPE html>
<html>
	<?php 
		include "header.php"; 
		$tracelogMsg= date("F j, Y, g:i a")."*****Trace Log opened*****".PHP_EOL;
		error_log($tracelogMsg, 3, "log/trace.log");
		$errorlogMsg= date("F j, Y, g:i a")."*****Error Log opened*****".PHP_EOL;
		error_log($errorlogMsg, 3, "log/error.log");
	?>
	<head>
		<link rel="stylesheet" href="css/style.css">
		<br>
		<div class="login-links">
	
			<a href="memberlogin.php" style="text-decoration:none">
			<div class="username">Member Login</div></a>
			<br><br>
			<a href="employeelogin.php" style="text-decoration:none">
			<div class="username">Employee Login</div></a>
			<div class="vr">
			<p style="margin:40px auto;padding:20px;float:left; display: block;"><img src="img/images.jpg"  style="width:1000px;height:500px;" >
			</div>
			
		</div>
		
	</head>
	
</html>
