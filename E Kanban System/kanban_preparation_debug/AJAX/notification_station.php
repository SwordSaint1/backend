<?php
require_once '../Connection/ConnectSqlsrv.php';
$operation =$_GET['operation'];
if($operation == "display_remarks"){
    $no = 0;
    $status_sender_id = $_GET['status_sender_id'];
    $scooter_station = $_GET['scooter_station'];
    $sql = "SELECT DISTINCT id_scanned_kanban, kanban, kanban_num, scooter_station, scan_date_time, request_date_time FROM mm_remarks WHERE sender_identification='$status_sender_id' and scooter_station='$scooter_station'";
    $stmt = sqlsrv_query($conn_sqlsrv, $sql);
    $row = sqlsrv_has_rows($stmt);
    if ($row === true){
        while($rows = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){
            $id_scanned_kanban = $rows['id_scanned_kanban'];
            $kanban = $rows['kanban'];
            $kanban_num = $rows['kanban_num'];
            $scan_date_time = date_format($rows['scan_date_time'],"Y-m-d H:i:s");
            $request_date_time = date_format($rows['request_date_time'],"Y-m-d H:i:s");
            $scooter_station = $rows['scooter_station'];
            //Getting Latest anf Single Data
            $sql1 = "SELECT TOP 1 mm_remarks, sender, remarks_date_time, remarks_status FROM mm_remarks WHERE id_scanned_kanban='$id_scanned_kanban' AND kanban='$kanban' AND kanban_num='$kanban_num' AND scan_date_time='$scan_date_time' AND request_date_time='$request_date_time' AND sender_identification='$status_sender_id' ORDER BY id DESC";
            $stmt1 = sqlsrv_query($conn_sqlsrv, $sql1);
            $row1 = sqlsrv_has_rows($stmt1);
            if ($row1 === true){
                while($rows1 = sqlsrv_fetch_array($stmt1, SQLSRV_FETCH_ASSOC)){
                    $mm_remarks = $rows1['mm_remarks'];
                    $sender = $rows1['sender'];
                    $remarks_date_time = date_format($rows1['remarks_date_time'],"Y-m-d H:i:s");
                    $remarks_status = $rows1['remarks_status'];
                    if($remarks_status == 'Unread'){
                        $seen_indicator = 'grey lighten-1';
                    }else{
                        $seen_indicator = '';
                    }
                    //Getting Other Data in Pending or Ongoing Picking
                    $sql2 = "SELECT id, line_no, stock_address, parts_code, parts_name, quantity, kanban_num, status FROM mm_scanned_kanban where id_scanned_kanban='$id_scanned_kanban' AND kanban='$kanban' AND kanban_num='$kanban_num' AND scan_date_time='$scan_date_time' AND request_date_time='$request_date_time' UNION SELECT id, line_no, stock_address, parts_code, parts_name, quantity, kanban_num, status FROM mm_ongoing_picking where id_scanned_kanban='$id_scanned_kanban' AND kanban='$kanban' AND kanban_num='$kanban_num' AND scan_date_time='$scan_date_time' AND request_date_time='$request_date_time'";
                    $stmt2 = sqlsrv_query($conn_sqlsrv, $sql2);
                    $row2 = sqlsrv_has_rows($stmt2);
                    if ($row2 === true){
                        while($rows2 = sqlsrv_fetch_array($stmt2, SQLSRV_FETCH_ASSOC)){
                            $no = $no +1;
                            $id = $rows2['id'];
                            $line_no = $rows2['line_no'];
                            $stock_address = $rows2['stock_address'];
                            $parts_code = $rows2['parts_code'];
                            $parts_name = $rows2['parts_name'];
                            $quantity = $rows2['quantity'];
                            $kanban_num = $rows2['kanban_num'];
                            $status = $rows2['status'];
                            echo'
                                <tr class="'.$seen_indicator.';">
                                    <td>'.$no.'</td><td>'.$line_no.'</td><td>'.$stock_address.'</td><td>'.$parts_code.'</td><td>'.$parts_name.'</td><td>'.$quantity.'</td><td>'.$kanban_num.'</td><td>'.$scan_date_time.'</td><td>'.$request_date_time.'</td><td style="cursor:pointer;" onclick="add_remarks_station(&quot;'.$id_scanned_kanban.'~!~'.$kanban.'~!~'.$kanban_num.'~!~'.$scan_date_time.'~!~'.$request_date_time.'~!~'.$scooter_station.'~!~'.$status.'&quot;)">'.$mm_remarks.'</td><td>'.$remarks_date_time.'</td><td>'.$status.'</td>
                                </tr>
                            ';
                        }
                    }
                }
            }
        }
    }else{
        $mm_remarks = '';
    }
}
?>