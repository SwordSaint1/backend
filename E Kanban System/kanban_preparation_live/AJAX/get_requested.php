<?php
include '../Connection/ConnectSqlsrv.php';
$operation = $_GET['operation'];
if($operation == "select_request_scooter_area"){
    $no = 0 ;
    $scooter_area = $_GET['scooter_area'];
    $sql = "SELECT DISTINCT id_scanned_kanban, requested_by, request_date_time, scooter_station, status FROM mm_scanned_kanban WHERE scooter_station='$scooter_area' AND status='Pending' ORDER BY request_date_time ASC";
    $stmt = sqlsrv_query($conn_sqlsrv, $sql);
    $row = sqlsrv_has_rows($stmt);
    if ($row === true){
        while($rows = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){
             //Checking How Many kanban in One Request
            $sql1 = "SELECT id FROM mm_scanned_kanban WHERE scooter_station='$scooter_area' AND status='Pending' AND id_scanned_kanban='".$rows['id_scanned_kanban']."'";
            $params1 = array();
            $options1 =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
            $stmt1 = sqlsrv_query($conn_sqlsrv,$sql1,$params1,$options1);
            $row_count1 = sqlsrv_num_rows($stmt1);
            //Checking if the Request has MM Remarks and Distributor Remarks
            $sql2 = "SELECT id FROM mm_remarks WHERE id_scanned_kanban='".$rows['id_scanned_kanban']."'";
            $params2 = array();
            $options2 =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
            $stmt2 = sqlsrv_query($conn_sqlsrv,$sql2,$params2,$options2);
            $row_count2 = sqlsrv_num_rows($stmt2);
            if($row_count2 > 0){
                $bgcolor = "red lighten-1";
                $color = "text-white";
            }else{
                $bgcolor = "";
                $color = "";
            }
            $no = $no + 1;
            echo'
                <tr class="'.$bgcolor.' '.$color.'" onclick="open_details_request(&quot;'.$rows['id_scanned_kanban'].'~!~'.$rows['status'].'~!~'.$rows['requested_by'].'&quot;)" style="cursor:pointer;">
                    <td class="font-weight-normal">'.$no.'</td><td class="font-weight-normal">'.$rows['id_scanned_kanban'].'</td><td class="font-weight-normal">'.$rows['scooter_station'].'</td><td class="font-weight-normal">'.date_format($rows['request_date_time'],"Y-m-d H:i:s").'</td><td class="font-weight-normal">'.$row_count1.'</td>
                </tr>
            ';
        }
    }else{
        
    }
    sqlsrv_free_stmt($stmt);
    sqlsrv_close($conn_sqlsrv);
}else if($operation == "select_request_scooter_area_ongoing"){
    $no = 0 ;
    $scooter_area = $_GET['scooter_area'];
    $sql = "SELECT DISTINCT id_scanned_kanban, requested_by, request_date_time, scooter_station, status FROM mm_ongoing_picking WHERE scooter_station='$scooter_area' AND status='Ongoing Picking' ORDER BY request_date_time ASC";
    $stmt = sqlsrv_query($conn_sqlsrv, $sql);
    $row = sqlsrv_has_rows($stmt);
    if ($row === true){
        while($rows = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){
             //Checking How Many kanban in One Request
            $sql1 = "SELECT id FROM mm_ongoing_picking WHERE scooter_station='$scooter_area' AND status='Ongoing Picking' AND id_scanned_kanban='".$rows['id_scanned_kanban']."'";
            $params1 = array();
            $options1 =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
            $stmt1 = sqlsrv_query($conn_sqlsrv,$sql1,$params1,$options1);
            $row_count1 = sqlsrv_num_rows($stmt1);
            //Checking if the Request has MM Remarks and Distributor Remarks
            $sql2 = "SELECT id FROM mm_remarks WHERE id_scanned_kanban='".$rows['id_scanned_kanban']."'";
            $params2 = array();
            $options2 =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
            $stmt2 = sqlsrv_query($conn_sqlsrv,$sql2,$params2,$options2);
            $row_count2 = sqlsrv_num_rows($stmt2);
            if($row_count2 > 0){
                $bgcolor = "red lighten-1";
                $color = "text-white";
            }else{
                $bgcolor = "";
                $color = "";
            }
            $no = $no + 1;
            echo'
                <tr class="'.$bgcolor.' '.$color.'" onclick="open_details_request(&quot;'.$rows['id_scanned_kanban'].'~!~'.$rows['status'].'~!~'.$rows['requested_by'].'&quot;)" style="cursor:pointer;">
                    <td class="font-weight-normal">'.$no.'</td><td class="font-weight-normal">'.$rows['id_scanned_kanban'].'</td><td class="font-weight-normal">'.$rows['scooter_station'].'</td><td class="font-weight-normal">'.date_format($rows['request_date_time'],"Y-m-d H:i:s").'</td><td class="font-weight-normal">'.$row_count1.'</td>
                </tr>
            ';
        }
    }else{
        
    }
    sqlsrv_free_stmt($stmt);
    sqlsrv_close($conn_sqlsrv);
}else if($operation == "get_requestor_name"){
    $id_scanned_kanban = $_GET['id_scanned_kanban'];
    $requested_by = $_GET['requested_by'];
    $sql = "SELECT TOP 1 name FROM mm_distributor_account WHERE id_no='$requested_by'";
    $stmt = sqlsrv_query($conn_sqlsrv, $sql);
    $row = sqlsrv_has_rows($stmt);
    if ($row === true){
        while($rows = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){
            echo '<i class="fas fa-user-check"></i> '.$rows['name'];
        }
    }else{
    }
    sqlsrv_free_stmt($stmt);
    sqlsrv_close($conn_sqlsrv);
}else if($operation == "open_details_requested_pending"){
    $id_scanned_kanban = $_GET['id_scanned_kanban'];
    $sql = "SELECT id_scanned_kanban, kanban, line_no, stock_address, parts_code, parts_name, quantity, kanban_num, scooter_station, status, scan_date_time, request_date_time FROM mm_scanned_kanban WHERE id_scanned_kanban='$id_scanned_kanban' ORDER BY line_no ASC, stock_address ASC , parts_code ASC";
    $stmt = sqlsrv_query($conn_sqlsrv, $sql);
    $row = sqlsrv_has_rows($stmt);
    if ($row === true){
        while($rows = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){
            $kanban = $rows['kanban'];
            $kanban_num = $rows['kanban_num'];
            $request_date_time =date_format($rows['request_date_time'],"Y-m-d H:i:s");
			$time_trucking = date("H:i:s",strtotime($request_date_time));
            //For Getting the Remarks of MM and Distributor
            $sql1 = "SELECT TOP 1 mm_remarks FROM mm_remarks WHERE id_scanned_kanban = '$id_scanned_kanban' AND kanban = '$kanban' AND kanban_num = '$kanban_num' ORDER BY id DESC";
            $stmt1 = sqlsrv_query($conn_sqlsrv, $sql1);
            $row1 = sqlsrv_has_rows($stmt1);
            if ($row1 === true){
                while($rows1 = sqlsrv_fetch_array($stmt1, SQLSRV_FETCH_ASSOC)){
                    $mm_remarks = $rows1['mm_remarks'];
                }
            }else{
                $mm_remarks = '';
            }
            //Checking the Truck No
			$sql2 = "SELECT truck_no FROM mm_truck_no WHERE time_from <= '$time_trucking' AND time_to >= '$time_trucking'";
			$stmt2 = sqlsrv_query($conn_sqlsrv, $sql2);
			$row2 = sqlsrv_has_rows($stmt2);
			if ($row2 === true){
				while($rows2 = sqlsrv_fetch_array($stmt2, SQLSRV_FETCH_ASSOC)){
					$truck_no = $rows2['truck_no'];
				}
			}else{
				$truck_no = 'Undefined';
			}
            echo'
 				<tr>
 					<td>'.$rows['line_no'].'</td><td>'.$rows['stock_address'].'</td><td>'.$rows['parts_code'].'</td><td>'.$rows['parts_name'].'</td><td>'.$rows['quantity'].'</td><td>'.$rows['kanban_num'].'</td><td>'.$truck_no.'</td><td>'.date_format($rows['scan_date_time'],"Y-m-d H:i:s").'</td><td>'.date_format($rows['request_date_time'],"Y-m-d H:i:s").'</td><td>N/A</td><td style="cursor:pointer;" onclick="add_remarks_distributor(&quot;'.$rows['id_scanned_kanban'].'~!~'.$rows['kanban'].'~!~'.$rows['kanban_num'].'~!~'.date_format($rows['scan_date_time'],"Y-m-d H:i:s").'~!~'.date_format($rows['request_date_time'],"Y-m-d H:i:s").'~!~'.$rows['scooter_station'].'~!~'.$rows['status'].'&quot;)">'.$mm_remarks.'</td>
 				</tr>
 			';
        }
    }else{
    }
    sqlsrv_free_stmt($stmt);
    sqlsrv_free_stmt($stmt1);
    sqlsrv_close($conn_sqlsrv);
}else if($operation == "open_details_requested_op"){
    $id_scanned_kanban = $_GET['id_scanned_kanban'];
    $sql = "SELECT id_scanned_kanban, kanban, line_no, stock_address, parts_code, parts_name, quantity, kanban_num, scooter_station, status, scan_date_time, request_date_time, print_date_time FROM mm_ongoing_picking WHERE id_scanned_kanban='$id_scanned_kanban' ORDER BY line_no ASC, stock_address ASC , parts_code ASC";
    $stmt = sqlsrv_query($conn_sqlsrv, $sql);
    $row = sqlsrv_has_rows($stmt);
    if ($row === true){
        while($rows = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){
            $kanban = $rows['kanban'];
            $kanban_num = $rows['kanban_num'];
            $request_date_time =date_format($rows['request_date_time'],"Y-m-d H:i:s");
			$time_trucking = date("H:i:s",strtotime($request_date_time));
            //For Getting the Remarks of MM and Distributor
            $sql1 = "SELECT TOP 1 mm_remarks FROM mm_remarks WHERE id_scanned_kanban = '$id_scanned_kanban' AND kanban = '$kanban' AND kanban_num = '$kanban_num' ORDER BY id DESC";
            $stmt1 = sqlsrv_query($conn_sqlsrv, $sql1);
            $row1 = sqlsrv_has_rows($stmt1);
            if ($row1 === true){
                while($rows1 = sqlsrv_fetch_array($stmt1, SQLSRV_FETCH_ASSOC)){
                    $mm_remarks = $rows1['mm_remarks'];
                }
            }else{
                $mm_remarks = '';
            }
            //Checking the Truck No
			$sql2 = "SELECT truck_no FROM mm_truck_no WHERE time_from <= '$time_trucking' AND time_to >= '$time_trucking'";
			$stmt2 = sqlsrv_query($conn_sqlsrv, $sql2);
			$row2 = sqlsrv_has_rows($stmt2);
			if ($row2 === true){
				while($rows2 = sqlsrv_fetch_array($stmt2, SQLSRV_FETCH_ASSOC)){
					$truck_no = $rows2['truck_no'];
				}
			}else{
				$truck_no = 'Undefined';
			}
            echo'
 				<tr>
 					<td>'.$rows['line_no'].'</td><td>'.$rows['stock_address'].'</td><td>'.$rows['parts_code'].'</td><td>'.$rows['parts_name'].'</td><td>'.$rows['quantity'].'</td><td>'.$rows['kanban_num'].'</td><td>'.$truck_no.'</td><td>'.date_format($rows['scan_date_time'],"Y-m-d H:i:s").'</td><td>'.date_format($rows['request_date_time'],"Y-m-d H:i:s").'</td><td>'.date_format($rows['print_date_time'],"Y-m-d H:i:s").'</td><td style="cursor:pointer;" onclick="add_remarks_distributor(&quot;'.$rows['id_scanned_kanban'].'~!~'.$rows['kanban'].'~!~'.$rows['kanban_num'].'~!~'.date_format($rows['scan_date_time'],"Y-m-d H:i:s").'~!~'.date_format($rows['request_date_time'],"Y-m-d H:i:s").'~!~'.$rows['scooter_station'].'~!~'.$rows['status'].'&quot;)">'.$mm_remarks.'</td>
 				</tr>
 			';
        }
    }else{
    }
    sqlsrv_free_stmt($stmt);
    sqlsrv_free_stmt($stmt1);
    sqlsrv_close($conn_sqlsrv);
}









































// if($operation == "display_all"){
// 	$sql = "SELECT request_id, distributor, kanban, scooter_station, request_date_time, status FROM tc_scanned_kanban WHERE status='Pending' GROUP BY(request_id) ORDER BY id ASC";
// 	$result = $conn_sql->query($sql);
// 	if($result->num_rows > 0){
// 		while($row = $result->fetch_assoc()){
// 			$sql1 = "SELECT request_id, kanban FROM tc_scanned_kanban WHERE status='Pending' AND request_id='".$row['request_id']."'";
// 			$result1 = $conn_sql->query($sql1);
// 			if($result1->num_rows > 0){
// 				$rowcount = mysqli_num_rows($result1);
// 				$sql2 = "SELECT id FROM tc_mm_remarks WHERE request_id='".$row['request_id']."'  AND kanban='".$row['kanban']."'";
// 				$result2 = $conn_sql->query($sql2);
// 				if($result2->num_rows > 0){
// 					$bgcolor = "red lighten-1";
// 					$color = "text-white";
// 				}else{
// 					$bgcolor = "";
// 					$color = "";
// 				}
// 				$sql3 = "SELECT id FROM tc_distributor_remarks WHERE request_id='".$row['request_id']."'  AND kanban='".$row['kanban']."'";
// 				$result3 = $conn_sql->query($sql3);
// 				if($result3->num_rows > 0){
// 					$bgcolor1 = "red lighten-1";
// 					$color1 = "text-white";
// 				}else{
// 					$bgcolor1 = "";
// 					$color1 = "";
// 				}
// 				echo'
// 					<tr class="'.$bgcolor.' '.$bgcolor1.' '.$color.' '.$color1.' " onclick="open_details_request(&quot;'.$row['request_id'].'~!~'.$row['status'].'&quot;)" style="cursor:pointer;" id="row_of_pending'.$row['request_id'].'">
// 						<td class="font-weight-normal" id="column_of_pending'.$row['request_id'].'">'.$row['request_id'].'</td><td class="font-weight-normal">'.$row['scooter_station'].'</td><td class="font-weight-normal">'.$row['request_date_time'].'</td><td class="font-weight-normal">'.$rowcount.'</td><td class="font-weight-normal">'.$row['distributor'].'</td>
// 					</tr>
// 				';
// 			}
// 		}
// 	}else{
// 	}
// }
// else if($operation == "display_all_ongoing"){
// 	//$scooter_area = mysqli_real_escape_string($conn_sql, $_GET['scooter_area']);
// 	$sql = "SELECT request_id, distributor, kanban, scooter_station, request_date_time, status FROM tc_scanned_kanban WHERE status='Ongoing Picking' GROUP BY(request_id) ORDER BY id ASC";
// 	$result = $conn_sql->query($sql);
// 	if($result->num_rows > 0){
// 		while($row = $result->fetch_assoc()){
// 			$sql1 = "SELECT request_id, kanban FROM tc_scanned_kanban WHERE status='Ongoing Picking' AND request_id='".$row['request_id']."'";
// 			$result1 = $conn_sql->query($sql1);
// 			if($result1->num_rows > 0){
// 				$rowcount = mysqli_num_rows($result1);
// 				$sql2 = "SELECT id FROM tc_mm_remarks WHERE request_id='".$row['request_id']."' AND kanban='".$row['kanban']."'";
// 				$result2 = $conn_sql->query($sql2);
// 				if($result2->num_rows > 0){
// 					$bgcolor = "red lighten-1";
// 					$color = "text-white";
// 				}else{
// 					$bgcolor = "";
// 					$color = "";
// 				}
// 				$sql3 = "SELECT id FROM tc_distributor_remarks WHERE request_id='".$row['request_id']."'  AND kanban='".$row['kanban']."'";
// 				$result3 = $conn_sql->query($sql3);
// 				if($result3->num_rows > 0){
// 					$bgcolor1 = "red lighten-1";
// 					$color1 = "text-white";
// 				}else{
// 					$bgcolor1 = "";
// 					$color1 = "";
// 				}
// 				echo'
// 					<tr class="'.$bgcolor.' '.$bgcolor1.' '.$color.' '.$color1.'" onclick="open_details_request(&quot;'.$row['request_id'].'~!~'.$row['status'].'&quot;)" style="cursor:pointer;">
// 						<td class="font-weight-normal">'.$row['request_id'].'</td><td class="font-weight-normal">'.$row['scooter_station'].'</td><td class="font-weight-normal">'.$row['request_date_time'].'</td><td class="font-weight-normal">'.$rowcount.'</td><td class="font-weight-normal">'.$row['distributor'].'</td>
// 					</tr>
// 				';
// 			}
// 		}
// 	}else{
// 	}
// }
// 
// 
// else if($operation == "open_details_request"){
// 	$request_id = mysqli_real_escape_string($conn_sql, $_GET['id_scanned_kanban']);
// 	$sql = "SELECT * FROM tc_scanned_kanban WHERE request_id='$request_id' AND status='Pending' ORDER BY line_no ASC, stock_address ASC , parts_code ASC";
// 	$result = $conn_sql->query($sql);
// 	if($result->num_rows > 0){
// 		while($row = $result->fetch_assoc()){
// 			echo'
// 				<tr>
// 					<td>'.$row['line_no'].'</td><td>'.$row['stock_address'].'</td><td>'.$row['parts_code'].'</td><td>'.$row['parts_name'].'</td><td>'.$row['comment'].'</td><td>'.$row['length'].'</td><td>'.$row['quantity'].'</td><td>'.$row['kanban_no'].'</td><td>'.$row['scan_date_time'].'</td><td>'.$row['request_date_time'].'</td>
// 				</tr>
// 			';
// 		}
// 	}else{
// 	}
// }
// else if($operation == "open_details_request_station"){
// 	$request_id = mysqli_real_escape_string($conn_sql, $_GET['id_scanned_kanban']);
// 	$sql = "SELECT * FROM tc_scanned_kanban WHERE request_id='$request_id' ORDER BY line_no ASC, stock_address ASC , parts_code ASC";
// 	$result = $conn_sql->query($sql);
// 	if($result->num_rows > 0){
// 		while($row = $result->fetch_assoc()){
// 			$request_id = $row['request_id'];
// 			$kanban = $row['kanban'];
// 			$kanban_no = $row['kanban_no'];
// 			$scan_date_time = $row['scan_date_time'];
// 			$request_date_time = $row['request_date_time'];
// 			$sql1 = "SELECT mm_remarks FROM tc_mm_remarks WHERE request_id='$request_id' AND kanban='$kanban' AND kanban_num='$kanban_no' AND scan_date_time='$scan_date_time' AND request_date_time='$request_date_time'";			
// 			$result1 = $conn_sql->query($sql1);
// 			if($result1->num_rows > 0){
// 				while($row1 = $result1->fetch_assoc()){
// 					$mm_remarks = $row1['mm_remarks'];
// 				}
// 			}else{
// 				$mm_remarks = '';
// 			}
// 			$sql1 = "SELECT distributor_remarks FROM tc_distributor_remarks WHERE request_id='$request_id' AND kanban='$kanban' AND kanban_num='$kanban_no' AND scan_date_time='$scan_date_time' AND request_date_time='$request_date_time'";			
// 			$result1 = $conn_sql->query($sql1);
// 			if($result1->num_rows > 0){
// 				while($row1 = $result1->fetch_assoc()){
// 					$distributor_remarks = $row1['distributor_remarks'];
// 				}
// 			}else{
// 				$distributor_remarks = '';
// 			}
// 			echo'
// 				<tr>
// 					<td>'.$row['line_no'].'</td><td>'.$row['stock_address'].'</td><td>'.$row['parts_code'].'</td><td>'.$row['parts_name'].'</td><td>'.$row['comment'].'</td><td>'.$row['length'].'</td><td>'.$row['quantity'].'</td><td>'.$row['kanban_no'].'</td><td>'.$row['scan_date_time'].'</td><td>'.$row['request_date_time'].'</td><td>'.$mm_remarks.'</td><td onclick="add_remarks_distributor(&quot;'.$row['request_id'].'~!~'.$row['kanban'].'~!~'.$row['kanban_no'].'~!~'.$row['scan_date_time'].'~!~'.$row['request_date_time'].'~!~'.$row['status'].'&quot;)" style="cursor:pointer;">'.$distributor_remarks.'</td><td>'.$row['status'].'</td>
// 				</tr>
// 			';
// 		}
// 	}else{
// 	}
// }
// 
// else if($operation == "open_details_request_ready_delivery"){
// 	$request_id = mysqli_real_escape_string($conn_sql, $_GET['id_scanned_kanban']);
// 	$sql = "SELECT * FROM tc_scanned_kanban WHERE request_id='$request_id' AND status='Ongoing Picking' ORDER BY line_no ASC, stock_address ASC , parts_code ASC";
// 	$result = $conn_sql->query($sql);
// 	if($result->num_rows > 0){
// 		while($row = $result->fetch_assoc()){
// 			$request_id = $row['request_id'];
// 			$kanban = $row['kanban'];
// 			$kanban_no = $row['kanban_no'];
// 			$scan_date_time = $row['scan_date_time'];
// 			$request_date_time = $row['request_date_time'];
// 			$scooter_station = $row['scooter_station'];
// 			$sql1 = "SELECT mm_remarks FROM tc_mm_remarks WHERE request_id='$request_id' AND kanban='$kanban' AND kanban_num='$kanban_no' AND scan_date_time='$scan_date_time' AND request_date_time='$request_date_time'";			
// 			$result1 = $conn_sql->query($sql1);
// 			if($result1->num_rows > 0){
// 				while($row1 = $result1->fetch_assoc()){
// 					$mm_remarks = $row1['mm_remarks'];
// 				}
// 			}else{
// 				$mm_remarks = '';
// 			}
// 			$sql1 = "SELECT distributor_remarks FROM tc_distributor_remarks WHERE request_id='$request_id' AND kanban='$kanban' AND kanban_num='$kanban_no' AND scan_date_time='$scan_date_time' AND request_date_time='$request_date_time'";			
// 			$result1 = $conn_sql->query($sql1);
// 			if($result1->num_rows > 0){
// 				while($row1 = $result1->fetch_assoc()){
// 					$distributor_remarks = $row1['distributor_remarks'];
// 				}
// 			}else{
// 				$distributor_remarks = '';
// 			}
// 			echo'
// 				<tr>
// 					<td>'.$row['line_no'].'</td><td>'.$row['stock_address'].'</td><td>'.$row['parts_code'].'</td><td>'.$row['parts_name'].'</td><td>'.$row['comment'].'</td><td>'.$row['length'].'</td><td>'.$row['quantity'].'</td><td>'.$row['kanban_no'].'</td><td>'.$row['scan_date_time'].'</td><td>'.$row['request_date_time'].'</td><td onclick="add_remarks_mm(&quot;'.$row['request_id'].'~!~'.$row['kanban'].'~!~'.$row['kanban_no'].'~!~'.$row['scan_date_time'].'~!~'.$row['request_date_time'].'~!~'.$scooter_station.'&quot;)" style="cursor:pointer;">'.$mm_remarks.'</td><td>'.$distributor_remarks.'</td>
// 				</tr>
// 			';
// 		}
// 	}else{
// 	}
// }
// else if($operation == "get_voice"){
// 	$sql = "SELECT tc_scooter_station FROM scanned_kanban WHERE status='Pending' GROUP BY(request_id) LIMIT 1";
// 	$result = $conn_sql->query($sql);
// 	if($result->num_rows > 0){
// 		while($row = $result->fetch_assoc()){
// 			echo $row['scooter_station'];
// 		}
// 	}else{
// 	}
// }
// else if($operation == "check_to_ten_min"){
// 	$sql = "SELECT request_id, request_date_time FROM tc_scanned_kanban WHERE status='Pending' GROUP BY(request_id) ";
// 	$result = $conn_sql->query($sql);
// 	if($result->num_rows > 0){
// 		while($row = $result->fetch_assoc()){
// 			$request_date_time = $row['request_date_time'];
// 			$cenvertedTime = date('Y-m-d H:i:s',strtotime('+10 minute',strtotime($request_date_time)));
// 			$now = date('Y-m-d H:i:s');
// 				//echo $cenvertedTime;
// 			if ($cenvertedTime < $now){
// 				echo $row['request_id'].'~!~';
// 			}
// 		}
// 	}else{
// 	}
// }
// else if($operation == "display_print_category_pending"){
// 	$request_id = mysqli_real_escape_string($conn_sql, $_GET['id_scanned_kanban']);
// 	$sql = "SELECT request_id, (SUBSTR(line_no,1,1)) AS alpha FROM tc_scanned_kanban WHERE request_id='$request_id' AND status='Pending' GROUP BY alpha ORDER BY line_no ASC, stock_address ASC , parts_code ASC";
// 	$result = $conn_sql->query($sql);
// 	if($result->num_rows > 0){
// 		while($row = $result->fetch_assoc()){
// 			echo'
// 				<option value='.$row['alpha'].'>Print ('.$row['alpha'].')</option>
// 			';
// 		}
// 	}else{
// 	}
// }
// else if($operation == "display_print_category_ongoing_picking"){
// 	$request_id = mysqli_real_escape_string($conn_sql, $_GET['id_scanned_kanban']);
// 	$sql = "SELECT request_id, (SUBSTR(line_no,1,1)) AS alpha FROM tc_scanned_kanban WHERE request_id='$request_id' AND status='Ongoing Picking' GROUP BY alpha ORDER BY line_no ASC, stock_address ASC , parts_code ASC";
// 	$result = $conn_sql->query($sql);
// 	if($result->num_rows > 0){
// 		while($row = $result->fetch_assoc()){
// 			echo'
// 				<option value='.$row['alpha'].'>Print ('.$row['alpha'].')</option>
// 			';
// 		}
// 	}else{
// 	}
// }
// $conn_sql->close();
?>
