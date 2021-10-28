<?php
include '../Connection/ConnectSqlsrv.php';
$operation = $_GET['operation'];
if($operation == "count_notif"){
    $scooter_station = $_GET['scooter_station'];
	$sql = "SELECT id FROM mm_remarks WHERE scooter_station='$scooter_station' AND sender_identification = 'MM Remarks' and remarks_status = 'Unread'";
    $params = array();
	$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
	$stmt = sqlsrv_query($conn_sqlsrv,$sql,$params,$options );
	$row_count = sqlsrv_num_rows($stmt);
   	echo $row_count;
    sqlsrv_free_stmt($stmt);
    sqlsrv_close($conn_sqlsrv);
}
?>
