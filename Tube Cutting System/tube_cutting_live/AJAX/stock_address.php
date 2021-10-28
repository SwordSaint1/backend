<?php
include '../Connection/Connect_sql.php';
$operation = mysqli_real_escape_string($conn_sql, $_GET['operation']);
if($operation == "select_stock_address"){
	$sql = "SELECT * FROM stock_address";
		$result = $conn_sql->query($sql);
		if($result->num_rows > 0){
			while($row = $result->fetch_assoc()){
				echo'
					<tr onclick="get_this_stock_address(&quot;'.$row['id'].'&quot;)" style="cursor:pointer;">
						<td style="cursor:pointer;">'.$row['id'].'</td><td style="cursor:pointer;">'.$row['stock_address'].'</td><td style="cursor:pointer;">'.$row['parts_code'].'</td><td style="cursor:pointer;">'.$row['parts_name'].'</td>
					</tr>
				';
			}
		}else{
			
		}
}
else if($operation == "save_stock_address"){
	$stock_address = mysqli_real_escape_string($conn_sql, $_GET['stock_address']);
	$parts_code = mysqli_real_escape_string($conn_sql, $_GET['parts_code']);
	$parts_name = mysqli_real_escape_string($conn_sql, $_GET['parts_name']);
	$date_updated = date("Y-m-d H:i:s");
	$sql = "INSERT INTO stock_address (id, stock_address, parts_code, parts_name,date_updated)
	VALUES ('','$stock_address','$parts_code','$parts_name','$date_updated')";
	if($conn_sql->query($sql) === TRUE){
		echo'New Stock Address Succesfully Saved';
	}else{
		echo "Error: " . $sql . "<br>" . $conn_sql->error;
	}
}
else if($operation == "update_stock_address"){
	$stock_address = mysqli_real_escape_string($conn_sql, $_GET['stock_address']);
	$parts_code = mysqli_real_escape_string($conn_sql, $_GET['parts_code']);
	$parts_name = mysqli_real_escape_string($conn_sql, $_GET['parts_name']);
	$id = mysqli_real_escape_string($conn_sql, $_GET['id_hidden']);
	$date_updated = date("Y-m-d H:i:s");
	$sql = "UPDATE stock_address SET stock_address='$stock_address', parts_code='$parts_code' , parts_name='$parts_name' , date_updated='$date_updated' WHERE id='$id'";
	if ($conn_sql->query($sql) === TRUE){
		echo "Stock Address Updated Successfully";
	} else {
		echo "Error Updating Stock Address: " . $conn_sql->error;
	}
}
else if($operation == "delete_stock_address"){
	$id = mysqli_real_escape_string($conn_sql, $_GET['id']);
	$stock_address = mysqli_real_escape_string($conn_sql, $_GET['stock_address']);
	$parts_code = mysqli_real_escape_string($conn_sql, $_GET['parts_code']);
	$parts_name = mysqli_real_escape_string($conn_sql, $_GET['parts_name']);
	$id = mysqli_real_escape_string($conn_sql, $_GET['id']);
	$sql = "DELETE FROM stock_address WHERE id='$id' AND stock_address='$stock_address' AND parts_code='$parts_code' AND parts_name='$parts_name'";
	if ($conn_sql->query($sql) === TRUE) {
		echo "Stock Address Deleted Successfully";
	} else {
		echo "Error deleting Stock Address: " . $conn_sql->error;
	}
}
else if($operation == "select_single_stock_address"){
	$id = mysqli_real_escape_string($conn_sql, $_GET['stock_id']);
	$sql = "SELECT * FROM stock_address WHERE id = '$id'";
		$result = $conn_sql->query($sql);
		if($result->num_rows > 0){
			while($row = $result->fetch_assoc()){
				echo $row['stock_address'].'~!~'.$row['parts_code'].'~!~'.$row['parts_name'];
			}
		}else{	
		}
}
else if($operation == "search_stock_address"){
	$keyword = mysqli_real_escape_string($conn_sql, $_GET['keyword']);
	if($keyword != ""){
		$sql = "SELECT * FROM stock_address WHERE parts_code LIKE '%$keyword%' OR parts_name LIKE '%$keyword%' OR stock_address LIKE '%$keyword%'";
		$result = $conn_sql->query($sql);
		if($result->num_rows > 0){
			while($row = $result->fetch_assoc()){
				echo'
					<tr onclick="get_this_stock_address(&quot;'.$row['id'].'&quot;)" style="cursor:pointer;">
						<td style="cursor:pointer;">'.$row['id'].'</td><td style="cursor:pointer;">'.$row['stock_address'].'</td><td style="cursor:pointer;">'.$row['parts_code'].'</td><td style="cursor:pointer;">'.$row['parts_name'].'</td>
					</tr>
				';
			}
		}else{	
		}
	}else{
		$sql = "SELECT * FROM stock_address";
		$result = $conn_sql->query($sql);
		if($result->num_rows > 0){
			while($row = $result->fetch_assoc()){
				echo'
					<tr onclick="get_this_stock_address(&quot;'.$row['id'].'&quot;)" style="cursor:pointer;">
						<td style="cursor:pointer;">'.$row['id'].'</td><td style="cursor:pointer;">'.$row['stock_address'].'</td><td style="cursor:pointer;">'.$row['parts_code'].'</td><td style="cursor:pointer;">'.$row['parts_name'].'</td>
					</tr>
				';
			}
		}else{
			
		}
	}	
}
$conn_sql->close();
?>
