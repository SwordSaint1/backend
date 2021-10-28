<?php
require_once '../Connection/ConnectSqlsrv.php';
$operation =$_GET['operation'];
if($operation == "display_all"){
	$no = $_GET['no'];
	$scooter_station = $_GET['scooter_station'];
	$line_no = $_GET['line_no'];
	$parts_name = $_GET['parts_name'];
	$parts_code = $_GET['parts_code'];
    $limiter_count = $_GET['limiter_count'];
	$date_from = $_GET['date_from'];
	$date_from=date_create($date_from);
	$date_from= date_format($date_from,"Y-m-d H:i:s");
	$date_to = $_GET['date_to'];
	$date_to=date_create($date_to);
    $date_to= date_format($date_to,"Y-m-d H:i:s");
    $sql = "SELECT id, id_scanned_kanban, kanban, line_no, parts_code, parts_name, kanban_num, quantity, scooter_station, scan_date_time, request_date_time, print_date_time, store_out_date_time FROM mm_history WHERE status != '' AND scooter_station LIKE '%$scooter_station' AND line_no LIKE '%$line_no%' AND parts_name LIKE '%$parts_name%' AND parts_code LIKE '%$parts_code%' AND scan_date_time >='$date_from' AND scan_date_time <='$date_to' ORDER BY scan_date_time DESC OFFSET $limiter_count ROWS FETCH NEXT 20 ROWS ONLY";
    $stmt = sqlsrv_query($conn_sqlsrv, $sql);
    $row = sqlsrv_has_rows($stmt);
    if ($row === true){
        while($rows = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){
            $no = $no + 1;
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
					<td>'.$no.'</td><td>'.$rows['line_no'].'</td><td>'.$rows['parts_code'].'</td><td>'.$rows['parts_name'].'</td><td>'.$rows['kanban_num'].'</td><td>'.$rows['quantity'].'</td><td>'.$rows['scooter_station'].'</td><td>'.$truck_no.'</td><td>'.date_format($rows['scan_date_time'],"Y-m-d H:i:s").'</td><td>'.date_format($rows['request_date_time'],"Y-m-d H:i:s").'</td><td>'.date_format($rows['print_date_time'],"Y-m-d H:i:s").'</td><td>'.date_format($rows['store_out_date_time'],"Y-m-d H:i:s").'</td>
				</tr>
			';
        }
    }else{
        echo'
			<tr>
				<td colspan="11" class="text-center h6 text-danger "><center><i class="fas fa-exclamation-triangle"></i> No Record Found</center></td>
			</tr>
		';
    }
    sqlsrv_free_stmt($stmt);
    sqlsrv_close($conn_sqlsrv);
}
else if($operation == "count_all"){
	$scooter_station = $_GET['scooter_station'];
	$line_no = $_GET['line_no'];
	$parts_name = $_GET['parts_name'];
	$parts_code = $_GET['parts_code'];
	$date_from = $_GET['date_from'];
	$date_from=date_create($date_from);
	$date_from= date_format($date_from,"Y-m-d H:i:s");
	$date_to = $_GET['date_to'];
	$date_to=date_create($date_to);
	$date_to= date_format($date_to,"Y-m-d H:i:s");
	$sql = "SELECT id FROM mm_history WHERE status != '' AND scooter_station LIKE '%$scooter_station' AND line_no LIKE '%$line_no%' AND parts_name LIKE '%$parts_name%' AND parts_code LIKE '%$parts_code%' AND scan_date_time >='$date_from' AND scan_date_time <='$date_to' ORDER BY id ASC";
    $params = array();
	$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
	$stmt = sqlsrv_query($conn_sqlsrv,$sql,$params,$options );
	$row_count = sqlsrv_num_rows($stmt);
   	echo $row_count;
    sqlsrv_free_stmt($stmt);
    sqlsrv_close($conn_sqlsrv);
}
else if($operation == "get_all_station"){
	echo'<option selected>Scooter Station</option>';
	$sql = "SELECT DISTINCT scooter_area FROM mm_scooter_area ORDER BY scooter_area ASC";
    $stmt = sqlsrv_query($conn_sqlsrv, $sql);
    $row = sqlsrv_has_rows($stmt);
    if ($row === true){
        while($rows = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){
			echo'
				<option>'.$rows['scooter_area'].'</option>
			';
        }
    }else{
    }
    sqlsrv_free_stmt($stmt);
	sqlsrv_close($conn_sqlsrv);
}
?>
