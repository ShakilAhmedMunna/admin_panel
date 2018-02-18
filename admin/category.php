<?php
	include './include/permission.php'; 
	include './include/header.php'; 
	include './include/db.php'; 
	require('./include/funtions.php');
 
	
	$result ="Data Inserted Successfully.";
	$notification = false;
	
	if(isset($_POST['Submit']))
	{  
		
		$category_name= ucfirst($_POST['category_name']);
		$category_name = sk_XSS($category_name);
		$date = date("Y-m-d H:i:s");
		
		//$category_name = $mysqli->real_escape_string($category_name);
		
		if (empty($category_name)){ 
			
			$notification = true;
			
			}else{
			// checking category_name that item already has or not 
			
			$cat_name_check ="SELECT * FROM `category` where cat_name = '$category_name'";
			$cat_name_check_data=$conn->query($cat_name_check);
			
			if($cat_name_check_data->num_rows > 0)
			{
				$_SESSION['already'] = "Already Has value";
				}else{
				
				
				
				// ##################################################
				
				$insertQuery="INSERT INTO `category` (`cat_name`, `date_time`, `status`) VALUES ('$category_name', '$date', '1')";
				
				if($conn->query($insertQuery)==true){
					
					//	echo $result;
					$_SESSION['Successfully'] = "Successfully";
					}else {
					die($conn->error);
				}
				
			}
			
			
		}
		
		
	}
	
	
	// Update 
	
	if(isset($_POST['editCategory'])){
		$cat_single_id =  $_POST['cat_edit']; 
		$cat_single_name = ucfirst($_POST['cat_single_name']); 
		$cat_single_name = sk_XSS($cat_single_name); 
		$cat_single_status =   $_POST['cat_status']; 
		
		if($cat_single_status == 'Active'){
			$status = 1;
			}else{
			$status = 2;
		}
		
		// checking category_name that item already has or not 
		
		$name_check ="SELECT * FROM `category` where cat_name = '$cat_single_name'";
		$name_check_data=$conn->query($name_check);
		
		if($name_check_data->num_rows > 0)
		{
			$_SESSION['already'] = "This name already has";
			$updateQuery="UPDATE `category` SET `status` = '$status' WHERE `category`.`cat_id` = '$cat_single_id'";
			
			if($conn->query($updateQuery)==true){
				//$_SESSION['Successfully'] = "Successfully Update";
				}else {
				die($conn->error);
			}	
			}else{
			
			$updateQuery="UPDATE `category` SET `cat_name` = '$cat_single_name', `status` = '$status' WHERE `category`.`cat_id` = '$cat_single_id'";
			
			if($conn->query($updateQuery)==true){
				$_SESSION['Successfully'] = "Successfully Update";
				}else {
				die($conn->error);
			}	
		}
	} 
	
	
	
	include './include/nav.php';
	
?>






<div class="container">
	
    <div class="row">
		
        <div class="col-md-12">
			
			<div class="row" style="width:100%;" >
				<div class="col-md-5" style="width:30%; float:right;">
					 <input type="text" class="form-control" placeholder="Search" id="search" />
				</div>
				
				
					
					<!-- <div style="width:30%; float:right;" >
						
						<div class="input-group">
							
							<div class="input-group-btn">
								<button class="btn btn-primary" type="submit">
									<span class="glyphicon glyphicon-search"></span>
								</button>
							</div>
						</div>
						
					</div>
					 	-->
				
				
				
				
				
			</div>
			
			<?php 
				if($notification == true){
					
				?>
				<div class="row" style="width:100%;"> 
					<div class="col-md-5"> 
						<div class="alert alert-warning">
							<strong> </strong>  Fields can not be empty 
						</div>
					</div>
					
				</div>
				
				<?php 
				}
			?>
			
			
			
			<?php 
				
				if(isset($_SESSION['already'])){ 
				 	
				?>
				<div class="row" style="width:100%;"> 
					<div class="col-md-5"> 
						<div class="alert alert-success">
							<strong><?php  echo $_SESSION['already']; ?></strong>  
						</div>
					</div>
					
				</div>			
				
				
				<?php 
					
					
					unset($_SESSION['already']);
				}
				
			?>  
			
			
			<?php 
				
				if(isset($_SESSION['Successfully'])){ 
				 	
				?>
				<div class="row" style="width:100%;"> 
					<div class="col-md-5"> 
						<div class="alert alert-success">
							<strong><?php  echo $_SESSION['Successfully']; ?></strong>  
						</div>
					</div>
					
				</div>			
				
				
				<?php 
					
					
					unset($_SESSION['Successfully']);
				}
				
			?>
			
			
			
			
			<br/>
			
	 
			
            <div class="panel panel-default panel-table"  id="tableData" class="table" id="myTable">
				<div class="panel-heading">
					<div class="row">
						<div class="col col-xs-6">
							<h3 class="panel-title"><b>Product Category</b></h3>
						</div>
						<div class="col col-xs-6 text-right">
							<button type="button" class="btn btn-sm btn-primary btn-create" data-toggle="modal" data-target="#myModal" >Create New</button>
						</div>
					</div>
				</div>
				<div class="panel-body">
					<table class="table table-striped table-bordered table-list" >
						<thead>
							<tr>
								<th><em class="fa fa-cog"></em></th>
								<th class="hidden-xs">ID</th>
								<th>Name</th>
								<th>Date</th>
								<th>Status</th>
							</tr> 
						</thead>
						<tbody>
							
							<?php
								
								//code for selecting data.
								$selectQuery="SELECT * FROM `category` ORDER BY `category`.`cat_id` DESC";
								$result_data=$conn->query($selectQuery);
								
								if($result_data->num_rows>0)
								{
									while ($row=$result_data->fetch_assoc()) {/* echo $row['cat_name'];   */
										
									?>
									
									<div id="myModal<?php echo $row['cat_id']; ?>" class="modal fade" role="dialog">
										<div class="modal-dialog">
											
											<!-- Modal content-->
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal">&times;</button>
													<h4 class="modal-title">Delete</h4>
												</div>
												<div class="modal-body">
													
													<center> <h5 class="modal-title">Are You Sure To Delete Item Name? </h5> </center>
													
													<br/>
													
													
													
													
													<a href="delete.php?delete=<?php echo $row['cat_id']; ?>" class="btn btn-default">Delete</a>
													
													
													
												</div>
												<div class="modal-footer">
													<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
												</div>
											</div>
											
										</div>
									</div>
									
									
									
									<!--  ############################## -->
									
									<div id="edit<?php echo $row['cat_id']; ?>" class="modal fade" role="dialog">
										<div class="modal-dialog">
											
											
											
											<!-- Modal content-->
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal">&times;</button>
													<h4 class="modal-title">Edit  </h4>
												</div>
												<div class="modal-body">
													
													<?php 
														$cat_id_single =  $row['cat_id'];
														
														
														$single = "SELECT * FROM `category` WHERE `category`.`cat_id` = '$cat_id_single'";
														
														
														$single_cat =$conn->query($single);
														
														if($single_cat->num_rows > 0)
														{
															/*---------------------------------------------------------  */
															$single_row=$single_cat->fetch_assoc();
															
														?>
														
														<form action="<?php $_SERVER['PHP_SELF']?>" method="post">
															<div class="form-group">
																<label for="Category">Category : </label>
																<input type="text" value="<?php echo $row['cat_name']; ?>" class="form-control" name="cat_single_name">
																
																<div class="form-group">
																	<label for="sel1">Status   </label>
																	<select class="form-control" name="cat_status">
																		<?php if($row['status'] == 1){ ?> 
																			<option select="selected">Active</option>
																			<option>Inactive</option>
																			<?php }else{ ?> 
																			
																			<option select="selected">Inactive</option>
																			<option>Active</option>
																		<?php }  ?> 
																		
																	</select>
																</div>
																<input type="hidden" value="<?php echo $row['cat_id']; ?>" name="cat_edit" >
															</div>
															<?php 
																
															}
															
															
														?> 
														
														<input type="submit" class="btn btn-default" name="editCategory" value="Update"> 
													</form>
													
												</div>
												<div class="modal-footer">
													<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
												</div>
											</div>
											
										</div>
									</div>
									
									
									
									
									
									
									<!--  ############################## -->		
									
									
									<tr class="jsearch-row" class="header">
										<td align="center" class="jsearch-field">
											<a class="btn btn-default" data-toggle="modal" data-target="#edit<?php echo $row['cat_id']; ?>" ><em class="fa fa-pencil"></em></a>
											<a class="btn btn-danger" data-toggle="modal" data-target="#myModal<?php echo $row['cat_id']; ?>" ><em class="fa fa-trash"></em></a>
										</td>
										<td class="hidden-xs"><?php echo $row['cat_id'];  ?></td>
										<td> <?php   echo $row['cat_name']; ?></td>
										<td><?php echo $row['date_time'];  ?></td>
										
										<?php 
											if($row['status'] == 1){
												?>	<td>Active</td> 	<?php 
												}else{
												?>	<td>Inactive</td> 	<?php 
											}
											
										?>	
										
										
										
										
									</tr>
									
									<?php
										
									}
									
								}
								
							?> 
							
							
							
						</tbody>
					</table>
					
				</div>
				<!--<div class="panel-footer">
					<div class="row">
					<div class="col col-xs-4">Page 1 of 5
					</div>
					<div class="col col-xs-8">
					<ul class="pagination hidden-xs pull-right">
					<li><a href="#">1</a></li>
					<li><a href="#">2</a></li>
					<li><a href="#">3</a></li>
					<li><a href="#">4</a></li>
					<li><a href="#">5</a></li>
					</ul>
					<ul class="pagination visible-xs pull-right">
					<li><a href="#">«</a></li>
					<li><a href="#">»</a></li>
					</ul>
					</div>
					</div>
				</div> -->
			</div>
		</div>
	</div>
</div>


<!-- Modal -->

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Create</h4>
			</div>
			<div class="modal-body">
				
				
				
				
				<form action="<?php $_SERVER['PHP_SELF']?>" method="post">
					
					<div class="form-group">
						<label for="Category">Category :  </label>
						<input type="text" class="form-control" id="Category" name="category_name">
					</div>
					
					<input type="submit" class="btn btn-default" name="Submit" value="Create">	
					
				</form>
				
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
		
	</div>
</div> 

<!-- Modal -->

<?php
	include './include/footer.php';
	
?>

