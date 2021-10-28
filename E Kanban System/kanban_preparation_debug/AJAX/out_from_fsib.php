<?php
set_time_limit(0);
require_once '../Connection/ConnectSqlsrv.php';
require_once '../Connection/ConnectOracle.php';

$operation = $_GET['operation'];
echo'';
if($operation == "check_out_fsib"){
	$count_out = 0;
	// Getting All Ongoing Picking
	$sql = "SELECT * FROM mm_ongoing_picking WHERE status='Ongoing Picking'";
    $stmt = sqlsrv_query($conn_sqlsrv, $sql);
    $row = sqlsrv_has_rows($stmt);
    if ($row === true){
        while($rows = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){
			$id_scanned_kanban = $rows['id_scanned_kanban'];
			$kanban = $rows['kanban'];
			$location = $rows['location'];
			$delivery = $rows['delivery'];
			$line_no = $rows['line_no'];
			$stock_address = $rows['stock_address'];
			$supplier_name = $rows['supplier_name'];
			$parts_code = $rows['parts_code'];
			$parts_name = $rows['parts_name'];
			$quantity = $rows['quantity'];
			$kanban_num = $rows['kanban_num'];
			$scooter_station = $rows['scooter_station'];
			$scan_date_time = date_format($rows['scan_date_time'],"Y-m-d H:i:s");
			$request_date_time = date_format($rows['scan_date_time'],"Y-m-d H:i:s");
			$requested_by = $rows['requested_by'];
			$print_date_time = date_format($rows['scan_date_time'],"Y-m-d H:i:s");
			$parts_code_for_out = trim($parts_code);
			$line_no_for_out = trim($line_no);
			$kanban_num_for_out = trim($kanban_num);
			// Check All Ongoing picking if the Kanban was Store in FSIB Database
 			$query = oci_parse($conn_oracle, "SELECT C_TRKUSER,C_BHNSZICOD,C_LINENUM,L_KNBNUM,TO_CHAR(DT_DATTRKYMD, 'YYYY-MM-DD HH24:MI:SS') AS DT_DATTRKYMD FROM FSIB.T_ZAISYKRSK WHERE C_BHNSZICOD = '$parts_code_for_out' AND C_LINENUM = '$line_no_for_out' AND L_KNBNUM = '$kanban_num_for_out' AND DT_DATTRKYMD >= to_date('$scan_date_time', 'YYYY-MM-DD HH24:MI:SS') AND ROWNUM <= 1");
			oci_execute($query);
			while($row_ora=oci_fetch_assoc($query)){
				$store_out_person = $row_ora['C_TRKUSER'];
				$store_out_date_time = $row_ora['DT_DATTRKYMD'];
				// Inserting Ongoing Picking to History
				$sql1 = "INSERT INTO mm_history (id_scanned_kanban, kanban, location, delivery, line_no, stock_address, supplier_name, parts_code, parts_name, quantity, kanban_num, scooter_station, scan_date_time, request_date_time, requested_by, print_date_time, store_out_date_time, store_out_person, status) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
				$params1 = array($id_scanned_kanban, $kanban, $location, $delivery, $line_no, $stock_address, $supplier_name, $parts_code, $parts_name, $quantity, $kanban_num, $scooter_station, $scan_date_time, $request_date_time, $requested_by, $print_date_time, $store_out_date_time, $store_out_person, 'Ready for Delivery');
				$stmt1 = sqlsrv_query($conn_sqlsrv, $sql1, $params1);
				if($stmt1 === false){
					die( print_r( sqlsrv_errors(), true));
				}else{
					// Cheek All Remarks
					$sql2 = "SELECT * FROM mm_remarks WHERE id_scanned_kanban= '$id_scanned_kanban' AND kanban='$kanban'";
					$stmt2 = sqlsrv_query($conn_sqlsrv, $sql2);
					$row2 = sqlsrv_has_rows($stmt2);
					if ($row2 === true){
						while($rows2 = sqlsrv_fetch_array($stmt2, SQLSRV_FETCH_ASSOC)){
							$id = $rows2['id'];
							$mm_remarks = $rows2['mm_remarks'];
							$sender = $rows2['sender'];
							$sender_identification = $rows2['sender_identification'];
							$remarks_date_time = date_format($rows2['remarks_date_time'],"Y-m-d H:i:s");
							$remarks_status = $rows2['remarks_status'];
							$seen_date_time = $rows2['seen_date_time'];
							if($seen_date_time != NULL){
								$seen_date_time = date_format($rows2['seen_date_time'],"Y-m-d H:i:s");
							}
							// For Inserting in Remarks History
							$sql3 = "INSERT INTO mm_remarks_history (id_scanned_kanban, kanban, kanban_num, scooter_station, scan_date_time, request_date_time, mm_remarks, sender, sender_identification, remarks_date_time, remarks_status, seen_date_time) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
							$params3 = array($id_scanned_kanban, $kanban, $kanban_num, $scooter_station, $scan_date_time, $request_date_time, $mm_remarks, $sender, $sender_identification, $remarks_date_time, $remarks_status, $seen_date_time);
							$stmt3 = sqlsrv_query($conn_sqlsrv, $sql3, $params3);
							if($stmt3 === false){
								die( print_r( sqlsrv_errors(), true));
							}else{
								// For Deleting Remarks in mm_remarks Table
								$sql4 = "DELETE FROM mm_remarks WHERE id = ?";
								$params4 = array($id);
								$stmt4 = sqlsrv_query($conn_sqlsrv, $sql4, $params4);
								if($stmt4 === false ) {
									die( print_r( sqlsrv_errors(), true));
								}else{
									
								}
							}
						}
					}
					// Cheek All Reprint History
					$sql5 = "SELECT id, reprint_date_time, status FROM mm_reprint_kanban WHERE id_scanned_kanban= '$id_scanned_kanban' AND kanban='$kanban' AND scooter_station='$scooter_station' AND request_date_time='$request_date_time'";
					$stmt5 = sqlsrv_query($conn_sqlsrv, $sql5);
					$row5 = sqlsrv_has_rows($stmt5);
					if ($row5 === true){
						while($rows5 = sqlsrv_fetch_array($stmt5, SQLSRV_FETCH_ASSOC)){
							$id = $rows5['id'];
							$reprint_date_time = date_format($rows5['reprint_date_time'],"Y-m-d H:i:s");
							$status =$rows5['status'];
							// For Inserting in Reprint History
							$sql6 = "INSERT INTO mm_reprint_kanban_history (id_scanned_kanban, kanban, scooter_station, scan_date_time, request_date_time, reprint_date_time, status) VALUES (?,?,?,?,?,?,?)";
							$params6 = array($id_scanned_kanban, $kanban, $scooter_station, $scan_date_time, $request_date_time, $reprint_date_time, $status);
							$stmt6 = sqlsrv_query($conn_sqlsrv, $sql6, $params6);
							if($stmt6 === false){
								die( print_r( sqlsrv_errors(), true));
							}else{
								// For Deleting Reprint Data
								$sql7 = "DELETE FROM mm_reprint_kanban WHERE id = ?";
								$params7 = array($id);
								$stmt7 = sqlsrv_query($conn_sqlsrv, $sql7, $params7);
								if($stmt7 === false ) {
									die( print_r( sqlsrv_errors(), true));
								}else{
									
								}
							}
						}
					}
					// For Deleting Data in Ongoing Picking
					$sql8 = "DELETE FROM mm_ongoing_picking WHERE id_scanned_kanban = ? AND kanban = ?";
					$params8 = array($id_scanned_kanban,$kanban);
					$stmt8 = sqlsrv_query($conn_sqlsrv, $sql8, $params8);
					if($stmt8 === false ) {
						die( print_r( sqlsrv_errors(), true));
					}else{
						$count_out = $count_out + 1;
					}
				}
			}
		}
	}
	echo $count_out;
	sqlsrv_close($conn_sqlsrv);
}

















// <!-- 


// $sql = "SELECT * FROM ongoing_picking WHERE status='Pending' AND real_time_status='Ongoing Picking'";
// 		$result = $conn_sql->query($sql);
// 		if($result->num_rows > 0){
// 			while($row = $result->fetch_assoc()){
// 				$id_scanned_kanban = $row['id_scanned_kanban'];
// 				$kanban = $row['kanban'];
// 				$kanban_num = $row['kanban_num'];
// 				$supplier_name = $row['supplier_name'];
// 				$parts_name = $row['parts_name'];
// 				$split = explode(" ",$parts_name);
// 				//$parts_name_ex = $split[0];
// 				//$wire_size_ex = $split[1];
// 				//$ground_color_ex = $split[2];
// 				//$stripe_color_ex = $split[3];
// 				$supplier_name = $row['supplier_name'];
// 				$parts_code = $row['parts_code'];
// 				$line_no = $row['line_no'];
// 				$location = $row['location'];
// 				$delivery = $row['delivery'];
// 				$quantity = $row['quantity'];
// 				$stock_address = $row['stock_address'];
// 				$scooter_station = $row['scooter_station'];
// 				$distributor = $row['distributor'];
// 				$scan_date_time = $row['scan_date_time'];
// 				$request_date_time = $row['request_date_time'];
// 				$print_date_time = $row['print_date_time'];
// 				//$store_out_date_time = date('Y-m-d H:i:s');
// 				$parts_code_for_out = substr($kanban, 13,20);
// 				$parts_code_for_out = trim($parts_code_for_out);
// 				$kanban_num_for_out = substr($kanban, 33,4);
// 				$kanban_num_for_out = ltrim($kanban_num_for_out, '0');
// 				if($kanban_num_for_out == ""){
// 					$kanban_num_for_out = '0';
// 				}else{
// 					$kanban_num_for_out=$kanban_num_for_out;
// 				}
// 				$line_no_for_out = substr($kanban, 37,47);
// 				$line_no_for_out = trim($line_no_for_out);
// 				$line_no_for_out = strtoupper($line_no_for_out);
// 				//$line_no_no_space =trim($line_no_from_kanban);
// 				//$query = oci_parse($conn_oracle, "SELECT * FROM FSIB.T_ZAISYKRSK WHERE C_BHNSZINAM LIKE '%$parts_name%' AND L_KNBNUM LIKE '%$kanban_num%' AND C_LINENUM LIKE '%$line_no%' AND DT_DATTRKYMD >= to_date('$scan_date_time', 'YYYY-MM-DD HH24:MI:SS')");
// 				//$query = oci_parse($conn_oracle, "SELECT C_TRKUSER,C_BHNSZICOD,C_LINENUM,L_KNBNUM,TO_CHAR(DT_DATTRKYMD, 'YYYY-MM-DD HH24:MI:SS') AS DT_DATTRKYMD FROM FSIB.T_ZAISYKRSK WHERE C_BHNSZICOD = '$parts_code_for_out' AND C_LINENUM = '$line_no_for_out' AND L_KNBNUM = '$kanban_num_for_out' AND DT_DATTRKYMD >= to_date('$scan_date_time', 'YYYY-MM-DD HH24:MI:SS') AND ROWNUM <= 1");
// 				//$query = oci_parse($conn_oracle, "SELECT C_TRKUSER,C_BHNSZICOD,C_LINENUM,L_KNBNUM,TO_CHAR(DT_DATTRKYMD, 'YYYY-MM-DD HH24:MI:SS') AS DT_DATTRKYMD FROM FSIB.T_ZAISYKRSK WHERE C_BHNSZICOD LIKE '%$parts_code_for_out%' AND C_LINENUM LIKE '%$line_no_for_out%' AND L_KNBNUM LIKE '%$kanban_num_for_out%' AND DT_DATTRKYMD >= to_date('$scan_date_time', 'YYYY-MM-DD HH24:MI:SS') AND ROWNUM <= 1");
// 				$query = oci_parse($conn_oracle, "SELECT C_TRKUSER,C_BHNSZICOD,C_LINENUM,L_KNBNUM,TO_CHAR(DT_DATTRKYMD, 'YYYY-MM-DD HH24:MI:SS') AS DT_DATTRKYMD FROM FSIB.T_ZAISYKRSK WHERE C_BHNSZICOD = '$parts_code_for_out' AND C_LINENUM = '$line_no_for_out' AND L_KNBNUM = '$kanban_num_for_out' AND DT_DATTRKYMD >= to_date('$scan_date_time', 'YYYY-MM-DD HH24:MI:SS') AND ROWNUM <= 1");
// 				//$query = oci_parse($conn_oracle, "SELECT * FROM FSIB.T_ZAISYKRSK WHERE C_BHNSZICOD LIKE '%$parts_code%' AND C_BHNSZINAM LIKE '%$parts_name%' AND DT_DATTRKYMD >= to_date('$scan_date_time', 'YYYY-MM-DD HH24:MI:SS') AND ROWNUM <= 1");
// 				oci_execute($query);
// 				while($row_ora=oci_fetch_assoc($query)){
// 					$store_out_person = $row_ora['C_TRKUSER'];
// 					$store_out_date_time = $row_ora['DT_DATTRKYMD'];
// 					$sql1 = "INSERT INTO history (id_scanned_kanban, kanban, kanban_num, supplier_name, parts_name, parts_code, line_no, location, delivery, quantity, stock_address, scooter_station, distributor, scan_date_time, request_date_time, print_date_time, store_out_date_time, store_out_person, status, real_time_status)
// 					VALUES ('$id_scanned_kanban','$kanban','$kanban_num','$supplier_name','$parts_name','$parts_code','$line_no','$location','$delivery','$quantity','$stock_address','$scooter_station','$distributor','$scan_date_time','$request_date_time','$print_date_time','$store_out_date_time','$store_out_person','Ready for Delivery','Ready for Delivery')";
// 					if($conn_sql->query($sql1) === TRUE){
// 						$sql2 = "DELETE FROM ongoing_picking WHERE id_scanned_kanban='$id_scanned_kanban' AND kanban='$kanban'";
// 						if ($conn_sql->query($sql2) === TRUE){
// 							echo "Record deleted successfully";
// 							$count_out = $count_out + 1;
// 						} else {
// 							echo "Error deleting record: " . $conn_sql->error;
// 						}
// 					} else {
// 						echo "Error: " . $sql1 . "<br>" . $conn_sql->error;
// 					}
// 				}
// 			}
// 			echo '~!~';
// 			echo $count_out;
// 		}
// 		echo "Already Checked"; -->
?>














