<?php
include '../Connection/Connect_sql.php';
$operation = mysqli_real_escape_string($conn_sql, $_GET['operation']);
if($operation == "select_distributor"){
	$sql = "SELECT * FROM tc_distributor_account";
		$result = $conn_sql->query($sql);
		if($result->num_rows > 0){
			while($row = $result->fetch_assoc()){
				echo'
					<tr onclick="get_this_distributor(&quot;'.$row['id'].'&quot;)" style="cursor:pointer;">
						<td style="cursor:pointer;">'.$row['id'].'</td><td style="cursor:pointer;">'.$row['id_no'].'</td><td style="cursor:pointer;">'.$row['scooter_area'].'</td><td style="cursor:pointer;">'.$row['name'].'</td><td style="cursor:pointer;">'.$row['date_updated'].'</td>
					</tr>
				';
			}
		}else{
			
		}
}
else if($operation == "save_distributor"){
	$id_no = mysqli_real_escape_string($conn_sql, $_GET['id_no']);
	$name = mysqli_real_escape_string($conn_sql, $_GET['name']);
	$scooter_area = mysqli_real_escape_string($conn_sql, $_GET['scooter_area']);
	$date_updated = date("Y-m-d H:i:s");
	$sql = "INSERT INTO tc_distributor_account (id_no, scooter_area, name, date_updated)
	VALUES ('$id_no','$scooter_area','$name','$date_updated')";
	if($conn_sql->query($sql) === TRUE){
		echo'Distributor Succesfully Saved';
	}else{
		echo "Error: " . $sql . "<br>" . $conn_sql->error;
	}
}
else if($operation == "update_distributor"){
	$id_no = mysqli_real_escape_string($conn_sql, $_GET['id_no']);
	$name = mysqli_real_escape_string($conn_sql, $_GET['name']);
	$scooter_area = mysqli_real_escape_string($conn_sql, $_GET['scooter_area']);
	$id = mysqli_real_escape_string($conn_sql, $_GET['id']);
	$date_updated = date("Y-m-d H:i:s");
	$sql = "UPDATE tc_distributor_account SET scooter_area='$scooter_area', name='$name' , id_no='$id_no', date_updated='$date_updated' WHERE id='$id'";
	if ($conn_sql->query($sql) === TRUE) {
		echo "Distributor Updated Successfully";
	} else {
		echo "Error updating record: " . $conn_sql->error;
	}
}
else if($operation == "delete_distributor"){
	$id = mysqli_real_escape_string($conn_sql, $_GET['id']);
	$sql = "DELETE FROM tc_distributor_account WHERE id='$id'";
	if ($conn_sql->query($sql) === TRUE) {
		echo "Distributor deleted successfully";
	} else {
		echo "Error deleting record: " . $conn_sql->error;
	}
}
else if($operation == "select_single_distributor"){
	$id = mysqli_real_escape_string($conn_sql, $_GET['id']);
	$sql = "SELECT * FROM tc_distributor_account WHERE id = '$id'";
		$result = $conn_sql->query($sql);
		if($result->num_rows > 0){
			while($row = $result->fetch_assoc()){
				echo $row['id_no'].'~!~'.$row['name'].'~!~'.$row['scooter_area'];
			}
		}else{	
		}
}
else if($operation == "get_stations"){
	$sql = "SELECT * FROM tc_scooter_area";
		$result = $conn_sql->query($sql);
		if($result->num_rows > 0){
			while($row = $result->fetch_assoc()){
				echo '<option>'.$row['scooter_area'].'</option>';
			}
		}else{	
		}
}
$conn_sql->close();
?>
