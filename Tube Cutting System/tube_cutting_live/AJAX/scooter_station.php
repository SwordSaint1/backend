<?php
include '../Connection/Connect_sql.php';
$operation = mysqli_real_escape_string($conn_sql, $_GET['operation']);
if($operation == "select_stations"){
	$sql = "SELECT * FROM tc_scooter_area";
		$result = $conn_sql->query($sql);
		if($result->num_rows > 0){
			while($row = $result->fetch_assoc()){
				echo'
					<tr onclick="get_this_station(&quot;'.$row['id'].'&quot;)" style="cursor:pointer;">
						<td style="cursor:pointer;">'.$row['id'].'</td><td style="cursor:pointer;">'.$row['scooter_area'].'</td><td style="cursor:pointer;">'.$row['ip'].'</td><td style="cursor:pointer;">'.$row['date_updated'].'</td>
					</tr>
				';
			}
		}else{
			
		}
}
else if($operation == "save_station"){
	$scooter_area = mysqli_real_escape_string($conn_sql, $_GET['scooter_area']);
	$date_updated = date("Y-m-d H:i:s");
	$ip = mysqli_real_escape_string($conn_sql, $_GET['ip']);
	$sql = "INSERT INTO tc_scooter_area (scooter_area, ip, date_updated)
	VALUES ('$scooter_area','$ip','$date_updated')";
	if($conn_sql->query($sql) === TRUE){
		echo'New Station Succesfully Saved';
	}else{
		echo "Error: " . $sql . "<br>" . $conn_sql->error;
	}
}
else if($operation == "update_station"){
	$scooter_area = mysqli_real_escape_string($conn_sql, $_GET['scooter_area']);
	$ip = mysqli_real_escape_string($conn_sql, $_GET['ip']);
	$id = mysqli_real_escape_string($conn_sql, $_GET['id']);
	$date_updated = date("Y-m-d H:i:s");
	$ip = mysqli_real_escape_string($conn_sql, $_GET['ip']);
	$sql = "UPDATE tc_scooter_area SET scooter_area='$scooter_area', ip='$ip' , date_updated='$date_updated' WHERE id='$id'";
	if ($conn_sql->query($sql) === TRUE) {
		echo "Station Updated Successfully";
	} else {
		echo "Error updating record: " . $conn_sql->error;
	}
}
else if($operation == "delete_station"){
	$id = mysqli_real_escape_string($conn_sql, $_GET['id']);
	$sql = "DELETE FROM tc_scooter_area WHERE id='$id'";
	if ($conn_sql->query($sql) === TRUE) {
		echo "Station deleted successfully";
	} else {
		echo "Error deleting record: " . $conn_sql->error;
	}
}
else if($operation == "select_single_station"){
	$id = mysqli_real_escape_string($conn_sql, $_GET['scooter_id']);
	$sql = "SELECT * FROM tc_scooter_area WHERE id = '$id'";
		$result = $conn_sql->query($sql);
		if($result->num_rows > 0){
			while($row = $result->fetch_assoc()){
				echo $row['scooter_area'].'~!~'.$row['ip'];
			}
		}else{	
		}
}
$conn_sql->close();
?>
