<?php
set_time_limit(0);
session_start();
include '../Connection/Connect_sql.php';
$operation = mysqli_real_escape_string($conn_sql, $_GET['operation']);
if($operation == "remarks_scooter_station"){
	$scooter_station = $_SESSION["scooter_area"];
	$sql = "SELECT id FROM tc_mm_remarks WHERE scooter_station='$scooter_station' AND mm_status='Unread'";
	$result = $conn_sql->query($sql);
	if($result->num_rows > 0){
		$rowcount = mysqli_num_rows($result);
		echo $rowcount;
	}else{
		$rowcount = mysqli_num_rows($result);
		echo 0;
	}
}
else if($operation == "scooter_station_remarks_pannel"){
	$scooter_station = $_SESSION["scooter_area"];
	$sql = "SELECT * FROM tc_mm_remarks WHERE scooter_station='$scooter_station' AND mm_status = 'Unread' ORDER BY id DESC";
	$result = $conn_sql->query($sql);
	if ($result->num_rows > 0){
		while($row = $result->fetch_assoc()){
			echo'
				<div class="media ml-1 mb-0" style="cursor:pointer;" onclick="read_remarks(&quot;'.$row['request_id'].'~!~'.$row['kanban'].'~!~'.$row['kanban_num'].'~!~'.$row['scan_date_time'].'~!~'.$row['request_date_time'].'&quot;)">
					<div class="media-body text-white" style="cursor:pointer;">
						<label class="font-weight-bold mb-0">
							'. $row['request_id'] .'
						</label><br>
						<label> New Remarks '.$row['mm_date_time'].'</label>
					</div>
				</div>
				<hr class="mt-0">
			';
		}
	}
}
else if($operation == "remarks_mm"){
	$no = 0;
	$sql = "SELECT * FROM tc_distributor_remarks WHERE distributor_status='Unread'";
	$result = $conn_sql->query($sql);
	if($result->num_rows > 0){
		while($row = $result->fetch_assoc()){
			$request_id = $row['request_id'];
			$kanban = $row['kanban'];
			$kanban_num = $row['kanban_num'];
			$scan_date_time = $row['scan_date_time'];
			$request_date_time = $row['request_date_time'];
			$notif_date_time = $row['distributor_date_time'];
			$distributor_remarks = $row['distributor_remarks'];
			$distributor_status = $row['distributor_status'];
			$sql1 = "SELECT * FROM tc_scanned_kanban WHERE request_id='$request_id' AND kanban='$kanban' AND kanban_no='$kanban_num' AND scan_date_time='$scan_date_time' AND request_date_time='$request_date_time'";
			$result1 = $conn_sql->query($sql1);
			if($result1->num_rows > 0){
				while($row1 = $result1->fetch_assoc()){
					$no = $no +1;
				}
			}  
		}
		echo $no;
	}else{
		$rowcount = mysqli_num_rows($result);
		echo 0;
	}
}
else if($operation == "mm_remarks_pannel"){
	$sql = "SELECT * FROM tc_distributor_remarks WHERE distributor_status = 'Unread' ORDER BY id DESC";
	$result = $conn_sql->query($sql);
	if ($result->num_rows > 0){
		while($row = $result->fetch_assoc()){
			echo'
				<div class="media ml-1 mb-0" style="cursor:pointer;" onclick="read_remarks(&quot;'.$row['request_id'].'~!~'.$row['kanban'].'~!~'.$row['kanban_num'].'~!~'.$row['scan_date_time'].'~!~'.$row['request_date_time'].'~!~'.$row['scooter_station'].'&quot;)">
					<div class="media-body text-white" style="cursor:pointer;">
						<label class="font-weight-bold mb-0">
							Station : ' . $row['scooter_station'] .', '. $row['request_id'] .'
						</label><br>
						<label> New Remarks from Distributor '.$row['distributor_date_time'].'</label>
					</div>
				</div>
				<hr class="mt-0">
			';
		}
	}
}
else if($operation == "read_remarks_now_station"){
	$request_id = mysqli_real_escape_string($conn_sql, $_GET['id_scanned_kanban']);
	$kanban = mysqli_real_escape_string($conn_sql, $_GET['kanban']);
	$kanban_no = mysqli_real_escape_string($conn_sql, $_GET['kanban_num']);
	$scan_date_time = mysqli_real_escape_string($conn_sql, $_GET['scan_date_time']);
	$request_date_time = mysqli_real_escape_string($conn_sql, $_GET['request_date_time']);
	$sql = "UPDATE tc_mm_remarks SET mm_status='Read' WHERE request_id='$request_id' AND kanban='$kanban' AND kanban_num='$kanban_no' AND scan_date_time='$scan_date_time' AND request_date_time='$request_date_time'";
	if ($conn_sql->query($sql) === TRUE){
		//echo "Parts is Ready for Delivery";
	} else {
		echo "Error updating record: " . $conn_sql->error;
	}
}
else if($operation == "read_remarks_now_mm"){
	$request_id = mysqli_real_escape_string($conn_sql, $_GET['id_scanned_kanban']);
	$kanban = mysqli_real_escape_string($conn_sql, $_GET['kanban']);
	$kanban_no = mysqli_real_escape_string($conn_sql, $_GET['kanban_num']);
	$scan_date_time = mysqli_real_escape_string($conn_sql, $_GET['scan_date_time']);
	$request_date_time = mysqli_real_escape_string($conn_sql, $_GET['request_date_time']);
	$sql = "SELECT * FROM tc_scanned_kanban WHERE request_id='$request_id' AND kanban='$kanban' AND kanban_no='$kanban_no' AND scan_date_time='$scan_date_time' AND request_date_time='$request_date_time' ORDER BY line_no ASC, stock_address ASC , parts_code ASC";
	$result = $conn_sql->query($sql);
	if($result->num_rows > 0){
		while($row = $result->fetch_assoc()){
			$request_id = $row['request_id'];
			$kanban = $row['kanban'];
			$kanban_no = $row['kanban_no'];
			$scan_date_time = $row['scan_date_time'];
			$request_date_time = $row['request_date_time'];
			$scooter_station = $row['scooter_station'];
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
					<td>'.$row['line_no'].'</td><td>'.$row['stock_address'].'</td><td>'.$row['parts_code'].'</td><td>'.$row['parts_name'].'</td><td>'.$row['comment'].'</td><td>'.$row['length'].'</td><td>'.$row['quantity'].'</td><td>'.$row['scan_date_time'].'</td><td>'.$row['request_date_time'].'</td><td  onclick="add_remarks_mm_notif(&quot;'.$row['request_id'].'~!~'.$row['kanban'].'~!~'.$row['kanban_no'].'~!~'.$row['scan_date_time'].'~!~'.$row['request_date_time'].'~!~'.$row['status'].'~!~'.$row['scooter_station'].'&quot;)" style="cursor:pointer;">'.$mm_remarks.'</td><td>'.$distributor_remarks.'</td><td>'.$row['status'].'</td>
				</tr>
			';
		}
	}else{
	}
	$sql = "UPDATE tc_distributor_remarks SET distributor_status='Read' WHERE request_id='$request_id' AND kanban='$kanban' AND kanban_num='$kanban_no' AND scan_date_time='$scan_date_time' AND request_date_time='$request_date_time'";
	if ($conn_sql->query($sql) === TRUE){
		//echo "Parts is Ready for Delivery";
	} else {
		echo "Error updating record: " . $conn_sql->error;
	}
}
else if($operation == "reload_now_station"){
	$id_scanned_kanban = mysqli_real_escape_string($conn_sql, $_GET['id_scanned_kanban']);
	$kanban = mysqli_real_escape_string($conn_sql, $_GET['kanban']);
	$kanban_num = mysqli_real_escape_string($conn_sql, $_GET['kanban_num']);
	$scan_date_time = mysqli_real_escape_string($conn_sql, $_GET['scan_date_time']);
	$request_date_time = mysqli_real_escape_string($conn_sql, $_GET['request_date_time']);
	$sql = "SELECT * FROM tc_scanned_kanban WHERE request_id='$id_scanned_kanban' AND kanban='$kanban' AND kanban_no='$kanban_num' AND scan_date_time='$scan_date_time' AND request_date_time='$request_date_time' ORDER BY line_no ASC, stock_address ASC , parts_code ASC";
	$result = $conn_sql->query($sql);
	if($result->num_rows > 0){
		while($row = $result->fetch_assoc()){
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
					<td>'.$row['line_no'].'</td><td>'.$row['stock_address'].'</td><td>'.$row['parts_code'].'</td><td>'.$row['parts_name'].'</td><td>'.$row['comment'].'</td><td>'.$row['length'].'</td><td>'.$row['quantity'].'</td><td>'.$row['kanban_no'].'</td><td>'.$row['scan_date_time'].'</td><td>'.$row['request_date_time'].'</td><td>'.$mm_remarks.'</td><td onclick="add_remarks_distributor_notif(&quot;'.$row['request_id'].'~!~'.$row['kanban'].'~!~'.$row['kanban_no'].'~!~'.$row['scan_date_time'].'~!~'.$row['request_date_time'].'~!~'.$row['status'].'&quot;)" style="cursor:pointer;">'.$distributor_remarks.'</td><td>'.$row['status'].'</td>
				</tr>
			';
		}
	}else{
	}
}
else if($operation == "reload_now_mm"){
	$request_id = mysqli_real_escape_string($conn_sql, $_GET['id_scanned_kanban']);
	$kanban = mysqli_real_escape_string($conn_sql, $_GET['kanban']);
	$kanban_no = mysqli_real_escape_string($conn_sql, $_GET['kanban_num']);
	$scan_date_time = mysqli_real_escape_string($conn_sql, $_GET['scan_date_time']);
	$request_date_time = mysqli_real_escape_string($conn_sql, $_GET['request_date_time']);
	$sql = "SELECT * FROM tc_scanned_kanban WHERE request_id='$request_id' AND kanban='$kanban' AND kanban_no='$kanban_no' AND scan_date_time='$scan_date_time' AND request_date_time='$request_date_time' ORDER BY line_no ASC, stock_address ASC , parts_code ASC";
	$result = $conn_sql->query($sql);
	if($result->num_rows > 0){
		while($row = $result->fetch_assoc()){
			$request_id = $row['request_id'];
			$kanban = $row['kanban'];
			$kanban_no = $row['kanban_no'];
			$scan_date_time = $row['scan_date_time'];
			$request_date_time = $row['request_date_time'];
			$scooter_station = $row['scooter_station'];
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
					<td>'.$row['line_no'].'</td><td>'.$row['stock_address'].'</td><td>'.$row['parts_code'].'</td><td>'.$row['parts_name'].'</td><td>'.$row['quantity'].'</td><td>'.$row['scan_date_time'].'</td><td>'.$row['request_date_time'].'</td><td onclick="add_remarks_mm_notif(&quot;'.$row['request_id'].'~!~'.$row['kanban'].'~!~'.$row['kanban_no'].'~!~'.$row['scan_date_time'].'~!~'.$row['request_date_time'].'~!~'.$row['status'].'~!~'.$row['scooter_station'].'&quot;)" style="cursor:pointer;">'.$mm_remarks.'</td><td>'.$distributor_remarks.'</td><td>'.$row['status'].'</td>
				</tr>
			';
		}
	}else{
	}
}
else if($operation == "open_details_request_mm"){
	$id_scanned_kanban = mysqli_real_escape_string($conn_sql, $_GET['id_scanned_kanban']);
	$kanban = mysqli_real_escape_string($conn_sql, $_GET['kanban']);
	$kanban_num = mysqli_real_escape_string($conn_sql, $_GET['kanban_num']);
	$scan_date_time = mysqli_real_escape_string($conn_sql, $_GET['scan_date_time']);
	$request_date_time = mysqli_real_escape_string($conn_sql, $_GET['request_date_time']);
	$sql = "SELECT * FROM scanned_kanban WHERE id_scanned_kanban='$id_scanned_kanban' AND kanban='$kanban' AND kanban_num='$kanban_num' AND scan_date_time='$scan_date_time' AND request_date_time='$request_date_time' ORDER BY line_no ASC, stock_address ASC , parts_code ASC";
	$result = $conn_sql->query($sql);
	if($result->num_rows > 0){
		while($row = $result->fetch_assoc()){
			$id_scanned_kanban = $row['id_scanned_kanban'];
			$kanban = $row['kanban'];
			$kanban_num = $row['kanban_num'];
			$scan_date_time = $row['scan_date_time'];
			$request_date_time = $row['request_date_time'];
			$sql1 = "SELECT mm_remarks FROM mm_remarks WHERE id_scanned_kanban='$id_scanned_kanban' AND kanban='$kanban' AND kanban_num='$kanban_num' AND scan_date_time='$scan_date_time' AND request_date_time='$request_date_time'";			
			$result1 = $conn_sql->query($sql1);
			if($result1->num_rows > 0){
				while($row1 = $result1->fetch_assoc()){
					$mm_remarks = $row1['mm_remarks'];
				}
			}else{
				$mm_remarks = '';
			}
			$sql1 = "SELECT distributor_remarks FROM distributor_remarks WHERE id_scanned_kanban='$id_scanned_kanban' AND kanban='$kanban' AND kanban_num='$kanban_num' AND scan_date_time='$scan_date_time' AND request_date_time='$request_date_time'";			
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
					<td>'.$row['line_no'].'</td><td>'.$row['stock_address'].'</td><td>'.$row['parts_code'].'</td><td>'.$row['parts_name'].'</td><td>'.$row['quantity'].'</td><td>'.$row['scan_date_time'].'</td><td>'.$row['request_date_time'].'</td><td>'.$mm_remarks.'</td><td onclick="add_remarks_distributor(&quot;'.$row['id_scanned_kanban'].'~!~'.$row['kanban'].'~!~'.$row['kanban_num'].'~!~'.$row['scan_date_time'].'~!~'.$row['request_date_time'].'~!~'.$row['real_time_status'].'&quot;)" style="cursor:pointer;">'.$distributor_remarks.'</td><td>'.$row['real_time_status'].'</td>
				</tr>
			';
		}
	}else{
	}
	$sql = "UPDATE mm_remarks SET mm_status='Read' WHERE id_scanned_kanban='$id_scanned_kanban' AND kanban='$kanban' AND kanban_num='$kanban_num' AND scan_date_time='$scan_date_time' AND request_date_time='$request_date_time'";
	if ($conn_sql->query($sql) === TRUE){
		//echo "Parts is Ready for Delivery";
	} else {
		echo "Error updating record: " . $conn_sql->error;
	}
}
$conn_sql->close();
?>
