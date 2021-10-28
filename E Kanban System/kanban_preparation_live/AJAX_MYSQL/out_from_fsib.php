<?php
set_time_limit(0);
include '../Connection/Connect_sql.php';
include '../Connection/Connect_oracle.php';
$operation = mysqli_real_escape_string($conn_sql, $_GET['operation']);
if($operation == "check_out_fsib"){
	$sql = "SELECT * FROM scanned_kanban WHERE status='Pending' AND real_time_status='Ongoing Picking'";
		$result = $conn_sql->query($sql);
		if($result->num_rows > 0){
			while($row = $result->fetch_assoc()){
				$id_scanned_kanban = $row['id_scanned_kanban'];
				$kanban = $row['kanban'];
				$kanban_num = $row['kanban_num'];
				$supplier_name = $row['supplier_name'];
				$parts_name = $row['parts_name'];
				$supplier_name = $row['supplier_name'];
				$parts_code = $row['parts_code'];
				$line_no = $row['line_no'];
				$location = $row['location'];
				$delivery = $row['delivery'];
				$quantity = $row['quantity'];
				$stock_address = $row['stock_address'];
				$scooter_station = $row['scooter_station'];
				$distributor = $row['distributor'];
				$scan_date_time = $row['scan_date_time'];
				$request_date_time = $row['request_date_time'];
				$print_date_time = $row['print_date_time'];
				$store_out_date_time = date('Y-m-d H:i:s');
				$status = $row['status'];
				$real_time_status = $row['real_time_status'];
				//$query = oci_parse($conn_oracle, "SELECT * FROM FSIB.T_ZAISYKRSK WHERE C_BHNSZINAM LIKE '%$parts_name%' AND L_KNBNUM LIKE '%$kanban_num%' AND C_LINENUM LIKE '%$line_no%' AND DT_DATTRKYMD >= to_date('$scan_date_time', 'YYYY-MM-DD HH24:MI:SS')");
				$query = oci_parse($conn_oracle, "SELECT * FROM FSIB.T_ZAISYKRSK WHERE C_BHNSZICOD LIKE '%$parts_code%' AND C_BHNSZINAM LIKE '%$parts_name%' AND C_LINENUM LIKE '%$line_no%' AND DT_DATTRKYMD >= to_date('$scan_date_time', 'YYYY-MM-DD HH24:MI:SS')");
				oci_execute($query);
				while($row_ora=oci_fetch_assoc($query)){
					$store_out_person = $row_ora['C_TRKUSER'];
					$sql1 = "INSERT INTO history (id_scanned_kanban, kanban, kanban_num, supplier_name, parts_name, parts_code, line_no, location, delivery, quantity, stock_address, scooter_station, distributor, scan_date_time, request_date_time, print_date_time, store_out_date_time, store_out_person, status, real_time_status)
					VALUES ('$id_scanned_kanban','$kanban','$kanban_num','$supplier_name','$parts_name','$parts_code','$line_no','$location','$delivery','$quantity','$stock_address','$scooter_station','$distributor','$scan_date_time','$request_date_time','$print_date_time','$store_out_date_time','$store_out_person','Ready for Delivery','Ready for Delivery')";
					if($conn_sql->query($sql1) === TRUE){
						$sql2 = "DELETE FROM scanned_kanban WHERE id_scanned_kanban='$id_scanned_kanban' AND kanban='$kanban'";
						if ($conn_sql->query($sql2) === TRUE){
							echo "Record deleted successfully";
						} else {
							echo "Error deleting record: " . $conn_sql->error;
						}
					} else {
						echo "Error: " . $sql1 . "<br>" . $conn_sql->error;
					}
				}
			}
		}
		echo "Already Checked";
}
$conn_sql->close();
?>
