<?php
set_time_limit(0);
include '../Connection/Connect_sql.php';
$operation = mysqli_real_escape_string($conn_sql, $_GET['operation']);
if($operation == "select_route_no"){
	$sql = "SELECT * FROM route_no";
		$result = $conn_sql->query($sql);
		if($result->num_rows > 0){
			while($row = $result->fetch_assoc()){
				echo'
					<tr onclick="get_this_route_no(&quot;'.$row['id'].'&quot;)" style="cursor:pointer;">
						<td style="cursor:pointer;">'.$row['id'].'</td><td style="cursor:pointer;">'.$row['route_no'].'</td><td style="cursor:pointer;">'.$row['car_maker'].'</td><td style="cursor:pointer;">'.$row['scooter_station'].'</td>
					</tr>
				';
			}
		}else{
			
		}
}
else if($operation == "save_route_no"){
	$route_no = mysqli_real_escape_string($conn_sql, $_GET['route_no']);
	$car_maker = mysqli_real_escape_string($conn_sql, $_GET['car_maker']);
	$scooter_station = mysqli_real_escape_string($conn_sql, $_GET['scooter_station']);
	$date_updated = date("Y-m-d H:i:s");
	$sql = "INSERT INTO route_no (route_no, car_maker, scooter_station, date_updated)
	VALUES ('$route_no','$car_maker','$scooter_station','$date_updated')";
	if($conn_sql->query($sql) === TRUE){
		echo'Route Succesfully Saved';
	}else{
		echo "Error: " . $sql . "<br>" . $conn_sql->error;
	}
}
else if($operation == "update_route_no"){
	$route_no = mysqli_real_escape_string($conn_sql, $_GET['route_no']);
	$car_maker = mysqli_real_escape_string($conn_sql, $_GET['car_maker']);
	$scooter_station = mysqli_real_escape_string($conn_sql, $_GET['scooter_station']);
	$id_hidden = mysqli_real_escape_string($conn_sql, $_GET['id_hidden']);
	$date_updated = date("Y-m-d H:i:s");
	$sql = "UPDATE route_no SET route_no='$route_no', car_maker='$car_maker' , scooter_station='$scooter_station', date_updated='$date_updated' WHERE id='$id_hidden'";
	if ($conn_sql->query($sql) === TRUE) {
		echo "Route Updated Successfully";
	} else {
		echo "Error updating record: " . $conn_sql->error;
	}
}
else if($operation == "delete_route_no"){
	$id = mysqli_real_escape_string($conn_sql, $_GET['id_hidden']);
	$sql = "DELETE FROM route_no WHERE id='$id'";
	if ($conn_sql->query($sql) === TRUE) {
		echo "Route deleted successfully";
	} else {
		echo "Error deleting record: " . $conn_sql->error;
	}
}
else if($operation == "select_single_route_no"){
	$id = mysqli_real_escape_string($conn_sql, $_GET['id']);
	$sql = "SELECT * FROM route_no WHERE id = '$id'";
		$result = $conn_sql->query($sql);
		if($result->num_rows > 0){
			while($row = $result->fetch_assoc()){
				echo $row['route_no'].'~!~'.$row['car_maker'].'~!~'.$row['scooter_station'];
			}
		}else{	
		}
}
else if($operation == "select_scooter_station"){
	echo '<option>Scooter Station</option>';
	$sql = "SELECT scooter_area FROM tc_scooter_area GROUP BY scooter_area ORDER BY scooter_area ASC";
	$result = $conn_sql->query($sql);
	if($result->num_rows > 0){
		while($row = $result->fetch_assoc()){
			echo '<option>'.$row['scooter_area'].'</option>';
		}
	}else{	
	}
}
else if($operation == "select_line_no"){
	$scooter_area = mysqli_real_escape_string($conn_sql, $_GET['scooter_station']);
	echo '<option>Lines</option>';
	$sql = "SELECT line_no FROM history where scooter_station='$scooter_area' GROUP BY line_no ORDER BY line_no ASC";
	$result = $conn_sql->query($sql);
	if($result->num_rows > 0){
		while($row = $result->fetch_assoc()){
			echo '<option>'.$row['line_no'].'</option>';
		}
	}else{
		echo '<option>No Data Found</option>';
	}
}
?>
