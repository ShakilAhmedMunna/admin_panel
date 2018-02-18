<?php
	include './include/db.php'; 
	
	if(isset($_REQUEST['delete'])){
		
		$deleted = $_REQUEST['delete'];
		 
		$deleteQuery="DELETE FROM `brand` WHERE `brand`.`brand_id` = '$deleted'";
			
		if($conn->query($deleteQuery)==true){
			header('location: brands.php');
			session_start();

 
			 $_SESSION['Successfully'] = "Successfully Deleted";
		}else {
			die($conn->error);
		}
	
	} 




 
	
?>