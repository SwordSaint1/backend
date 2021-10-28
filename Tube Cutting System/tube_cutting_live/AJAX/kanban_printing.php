<?php
include '../Connection/Connect_oracle.php';
include '../Connection/Connect_sql.php';
$operation = mysqli_real_escape_string($conn_sql, $_GET['operation']);
if($operation == "by_batch"){
	$sql = "SELECT batch_id FROM tc_kanban_masterlist GROUP BY(batch_id) ORDER BY id ASC";
	$result = $conn_sql->query($sql);
	if($result->num_rows > 0){
			echo'
				<option selected>Select Batch</option>
			';
		while($row = $result->fetch_assoc()){
			echo'
				<option>'.$row['batch_id'].'</option>
			';
		}
	}else{
		
	}
}
else if($operation == "by_line"){
	$sql = "SELECT line_no FROM tc_kanban_masterlist GROUP BY(line_no) ORDER BY id ASC";
	$result = $conn_sql->query($sql);
	if($result->num_rows > 0){
			echo'
				<option selected>Select Line No</option>
			';
		while($row = $result->fetch_assoc()){
			echo'
				<option>'.$row['line_no'].'</option>
			';
		}
	}else{
		
	}
}
else if($operation == "by_latest"){
	$no = 0;
	$sql = "SELECT id, batch_id FROM tc_kanban_masterlist GROUP BY(batch_id) ORDER BY id DESC LIMIT 1";
	$result = $conn_sql->query($sql);
	if($result->num_rows > 0){
		while($row = $result->fetch_assoc()){
			$batch_id = $row['batch_id'];
			$sql1 = "SELECT * FROM tc_kanban_masterlist WHERE batch_id = '$batch_id' ORDER BY line_no ASC, stock_address ASC , parts_code ASC";
			$result1 = $conn_sql->query($sql1);
			if($result1->num_rows > 0){
				while($row1 = $result1->fetch_assoc()){
					$no = $no + 1;
					echo'
						<tr>
							<td>'.$no.'</td><td>'.$row1['line_no'].'</td><td>'.$row1['stock_address'].'</td><td>'.$row1['parts_code'].'</td><td>'.$row1['parts_name'].'</td><td>'.$row1['length'].'</td><td>'.$row1['quantity'].'</td><td><center><button class="btn btn-info btn-sm" onclick="print_single_kanban(&quot;'.$row1['id'].'&quot;)"><i class="fas fa-print"></i> Print</button></center></td>
						</tr>
					';
				}
			}else{
				
			}
		}
	}else{
	}
}
else if($operation == "by_batch_cat"){
	$no = 0;
	$batch_id = mysqli_real_escape_string($conn_sql, $_GET['batch_id']);
	$sql1 = "SELECT * FROM tc_kanban_masterlist WHERE batch_id = '$batch_id' ORDER BY line_no ASC, stock_address ASC , parts_code ASC";
	$result1 = $conn_sql->query($sql1);
	if($result1->num_rows > 0){
		while($row1 = $result1->fetch_assoc()){
			$no = $no + 1;
			echo'
				<tr>
					<td>'.$no.'</td><td>'.$row1['line_no'].'</td><td>'.$row1['stock_address'].'</td><td>'.$row1['parts_code'].'</td><td>'.$row1['parts_name'].'</td><td>'.$row1['length'].'</td><td>'.$row1['quantity'].'</td><td><center><button class="btn btn-info btn-sm" onclick="print_single_kanban(&quot;'.$row1['id'].'&quot;)"><i class="fas fa-print"></i> Print</button></center></td>
				</tr>
			';
		}
	}else{
		
	}
}
else if($operation == "by_line_cat"){
	$no = 0;
	$line_no = mysqli_real_escape_string($conn_sql, $_GET['line_no']);
	$sql1 = "SELECT * FROM tc_kanban_masterlist WHERE line_no = '$line_no' ORDER BY line_no ASC, stock_address ASC , parts_code ASC";
	$result1 = $conn_sql->query($sql1);
	if($result1->num_rows > 0){
		while($row1 = $result1->fetch_assoc()){
			$no = $no + 1;
			echo'
				<tr>
					<td>'.$no.'</td><td>'.$row1['line_no'].'</td><td>'.$row1['stock_address'].'</td><td>'.$row1['parts_code'].'</td><td>'.$row1['parts_name'].'</td><td>'.$row1['length'].'</td><td>'.$row1['quantity'].'</td><td><center><button class="btn btn-info btn-sm" onclick="print_single_kanban(&quot;'.$row1['id'].'&quot;)"><i class="fas fa-print"></i> Print</button></center></td>
				</tr>
			';
		}
	}else{
		
	}
}
$conn_sql->close();
?>
