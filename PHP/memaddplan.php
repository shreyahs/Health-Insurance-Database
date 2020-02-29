<?php
  include "header.php";
  include "dbconnect.php";
  session_start();
  $empid = $_SESSION['user_id'];
   
  $memselect = "select m.memberid, m.fname, m.lname 
                from member m 
			    where m.memberid not in (select  memberid from memberrecord); ";
				
  $memlist=mysqli_query($dbConnect, $memselect); 
  
  $planselect = "select p.planid, p.plantype from plan p ";
				
  $planlist=mysqli_query($dbConnect, $planselect); 
	
  if(isset($_POST['add']))
  {
	if((isset($_POST['mem_id']) && $_POST['mem_id'] !='') && 
	   (isset($_POST['plan_id']) && $_POST['plan_id'] !=''))
	{
		$memberid=$_POST['mem_id'];
		$planid=$_POST['plan_id'];
        $new_id_sql = "select max(recordno) newid from memberrecord;";
		$insertsql = "insert into memberrecord(memberid, planid) values('$memberid','$planid');";
				
		if(mysqli_query($dbConnect, $insertsql)) 
		{ 
			$tracelogMsg= date("F j, Y, g:i:s").":- Assigned plan($planid) to new Member ($memberid)".PHP_EOL;
			error_log($tracelogMsg, 3, "log/trace.log");

			$result = mysqli_query($dbConnect,$new_id_sql);
			$row = mysqli_fetch_array($result);
			$newid = $row['newid'];
			$insertsql2 = "insert into updates(memberid, recordno, empid)	values('$memberid', $newid,'$empid');";
					  
			if(mysqli_query($dbConnect, $insertsql2)) 
			{ 
		        $tracelogMsg= date("F j, Y, g:i:s").":- Inserted into updates table".PHP_EOL;
				error_log($tracelogMsg, 3, "log/trace.log");
				header('location:employeeinfo.php');
				exit;
			}
			else
			{
				$errorlogMsg =  date("F j, Y, g:i:s").":- Error in inserting into updates table!".PHP_EOL;
				error_log($errorlogMsg, 3, "log/error.log");
			}	
		}
		else 
		{ 
			$errorlogMsg =  date("F j, Y, g:i:s").":- Error in assigning plan to member!".PHP_EOL;
			error_log($errorlogMsg, 3, "log/error.log");
			echo $errorlogMsg;
		}
	}
	else
	{
		echo "Please provide both MemberID and PlanID to add!";
	}
  }
?>
<!DOCTYPE html>
<html>
 <form action="<?php echo $_SERVER['PHP_SELF']?>"  method="post">
	<div class="block">
	<div class="p_title" style="test-align:center;">Assign Plan to Member<br><br></div>
      <label>Member ID :</label>
        <select name="mem_id">  
        <option value="">--- Select ---</option>  
        <?php  
            $select=$_POST['mem_id'];       
            while($row_list=mysqli_fetch_array($memlist)){  
        ?>  
        <option value="<?php echo $row_list['memberid']; ?>"
		<?php 
		    if($row_list['memberid']==$select){ echo "selected=$select"; } ?>
		>  
        <?php echo $row_list['memberid']. ' ' .$row_list['fname']. ' '.$row_list['lname'];?>  
        </option>  
		<?php  } ?>
		
        </select>&nbsp;&nbsp;
		<?php echo $row_list['memberid']; ?>		
       <label>Plan ID :</label>
        <select name="plan_id">  
        <option value="">--- Select ---</option>  
        <?php  
            $select=$_POST['plan_id'];       
            while($row_list=mysqli_fetch_array($planlist)){  
        ?>  
        <option value="<?php echo $row_list['planid']; ?>"
		<?php 
		    if($row_list['planid']==$select){ echo "selected=$select"; } ?>
		>  
        <?php echo $row_list['planid'].' ' .$row_list['plantype'];?>  
        </option>  
		<?php  } ?>
		
        </select>&nbsp;&nbsp;
		<?php echo $row_list['memberid']; ?>
		<br><br>
	<button class="newbutton" type="submit" name="add">Assign Plan</button>
	</div>
	</form>
</html>