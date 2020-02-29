<?php
  $dbServer = "localhost";
  $dbUser = "root";
  $dbPassword = "";
  $dbName = "insurancecompany";

  $dbConnect = mysqli_connect($dbServer,$dbUser,$dbPassword,$dbName);

  if(!$dbConnect)
  {
	$errorlogMsg =  date("F j, Y, g:i:s").":- Error connecting to database!".PHP_EOL;
	error_log($errorlogMsg, 3, "log/error.log");
	die(mysqli_error());
  }

 ?>
