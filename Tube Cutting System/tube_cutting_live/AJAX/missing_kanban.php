<?php
set_time_limit(0);
include '../Connection/Connect_sql.php';
$operation = mysqli_real_escape_string($conn_sql, $_GET['operation']);
if($operation == "display_all"){
	$no = mysqli_real_escape_string($conn_sql, $_GET['no']);
	$no = $no;
	$line_no = mysqli_real_escape_string($conn_sql, $_GET['line_no']);
	$parts_code = mysqli_real_escape_string($conn_sql, $_GET['parts_code']);
	$parts_name = mysqli_real_escape_string($conn_sql, $_GET['parts_name']);
	$length = mysqli_real_escape_string($conn_sql, $_GET['length']);
	$kanban_no = mysqli_real_escape_string($conn_sql, $_GET['kanban_no']);
	$cycle_day = mysqli_real_escape_string($conn_sql, $_GET['cycle_day']);
    $limiter_count = mysqli_real_escape_string($conn_sql, $_GET['limiter_count']);
	$date_now = date("Y-m-d H:i:s");
	$sql = "SELECT kanban, serial_no, line_no, stock_address, parts_code, parts_name, comment, length, quantity, kanban_no, transaction_date_time, transaction_details, DATEDIFF('$date_now', transaction_date_time) AS date_diff FROM tc_kanban_masterlist WHERE line_no LIKE '%$line_no%' AND parts_code LIKE '%$parts_code%' AND parts_name LIKE '%$parts_name%' AND length LIKE '%$length%' AND kanban_no LIKE '%$kanban_no%' ORDER BY transaction_date_time DESC LIMIT $limiter_count, 200";
	$result = $conn_sql->query($sql);
	if($result->num_rows > 0){
		while($row = $result->fetch_assoc()){
			$no = $no + 1;
			$date_diff = $row['date_diff'];
			if($date_diff == ''){
				$color = 'danger-color';
				$text_color = 'text-white';
			}elseif($date_diff > $cycle_day){
				$color = 'danger-color';
				$text_color = 'text-white';
			}else{
				$color = '';
				$text_color = '';
			}
			echo'
				<tr class="'.$color.' '.$text_color.'" style="cursor:pointer;" onclick="open_history_kanban(&quot;'.$row['kanban'].'~!~'.$row['serial_no'].'&quot;)">
					<td>'.$no.'</td><td>'.$row['line_no'].'</td><td>'.$row['stock_address'].'</td><td>'.$row['parts_code'].'</td><td>'.$row['parts_name'].'</td><td>'.$row['comment'].'</td><td>'.$row['length'].'</td><td>'.$row['quantity'].'</td><td>'.$row['kanban_no'].'</td><td>'.$row['transaction_date_time'].'</td><td>'.$row['transaction_details'].'</td>
				</tr>
			';
		}
	}else{
		echo'
			<tr>
				<td colspan="14" class="text-center h6"><center><i class="fas fa-exclamation-triangle"></i> No Record Found</center></td>
			</tr>
		';
	}
}
elseif($operation == "count_all"){
	$line_no = mysqli_real_escape_string($conn_sql, $_GET['line_no']);
	$parts_code = mysqli_real_escape_string($conn_sql, $_GET['parts_code']);
	$parts_name = mysqli_real_escape_string($conn_sql, $_GET['parts_name']);
	$length = mysqli_real_escape_string($conn_sql, $_GET['length']);
	$kanban_no = mysqli_real_escape_string($conn_sql, $_GET['kanban_no']);
    $limiter_count = mysqli_real_escape_string($conn_sql, $_GET['limiter_count']);
	$date_now = date("Y-m-d H:i:s");
	$sql = "SELECT COUNT(id) AS total FROM tc_kanban_masterlist WHERE line_no LIKE '%$line_no%' AND parts_code LIKE '%$parts_code%' AND parts_name LIKE '%$parts_name%' AND length LIKE '%$length%' AND kanban_no LIKE '%$kanban_no%' ORDER BY transaction_date_time DESC";
	$result = $conn_sql->query($sql);
	if($result->num_rows > 0){
		while($row = $result->fetch_assoc()){
			echo $row['total'];
		}
	}else{
		echo 0;
	}
}
elseif($operation == "open_history_kanban"){
	$kanban = mysqli_real_escape_string($conn_sql, $_GET['kanban']);
	$serial_no = mysqli_real_escape_string($conn_sql, $_GET['serial_no']);
	$limiter_count = mysqli_real_escape_string($conn_sql, $_GET['limiter_count']);
	$no = $limiter_count;
	$date_now = date("Y-m-d H:i:s");
	$sql = "SELECT line_no, stock_address, parts_code, parts_name, comment, length, quantity, kanban_no, scan_date_time, request_date_time, print_date_time, store_out_date_time  FROM tc_history WHERE kanban LIKE '%$kanban%' AND serial_no LIKE '%$serial_no%' ORDER BY store_out_date_time DESC LIMIT 20";
	$result = $conn_sql->query($sql);
	if($result->num_rows > 0){
		while($row = $result->fetch_assoc()){
			$no = $no + 1;
			echo'
				<tr>
					<td>'.$no.'</td><td>'.$row['line_no'].'</td><td>'.$row['stock_address'].'</td><td>'.$row['parts_code'].'</td><td>'.$row['parts_name'].'</td><td>'.$row['comment'].'</td><td>'.$row['length'].'</td><td>'.$row['quantity'].'</td><td>'.$row['kanban_no'].'</td><td>'.$row['scan_date_time'].'</td><td>'.$row['request_date_time'].'</td><td>'.$row['print_date_time'].'</td><td>'.$row['store_out_date_time'].'</td>
				</tr>
			';
		}
	}else{
		echo'
			<tr>
				<td colspan="14" class="text-center h6"><center><i class="fas fa-exclamation-triangle"></i> No Record Found</center></td>
			</tr>
		';
	}
}






















// else if($operation == "count_all"){
// 	$scooter_station = mysqli_real_escape_string($conn_sql, $_GET['scooter_station']);
// 	$line_no = mysqli_real_escape_string($conn_sql, $_GET['line_no']);
// 	$parts_code = mysqli_real_escape_string($conn_sql, $_GET['parts_code']);
// 	$parts_name = mysqli_real_escape_string($conn_sql, $_GET['parts_name']);
// 	$comment = mysqli_real_escape_string($conn_sql, $_GET['comment']);
// 	$length = mysqli_real_escape_string($conn_sql, $_GET['length']);
// 	$kanban_no = mysqli_real_escape_string($conn_sql, $_GET['kanban_no']);
// 	$date_from = mysqli_real_escape_string($conn_sql, $_GET['date_from']);
// 	$date_from=date_create($date_from);
// 	$date_from= date_format($date_from,"Y-m-d H:i:s");
// 	$date_to = mysqli_real_escape_string($conn_sql, $_GET['date_to']);
// 	$date_to=date_create($date_to);
// 	$date_to= date_format($date_to,"Y-m-d H:i:s");
// 	$sql = "SELECT count(id) AS total FROM tc_history WHERE status != '' AND line_no LIKE '%$line_no%' AND parts_code LIKE '%$parts_code%' AND parts_name LIKE '%$parts_name%' AND comment LIKE '%$comment%' AND length LIKE '%$length%' AND kanban_no LIKE '%$kanban_no%' AND scan_date_time >='$date_from' AND scan_date_time <='$date_to'";
// 	$result = $conn_sql->query($sql);
// 	if($result->num_rows > 0){
// 		while($row = $result->fetch_assoc()){
// 			echo $row['total'];
// 		}
// 	}
// }
// else if($operation == "get_all_station"){
// 	$sql = "SELECT scooter_area FROM tc_scooter_area GROUP BY scooter_area ORDER BY scooter_area";
// 	$result = $conn_sql->query($sql);
// 	if($result->num_rows > 0){
// 		while($row = $result->fetch_assoc()){
// 			echo'
// 				<option>'.$row['scooter_area'].'</option>
// 			';
// 		}
// 	}else{
// 	}
// }
$conn_sql->close();
?>
