<?php
require_once '../Connection/ConnectSqlsrv.php';
$operation =$_GET['operation'];
if($operation == "add_remarks_mm"){
	$id_scanned_kanban = $_GET['remarks_id_scanned_kanban'];
	$kanban = $_GET['remarks_kanban'];
	$kanban_num = $_GET['remarks_kanban_num'];
	$scan_date_time = $_GET['remarks_scan_date_time'];
	$request_date_time = $_GET['remarks_request_date_time'];
	$mm_remarks = $_GET['mm_remarks'];
	$scooter_station = $_GET['scooter_station'];
    $remarks_date_time = date("Y-m-d H:i:s");
    $sender_remarks = $_GET['sender_remarks'];
    
    $sql = "INSERT INTO mm_remarks (id_scanned_kanban, kanban, kanban_num, scooter_station, scan_date_time, request_date_time, mm_remarks, sender, sender_identification, remarks_date_time, remarks_status) VALUES (?,?,?,?,?,?,?,?,?,?,?)";
	$params = array($id_scanned_kanban, $kanban, $kanban_num, $scooter_station, $scan_date_time , $request_date_time, $mm_remarks, $sender_remarks, 'MM Remarks', $remarks_date_time, 'Unread');
	$stmt = sqlsrv_query($conn_sqlsrv, $sql, $params);
	if($stmt === false){
		die( print_r( sqlsrv_errors(), true));
	}else{
		echo'Remarks Succesfully Saved';
	}
	sqlsrv_free_stmt($stmt);
    sqlsrv_close($conn_sqlsrv);
}else if($operation == "load_remarks_conversation"){
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
            if($sender_identification == 'Production Remarks'){
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
                            <p class="card-text text-white">'.$mm_remarks.'</p>
                            <p class="card-text text-white text-right" style="font-size:10px;">'.date_format($rows['remarks_date_time'],"Y-m-d H:i:s").'</p>
                        </div>
                    </div>
                ';
            }
            echo'</div>';
            
        }
    }else{
        $mm_remarks = '';
    }
}else if($operation == "update_seen"){
	$id_scanned_kanban = $_GET['remarks_id_scanned_kanban'];
	$kanban = $_GET['remarks_kanban'];
	$kanban_num = $_GET['remarks_kanban_num'];
	$scan_date_time = $_GET['remarks_scan_date_time'];
	$request_date_time = $_GET['remarks_request_date_time'];
	$scooter_station = $_GET['scooter_station'];
    $seen_date_time = date("Y-m-d H:i:s");

    $sql = "UPDATE mm_remarks SET remarks_status=?, seen_date_time=? WHERE id_scanned_kanban = ? AND kanban = ? AND kanban_num = ? AND scan_date_time = ? AND request_date_time = ? AND sender_identification = ?";
    $params = array('Read', $seen_date_time, $id_scanned_kanban, $kanban, $kanban_num, $scan_date_time, $request_date_time, 'Production Remarks');
	$stmt = sqlsrv_query($conn_sqlsrv, $sql, $params);
	$rows_affected = sqlsrv_rows_affected($stmt);
	if($rows_affected === false){
		die(print_r( sqlsrv_errors(), true));
	}elseif( $rows_affected == -1){
		echo "Seen";
	}else{
		// For Count of Affected echo $rows_affected." rows were updated.<br />";
		echo "Seen";
	}
	sqlsrv_free_stmt($stmt);
    sqlsrv_close($conn_sqlsrv);
   
}
?>