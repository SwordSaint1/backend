<?php
	include '../Connection/Connect_sql.php';
	$ip = $_SERVER['REMOTE_ADDR'];
	$sql = "SELECT ip, scooter_area FROM tc_scooter_area WHERE ip='$ip'";
	$result = $conn_sql->query($sql);
	if($result->num_rows > 0){
		while($row = $result->fetch_assoc()){
			echo 'access';
		}
	}else{
		echo 'access_denied';
	}
$conn_sql->close();
?>