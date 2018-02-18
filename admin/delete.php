<?php
	include './include/db.php'; 
	
	if(isset($_REQUEST['delete'])){
		
		$deleted = $_REQUEST['delete'];
		 
		$deleteQuery="DELETE FROM `category` WHERE `category`.`cat_id` = '$deleted'";
			
		if($conn->query($deleteQuery)==true){
			header('location: category.php');
			session_start();

 
			 $_SESSION['Successfully'] = "Successfully Deleted";
		}else {
			die($conn->error);
		}
	
	} 




 
	
?>