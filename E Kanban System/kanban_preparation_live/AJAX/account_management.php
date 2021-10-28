<?php
require_once '../Connection/ConnectSqlsrv.php';
$operation = $_GET['operation'];
if($operation == "select_account"){
    $sql = "SELECT * FROM mm_account";
    $stmt = sqlsrv_query($conn_sqlsrv, $sql);
    $row = sqlsrv_has_rows($stmt);
    if ($row === true){
        while($rows = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){
            echo'
                <tr onclick="get_this_account(&quot;'.$rows['id'].'~!~'.$rows['name'].'~!~'.$rows['username'].'~!~'.$rows['role'].'&quot;)" style="cursor:pointer;">
                    <td>'.$rows['id'].'</td><td>'.$rows['username'].'</td><td>'.$rows['name'].'</td><td>'.$rows['role'].'</td><td>'.date_format($rows['date_updated'],"Y-m-d H:i:s").'</td>
                </tr>
            ';
        }
    }else{
        echo "";
    }
    sqlsrv_free_stmt($stmt);
    sqlsrv_close($conn_sqlsrv);
}else if($operation == "save_account"){
	$name = $_GET['name'];
	$username = $_GET['username'];
	$password = $_GET['password'];
	$password = hash('sha256', $password);
	$role =$_GET['role'];
	$date_updated = date("Y-m-d H:i:s");
	$sql = "INSERT INTO mm_account (username, password, name, role, date_updated) VALUES (?,?,?,?,?)";
	$params = array($username, $password, $name, $role, $date_updated);
	$stmt = sqlsrv_query($conn_sqlsrv, $sql, $params);
	if($stmt === false){
		die( print_r( sqlsrv_errors(), true));
	}else{
		echo'New User Succesfully Saved';
	}
	sqlsrv_free_stmt($stmt);
    sqlsrv_close($conn_sqlsrv);
}else if($operation == "update_account"){
	$name = $_GET['name'];
	$username = $_GET['username'];
	$password = $_GET['password'];
	$role =$_GET['role'];
	$id = $_GET['id'];
	$date_updated = date("Y-m-d H:i:s");
	if($password == ''){
		$password = hash('sha256', $password);
		$sql = "UPDATE mm_account SET name=?, username=?, role=?, date_updated=? WHERE id = ?";
		$params = array($name, $username, $role, $date_updated, $id);
	}else{
		$password = hash('sha256', $password);
		$sql = "UPDATE mm_account SET name=?, username=?, password=?, role=?, date_updated=? WHERE id = ?";
		$params = array($name, $username, $password, $role, $date_updated, $id);
	}
	$stmt = sqlsrv_query($conn_sqlsrv, $sql, $params);
	$rows_affected = sqlsrv_rows_affected($stmt);
	if($rows_affected === false){
		die(print_r( sqlsrv_errors(), true));
	}elseif( $rows_affected == -1){
		echo "User Updated Successfully";
	}else{
		// For Count of Affected echo $rows_affected." rows were updated.<br />";
		echo "User Updated Successfully";
	}
	sqlsrv_free_stmt($stmt);
    sqlsrv_close($conn_sqlsrv);
}else if($operation == "delete_account"){
	$id = $_GET['id'];
	$sql = "DELETE FROM mm_account WHERE id = ?";
	$params = array($id);
	$stmt = sqlsrv_query($conn_sqlsrv, $sql, $params);
	if($stmt === false ) {
		die( print_r( sqlsrv_errors(), true));
	}else{
		echo'User Deleted Succesfully';
	}
	sqlsrv_free_stmt($stmt);
    sqlsrv_close($conn_sqlsrv);
}

?>
