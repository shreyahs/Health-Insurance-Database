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
	$sql = "select email,addressline,city,state,pincode from member m	where m.memberid = $memid;";
	$result = mysqli_query($dbConnect, $sql);
	if(!$result )
	{
		$errorlogMsg =  date("F j, Y, g:i:s").":- Error in getting Member Profile Information!".PHP_EOL;
		error_log($errorlogMsg, 3, "log/error.log");
	}
?>
       
<!DOCTYPE html>
<html>
	<?php			
		echo "<table>
		     <tr><th>Email</th><th>AddressLine</th><th>City</th><th>State</th><th>ZipCode</th></tr>";

		while($row = mysqli_fetch_array($result))
		{
			echo "<tr>";
			echo "<td>" . $row['email'] . "</td>";
			echo "<td>" . $row['addressline'] . "</td>";
			echo "<td>" . $row['city'] . "</td>";
			echo "<td>" . $row['state'] . "</td>";
			echo "<td>" . $row['pincode'] . "</td>";
			echo "<td>" ?>
			<a href="updateprofile.php?mem_id=<?php echo $memid; ?>" alt="edit" >Edit</a> 
			<?php
			echo "</td>";
	  
			echo "</tr>";
		}
		echo "</table>";	
?>
</html>
