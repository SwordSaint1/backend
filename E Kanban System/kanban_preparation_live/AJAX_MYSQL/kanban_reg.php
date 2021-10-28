<?php
include '../Connection/Connect_sql.php';
$operation = mysqli_real_escape_string($conn_sql, $_GET['operation']);
if($operation == "add_kanban"){
	$date_updated = date("Y-m-d H:i:s");
	$date_for_serial_no = date("ymdHis");
	$production_lot = mysqli_real_escape_string($conn_sql, $_GET['production_lot']);
	$parts_code = mysqli_real_escape_string($conn_sql, $_GET['parts_code']);
	$line_no = mysqli_real_escape_string($conn_sql, $_GET['line_no']);
	$stock_address = mysqli_real_escape_string($conn_sql, $_GET['stock_address']);
	$parts_name = mysqli_real_escape_string($conn_sql, $_GET['parts_name']);
	$comment = mysqli_real_escape_string($conn_sql, $_GET['comment']);
	$length = mysqli_real_escape_string($conn_sql, $_GET['length']);
	$quantity = mysqli_real_escape_string($conn_sql, $_GET['quantity']);
	$required_knb = mysqli_real_escape_string($conn_sql, $_GET['required_knb']);
	$batch_no = date("ymdh");
	$rand = substr(md5(microtime()),rand(0,26),5);
	$batch_no = 'BAT:'.$batch_no;
	$batch_no = $batch_no.''.$rand;
	$rand = substr(md5(microtime()),rand(0,26),5);
	
	for ($x = 1; $x <= $required_knb; $x++){
			$rand2 = substr(md5(microtime()),rand(0,26),5);
			$rand3 = substr(md5(microtime()),rand(0,26),5);
			$serial_no = 'SN-'.$rand2.''.$parts_code.''.$rand3;
			
			//Check if Parts is Allready 
			$sql = "SELECT kanban_no FROM tc_kanban_masterlist WHERE parts_code LIKE '%$parts_code%' AND line_no LIKE '%$line_no%' AND stock_address LIKE '%$stock_address%' AND parts_name LIKE '%$parts_name%' AND comment LIKE '%$comment%' AND length LIKE '%$length%' AND quantity LIKE '%$quantity%' ORDER BY id ASC";
			$result = $conn_sql->query($sql);
			if($result->num_rows > 0){
				while($row = $result->fetch_assoc()){
					$kanban_no = $row['kanban_no'];
				}
			}else{
				$kanban_no = 0;
			}
			$kanban_no_generated = $kanban_no + 1;
			$kanban =  'TC-'.$parts_name.'_'.$length.'_'.$line_no.'_'.$quantity.'_'.$parts_code.'_'.$stock_address.'_'.$kanban_no_generated.'_'.$date_for_serial_no;
			
			//$kanban =  $parts_name.'_'.$length.'_'.$line_no.'_'.$quantity.'_'.$parts_code.'_'.$date_for_serial_no;
			//$serial_no = $parts_code.''.$date_for_serial_no;
			$sql1 = "INSERT INTO tc_kanban_masterlist (batch_id,production_lot,parts_code,line_no,stock_address,parts_name,comment,length,quantity,kanban_no,kanban,serial_no,date_updated)
			VALUES ('$batch_no','$production_lot','$parts_code','$line_no','$stock_address','$parts_name','$comment','$length','$quantity','$kanban_no_generated','$kanban','$serial_no','$date_updated')";
			if($conn_sql->query($sql1) === TRUE){
			} else {
				echo "Error: " . $sql1 . "<br>" . $conn_sql->error;
			}
	}
	echo 'uploaded~!~'.$batch_no;
	
}else if($operation == "update_kanban"){
	$production_lot = mysqli_real_escape_string($conn_sql, $_GET['production_lot']);
	$parts_code = mysqli_real_escape_string($conn_sql, $_GET['parts_code']);
	$line_no = mysqli_real_escape_string($conn_sql, $_GET['line_no']);
	$stock_address = mysqli_real_escape_string($conn_sql, $_GET['stock_address']);
	$parts_name = mysqli_real_escape_string($conn_sql, $_GET['parts_name']);
	$comment = mysqli_real_escape_string($conn_sql, $_GET['comment']);
	$length = mysqli_real_escape_string($conn_sql, $_GET['length']);
	$quantity = mysqli_real_escape_string($conn_sql, $_GET['quantity']);
	$id_hidden = mysqli_real_escape_string($conn_sql, $_GET['id_hidden']);
	$sql = "UPDATE tc_kanban_masterlist SET production_lot='$production_lot' , parts_code='$parts_code' , line_no='$line_no' , stock_address='$stock_address' , parts_name='$parts_name' , comment='$comment' , length='$length' , quantity='$quantity' WHERE id='$id_hidden'";
	if ($conn_sql->query($sql) === TRUE){
		echo "Kanban Updated Successfully";
	} else {
		echo "Error updating record: " . $conn_sql->error;
	}
}
$conn_sql->close();
?>
