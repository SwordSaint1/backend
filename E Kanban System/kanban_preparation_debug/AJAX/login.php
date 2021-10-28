<?php
include "../Connection/ConnectSqlsrv.php";
$username = $_GET['username'];
$password = $_GET['password'];
$password = hash('sha256', $password);
$sql = "SELECT TOP 1 username, password, role FROM mm_account WHERE username = '$username' AND password = '$password'";
$stmt = sqlsrv_query($conn_sqlsrv, $sql);
$row = sqlsrv_has_rows( $stmt );
if ($row === true){
    while($rows = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){
        echo "unlocked~!~".$rows['role'];
        session_start();
        $_SESSION["username_session"] = $username;
        $_SESSION["role"] = $rows['role'];
    }
}else{
    echo "locked";
}
sqlsrv_free_stmt( $stmt);
sqlsrv_close($conn_sqlsrv);
?>