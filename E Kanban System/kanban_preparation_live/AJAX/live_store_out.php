<?php
set_time_limit(0);
include '../Connection/ConnectOracle.php';
$operation = $_GET['operation'];
if($operation == "display_all"){
	$kanban_no = $_GET['kanban_no'];
	$line_no = strtoupper($_GET['line_no']);
	$parts_code = $_GET['parts_code'];
	$date_from = $_GET['date_from'];
	$date_from=date_create($date_from);
	$date_from= date_format($date_from,"Y-m-d H:i:s");
	$date_to = $_GET['date_to'];
	$date_to=date_create($date_to);
	$date_to= date_format($date_to,"Y-m-d H:i:s");
	$limiter_count = $_GET['limiter_count'];
	$no = $limiter_count;
	$sql = oci_parse($conn_oracle, "SELECT C_TRKUSER,C_BHNSZICOD,C_LINENUM,L_KNBNUM,TO_CHAR(DT_DATTRKYMD, 'YYYY-MM-DD HH24:MI:SS') AS DT_DATTRKYMD FROM FSIB.T_ZAISYKRSK WHERE C_BHNSZICOD LIKE '%$parts_code%' AND C_LINENUM LIKE '%$line_no%' AND L_KNBNUM LIKE '%$kanban_no%' AND DT_DATTRKYMD >= to_date('$date_from', 'YYYY-MM-DD HH24:MI:SS') AND DT_DATTRKYMD <= to_date('$date_to', 'YYYY-MM-DD HH24:MI:SS') ORDER BY DT_DATTRKYMD ASC OFFSET $limiter_count ROWS FETCH NEXT 20 ROWS ONLY");
	oci_execute($sql);
		while($row_ora=oci_fetch_assoc($sql)){
			$no = $no +1;
			$parts_code = $row_ora['C_BHNSZICOD'];
			$line_no = $row_ora['C_LINENUM'];
			$kanban_no = $row_ora['L_KNBNUM'];
			$store_out_person = $row_ora['C_TRKUSER'];
			$store_out_date_time = $row_ora['DT_DATTRKYMD'];
			echo'
				<tr>
					<td>'.$no.'</td><td>'.$line_no.'</td><td>'.$parts_code.'</td><td>'.$kanban_no.'</td><td>'.$store_out_person.'</td><td>'.$store_out_date_time.'</td>
				</tr>
			';
		}
}
else if($operation == "count_all"){
	$kanban_no = mysqli_real_escape_string($conn_sql, $_GET['kanban_no']);
	$line_no = mysqli_real_escape_string($conn_sql, $_GET['line_no']);
	$parts_code = mysqli_real_escape_string($conn_sql, $_GET['parts_code']);
	$date_from = mysqli_real_escape_string($conn_sql, $_GET['date_from']);
	$date_from=date_create($date_from);
	$date_from= date_format($date_from,"Y-m-d H:i:s");
	$date_to = mysqli_real_escape_string($conn_sql, $_GET['date_to']);
	$date_to=date_create($date_to);
	$date_to= date_format($date_to,"Y-m-d H:i:s");
	$sql = oci_parse($conn_oracle, "SELECT COUNT(*) AS NUM_ROWS FROM FSIB.T_ZAISYKRSK WHERE C_BHNSZICOD LIKE '%$parts_code%' AND C_LINENUM LIKE '%$line_no%' AND L_KNBNUM LIKE '%$kanban_no%' AND DT_DATTRKYMD >= to_date('$date_from', 'YYYY-MM-DD HH24:MI:SS') AND DT_DATTRKYMD <= to_date('$date_to', 'YYYY-MM-DD HH24:MI:SS')");
	oci_execute($sql);
		while($row_ora=oci_fetch_assoc($sql)){
			$total_num = $row_ora['NUM_ROWS'];
			echo $total_num;
		}
}
?>