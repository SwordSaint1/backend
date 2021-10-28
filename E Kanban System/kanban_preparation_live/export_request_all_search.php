<?php
require_once 'Connection/ConnectSqlsrv.php';
$date_from = $_GET['date_from'];
$date_from=date_create($date_from);
$date_from= date_format($date_from,"Y-m-d H:i:s");
$date_to = $_GET['date_to'];
$date_to=date_create($date_to);
$date_to= date_format($date_to,"Y-m-d H:i:s");
$search_status = $_GET['search_status'];
$line_no_search = $_GET['line_no_search'];
$parts_code_search1 = $_GET['parts_code_search1'];
$parts_name_search1 = $_GET['parts_name_search1'];
$scooter_station = $_GET['scooter_station'];
if($scooter_station == '' || $scooter_station =='Scooter Station'){
	$scooter_station = '';
	$scooter_station_title = 'All';
}else{
	$scooter_station = $scooter_station;
    $scooter_station_title = $scooter_station;
}
$datenow = date('Y-m-d');
$filename = $search_status." of ".$scooter_station_title." - ".$datenow.".xls";
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
if($search_status == 'Pending'){
    $sql = "SELECT id, id_scanned_kanban, kanban, line_no, stock_address, parts_code, parts_name, quantity, kanban_num, scooter_station, scan_date_time, requested_by, request_date_time, status FROM mm_scanned_kanban WHERE status = 'Pending' AND line_no LIKE '%$line_no_search%' AND parts_name LIKE '%$parts_name_search1%' AND parts_code LIKE '%$parts_code_search1%' AND scooter_station LIKE '%$scooter_station%' AND scan_date_time >='$date_from' AND scan_date_time <='$date_to' ORDER BY scan_date_time DESC";
}elseif($search_status == 'Ongoing Picking'){
    $sql = "SELECT id, id_scanned_kanban, kanban, line_no, stock_address, parts_code, parts_name, quantity, kanban_num, scooter_station, scan_date_time, requested_by, request_date_time, print_date_time, status FROM mm_ongoing_picking WHERE status = 'Ongoing Picking' AND line_no LIKE '%$line_no_search%' AND parts_name LIKE '%$parts_name_search1%' AND parts_code LIKE '%$parts_code_search1%' AND scooter_station LIKE '%$scooter_station%' AND scan_date_time >='$date_from' AND scan_date_time <='$date_to' ORDER BY scan_date_time DESC";
}
 $stmt = sqlsrv_query($conn_sqlsrv, $sql);
    $row = sqlsrv_has_rows($stmt);
    if ($row === true){
        while($rows = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){
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
			if($search_status == 'Pending'){
				$print_date_time = 'N/A';
			 }elseif($search_status == 'Ongoing Picking'){
				$print_date_time = date_format($rows['print_date_time'],'Y-m-d H:i:s');
			 }
            echo'
 				<tr>
                    <td>'.$rows['id_scanned_kanban'].'</td><td>'.$rows['line_no'].'</td><td>'.$rows['stock_address'].'</td><td>'.$rows['parts_code'].'</td><td>'.$rows['parts_name'].'</td><td>'.$rows['kanban_num'].'</td><td>'.$rows['quantity'].'</td><td>'.$rows['scooter_station'].'</td><td>'.$rows['requested_by'].'</td><td>'.$truck_no.'</td><td>'.date_format($rows['scan_date_time'],"Y-m-d H:i:s").'</td><td>'.date_format($rows['request_date_time'],"Y-m-d H:i:s").'</td><td>'.$print_date_time.'</td><td>N/A</td><td>'.$rows['status'].'</td>
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