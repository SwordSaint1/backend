<?php
include '../Connection/ConnectSqlsrv.php';
$operation = $_GET['operation'];
if($operation == "count_conversation"){
	$remarks_id_scanned_kanban = $_GET['remarks_id_scanned_kanban'];
	$remarks_kanban = $_GET['remarks_kanban'];
	$remarks_kanban_num = $_GET['remarks_kanban_num'];
	$remarks_scan_date_time = $_GET['remarks_scan_date_time'];
	$remarks_request_date_time = $_GET['remarks_request_date_time'];
    $scooter_station = $_GET['scooter_station'];
    //Getting the Count of All Production Remarks
	$sql = "SELECT id FROM mm_remarks WHERE id_scanned_kanban='$remarks_id_scanned_kanban' AND kanban='$remarks_kanban' AND kanban_num='$remarks_kanban_num' AND scan_date_time='$remarks_scan_date_time' AND request_date_time='$remarks_request_date_time' AND sender_identification='MM Remarks'";
    $params = array();
	$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
	$stmt = sqlsrv_query($conn_sqlsrv,$sql,$params,$options );
	$row_count = sqlsrv_num_rows($stmt);
   	echo $row_count;
    sqlsrv_free_stmt($stmt);
    sqlsrv_close($conn_sqlsrv);
}else if($operation == "load_realtime_conversation"){
	$id_scanned_kanban = $_GET['remarks_id_scanned_kanban'];
	$kanban = $_GET['remarks_kanban'];
	$kanban_num = $_GET['remarks_kanban_num'];
	$scan_date_time = $_GET['remarks_scan_date_time'];
	$request_date_time = $_GET['remarks_request_date_time'];
	$scooter_station = $_GET['scooter_station'];
    $sql = "SELECT mm_remarks, sender, sender_identification, remarks_date_time FROM mm_remarks WHERE id_scanned_kanban='$id_scanned_kanban' AND kanban='$kanban' AND kanban_num='$kanban_num' AND scan_date_time='$scan_date_time' AND request_date_time='$request_date_time' AND scooter_station='$scooter_station'";
    $stmt = sqlsrv_query($conn_sqlsrv, $sql);
    $row = sqlsrv_has_rows($stmt);
    if ($row === true){
        while($rows = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){
            $mm_remarks = $rows['mm_remarks'];
            $sender = $rows['sender'];
            $sender_identification = $rows['sender_identification'];
            echo'<div class="chat-message">';
            if($sender_identification == 'MM Remarks'){
                echo'
                <div class="card bg-light rounded w-75 z-depth-0 mb-1 message-text">
                    <div class="card-body p-2">
                        <p class="card-text black-text">'.$mm_remarks.'</p>
                        <p class="card-text black-text text-right" style="font-size:10px;">'.date_format($rows['remarks_date_time'],"Y-m-d H:i:s").'</p>
                    </div>
                </div>
            ';
            }else{
                echo'
                    <div class="card unique-color text-white rounded w-75 float-right z-depth-0 mb-1">
                        <div class="card-body p-2">
                            <p class="card-text text-white mb-1">'.$mm_remarks.'</p>
                            <p class="card-text text-white text-right mx-0 my-0" style="font-size:10px;">'.date_format($rows['remarks_date_time'],"Y-m-d H:i:s").'</p>
                        </div>
                    </div>
                ';
            }
            echo'</div>';
            
        }
    }else{
        $mm_remarks = '';
    }
}























































else if($operation == "remarks_mm"){
	$sql = "SELECT id FROM mm_remarks WHERE sender_identification = 'Production Remarks' and remarks_status = 'Unread'";
    $params = array();
	$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
	$stmt = sqlsrv_query($conn_sqlsrv,$sql,$params,$options );
	$row_count = sqlsrv_num_rows($stmt);
   	echo $row_count;
    sqlsrv_free_stmt($stmt);
    sqlsrv_close($conn_sqlsrv);
}else if($operation == "check_to_ten_min"){
    $my_ip = $_SERVER['REMOTE_ADDR'];
    $sql = "SELECT DISTINCT id_scanned_kanban, request_date_time FROM mm_scanned_kanban WHERE status='Pending' AND (selector_ip='$my_ip' OR selector_ip IS NULL)";
    $stmt = sqlsrv_query($conn_sqlsrv, $sql);
    $row = sqlsrv_has_rows($stmt);
    if ($row === true){
        while($rows = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){
            $request_date_time =date_format($rows['request_date_time'],"Y-m-d H:i:s");
            $convertedTime = date('Y-m-d H:i:s',strtotime('+10 minute',strtotime($request_date_time)));
            $now = date('Y-m-d H:i:s');
			if ($convertedTime < $now){
				echo $rows['id_scanned_kanban'].'~!~';
			}
        }
    }
    sqlsrv_free_stmt($stmt);
    sqlsrv_close($conn_sqlsrv);
}else if($operation == "remove_ip_selector"){
    $sql = "SELECT DISTINCT id_scanned_kanban, selection_date_time FROM mm_scanned_kanban WHERE status='Pending' AND selector_ip != ''";
    $stmt = sqlsrv_query($conn_sqlsrv, $sql);
    $row = sqlsrv_has_rows($stmt);
    if ($row === true){
        while($rows = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){
            $id_scanned_kanban = $rows['id_scanned_kanban'];
            $selection_date_time =date_format($rows['selection_date_time'],"Y-m-d H:i:s");
            $convertedTime = date('Y-m-d H:i:s',strtotime('+10 minute',strtotime($selection_date_time)));
            $now = date('Y-m-d H:i:s');
			if ($convertedTime < $now){
                $sql1 = "UPDATE mm_scanned_kanban SET selector_ip=?, selection_date_time=? WHERE id_scanned_kanban = ?";
                $params1 = array(NULL, NULL, $id_scanned_kanban);
                $stmt1 = sqlsrv_query($conn_sqlsrv, $sql1, $params1);
                $rows_affected = sqlsrv_rows_affected($stmt1);
                if($rows_affected === false){
                    die(print_r( sqlsrv_errors(), true));
                }elseif( $rows_affected == -1){
                    echo "Selector IP was Succesfully Remove";
                }else{
                    // For Count of Affected echo $rows_affected." rows were updated.<br />";
                    echo "Selector IP was Succesfully Remove";
                }
                sqlsrv_free_stmt($stmt1);
			}
        }
    }
    sqlsrv_free_stmt($stmt);
    sqlsrv_close($conn_sqlsrv);
}







// else if($operation == "check_to_ten_min"){
// 	$sql = "SELECT request_id, request_date_time FROM tc_scanned_kanban WHERE status='Pending' GROUP BY(request_id) ";
// 	$result = $conn_sql->query($sql);
// 	if($result->num_rows > 0){
// 		while($row = $result->fetch_assoc()){
// 			$request_date_time = $row['request_date_time'];
// 			$cenvertedTime = date('Y-m-d H:i:s',strtotime('+10 minute',strtotime($request_date_time)));
// 			$now = date('Y-m-d H:i:s');
// 				//echo $cenvertedTime;
// 			if ($cenvertedTime < $now){
// 				echo $row['request_id'].'~!~';
// 			}
// 		}
// 	}else{
// 	}
// }
?>
