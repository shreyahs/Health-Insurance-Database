<?php 
date_default_timezone_set('America/Los_angeles'); 
if(isset($_GET['logout']))
{
	$tracelogMsg= date("F j, Y, g:i a")."*****Trace Log closed*****".PHP_EOL;
	error_log($tracelogMsg, 3, "log/trace.log");
	$errorlogMsg= date("F j, Y, g:i a")."*****Error Log closed*****".PHP_EOL;
	error_log($errorlogMsg, 3, "log/error.log");
	session_destroy();
	header('location:index.php?logout=true');
	exit;
}
?>