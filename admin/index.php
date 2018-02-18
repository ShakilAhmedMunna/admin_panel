<?php 
	
	include './include/header.php'; 
	require('./include/db.php');
	
	session_start();
	// If form submitted, insert values into the database.
	if (isset($_POST['username'])){
		// removes backslashes
		$username = stripslashes($_REQUEST['username']);
		//escapes special characters in a string
		$username = mysqli_real_escape_string($conn,$username);
		$password = stripslashes($_REQUEST['password']);
		$password = mysqli_real_escape_string($conn,$password);
		//Checking is user existing in the database or not
		$query = "SELECT * FROM `users` WHERE user_name='$username' and password='".md5($password)."'";
		$result = mysqli_query($conn,$query) or die(mysql_error());
		$rows = mysqli_num_rows($result);
		if($rows==1){
			$_SESSION['username'] = $username;
			// Redirect user to category.php
			header("Location: category.php");
			}else{
			echo "<div class='alert alert-danger text-center'> Username/password is incorrect. </div><br/>";
		}
		}else{
	?>
 
<?php } ?>


<div class="container" style="margin-top:8%;">
	<div class="row" >
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Welcome to my site</h3>
                </div>
                <div class="panel-body">
                    <form role="form" action="" method="post" name="login">
                        <fieldset>
                            <div class="form-group">
                                <input class="form-control" placeholder="E-mail" name="username" type="email" autofocus>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Password" name="password" type="password" value="">
                            </div>
                            <!-- Change this to a button or input when using this as a form -->
							<input name="submit" class="btn btn-success btn-block" type="submit" value="Login" />
                            
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>



</body>
</html>