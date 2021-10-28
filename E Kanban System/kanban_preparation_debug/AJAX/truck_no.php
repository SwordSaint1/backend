<?php
require_once '../Connection/ConnectSqlsrv.php';
$operation = $_GET['operation'];
if($operation == "select_truck"){
    $no = 0;
    $sql = "SELECT * FROM mm_truck_no";
    $stmt = sqlsrv_query($conn_sqlsrv, $sql);
    $row = sqlsrv_has_rows($stmt);
    if ($row === true){
        while($rows = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){
            $no = $no + 1;
            echo'
                <tr onclick="get_this_truck(&quot;'.$rows['id'].'~!~'.$rows['truck_no'].'~!~'.$rows['time_from'].'~!~'.$rows['time_to'].'&quot;)" style="cursor:pointer;">
                    <td>'.$no.'</td><td>'.$rows['truck_no'].'</td><td>'.$rows['time_from'].'</td><td>'.$rows['time_to'].'</td><td>'.date_format($rows['date_updated'],"Y-m-d H:i:s").'</td>
                </tr>
            ';
        }
    }else{
        echo "";
    }
    sqlsrv_free_stmt($stmt);
    sqlsrv_close($conn_sqlsrv);
}else if($operation == "save_truck"){
	$truck_no = $_GET['truck_no'];
	$time_from = $_GET['time_from'];
	$time_to = $_GET['time_to'];
	$date_updated = date("Y-m-d H:i:s");
	$sql = "INSERT INTO mm_truck_no (truck_no, time_from, time_to, date_updated) VALUES (?,?,?,?)";
	$params = array($truck_no, $time_from, $time_to, $date_updated);
	$stmt = sqlsrv_query($conn_sqlsrv, $sql, $params);
	if($stmt === false){
		die( print_r( sqlsrv_errors(), true));
	}else{
		echo'Truck No Succesfully Saved';
	}
	sqlsrv_free_stmt($stmt);
    sqlsrv_close($conn_sqlsrv);
}else if($operation == "update_truck"){
	$truck_no = $_GET['truck_no'];
	$time_from = $_GET['time_from'];
	$time_to = $_GET['time_to'];
	$id_hidden =$_GET['id_hidden'];
	$date_updated = date("Y-m-d H:i:s");
    $sql = "UPDATE mm_truck_no SET truck_no=?, time_from=?, time_to=?, date_updated=? WHERE id = ?";
    $params = array($truck_no, $time_from, $time_to, $date_updated, $id_hidden);
	$stmt = sqlsrv_query($conn_sqlsrv, $sql, $params);
	$rows_affected = sqlsrv_rows_affected($stmt);
	if($rows_affected === false){
		die(print_r( sqlsrv_errors(), true));
	}elseif( $rows_affected == -1){
		echo "Truck Updated Successfully";
	}else{
		// For Count of Affected echo $rows_affected." rows were updated.<br />";
		echo "Truck Updated Successfully";
	}
	sqlsrv_free_stmt($stmt);
    sqlsrv_close($conn_sqlsrv);
}else if($operation == "delete_truck"){
	$id = $_GET['id_hidden'];
	$sql = "DELETE FROM mm_truck_no WHERE id = ?";
	$params = array($id);
	$stmt = sqlsrv_query($conn_sqlsrv, $sql, $params);
	if($stmt === false ) {
		die( print_r( sqlsrv_errors(), true));
	}else{
		echo'Truck Deleted Succesfully';
	}
	sqlsrv_free_stmt($stmt);
    sqlsrv_close($conn_sqlsrv);
}

?>
