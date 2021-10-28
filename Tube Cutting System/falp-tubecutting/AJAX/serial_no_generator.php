<?php
include ('../Connection/Connect_sql.php');
	$sql = "SELECT * FROM tc_kanban_masterlist";
	$result = $conn_sql->query($sql);
	if($result->num_rows > 0){
		while($row= $result->fetch_assoc()){
			$date = date("ymd");
			$rand = substr(md5(microtime()),rand(0,26),5);
			$rand1 = substr(md5(microtime()),rand(0,26),5);
			$parts_code = $row['parts_code'];
			$id = $row['id'];
			$length = $row['length'];
			$serial_no = 'SN-'.$rand1.''.$parts_code.''.$rand;
			$sql1 = "UPDATE tc_kanban_masterlist SET serial_no='$serial_no' WHERE id= '$id'";
			if ($conn_sql->query($sql1) === TRUE){
				echo "Record updated successfully";
			} else {
				echo "Error updating record: " . $conn_sql->error;
			}
		}
	}
$conn_sql->close();
?>