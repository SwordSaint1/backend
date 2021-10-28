<?php

//nit_set('memory_limit','1024M');
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
        <td>Kanban No</td>
        <td>Length</td>
        <td>Quantity</td>
        <td>Scooter Station</td>
		<td>Comment</td>
		<td>Distributor</td>
		<td>Scan Date & Time</td>
        <td>Request Date & Time</td>
        <td>Print Date & Time</td>
        <td>Store Out Date & Time</td>
        <td>Status</td>
	</tr>
</thead>
';
$scooter_station = mysqli_real_escape_string($conn_sql, $_GET['scooter_station']);
$line_no = mysqli_real_escape_string($conn_sql, $_GET['line_no']);
$parts_name = mysqli_real_escape_string($conn_sql, $_GET['parts_name']);
$parts_code = mysqli_real_escape_string($conn_sql, $_GET['parts_code']);
$comment = mysqli_real_escape_string($conn_sql, $_GET['comment']);
$length = mysqli_real_escape_string($conn_sql, $_GET['length']);
$kanban_no = mysqli_real_escape_string($conn_sql, $_GET['kanban_no']);
$date_from = mysqli_real_escape_string($conn_sql, $_GET['date_from']);
$date_from=date_create($date_from);
$date_from= date_format($date_from,"Y-m-d H:i:s");
$date_to = mysqli_real_escape_string($conn_sql, $_GET['date_to']);
$date_to=date_create($date_to);
$date_to= date_format($date_to,"Y-m-d H:i:s");
$sql = "SELECT * FROM tc_history WHERE status != '' AND line_no LIKE '%$line_no%' AND parts_code LIKE '%$parts_code%' AND parts_name LIKE '%$parts_name%' AND comment LIKE '%$comment%' AND length LIKE '%$length%' AND kanban_no LIKE '%$kanban_no%' AND scan_date_time >='$date_from' AND scan_date_time <='$date_to' ORDER BY scan_date_time DESC";
$result = $conn_sql->query($sql);
	if($result->num_rows > 0){
		while($row = $result->fetch_assoc()){
			echo'
				<tr>
					<td>'.$row['request_id'].'</td><td>'.$row['line_no'].'</td><td>'.$row['stock_address'].'</td><td>'.$row['parts_code'].'</td><td>'.$row['parts_name'].'</td><td>'.$row['kanban_no'].'</td><td>'.$row['length'].'</td><td>'.$row['quantity'].'</td><td>'.$row['scooter_station'].'</td><td>'.$row['comment'].'</td><td>'.$row['scooter_station'].'</td><td>'.$row['scan_date_time'].'</td><td>'.$row['request_date_time'].'</td><td>'.$row['print_date_time'].'</td><td>'.$row['store_out_date_time'].'</td><td>'.$row['status'].'</td>
				</tr>
			';
		}
	}
echo'
</table>
</body>
</html>
';
?>