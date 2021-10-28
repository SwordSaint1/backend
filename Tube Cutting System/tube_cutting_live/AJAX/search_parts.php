<?php
include '../Connection/Connect_oracle.php';
include '../Connection/Connect_sql.php';
$operation = mysqli_real_escape_string($conn_sql, $_GET['operation']);
if($operation == "display_all"){
	$no = 0;
	//$scooter_station = mysqli_real_escape_string($conn_sql, $_GET['scooter_station']);
	$line_no_search = mysqli_real_escape_string($conn_sql, $_GET['line_no_search']);
	$parts_name_search = mysqli_real_escape_string($conn_sql, $_GET['parts_name_search1']);
	$parts_code_search = mysqli_real_escape_string($conn_sql, $_GET['parts_code_search1']);
	$length_search1 = mysqli_real_escape_string($conn_sql, $_GET['length_search1']);
	$sql = "SELECT * FROM tc_kanban_masterlist WHERE line_no LIKE '%$line_no_search%' AND parts_name LIKE '%$parts_name_search%' AND parts_code LIKE '%$parts_code_search%' AND length LIKE '%$length_search1%' ORDER BY id ASC";
	$result = $conn_sql->query($sql);
	if($result->num_rows > 0){
		while($row = $result->fetch_assoc()){
			$kanban =$row['kanban'];
			$identification_qr = substr($kanban, 0,3);
			if($identification_qr == 'TC-'){
				$new_iden_qr = 'New';
			}else{
				$new_iden_qr = 'Old';
			}
			$no = $no + 1;
				echo'
					<tr style="cursor:pointer;" >
						<td class="font-weight-normal">'.$no.'</td><td class="font-weight-normal">'.$row['line_no'].'</td><td class="font-weight-normal">'.$row['stock_address'].'</td><td class="font-weight-normal">'.$row['parts_code'].'</td><td class="font-weight-normal">'.$row['parts_name'].'</td><td class="font-weight-normal">'.$row['comment'].'</td><td class="font-weight-normal">'.$row['length'].'</td><td class="font-weight-normal">'.$row['quantity'].'</td><td class="font-weight-normal">'.$row['kanban_no'].'</td><td class="font-weight-normal">'.$new_iden_qr.'</td><td class="font-weight-normal"><center class="mx-0 my-0"><button class="btn btn-info btn-sm mx-0 my-0" onclick="print_single_kanban(&quot;'.$row['id'].'&quot;)"><i class="fas fa-print"></i> Print</button></center></td><td class="font-weight-normal"><center class="mx-0 my-0"><button class="btn btn-info btn-sm mx-0 my-0" onclick="open_details(&quot;'.$row['id'].'&quot;)"><i class="fas fa-edit"></i> Edit</button></center></td><td class="font-weight-normal"><center class="mx-0 my-0"><button class="btn btn-danger btn-sm mx-0 my-0" onclick="delete_single_kanban_master(&quot;'.$row['id'].'&quot;)"><i class="fas fa-trash"></i> Delete</button></center></td>
					</tr>
				';
		}
	}else{
		echo "<td colspan='10' style='font-weight:bold;color:red;'><center>NO DATA FOUND</center></td>";
	}
}else if($operation == "load_all_station"){
	$sql = "SELECT scooter_area FROM tc_scooter_area ORDER BY scooter_area ASC";
	$result = $conn_sql->query($sql);
	if($result->num_rows > 0){
		while($row = $result->fetch_assoc()){
			$no = $no + 1;
				echo'
					<option selected>'.$row['scooter_area'].'</option>
				';
		}
	}else{
		echo'No Data Found';
	}
}
$conn_sql->close();
?>
