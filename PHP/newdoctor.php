<?php
  include "header.php";
  include "dbconnect.php";
  
  if(isset($_POST['newdoctor']))
  {
	if((isset($_POST['fname']) && $_POST['fname'] !='') && 
	   (isset($_POST['lname']) && $_POST['lname'] !='') )
	{
		
		$fname=$_POST['fname'];
		$lname=$_POST['lname'];
			   
		$sql = "insert into doctor (fname, lname)
			    values('$fname','$lname');";

		if(mysqli_query($dbConnect, $sql)) 
		{ 

	        $tracelogMsg= date("F j, Y, g:i:s").":- New Doctor data inserted in!".PHP_EOL;
			error_log($tracelogMsg, 3, "log/trace.log");
				
			header('location:employeeinfo.php');
			exit;
		}
		else 
		{ 
			$errorlogMsg =  date("F j, Y, g:i:s").":- Unable add New Doctor data!".PHP_EOL;
			error_log($errorlogMsg, 3, "log/error.log");
			echo "Unable add New Doctor data!, please enter data in specified formats!";
		}
					
	 }
		   
  }	
?>
<!DOCTYPE html>
<html>
  <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" >
		<div class="block">
		<div class="p_title" style="test-align:center;">Add  New Doctor<br><br></div>
		
		<div>
        <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;FirstName:</label>
		<input type="text" name="fname" required placeholder="First Name"><br>
		</div><br>
		<div>
		<div>
        <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;LastName:</label>
		<input type="text" name="lname" required placeholder="Last Name"><br>
		</div><br>
		<div>
       
		<button class="newbutton" type="submit" name="newdoctor">Add Doctor</button>
	</div>
  </form>
</html>
