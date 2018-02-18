<?php
	include './include/permission.php'; 
	include './include/header.php'; 
	include './include/db.php'; 
	require('./include/funtions.php');
 
	
	$result ="Data Inserted Successfully.";
	$notification = false;
	
	if(isset($_POST['Submit']))
	{  
		
		$brand_name= ucfirst($_POST['brand_name']);
		$brand_name = sk_XSS($brand_name);
		$date = date("Y-m-d H:i:s");
		
		
		
		if (empty($brand_name)){ 
			
			$notification = true;
			
			}else{
			// checking category_name that item already has or not 
			
			$brand_name_check ="SELECT * FROM `brand` where brand_name = '$brand_name'";
			$brand_name_check_data=$conn->query($brand_name_check);
			
			if($brand_name_check_data->num_rows > 0)
			{
				$_SESSION['already'] = "Already Has value";
				}else{
				
				
				
				// ##################################################
				
				$insertQuery="INSERT INTO `brand` (`brand_name`, `brand_date_time`, `brand_status`) VALUES ('$brand_name', '$date', '1')";
				
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
	
	if(isset($_POST['editbrand'])){
		$brand_single_id =  $_POST['brand_edit']; 
		$brand_single_name = ucfirst($_POST['brand_single_name']); 
		$brand_single_name = sk_XSS($brand_single_name); 
		$brand_single_status =   $_POST['brand_status']; 
		
		if($brand_single_status == 'Active'){
			$status = 1;
			}else{
			$status = 2;
		}
		
		
		// checking category_name that item already has or not 
		
		$name_check ="SELECT * FROM `brand` where brand_name = '$brand_single_name'";
		$name_check_data=$conn->query($name_check);
		
		if($name_check_data->num_rows > 0)
		{
			$_SESSION['already'] = "This name already has";
			
			$updateQuery="UPDATE `brand` SET  `brand_status` = '$status' WHERE `brand`.`brand_id` = '$brand_single_id'";
			
			if($conn->query($updateQuery)==true){
				//$_SESSION['Successfully'] = "Successfully Update";
				}else {
				die($conn->error);
			}
			
			
		}else{
			$updateQuery="UPDATE `brand` SET `brand_name` = '$brand_single_name', `brand_status` = '$status' WHERE `brand`.`brand_id` = '$brand_single_id'";
			
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
			
            <div class="panel panel-default panel-table" id="tableData">
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
					<table class="table table-striped table-bordered table-list">
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
								$selectQuery="SELECT * FROM `brand` ORDER BY `brand`.`brand_id` DESC";
								$result_data=$conn->query($selectQuery);
								
								if($result_data->num_rows>0)
								{
									while ($row=$result_data->fetch_assoc()) { 
										
									?>
									
									<div id="myModal<?php echo $row['brand_id']; ?>" class="modal fade" role="dialog">
										
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
													
													
													
													
													<a href="brandsdelete.php?delete=<?php echo $row['brand_id']; ?>" class="btn btn-default">Delete</a>
													
													
													
												</div>
												<div class="modal-footer">
													<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
												</div>
											</div>
											
										</div>
									</div>
									
									
									
									<!--  ############################## -->
									
									<div id="edit<?php echo $row['brand_id']; ?>" class="modal fade" role="dialog">
										<div class="modal-dialog">
											
											
											
											<!-- Modal content-->
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal">&times;</button>
													<h4 class="modal-title">Edit  </h4>
												</div>
												<div class="modal-body">
													
													<?php 
														$cat_id_single =  $row['brand_id'];
														
														
														$single = "SELECT * FROM `brand` WHERE `brand`.`brand_id` = '$cat_id_single'";
														
														
														$single_cat =$conn->query($single);
														
														if($single_cat->num_rows > 0)
														{
															/*---------------------------------------------------------  */
															$single_row=$single_cat->fetch_assoc();
															
														?>
														
														<form action="<?php $_SERVER['PHP_SELF']?>" method="post">
															<div class="form-group">
																<label for="Category">Brand : </label>
																<input type="text" value="<?php echo $row['brand_name']; ?>" class="form-control" name="brand_single_name">
																
																<div class="form-group">
																	<label for="sel1">Status   </label>
																	<select class="form-control" name="brand_status">
																		<?php if($row['brand_status'] == 1){ ?> 
																			<option select="selected">Active</option>
																			<option>Inactive</option>
																			<?php }else{ ?> 
																			
																			<option select="selected">Inactive</option>
																			<option>Active</option>
																		<?php }  ?> 
																		
																	</select>
																</div>
																<input type="hidden" value="<?php echo $row['brand_id']; ?>" name="brand_edit" >
															</div>
															<?php 
																
															}
															
															
														?> 
														
														<input type="submit" class="btn btn-default" name="editbrand" value="Update"> 
													</form>
													
												</div>
												<div class="modal-footer">
													<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
												</div>
											</div>
											
										</div>
									</div>
									
									
									
									
									
									
									<!--  ############################## -->		
									
									
									<tr>
										<td align="center">
											<a class="btn btn-default" data-toggle="modal" data-target="#edit<?php echo $row['brand_id']; ?>" ><em class="fa fa-pencil"></em></a>
											<a class="btn btn-danger" data-toggle="modal" data-target="#myModal<?php echo $row['brand_id']; ?>" ><em class="fa fa-trash"></em></a>
										</td>
										<td class="hidden-xs"><?php echo $row['brand_id'];  ?></td>
										<td> <?php   echo $row['brand_name']; ?></td>
										<td><?php echo $row['brand_date_time'];  ?></td>
										
										<?php 
											if($row['brand_status'] == 1){
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
						<label for="Category">Brand :  </label>
						<input type="text" class="form-control" id="brand" name="brand_name">
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