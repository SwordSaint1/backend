<?php
require_once '../Connection/ConnectOracle.php';
include '../Connection/ConnectSqlsrv.php';
$operation = $_GET['operation'];
if($operation == 'get_scan_kanban'){
    $id_scanned_kanban = $_GET['id_scanned_kanban'];
    $identifier = '';
    if($id_scanned_kanban == ""){
        $id_scanned_kanban = date("ymdh");
        $rand = substr(md5(microtime()),rand(0,26),5);
        $id_scanned_kanban = 'REQ:'.$id_scanned_kanban;
        $id_scanned_kanban = $id_scanned_kanban.''.$rand;
    }else{
        $id_scanned_kanban = $id_scanned_kanban;
    }
    $kanban_scan = $_GET['kanban_scan'];
    $kanban_scan = strtoupper($kanban_scan);
    $location = substr($kanban_scan, 5,4); //Location
    $delivery = substr($kanban_scan, 9,4); //Delivery
    

    // CHECK KANBAN ON MASTERLIST
    $queryCheck = "SELECT partsname, station, quantity, kanban_number, partscode, suppliers_name, stock_address, line_number FROM mm_masterlist WHERE kanban_qrcode = '$kanban_scan'";
    $stmt=sqlsrv_query($conn_sqlsrv,$queryCheck);
    $row = sqlsrv_has_rows($stmt);
    if($row == TRUE){
        while($x = sqlsrv_fetch_array($stmt,SQLSRV_FETCH_ASSOC)){
            // GET KANBAN DETAILS
            $partsname = $x['partsname'];
            $scooter_station = $x['station'];
            $quantity = $x['quantity'];
            $kanban_number = $x['kanban_number'];
            $partscode = trim($x['partscode']);
            $supplier_name = $x['suppliers_name'];
            // $stock_address = $x['stock_address'];
            $line_no = trim($x['line_number']);
        }


        // GET STOCK ADDRESS 
        $get_stock_address = oci_parse($conn_oracle, "SELECT NVL(C_BANTICODE,'No Data') AS C_BANTICODE
                                        FROM(SELECT C_BHNSZICOD, C_BHNSZINAM, C_DSNSIZ, C_DSNJIIRO, C_DSNSTRIPE,C_TKSSENCOD,L_MINLOTSUU,C_KNYSAKCOD,C_BANTICODE,C_KNYSAKBHNNAM 
                                            FROM (SELECT A.C_BHNSZICOD, A.C_BHNSZINAM, A.C_DSNSIZ, A.C_DSNJIIRO, A.C_DSNSTRIPE,A.C_TKSSENCOD,C.L_MINLOTSUU,A.C_KNYSAKCOD,B.C_BANTICODE,A.DT_ZAIKOTRKHIZ, A.C_NYKLBLBARCOD,C.C_KNYSAKBHNNAM ,
                                            RANK() OVER(PARTITION BY A.C_BHNSZICOD ORDER BY A.DT_ZAIKOTRKHIZ, A.C_NYKLBLBARCOD,B.C_BANTICODE) AS RANKING 
                                            FROM T_ZAIZIKMSI A LEFT JOIN M_BANTI B ON A.C_BHNSZICOD = B.C_BANTIBIKOU LEFT OUTER JOIN M_ZAIBHNSZIMST C ON A.C_BHNSZICOD = C.C_BHNSZICOD AND A.C_KNYSAKCOD = C.C_KNYSAKCOD 
                                            WHERE NVL(A.C_ZAKSTATUS,'00') = '00' AND NVL(B.C_BANTIKUBUN,'1') = '1' AND NVL(B.C_HIKIATEFLAG,'1') = '1' AND TO_CHAR(NVL(B.DT_STARTYMD,SYSDATE),'YYYY/MM/DD') <= TO_CHAR(SYSDATE,'YYYY/MM/DD') AND TO_CHAR(NVL(B.DT_ENDYMD,SYSDATE),'YYYY/MM/DD') >= TO_CHAR(SYSDATE,'YYYY/MM/DD') 
                                            AND A.C_CNTFLG = '0' AND A.C_PLTFLG = '0' AND A.C_BNTFLG = '1' AND A.C_LOCCOD LIKE '1457' 
                                            ORDER BY A.C_LOCCOD, A.C_BHNSZICOD, A.DT_ZAIKOTRKHIZ, A.C_NYKLBLBARCOD) WHERE RANKING = 1
                                            UNION ALL SELECT C_BHNSZICOD,C_BHNSZINAM,C_DSNSIZ,C_DSNJIIRO,C_DSNSTRIPE,C_TKSSENCOD,L_MINLOTSUU,C_KNYSAKCOD,BB.C_BANTICODE,C_KNYSAKBHNNAM
                                            FROM(SELECT C_BHNSZICOD,C_BHNSZINAM,C_DSNSIZ,C_DSNJIIRO,C_DSNSTRIPE,C_TKSSENCOD,L_MINLOTSUU,C_KNYSAKCOD,NULL AS C_BANTICODE,C_KNYSAKBHNNAM
                                                FROM (
                                                    SELECT A.C_BHNSZICOD,A.C_BHNSZINAM,A.C_DSNSIZ,A.C_DSNJIIRO,A.C_DSNSTRIPE,A.C_TKSSENCOD,A.L_MINLOTSUU,A.C_KNYSAKCOD,NULL AS C_BANTICODE,A.C_KNYSAKBHNNAM,RANK() OVER(PARTITION BY A.C_BHNSZICOD ORDER BY A.C_KNYSAKCOD) AS RANKING 
                                                    FROM M_ZAIBHNSZIMST A WHERE NOT EXISTS(SELECT 1 FROM (SELECT C_BHNSZICOD, C_BHNSZINAM, C_DSNSIZ, C_DSNJIIRO, C_DSNSTRIPE,C_TKSSENCOD,L_MINLOTSUU,C_KNYSAKCOD,C_BANTICODE,C_KNYSAKBHNNAM 
                                                    FROM (SELECT A.C_BHNSZICOD, A.C_BHNSZINAM, A.C_DSNSIZ, A.C_DSNJIIRO,A.C_DSNSTRIPE,A.C_TKSSENCOD,A.L_MINLOTSUU,A.C_KNYSAKCOD,B.C_BANTICODE,A.DT_ZAIKOTRKHIZ, A.C_NYKLBLBARCOD,C.C_KNYSAKBHNNAM ,
                                                    RANK() OVER(PARTITION BY A.C_BHNSZICOD ORDER BY A.DT_ZAIKOTRKHIZ, A.C_NYKLBLBARCOD,B.C_BANTICODE) AS RANKING 
                                                    FROM T_ZAIZIKMSI A LEFT JOIN M_BANTI B ON A.C_BHNSZICOD = B.C_BANTIBIKOU LEFT OUTER JOIN M_ZAIBHNSZIMST C ON A.C_BHNSZICOD = C.C_BHNSZICOD AND A.C_KNYSAKCOD = C.C_KNYSAKCOD 
                                                    WHERE NVL(A.C_ZAKSTATUS,'00') = '00' AND NVL(B.C_BANTIKUBUN,'1') = '1' AND NVL(B.C_HIKIATEFLAG,'1') = '1' AND TO_CHAR(NVL(B.DT_STARTYMD,SYSDATE),'YYYY/MM/DD') <= TO_CHAR(SYSDATE,'YYYY/MM/DD') AND TO_CHAR(NVL(B.DT_ENDYMD,SYSDATE),'YYYY/MM/DD') >= TO_CHAR(SYSDATE,'YYYY/MM/DD') 
                                                    AND A.C_CNTFLG = '0' AND A.C_PLTFLG = '0' AND A.C_BNTFLG = '1' AND A.C_LOCCOD = '1457' ORDER BY A.C_LOCCOD, A.C_BHNSZICOD, A.DT_ZAIKOTRKHIZ, A.C_NYKLBLBARCOD) WHERE RANKING = 1) B WHERE A.C_BHNSZICOD = B.C_BHNSZICOD)
                                                ) WHERE RANKING = 1
                                            ) AA LEFT OUTER JOIN M_BANTI BB ON AA.C_BHNSZICOD = BB.C_BANTIBIKOU WHERE AA.C_BHNSZICOD IS NOT NULL
                                        )
                                        WHERE C_BHNSZICOD = '$partscode'");
        oci_execute($get_stock_address);
        while($data = oci_fetch_assoc($get_stock_address)){
            $stock_address = $data['C_BANTICODE'];
        }


        // DUPLICATE ENTRY
        $duplicateQuery = "SELECT id FROM mm_scanned_kanban WHERE id_scanned_kanban = '$id_scanned_kanban' AND kanban = '$kanban_scan' AND line_no = '$line_no' AND parts_code = '$partscode' AND kanban_num = '$kanban_number'";
        $stmt0 = sqlsrv_query($conn_sqlsrv,$duplicateQuery);
        $row0 = sqlsrv_has_rows($stmt0);
        if($row0 === true){
            $identifier = 'Error: Duplicate Entry!';
            echo 'Error: Duplicate Entry!';
            }else{
                // CHECK WHEN ALREADY REQUESTED
                $checkReq = "SELECT id FROM mm_scanned_kanban WHERE kanban = '$kanban_scan' AND line_no = '$line_no' AND parts_code = '$partscode' AND kanban_num = '$kanban_number' AND status !='' UNION SELECT id FROM mm_ongoing_picking WHERE kanban = '$kanban_scan' AND line_no = '$line_no' AND parts_code = '$partscode' AND kanban_num='$kanban_number' AND status !=''";
                $stmt1 = sqlsrv_query($conn_sqlsrv,$checkReq);
                $row1 = sqlsrv_has_rows($stmt1);
                if($row1 === true){
                    $identifier = 'Error: Duplicate Entry!';
                    echo 'Error: Already Requested!';
                }else{
                    // INSERTING REQUEST
                    $scan_date_time = date("Y-m-d H:i:s");
                    $insertRequest = "INSERT INTO mm_scanned_kanban (id_scanned_kanban,kanban,location,delivery,line_no,stock_address,supplier_name,parts_code,parts_name,quantity,kanban_num,scooter_station,scan_date_time) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)";
                    $parameters = array($id_scanned_kanban, $kanban_scan, $location, $delivery, $line_no, $stock_address, $supplier_name, $partscode, $partsname, $quantity, $kanban_number, $scooter_station, $scan_date_time);
                    $stmt2=sqlsrv_query($conn_sqlsrv,$insertRequest,$parameters);
                    if($stmt2 === false){
                        die(print_r(sqlsrv_errors(),true));
                    }else{
                        $identifier = $id_scanned_kanban;
                        echo $id_scanned_kanban;
                    }
                    sqlsrv_free_stmt($stmt1);
                    sqlsrv_free_stmt($stmt2);
                }
                sqlsrv_free_stmt($stmt0);
                // sqlsrv_close($conn_sqlsrv);
            }
    }
    else{
        echo 'Error: Please Review your Kanban!';
    }
    // FREE PREPARED STATEMENT
    sqlsrv_free_stmt($stmt);
    sqlsrv_close($conn_sqlsrv);
    if($identifier == ''){
        // echo 'Error: Unregistered Kanban!';
    }else if($identifier == 'Error: Duplicate Entry!' ){
        // echo 'Error: Duplicate Entry!';
    }else if($identifier == 'Error: Already Requested!' ){
        // echo 'Error: Already Requested!';
    }

}

elseif($operation == "get_kanban"){
    $no = 0;
    $request_id =$_GET['id_scanned_kanban'];
    $sql = "SELECT id, line_no, parts_code, parts_name, quantity, kanban_num FROM mm_scanned_kanban WHERE id_scanned_kanban='$request_id' ORDER BY id DESC";
    $stmt = sqlsrv_query($conn_sqlsrv, $sql);
    $row = sqlsrv_has_rows($stmt);
    if ($row === true){
        while($rows = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){
            $no = $no + 1;
            echo'
                <tr id="row_table_requested_'.$no.'">
                    <td class="font-weight-normal">'.$no.'</td><td class="font-weight-normal">'.$rows['line_no'].'</td><td class="font-weight-normal">'.$rows['parts_code'].'</td><td class="font-weight-normal">'.$rows['parts_name'].'</td><td class="font-weight-normal">'.$rows['quantity'].'</td><td class="font-weight-normal">'.$rows['kanban_num'].'</td><td class="h5 mx-0 my-0 py-0 px-0"><center><i class="fas fa-trash mt-3 my-unique-text" style="cursor:pointer;" onclick="delete_request(&quot;'.$request_id.'~!~'.$rows['id'].'&quot;);"></i></center></td>
                </tr>
            ';
        }
    }else{
        echo "";
    }
    sqlsrv_free_stmt($stmt);
    sqlsrv_close($conn_sqlsrv);
}

else if($operation == "request_success"){
    $request_date_time = date("Y-m-d H:i:s");
    $request_id = $_GET['id_scanned_kanban'];
    $distributor = $_GET['distributor'];
    $sql = "UPDATE mm_scanned_kanban SET request_date_time=?, requested_by=?, status=? WHERE id_scanned_kanban=?";
    $params = array($request_date_time, $distributor, 'Pending', $request_id);
	$stmt = sqlsrv_query($conn_sqlsrv, $sql, $params);
	$rows_affected = sqlsrv_rows_affected($stmt);
	if($rows_affected === false){
		die(print_r( sqlsrv_errors(), true));
	}elseif( $rows_affected == -1){
		echo "Record updated successfully";
	}else{
		echo "Record updated successfully";
	}
	sqlsrv_free_stmt($stmt);
    sqlsrv_close($conn_sqlsrv);
}

else if($operation == "delete_kanban"){
    $id_scanned_kanban = $_GET['id_scanned_kanban'];
    $id = $_GET['id'];
    $distributor_id = $_GET['distributor_id'];
    
    $sql = "SELECT TOP 1 id_no FROM mm_distributor_account WHERE id_no='$distributor_id'";
    $stmt = sqlsrv_query($conn_sqlsrv, $sql);
    $row = sqlsrv_has_rows($stmt);
    if ($row === true){
        while($rows = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){
            $sql1 = "SELECT * FROM mm_scanned_kanban WHERE id='$id' AND id_scanned_kanban='$id_scanned_kanban'";
            $stmt1 = sqlsrv_query($conn_sqlsrv, $sql1);
            $row1 = sqlsrv_has_rows($stmt1);
            if ($row1 === true){
                while($rows1 = sqlsrv_fetch_array($stmt1, SQLSRV_FETCH_ASSOC)){
                    $kanban = $rows1['kanban'];
                    $location = $rows1['location'];
                    $delivery = $rows1['delivery'];
                    $line_no = $rows1['line_no'];
                    $stock_address = $rows1['stock_address'];
                    $supplier_name = $rows1['supplier_name'];
                    $parts_code = $rows1['parts_code'];
                    $parts_name = $rows1['parts_name'];
                    $quantity = $rows1['quantity'];
                    $kanban_num = $rows1['kanban_num'];
                    $scooter_station = $rows1['scooter_station'];
                    $scan_date_time = date_format($rows1['scan_date_time'],"Y-m-d H:i:s");
                    $parts_code = $rows1['parts_code'];
                    $delete_date_time = date("Y-m-d H:i:s");
                    $sql2 = "INSERT INTO mm_request_deleted (id_scanned_kanban, kanban, location, delivery, line_no, stock_address, supplier_name, parts_code, parts_name, quantity, kanban_num, scooter_station, scan_date_time, delete_date_time, deleted_by) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
                    $params2 = array($id_scanned_kanban, $kanban, $location, $delivery, $line_no, $stock_address, $supplier_name, $parts_code, $parts_name, $quantity, $kanban_num, $scooter_station, $scan_date_time, $delete_date_time, $distributor_id);
                    $stmt2 = sqlsrv_query($conn_sqlsrv, $sql2, $params2);
                    if($stmt2 === false){
                        die( print_r( sqlsrv_errors(), true));
                    }else{
                        $sql3 = "DELETE FROM mm_scanned_kanban WHERE id = ? AND id_scanned_kanban = ?";
                        $params3 = array($id, $id_scanned_kanban);
                        $stmt3 = sqlsrv_query($conn_sqlsrv, $sql3, $params3);
                        if($stmt3 === false ) {
                            die( print_r( sqlsrv_errors(), true));
                        }else{
                            echo 'Kanban Request Deleted!';
                        }
                    }
                }
            }else{
            }

        }
    }else{
        echo 'Unregistered ID Code!';
    }
}


















































// if($id_scanned_kanban == ""){



// 	$request_id = date("ymdh");
// 	$rand = substr(md5(microtime()),rand(0,26),5);
// 	$request_id = 'REQ:'.$request_id;
// 	$request_id = $request_id.''.$rand;
// }else{
// 	$request_id = $id_scanned_kanban;
// }
// if($operation == "get_scan_kanban"){
// 	$kanban_scan = mysqli_real_escape_string($conn_sql, $_GET['kanban_scan']);
// 	$scooter_station = mysqli_real_escape_string($conn_sql, $_GET['scooter_area']);
// 	// To Check Kanban
// 	// First is for Duplicate Entry
// 	$sql = "SELECT request_id kanban, scooter_station, status FROM tc_scanned_kanban WHERE kanban='$kanban_scan' AND scooter_station='$scooter_station' and request_id='$request_id' and status ='' LIMIT 1";
// 	$result = $conn_sql->query($sql);
// 	if($result->num_rows > 0){
// 		echo 'Error: Duplicate Entry!';
// 	}else{
// 		// Second is for Allready Requested
// 		$sql1 = "SELECT request_id, kanban, scooter_station, status FROM tc_scanned_kanban WHERE kanban='$kanban_scan' AND scooter_station='$scooter_station' and request_id !='$request_id' and status !='' LIMIT 1";
// 		$result1 = $conn_sql->query($sql1);
// 		if($result1->num_rows > 0){
// 			echo 'Error: Already Requested!';
// 		}else{
// 			// For Checking the Master and Insert Data
// 			$sql2 = "SELECT * FROM tc_kanban_masterlist WHERE kanban='$kanban_scan' ORDER BY id DESC LIMIT 1";
// 			$result2 = $conn_sql->query($sql2);
// 			if($result2->num_rows > 0){
// 				while($row2 = $result2->fetch_assoc()){
// 					$production_lot = $row2['production_lot'];
// 					$parts_code = $row2['parts_code'];
// 					$line_no = $row2['line_no'];
// 					$stock_address = $row2['stock_address'];
// 					$parts_name = $row2['parts_name'];
// 					$comment = $row2['comment'];
// 					$length = $row2['length'];
// 					$quantity = $row2['quantity'];
// 					$kanban_no = $row2['kanban_no'];
// 					$serial_no = $row2['serial_no'];
// 					$scan_date_time = date("Y-m-d H:i:s");
// 					$sql3 = "SELECT request_id, kanban, serial_no FROM tc_scanned_kanban WHERE kanban='$kanban_scan' AND serial_no='$serial_no' AND request_id='$request_id' ORDER BY id DESC LIMIT 1";
// 					$result3 = $conn_sql->query($sql3);
// 					if($result3->num_rows > 0){
// 						echo $request_id;
// 					}else{
// 						$sql4 = "INSERT INTO tc_scanned_kanban (request_id, production_lot, parts_code, line_no, stock_address, parts_name, comment, length, quantity, kanban_no, kanban, serial_no, scooter_station, distributor, scan_date_time, request_date_time, print_date_time, store_out_date_time, requested_by, store_out_person, status)
// 						VALUES ('$request_id','$production_lot','$parts_code','$line_no','$stock_address','$parts_name','$comment','$length','$quantity','$kanban_no','$kanban_scan','$serial_no','$scooter_station','','$scan_date_time','','','','','','')";
// 						if($conn_sql->query($sql4) === TRUE){
// 							echo $request_id;
// 						} else {
// 							echo "Error: " . $sql4 . "<br>" . $conn_sql->error;
// 						}
// 					}
					
// 				}
// 			}else{
// 				echo 'Error: Unregistered Kanban!';
// 			}
// 		}
// 	}
// }
// else if($operation == "get_scan_serial_no"){
// 	$serial_no_scan = mysqli_real_escape_string($conn_sql, $_GET['serial_no_scan']);
// 	$scooter_station = mysqli_real_escape_string($conn_sql, $_GET['scooter_area']);
// 	// To Check Kanban
// 	// First is for Duplicate Entry
// 	$sql = "SELECT request_id serial_no, scooter_station, status FROM tc_scanned_kanban WHERE serial_no='$serial_no_scan' AND scooter_station='$scooter_station' and request_id='$request_id' and status ='' LIMIT 1";
// 	$result = $conn_sql->query($sql);
// 	if($result->num_rows > 0){
// 		echo 'Error: Duplicate Entry!';
// 	}else{
// 		// Second is for Allready Requested
// 		$sql1 = "SELECT request_id, serial_no, scooter_station, status FROM tc_scanned_kanban WHERE serial_no='$serial_no_scan' AND scooter_station='$scooter_station' and request_id !='$request_id' and status !='' LIMIT 1";
// 		$result1 = $conn_sql->query($sql1);
// 		if($result1->num_rows > 0){
// 			echo 'Error: Already Requested!';
// 		}else{
// 			// For Checking the Master and Insert Data
// 			$sql2 = "SELECT * FROM tc_kanban_masterlist WHERE serial_no='$serial_no_scan' ORDER BY id DESC LIMIT 1";
// 			$result2 = $conn_sql->query($sql2);
// 			if($result2->num_rows > 0){
// 				while($row2 = $result2->fetch_assoc()){
// 					$production_lot = $row2['production_lot'];
// 					$parts_code = $row2['parts_code'];
// 					$line_no = $row2['line_no'];
// 					$stock_address = $row2['stock_address'];
// 					$parts_name = $row2['parts_name'];
// 					$comment = $row2['comment'];
// 					$length = $row2['length'];
// 					$quantity = $row2['quantity'];
// 					$kanban_no = $row2['kanban_no'];
// 					$kanban = $row2['kanban'];
// 					$serial_no = $row2['serial_no'];
// 					$scan_date_time = date("Y-m-d H:i:s");
// 					$sql3 = "SELECT request_id, kanban, serial_no FROM tc_scanned_kanban WHERE kanban='$kanban' AND serial_no='$serial_no' AND request_id='$request_id' ORDER BY id DESC LIMIT 1";
// 					$result3 = $conn_sql->query($sql3);
// 					if($result3->num_rows > 0){
// 						echo $request_id;
// 					}else{
// 						$sql4 = "INSERT INTO tc_scanned_kanban (request_id, production_lot, parts_code, line_no, stock_address, parts_name, comment, length, quantity, kanban_no, kanban, serial_no, scooter_station, distributor, scan_date_time, request_date_time, print_date_time, store_out_date_time, requested_by, store_out_person, status)
// 						VALUES ('$request_id','$production_lot','$parts_code','$line_no','$stock_address','$parts_name','$comment','$length','$quantity','$kanban_no','$kanban','$serial_no','$scooter_station','','$scan_date_time','','','','','','')";
// 						if($conn_sql->query($sql4) === TRUE){
// 							echo $request_id;
// 						} else {
// 							echo "Error: " . $sql4 . "<br>" . $conn_sql->error;
// 						}
// 					}
					
// 				}
// 			}else{
// 				echo 'Error: Unregistered Serial No!';
// 			}
// 		}
// 	}
// }
// else if($operation == "get_kanban"){
// 	$no_row = 0;
// 	$request_id = mysqli_real_escape_string($conn_sql, $_GET['id_scanned_kanban']);
// 	$sql = "SELECT id, request_id, kanban, kanban_no, parts_name, comment, parts_code, quantity, scooter_station, length, line_no FROM tc_scanned_kanban WHERE request_id='$request_id' ORDER BY id DESC";
// 		$result = $conn_sql->query($sql);
// 		if($result->num_rows > 0){
// 			while($row = $result->fetch_assoc()){
// 				$no_row = $no_row + 1;
// 				echo'
// 					<tr id="row_table_requested_'.$no_row.'">
// 						<td class="font-weight-normal">'.$no_row.'</td><td class="font-weight-normal">'.$row['line_no'].'</td><td class="font-weight-normal">'.$row['parts_code'].'</td><td class="font-weight-normal">'.$row['parts_name'].'</td><td class="font-weight-normal">'.$row['comment'].'</td><td class="font-weight-normal">'.$row['length'].'</td><td class="font-weight-normal">'.$row['quantity'].'</td><td class="h5 mx-0 my-0 py-0 px-0"><center><i class="fas fa-trash mt-3 text-default" style="cursor:pointer;" onclick="delete_request(&quot;'.$row['request_id'].'~!~'.$row['id'].'&quot;);"></i></center></td>
// 					</tr>
// 				';
// 			}
// 		}else{
// 		}
// }
// 
// 
// $conn_sql->close();
?>
