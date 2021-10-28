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
		<th class="h6">Request ID</th>
		<th class="h6">Scooter Station</th>
		<th class="h6">Request Data & Time</th>
		<th class="h6">Kanban</th>
		<th class="h6">Requested By</th>
		<th class="h6">Status</th>
	</tr>
</thead>
';
$lines_select = mysqli_real_escape_string($conn_sql, $_GET['lines_select']);
$date_from = mysqli_real_escape_string($conn_sql, $_GET['date_from']);
$date_from = $date_from.' 00:00:00';
$date_to = mysqli_real_escape_string($conn_sql, $_GET['date_to']);
$date_to = $date_to.' 24:59:59';
$sql = "SELECT request_id, distributor, kanban, line_no, scooter_station, request_date_time, status FROM tc_history WHERE line_no='$lines_select' AND (request_date_time >= '$date_from' AND request_date_time <= '$date_to') GROUP BY(request_id) ORDER BY id DESC";
	$result = $conn_sql->query($sql);
	if($result->num_rows > 0){
		while($row = $result->fetch_assoc()){
			$sql1 = "SELECT request_id FROM tc_history WHERE line_no='".$row['line_no']."'";
			$result1 = $conn_sql->query($sql1);
			if($result1->num_rows > 0){
				$rowcount = mysqli_num_rows($result1);
				echo'
					<tr style="cursor:pointer;">
						<td class="font-weight-normal">'.$row['request_id'].'</td>
						<td class="font-weight-normal">'.$row['scooter_station'].'</td>
						<td class="font-weight-normal">'.$row['request_date_time'].'</td>
						<td class="font-weight-normal">'.$rowcount.'</td>
						<td class="font-weight-normal">'.$row['distributor'].'</td>
						<td class="font-weight-normal">'.$row['status'].'</td>
					</tr>
				';
			}
		}
	}else{
	}
echo'
</table>
</body>
</html>
';
?>