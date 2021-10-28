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
	$search_status = mysqli_real_escape_string($conn_sql, $_GET['search_status']);
	$line_no_search = mysqli_real_escape_string($conn_sql, $_GET['line_no_search']);
	$parts_code_search1 = mysqli_real_escape_string($conn_sql, $_GET['parts_code_search1']);
	$parts_name_search1 = mysqli_real_escape_string($conn_sql, $_GET['parts_name_search1']);
	$comment_search1 = mysqli_real_escape_string($conn_sql, $_GET['comment_search1']);
	$length_search1 = mysqli_real_escape_string($conn_sql, $_GET['length_search1']);
	$limiter_search = mysqli_real_escape_string($conn_sql, $_GET['limiter_search']);
	$no = $limiter_search;
	$sql = "SELECT * FROM tc_scanned_kanban WHERE line_no LIKE '%$line_no_search%' AND parts_code LIKE '%$parts_code_search1%' AND parts_name LIKE '%$parts_name_search1%' AND comment like '%$comment_search1%' AND length like '%$length_search1%' AND status LIKE '%$search_status%' AND (scan_date_time >= '$date_from' AND scan_date_time <= '$date_to')  ORDER BY id ASC LIMIT $limiter_search, 20";
	$result = $conn_sql->query($sql);
	if($result->num_rows > 0){
		while($row = $result->fetch_assoc()){
			$no = $no + 1;
			$request_id = $row['request_id'];
			$kanban = $row['kanban'];
			$kanban_no = $row['kanban_no'];
			$scan_date_time = $row['scan_date_time'];
			$request_date_time = $row['request_date_time'];
			$sql1 = "SELECT mm_remarks FROM tc_mm_remarks WHERE request_id='$request_id' AND kanban='$kanban' AND kanban_num='$kanban_no' AND scan_date_time='$scan_date_time' AND request_date_time='$request_date_time'";			
			$result1 = $conn_sql->query($sql1);
			if($result1->num_rows > 0){
				while($row1 = $result1->fetch_assoc()){
					$mm_remarks = $row1['mm_remarks'];
				}
			}else{
				$mm_remarks = '';
			}
			$sql1 = "SELECT distributor_remarks FROM tc_distributor_remarks WHERE request_id='$request_id' AND kanban='$kanban' AND kanban_num='$kanban_no' AND scan_date_time='$scan_date_time' AND request_date_time='$request_date_time'";			
			$result1 = $conn_sql->query($sql1);
			if($result1->num_rows > 0){
				while($row1 = $result1->fetch_assoc()){
					$distributor_remarks = $row1['distributor_remarks'];
				}
			}else{
				$distributor_remarks = '';
			}
			echo'
				<tr>
					<td class="font-weight-normal">'.$no.'</td><td class="font-weight-normal">'.$row['line_no'].'</td><td class="font-weight-normal">'.$row['stock_address'].'</td><td class="font-weight-normal">'.$row['parts_code'].'</td><td class="font-weight-normal">'.$row['parts_name'].'</td><td class="font-weight-normal">'.$row['comment'].'</td><td class="font-weight-normal">'.$row['length'].'</td><td class="font-weight-normal">'.$row['quantity'].'</td><td class="font-weight-normal">'.$row['scan_date_time'].'</td><td class="font-weight-normal">'.$row['request_date_time'].'</td><td class="font-weight-normal">'.$row['print_date_time'].'</td><td class="font-weight-normal" onclick="add_remarks_tc_search(&quot;'.$row['request_id'].'~!~'.$row['kanban'].'~!~'.$row['kanban_no'].'~!~'.$row['scan_date_time'].'~!~'.$row['request_date_time'].'~!~'.$row['scooter_station'].'&quot;)" style="cursor:pointer;">'.$mm_remarks.'</td><td class="font-weight-normal">'.$distributor_remarks.'</td><td class="font-weight-normal">'.$row['status'].'</td><td class="font-weight-normal"><center class="mx-0 my-0"><button class="btn btn-info btn-sm mx-0 my-0" onclick="print_kanban_search(&quot;'.$row['id'].'&quot;)"><i class="fas fa-print"></i> Print</button></center></td>
				</tr>
			';
		}
	}else{
	}
}else if($operation == "search_counter"){
	$date_from = mysqli_real_escape_string($conn_sql, $_GET['date_from']);
	$date_from=date_create($date_from);
	$date_from= date_format($date_from,"Y-m-d H:i:s");
	$date_to = mysqli_real_escape_string($conn_sql, $_GET['date_to']);
	$date_to=date_create($date_to);
	$date_to= date_format($date_to,"Y-m-d H:i:s");
	$search_status = mysqli_real_escape_string($conn_sql, $_GET['search_status']);
	$line_no_search = mysqli_real_escape_string($conn_sql, $_GET['line_no_search']);
	$parts_code_search1 = mysqli_real_escape_string($conn_sql, $_GET['parts_code_search1']);
	$parts_name_search1 = mysqli_real_escape_string($conn_sql, $_GET['parts_name_search1']);
	$comment_search1 = mysqli_real_escape_string($conn_sql, $_GET['comment_search1']);
	$length_search1 = mysqli_real_escape_string($conn_sql, $_GET['length_search1']);
	$sql = "SELECT count(id) AS total FROM tc_scanned_kanban WHERE line_no LIKE '%$line_no_search%' AND parts_code LIKE '%$parts_code_search1%' AND parts_name LIKE '%$parts_name_search1%' AND comment like '%$comment_search1%' AND length like '%$length_search1%' AND status LIKE '%$search_status%' AND (scan_date_time >= '$date_from' AND scan_date_time <= '$date_to')  ORDER BY id ASC";
	$result = $conn_sql->query($sql);
	if($result->num_rows > 0){
		while($row = $result->fetch_assoc()){
			$total =$row['total'];
			echo $total;
		}
	}else{
	}
}
$conn_sql->close();
?>
