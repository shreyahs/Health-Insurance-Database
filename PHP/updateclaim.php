<?php
	include "header.php";
	require('dbconnect.php');
	session_start();
	$empid = $_SESSION['user_id'];
	$claimselect = "select c.claimid
					from claim c, memberrecord r, employee e, updates u
					where e.empid = u.empid and u.recordno = r.recordno
					and c.memberid = r.memberid
					and c.claimstatus !='Approved'
					and e.empid = $empid;";
	
	$claimlist=mysqli_query($dbConnect, $claimselect); 
	
	$status = array("Pending", "Denied", "Approved");
	
	if (isset($_POST['back']))
	{
	  header('location:claimslist.php');
	}
	
	if ((isset($_POST['update'])))
	{
		if ((isset($_POST['c_id'])) && ($_POST['c_id'] !='') && (isset($_POST['c_status']))  && ($_POST['c_status'] !='') ) 
		{
			$setid = $_POST['c_id'];
			$setstatus = $_POST['c_status'];
		
			$sql = "update claim set claimstatus = '$setstatus'	where claimid = $setid;	";
		
			if(mysqli_query($dbConnect, $sql)) 
			{ 	
				$tracelogMsg= date("F j, Y, g:i:s").":- Claim status updated!".PHP_EOL;
				error_log($tracelogMsg, 3, "log/trace.log");
				header('location:employeeinfo.php');
				exit;
			}
			else 
			{ 
				$errorlogMsg =  date("F j, Y, g:i:s").":- Unable to update claim status!".PHP_EOL;
				error_log($errorlogMsg, 3, "log/error.log");
				echo $errorlogMsg;
			}
		}
		else
		{
			echo "Please provide both ClaimID and ClaimStatus to update!";
		}
	}	
?>

<!DOCTYPE html>
<html>
<form action="<?php echo $_SERVER['PHP_SELF']?>"  method="post">
	<div class="block">
	<div class="p_title" style="test-align:center;">Update Claim Status<br><br></div>
      <label>Claim ID :</label>
        <select name="c_id">  
        <option value="">--- Select ---</option>  
        <?php  
            $select=$_POST['c_id'];       
            while($row_list=mysqli_fetch_array($claimlist)){  
        ?>  
        <option value="<?php echo $row_list['claimid']; ?>"
		<?php 
		    if($row_list['claimid']==$select){ echo "selected=$select"; } ?>
		>  
        <?php echo $row_list['claimid'];?>  
        </option>  
		<?php  } ?>
		
        </select>&nbsp;&nbsp;
		<?php echo $row_list['claimid']; ?>		
        <label>Claim Status :</label> 
		<select name="c_status">
        <option value="">--- Select ---</option>
        <?php 
		    $select2=$_POST['c_status']; 
			foreach($status as $item){ 
		?>
        <option value="<?php echo $item; ?>"
		  <?php if ($item == $select2) echo "selected=$select2"; ?>
		>
		<?php echo $item;?> 
		</option>
        <?php echo strtolower($item); }  ?>
        </select>
		<br><br>
	<button type="submit" name="back">Back</button>&nbsp;&nbsp;
	<button style="float:right" type="submit" name="update">Update</button>	
	</div>
  </form>    
</html>  