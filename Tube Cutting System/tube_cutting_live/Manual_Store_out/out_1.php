<?php
include '../Connection/Connect_sql.php';
$file = file_get_contents('MANUAL  STOREOUT 030520_22.txt');
$file = preg_replace('/[\n]+/', "||~~||", $file); 
$file_ex = explode("||~~||", $file);
$count = count($file_ex);
for ($i=0; $i <$count ; $i++) {
	$kanban = $file_ex[$i];
	$kanban = trim($kanban);
	echo "<input type='text' value='$kanban'>";
	$sql = "SELECT * FROM tc_scanned_kanban WHERE kanban='$kanban' AND status = 'Ongoing Picking' LIMIT 1";	
	$result = $conn_sql->query($sql);
	if($result->num_rows > 0){
		while($row = $result->fetch_assoc()){
			$id = $row['id'];
			$request_id = $row['request_id'];
			$production_lot = $row['production_lot'];
			$parts_code = $row['parts_code'];
			$line_no = $row['line_no'];
			$stock_address = $row['stock_address'];
			$parts_name = $row['parts_name'];
			$comment = $row['comment'];
			$length = $row['length'];
			$quantity = $row['quantity'];
			$kanban_no = $row['kanban_no'];
			$kanban = $row['kanban'];
			$serial_no = $row['serial_no'];
			$scooter_station = $row['scooter_station'];
			$distributor = $row['distributor'];
			$scan_date_time = $row['scan_date_time'];
			$request_date_time = $row['request_date_time'];
			$print_date_time = $row['print_date_time'];
			$requested_by = $row['requested_by'];
			$store_out_person = 'out';
			$store_out_date_time = date("Y-m-d H:i:s");
			$sql1 = "INSERT INTO tc_history (id, request_id, production_lot, parts_code, line_no, stock_address, parts_name, comment, length, quantity, kanban_no, kanban, serial_no, scooter_station, distributor, scan_date_time, request_date_time, print_date_time, store_out_date_time, requested_by, store_out_person, status)
			VALUES ('','$request_id','$production_lot','$parts_code','$line_no','$stock_address','$parts_name','$comment','$length','$quantity','$kanban_no','$kanban','$serial_no','$scooter_station','$distributor','$scan_date_time','$request_date_time','$print_date_time','$store_out_date_time','$distributor','$store_out_person','Ready for Delivery')";
			if($conn_sql->query($sql1) === TRUE){
				$sql2 = "DELETE FROM tc_scanned_kanban WHERE request_id='$request_id' AND kanban='$kanban' AND scan_date_time='$scan_date_time'";
				if ($conn_sql->query($sql2) === TRUE){
					echo "Succesfully Store Out";
				} else {
					echo "Error Store Out: " . $conn_sql->error;
				}
			} else {
				echo "Error: " . $sql1 . "<br>" . $conn_sql->error;
			}
		}
	}else{
		echo'Wala';
	}
 }
?>