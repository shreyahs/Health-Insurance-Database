<?php
  include "header.php";
  include "dbconnect.php";
  
  if(isset($_GET['doc_id'])){
	  $doctorid = $_GET['doc_id'];
 $sql = "SELECT doctorid, fname, lname,hospital, licensedate,institution, address from doctor where doctorid =$doctorid";
$result = mysqli_query($dbConnect, $sql);
 $row = mysqli_fetch_array($result);
}

	
	if(isset($_POST['updatedoctor']))
	{   
			$fname = $_POST['fname'];
			$lname = $_POST['lname'];
			$hospital = $_POST['hospital'];
			$licensedate = $_POST['licensedate'];
			$institution = $_POST['institution'];
			$address = $_POST['address'];
			$updatesql = "call proc_update_doctorinfo( $doctorid,'$fname','$lname','$hospital','$licensedate','$institution', '$address');";
			echo $updatesql;	
			$result2 = mysqli_query($dbConnect, $updatesql);
	if(!$result2 )
	{
		$errorlogMsg =  date("F j, Y, g:i:s").":- Error in updating Doctor Information for plan($doctorid)!".PHP_EOL;
		error_log($errorlogMsg, 3, "log/error.log");
		echo "Unable to update profile, please enter valid information!"; 
	}
	else
	{
		$tracelogMsg= date("F j, Y, g:i:s").":- Doctor info updated for ($doctorid)!".PHP_EOL;
		error_log($tracelogMsg, 3, "log/trace.log");
		header("location:doctorinfo.php");
		exit;
	}
	}	
 ?>
  
<!DOCTYPE html>
<html>

  <form method="post" >
  		<div class="block">
		
		<div class="p_title" style="test-align:center;">Update Doctor Information<br><br></div>
		
     
		<div>
       <label>&nbsp;&nbsp;&nbsp;&nbsp;FisrtName:</label>
		<input type="text" name="fname" required placeholder ="" value="<?php echo $row ['fname']; ?>" ><br>
		</div><br>
		<div>
        <label>&nbsp;&nbsp;&nbsp;&nbsp;LastName:</label>
		<input type="text" name="lname" required placeholder ="" value="<?php echo $row ['lname']; ?>"><br>
		</div><br>
		<div>
        <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Hospital:</label>
		<input type="text" name="hospital" placeholder ="" value="<?php echo $row ['hospital']; ?>"><br>
		</div><br>
		<div>
        <label>LicenseDate:</label>
		<input type="text" name="licensedate" placeholder ="Date in YYYY-MM-DD" value="<?php echo $row ['licensedate']; ?>"><br>
		</div><br>
		<div>
        <label>&nbsp;&nbsp;&nbsp;Institution:</label>
		<input type="text" name="institution" placeholder ="" value="<?php echo $row ['institution']; ?>"><br>
		</div>
		<div><br>
        <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Address:</label>
		<input type="text" name="address" placeholder ="" value="<?php echo $row ['address']; ?>"><br>
		</div>
		<br>
		<button class="newbutton" type="submit" name="updatedoctor">Update Doctor Info</button>
		
	</div>
	
  </form>

 </html>