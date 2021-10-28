<?php
include '../Connection/Connect_sql.php';
$operation = mysqli_real_escape_string($conn_sql, $_GET['operation']);
if($operation == "by_batch"){
	$no = 0;
	$batch_no = mysqli_real_escape_string($conn_sql, $_GET['batch_no']);
	$sql = "SELECT * FROM tc_kanban_masterlist WHERE batch_id = '$batch_no' ORDER BY line_no ASC, stock_address ASC , parts_code ASC";
	$result = $conn_sql->query($sql);
	if($result->num_rows > 0){
		while($row = $result->fetch_assoc()){
			$no = $no + 1;
			echo'
				<tr>
					<td>'.$no.'</td><td>'.$row['line_no'].'</td><td>'.$row['stock_address'].'</td><td>'.$row['parts_code'].'</td><td>'.$row['parts_name'].'</td><td>'.$row['length'].'</td><td>'.$row['quantity'].'</td>
				</tr>
			';
		}
	}
}else if($operation == "select_station"){
	echo'
		<option selected>Select Station</option>
	';
	$sql = "SELECT * FROM tc_scooter_area ORDER BY scooter_area ASC";
	$result = $conn_sql->query($sql);
	if($result->num_rows > 0){
		while($row = $result->fetch_assoc()){
			echo'
				<option>'.$row['scooter_area'].'</option>
			';
		}
	}
}
$conn_sql->close();
?>
