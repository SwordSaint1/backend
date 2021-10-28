<?php
include '../Connection/Connect_sql.php';
$operation = mysqli_real_escape_string($conn_sql, $_GET['operation']);
if($operation == "update_history"){
	$user_id = mysqli_real_escape_string($conn_sql, $_GET['user_id']);
	$id_scanned_kanban = mysqli_real_escape_string($conn_sql, $_GET['id_scanned_kanban']);
	$sql = "SELECT * FROM scanned_kanban WHERE store_out_person='$user_id' AND id_scanned_kanban='$id_scanned_kanban' AND status='Ready for Delivery' AND real_time_status='Ready for Delivery'";
		$result = $conn_sql->query($sql);
		if($result->num_rows > 0){
			while($row = $result->fetch_assoc()){
				$id_scanned_kanban = $row['id_scanned_kanban'];
				$kanban = $row['kanban'];
				$supplier_name = $row['supplier_name'];
				$parts_name = $row['parts_name'];
				$comment = $row['comment'];
				$parts_code = $row['parts_code'];
				$line_no = $row['line_no'];
				$location = $row['location'];
				$delivery = $row['delivery'];
				$quantity = $row['quantity'];
				$scooter_station = $row['scooter_station'];
				$distributor = $row['distributor'];
				$scan_date_time = $row['scan_date_time'];
				$request_date_time = $row['request_date_time'];
				$print_date_time = $row['print_date_time'];
				$store_out_date_time = $row['store_out_date_time'];
				$store_out_person = $row['store_out_person'];
				$status = $row['status'];
				$real_time_status = $row['real_time_status'];
				$sql1 = "INSERT INTO history (id, id_scanned_kanban, kanban, supplier_name, parts_name, comment, parts_code, line_no, location, delivery, quantity, scooter_station, distributor, scan_date_time, request_date_time, print_date_time, store_out_date_time, store_out_person, status, real_time_status)
				VALUES ('','$id_scanned_kanban','$kanban','$supplier_name','$parts_name','$comment','$parts_code','$line_no','$location','$delivery','$quantity','$scooter_station','$distributor','$scan_date_time','$request_date_time','$print_date_time','$store_out_date_time','$store_out_person','$status','$real_time_status')";
				if($conn_sql->query($sql1) === TRUE){
					$sql2 = "DELETE FROM scanned_kanban WHERE store_out_person='$user_id' AND id_scanned_kanban='$id_scanned_kanban' AND status='Ready for Delivery' AND real_time_status='Ready for Delivery'";
					if ($conn_sql->query($sql2) === TRUE) {
						echo "Record deleted successfully";
					} else {
						echo "Error deleting record: " . $conn_sql->error;
					}
				} else {
					echo "Error: " . $sql1 . "<br>" . $conn_sql->error;
				}
			}
		}else{
			echo 'Unable to Update';
		}
}
$conn_sql->close();
?>
