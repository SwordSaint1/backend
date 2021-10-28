<?php
$username = $_GET['username'];
$password = $_GET['password'];
include "../Connection/Connect_sql.php";
$sql = "SELECT * FROM tc_account WHERE username = '$username' && password = '$password'";
$result = $conn_sql->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()){
		echo "unlocked~!~".$row['role'];
		session_start();
		$_SESSION["username_session"] = $username;
		$_SESSION["role"] = $row['role'];
	}
} else {
    echo "locked";
}
$conn_sql->close();
?>