<?php
  include "header.php";
  include "dbconnect.php";
  
  if(isset($_POST['newplan']))
  {
	if((isset($_POST['plantype']) && $_POST['plantype'] !='') && 
	   (isset($_POST['premium']) && $_POST['premium'] !='') &&
	   (isset($_POST['deductible']) && $_POST['deductible'] !='') &&
	   (isset($_POST['coinsurance']) && $_POST['coinsurance'] !='') &&
	   (isset($_POST['outofpocket']) && $_POST['outofpocket'] !=''))
	{
		
		$ptype=$_POST['plantype'];
		$premium=$_POST['premium'];
		$deduc=$_POST['deductible'];
		$coins=$_POST['coinsurance'];
		$outofpkt=$_POST['outofpocket'];
			   
		$sql = "insert into plan (plantype, monthlypremium, deductible, coinsurance, outofpocketlimit)
			    values('$ptype','$premium','$deduc','$coins', '$outofpkt');";

		if(mysqli_query($dbConnect, $sql)) 
		{ 

	        $tracelogMsg= date("F j, Y, g:i:s").":- New Plan data inserted in!".PHP_EOL;
			error_log($tracelogMsg, 3, "log/trace.log");
				
			header('location:employeeinfo.php');
			exit;
		}
		else 
		{ 
			$errorlogMsg =  date("F j, Y, g:i:s").":- Unable add New Plan data!".PHP_EOL;
			error_log($errorlogMsg, 3, "log/error.log");
			echo "Unable add New Plan data!, please enter data in specified formats!";
		}
					
	 }
		   
  }	
?>
<!DOCTYPE html>
<html>
  <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" >
		<div class="block">
		<div class="p_title" style="test-align:center;">Add New Plan<br><br></div>
		
		<div>
        <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Plan Type:</label>
		<input type="text" name="plantype" required placeholder="Plan type"><br>
		</div><br>
		<div>
        <label>&nbsp;&nbsp;&nbsp;Monthly Premium:</label>
		<input type="text" name="premium" required placeholder="(ex: 100)"><br>
		</div><br>
		<div>
        <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Deductible:</label>
		<input type="text" name="deductible" required placeholder="(ex: 1000)"><br>
		</div><br>
		<div>
        <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; CoInsurance:</label>
		<input type="text" name="coinsurance" required placeholder="(ex: 10)"><br>
		</div><br>
		<div>
        <label>Out Of Pocket Limit:</label>
		<input type="text" name="outofpocket" required placeholder="(ex: 10000)"><br>
		</div>
		<button class="newbutton" type="submit" name="newplan">Add Plan</button>
	</div>
  </form>
</html>
