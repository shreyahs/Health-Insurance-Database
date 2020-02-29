<?php 
	include "header.php";
    require('dbconnect.php');
	session_start();
	$empid = $_SESSION['user_id'];
	$claimsql = "select c.claimid, r.memberid, c.claimstatus, c.claimamount
					from claim c, memberrecord r, employee e, updates u
					where e.empid = u.empid and u.recordno = r.recordno
					and c.memberid = r.memberid
					and e.empid =$empid order by c.claimid;	";
	
	$result = mysqli_query($dbConnect, $claimsql);
	if(!$result )
	{
		$errorlogMsg =  date("F j, Y, g:i:s").":- Error in getting Employee Claims List!".PHP_EOL;
		error_log($errorlogMsg, 3, "log/error.log");
	}
?>

<!DOCTYPE html>
<html>
	<h4>MY CLAIMS LIST</h4>
	<?php
		echo "<table>
		     <tr><th>ClaimID</th><th>MemberID</th><th>ClaimStatus</th><th>ClaimAmount</th></tr>";
		while($row = mysqli_fetch_array($result)){
				echo "<tr>";
				echo "<td>" . $row['claimid'] . "</td>";
				echo "<td>" . $row['memberid'] . "</td>";
				echo "<td>" . $row['claimstatus'] . "</td>";
				echo "<td>" . $row['claimamount'] . "</td>";
				echo "</tr>";
		}   
		echo "</table>";
	?>	
	<br>
	<h6><a href="updateclaim.php" style="text-decoration:none">Update Claim Status</a></h6>	
</html>
	
  
		 
