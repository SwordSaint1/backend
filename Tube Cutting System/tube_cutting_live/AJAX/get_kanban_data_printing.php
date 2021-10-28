<?php
include '../Connection/Connect_oracle.php';
include '../Connection/Connect_sql.php';
$operation = mysqli_real_escape_string($conn_sql, $_GET['operation']);
if($operation == "get_scan_kanban"){
	$kanban_scan = mysqli_real_escape_string($conn_sql, $_GET['kanban_scan']);
		$no = 0;
		$sql = "SELECT * FROM tc_kanban_masterlist WHERE kanban='$kanban_scan' LIMIT 1";			
		$result = $conn_sql->query($sql);
		if($result->num_rows > 0){
			while($row = $result->fetch_assoc()){
				$no = $no + 1;
				echo'
					<tr>
						<td class="font-weight-normal">'.$no.'</td><td class="font-weight-normal">'.$row['serial_no'].'</td><td class="font-weight-normal">'.$row['stock_address'].'</td><td class="font-weight-normal">'.$row['parts_code'].'</td><td class="font-weight-normal">'.$row['parts_name'].'</td><td class="font-weight-normal">'.$row['length'].'</td><td class="font-weight-normal">'.$row['quantity'].'</td><td class="font-weight-normal"><center class="mx-0 my-0"><button class="btn btn-info btn-sm mx-0 my-0" onclick="reprint_kanban(&quot;'.$row['id'].'&quot;)"><i class="fas fa-print"></i> Print</button></center></td>
					</tr>
				';
			}
		}else{
		}
		
	}
$conn_sql->close();
?>
