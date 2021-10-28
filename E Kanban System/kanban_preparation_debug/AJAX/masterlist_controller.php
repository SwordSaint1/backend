<?php
	require_once '../Connection/ConnectSqlsrv.php';
	$method = $_POST['method'];
	if($method == 'load_masterlist'){
		$limit = $_POST['limit'];
		$scooter_station = $_POST['scooter_station'];
		$line = $_POST['line_number'];
		$parts_code = $_POST['parts_code'];
		$c = 0;
		if(empty($scooter_station)){
		$query = "SELECT TOP $limit *FROM mm_masterlist WHERE line_number LIKE '$line%' AND partscode LIKE '$parts_code%'";
		$stmt = sqlsrv_query($conn_sqlsrv,$query);
		$row = sqlsrv_has_rows($stmt);
		if($row === TRUE){
			while($x = sqlsrv_fetch_array($stmt,SQLSRV_FETCH_ASSOC)){
				$c++;
				echo '<tr>';
				echo '<td>
				<div class="form-check">
						  <input
						    class="form-check-input singleCheck"
						    type="checkbox"
						    value="'.$x['id'].'"
						    onclick="get_master_to_delete()"
						  />
						</div>
				</td>';
				echo '<td>'.$x['kanban_qrcode'].'</td>';
				echo '<td>'.$x['station'].'</td>';
				echo '<td>'.$x['kanban_number'].'</td>';
				echo '<td>'.$x['line_number'].'</td>';
				echo '<td>'.$x['partscode'].'</td>';
				echo '<td>'.$x['partsname'].'</td>';
				echo '<td>'.$x['quantity'].'</td>';
				echo '<td>'.$x['suppliers_name'].'</td>';
				echo '<td>'.$x['stock_address'].'</td>';
				echo '<td>'.date_format($x['date_uploaded'],'Y-m-d').'</td>';
				echo '<td>'.date_format($x['date_updated'],'Y-m-d').'</td>';
				echo '</tr>';
			}
			echo '<tr>';
			echo '<td colspan="14" style="text-align:center;"><button class="btn btn-success" onclick="load_masterlist()">LOAD MORE...</button></td>';
			echo '</tr>';
		}else{
			echo '<tr>';
				echo '<td colspan="14" style="text-align:center;">NO DATA</td>';
			echo '</tr>';
		}
		sqlsrv_free_stmt($stmt);
    	sqlsrv_close($conn_sqlsrv);
    }else{
    	$query = "SELECT TOP $limit *FROM mm_masterlist WHERE station = '$scooter_station' AND line_number LIKE '$line%' AND partscode LIKE '$parts_code%'";
		$stmt = sqlsrv_query($conn_sqlsrv,$query);
		$row = sqlsrv_has_rows($stmt);
		if($row === TRUE){
			while($x = sqlsrv_fetch_array($stmt,SQLSRV_FETCH_ASSOC)){
				$c++;
				echo '<tr>';
				echo '<td>
				<div class="form-check">
						  <input
						    class="form-check-input singleCheck"
						    type="checkbox"
						    value="'.$x['id'].'"
						    onclick="get_master_to_delete()"
						  />
						</div>
				</td>';
				echo '<td>'.$x['kanban_qrcode'].'</td>';
				echo '<td>'.$x['station'].'</td>';
				echo '<td>'.$x['kanban_number'].'</td>';
				echo '<td>'.$x['line_number'].'</td>';
				echo '<td>'.$x['partscode'].'</td>';
				echo '<td>'.$x['partsname'].'</td>';
				echo '<td>'.$x['quantity'].'</td>';
				echo '<td>'.$x['suppliers_name'].'</td>';
				echo '<td>'.$x['stock_address'].'</td>';
				echo '<td>'.date_format($x['date_uploaded'],'Y-m-d').'</td>';
				echo '<td>'.date_format($x['date_updated'],'Y-m-d').'</td>';
				echo '</tr>';
			}
			echo '<tr>';
			echo '<td colspan="14" style="text-align:center;"><button class="btn btn-success" onclick="load_masterlist()">LOAD MORE...</button></td>';
			echo '</tr>';
		}else{
			echo '<tr>';
			echo '<td colspan="14" style="text-align:center;">NO DATA</td>';
			echo '</tr>';
		}
		sqlsrv_free_stmt($stmt);
    	sqlsrv_close($conn_sqlsrv);
    }
}

	if($method == 'load_station'){
		echo '<option value="">--SELECT SCOOTER STATION--</option>';
		$query = "SELECT DISTINCT scooter_area FROM mm_scooter_area  ORDER BY scooter_area ASC";
		$stmt = sqlsrv_query($conn_sqlsrv,$query);
		while($x = sqlsrv_fetch_array($stmt,SQLSRV_FETCH_ASSOC)){
			echo '<option value="'.$x['scooter_area'].'">'.$x['scooter_area'].'</option>';
		}
	}

	if($method == 'load_transfer_station'){
		echo '<option value="">--SELECT NEW SCOOTER STATION--</option>';
		$query = "SELECT DISTINCT scooter_area FROM mm_scooter_area  ORDER BY scooter_area ASC";
		$stmt = sqlsrv_query($conn_sqlsrv,$query);
		while($x = sqlsrv_fetch_array($stmt,SQLSRV_FETCH_ASSOC)){
			echo '<option value="'.$x['scooter_area'].'">'.$x['scooter_area'].'</option>';
		}
	}

	//DELETE FROM ARRAYED ID
	if($method == 'delete_master'){
		$data = [];
		$data = $_POST['arrID'];
		$selectedData = count($data);
		foreach($data as $x){
			// echo $x;
			$sql = "DELETE FROM mm_masterlist WHERE id = ?";
			$param = array($x);
			$stmt = sqlsrv_query($conn_sqlsrv,$sql,$param);
			if($stmt == true){
				$affected = sqlsrv_rows_affected($stmt);
				$selectedData = $selectedData - $affected;
			}else{
				die(print_r(sqlsrv_errors(),true));
			}
		}
		// CHECK DELETE PROGRESS
			if($selectedData == '0'){
				echo 'done';
			}else{
				echo 'error';
			}
		sqlsrv_free_stmt($stmt);
		sqlsrv_close($conn_sqlsrv);
	}

	// TRANSFER /UPDATE SCOOTER STATION

	if($method == 'transfer_kanban_master'){
		$new_station = $_POST['new_station'];
		$data = [];
		$data = $_POST['arrID'];
		$selectedData = count($data);
		foreach($data as $x){
			$sql = "UPDATE mm_masterlist SET station = ? WHERE id = ?";
			$update_param = array($new_station,$x);
			$stmt = sqlsrv_query($conn_sqlsrv,$sql,$update_param);
			if($stmt == true){
				$affected = sqlsrv_rows_affected($stmt);
				$selectedData = $selectedData - $affected;
			}else{
				die(print_r(sqlsrv_errors(),true));
			}
		}
		// CHECK DELETE PROGRESS
			if($selectedData == '0'){
				echo 'done';
			}else{
				echo 'error';
			}
		sqlsrv_free_stmt($stmt);
		sqlsrv_close($conn_sqlsrv);
	}
?>