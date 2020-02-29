<?php
  include "header.php";
  include "dbconnect.php";
  session_start();
  $memid = $_SESSION['user_id'];

  $sql = "select email,addressline,city,state,pincode from member m	where m.memberid = $memid;";
  $result = mysqli_query($dbConnect, $sql);
	if(!$result )
	{
		$errorlogMsg =  date("F j, Y, g:i:s").":- Error in getting Member Profile Information for update!".PHP_EOL;
		error_log($errorlogMsg, 3, "log/error.log");
	}
	
 if(isset($_POST['updateprofile']))
 {

 $email = $_POST['email'];
 $address = $_POST['address'];
 $city = $_POST['city'];
 $state = $_POST['state'];
 $zipcode = $_POST['zipcode'];
 $updatesql = "call proc_update_memberprofile( '$memid','$email','$address','$city','$state','$zipcode');";
 //echo $updatesql;
 $result2 = mysqli_query($dbConnect, $updatesql);
	if(!$result2 )
	{
		$errorlogMsg =  date("F j, Y, g:i:s").":- Error in updating Member Profile Information for update!".PHP_EOL;
		error_log($errorlogMsg, 3, "log/error.log");
		echo "Unable to update profile, please enter valid information!"; 
	}
	else
	{
		$tracelogMsg= date("F j, Y, g:i:s").":- Member Profile updated!".PHP_EOL;
		error_log($tracelogMsg, 3, "log/trace.log");
		header('location:memberinfo.php');
		exit;
	}
 }
?>
<!DOCTYPE html>
<html>
<?php while($row = mysqli_fetch_array($result))	{ ?>
  <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" >
		<div class="block">
		<div class="p_title" style="test-align:center;">Update Member Profile<br><br></div>
		
		<div>
        <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Email:</label>
		<input type="text" name="email" value="<?php echo $row ['email']; ?>" ><br>
		</div><br>
		<div>
        <label>Address Line:</label>
		<input type="text" name="address" value="<?php echo $row ['addressline']; ?>"><br>
		</div><br>
		<div>
        <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;City:</label>
		<input type="text" name="city" value="<?php echo $row ['city']; ?>"><br>
		</div><br>
		<div>
        <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; State:</label>
		<input type="text" name="state" value="<?php echo $row ['state']; ?>"><br>
		</div><br>
		<div>
        <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ZipCode:</label>
		<input type="text" name="zipcode" value="<?php echo $row ['pincode']; ?>"><br>
		</div>
		<button class="newbutton" type="submit" name="updateprofile">Update Profile</button>
	</div>
  </form>
  <?php 
  }
  ?>
</html>