<?php
require_once '../Connection/ConnectSqlsrv.php';
$operation = $_GET['operation'];
if($operation == "select_distributor"){
    $sql = "SELECT * FROM mm_distributor_account";
    $stmt = sqlsrv_query($conn_sqlsrv, $sql);
    $row = sqlsrv_has_rows($stmt);
    if ($row === true){
        while($rows = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){
            echo'
                <tr onclick="get_this_distributor(&quot;'.$rows['id'].'~!~'.$rows['id_no'].'~!~'.$rows['scooter_area'].'~!~'.$rows['name'].'&quot;)" style="cursor:pointer;">
                    <td>'.$rows['id'].'</td><td>'.$rows['id_no'].'</td><td>'.$rows['scooter_area'].'</td><td>'.$rows['name'].'</td><td>'.date_format($rows['date_updated'],"Y-m-d H:i:s").'</td>
				</tr>
            ';
        }
    }else{
        echo "";
    }
    sqlsrv_free_stmt($stmt);
    sqlsrv_close($conn_sqlsrv);
}else if($operation == "save_distributor"){
	$id_no = $_GET['id_no'];
	$name = $_GET['name'];
	$scooter_area = $_GET['scooter_area'];
	$date_updated = date("Y-m-d H:i:s");
	$sql = "INSERT INTO mm_distributor_account (id_no, scooter_area, name, date_updated) VALUES (?,?,?,?)";
	$params = array($id_no, $scooter_area, $name, $date_updated);
	$stmt = sqlsrv_query($conn_sqlsrv, $sql, $params);
	if($stmt === false){
		die( print_r( sqlsrv_errors(), true));
	}else{
		echo'Distributor Succesfully Saved';
	}
	sqlsrv_free_stmt($stmt);
    sqlsrv_close($conn_sqlsrv);
}else if($operation == "update_distributor"){
	$id = $_GET['id'];
	$scooter_area = $_GET['scooter_area'];
	$name = $_GET['name'];
	$id_no = $_GET['id_no'];
	$date_updated = date("Y-m-d H:i:s");
    $sql = "UPDATE mm_distributor_account SET id_no=?, scooter_area=?, name=?, date_updated=? WHERE id = ?";
    $params = array($id_no, $scooter_area, $name, $date_updated, $id);
	$stmt = sqlsrv_query($conn_sqlsrv, $sql, $params);
	$rows_affected = sqlsrv_rows_affected($stmt);
	if($rows_affected === false){
		die(print_r( sqlsrv_errors(), true));
	}elseif( $rows_affected == -1){
		echo "Distributor Updated Successfully";
	}else{
		// For Count of Affected echo $rows_affected." rows were updated.<br />";
		echo "Distributor Updated Successfully";
	}
	sqlsrv_free_stmt($stmt);
    sqlsrv_close($conn_sqlsrv);
}else if($operation == "delete_distributor"){
	$id = $_GET['id'];
	$sql = "DELETE FROM mm_distributor_account WHERE id = ?";
	$params = array($id);
	$stmt = sqlsrv_query($conn_sqlsrv, $sql, $params);
	if($stmt === false ) {
		die( print_r( sqlsrv_errors(), true));
	}else{
		echo "Distributor deleted successfully";
	}
	sqlsrv_free_stmt($stmt);
    sqlsrv_close($conn_sqlsrv);
}else if($operation == "load_scooter_area"){
	echo '<option>Scooter Station</option>';
	$sql = "SELECT DISTINCT scooter_area FROM mm_scooter_area ORDER BY scooter_area ASC";
    $stmt = sqlsrv_query($conn_sqlsrv, $sql);
    $row = sqlsrv_has_rows($stmt);
    if ($row === true){
        while($rows = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){
			echo '<option>'.$rows['scooter_area'].'</option>';
        }
    }else{
        echo "";
    }
	sqlsrv_free_stmt($stmt);
	sqlsrv_close($conn_sqlsrv);
}  

?>
