<?php
include '../Connection/Connect_oracle.php';
include '../Connection/Connect_sql.php';
$operation = mysqli_real_escape_string($conn_sql, $_GET['operation']);
if($operation == "add_remarks_mm"){
	$id_scanned_kanban = mysqli_real_escape_string($conn_sql, $_GET['remarks_id_scanned_kanban']);
	$kanban = mysqli_real_escape_string($conn_sql, $_GET['remarks_kanban']);
	$kanban_num = mysqli_real_escape_string($conn_sql, $_GET['remarks_kanban_num']);
	$scan_date_time = mysqli_real_escape_string($conn_sql, $_GET['remarks_scan_date_time']);
	$request_date_time = mysqli_real_escape_string($conn_sql, $_GET['remarks_request_date_time']);
	$mm_remarks = mysqli_real_escape_string($conn_sql, $_GET['mm_remarks']);
	$scooter_station = mysqli_real_escape_string($conn_sql, $_GET['scooter_station']);
	$date_time = date("Y-m-d H:i:s");
	$sql = "INSERT INTO tc_mm_remarks (request_id, kanban, kanban_num, scooter_station, scan_date_time, request_date_time, mm_remarks, mm_date_time, mm_status)
	VALUES ('$id_scanned_kanban','$kanban','$kanban_num','$scooter_station','$scan_date_time','$request_date_time','$mm_remarks','$date_time','Unread')";
	if($conn_sql->query($sql) === TRUE){
		echo'Remarks Succesfully Saved';
	}else{
		echo "Error: " . $sql . "<br>" . $conn_sql->error;
	}
}
else if($operation == "add_remarks_distributor"){
	$id_scanned_kanban = mysqli_real_escape_string($conn_sql, $_GET['remarks_id_scanned_kanban']);
	$kanban = mysqli_real_escape_string($conn_sql, $_GET['remarks_kanban']);
	$kanban_num = mysqli_real_escape_string($conn_sql, $_GET['remarks_kanban_num']);
	$scan_date_time = mysqli_real_escape_string($conn_sql, $_GET['remarks_scan_date_time']);
	$request_date_time = mysqli_real_escape_string($conn_sql, $_GET['remarks_request_date_time']);
	$distributor_remarks = mysqli_real_escape_string($conn_sql, $_GET['distributor_remarks']);
	$scooter_station = mysqli_real_escape_string($conn_sql, $_GET['scooter_station']);
	$date_time = date("Y-m-d H:i:s");
	$sql = "INSERT INTO tc_distributor_remarks (request_id, kanban, kanban_num, scooter_station, scan_date_time, request_date_time, distributor_remarks, distributor_date_time, distributor_status)
	VALUES ('$id_scanned_kanban','$kanban','$kanban_num','$scooter_station','$scan_date_time','$request_date_time','$distributor_remarks','$date_time','Unread')";
	if($conn_sql->query($sql) === TRUE){
		echo'Remarks Succesfully Saved';
	}else{
		echo "Error: " . $sql . "<br>" . $conn_sql->error;
	}
}
$conn_sql->close();
?>