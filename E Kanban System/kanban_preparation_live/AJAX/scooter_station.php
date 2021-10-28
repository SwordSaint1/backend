<?php
require_once '../Connection/ConnectSqlsrv.php';
$operation = $_GET['operation'];
if($operation == "select_stations"){
    $sql = "SELECT * FROM mm_scooter_area";
    $stmt = sqlsrv_query($conn_sqlsrv, $sql);
    $row = sqlsrv_has_rows($stmt);
    if ($row === true){
        while($rows = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){
            echo'
                <tr onclick="get_this_station(&quot;'.$rows['id'].'~!~'.$rows['scooter_area'].'~!~'.$rows['ip'].'&quot;)" style="cursor:pointer;">
                    <td>'.$rows['id'].'</td><td>'.$rows['scooter_area'].'</td><td>'.$rows['ip'].'</td><td>'.date_format($rows['date_updated'],"Y-m-d H:i:s").'</td>
                </tr>
            ';
        }
    }else{
        echo "";
    }
    sqlsrv_free_stmt($stmt);
    sqlsrv_close($conn_sqlsrv);
}else if($operation == "save_station"){
	$scooter_area = $_GET['scooter_area'];
	$ip = $_GET['ip'];
	$date_updated = date("Y-m-d H:i:s");
	$sql = "INSERT INTO mm_scooter_area (scooter_area, ip, date_updated) VALUES (?,?,?)";
	$params = array($scooter_area, $ip, $date_updated);
	$stmt = sqlsrv_query($conn_sqlsrv, $sql, $params);
	if($stmt === false){
		die( print_r( sqlsrv_errors(), true));
	}else{
		echo'New Station Succesfully Saved';
	}
	sqlsrv_free_stmt($stmt);
    sqlsrv_close($conn_sqlsrv);
}else if($operation == "update_station"){
	$scooter_area = $_GET['scooter_area'];
	$ip = $_GET['ip'];
	$id = $_GET['id'];
	$date_updated = date("Y-m-d H:i:s");
    $sql = "UPDATE mm_scooter_area SET scooter_area=?, ip=?, date_updated=? WHERE id = ?";
    $params = array($scooter_area, $ip, $date_updated, $id);
	$stmt = sqlsrv_query($conn_sqlsrv, $sql, $params);
	$rows_affected = sqlsrv_rows_affected($stmt);
	if($rows_affected === false){
		die(print_r( sqlsrv_errors(), true));
	}elseif( $rows_affected == -1){
		echo "Station Updated Successfully";
	}else{
		// For Count of Affected echo $rows_affected." rows were updated.<br />";
		echo "Station Updated Successfully";
	}
	sqlsrv_free_stmt($stmt);
    sqlsrv_close($conn_sqlsrv);
}else if($operation == "delete_station"){
	$id = $_GET['id'];
	$sql = "DELETE FROM mm_scooter_area WHERE id = ?";
	$params = array($id);
	$stmt = sqlsrv_query($conn_sqlsrv, $sql, $params);
	if($stmt === false ) {
		die( print_r( sqlsrv_errors(), true));
	}else{
		echo'Station Deleted Succesfully';
	}
	sqlsrv_free_stmt($stmt);
    sqlsrv_close($conn_sqlsrv);
}

?>
