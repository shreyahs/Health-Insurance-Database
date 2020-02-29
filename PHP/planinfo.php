<?php 
	include "header.php";
    require('dbconnect.php');
	session_start();
	$usertype = $_SESSION['user_type'];
	//$usertype="emp";
	$sql = "select planid,plantype,monthlypremium, deductible,coinsurance,outofpocketlimit,tenure from plan;";
			
	$result = mysqli_query($dbConnect, $sql);
	if(!$result )
	{
		$errorlogMsg =  date("F j, Y, g:i:s").":- Error in getting Available Plans Information!".PHP_EOL;
		error_log($errorlogMsg, 3, "log/error.log");
	}
?>

<!DOCTYPE html>
<html>
	<h4>AVAILABLE PLANS</h4>
	<?php
		echo "<table>
			<tr><th>PlanID</th><th>PlanType</th><th>MonthlyPremium</th><th>Deductible</th><th>CoInsurance</th>
			<th>OutofPocketLimit</th><th>Tenure</th></tr>";
     
		while($row = mysqli_fetch_array($result))
		{
			echo "<tr>";
			echo "<td>" . $row['planid'] . "</td>";
			echo "<td>" . $row['plantype'] . "</td>";
			echo "<td>" . $row['monthlypremium'] . "</td>";
			echo "<td>" . $row['deductible'] . "</td>";
			echo "<td>" . $row['coinsurance'] . "</td>";
			echo "<td>" . $row['outofpocketlimit'] . "</td>";
			echo "<td>" . $row['tenure'] . "</td>";
			if (!empty($usertype) && ($usertype == 'emp')) 
	   { 
			echo "<td>" ?>
			<a href="updateplaninfo.php?plan_id=<?php echo $row['planid']; ?>" alt="edit" >Edit</a> 
			<?php
			echo "</td>";
	   }
			echo "</tr>";
		}
		echo "</table><br>"; 
	   if (!empty($usertype) && ($usertype == 'emp')) 
	   { 
   ?>
		<h6><a href="newplan.php" style="text-decoration:none">Add New Plan</a></h6>
		<br>
		<h6><a href="memaddplan.php" style="text-decoration:none">Assign Plan to Member</a></h6>
				
		<?php 
		} 
		?>
</html>