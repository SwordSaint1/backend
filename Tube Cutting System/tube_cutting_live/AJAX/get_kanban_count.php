<?php
include '../Connection/Connect_sql.php';
$operation = mysqli_real_escape_string($conn_sql, $_GET['operation']);
if($operation == "get_kanban_count"){
	$request_id = mysqli_real_escape_string($conn_sql, $_GET['id_scanned_kanban']);
	$sql = "SELECT request_id FROM tc_scanned_kanban WHERE request_id = '$request_id'";
	$result = $conn_sql->query($sql);
	if($result->num_rows > 0){
		 $rowcount = mysqli_num_rows($result);
		 echo $rowcount;
	}else{
	}
}
$conn_sql->close();
?>