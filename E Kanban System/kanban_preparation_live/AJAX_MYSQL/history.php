<?php
include '../Connection/Connect_oracle.php';
include '../Connection/Connect_sql.php';
$operation = mysqli_real_escape_string($conn_sql, $_GET['operation']);
if($operation == "select_request_scooter_area"){
	//$scooter_area = mysqli_real_escape_string($conn_sql, $_GET['scooter_area']);
	$sql = "SELECT id_scanned_kanban, distributor, kanban, scooter_station, request_date_time, status, real_time_status FROM history GROUP BY(id_scanned_kanban) ORDER BY id DESC";
	$result = $conn_sql->query($sql);
	if($result->num_rows > 0){
		while($row = $result->fetch_assoc()){
			$sql1 = "SELECT id_scanned_kanban FROM history WHERE id_scanned_kanban='".$row['id_scanned_kanban']."'";
			$result1 = $conn_sql->query($sql1);
			if($result1->num_rows > 0){
				$rowcount = mysqli_num_rows($result1);
				echo'
					<div class="col-sm-3 mt-1">
						<div class="card-body elegant-color white-text rounded-bottom mx-md-n2">
							<h5 class="card-title">Requested By: '.$row['distributor'].'</h5>
							<hr class="hr-light">
							<p class="card-text white-text mb-1">Scooter Station: '.$row['scooter_station'].'</p>
							<p class="card-text white-text mb-1">Date & Time: '.$row['request_date_time'].'</p>
							<p class="card-text white-text mb-1">Kanban: '.$rowcount.'</p>
							<p class="card-text white-text mb-1 h6">Status: '.$row['real_time_status'].'</p>
							<a class="white-text d-flex justify-content-end" onclick="open_details_request(&quot;'.$row['id_scanned_kanban'].'~!~'.$row['real_time_status'].'&quot;)"><h5><i class="fas fa-eye"></i></h5></a>
						</div>
					</div>
				';
			}
		}
	}else{
	}
}
else if($operation == "open_details_request_station"){
	$id_scanned_kanban = mysqli_real_escape_string($conn_sql, $_GET['id_scanned_kanban']);
	$sql = "SELECT * FROM history WHERE id_scanned_kanban='$id_scanned_kanban' ORDER BY scan_date_time ASC";
	$result = $conn_sql->query($sql);
	if($result->num_rows > 0){
		while($row = $result->fetch_assoc()){
			echo'
				<tr>
					<td>'.$row['parts_name'].'</td><td>'.$row['parts_code'].'</td><td>'.$row['line_no'].'</td><td>'.$row['quantity'].'</td><td>'.$row['scan_date_time'].'</td><td>'.$row['request_date_time'].'</td><td>'.$row['real_time_status'].'</td>
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
$conn_sql->close();
?>
