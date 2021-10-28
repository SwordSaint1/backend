<?php
include '../Connection/Connect_sql.php';
$operation = mysqli_real_escape_string($conn_sql, $_GET['operation']);
if($operation == "count_all_history"){
	$date_from = mysqli_real_escape_string($conn_sql, $_GET['date_from']);
	$date_to = mysqli_real_escape_string($conn_sql, $_GET['date_to']);
	$date_from = $date_from.' 00:00:00';
	$date_to = $date_to.' 24:59:59';
	$sql = "SELECT * FROM tc_history where scan_date_time >= '$date_from' AND scan_date_time <= '$date_to'";
	$result = $conn_sql->query($sql);
	if($result->num_rows > 0){
		$rowcount=mysqli_num_rows($result);
		echo $rowcount;
	}
}
else if($operation == "count_all_lines"){
	$lines_select = mysqli_real_escape_string($conn_sql, $_GET['lines_select']);
	$date_from = mysqli_real_escape_string($conn_sql, $_GET['date_from']);
	$date_to = mysqli_real_escape_string($conn_sql, $_GET['date_to']);
	$date_from = $date_from.' 00:00:00';
	$date_to = $date_to.' 24:59:59';
	$sql = "SELECT * FROM tc_history where line_no='$lines_select' AND scan_date_time >= '$date_from' AND scan_date_time <= '$date_to' GROUP BY(request_id)";
	$result = $conn_sql->query($sql);
	if($result->num_rows > 0){
		$rowcount=mysqli_num_rows($result);
		echo $rowcount;
	}
}
else if($operation == "count_all_station"){
	$scooter_area_select = mysqli_real_escape_string($conn_sql, $_GET['scooter_area_select']);
	$date_from = mysqli_real_escape_string($conn_sql, $_GET['date_from']);
	$date_to = mysqli_real_escape_string($conn_sql, $_GET['date_to']);
	$date_from = $date_from.' 00:00:00';
	$date_to = $date_to.' 24:59:59';
	$sql = "SELECT * FROM tc_history where scooter_station='$scooter_area_select' AND scan_date_time >= '$date_from' AND scan_date_time <= '$date_to'  GROUP BY(request_id)";
	$result = $conn_sql->query($sql);
	if($result->num_rows > 0){
		$rowcount=mysqli_num_rows($result);
		echo $rowcount;
	}
}
$conn_sql->close();
?>
