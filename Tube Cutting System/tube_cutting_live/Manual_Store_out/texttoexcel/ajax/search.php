<?php
include '../db/config.php';


 $model_name = isset($_POST['model_name'])?$_POST['model_name']:'not yet';
 $car_type = isset($_POST['car_type'])?$_POST['car_type']:'not yet';
 $design_request = isset($_POST['design_request'])?$_POST['design_request']:'not yet';
 $design_content = isset($_POST['design_content'])?$_POST['design_content']:'not yet';

$sql = "SELECT * FROM qc_processflow where model_name like '$model_name' and car_type like '$car_type' and design_content like '$design_content' and design_request like '$design_request'";
$query = $db->query($sql);

$rowCount = mysqli_num_rows($query);

if ($rowCount > 0) {
	
	echo '<input type="text" class="ajax1" value="'.$rowCount.'">';
}
else
{
	echo $rowCount;
}



?>


