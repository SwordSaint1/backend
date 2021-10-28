<?php
include '../Connection/Connect_sql.php';
$operation = mysqli_real_escape_string($conn_sql, $_GET['operation']);
if($operation == "select_scooter_station"){
	$sql = "SELECT * FROM tc_scooter_area";
	$result = $conn_sql->query($sql);
	if($result->num_rows > 0){
		while($row = $result->fetch_assoc()){
			echo'<option>'.$row['scooter_area'].'</option>';
		}
	}else{
	}
}
if($operation == "select_lines"){
	$sql = "SELECT DISTINCT(line_no) FROM tc_history ORDER BY line_no ASC";
	$result = $conn_sql->query($sql);
	if($result->num_rows > 0){
		while($row = $result->fetch_assoc()){
			echo'<option>'.$row['line_no'].'</option>';
		}
	}else{
	}
}
$conn_sql->close();
?>
