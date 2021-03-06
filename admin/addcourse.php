<?php
ob_start();

include('../function.php');
include('../config.php');
require('common/header.php');

$getBranchList=displayResult('tbl_course_branch');

if(isset($_POST['admission']))
{
	$id='';
	$id=$_POST['id'];
	$cName=$_POST['cName'];
	$branch=$_POST['branch'];
	$aIntake=$_POST['aIntake'];
	$aeligib=mysql_real_escape_string($_POST['aeligib']);
	$aDuration=$_POST['aDuration'];
	$aFees=$_POST['aFees'];
	$createDate=date("Y-m-d H:i:s");
	$data=array(
							'course_name 	'=>$cName,
							'branch' 	=>$branch,
							'intake'=>$aIntake,
							
							'eligibility'=>$aeligib,
							'duration  '=>$aDuration,
							
							'fees '=>$aFees,
							'create_date '=>$createDate
							);
							//print_r($data);
							if($id)
							{
						
								$result=updateName("tbl_courses",$data,$id);//if ID already exist then upadate the data
								$mess="<div class='alert alert-success fade in' id='success'>
								<strong>Success!</strong> Updated Successfully.
								</div>";
									header("Refresh: 1;addcourse.php");
							}
							else
							{
									
								$result=dbRowInsert('tbl_courses',$data);//if id is doesnot exist then isert the data
								
									 $mess="<div class='alert alert-success fade in' id='success'>
									<strong>Success!</strong> Sucessfully Inserted.
									</div>";
									header("Refresh: 1;addcourse.php");
							}
						
							if(empty($result))
							{
							
								$mess="<div class='alert alert-danger fade in' id='success'>
								<strong>Danger! </strong> Something went wrong, go back and try again!
								</div>";
								header("Refresh: 1;addcourse.php");
						
							}
	
	}


if(isset($_POST['delete']))
{
				$courseId=$_POST['id'];
				$getId='';
				$query=mysql_query("SELECT * FROM tbl_courses WHERE id=$courseId");
				while($row=mysql_fetch_array($query))
				{
					$getId=$row['id'];
				
				}
				if($getId)
				{
					$mess="<div class='alert alert-success fade in' id='success'>
						<strong>Success! </strong> Sucessfully Deleted
						</div>";
						header("Refresh: 1;addcourse.php");
						mysql_query("DELETE FROM tbl_courses WHERE id =$courseId ");
				}
				else
				{
					$mess="<div class='alert alert-danger fade in' id='success'>
						<strong>Danger! </strong> Something went wrong, go back and try again!
						</div>";
						header("Refresh: 1;addcourse.php");
				}
}

?>

        <div id="page-wrapper">
		
            <div class="container-fluid">
			<div class="col-lg-8">
                <h1 class="page-header">
                            Add Course</h1>
                        
            </div>
                             
		<div  class="row" id="course_tbl_view">
			<div class="col-md-10 col-md-offset-1">
         		<div class="mess" ><?php if(isset($mess)){echo $mess;}?></div>
						<div class="panel panel-default panel-table">
							  <div class="panel-heading">
								<div class="row">
										
								  <div class="col col-xs-6">
									<h3 class="panel-title">Course</h3>
								  </div>
								  <div class="col col-xs-6 text-right">
									<button type="button" class="btn btn-sm btn-primary btn-create btnCreate" id="createNewAdm">Create New</button>
									<button type="button" class="btn btn-sm btn-primary btn-create btnAdmission" id="deleteAdmission">Delete All</button>	
								  </div>
								</div>
							  </div>
							  <div class="panel-body">
										<table class="table table-striped table-bordered table-list paginationTable">
											  <thead>
												<tr>
													<th>Sl.No</th>
													<th>Course Name </th>
													<th>Branch</th>
													<th>Intake</th>
													<th>Eligibility</th>
													<th>Duration</th>
													<th>Fees</th>
													<th>Edit</th>
													<th>Delete</th>
												</tr> 
											  </thead>
												 <tbody>
												  <?php
															
														//displaying the data in table
															$selectAdmission=displayAdmission(); 
															  $i=1;
															  if($selectAdmission)
															  {
																foreach($selectAdmission as $row)
																{
																?>
																	<tr data-user-id="<?php echo $row['id'] ?>">
																	<?php
																	  echo ' <td class="hidden-xs">'.$i.'</td>
																
																	 
																	
																		 <td class="hidden-xs">'.substr($row['course_name'],0,50).'</td>
																		   <td class="hidden-xs">'.substr($row['branch'],0,50).'</td>
																		    <td class="hidden-xs">'.$row['intake'].'</td>
																			 <td class="hidden-xs">'.substr($row['eligibility'],0,50).'</td>
																			<td class="hidden-xs">'.$row['duration'].'</td>
																			  <td class="hidden-xs">'.$row['fees'].'</td>
																				
																				 <td align="center">
																			   <button type="button" class="btn btn-default editAdmission" value='.$row['id'].'><em class="fa fa-pencil"></em></button>  </td>
																			   
																					<td><form method="POST"><input type="hidden" name="id" value='.$row['id'].'><input type="submit" class="btn btn-danger fa fa-trash" name="delete" value="Delete"> </form> </td>
																					 </tr>';
																				$i++;
																}
																}
																?>
															
															
														</tbody>
										</table>
							
							  </div>
                
            </div>

        </div>
    </div>
		<div  class="row" id="formAdmis" style="display: none;">
				<div class="col-md-10 col-md-offset-1">
						<div class="panel panel-default panel-table">
							<div class="panel-heading">
							<div class="row">
									
									  <div class="col col-xs-6">
										<h3 class="panel-title">Add Course </h3>
									  </div>
							  </div>
						</div>
		
				 <div class="panel-body">
							  <form method="POST" action="" name="formAdmission" class="formAdmission" enctype="multipart/form-data">
								<div class="row">
										<div class="col-lg-5">
												<input type="hidden" name="id" id="id" value="">
								
												
												<div class="form-group">
														<label>Course Name</label>
														<input type="text"  name="cName" id="cName" class="form-control"   required></textarea>
												 </div>
												<div class="form-group">
														<label>Branch</label>
														<input type="text"  name="branch" id="branch" class="form-control"   required></textarea>
												 </div>
												   <div class="form-group">
								 
												<label>Intake</label>
											   
												<input type="number"  min="1" step=01 class="form-control " placeholder="Intake"  id="aIntake"  name="aIntake" required><br>
								
											</div>
												<div class="form-group">
														<label>Eligibility</label>
														<textarea  name="aeligib" id="aeligib" class="form-control" rows="3"  required></textarea>
												 </div>
												
											
										
									 
										<div class="form-group">
								 
											<label>Duration</label>
										     <input type="text" class="form-control " placeholder="Course Duration"  id="aDuration"  name="aDuration" ><br>
										
								
										</div>
									 
									 
									  <div class="form-group">
								 
											<label>Fee</label>
										   
											<input type="text" class="form-control " placeholder="Fees"  id="aFess"  name="aFees" ><br>
								
									 </div>
										  
									
									  <div class="form-group">
									   <input type="submit"  class="btn btn-info" value="save" name="admission">
									 <button class="btn btn-info confirm" id="admiscancel" name="admiscancel" value="Cancel" type="button">Cancel </button>
										</div>
										
								</div>
							</div>
						</form> 
					</div>
					</div>
					</div>
					</div>
					</div>
					</div>
                <!-- /.row -->

<?php
require('common/footer.php');
?>
