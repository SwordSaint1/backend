<?php
set_time_limit(0);
include '../Connection/Connect_sql.php';
$operation = mysqli_real_escape_string($conn_sql, $_GET['operation']);
$username_session = mysqli_real_escape_string($conn_sql, $_GET['username_session']);
if($operation == "update_ready_for_delivery"){
	$kanban_scan_ready_delivery = mysqli_real_escape_string($conn_sql, $_GET['kanban_scan_ready_delivery']);
	$kanban_length = strlen($kanban_scan_ready_delivery);
	if($kanban_length > 25){
		$sql = "SELECT * FROM tc_scanned_kanban WHERE kanban='$kanban_scan_ready_delivery' AND status = 'Ongoing Picking' LIMIT 1";			
	}else{
		$sql = "SELECT * FROM tc_scanned_kanban WHERE serial_no='$kanban_scan_ready_delivery' AND status = 'Ongoing Picking' LIMIT 1";			
	}
	$result = $conn_sql->query($sql);
	if($result->num_rows > 0){
		while($row = $result->fetch_assoc()){
			$id = $row['id'];
			$request_id = $row['request_id'];
			$production_lot = $row['production_lot'];
			$parts_code = $row['parts_code'];
			$line_no = $row['line_no'];
			$stock_address = $row['stock_address'];
			$parts_name = $row['parts_name'];
			$comment = $row['comment'];
			$length = $row['length'];
			$quantity = $row['quantity'];
			$kanban_no = $row['kanban_no'];
			$kanban = $row['kanban'];
			$serial_no = $row['serial_no'];
			$scooter_station = $row['scooter_station'];
			$distributor = $row['distributor'];
			$scan_date_time = $row['scan_date_time'];
			$request_date_time = $row['request_date_time'];
			$print_date_time = $row['print_date_time'];
			$requested_by = $row['requested_by'];
			$store_out_person = $username_session;
			$store_out_date_time = date("Y-m-d H:i:s");
			$sql1 = "INSERT INTO tc_history (id, request_id, production_lot, parts_code, line_no, stock_address, parts_name, comment, length, quantity, kanban_no, kanban, serial_no, scooter_station, distributor, scan_date_time, request_date_time, print_date_time, store_out_date_time, requested_by, store_out_person, status)
			VALUES ('','$request_id','$production_lot','$parts_code','$line_no','$stock_address','$parts_name','$comment','$length','$quantity','$kanban_no','$kanban','$serial_no','$scooter_station','$distributor','$scan_date_time','$request_date_time','$print_date_time','$store_out_date_time','$distributor','$store_out_person','Ready for Delivery')";
			if($conn_sql->query($sql1) === TRUE){
				//Checking Distributors Remarks
				$sql3 = "SELECT * FROM tc_distributor_remarks WHERE request_id = '$request_id' AND kanban = '$kanban' AND kanban_num = '$kanban_no' AND scooter_station = '$scooter_station' AND scan_date_time = '$scan_date_time' AND request_date_time = '$request_date_time'";
				$result3 = $conn_sql->query($sql3);
				if($result3->num_rows > 0){
					while($row3 = $result3->fetch_assoc()){
						$distributor_remarks = $row3['distributor_remarks'];
						$distributor_date_time = $row3['distributor_date_time'];
						$distributor_status = $row3['distributor_status'];
						//Inserting Distibutor Remarks in History
						$sql4 = "INSERT INTO tc_distributor_remarks_history (request_id,kanban,kanban_num,scooter_station,scan_date_time,request_date_time,distributor_remarks,distributor_date_time,distributor_status)
						VALUES ('$request_id','$kanban','$kanban_no','$scooter_station','$scan_date_time','$request_date_time','$distributor_remarks','$distributor_date_time','$distributor_status')";
						if($conn_sql->query($sql4) === TRUE){
							//Deleting Distibutor Remarks
							$sql5 = "DELETE FROM tc_distributor_remarks WHERE request_id = '$request_id' AND kanban = '$kanban' AND kanban_num = '$kanban_no' AND scooter_station = '$scooter_station' AND scan_date_time = '$scan_date_time' AND request_date_time = '$request_date_time'";
							if ($conn_sql->query($sql5) === TRUE){
							} else {
								echo "Error: " . $sql5 . "<br>" . $conn_sql->error;
							}
						} else {
							echo "Error: " . $sql4 . "<br>" . $conn_sql->error;
						}
					}
				}
				//Checking Tubecutting Remarks
				$sql6 = "SELECT * FROM tc_mm_remarks WHERE request_id = '$request_id' AND kanban = '$kanban' AND kanban_num = '$kanban_no' AND scooter_station = '$scooter_station' AND scan_date_time = '$scan_date_time' AND request_date_time = '$request_date_time'";
				$result6 = $conn_sql->query($sql6);
				if($result6->num_rows > 0){
					while($row6 = $result6->fetch_assoc()){
						$mm_remarks = $row6['mm_remarks'];
						$mm_date_time = $row6['mm_date_time'];
						$mm_status = $row6['mm_status'];
						//Inserting Tubecutting Remarks in History
						$sql7 = "INSERT INTO tc_mm_remarks_history (request_id,kanban,kanban_num,scooter_station,scan_date_time,request_date_time,mm_remarks,mm_date_time,mm_status)
						VALUES ('$request_id','$kanban','$kanban_no','$scooter_station','$scan_date_time','$request_date_time','$mm_remarks','$mm_date_time','$mm_status')";
						if($conn_sql->query($sql7) === TRUE){
							//Deleting Tubecutting Remarks
							$sql8 = "DELETE FROM tc_mm_remarks WHERE request_id = '$request_id' AND kanban = '$kanban' AND kanban_num = '$kanban_no' AND scooter_station = '$scooter_station' AND scan_date_time = '$scan_date_time' AND request_date_time = '$request_date_time'";
							if ($conn_sql->query($sql8) === TRUE){
							} else {
								echo "Error: " . $sql8 . "<br>" . $conn_sql->error;
							}
						} else {
							echo "Error: " . $sql7 . "<br>" . $conn_sql->error;
						}
					}
				}
				
				
				
				
				$sql2 = "DELETE FROM tc_scanned_kanban WHERE request_id='$request_id' AND kanban='$kanban' AND scan_date_time='$scan_date_time'";
				if ($conn_sql->query($sql2) === TRUE){

					//Update of Masterlist for Last Transaction
					$sql9 = "UPDATE tc_kanban_masterlist SET transaction_date_time='$store_out_date_time', transaction_details ='Allready Storeout' WHERE kanban='$kanban_scan_ready_delivery'";
					if ($conn_sql->query($sql9) === TRUE){
						//echo "Record updated successfully";
					} else {
						//echo "Error updating record: " . $conn_sql->error;
					}

					echo "Succesfully Store Out";
				} else {
					echo "Error Store Out: " . $conn_sql->error;
				}
			} else {
				echo "Error: " . $sql1 . "<br>" . $conn_sql->error;
			}
		}
	}else{
		echo'This Kanban Is Not Requested';
	}
}
$conn_sql->close();
?>
