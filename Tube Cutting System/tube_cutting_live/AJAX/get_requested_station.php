<?php
include '../Connection/Connect_oracle.php';
include '../Connection/Connect_sql.php';
$operation = mysqli_real_escape_string($conn_sql, $_GET['operation']);
if($operation == "select_request_scooter_area"){
	$scooter_area = mysqli_real_escape_string($conn_sql, $_GET['scooter_area']);
	$sql = "SELECT id_scanned_kanban, distributor, kanban, scooter_station, request_date_time, status, real_time_status FROM history GROUP BY(id_scanned_kanban) ORDER BY id DESC";
	$result = $conn_sql->query($sql);
	if($result->num_rows > 0){
		while($row = $result->fetch_assoc()){
			$sql1 = "SELECT id_scanned_kanban FROM history WHERE scooter_station='$scooter_area' AND id_scanned_kanban='".$row['id_scanned_kanban']."'";
			$result1 = $conn_sql->query($sql1);
			if($result1->num_rows > 0){
				$rowcount = mysqli_num_rows($result1);
				echo'
					<tr onclick="open_details_request(&quot;'.$row['id_scanned_kanban'].'~!~'.$row['real_time_status'].'&quot;)" style="cursor:pointer;" id="row_of_pending'.$row['id_scanned_kanban'].'">
						<td class="font-weight-normal" id="column_of_pending'.$row['id_scanned_kanban'].'">'.$row['id_scanned_kanban'].'</td><td class="font-weight-normal">'.$row['scooter_station'].'</td><td class="font-weight-normal">'.$row['request_date_time'].'</td><td class="font-weight-normal">'.$rowcount.'</td><td class="font-weight-normal">'.$row['distributor'].'</td>
					</tr>
				';
			}
		}
	}else{
	}
}
else if($operation == "open_details_request_station"){
	$id_scanned_kanban = mysqli_real_escape_string($conn_sql, $_GET['id_scanned_kanban']);
	$sql = "SELECT * FROM history WHERE id_scanned_kanban='$id_scanned_kanban' ORDER BY line_no ASC, stock_address ASC , parts_code ASC";
	$result = $conn_sql->query($sql);
	if($result->num_rows > 0){
		while($row = $result->fetch_assoc()){
			echo'
				<tr>
					<td>'.$row['line_no'].'</td><td>'.$row['stock_address'].'</td><td>'.$row['parts_code'].'</td><td>'.$row['parts_name'].'</td><td>'.$row['quantity'].'</td><td>'.$row['kanban_num'].'</td><td>'.$row['scan_date_time'].'</td><td>'.$row['request_date_time'].'</td><td>'.$row['store_out_date_time'].'</td><td>'.$row['status'].'</td>
				</tr>
			';
		}
	}else{
	}
}
else if($operation == "get_requestor_name"){
	$id_scanned_kanban = mysqli_real_escape_string($conn_sql, $_GET['id_scanned_kanban']);
	$sql = "SELECT distributor FROM history WHERE id_scanned_kanban='$id_scanned_kanban' GROUP BY(id_scanned_kanban)";
	$result = $conn_sql->query($sql);
	if($result->num_rows > 0){
		while($row = $result->fetch_assoc()){
			$sql = "SELECT name FROM distributor_account WHERE id_no='".$row['distributor']."'";
			$result = $conn_sql->query($sql);
			if($result->num_rows > 0){
				while($row = $result->fetch_assoc()){
					echo $row['name'];
				}
			}else{
			}
		}
	}else{
	}
}
else if($operation == "select_parts_history"){
	$scooter_area = mysqli_real_escape_string($conn_sql, $_GET['scooter_area']);
	$date_from = mysqli_real_escape_string($conn_sql, $_GET['date_from']);
	$date_from = $date_from.' 00:00:00';
	$date_to = mysqli_real_escape_string($conn_sql, $_GET['date_to']);
	$date_to = $date_to.' 24:59:59';
	$parts_name = mysqli_real_escape_string($conn_sql, $_GET['parts_name']);
	if($parts_name == ""){
		$sql = "SELECT * FROM tc_history WHERE scooter_station='$scooter_area' AND scan_date_time >= '$date_from' AND scan_date_time <= '$date_to' ORDER BY line_no ASC, stock_address ASC , parts_code ASC";
	}else{
		$sql = "SELECT * FROM tc_history WHERE scooter_station='$scooter_area' AND scan_date_time >= '$date_from' AND scan_date_time <= '$date_to' AND parts_name LIKE '%$parts_name%' ORDER BY line_no ASC, stock_address ASC , parts_code ASC";
	}
	$result = $conn_sql->query($sql);
	if($result->num_rows > 0){
		while($row = $result->fetch_assoc()){
			echo'
			<tr>
				<td class="font-weight-normal">'.$row['line_no'].'</td><td class="font-weight-normal">'.$row['stock_address'].'</td><td class="font-weight-normal">'.$row['parts_code'].'</td><td class="font-weight-normal">'.$row['parts_name'].'</td><td class="font-weight-normal">'.$row['comment'].'</td><td class="font-weight-normal">'.$row['length'].'</td><td class="font-weight-normal">'.$row['quantity'].'</td><td class="font-weight-normal">'.$row['scan_date_time'].'</td><td class="font-weight-normal">'.$row['print_date_time'].'</td><td class="font-weight-normal">'.$row['store_out_date_time'].'</td>
			</tr>';
		}
	}else{
	}
}
$conn_sql->close();
?>
