<?php
include '../Connection/Connect_sql.php';
$operation = mysqli_real_escape_string($conn_sql, $_GET['operation']);
if($operation == "count_entries"){
	//$scooter_area = mysqli_real_escape_string($conn_sql, $_GET['scooter_area']);
	$sql = "SELECT request_id, distributor, kanban, scooter_station, request_date_time, status FROM tc_scanned_kanban WHERE status='Pending' OR status='Ongoing Picking'";
	$result = $conn_sql->query($sql);
	if($result->num_rows > 0){
		$rowcount = mysqli_num_rows($result);
		echo $rowcount;
	}else{
		$rowcount = mysqli_num_rows($result);
		echo $rowcount;
	}
}
$conn_sql->close();
?>
