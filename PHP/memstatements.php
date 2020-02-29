<?php 
	include "header.php";
	require('dbconnect.php');
	session_start();
	
	$memid = $_SESSION['user_id'];
		
	$sql = 	"select s.statementno, c.claimid, c.claimamount, c.claimdate, c.treatment, s.amountcovered
             from claim c, statement s
            where c.claimid = s.claimid
	        and s.memberid = $memid;";
			
	$result = mysqli_query($dbConnect, $sql);
	$numRows = mysqli_num_rows($result);
	if(!$result )
	{
		$errorlogMsg =  date("F j, Y, g:i:s").":- Error in getting Member Statements!".PHP_EOL;
		error_log($errorlogMsg, 3, "log/error.log");
	}	
?>

<!DOCTYPE html>
<html>
  
	<h4>MY STATEMENTS</h4>
	<?php
		if($numRows >= 1)
		{
			echo "<table>
			<tr><th>StatementNo</th><th>ClaimID</th><th>ClaimAmount</th><th>ClaimDate</th><th>Treatment</th><th>AmountCovered</th></tr>";

			while($row = mysqli_fetch_array($result)){
				echo "<tr>";
				echo "<td>" . $row['statementno'] . "</td>";
				echo "<td>" . $row['claimid'] . "</td>";
				echo "<td>" . $row['claimamount'] . "</td>";
				echo "<td>" . $row['claimdate'] . "</td>";
				echo "<td>" . $row['treatment'] . "</td>";
				echo "<td>" . $row['amountcovered'] . "</td>";
				echo "</tr>";
			}
			echo "</table>";
			
		}
		else{
			echo "<div class='p_title'>No Statements Yet!<br><br></div>";
		}
	?> 
	
</html>