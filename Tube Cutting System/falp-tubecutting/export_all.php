<?php
include 'Connection/Connect_sql.php';
$datenow = date('Y-m-d');
$filename = "History".$datenow.".xls";
header("Content-Type: application/vnd.ms-excel");
header('Content-Type: text/csv; charset=utf-8');  
header("Content-Disposition: ; filename=\"$filename\"");
echo'
<html lang="en">
<body>
<table border="1">
<thead>
	<tr>
		<td>Request ID</td>
		<td>Line No</td>
		<td>Stock Address</td>
		<td>Parts Code</td>
		<td>Parts Name</td>
		<td>Quantity</td>
		<td>Kanban Number</td>
		<td>Distributor</td>
		<td>MM Remarks</td>
		<td>Distributor Remarks</td>
		<td>Scan Date and Time</td>
		<td>Request Date and Time</td>
		<td>Store Out Date and Time</td>
	</tr>
</thead>
';
$date_from = mysqli_real_escape_string($conn_sql, $_GET['date_from']);
$date_from = $date_from.' 00:00:00';
$date_to = mysqli_real_escape_string($conn_sql, $_GET['date_to']);
$date_to = $date_to.' 24:59:59';
$sql = "SELECT * FROM tc_history WHERE (request_date_time >= '$date_from' AND request_date_time <= '$date_to') ORDER BY request_date_time ASC, line_no ASC, stock_address ASC , parts_code ASC";
	$result = $conn_sql->query($sql);
	if($result->num_rows > 0){
		while($row = $result->fetch_assoc()){
			$request_id = $row['request_id'];
			$kanban = $row['kanban'];
			$kanban_no = $row['kanban_no'];
			$scan_date_time = $row['scan_date_time'];
			$request_date_time = $row['request_date_time'];
			$sql1 = "SELECT request_id FROM tc_history WHERE line_no='".$row['line_no']."'";
			$result1 = $conn_sql->query($sql1);
			if($result1->num_rows > 0){
				$rowcount = mysqli_num_rows($result1);
				echo'
					<tr>
						<td class="font-weight-normal">'.$row['request_id'].'</td>
						<td class="font-weight-normal">'.$row['line_no'].'</td>
						<td class="font-weight-normal">'.$row['stock_address'].'</td>
						<td class="font-weight-normal">'.$row['parts_code'].'</td>
						<td class="font-weight-normal">'.$row['parts_name'].'</td>
						<td class="font-weight-normal">'.$row['quantity'].'</td>
						<td class="font-weight-normal">'.$row['kanban_no'].'</td>
						<td class="font-weight-normal">'.$row['distributor'].'</td>
						<td class="font-weight-normal">
				';
						$sql1 = "SELECT mm_remarks FROM tc_mm_remarks WHERE request_id='$request_id' AND kanban='$kanban' AND kanban_num='$kanban_no' AND scan_date_time='$scan_date_time' AND request_date_time='$request_date_time'";			
						$result1 = $conn_sql->query($sql1);
						if($result1->num_rows > 0){
							while($row1 = $result1->fetch_assoc()){
								$mm_remarks = $row1['mm_remarks'];
								echo $mm_remarks .'<br>';
							}
						}else{
						}
				echo'
						</td>
						<td class="font-weight-normal">
				';
						$sql1 = "SELECT distributor_remarks FROM tc_distributor_remarks WHERE request_id='$request_id' AND kanban='$kanban' AND kanban_num='$kanban_no' AND scan_date_time='$scan_date_time' AND request_date_time='$request_date_time'";			
						$result1 = $conn_sql->query($sql1);
						if($result1->num_rows > 0){
							while($row1 = $result1->fetch_assoc()){
								$distributor_remarks = $row1['distributor_remarks'];
								echo $distributor_remarks .'<br>';
							}
						}else{
						}
				echo'
						</td>
						<td class="font-weight-normal">'.$row['scan_date_time'].'</td>
						<td class="font-weight-normal">'.$row['request_date_time'].'</td>
						<td class="font-weight-normal">'.$row['store_out_date_time'].'</td>
					</tr>
				';
			}
		}
	}else{
		
	}
echo'
</table>
</body>
</html>
';
?>