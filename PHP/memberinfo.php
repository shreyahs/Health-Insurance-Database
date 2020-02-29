<?php 
    include "header.php";
	require('dbconnect.php');
	session_start();	
	if(!isset($_SESSION))
	{
		header('location:index.php');
		exit;
	}	
    else
	{
	  $memid = $_SESSION['user_id'];
	}	
	$newmem = 0;
    $sql="select memberid from memberrecord where memberid =$memid;";
	$result = mysqli_query($dbConnect, $sql);
	$numRows = mysqli_num_rows($result);
	if($numRows == 0)	{ $newmem = 1;}
?>

<!DOCTYPE html>
<html>
	<div class="header">
		<span class="user-name">
			<?php echo "Hi "; ?>
			<?php echo ucwords($_SESSION['first_name']);?>
			<?php echo ucwords($_SESSION['last_name']);?> 
		</span>
		<a href="logout.php?logout=true" class="logout-link">Logout</a>	
	</div>
	<hr>
	
	<div class="container2">	
	<div class="column">
		<h4>MY PROFILE</h4>
			<?php include "memprofile.php";?>	
		<h4>MY CURRENT PLAN</h4>
			<?php include "memplaninfo.php";?>	
	</div>
	
	<div class="column">
		<h4>QUICK LINKS</h4>
		
		<h6><a href="planinfo.php" style="text-decoration:none">Available Plans</a></h6><br>
		<h6><a href="doctorinfo.php" style="text-decoration:none">Available Doctors</a></h6><br>
		<h6><a href="memstatements.php" style="text-decoration:none">My Statements</a></h6><br>
		<?php if (!$newmem == 1) { ?>
		<h6><a href="raiseclaim.php" style="text-decoration:none">Raise New Claim</a></h6>
		<br><?php } ?>
		
		
	</div>
  </div>	
</html>