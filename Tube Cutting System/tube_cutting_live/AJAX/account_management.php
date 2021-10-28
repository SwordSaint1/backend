<?php
include '../Connection/Connect_sql.php';
$operation = mysqli_real_escape_string($conn_sql, $_GET['operation']);
if($operation == "select_account"){
	$sql = "SELECT * FROM tc_account";
		$result = $conn_sql->query($sql);
		if($result->num_rows > 0){
			while($row = $result->fetch_assoc()){
				echo'
					<tr onclick="get_this_account(&quot;'.$row['id'].'&quot;)" style="cursor:pointer;">
						<td style="cursor:pointer;">'.$row['id'].'</td><td style="cursor:pointer;">'.$row['username'].'</td><td style="cursor:pointer;">'.$row['name'].'</td><td style="cursor:pointer;">'.$row['role'].'</td><td style="cursor:pointer;">'.$row['date_updated'].'</td>
					</tr>
				';
			}
		}else{
		}
}
else if($operation == "save_account"){
	$name = mysqli_real_escape_string($conn_sql, $_GET['name']);
	$username = mysqli_real_escape_string($conn_sql, $_GET['username']);
	$password = mysqli_real_escape_string($conn_sql, $_GET['password']);
	$role = mysqli_real_escape_string($conn_sql, $_GET['role']);
	$date_updated = date("Y-m-d H:i:s");
	$sql = "INSERT INTO tc_account (username, password, name, role, date_updated)
	VALUES ('$username','$password','$name','$role','$date_updated')";
	if($conn_sql->query($sql) === TRUE){
		echo'New User Succesfully Saved';
	}else{
		echo "Error: " . $sql . "<br>" . $conn_sql->error;
	}
}
else if($operation == "update_account"){
	$name = mysqli_real_escape_string($conn_sql, $_GET['name']);
	$username = mysqli_real_escape_string($conn_sql, $_GET['username']);
	$role = mysqli_real_escape_string($conn_sql, $_GET['role']);
	$password = mysqli_real_escape_string($conn_sql, $_GET['password']);
	$id = mysqli_real_escape_string($conn_sql, $_GET['id']);
	$date_updated = date("Y-m-d h:i:sa");
	$sql = "UPDATE tc_account SET name='$name', username='$username', password='$password', role='$role', date_updated='$date_updated' WHERE id='$id'";
	if ($conn_sql->query($sql) === TRUE) {
		echo "User Updated Successfully";
	} else {
		echo "Error updating record: " . $conn_sql->error;
	}
}
else if($operation == "delete_account"){
	$id = mysqli_real_escape_string($conn_sql, $_GET['id']);
	$sql = "DELETE FROM tc_account WHERE id='$id'";
	if ($conn_sql->query($sql) === TRUE) {
		echo "User deleted successfully";
	} else {
		echo "Error deleting record: " . $conn_sql->error;
	}
}
else if($operation == "select_single_account"){
	$id = mysqli_real_escape_string($conn_sql, $_GET['id']);
	$sql = "SELECT * FROM tc_account WHERE id = '$id'";
		$result = $conn_sql->query($sql);
		if($result->num_rows > 0){
			while($row = $result->fetch_assoc()){
				echo $row['username'].'~!~'.$row['password'].'~!~'.$row['name'].'~!~'.$row['role'];
			}
		}else{	
		}
}
$conn_sql->close();
?>
