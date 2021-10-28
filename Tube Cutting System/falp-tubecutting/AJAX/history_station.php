<?php
set_time_limit(0);
include '../Connection/Connect_oracle.php';
include '../Connection/Connect_sql.php';
$operation = mysqli_real_escape_string($conn_sql, $_GET['operation']);
if($operation == "display_all"){
	$date_from = mysqli_real_escape_string($conn_sql, $_GET['date_from']);
	$date_from=date_create($date_from);
	$date_from= date_format($date_from,"Y-m-d H:i:s");
	$date_to = mysqli_real_escape_string($conn_sql, $_GET['date_to']);
	$date_to=date_create($date_to);
	$date_to= date_format($date_to,"Y-m-d H:i:s");
	$line_no = mysqli_real_escape_string($conn_sql, $_GET['line_no']);
	$parts_code = mysqli_real_escape_string($conn_sql, $_GET['parts_code']);
	$parts_name = mysqli_real_escape_string($conn_sql, $_GET['parts_name']);
	$comment = mysqli_real_escape_string($conn_sql, $_GET['comment']);
	$length = mysqli_real_escape_string($conn_sql, $_GET['length']);
	$kanban_no = mysqli_real_escape_string($conn_sql, $_GET['kanban_no']);
	$scooter_station = mysqli_real_escape_string($conn_sql, $_GET['scooter_station']);
	$load_more_counter = mysqli_real_escape_string($conn_sql, $_GET['load_more_counter']);
	$no = $load_more_counter;
	//Starting of Query
	$sql = "SELECT * FROM tc_history WHERE line_no LIKE '%$line_no%' AND parts_code LIKE '%$parts_code%' AND parts_name LIKE '%$parts_name%' AND comment LIKE '%$comment%' AND length LIKE '%$length%' AND kanban_no LIKE '%$kanban_no%' AND scooter_station LIKE '%$scooter_station%' AND (scan_date_time >= '$date_from' AND scan_date_time <= '$date_to') ORDER BY id ASC LIMIT $load_more_counter, 20";
	$result = $conn_sql->query($sql);
	if($result->num_rows > 0){
		while($row = $result->fetch_assoc()){
			$no = $no + 1;
			echo'
				<tr>
					<td>'.$no.'</td><td>'.$row['line_no'].'</td><td>'.$row['stock_address'].'</td><td>'.$row['parts_code'].'</td><td>'.$row['parts_name'].'</td><td>'.$row['comment'].'</td><td>'.$row['length'].'</td><td>'.$row['quantity'].'</td><td>'.$row['kanban_no'].'</td><td>'.$row['scooter_station'].'</td><td>'.$row['scan_date_time'].'</td><td>'.$row['request_date_time'].'</td><td>'.$row['print_date_time'].'</td><td>'.$row['store_out_date_time'].'</td>
				</tr>
			';
		}
	}
}
else if($operation == "count_all"){
	$date_from = mysqli_real_escape_string($conn_sql, $_GET['date_from']);
	$date_from=date_create($date_from);
	$date_from= date_format($date_from,"Y-m-d H:i:s");
	$date_to = mysqli_real_escape_string($conn_sql, $_GET['date_to']);
	$date_to=date_create($date_to);
	$date_to= date_format($date_to,"Y-m-d H:i:s");
	$line_no = mysqli_real_escape_string($conn_sql, $_GET['line_no']);
	$parts_code = mysqli_real_escape_string($conn_sql, $_GET['parts_code']);
	$parts_name = mysqli_real_escape_string($conn_sql, $_GET['parts_name']);
	$comment = mysqli_real_escape_string($conn_sql, $_GET['comment']);
	$length = mysqli_real_escape_string($conn_sql, $_GET['length']);
	$kanban_no = mysqli_real_escape_string($conn_sql, $_GET['kanban_no']);
	$scooter_station = mysqli_real_escape_string($conn_sql, $_GET['scooter_station']);
	//Starting of Query
	$sql = "SELECT count(id) as total FROM tc_history WHERE line_no LIKE '%$line_no%' AND parts_code LIKE '%$parts_code%' AND parts_name LIKE '%$parts_name%' AND comment LIKE '%$comment%' AND length LIKE '%$length%' AND kanban_no LIKE '%$kanban_no%' AND scooter_station LIKE '%$scooter_station%' AND (scan_date_time >= '$date_from' AND scan_date_time <= '$date_to') ORDER BY id ASC";
	$result = $conn_sql->query($sql);
	if($result->num_rows > 0){
		while($row = $result->fetch_assoc()){
			echo $row['total'];
		}
	}
}
else if($operation == "get_all_station"){
	$sql = "SELECT scooter_area FROM tc_scooter_area GROUP BY scooter_area ORDER BY scooter_area";
	$result = $conn_sql->query($sql);
	if($result->num_rows > 0){
		while($row = $result->fetch_assoc()){
			echo'
				<option>'.$row['scooter_area'].'</option>
			';
		}
	}else{
	}
}
$conn_sql->close();
?>
