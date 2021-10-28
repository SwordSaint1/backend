<?php
include '../Connection/Connect_oracle.php';
include '../Connection/Connect_sql.php';
$operation = mysqli_real_escape_string($conn_sql, $_GET['operation']);
if($operation == "display_all"){
	$no = 0;
	$line_no_search = mysqli_real_escape_string($conn_sql, $_GET['line_no']);
	$scooter_station = mysqli_real_escape_string($conn_sql, $_GET['scooter_station']);
	$parts_name_search = mysqli_real_escape_string($conn_sql, $_GET['parts_name']);
	$parts_code_search = mysqli_real_escape_string($conn_sql, $_GET['parts_code']);
	$date_from = mysqli_real_escape_string($conn_sql, $_GET['date_from']);
	$date_to = mysqli_real_escape_string($conn_sql, $_GET['date_to']);
	if ($line_no_search != "" && $parts_name_search != "" && $parts_code_search != ""){
		$sql = "SELECT * FROM tc_history WHERE scooter_station = '$scooter_station' AND (scan_date_time >= '$date_from' AND scan_date_time <= '$date_to') AND line_no LIKE '%$line_no_search%' AND parts_name LIKE '%$parts_name_search%' AND parts_code LIKE '%$parts_code_search%' ORDER BY id ASC";
	}else if ($line_no_search != "" && $parts_name_search != "" && $parts_code_search == ""){
		$sql = "SELECT * FROM tc_history WHERE scooter_station = '$scooter_station' AND (scan_date_time >= '$date_from' AND scan_date_time <= '$date_to') AND line_no LIKE '%$line_no_search%' AND parts_name LIKE '%$parts_name_search%' ORDER BY id ASC";
	}else if ($line_no_search != "" && $parts_name_search == "" && $parts_code_search == ""){
		$sql = "SELECT * FROM tc_history WHERE scooter_station = '$scooter_station' AND (scan_date_time >= '$date_from' AND scan_date_time <= '$date_to') AND line_no LIKE '%$line_no_search%' ORDER BY id ASC";
	}else if ($line_no_search != "" && $parts_name_search == "" && $parts_code_search != ""){
		$sql = "SELECT * FROM tc_history WHERE scooter_station = '$scooter_station' AND (scan_date_time >= '$date_from' AND scan_date_time <= '$date_to') AND line_no LIKE '%$line_no_search%' AND parts_code LIKE '%$parts_code_search%' ORDER BY id ASC";
	}else if ($line_no_search == "" && $parts_name_search != "" && $parts_code_search != ""){
		$sql = "SELECT * FROM tc_history WHERE scooter_station = '$scooter_station' AND (scan_date_time >= '$date_from' AND scan_date_time <= '$date_to') AND parts_name LIKE '%$parts_name_search%' AND parts_code LIKE '%$parts_code_search%' ORDER BY id ASC";
	}else if ($line_no_search == "" && $parts_name_search == "" && $parts_code_search != ""){
		$sql = "SELECT * FROM tc_history WHERE scooter_station = '$scooter_station' AND (scan_date_time >= '$date_from' AND scan_date_time <= '$date_to') AND parts_code LIKE '%$parts_code_search%' ORDER BY id ASC";
	}else if ($line_no_search == "" && $parts_name_search != "" && $parts_code_search == ""){
		$sql = "SELECT * FROM tc_history WHERE scooter_station = '$scooter_station' AND (scan_date_time >= '$date_from' AND scan_date_time <= '$date_to') AND parts_name LIKE '%$parts_name_search%' ORDER BY id ASC";
	}else if ($line_no_search == "" && $parts_name_search == "" && $parts_code_search == ""){
		$sql = "SELECT * FROM tc_history WHERE scooter_station = '$scooter_station' AND (scan_date_time >= '$date_from' AND scan_date_time <= '$date_to') ORDER BY id ASC";
	}
	$result = $conn_sql->query($sql);
	if($result->num_rows > 0){
		while($row = $result->fetch_assoc()){
			$no = $no + 1;
			$request_id = $row['request_id'];
			$kanban = $row['kanban'];
			$kanban_no = $row['kanban_no'];
			$scan_date_time = $row['scan_date_time'];
			$request_date_time = $row['request_date_time'];
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
