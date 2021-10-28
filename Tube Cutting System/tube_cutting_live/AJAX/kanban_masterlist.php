<?php
include '../Connection/Connect_oracle.php';
include '../Connection/Connect_sql.php';
$operation = mysqli_real_escape_string($conn_sql, $_GET['operation']);
if($operation == "select_all"){
	$limiter_master = mysqli_real_escape_string($conn_sql, $_GET['limiter_master']);
	$no = $limiter_master;
	$sql = "SELECT * FROM tc_kanban_masterlist ORDER BY line_no ASC, stock_address ASC , parts_code ASC LIMIT $limiter_master, 100";
	$result = $conn_sql->query($sql);
	if($result->num_rows > 0){
		while($row = $result->fetch_assoc()){
			$kanban = $row['kanban'];
			$identification_qr = substr($kanban, 0,3);
				if($identification_qr == 'TC-'){
					$new_iden_qr = 'New';
				}else{
					$new_iden_qr = 'Old';
				}
			$no = $no + 1;
			echo'
				<tr style="cursor:pointer;" onclick="open_details(&quot;'.$row['id'].'&quot;)">
					<td class="font-weight-normal">'.$no.'</td><td class="font-weight-normal">'.$row['line_no'].'</td><td class="font-weight-normal">'.$row['stock_address'].'</td><td class="font-weight-normal">'.$row['parts_code'].'</td><td class="font-weight-normal">'.$row['parts_name'].'</td><td class="font-weight-normal">'.$row['comment'].'</td><td class="font-weight-normal">'.$row['length'].'</td><td class="font-weight-normal">'.$row['quantity'].'</td><td class="font-weight-normal">'.$row['kanban_no'].'</td><td class="font-weight-normal">'.$new_iden_qr.'</td>
				</tr>
			';
		}
	}else{
		
	}
}else if($operation == "count_all_master"){
	$sql = "SELECT count(id) as total FROM tc_kanban_masterlist ORDER BY line_no ASC, stock_address ASC , parts_code ASC";
	$result = $conn_sql->query($sql);
	if($result->num_rows > 0){
		while($row = $result->fetch_assoc()){
			echo $row['total'];
		}
	}else{
		
	}
}else if($operation == "open_details"){
	$id = mysqli_real_escape_string($conn_sql, $_GET['id']);
	$sql = "SELECT * FROM tc_kanban_masterlist WHERE id='$id' LIMIT 1";
	$result = $conn_sql->query($sql);
	if($result->num_rows > 0){
		while($row = $result->fetch_assoc()){
			echo $row['production_lot'].'~!~'.$row['parts_code'].'~!~'.$row['line_no'].'~!~'.$row['stock_address'].'~!~'.$row['parts_name'].'~!~'.$row['comment'].'~!~'.$row['length'].'~!~'.$row['quantity'];
		}
	}else{
		
	}
}else if($operation == "delete_kanban"){
	$id_hidden = mysqli_real_escape_string($conn_sql, $_GET['id_hidden']);
	$sql = "DELETE FROM tc_kanban_masterlist WHERE id='$id_hidden'";
	if ($conn_sql->query($sql) === TRUE) {
		echo 'Kanban Deleted!';
	} else {
		echo "Error deleting record: " . $conn_sql->error;
	}
}else if($operation == "master_delete_confirmed"){
	$idForDeleteHidden = mysqli_real_escape_string($conn_sql, $_GET['idForDeleteHidden']);
	$sql = "DELETE FROM tc_kanban_masterlist WHERE id='$idForDeleteHidden'";
	if ($conn_sql->query($sql) === TRUE) {
		echo 'Kanban Deleted!';
	} else {
		echo "Error deleting record: " . $conn_sql->error;
	}
}
$conn_sql->close();
?>
