
<?php 
include '../db/config.php';




if (isset($_POST['edit'])) 
{
 	$control_number = $_POST['control_number'];	
 	$names = $_POST['emp_name'];
 	$date_deployed = $_POST['dateDeploy'];
 	$gender = $_POST['gender'];
 	$batch_no = $_POST['batch'];
 	$remarks = $_POST['remarks'];
 
	$update = "UPDATE tbl_deployedlist SET names='$names',date_deployed='$date_deployed',gender='$gender',batch_no = '$batch_no', remarks='$remarks' where list_id ='$control_number'";
	$query= $db->query($update);


	header('location:../manpowerRequestDataSummary.php?msg="success"');

}









 ?>




