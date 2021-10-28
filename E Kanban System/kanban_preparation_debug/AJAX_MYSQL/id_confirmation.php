<?php
include '../Connection/Connect_sql.php';
$operation = mysqli_real_escape_string($conn_sql, $_GET['operation']);
if($operation == "confirmation_id"){
	$id_scan_employee = mysqli_real_escape_string($conn_sql, $_GET['id_scan_employee']);
	$scooter_area = mysqli_real_escape_string($conn_sql, $_GET['scooter_area']);
	$sql = "SELECT id_no FROM tc_distributor_account WHERE id_no='$id_scan_employee'";
	//$sql = "SELECT id_no FROM distributor_account WHERE id_no='$id_scan_employee' AND scooter_area='$scooter_area'";   For Restriction in every Station
		$result = $conn_sql->query($sql);
		if($result->num_rows > 0){
			while($row = $result->fetch_assoc()){
				echo $row['id_no'];
			}
		}else{
			echo 'Unable to Request';
		}
}



else if($operation == "confirm_id_to_delivery"){
	$user_id = mysqli_real_escape_string($conn_sql, $_GET['user_id']);
	$id_scanned_kanban = mysqli_real_escape_string($conn_sql, $_GET['id_scanned_kanban']);
	$store_out_date_time = date("Y-m-d H:i:s");
	$sql = "SELECT username FROM account WHERE username='$user_id'";
		$result = $conn_sql->query($sql);
		if($result->num_rows > 0){
			$sql = "UPDATE scanned_kanban SET status='Ready for Delivery', store_out_date_time='$store_out_date_time', store_out_person='$user_id' WHERE id_scanned_kanban='$id_scanned_kanban' AND real_time_status = 'Ready For Delivery'";
			if ($conn_sql->query($sql) === TRUE){
				echo "Parts is Ready for Delivery";
			} else {
				echo "Error updating record: " . $conn_sql->error;
			}
		}else{
			echo 'Unable to Update';
		}
}
$conn_sql->close();
?>
