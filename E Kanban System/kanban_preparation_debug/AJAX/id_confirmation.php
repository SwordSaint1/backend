<?php
require_once '../Connection/ConnectSqlsrv.php';
$operation = $_GET['operation'];
if($operation == "confirmation_id"){
	$id_scan_employee = $_GET['id_scan_employee'];
	$scooter_area = $_GET['scooter_area'];
    $sql = "SELECT TOP 1 id FROM mm_distributor_account WHERE id_no='$id_scan_employee'";
    $stmt = sqlsrv_query($conn_sqlsrv, $sql);
    $row = sqlsrv_has_rows($stmt);
    if ($row === true){
        echo $id_scan_employee;
    }else{
        echo 'Unable to Request';
    }
    sqlsrv_free_stmt($stmt);
    sqlsrv_close($conn_sqlsrv);
}
// else if($operation == "confirm_id_to_delivery"){
// 	$user_id = mysqli_real_escape_string($conn_sql, $_GET['user_id']);
// 	$id_scanned_kanban = mysqli_real_escape_string($conn_sql, $_GET['id_scanned_kanban']);
// 	$store_out_date_time = date("Y-m-d H:i:s");
// 	$sql = "SELECT username FROM account WHERE username='$user_id'";
// 		$result = $conn_sql->query($sql);
// 		if($result->num_rows > 0){
// 			$sql = "UPDATE scanned_kanban SET status='Ready for Delivery', store_out_date_time='$store_out_date_time', store_out_person='$user_id' WHERE id_scanned_kanban='$id_scanned_kanban' AND real_time_status = 'Ready For Delivery'";
// 			if ($conn_sql->query($sql) === TRUE){
// 				echo "Parts is Ready for Delivery";
// 			} else {
// 				echo "Error updating record: " . $conn_sql->error;
// 			}
// 		}else{
// 			echo 'Unable to Update';
// 		}
// }
// $conn_sql->close();
?>
