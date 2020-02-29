<?php
  include "header.php";
  include "dbconnect.php";
  $status=0;
  function function_alert($message) { 
      
    // Display the alert box  
    echo "<script>
	window.location.href='localhost:8080/www/p2/memberlogin.php';
	alert('$message');</script>"; 
} 
  
 if(isset($_POST['signup']))
	{
		if((isset($_POST['fname']) && $_POST['fname'] !='') && 
		   (isset($_POST['lname']) && $_POST['lname'] !='') &&
		   (isset($_POST['email']) && $_POST['email'] !='') &&
		   (isset($_POST['pwd']) && $_POST['pwd'] !='') &&
		   (isset($_POST['pwd2']) && $_POST['pwd2'] !='') &&
		   (isset($_POST['dob']) && $_POST['dob'] !=''))
		   {
		
			   $fname=$_POST['fname'];
			   $lname=$_POST['lname'];
			   $email=$_POST['email'];
			   $pwd=$_POST['pwd'];
			   $dob=$_POST['dob'];
			   
			   $new_id_sql = "select max(memberid) newid from member;";
			   $insertsql = "insert into member (fname, lname, email, userpassword, dob)
			           values('$fname','$lname','$email',sha1('$pwd'), '$dob');";
				
				if(mysqli_query($dbConnect, $insertsql)) 
				{ 
			        $status=1;
					$result = mysqli_query($dbConnect,$new_id_sql);
					$row = mysqli_fetch_array($result);
					$msg = $row['newid'];
						
					$tracelogMsg= date("F j, Y, g:i:s").":- New MemberID $msg data inserted in!".PHP_EOL;
					error_log($tracelogMsg, 3, "log/trace.log");
				
					header("location:memberlogin.php?memberid=$msg");
					function_alert($msg);
					exit;						
				}
				else 
				{ 
					$errorlogMsg =  date("F j, Y, g:i:s").":- Unable to signup! Please provide all required fields in the specified formats!".PHP_EOL;
					error_log($errorlogMsg, 3, "log/error.log");
					echo "Unable to signup! Please provide all required fields in the specified formats!";
					$status=0;
				}
			}
			
		   
	}	
?>
<!DOCTYPE html>
<html>
	<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" >
			<div class="block">
			<div class="p_title">New Member Signup</div><br>
			<div>
				<label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;*First Name:</label>
				<input type="text" name="fname" required placeholder="First name...">
			</div><br>
			<div>
				<label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;*Last Name:</label>
				<input type="text" name="lname" required placeholder="Last name...">
			</div><br>
			<div>
				<label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;*User Email:</label>
				<input type="text" name="email" required placeholder="Email...">
			</div><br>
			<div>
				<label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;*Password:</label>
				<input type="password" name="pwd" required placeholder="Password...">
			</div><br>
			<div>
				<label>*Confirm Password:</label>
				<input type="password" name="pwd2" required placeholder="Confirm Password...">
			</div><br>
			<div>
				<label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;*Date of Birth:</label>
				<input type="text" name="dob" required placeholder="Date of birth(YYYY-MM-DD)...">
			</div>
			<button class="newbutton" type="submit" name="signup">Signup</button>
			<p style="font-size:9px;"> *required field&nbsp;</p>
			</div>
	</form>
</html>
