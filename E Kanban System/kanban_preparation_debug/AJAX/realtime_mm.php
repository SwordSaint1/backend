<?php
include '../Connection/ConnectSqlsrv.php';
$operation = $_GET['operation'];
if($operation == "count_entries"){
    $my_ip = $_SERVER['REMOTE_ADDR'];
	$sql = "SELECT id FROM mm_scanned_kanban WHERE status = 'Pending' AND (selector_ip='$my_ip' OR selector_ip IS NULL) UNION SELECT id FROM mm_ongoing_picking WHERE status = 'Ongoing Picking' ";
    $params = array();
	$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
	$stmt = sqlsrv_query($conn_sqlsrv,$sql,$params,$options );
	$row_count = sqlsrv_num_rows($stmt);
   	echo $row_count;
    sqlsrv_free_stmt($stmt);
    sqlsrv_close($conn_sqlsrv);
}else if($operation == "remarks_mm"){
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
?>
