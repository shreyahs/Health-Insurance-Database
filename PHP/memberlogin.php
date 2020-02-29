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
			$utype = 'member';
			
			$sql = "select fname,lname from member where memberid = '$userid' and userpassword = sha1('".$password."')";
			
			$result = mysqli_query($dbConnect,$sql);
			$numRows = mysqli_num_rows($result);
			
			if($numRows == 1)
			{
				$row = mysqli_fetch_assoc($result);
				$_SESSION['user_id'] = $userid;
				$_SESSION['first_name'] = $row['fname'];
				$_SESSION['last_name'] = $row['lname'];
				$_SESSION['user_type'] =  $utype;
				
				$tracelogMsg= date("F j, Y, g:i:s").":- MemberID $userid logged in".PHP_EOL;
				error_log($tracelogMsg, 3, "log/trace.log");
				error_log($tracelogMsg, 3, "log/error.log");
				
				header('location:memberinfo.php');
				exit;
			}
			else
			{
				$errorMsg =  "Please check MemberID/Password!";
				$errorlogMsg =  date("F j, Y, g:i:s").":- Please check MemberID/Password for $userid!".PHP_EOL;
				error_log($errorlogMsg, 3, "log/error.log");
				
			
			}
		}
	}	
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Member Login Page</title>
		<link rel="stylesheet" href="css/style.css">
	</head>

	<body>	
		<div class="block">
			<h5>Member Login</h5>
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
					echo "You have successfully logged out";
					echo "</div>";
				}	
			?>
			<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
				<div class="field-container">
					<label>MemberID:</label>
					<input type="text" name="userid" required placeholder="MemberID...">
				</div>
				<div class="field-container">
					<label>&nbsp;&nbsp;Password:</label>
					<input type="password" name="password" required placeholder="Password...">
				</div>
				<button class="newbutton" type="submit" name="login">Login</button>
				<p style="font-size:11px;"> New User&nbsp;<a href="signup.php" style="text-decoration:none;font-size:13px;">Signup</a></p>			
			</form>
		</div>
	</body>
</html>