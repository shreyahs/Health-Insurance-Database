<?php 
    require('dbconnect.php');
	if(!isset($_SESSION))
	{
		header('location:index.php');
		exit;
	}
	else
	{
	  $memid = $_SESSION['user_id'];
	}	
	$sql = "select m.memberid, p.plantype, r.deductiblespent,r.outofpocketspent,r.startDate,r.premiumPaymentStatus
					from member m, memberrecord r, plan p
					where m.memberid = r.memberid and p.planid = r.planid 
					and m.memberid = $memid;";
	$result = mysqli_query($dbConnect, $sql);
	if(!$result )
	{
		$errorlogMsg =  date("F j, Y, g:i:s").":- Error in getting Member Plan Information!".PHP_EOL;
		error_log($errorlogMsg, 3, "log/error.log");
	}
?>
       
<!DOCTYPE html>
<html>
	<?php			
		echo "<table>
		     <tr><th>MemberID</th><th>PlanType</th><th>DeductibleSpent</th><th>OutofPocketSpent</th>
			 <th>StartDate</th><th>PremiumPayment</th></tr>";

		while($row = mysqli_fetch_array($result))
		{
			echo "<tr>";
			echo "<td>" . $row['memberid'] . "</td>";
			echo "<td>" . $row['plantype'] . "</td>";
			echo "<td>" . $row['deductiblespent'] . "</td>";
			echo "<td>" . $row['outofpocketspent'] . "</td>";
			echo "<td>" . $row['startDate'] . "</td>";
			echo "<td>" . $row['premiumPaymentStatus'] . "</td>";
			echo "</tr>";
		}
		echo "</table>";	
?>
</html>
