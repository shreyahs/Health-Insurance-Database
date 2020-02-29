<?php 
	include "header.php";
    require('dbconnect.php');
	session_start();
		
	if(!isset($_SESSION))
	{
		header('location:index.php');
		exit;
	}
		
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
		<h4>MY CURRENT MEMBERS</h4>
			<?php include "memberslist.php";?>	
	</div>
	
	<div class="column">
		<h4>MY TASKS</h4>
		<h6><a href="claimslist.php" style="text-decoration:none">Manage Claims</a></h6>
		<br>
	<h6><a href="planinfo.php" style="text-decoration:none">Manage Plans</a></h6>
	<br>
	<h6><a href="doctorinfo.php" style="text-decoration:none">Manage Doctors</a></h6>
		
	</div>
  </div>
	
</html>
