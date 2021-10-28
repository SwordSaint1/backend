<?php
include 'Connection/Connect_sql.php';
$datenow = date('Y-m-d');
$filename = "History".$datenow.".xls";
header("Content-Type: application/vnd.ms-excel");
header('Content-Type: text/csv; charset=utf-8');  
header("Content-Disposition: ; filename=\"$filename\"");
echo'
<html lang="en">
<body>
<table border="1">
<thead>
	<tr>
		<td>Serial No</td>
		<td>Kanban Read</td>
		<td>Parts Code</td>
        <td>Line No</td>
        <td>Stock Address</td>
        <td>Parts Name</td>
        <td>Comment</td>
        <td>Length(mm)</td>
		<td>Quantity</td>
		<td>Production Location</td>
	</tr>
</thead>
';
$line_no = mysqli_real_escape_string($conn_sql, $_GET['line_no']);
$parts_code = mysqli_real_escape_string($conn_sql, $_GET['parts_code']);
$parts_name = mysqli_real_escape_string($conn_sql, $_GET['parts_name']);
$length = mysqli_real_escape_string($conn_sql, $_GET['length']);
$sql = "SELECT * FROM tc_kanban_masterlist WHERE line_no LIKE '%$line_no%' AND parts_code LIKE '%$parts_code%' AND parts_name LIKE '%$parts_name%' AND length LIKE '%$length%'";
$result = $conn_sql->query($sql);
	if($result->num_rows > 0){
		while($row = $result->fetch_assoc()){
			echo'
				<tr>
					<td>'.$row['serial_no'].'</td><td>'.$row['kanban'].'</td><td>'.$row['parts_code'].'</td><td>'.$row['line_no'].'</td><td>'.$row['stock_address'].'</td><td>'.$row['parts_name'].'</td><td>'.$row['comment'].'</td><td>'.$row['length'].'</td><td>'.$row['quantity'].'</td><td>'.$row['prod_loc'].'</td>
				</tr>
			';
		}
	}
echo'
</table>
</body>
</html>
';
?>