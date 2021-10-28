<?php
set_time_limit(0);
require_once '../Connection/ConnectSqlsrv.php';
$operation = $_GET['operation'];
if($operation == "display_all"){
	$date_from = $_GET['date_from'];
	$date_from=date_create($date_from);
	$date_from= date_format($date_from,"Y-m-d H:i:s");
	$date_to = $_GET['date_to'];
	$date_to=date_create($date_to);
    $date_to= date_format($date_to,"Y-m-d H:i:s");
	$search_status = $_GET['search_status'];
	$line_no_search = $_GET['line_no_search'];
	$parts_code_search1 =$_GET['parts_code_search1'];
	$parts_name_search1 = $_GET['parts_name_search1'];
	$limiter_search = $_GET['limiter_search'];
	$no = $limiter_search;
	 if($search_status == 'Pending'){
		$sql = "SELECT id, id_scanned_kanban, kanban, line_no, stock_address, parts_code, parts_name, quantity, kanban_num, scooter_station, scan_date_time, request_date_time, status FROM mm_scanned_kanban WHERE status = 'Pending' AND line_no LIKE '%$line_no_search%' AND parts_name LIKE '%$parts_name_search1%' AND parts_code LIKE '%$parts_code_search1%' AND scan_date_time >='$date_from' AND scan_date_time <='$date_to' ORDER BY scan_date_time DESC OFFSET $limiter_search ROWS FETCH NEXT 20 ROWS ONLY";
	 }elseif($search_status == 'Ongoing Picking'){
		$sql = "SELECT id, id_scanned_kanban, kanban, line_no, stock_address, parts_code, parts_name, quantity, kanban_num, scooter_station, scan_date_time, request_date_time, print_date_time, status FROM mm_ongoing_picking WHERE status = 'Ongoing Picking' AND line_no LIKE '%$line_no_search%' AND parts_name LIKE '%$parts_name_search1%' AND parts_code LIKE '%$parts_code_search1%' AND scan_date_time >='$date_from' AND scan_date_time <='$date_to' ORDER BY scan_date_time DESC OFFSET $limiter_search ROWS FETCH NEXT 20 ROWS ONLY";
	 }
    $stmt = sqlsrv_query($conn_sqlsrv, $sql);
    $row = sqlsrv_has_rows($stmt);
    if ($row === true){
        while($rows = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){
            $no = $no + 1;
            $id_scanned_kanban = $rows['id_scanned_kanban'];
            $kanban = $rows['kanban'];
			$kanban_num = $rows['kanban_num'];
			$kanban_num = $rows['kanban_num'];
			$request_date_time =date_format($rows['request_date_time'],"Y-m-d H:i:s");
			$time_trucking = date("H:i:s",strtotime($request_date_time));
			if($search_status == 'Pending'){
				$print_date_time = 'N/A';
			 }elseif($search_status == 'Ongoing Picking'){
				$print_date_time = date_format($rows['print_date_time'],'Y-m-d H:i:s');
			 }
            //For Getting the Remarks of MM and Distributor
            $sql1 = "SELECT TOP 1 id, mm_remarks FROM mm_remarks WHERE id_scanned_kanban='$id_scanned_kanban' AND kanban='$kanban' AND kanban_num='$kanban_num' ORDER BY id DESC";
            $stmt1 = sqlsrv_query($conn_sqlsrv, $sql1);
            $row1 = sqlsrv_has_rows($stmt1);
            if ($row1 === true){
                while($rows1 = sqlsrv_fetch_array($stmt1, SQLSRV_FETCH_ASSOC)){
                    $mm_remarks = $rows1['mm_remarks'];
                }
            }else{
                $mm_remarks = '';
			}
			//Checking the Truck No
			$sql2 = "SELECT truck_no FROM mm_truck_no WHERE time_from <= '$time_trucking' AND time_to >= '$time_trucking'";
			$stmt2 = sqlsrv_query($conn_sqlsrv, $sql2);
			$row2 = sqlsrv_has_rows($stmt2);
			if ($row2 === true){
				while($rows2 = sqlsrv_fetch_array($stmt2, SQLSRV_FETCH_ASSOC)){
					$truck_no = $rows2['truck_no'];
				}
			}else{
				$truck_no = 'Undefined';
			}
			//For Getting the Count of Reprint
            $sql3 = "SELECT id FROM mm_reprint_kanban WHERE id_scanned_kanban='$id_scanned_kanban' AND kanban='$kanban'";
            $params3 = array();
            $options3 =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
            $stmt3 = sqlsrv_query($conn_sqlsrv,$sql3,$params3,$options3 );
            $count_reprint = sqlsrv_num_rows($stmt3);
            if($count_reprint != 0){
                $count_reprint = $count_reprint;
            }else{
                $count_reprint = '';
			}
            echo'
 				<tr>
                    <td>'.$no.'</td><td>'.$rows['line_no'].'</td><td>'.$rows['stock_address'].'</td><td>'.$rows['parts_code'].'</td><td>'.$rows['parts_name'].'</td><td>'.$rows['kanban_num'].'</td><td>'.$rows['quantity'].'</td><td>'.$rows['scooter_station'].'</td><td>'.$truck_no.'</td><td>'.date_format($rows['scan_date_time'],"Y-m-d H:i:s").'</td><td>'.date_format($rows['request_date_time'],"Y-m-d H:i:s").'</td><td>'.$print_date_time.' <span class="badge badge-danger" style="cursor:pointer;" onclick="open_reprint_history(&quot;'.$rows['id_scanned_kanban'].'~!~'.$rows['kanban'].'~!~'.date_format($rows['scan_date_time'],"Y-m-d H:i:s").'~!~'.date_format($rows['request_date_time'],"Y-m-d H:i:s").'~!~'.$rows['scooter_station'].'~!~'.$rows['status'].'&quot;)">'.$count_reprint.'</span></td><td style="cursor:pointer;" onclick="add_remarks_mm(&quot;'.$rows['id_scanned_kanban'].'~!~'.$rows['kanban'].'~!~'.$rows['kanban_num'].'~!~'.date_format($rows['scan_date_time'],"Y-m-d H:i:s").'~!~'.date_format($rows['request_date_time'],"Y-m-d H:i:s").'~!~'.$rows['scooter_station'].'&quot;)">'.$mm_remarks.'</td><td>'.$rows['status'].'</td><td class="text-center"><button class="btn unique-color text-white btn-sm mx-0 my-0" onclick="print_kanban_search(&quot;'.$rows['id'].'~!~'.$rows['status'].'&quot;)"><i class="fas fa-print"></i> Print</button></td>
 				</tr>
 			';
        }
    }else{
    }
    sqlsrv_free_stmt($stmt);
    sqlsrv_close($conn_sqlsrv);
}else if($operation == "search_counter"){
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
	if($search_status == 'Pending'){
		$sql = "SELECT id FROM mm_scanned_kanban WHERE status = 'Pending' AND line_no LIKE '%$line_no_search%' AND parts_name LIKE '%$parts_name_search1%' AND parts_code LIKE '%$parts_code_search1%' AND scan_date_time >='$date_from' AND scan_date_time <='$date_to' ORDER BY id ASC";
	}elseif($search_status == 'Ongoing Picking'){
		$sql = "SELECT id FROM mm_ongoing_picking WHERE status = 'Ongoing Picking' AND line_no LIKE '%$line_no_search%' AND parts_name LIKE '%$parts_name_search1%' AND parts_code LIKE '%$parts_code_search1%' AND scan_date_time >='$date_from' AND scan_date_time <='$date_to' ORDER BY id ASC";
	 }
    $params = array();
	$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
	$stmt = sqlsrv_query($conn_sqlsrv,$sql,$params,$options );
	$row_count = sqlsrv_num_rows($stmt);
   	echo $row_count;
    sqlsrv_free_stmt($stmt);
    sqlsrv_close($conn_sqlsrv);
}
?>
