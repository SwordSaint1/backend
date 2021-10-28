<?php
session_start();
$scooter_station = $_SESSION["scooter_area"];
include '../Connection/Connect_sql.php';
$operation = mysqli_real_escape_string($conn_sql, $_GET['operation']);
if($operation == "count_entries_pending"){
	$sql = "SELECT status, status FROM tc_scanned_kanban WHERE status='Ongoing Picking' AND scooter_station='$scooter_station' AND (status = 'Pending' OR status = 'Ready for Delivery' OR store_out_date_time='')";
	$result = $conn_sql->query($sql);
	if($result->num_rows > 0){
		$rowcount = mysqli_num_rows($result);
		echo $rowcount;
	}else{
		$rowcount = mysqli_num_rows($result);
		echo $rowcount;
	}
}
else if($operation == "count_pending"){
	$operation = mysqli_real_escape_string($conn_sql, $_GET['operation']);
	$sql = "SELECT status FROM tc_scanned_kanban WHERE status = 'Pending' AND scooter_station='$scooter_station' GROUP BY(request_id)";
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
