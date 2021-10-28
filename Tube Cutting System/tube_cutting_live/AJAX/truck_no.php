<?php
set_time_limit(0);
include '../Connection/Connect_sql.php';
$operation = mysqli_real_escape_string($conn_sql, $_GET['operation']);
if($operation == "select_truck_no"){
	$sql = "SELECT * FROM truck_no";
		$result = $conn_sql->query($sql);
		if($result->num_rows > 0){
			while($row = $result->fetch_assoc()){
				echo'
					<tr onclick="get_this_truck_no(&quot;'.$row['id'].'&quot;)" style="cursor:pointer;">
						<td style="cursor:pointer;">'.$row['id'].'</td><td style="cursor:pointer;">'.$row['truck_no'].'</td><td style="cursor:pointer;">'.$row['time_from'].'</td><td style="cursor:pointer;">'.$row['time_to'].'</td>
					</tr>
				';
			}
		}else{
			
		}
}
else if($operation == "save_truck_no"){
	$truck_no = mysqli_real_escape_string($conn_sql, $_GET['truck_no']);
	$time_from = mysqli_real_escape_string($conn_sql, $_GET['time_from']);
	$time_to = mysqli_real_escape_string($conn_sql, $_GET['time_to']);
	$date_updated = date("Y-m-d H:i:s");
	$sql = "INSERT INTO truck_no (truck_no, time_from, time_to, date_updated)
	VALUES ('$truck_no','$time_from','$time_to','$date_updated')";
	if($conn_sql->query($sql) === TRUE){
		echo'New Truck Succesfully Saved';
	}else{
		echo "Error: " . $sql . "<br>" . $conn_sql->error;
	}
}
else if($operation == "update_truck_no"){
	$truck_no = mysqli_real_escape_string($conn_sql, $_GET['truck_no']);
	$time_from = mysqli_real_escape_string($conn_sql, $_GET['time_from']);
	$time_to = mysqli_real_escape_string($conn_sql, $_GET['time_to']);
	$id_hidden = mysqli_real_escape_string($conn_sql, $_GET['id_hidden']);
	$date_updated = date("Y-m-d H:i:s");
	$sql = "UPDATE truck_no SET truck_no='$truck_no', time_from='$time_from' , time_to='$time_to', date_updated='$date_updated' WHERE id='$id_hidden'";
	if ($conn_sql->query($sql) === TRUE) {
		echo "Truck No Updated Successfully";
	} else {
		echo "Error updating record: " . $conn_sql->error;
	}
}
else if($operation == "delete_truck_no"){
	$id = mysqli_real_escape_string($conn_sql, $_GET['id_hidden']);
	$sql = "DELETE FROM truck_no WHERE id='$id'";
	if ($conn_sql->query($sql) === TRUE) {
		echo "Truck No deleted successfully";
	} else {
		echo "Error deleting record: " . $conn_sql->error;
	}
}
else if($operation == "select_single_truck_no"){
	$id = mysqli_real_escape_string($conn_sql, $_GET['truck_id']);
	$sql = "SELECT * FROM truck_no WHERE id = '$id'";
		$result = $conn_sql->query($sql);
		if($result->num_rows > 0){
			while($row = $result->fetch_assoc()){
				echo $row['truck_no'].'~!~'.$row['time_from'].'~!~'.$row['time_to'];
			}
		}else{	
		}
}
?>
