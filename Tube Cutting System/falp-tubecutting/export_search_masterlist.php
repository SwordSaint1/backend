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
        <td>Master Identification</td>
	</tr>
</thead>
';
$no =0;
$line_no = mysqli_real_escape_string($conn_sql,$_GET['line_no']);
$parts_name = mysqli_real_escape_string($conn_sql, $_GET['parts_name']);
$parts_code = mysqli_real_escape_string($conn_sql, $_GET['parts_code']);
$length = mysqli_real_escape_string($conn_sql, $_GET['length']);
$query = "SELECT * FROM tc_kanban_masterlist WHERE line_no LIKE '%$line_no%' AND parts_name LIKE '%$parts_name%' AND parts_code LIKE '%$parts_code%' AND length LIKE '%$length%' ORDER BY id ASC";
$result = $conn_sql->query($query);
if($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
        $kanban =$row['kanban'];
        $identification_qr = substr($kanban, 0,3);
        if($identification_qr == 'TC-'){
            $new_iden_qr = 'New';
        }else{
            $new_iden_qr = 'Old';
        }
        $no = $no + 1;
            echo'
                <tr style="cursor:pointer;" >
                    <td class="font-weight-normal">'.$no.'</td><td class="font-weight-normal">'.$row['line_no'].'</td><td class="font-weight-normal">'.$row['stock_address'].'</td><td class="font-weight-normal">'.$row['parts_code'].'</td><td class="font-weight-normal">'.$row['parts_name'].'</td><td class="font-weight-normal">'.$row['comment'].'</td><td class="font-weight-normal">'.$row['length'].'</td><td class="font-weight-normal">'.$row['quantity'].'</td><td class="font-weight-normal">'.$row['kanban_no'].'</td><td class="font-weight-normal">'.$new_iden_qr.'</td>
                </tr>
            ';
    }
}else{
    echo "<td colspan='10' style='font-weight:bold;color:red;'><center>NO DATA FOUND</center></td>";
}