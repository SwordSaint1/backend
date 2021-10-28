<?php
include '../Connection/Connect_oracle.php';
include '../Connection/Connect_sql.php';
$operation = mysqli_real_escape_string($conn_sql, $_GET['operation']);
$id_scanned_kanban = mysqli_real_escape_string($conn_sql, $_GET['id_scanned_kanban']);
if($id_scanned_kanban == ""){
	$request_id = date("ymdh");
	$rand = substr(md5(microtime()),rand(0,26),5);
	$request_id = 'REQ:'.$request_id;
	$request_id = $request_id.''.$rand;
}else{
	$request_id = $id_scanned_kanban;
}
if($operation == "get_scan_kanban"){
	$kanban_scan = mysqli_real_escape_string($conn_sql, $_GET['kanban_scan']);
	$scooter_station = mysqli_real_escape_string($conn_sql, $_GET['scooter_area']);
	// To Check Kanban
	// First is for Duplicate Entry
	$sql = "SELECT request_id kanban, scooter_station, status FROM tc_scanned_kanban WHERE kanban='$kanban_scan' AND scooter_station='$scooter_station' and request_id='$request_id' and status ='' LIMIT 1";
	$result = $conn_sql->query($sql);
	if($result->num_rows > 0){
		echo 'Error: Duplicate Entry!';
	}else{
		// Second is for Allready Requested
		$sql1 = "SELECT request_id, kanban, scooter_station, status FROM tc_scanned_kanban WHERE kanban='$kanban_scan' AND scooter_station='$scooter_station' and request_id !='$request_id' and status !='' LIMIT 1";
		$result1 = $conn_sql->query($sql1);
		if($result1->num_rows > 0){
			echo 'Error: Already Requested!';
		}else{
			// For Checking the Master and Insert Data
			$sql2 = "SELECT * FROM tc_kanban_masterlist WHERE kanban='$kanban_scan' ORDER BY id DESC LIMIT 1";
			$result2 = $conn_sql->query($sql2);
			if($result2->num_rows > 0){
				while($row2 = $result2->fetch_assoc()){
					$production_lot = $row2['production_lot'];
					$parts_code = $row2['parts_code'];
					$line_no = $row2['line_no'];
					$stock_address = $row2['stock_address'];
					$parts_name = $row2['parts_name'];
					$comment = $row2['comment'];
					$length = $row2['length'];
					$quantity = $row2['quantity'];
					$kanban_no = $row2['kanban_no'];
					$serial_no = $row2['serial_no'];
					$scan_date_time = date("Y-m-d H:i:s");
					$sql3 = "SELECT request_id, kanban, serial_no FROM tc_scanned_kanban WHERE kanban='$kanban_scan' AND serial_no='$serial_no' AND request_id='$request_id' ORDER BY id DESC LIMIT 1";
					$result3 = $conn_sql->query($sql3);
					if($result3->num_rows > 0){
						echo $request_id;
					}else{
						$sql4 = "INSERT INTO tc_scanned_kanban (request_id, production_lot, parts_code, line_no, stock_address, parts_name, comment, length, quantity, kanban_no, kanban, serial_no, scooter_station, distributor, scan_date_time, request_date_time, print_date_time, store_out_date_time, requested_by, store_out_person, status)
						VALUES ('$request_id','$production_lot','$parts_code','$line_no','$stock_address','$parts_name','$comment','$length','$quantity','$kanban_no','$kanban_scan','$serial_no','$scooter_station','','$scan_date_time','','','','','','')";
						if($conn_sql->query($sql4) === TRUE){
							//Update of Masterlist for Last Transaction
							$sql5 = "UPDATE tc_kanban_masterlist SET transaction_date_time='$scan_date_time', transaction_details ='Scanned in $scooter_station' WHERE kanban='$kanban_scan'";
							if ($conn_sql->query($sql5) === TRUE){
								//echo "Record updated successfully";
							} else {
								//echo "Error updating record: " . $conn_sql->error;
							}
							echo $request_id;
						} else {
							echo "Error: " . $sql4 . "<br>" . $conn_sql->error;
						}
					}
					
				}
			}else{
				echo 'Error: Unregistered Kanban!';
			}
		}
	}
}
else if($operation == "get_scan_serial_no"){
	$serial_no_scan = mysqli_real_escape_string($conn_sql, $_GET['serial_no_scan']);
	$scooter_station = mysqli_real_escape_string($conn_sql, $_GET['scooter_area']);
	// To Check Kanban
	// First is for Duplicate Entry
	$sql = "SELECT request_id serial_no, scooter_station, status FROM tc_scanned_kanban WHERE serial_no='$serial_no_scan' AND scooter_station='$scooter_station' and request_id='$request_id' and status ='' LIMIT 1";
	$result = $conn_sql->query($sql);
	if($result->num_rows > 0){
		echo 'Error: Duplicate Entry!';
	}else{
		// Second is for Allready Requested
		$sql1 = "SELECT request_id, serial_no, scooter_station, status FROM tc_scanned_kanban WHERE serial_no='$serial_no_scan' AND scooter_station='$scooter_station' and request_id !='$request_id' and status !='' LIMIT 1";
		$result1 = $conn_sql->query($sql1);
		if($result1->num_rows > 0){
			echo 'Error: Already Requested!';
		}else{
			// For Checking the Master and Insert Data
			$sql2 = "SELECT * FROM tc_kanban_masterlist WHERE serial_no='$serial_no_scan' ORDER BY id DESC LIMIT 1";
			$result2 = $conn_sql->query($sql2);
			if($result2->num_rows > 0){
				while($row2 = $result2->fetch_assoc()){
					$production_lot = $row2['production_lot'];
					$parts_code = $row2['parts_code'];
					$line_no = $row2['line_no'];
					$stock_address = $row2['stock_address'];
					$parts_name = $row2['parts_name'];
					$comment = $row2['comment'];
					$length = $row2['length'];
					$quantity = $row2['quantity'];
					$kanban_no = $row2['kanban_no'];
					$kanban = $row2['kanban'];
					$serial_no = $row2['serial_no'];
					$scan_date_time = date("Y-m-d H:i:s");
					$sql3 = "SELECT request_id, kanban, serial_no FROM tc_scanned_kanban WHERE kanban='$kanban' AND serial_no='$serial_no' AND request_id='$request_id' ORDER BY id DESC LIMIT 1";
					$result3 = $conn_sql->query($sql3);
					if($result3->num_rows > 0){
						echo $request_id;
					}else{
						$sql4 = "INSERT INTO tc_scanned_kanban (request_id, production_lot, parts_code, line_no, stock_address, parts_name, comment, length, quantity, kanban_no, kanban, serial_no, scooter_station, distributor, scan_date_time, request_date_time, print_date_time, store_out_date_time, requested_by, store_out_person, status)
						VALUES ('$request_id','$production_lot','$parts_code','$line_no','$stock_address','$parts_name','$comment','$length','$quantity','$kanban_no','$kanban','$serial_no','$scooter_station','','$scan_date_time','','','','','','')";
						if($conn_sql->query($sql4) === TRUE){
							//Update of Masterlist for Last Transaction
							$sql5 = "UPDATE tc_kanban_masterlist SET transaction_date_time='$scan_date_time', transaction_details ='Scanned in $scooter_station' WHERE serial_no='$serial_no_scan'";
							if ($conn_sql->query($sql5) === TRUE){
								//echo "Record updated successfully";
							} else {
								//echo "Error updating record: " . $conn_sql->error;
							}
							echo $request_id;
						} else {
							echo "Error: " . $sql4 . "<br>" . $conn_sql->error;
						}
					}
					
				}
			}else{
				echo 'Error: Unregistered Serial No!';
			}
		}
	}
}
else if($operation == "get_kanban"){
	$no_row = 0;
	$request_id = mysqli_real_escape_string($conn_sql, $_GET['id_scanned_kanban']);
	$sql = "SELECT id, request_id, kanban, kanban_no, parts_name, comment, parts_code, quantity, scooter_station, length, line_no FROM tc_scanned_kanban WHERE request_id='$request_id' ORDER BY id DESC";
		$result = $conn_sql->query($sql);
		if($result->num_rows > 0){
			while($row = $result->fetch_assoc()){
				$no_row = $no_row + 1;
				echo'
					<tr id="row_table_requested_'.$no_row.'">
						<td class="font-weight-normal">'.$no_row.'</td><td class="font-weight-normal">'.$row['line_no'].'</td><td class="font-weight-normal">'.$row['parts_code'].'</td><td class="font-weight-normal">'.$row['parts_name'].'</td><td class="font-weight-normal">'.$row['comment'].'</td><td class="font-weight-normal">'.$row['length'].'</td><td class="font-weight-normal">'.$row['quantity'].'</td><td class="h5 mx-0 my-0 py-0 px-0"><center><i class="fas fa-trash mt-3 text-default" style="cursor:pointer;" onclick="delete_request(&quot;'.$row['request_id'].'~!~'.$row['id'].'&quot;);"></i></center></td>
					</tr>
				';
			}
		}else{
		}
}
else if($operation == "request_success"){
	$request_date_time = date("Y-m-d H:i:s");
	$request_id = mysqli_real_escape_string($conn_sql, $_GET['id_scanned_kanban']);
	$distributor = mysqli_real_escape_string($conn_sql, $_GET['distributor']);
	$sql = "UPDATE tc_scanned_kanban SET distributor='$distributor', request_date_time ='$request_date_time', status ='Pending' WHERE request_id='$request_id'";
	if ($conn_sql->query($sql) === TRUE){
		//For Getting Serial Number
		$sql1 = "SELECT serial_no FROM tc_scanned_kanban WHERE request_id='$request_id'";
		$result1 = $conn_sql->query($sql1);
		if($result1->num_rows > 0){
			while($row1 = $result1->fetch_assoc()){
				$serial_no = $row1['serial_no'];
				//Update of Masterlist for Last Transaction
				$sql2 = "UPDATE tc_kanban_masterlist SET transaction_date_time='$request_date_time', transaction_details ='Order Confirmed By $distributor' WHERE serial_no='$serial_no'";
				if ($conn_sql->query($sql2) === TRUE){
					//echo "Record updated successfully";
				} else {
					//echo "Error updating record: " . $conn_sql->error;
				}
			}
		}
		echo "Record updated successfully";
	} else {
		echo "Error updating record: " . $conn_sql->error;
	}
}
else if($operation == "delete_kanban"){
	$distributor_id = mysqli_real_escape_string($conn_sql, $_GET['distributor_id']);
	$sql = "SELECT id_no FROM distributor_account WHERE id_no='$distributor_id'";
	$result = $conn_sql->query($sql);
	if($result->num_rows > 0){
		while($row = $result->fetch_assoc()){
		$id = mysqli_real_escape_string($conn_sql, $_GET['id']);
		$id_scanned_kanban = mysqli_real_escape_string($conn_sql, $_GET['id_scanned_kanban']);
		$sql = "DELETE FROM scanned_kanban WHERE id_scanned_kanban='$id_scanned_kanban' AND id='$id'";
		if ($conn_sql->query($sql) === TRUE) {
			echo 'Kanban Request Deleted!';
		} else {
			echo "Error deleting record: " . $conn_sql->error;
		}	
		}
	}else{
		echo 'Unregistered ID Code!';
	}
	
}
$conn_sql->close();
?>
