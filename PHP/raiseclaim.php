<?php
  include "header.php";
  include "dbconnect.php";
  session_start();
  $memid = $_SESSION['user_id'];
	
  $status=0;
  function function_alert($message) { 
      
    // Display the alert box  
    echo "<script>
	window.location.href='localhost:8080/www/p2/memberlogin.php';
	alert('$message');</script>"; 
} 
  
 if(isset($_POST['raiseclaim']))
	{
		if((isset($_POST['billid']) && $_POST['billid'] !='') &&
		   (isset($_POST['doctorid']) && $_POST['doctorid'] !='') &&
		   (isset($_POST['treatment']) && $_POST['treatment'] !='') &&
		   (isset($_POST['amount']) && $_POST['amount'] !='') &&
		   (isset($_POST['claimdate']) && $_POST['claimdate'] !=''))
		   {
			   $billid=$_POST['billid'];
			   $doctorid=$_POST['doctorid'];
			   $treatment=$_POST['treatment'];
			   $amount=$_POST['amount'];
			   $claimdate=$_POST['claimdate'];
			   
			   $insertsql = "insert into claim (memberid, doctorid, billid, treatment, claimamount, claimdate)
			           values('$memid', '$doctorid', '$billid','$treatment','$amount', '$claimdate');";
					   
				$selectsql = "select * from claim where billid ='$billid' and doctorid = '$doctorid' and memberid = '$memid'";
				$result = mysqli_query($dbConnect,$selectsql);
				$numRows = mysqli_num_rows($result);
				if(mysqli_query($dbConnect, $insertsql)) 
				{ 
			        $status=1;
					
					$tracelogMsg= date("F j, Y, g:i:s").":- New claim raised!".PHP_EOL;
					error_log($tracelogMsg, 3, "log/trace.log");
					header("location:memberinfo.php");
					//function_alert($msg);
					exit;						
				}
				else 
				{ 
					if ($numRows==1) 
					{
						echo "Claim already raised for the given bill $billid";
					
					}
					else
					{	
						$errorlogMsg =  date("F j, Y, g:i:s").":- Error raising Claim, check field values provided!";
						error_log($errorlogMsg.PHP_EOL, 3, "log/error.log");
						echo $errorlogMsg;
					//function_alert($errorlogMsg);
				   } 
				}	   
			}
		   
	}	
?>
<!DOCTYPE html>
<html>
	<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" >
			<div class="block">
			<div class="p_title">Raise New Claim</div><br>
			
			<div>
				<label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Bill ID:</label>
				<input type="text" name="billid" required placeholder="(ex: 1234)">
			</div><br>
			<div>
				<label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Doctor ID:</label>
				<input type="text" name="doctorid" required placeholder="(ex: 1234)">
			</div><br>
			<div>
				<label>&nbsp;&nbsp;&nbsp;&nbsp; Treatment:</label>
				<input type="text" name="treatment" required placeholder="(ex: Fracture)">
			</div><br>
			<div>
				<label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  Amount:</label>
				<input type="text" name="amount" required placeholder="(ex: 1234)">
			</div><br>
			<div>
				<label>Date of Claim:</label>
				<input type="text" name="claimdate" required placeholder="(date in YYYY-MM-DD format)">
			</div>
			<button class="newbutton" type="submit" name="raiseclaim">Raise Claim</button>
			</div>
		
	</form>
</html>
