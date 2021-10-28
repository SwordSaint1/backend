<?php
set_time_limit(0);
include '../Connection/Connect_sql.php';
$operation = mysqli_real_escape_string($conn_sql, $_GET['operation']);
if($operation == "display_remarks"){
    $scooter_station = mysqli_real_escape_string($conn_sql, $_GET['scooter_station']);
    $status_sender_id = mysqli_real_escape_string($conn_sql, $_GET['status_sender_id']);
    $no = 0;
    if ($status_sender_id == 'Tubecutting Remarks'){
        $sql = "SELECT request_id, kanban, kanban_num, scan_date_time, request_date_time FROM tc_mm_remarks WHERE scooter_station='$scooter_station'";
        $result = $conn_sql->query($sql);
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $request_id = $row['request_id'];
                $kanban = $row['kanban'];
                $kanban_num = $row['kanban_num'];
                $scan_date_time = $row['scan_date_time'];
                $request_date_time = $row['request_date_time'];
                $sql1 = "SELECT mm_remarks, mm_status, mm_date_time FROM tc_mm_remarks WHERE request_id='$request_id' AND request_id='$request_id' AND kanban='$kanban' AND kanban_num='$kanban_num' AND scan_date_time='$scan_date_time' AND request_date_time='$request_date_time'ORDER BY id DESC LIMIT 1";
                $result1 = $conn_sql->query($sql1);
                if($result1->num_rows > 0){
                    while($row1 = $result1->fetch_assoc()){
                        $notif_date_time = $row1['mm_date_time'];
                        $mm_remarks = $row1['mm_remarks'];
                        $mm_status = $row1['mm_status'];
                        if ($mm_status == 'Unread'){
                            $bgcolortemp = 'grey lighten-1';
                        }elseif($bgcolortemp = 'Read' ){
                            $bgcolortemp = '';
                        }

                        $sql2 = "SELECT * FROM tc_scanned_kanban WHERE scooter_station='$scooter_station' AND request_id='$request_id' AND kanban='$kanban' AND kanban_no='$kanban_num' AND scan_date_time='$scan_date_time' AND request_date_time='$request_date_time'";
                        $result2 = $conn_sql->query($sql2);
                        if($result2->num_rows > 0){
                            while($row2 = $result2->fetch_assoc()){
                                $no = $no +1;
                                echo'
                                    <tr class="'.$bgcolortemp.'" onclick="add_remarks_distributor_notif(&quot;'.$row2['request_id'].'~!~'.$row2['kanban'].'~!~'.$row2['kanban_no'].'~!~'.$row2['scan_date_time'].'~!~'.$row2['request_date_time'].'~!~'.$row2['status'].'&quot;)" style="cursor:pointer;">
                                        <td>'.$no.'</td><td>'.$row2['line_no'].'</td><td>'.$row2['stock_address'].'</td><td>'.$row2['parts_code'].'</td><td>'.$row2['parts_name'].'</td><td>'.$row2['comment'].'</td><td>'.$row2['length'].'</td><td>'.$row2['quantity'].'</td><td>'.$row2['kanban_no'].'</td><td>'.$row2['scan_date_time'].'</td><td>'.$row2['request_date_time'].'</td><td>'.$mm_remarks.'</td><td>'.$notif_date_time.'</td><td>'.$row2['status'].'</td>
                                    </tr>
                                ';
                            }
                        }   
                    }
                }
            }
        }
    }elseif($status_sender_id == 'Production Remarks'){
        $sql = "SELECT DISTINCT request_id, kanban, kanban_num, scan_date_time, request_date_time FROM tc_distributor_remarks WHERE scooter_station='$scooter_station'";
        $result = $conn_sql->query($sql);
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $request_id = $row['request_id'];
                $kanban = $row['kanban'];
                $kanban_num = $row['kanban_num'];
                $scan_date_time = $row['scan_date_time'];
                $request_date_time = $row['request_date_time'];

                $sql1 = "SELECT distributor_remarks, distributor_status, distributor_date_time FROM tc_distributor_remarks WHERE request_id='$request_id' AND request_id='$request_id' AND kanban='$kanban' AND kanban_num='$kanban_num' AND scan_date_time='$scan_date_time' AND request_date_time='$request_date_time'ORDER BY id DESC LIMIT 1";
                $result1 = $conn_sql->query($sql1);
                if($result1->num_rows > 0){
                    while($row1 = $result1->fetch_assoc()){
                        $notif_date_time = $row1['distributor_date_time'];
                        $distributor_remarks = $row1['distributor_remarks'];
                        $distributor_status = $row1['distributor_status'];
                        if ($distributor_status == 'Unread'){
                            $bgcolortemp = 'grey lighten-1';
                        }elseif($bgcolortemp = 'Read' ){
                            $bgcolortemp = '';
                        }

                        $sql2 = "SELECT * FROM tc_scanned_kanban WHERE scooter_station='$scooter_station' AND request_id='$request_id' AND kanban='$kanban' AND kanban_no='$kanban_num' AND scan_date_time='$scan_date_time' AND request_date_time='$request_date_time'";
                        $result2 = $conn_sql->query($sql2);
                        if($result2->num_rows > 0){
                            while($row2 = $result2->fetch_assoc()){
                                $no = $no +1;
                                echo'
                                    <tr class="'.$bgcolortemp.'" onclick="add_remarks_distributor_notif(&quot;'.$row2['request_id'].'~!~'.$row2['kanban'].'~!~'.$row2['kanban_no'].'~!~'.$row2['scan_date_time'].'~!~'.$row2['request_date_time'].'~!~'.$row2['status'].'&quot;)" style="cursor:pointer;">
                                        <td>'.$no.'</td><td>'.$row2['line_no'].'</td><td>'.$row2['stock_address'].'</td><td>'.$row2['parts_code'].'</td><td>'.$row2['parts_name'].'</td><td>'.$row2['comment'].'</td><td>'.$row2['length'].'</td><td>'.$row2['quantity'].'</td><td>'.$row2['kanban_no'].'</td><td>'.$row2['scan_date_time'].'</td><td>'.$row2['request_date_time'].'</td><td>'.$distributor_remarks.'</td><td>'.$notif_date_time.'</td><td>'.$row2['status'].'</td>
                                    </tr>
                                ';
                            }
                        }    
                    }
                }
            }
        }

    }
}
else if($operation == "count_notif"){
    $scooter_station = mysqli_real_escape_string($conn_sql, $_GET['scooter_station']);
    $no = 0;
	$sql = "SELECT count(id) AS total FROM tc_mm_remarks WHERE scooter_station='$scooter_station' AND mm_status='Unread'";
	$result = $conn_sql->query($sql);
	if($result->num_rows > 0){
		while($row = $result->fetch_assoc()){
            $total =$row['total'];
            echo $total;
        }
    }else{
        echo 0;
    }
}
$conn_sql->close();
?>