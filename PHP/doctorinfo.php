<?php 
	include "header.php";
    require('dbconnect.php');
	session_start();
	$usertype = $_SESSION['user_type'];
	//$usertype="emp";
	$sql = "select doctorid, fname, lname, hospital, licensedate,institution,address, gender from doctor;";
			
	$result = mysqli_query($dbConnect, $sql);
	if(!$result )
	{
		$errorlogMsg =  date("F j, Y, g:i:s").":- Error in getting Available Doctors Information!".PHP_EOL;
		error_log($errorlogMsg, 3, "log/error.log");
	}
?>

<!DOCTYPE html>
<html>
	<h4>AVAILABLE DOCTORS</h4>
	<?php
		echo "<table>
			<tr><th>DoctorID</th><th>FistName</th><th>LastName</th><th>Hospital</th>
			<th>LicenseDate</th><th>Institution</th><th>AddressInstitution</th><th>Gender</th></tr>";
     
		while($row = mysqli_fetch_array($result))
		{
			echo "<tr>";
			echo "<td>" . $row['doctorid'] . "</td>";
			echo "<td>" . $row['fname'] . "</td>";
			echo "<td>" . $row['lname'] . "</td>";
			echo "<td>" . $row['hospital'] . "</td>";
			echo "<td>" . $row['licensedate'] . "</td>";
			echo "<td>" . $row['institution'] . "</td>";
			echo "<td>" . $row['address'] . "</td>";
			echo "<td>" . $row['gender'] . "</td>";
			if (!empty($usertype) && ($usertype == 'emp')) 
	   { 
			echo "<td>" ?>
			<a href="updatedoctorinfo.php?doc_id=<?php echo $row['doctorid']; ?>" alt="edit" >Edit</a> 
			<?php
			echo "</td>";
	   }
			echo "</tr>";
		}
		echo "</table><br>"; 
	   if (!empty($usertype) && ($usertype == 'emp')) 
	   { 
   ?>
		<h6><a href="newdoctor.php" style="text-decoration:none">Add New Doctor</a></h6>
				
		<?php 
		} 
		?>
</html>