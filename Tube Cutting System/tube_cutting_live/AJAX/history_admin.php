<?php
include '../Connection/Connect_oracle.php';
include '../Connection/Connect_sql.php';
$operation = mysqli_real_escape_string($conn_sql, $_GET['operation']);
if($operation == "Scooter Station"){
	$no = 0 ;
	$limiter = mysqli_real_escape_string($conn_sql, $_GET['limiter']);
	$limiter = $limiter + 20;
	$date_from = mysqli_real_escape_string($conn_sql, $_GET['date_from']);
	$date_from = $date_from.' 00:00:00';
	$date_to = mysqli_real_escape_string($conn_sql, $_GET['date_to']);
	$date_to = $date_to.' 24:59:59';
	$selected_con = mysqli_real_escape_string($conn_sql, $_GET['selected_con']);
	$sql = "SELECT request_id, distributor, kanban, scooter_station, request_date_time, status FROM tc_history WHERE scooter_station='$selected_con' AND (request_date_time >= '$date_from' AND request_date_time <= '$date_to') GROUP BY(request_id) ORDER BY id DESC LIMIT $limiter";
	$result = $conn_sql->query($sql);
	if($result->num_rows > 0){
		while($row = $result->fetch_assoc()){
			$sql1 = "SELECT request_id FROM tc_history WHERE request_id='".$row['request_id']."'";
			$result1 = $conn_sql->query($sql1);
			if($result1->num_rows > 0){
				$no = $no + 1;
				$rowcount = mysqli_num_rows($result1);
				echo'
					<tr onclick="open_details_request(&quot;'.$row['request_id'].'~!~'.$row['status'].'&quot;)" style="cursor:pointer;">
						<td class="font-weight-normal">'.$no.'</td><td class="font-weight-normal">'.$row['request_id'].'</td><td class="font-weight-normal">'.$row['scooter_station'].'</td><td class="font-weight-normal">'.$row['request_date_time'].'</td><td class="font-weight-normal">'.$rowcount.'</td><td class="font-weight-normal">'.$row['distributor'].'</td><td class="font-weight-normal">'.$row['status'].'</td>
					</tr>
				';
			}
		}
	}else{
	}
	echo '|~!~|'.$limiter;
}
else if($operation == "Lines"){
	$no = 0;
	$limiter = mysqli_real_escape_string($conn_sql, $_GET['limiter']);
	$limiter = $limiter + 20;
	$date_from = mysqli_real_escape_string($conn_sql, $_GET['date_from']);
	$date_from = $date_from.' 00:00:00';
	$date_to = mysqli_real_escape_string($conn_sql, $_GET['date_to']);
	$date_to = $date_to.' 24:59:59';
	$selected_con = mysqli_real_escape_string($conn_sql, $_GET['selected_con']);
	$sql = "SELECT request_id, distributor, kanban, line_no, scooter_station, request_date_time, status FROM tc_history WHERE line_no='$selected_con' AND (request_date_time >= '$date_from' AND request_date_time <= '$date_to') GROUP BY(request_id) ORDER BY id DESC LIMIT $limiter";
	$result = $conn_sql->query($sql);
	if($result->num_rows > 0){
		while($row = $result->fetch_assoc()){
			$sql1 = "SELECT request_id FROM tc_history WHERE line_no='".$row['line_no']."'";
			$result1 = $conn_sql->query($sql1);
			if($result1->num_rows > 0){
				$no = $no + 1;
				$rowcount = mysqli_num_rows($result1);
				echo'
					<tr onclick="open_details_request_lines(&quot;'.$row['request_id'].'~!~'.$row['status'].'~!~'.$row['line_no'].'&quot;)" style="cursor:pointer;">
						<td class="font-weight-normal">'.$no.'</td><td class="font-weight-normal">'.$row['request_id'].'</td><td class="font-weight-normal">'.$row['scooter_station'].'</td><td class="font-weight-normal">'.$row['request_date_time'].'</td><td class="font-weight-normal">'.$rowcount.'</td><td class="font-weight-normal">'.$row['distributor'].'</td><td class="font-weight-normal">'.$row['status'].'</td>
					</tr>
				';
			}
		}
	}else{
	}
	echo '|~!~|'.$limiter;
}
else if($operation == "All"){
	$no = 0;
	$limiter = mysqli_real_escape_string($conn_sql, $_GET['limiter']);
	$limiter = $limiter + 20;
	$date_from = mysqli_real_escape_string($conn_sql, $_GET['date_from']);
	$date_from = $date_from.' 00:00:00';
	$date_to = mysqli_real_escape_string($conn_sql, $_GET['date_to']);
	$date_to = $date_to.' 24:59:59';
	$selected_con = mysqli_real_escape_string($conn_sql, $_GET['selected_con']);
	$sql = "SELECT * FROM tc_history WHERE (request_date_time >= '$date_from' AND request_date_time <= '$date_to') ORDER BY id DESC LIMIT $limiter";
	$result = $conn_sql->query($sql);
	if($result->num_rows > 0){
		while($row = $result->fetch_assoc()){
			$sql1 = "SELECT request_id FROM tc_history WHERE line_no='".$row['line_no']."'";
			$result1 = $conn_sql->query($sql1);
			if($result1->num_rows > 0){
				$no = $no + 1;
				$rowcount = mysqli_num_rows($result1);
				echo'
					<tr>
						<td class="font-weight-normal">'.$no.'</td><td class="font-weight-normal">'.$row['serial_no'].'</td><td class="font-weight-normal">'.$row['line_no'].'</td><td class="font-weight-normal">'.$row['stock_address'].'</td><td class="font-weight-normal">'.$row['parts_code'].'</td><td class="font-weight-normal">'.$row['parts_name'].'</td><td class="font-weight-normal">'.$row['length'].'</td><td class="font-weight-normal">'.$row['quantity'].'</td><td class="font-weight-normal">'.$row['scan_date_time'].'</td><td class="font-weight-normal">'.$row['print_date_time'].'</td><td class="font-weight-normal">'.$row['store_out_date_time'].'</td><td class="font-weight-normal"><center class="mx-0 my-0"><button class="btn btn-info btn-sm mx-0 my-0" onclick="reprint_kanban(&quot;'.$row['id'].'&quot;)"><i class="fas fa-print"></i> Print</button></center></td>
					</tr>
				';
				
			}
		}
	}else{
	}
	echo '|~!~|'.$limiter;
}
else if($operation == "open_details_history"){
	$request_id = mysqli_real_escape_string($conn_sql, $_GET['id_scanned_kanban']);
	$sql = "SELECT * FROM tc_history WHERE request_id='$request_id' ORDER BY scan_date_time ASC";
	$result = $conn_sql->query($sql);
	if($result->num_rows > 0){
		while($row = $result->fetch_assoc()){
			echo'
				<tr>
					<td>'.$row['line_no'].'</td><td>'.$row['stock_address'].'</td><td>'.$row['parts_code'].'</td><td>'.$row['parts_name'].'</td><td>'.$row['quantity'].'</td><td>'.$row['kanban_no'].'</td><td>'.$row['scan_date_time'].'</td><td>'.$row['request_date_time'].'</td><td>'.$row['store_out_date_time'].'</td><td>'.$row['status'].'</td>
				</tr>
			';
		}
	}else{
	}
}
else if($operation == "open_details_history_lines"){
	$request_id = mysqli_real_escape_string($conn_sql, $_GET['id_scanned_kanban']);
	$line_no = mysqli_real_escape_string($conn_sql, $_GET['line_no']);
	$sql = "SELECT * FROM tc_history WHERE request_id='$request_id' AND line_no='$line_no' ORDER BY line_no ASC, stock_address ASC , parts_code ASC";
	$result = $conn_sql->query($sql);
	if($result->num_rows > 0){
		while($row = $result->fetch_assoc()){
			echo'
				<tr>
					<td>'.$row['line_no'].'</td><td>'.$row['stock_address'].'</td><td>'.$row['parts_code'].'</td><td>'.$row['parts_name'].'</td><td>'.$row['quantity'].'</td><td>'.$row['kanban_no'].'</td><td>'.$row['scan_date_time'].'</td><td>'.$row['request_date_time'].'</td><td>'.$row['store_out_date_time'].'</td><td>'.$row['status'].'</td>
				</tr>
			';
		}
	}else{
	}
}
else if($operation == "search_parts_name"){
	$no = 0;
	$parts_name = mysqli_real_escape_string($conn_sql, $_GET['parts_name']);
	$date_from = mysqli_real_escape_string($conn_sql, $_GET['date_from']);
	$date_from = $date_from.' 00:00:00';
	$date_to = mysqli_real_escape_string($conn_sql, $_GET['date_to']);
	$date_to = $date_to.' 24:59:59';
	$sql = "SELECT * FROM tc_history WHERE (request_date_time >= '$date_from' AND request_date_time <= '$date_to') AND parts_name LIKE '%$parts_name%' ORDER BY id DESC";
	$result = $conn_sql->query($sql);
	if($result->num_rows > 0){
		while($row = $result->fetch_assoc()){
			$sql1 = "SELECT request_id FROM tc_history WHERE line_no='".$row['line_no']."'";
			$result1 = $conn_sql->query($sql1);
			if($result1->num_rows > 0){
				$no = $no + 1;
				$rowcount = mysqli_num_rows($result1);
				echo'
					<tr>
						<td class="font-weight-normal">'.$no.'</td><td class="font-weight-normal">'.$row['serial_no'].'</td><td class="font-weight-normal">'.$row['stock_address'].'</td><td class="font-weight-normal">'.$row['parts_code'].'</td><td class="font-weight-normal">'.$row['parts_name'].'</td><td class="font-weight-normal">'.$row['length'].'</td><td class="font-weight-normal">'.$row['quantity'].'</td><td class="font-weight-normal">'.$row['scan_date_time'].'</td><td class="font-weight-normal">'.$row['print_date_time'].'</td><td class="font-weight-normal">'.$row['store_out_date_time'].'</td><td class="font-weight-normal"><center class="mx-0 my-0"><button class="btn btn-info btn-sm mx-0 my-0" onclick="reprint_kanban(&quot;'.$row['id'].'&quot;)"><i class="fas fa-print"></i> Print</button></center></td>
					</tr>
				';
			}
		}
	}else{
	}
}
else if($operation == "store_out_today"){
	$line_number = $_GET['line_no'];
	$no = 0;
	$date_from = date("Y-m-d");
	$date_from = $date_from.' 00:00:00';
	$date_to = date("Y-m-d");
	$date_to = $date_to.' 24:59:59';
	$sql = "SELECT * FROM tc_history WHERE (store_out_date_time >= '$date_from' AND store_out_date_time <= '$date_to') AND line_no LIKE '$line_number%' ORDER BY id DESC LIMIT 20";
	$result = $conn_sql->query($sql);
	if($result->num_rows > 0){
		while($row = $result->fetch_assoc()){
			$kanban =$row['kanban'];
			$identification_qr = substr($kanban, 0,3);
			if($identification_qr == 'TC-'){
				$new_iden_qr = 'New';
			}else{
				$new_iden_qr = 'Old';
			}
			$no = $no + 1;
			echo'
				<tr>
					<td class="font-weight-normal">'.$no.'</td>
					<td class="font-weight-normal">'.$row['serial_no'].'</td>
					<td class="font-weight-normal">'.$row['stock_address'].'</td>
					<td class="font-weight-normal">'.$row['line_no'].'</td>
					<td class="font-weight-normal">'.$row['parts_code'].'</td>
					<td class="font-weight-normal">'.$row['parts_name'].'</td>
					<td class="font-weight-normal">'.$row['comment'].'</td>
					<td class="font-weight-normal">'.$row['length'].'</td>
					<td class="font-weight-normal">'.$row['quantity'].'</td>
					<td class="font-weight-normal">'.$row['kanban_no'].'</td>
					<td class="font-weight-normal">'.$row['store_out_date_time'].'</td>
					<td class="font-weight-normal">'.$new_iden_qr.'</td>
				</tr>
			';
		}
	}else{
	}
}

elseif($operation == 'load_line'){
	echo '<option value="">--SELECT LINE--</option>';
	$ql = "SELECT DISTINCT line_no FROM tc_kanban_masterlist ORDER BY line_no ASC";
	$result = $conn_sql->query($ql);
	if($result->num_rows > 0){
		while($x = $result->fetch_assoc()){
			echo '<option value="'.$x['line_no'].'">'.$x['line_no'].'</option>';
		}
	}
}

$conn_sql->close();
?>
