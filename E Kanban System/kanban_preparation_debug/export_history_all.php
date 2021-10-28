<?php
require_once 'Connection/ConnectSqlsrv.php';
$date_from = $_GET['date_from'];
$date_from=date_create($date_from);
$date_from= date_format($date_from,"Y-m-d H:i:s");
$date_to = $_GET['date_to'];
$date_to=date_create($date_to);
$date_to= date_format($date_to,"Y-m-d H:i:s");
$line_no = $_GET['line_no'];
$parts_code = $_GET['parts_code'];
$parts_name = $_GET['parts_name'];
$scooter_area_select = $_GET['scooter_area_select'];

$datenow = date('Y-m-d');
$filename = "E-Kanban History-".$datenow.".xls";
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
        <td>Quantity</td>
        <td>Scooter Station</td>
		<td>Distributor</td>
		<td>Truck No</td>
		<td>Scan Date & Time</td>
        <td>Request Date & Time</td>
        <td>Print Date & Time</td>
        <td>Store Out Date & Time</td>
        <td>Status</td>
	</tr>
</thead>
';
 $sql = "SELECT id, id_scanned_kanban, kanban, line_no, stock_address, parts_code, parts_name, quantity, kanban_num, scooter_station ,requested_by, scan_date_time, request_date_time, print_date_time, store_out_date_time, status FROM mm_history WHERE scooter_station LIKE '%$scooter_area_select' AND line_no LIKE '%$line_no%' AND parts_name LIKE '%$parts_name%' AND parts_code LIKE '%$parts_code%' AND scan_date_time >='$date_from' AND scan_date_time <='$date_to' ORDER BY scan_date_time DESC";
 $stmt = sqlsrv_query($conn_sqlsrv, $sql);
    $row = sqlsrv_has_rows($stmt);
    if ($row === true){
        while($rows = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){
			$print_date_time = date_format($rows['print_date_time'],'Y-m-d H:i:s');
			$store_out_date_time = date_format($rows['store_out_date_time'],'Y-m-d H:i:s');
            $request_date_time =date_format($rows['request_date_time'],"Y-m-d H:i:s");
			$time_trucking = date("H:i:s",strtotime($request_date_time));

			//Checking the Truck No
			$sql1 = "SELECT truck_no FROM mm_truck_no WHERE time_from <= '$time_trucking' AND time_to >= '$time_trucking'";
			$stmt1 = sqlsrv_query($conn_sqlsrv, $sql1);
			$row1 = sqlsrv_has_rows($stmt1);
			if ($row1 === true){
				while($rows1 = sqlsrv_fetch_array($stmt1, SQLSRV_FETCH_ASSOC)){
					$truck_no = $rows1['truck_no'];
				}
			}else{
				$truck_no = 'Undefined';
			}
            echo'
 				<tr>
                    <td>'.$rows['id_scanned_kanban'].'</td><td>'.$rows['line_no'].'</td><td>'.$rows['stock_address'].'</td><td>'.$rows['parts_code'].'</td><td>'.$rows['parts_name'].'</td><td>'.$rows['kanban_num'].'</td><td>'.$rows['quantity'].'</td><td>'.$rows['scooter_station'].'</td><td>'.$rows['requested_by'].'</td><td>'.$truck_no.'</td><td>'.date_format($rows['scan_date_time'],"Y-m-d H:i:s").'</td><td>'.date_format($rows['request_date_time'],"Y-m-d H:i:s").'</td><td>'.$print_date_time.'</td><td>'.$store_out_date_time.'</td><td>'.$rows['status'].'</td>
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