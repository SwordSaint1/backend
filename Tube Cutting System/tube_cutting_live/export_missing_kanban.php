<?php
include 'Connection/Connect_sql.php';
$datenow = date('Y-m-d');
$filename = "Missing Kanban ".$datenow.".xls";
header("Content-Type: application/vnd.ms-excel");
header('Content-Type: text/csv; charset=utf-8');  
header("Content-Disposition: ; filename=\"$filename\"");
echo'
<html lang="en">
<body>
<table border="1">
<thead>
	<tr>
        <td>No</td>
		<td>Line No</td>
		<td>Stock Address</td>
		<td>Parts Code</td>
        <td>Parts Name</td>
        <td>Comment</td>
        <td>Length(mm)</td>
        <td>Quantity</td>
        <td>Kanban No</td>
        <td>Last Date Transaction</td>
        <td>Transaction Details</td>
	</tr>
</thead>
';
$no = 0;
$cycle_day = mysqli_real_escape_string($conn_sql,$_GET['cycle_day']);
$line_no = mysqli_real_escape_string($conn_sql, $_GET['line_no']);
$parts_name = mysqli_real_escape_string($conn_sql, $_GET['parts_name']);
$parts_code = mysqli_real_escape_string($conn_sql, $_GET['parts_code']);
$length = mysqli_real_escape_string($conn_sql, $_GET['length']);
$kanban_no = mysqli_real_escape_string($conn_sql, $_GET['kanban_no']);
$date_now = date("Y-m-d H:i:s");
$sql = "SELECT kanban, serial_no, line_no, stock_address, parts_code, parts_name, comment, length, quantity, kanban_no, transaction_date_time, transaction_details, DATEDIFF('$date_now', transaction_date_time) AS date_diff FROM tc_kanban_masterlist WHERE line_no LIKE '%$line_no%' AND parts_code LIKE '%$parts_code%' AND parts_name LIKE '%$parts_name%' AND length LIKE '%$length%' AND kanban_no LIKE '%$kanban_no%' ORDER BY transaction_date_time DESC";
$result = $conn_sql->query($sql);
if($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
        $no = $no +1;
        $date_diff = $row['date_diff'];
        if($date_diff == ''){
            $color = 'danger-color';
            $text_color = 'text-white';
        }elseif($date_diff > $cycle_day){
            $color = 'danger-color';
            $text_color = 'text-white';
        }else{
            $color = '';
            $text_color = '';
        }
        echo'
            <tr>
                <td>'.$no.'</td>
                <td>'.$row['line_no'].'</td>
                <td>'.$row['stock_address'].'</td>
                <td>'.$row['parts_code'].'</td>
                <td>'.$row['parts_name'].'</td>
                <td>'.$row['comment'].'</td>
                <td>'.$row['length'].'</td>
                <td>'.$row['quantity'].'</td>
                <td>'.$row['kanban_no'].'</td>
                <td>'.$row['transaction_date_time'].'</td>
                <td>'.$row['transaction_details'].'</td>
            </tr>
        ';
    }
}else{
    echo'
        <tr>
            <td colspan="14" class="text-center h6"><center><i class="fas fa-exclamation-triangle"></i> No Record Found</center></td>
        </tr>
    ';
}

?>