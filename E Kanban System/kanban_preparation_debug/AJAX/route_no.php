<?php
require_once '../Connection/ConnectSqlsrv.php';
$operation = $_GET['operation'];
if($operation == "select_route"){
    $no = 0;
    $sql = "SELECT * FROM mm_route_no";
    $stmt = sqlsrv_query($conn_sqlsrv, $sql);
    $row = sqlsrv_has_rows($stmt);
    if ($row === true){
        while($rows = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){
            echo'
                <tr onclick="get_this_route(&quot;'.$rows['id'].'~!~'.$rows['route_no'].'~!~'.$rows['scooter_station'].'~!~'.$rows['car_maker'].'&quot;)" style="cursor:pointer;">
                    <td>'.$rows['id'].'</td><td>'.$rows['route_no'].'</td><td>'.$rows['scooter_station'].'</td><td>'.$rows['car_maker'].'</td><td>'.date_format($rows['date_updated'],"Y-m-d H:i:s").'</td>
                </tr>
            ';
        }
    }else{
        echo "";
    }
    sqlsrv_free_stmt($stmt);
    sqlsrv_close($conn_sqlsrv);
}else if($operation == "load_scooter_station"){
    $no = 0;
    $sql = "SELECT scooter_area FROM mm_scooter_area ORDER BY scooter_area ASC";
    $stmt = sqlsrv_query($conn_sqlsrv, $sql);
    $row = sqlsrv_has_rows($stmt);
    if ($row === true){
        while($rows = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){
            echo'<option>'.$rows['scooter_area'].'</option>';
        }
    }else{
        echo "";
    }
    sqlsrv_free_stmt($stmt);
    sqlsrv_close($conn_sqlsrv);
}else if($operation == "save_route"){
	$route_no = $_GET['route_no'];
	$car_maker = $_GET['car_maker'];
	$scooter_station = $_GET['scooter_station'];
	$date_updated = date("Y-m-d H:i:s");
	$sql = "INSERT INTO mm_route_no (route_no, car_maker, scooter_station, date_updated) VALUES (?,?,?,?)";
	$params = array($route_no, $car_maker, $scooter_station, $date_updated);
	$stmt = sqlsrv_query($conn_sqlsrv, $sql, $params);
	if($stmt === false){
		die( print_r( sqlsrv_errors(), true));
	}else{
		echo'Route Succesfully Saved';
	}
	sqlsrv_free_stmt($stmt);
    sqlsrv_close($conn_sqlsrv);
}else if($operation == "update_route"){
	$route_no = $_GET['route_no'];
	$car_maker = $_GET['car_maker'];
	$scooter_station = $_GET['scooter_station'];
	$id_hidden =$_GET['id_hidden'];
	$date_updated = date("Y-m-d H:i:s");
    $sql = "UPDATE mm_route_no SET route_no=?, car_maker=?, scooter_station=?, date_updated=? WHERE id = ?";
    $params = array($route_no, $car_maker, $scooter_station, $date_updated, $id_hidden);
	$stmt = sqlsrv_query($conn_sqlsrv, $sql, $params);
	$rows_affected = sqlsrv_rows_affected($stmt);
	if($rows_affected === false){
		die(print_r( sqlsrv_errors(), true));
	}elseif( $rows_affected == -1){
		echo "Route Updated Successfully";
	}else{
		// For Count of Affected echo $rows_affected." rows were updated.<br />";
		echo "Route Updated Successfully";
	}
	sqlsrv_free_stmt($stmt);
    sqlsrv_close($conn_sqlsrv);
}else if($operation == "delete_route"){
	$id = $_GET['id'];
	$sql = "DELETE FROM mm_route_no WHERE id = ?";
	$params = array($id);
	$stmt = sqlsrv_query($conn_sqlsrv, $sql, $params);
	if($stmt === false ) {
		die( print_r( sqlsrv_errors(), true));
	}else{
		echo'Route Deleted Succesfully';
	}
	sqlsrv_free_stmt($stmt);
    sqlsrv_close($conn_sqlsrv);
}

?>
