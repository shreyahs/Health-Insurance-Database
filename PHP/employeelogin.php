<?php 
	require('dbconnect.php');
	date_default_timezone_set('America/Los_angeles'); 
	session_start();
		
	if(isset($_POST['login']))
	{
		if((isset($_POST['userid']) && $_POST['userid'] !='') && (isset($_POST['password']) && $_POST['password'] !=''))
		{
			$userid = $_POST['userid'];
			$password = $_POST['password'];
			$utype = 'emp';
			
			$sql = "select fname, lname from employee where empid = '$userid' and password = sha1('".$password."')";
			
			$result = mysqli_query($dbConnect,$sql);
			$numRows = mysqli_num_rows($result);
			
			if($numRows  == 1)
			{
				$row = mysqli_fetch_assoc($result);
				$_SESSION['user_id'] = $userid;
				$_SESSION['first_name'] = $row['fname'];
				$_SESSION['last_name'] = $row['lname'];
				$_SESSION['user_type'] =  $utype;
				
				$tracelogMsg= date("F j, Y, g:i:s").":- EmployeeID $userid logged in".PHP_EOL;
				error_log($tracelogMsg, 3, "log/trace.log");
				error_log($tracelogMsg, 3, "log/error.log");
				
				header('location:employeeinfo.php');
				exit;
			}
			else
			{
				$errorMsg =  "Please check EmployeeID/Password!";
				$errorlogMsg =  date("F j, Y, g:i:s").":- Please check EmployeeID/Password for $userid".PHP_EOL;
				error_log($errorlogMsg, 3, "log/error.log");
			}
		}
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Employee Login Page</title>
		<link rel="stylesheet" href="css/style.css">
	</head>

	<body>
		<div class="block">
			<h5>Employee Login</h5>
			<?php 
				if(isset($errorMsg))
				{
					echo "<div class='error-msg'>";
					echo $errorMsg;
					echo "</div>";
					unset($errorMsg);
				}	
				if(isset($_GET['logout']))
				{
					echo "<div class='success-msg'>";
					echo "You have successfully logout";
					echo "</div>";		
				}
			?>
			<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
				<div class="field-container">
					<label>EmployeeID:</label>
					<input type="text" name="userid" required placeholder="EmployeeID...">
				</div>
				<div class="field-container">
					<label>&nbsp;&nbsp;&nbsp;&nbsp;Password:</label>
					<input type="password" name="password" required placeholder="Password...">
				</div>
					<button class="newbutton" type="submit" name="login">Login</button>
			</form>
		</div>
	</body>
</html>