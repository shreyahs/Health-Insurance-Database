<?php
  include "header.php";
  include "dbconnect.php";
  
  if(isset($_GET['plan_id'])){
	  $planid = $_GET['plan_id'];
 $sql = "SELECT planid, plantype, monthlypremium, deductible, coinsurance, outofpocketlimit, tenure from plan where planid =$planid";
$result = mysqli_query($dbConnect, $sql);
 $row = mysqli_fetch_array($result);
}

	
	if(isset($_POST['updateplan']))
	{   
			$plantype = $_POST['plantype'];
			$monthlypremium = $_POST['monthlypremium'];
			$deductible = $_POST['deductible'];
			$coinsurance = $_POST['coinsurance'];
			$outofpocket = $_POST['outofpocket'];
			$tenure = $_POST['tenure'];
			$updatesql = "call proc_update_planinfo( $planid,'$plantype',$monthlypremium,$deductible,$coinsurance,$outofpocket, $tenure);";
			//echo $updatesql;	
			$result2 = mysqli_query($dbConnect, $updatesql);
	if(!$result2 )
	{
		$errorlogMsg =  date("F j, Y, g:i:s").":- Error in updating Plan Information for plan($planid)!".PHP_EOL;
		error_log($errorlogMsg, 3, "log/error.log");
		echo "Unable to update profile, please enter valid information!"; 
	}
	else
	{
		$tracelogMsg= date("F j, Y, g:i:s").":- Plan info updated for ($planid)!".PHP_EOL;
		error_log($tracelogMsg, 3, "log/trace.log");
		header("location:planinfo.php");
		exit;
	}
	}	
 ?>
  
<!DOCTYPE html>
<html>

  <form method="post" >
  		<div class="block">
		
		<div class="p_title" style="test-align:center;">Update Plan Information<br><br></div>
		
     
		<div>
       <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Plan Type:</label>
		<input type="text" name="plantype" required placeholder ="" value="<?php echo $row ['plantype']; ?>" ><br>
		</div><br>
		<div>
        <label>Monthly Premium:</label>
		<input type="text" name="monthlypremium"required placeholder ="" value="<?php echo $row ['monthlypremium']; ?>"><br>
		</div><br>
		<div>
        <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Deductible:</label>
		<input type="text" name="deductible" required placeholder ="" value="<?php echo $row ['deductible']; ?>"><br>
		</div><br>
		<div>
        <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Coinsurance:</label>
		<input type="text" name="coinsurance" required placeholder ="" value="<?php echo $row ['coinsurance']; ?>"><br>
		</div><br>
		<div>
        <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;OutOfPocket:</label>
		<input type="text" name="outofpocket" required placeholder ="" value="<?php echo $row ['outofpocketlimit']; ?>"><br>
		</div>
		<div><br>
        <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tenure:</label>
		<input type="text" name="tenure" placeholder ="" value="<?php echo $row ['tenure']; ?>"><br>
		</div>
		<br>
		<button class="newbutton" type="submit" name="updateplan">Update Plan Info</button>
		
	</div>
	
  </form>

 </html>