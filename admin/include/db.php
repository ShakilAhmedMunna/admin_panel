<?php
 
$conn= new mysqli("localhost","root","","adminpannel");
// Check connection
/* if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  } */
 
if($conn->connect_error)
{
	die("Error: ".$conn->connect_error);
}
//echo "Connection established successfully.";
?>