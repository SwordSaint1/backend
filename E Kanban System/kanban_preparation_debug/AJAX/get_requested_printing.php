<?php
require_once '../Connection/ConnectSqlsrv.php';
$operation = $_GET['operation'];
if($operation == "display_pending"){
    $no = 0 ;
    $my_ip = $_SERVER['REMOTE_ADDR'];
    $sql = "SELECT DISTINCT id_scanned_kanban, requested_by, request_date_time, scooter_station, status FROM mm_scanned_kanban WHERE status='Pending' AND (selector_ip='$my_ip' OR selector_ip IS NULL) ORDER BY request_date_time ASC";
    $stmt = sqlsrv_query($conn_sqlsrv, $sql);
    $row = sqlsrv_has_rows($stmt);
    if ($row === true){
        while($rows = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){
             //Checking How Many kanban in One Request
            $sql1 = "SELECT id FROM mm_scanned_kanban WHERE status='Pending' AND id_scanned_kanban='".$rows['id_scanned_kanban']."'";
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
                <tr class="'.$bgcolor.' '.$color.'" onclick="open_details_request(&quot;'.$rows['id_scanned_kanban'].'~!~'.$rows['status'].'~!~'.$rows['requested_by'].'&quot;)" style="cursor:pointer;" id="row_of_pending'.$rows['id_scanned_kanban'].'">
                    <td class="font-weight-normal">'.$no.'</td><td class="font-weight-normal">'.$rows['id_scanned_kanban'].'</td><td class="font-weight-normal">'.$rows['scooter_station'].'</td><td class="font-weight-normal">'.date_format($rows['request_date_time'],"Y-m-d H:i:s").'</td><td class="font-weight-normal">'.$row_count1.'</td>
                </tr>
            ';
        }
    }else{
        
    }
    sqlsrv_free_stmt($stmt);
    sqlsrv_close($conn_sqlsrv);
}else if($operation == "display_ongoing"){
    $limiter_count = $_GET['limiter_count'];
    $no = $limiter_count ;
    $sql = "SELECT DISTINCT id_scanned_kanban, requested_by, request_date_time, scooter_station, status FROM mm_ongoing_picking WHERE status='Ongoing Picking' ORDER BY request_date_time ASC OFFSET $limiter_count ROWS FETCH NEXT 50 ROWS ONLY";
    $stmt = sqlsrv_query($conn_sqlsrv, $sql);
    $row = sqlsrv_has_rows($stmt);
    if ($row === true){
        while($rows = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){
             //Checking How Many kanban in One Request
            $sql1 = "SELECT id FROM mm_ongoing_picking WHERE status='Ongoing Picking' AND id_scanned_kanban='".$rows['id_scanned_kanban']."'";
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
                <tr class="'.$bgcolor.' '.$color.'" onclick="open_details_request(&quot;'.$rows['id_scanned_kanban'].'~!~'.$rows['status'].'~!~'.$rows['requested_by'].'&quot;)" style="cursor:pointer;" id="row_of_pending'.$rows['id_scanned_kanban'].'">
                    <td class="font-weight-normal">'.$no.'</td><td class="font-weight-normal">'.$rows['id_scanned_kanban'].'</td><td class="font-weight-normal">'.$rows['scooter_station'].'</td><td class="font-weight-normal">'.date_format($rows['request_date_time'],"Y-m-d H:i:s").'</td><td class="font-weight-normal">'.$row_count1.'</td>
                </tr>
            ';
        }
    }else{
        
    }
    sqlsrv_free_stmt($stmt);
    sqlsrv_close($conn_sqlsrv);
}else if($operation == "open_details_requested_pending"){
    $no = 0;
    $id_scanned_kanban = $_GET['id_scanned_kanban'];
    $sql = "SELECT id_scanned_kanban, kanban, line_no, stock_address, parts_code, parts_name, quantity, kanban_num, scooter_station, status, scan_date_time, request_date_time FROM mm_scanned_kanban WHERE id_scanned_kanban='$id_scanned_kanban' ORDER BY line_no ASC, stock_address ASC , parts_code ASC";
    $stmt = sqlsrv_query($conn_sqlsrv, $sql);
    $row = sqlsrv_has_rows($stmt);
    if ($row === true){
        while($rows = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){
            $no = $no + 1;
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
                    <td>'.$no.'</td><td>'.$rows['line_no'].'</td><td>'.$rows['stock_address'].'</td><td>'.$rows['parts_code'].'</td><td>'.$rows['parts_name'].'</td><td>'.$rows['quantity'].'</td><td>'.$rows['kanban_num'].'</td><td>'.$truck_no.'</td><td>'.date_format($rows['scan_date_time'],"Y-m-d H:i:s").'</td><td>'.date_format($rows['request_date_time'],"Y-m-d H:i:s").'</td><td>N/A</td><td style="cursor:pointer;" onclick="add_remarks_mm(&quot;'.$rows['id_scanned_kanban'].'~!~'.$rows['kanban'].'~!~'.$rows['kanban_num'].'~!~'.date_format($rows['scan_date_time'],"Y-m-d H:i:s").'~!~'.date_format($rows['request_date_time'],"Y-m-d H:i:s").'~!~'.$rows['scooter_station'].'~!~'.$rows['status'].'&quot;)">'.$mm_remarks.'</td>
 				</tr>
 			';
        }
    }else{
    }
    sqlsrv_free_stmt($stmt);
    sqlsrv_close($conn_sqlsrv);
}else if($operation == "open_details_requested_op"){
    $no = 0;
    $id_scanned_kanban = $_GET['id_scanned_kanban'];
    $sql = "SELECT id_scanned_kanban, kanban, line_no, stock_address, parts_code, parts_name, quantity, kanban_num, scooter_station, status, scan_date_time, request_date_time, print_date_time FROM mm_ongoing_picking WHERE id_scanned_kanban='$id_scanned_kanban' ORDER BY line_no ASC, stock_address ASC , parts_code ASC";
    $stmt = sqlsrv_query($conn_sqlsrv, $sql);
    $row = sqlsrv_has_rows($stmt);
    if ($row === true){
        while($rows = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){
            $no = $no + 1;
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
            //For Getting the Count of Reprint
            $sql2 = "SELECT id FROM mm_reprint_kanban WHERE id_scanned_kanban='$id_scanned_kanban' AND kanban='$kanban'";
            $params2 = array();
            $options2 =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
            $stmt2 = sqlsrv_query($conn_sqlsrv,$sql2,$params2,$options2 );
            $count_reprint = sqlsrv_num_rows($stmt2);
            if($count_reprint != 0){
                $count_reprint = $count_reprint;
            }else{
                $count_reprint = '';
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
                    <td>'.$no.'</td><td>'.$rows['line_no'].'</td><td>'.$rows['stock_address'].'</td><td>'.$rows['parts_code'].'</td><td>'.$rows['parts_name'].'</td><td>'.$rows['quantity'].'</td><td>'.$rows['kanban_num'].'</td><td>'.$truck_no.'</td><td>'.date_format($rows['scan_date_time'],"Y-m-d H:i:s").'</td><td>'.date_format($rows['request_date_time'],"Y-m-d H:i:s").'</td><td>'.date_format($rows['print_date_time'],"Y-m-d H:i:s").' <span class="badge badge-danger" style="cursor:pointer;" onclick="open_reprint_history(&quot;'.$rows['id_scanned_kanban'].'~!~'.$rows['kanban'].'~!~'.date_format($rows['scan_date_time'],"Y-m-d H:i:s").'~!~'.date_format($rows['request_date_time'],"Y-m-d H:i:s").'~!~'.$rows['scooter_station'].'~!~'.$rows['status'].'&quot;)">'.$count_reprint.'</span></td><td style="cursor:pointer;" onclick="add_remarks_mm(&quot;'.$rows['id_scanned_kanban'].'~!~'.$rows['kanban'].'~!~'.$rows['kanban_num'].'~!~'.date_format($rows['scan_date_time'],"Y-m-d H:i:s").'~!~'.date_format($rows['request_date_time'],"Y-m-d H:i:s").'~!~'.$rows['scooter_station'].'~!~'.$rows['status'].'&quot;)">'.$mm_remarks.'</td>
 				</tr>
 			';
        }
    }else{
    }
    sqlsrv_free_stmt($stmt);
    sqlsrv_free_stmt($stmt2);
    sqlsrv_close($conn_sqlsrv);
}else if($operation == "display_print_category_pending"){
    $id_scanned_kanban = $_GET['id_scanned_kanban'];
    $sql = "SELECT DISTINCT LEFT(line_no, 1) AS alpha FROM mm_scanned_kanban WHERE id_scanned_kanban='$id_scanned_kanban' AND status='Pending' ORDER BY alpha ASC";
    //$sql = "SELECT id_scanned_kanban, kanban, line_no, stock_address, parts_code, parts_name, quantity, kanban_num, scan_date_time, request_date_time FROM mm_ongoing_picking WHERE id_scanned_kanban='$id_scanned_kanban' ORDER BY line_no ASC, stock_address ASC , parts_code ASC";
    $stmt = sqlsrv_query($conn_sqlsrv, $sql);
    $row = sqlsrv_has_rows($stmt);
    if ($row === true){
        while($rows = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){
            echo'
                <option value='.$rows['alpha'].'>Print ('.$rows['alpha'].')</option>
            ';
        }
    }else{
    }
    sqlsrv_free_stmt($stmt);
    sqlsrv_close($conn_sqlsrv);
}else if($operation == "display_print_category_ongoing_picking"){
    $id_scanned_kanban = $_GET['id_scanned_kanban'];
    $sql = "SELECT DISTINCT LEFT(line_no, 1) AS alpha FROM mm_ongoing_picking WHERE id_scanned_kanban='$id_scanned_kanban' AND status='Ongoing Picking' ORDER BY alpha ASC";
    //$sql = "SELECT id_scanned_kanban, kanban, line_no, stock_address, parts_code, parts_name, quantity, kanban_num, scan_date_time, request_date_time FROM mm_ongoing_picking WHERE id_scanned_kanban='$id_scanned_kanban' ORDER BY line_no ASC, stock_address ASC , parts_code ASC";
    $stmt = sqlsrv_query($conn_sqlsrv, $sql);
    $row = sqlsrv_has_rows($stmt);
    if ($row === true){
        while($rows = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){
            echo'
                <option value='.$rows['alpha'].'>Print ('.$rows['alpha'].')</option>
            ';
        }
    }else{
    }
    sqlsrv_free_stmt($stmt);
    sqlsrv_close($conn_sqlsrv);
}else if($operation == "update_selection"){
    $id_scanned_kanban = $_GET['id_scanned_kanban'];
    $selector_ip = $_SERVER['REMOTE_ADDR'];
    $selection_date_time = date("Y-m-d H:i:s");
    $sql = "UPDATE mm_scanned_kanban SET selector_ip=?, selection_date_time=? WHERE id_scanned_kanban = ?";
    $params = array($selector_ip, $selection_date_time, $id_scanned_kanban);
    $stmt = sqlsrv_query($conn_sqlsrv, $sql, $params);
	$rows_affected = sqlsrv_rows_affected($stmt);
	if($rows_affected === false){
		die(print_r( sqlsrv_errors(), true));
	}elseif( $rows_affected == -1){
		echo "User Updated Successfully";
	}else{
		// For Count of Affected echo $rows_affected." rows were updated.<br />";
		echo "User Updated Successfully";
	}
	sqlsrv_free_stmt($stmt);
    sqlsrv_close($conn_sqlsrv);
}else if($operation == "open_reprint_history"){
    $id_scanned_kanban = $_GET['id_scanned_kanban'];
    $kanban = $_GET['kanban'];
    $scan_date_time = $_GET['scan_date_time'];
    $request_date_time = $_GET['request_date_time'];
    $scooter_station = $_GET['scooter_station'];
    $status = $_GET['status'];
    $no = 0;
    $sql = "SELECT scan_date_time, request_date_time, reprint_date_time FROM mm_reprint_kanban WHERE id_scanned_kanban='$id_scanned_kanban' AND kanban='$kanban' AND scan_date_time='$scan_date_time' AND request_date_time='$request_date_time' AND scooter_station='$scooter_station' AND status='$status' ORDER BY reprint_date_time ASC";
    $stmt = sqlsrv_query($conn_sqlsrv, $sql);
    $row = sqlsrv_has_rows($stmt);
    if ($row === true){
        while($rows = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){
            $sql1 = "SELECT line_no, stock_address, parts_code, parts_name, quantity, kanban_num FROM mm_ongoing_picking WHERE id_scanned_kanban='$id_scanned_kanban' AND kanban='$kanban' AND scan_date_time='$scan_date_time' AND request_date_time='$request_date_time' AND scooter_station='$scooter_station' AND status='$status'";
            $stmt1 = sqlsrv_query($conn_sqlsrv, $sql1);
            $row1 = sqlsrv_has_rows($stmt1);
            if ($row1 === true){
                while($rows1 = sqlsrv_fetch_array($stmt1, SQLSRV_FETCH_ASSOC)){
                    $no = $no+1;
                    echo'
                        <tr>
                            <td>'.$no.'</td><td>'.$rows1['line_no'].'</td><td>'.$rows1['stock_address'].'</td><td>'.$rows1['parts_code'].'</td><td>'.$rows1['parts_name'].'</td><td>'.$rows1['quantity'].'</td><td>'.$rows1['kanban_num'].'</td><td>'.date_format($rows['scan_date_time'],"Y-m-d H:i:s").'</td><td>'.date_format($rows['request_date_time'],"Y-m-d H:i:s").'</td><td>'.date_format($rows['reprint_date_time'],"Y-m-d H:i:s").'</td>
                        </tr>
                    ';
                }
            }
        }
    }else{
    }
    sqlsrv_free_stmt($stmt);
    sqlsrv_free_stmt($stmt1);
    sqlsrv_close($conn_sqlsrv);
}else if($operation == 'count_requested_ongoing'){
    $sql = "SELECT DISTINCT id_scanned_kanban, requested_by, request_date_time, scooter_station, status FROM mm_ongoing_picking WHERE status='Ongoing Picking'";
    $params = array();
	$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
	$stmt = sqlsrv_query($conn_sqlsrv,$sql,$params,$options );
	$row_count = sqlsrv_num_rows($stmt);
   	echo $row_count;
    sqlsrv_free_stmt($stmt);
    sqlsrv_close($conn_sqlsrv);
}else if($operation == "display_ongoing_realtime"){
    $limiter_count = $_GET['limiter_count'];
    $no = 0;
    $sql = "SELECT DISTINCT TOP $limiter_count id_scanned_kanban, requested_by, request_date_time, scooter_station, status FROM mm_ongoing_picking WHERE status='Ongoing Picking' ORDER BY request_date_time ASC";
    $stmt = sqlsrv_query($conn_sqlsrv, $sql);
    $row = sqlsrv_has_rows($stmt);
    if ($row === true){
        while($rows = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){
             //Checking How Many kanban in One Request
            $sql1 = "SELECT id FROM mm_ongoing_picking WHERE status='Ongoing Picking' AND id_scanned_kanban='".$rows['id_scanned_kanban']."'";
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
                <tr class="'.$bgcolor.' '.$color.'" onclick="open_details_request(&quot;'.$rows['id_scanned_kanban'].'~!~'.$rows['status'].'~!~'.$rows['requested_by'].'&quot;)" style="cursor:pointer;" id="row_of_pending'.$rows['id_scanned_kanban'].'">
                    <td class="font-weight-normal">'.$no.'</td><td class="font-weight-normal">'.$rows['id_scanned_kanban'].'</td><td class="font-weight-normal">'.$rows['scooter_station'].'</td><td class="font-weight-normal">'.date_format($rows['request_date_time'],"Y-m-d H:i:s").'</td><td class="font-weight-normal">'.$row_count1.'</td>
                </tr>
            ';
        }
    }else{
        
    }
    sqlsrv_free_stmt($stmt);
    sqlsrv_close($conn_sqlsrv);
}else if($operation == "open_reprint_option"){
    $id_scanned_kanban = $_GET['id_scanned_kanban'];
    $print_category = $_GET['print_category'];
    $no = 0;
    $sql = "SELECT line_no, parts_code, parts_name, kanban_num, quantity FROM mm_scanned_kanban WHERE id_scanned_kanban='$id_scanned_kanban' AND line_no LIKE '$print_category%' UNION SELECT line_no, parts_code, parts_name, kanban_num, quantity FROM mm_ongoing_picking WHERE id_scanned_kanban='$id_scanned_kanban' AND line_no LIKE '$print_category%'";
    $stmt = sqlsrv_query($conn_sqlsrv, $sql);
    $row = sqlsrv_has_rows($stmt);
    if ($row === true){
        while($rows = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){
            $no = $no + 1;
            $line_no =$rows['line_no'];
            $parts_code =$rows['parts_code'];
			$parts_name =$rows['parts_name'];
            $kanban_num =$rows['kanban_num'];
            $quantity =$rows['quantity'];
            echo'
                <tr>
                    <td class="font-weight-normal">'.$no.'</td><td class="font-weight-normal">'.$line_no.'</td><td class="font-weight-normal">'.$parts_code.'</td><td class="font-weight-normal">'.$parts_name.'</td><td class="font-weight-normal">'.$kanban_num.'</td><td class="font-weight-normal">'.$quantity.'</td>
                </tr>
            ';
        }
    }else{
        
    }
    sqlsrv_free_stmt($stmt);
    sqlsrv_close($conn_sqlsrv);
}
?>
