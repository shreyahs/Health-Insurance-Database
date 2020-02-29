<?php 
	require('dbconnect.php');
	if(!isset($_SESSION))
	{
		header('location:index.php');
		exit;
	}
	else
	{
	  $empid = $_SESSION['user_id'];
	}
	$sql = "select m.memberid, p.plantype, m.fname, m.lname, r.deductiblespent,r.outofpocketspent
			from employee e, memberrecord r, member m, updates u, plan p
			where e.empid = u.empid and r.recordno = u.recordno
			and r.memberid = m.memberid 
			and r.planid = p.planid
			and e.empid = $empid order by m.memberid;";
	
	$result = mysqli_query($dbConnect, $sql);
	if(!$result )
	{
		$errorlogMsg =  date("F j, Y, g:i:s").":- Error in getting Employee Members List!".PHP_EOL;
		error_log($errorlogMsg, 3, "log/error.log");
	}
?>

<!DOCTYPE html>
<html>
	<?php
		echo "<table>
		     <tr><th>MemberID</th><th>PlanType</th><th>FirstName</th><th>LastName</th><th>DeductibleSpent</th><th>OutofPocketSpent</th></tr>";

		while($row = mysqli_fetch_array($result))
		{
			echo "<tr>";
			echo "<td>" . $row['memberid'] . "</td>";
			echo "<td>" . $row['plantype'] . "</td>";
			echo "<td>" . $row['fname'] . "</td>";
			echo "<td>" . $row['lname'] . "</td>";
			echo "<td>" . $row['deductiblespent'] . "</td>";
			echo "<td>" . $row['outofpocketspent'] . "</td>";
			echo "</tr>";
		}
		echo "</table>";
	?> 
</html>
