<?php
set_time_limit(0);
date_default_timezone_set('Asia/Manila');
require('library/php-excel-reader/excel_reader2.php');
require('library/SpreadsheetReader.php');
include '../Connection/Connect_sql.php';
$batch_no = date("ymdh");
$rand = substr(md5(microtime()),rand(0,26),5);
$batch_no = 'BAT:'.$batch_no;
$batch_no = $batch_no.''.$rand;
//print_r($_FILES);
$mimes = array('application/vnd.ms-excel','text/xls','text/xlsx','text/csv','application/vnd.oasis.opendocument.spreadsheet','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
if(in_array($_FILES["file"]["type"],$mimes)){
	$uploadFilePath = 'uploads/'.basename($_FILES['file']['name']);
	move_uploaded_file($_FILES['file']['tmp_name'], $uploadFilePath);
	$Reader = new SpreadsheetReader($uploadFilePath);
	//echo $uploadFilePath;
	$totalSheet = count($Reader->sheets());
	//echo "You have total ".$totalSheet." sheets".
	/* For Loop for all sheets */
	for($i=0;$i<$totalSheet;$i++)
	{
		$Reader->ChangeSheet($i);
		foreach ($Reader as $Row)
		{
			$x = '';
			$production_lot = isset($Row[0]) ? $Row[0] : '';
			$parts_code = isset($Row[1]) ? $Row[1] : '';
			$line_no = isset($Row[2]) ? $Row[2] : '';
			$stock_address = isset($Row[3]) ? $Row[3] : '';
			$parts_name = isset($Row[4]) ? $Row[4] : '';
			$comment = isset($Row[5]) ? $Row[5] : '';
			$length = isset($Row[6]) ? $Row[6] : '';
			$quantity = isset($Row[7]) ? $Row[7] : '';
			$required_kanban = isset($Row[8]) ? $Row[8] : '';
			if($comment == '' ||$comment == '(blank)'){
				$comment1 = '';
			}else{
				$comment1 = $comment;
			}
			$date_updated = date("Y-m-d H:i:s");
			if ($production_lot != '' && $parts_code != '' && $line_no != '' && $stock_address != '' && $parts_name != '' && $length != '' && $quantity != ''){
				if($production_lot != 'Production Lot' && $parts_code != 'Parts Code' && $line_no != 'Line No' && $stock_address != 'Stock Address' && $parts_name != 'Parts Name' && $length != 'Length (mm)' && $quantity != 'Quantity' && $required_kanban != 'Required Kanban'){
					for ($x = 1; $x <= $required_kanban; $x++){
						$sql = "SELECT kanban_no FROM tc_kanban_masterlist WHERE parts_code LIKE '%$parts_code%' AND line_no LIKE '%$line_no%' AND stock_address LIKE '%$stock_address%' AND parts_name LIKE '%$parts_name%' AND comment LIKE '%$comment%' AND length LIKE '%$length%' AND quantity LIKE '%$quantity%' ORDER BY id DESC LIMIT 1";
						$result = $conn_sql->query($sql);
						if($result->num_rows > 0){
							while($row = $result->fetch_assoc()){
								$kanban_no_generated = $row['kanban_no'];
							}
							$date_for_serial_no = date("ymdHis");
							$rand = substr(md5(microtime()),rand(0,26),5);
							$rand1 = substr(md5(microtime()),rand(0,26),5);
							$serial_no = 'SN-'.$rand1.''.$parts_code.''.$rand;
							$kanban_no_generated = $kanban_no_generated + 1;
							$kanban =  'TC-'.$parts_name.'_'.$length.'_'.$line_no.'_'.$quantity.'_'.$parts_code.'_'.$stock_address.'_'.$kanban_no_generated.'_'.$date_for_serial_no;
							$sql1 = "INSERT INTO tc_kanban_masterlist (batch_id,production_lot,parts_code,line_no,stock_address,parts_name,comment,length,quantity,kanban_no,kanban,serial_no,date_updated)
							VALUES ('$batch_no','$production_lot','$parts_code','$line_no','$stock_address','$parts_name','$comment','$length','$quantity','$kanban_no_generated','$kanban','$serial_no','$date_updated')";
							if($conn_sql->query($sql1) === TRUE){
							}else{
								echo "Error: " . $sql1 . "<br>" . $conn_sql->error;
							}
						}else{
							$kanban_no_generated = 0;
							$date_for_serial_no = date("ymdHis");
							$rand = substr(md5(microtime()),rand(0,26),5);
							$rand1 = substr(md5(microtime()),rand(0,26),5);
							$serial_no = 'SN-'.$rand1.''.$parts_code.''.$rand;
							$kanban_no_generated = $kanban_no + $x;
							$kanban =  'TC-'.$parts_name.'_'.$length.'_'.$line_no.'_'.$quantity.'_'.$parts_code.'_'.$stock_address.'_'.$kanban_no_generated.'_'.$date_for_serial_no;
							$sql1 = "INSERT INTO tc_kanban_masterlist (batch_id,production_lot,parts_code,line_no,stock_address,parts_name,comment,length,quantity,kanban_no,kanban,serial_no,date_updated)
							VALUES ('$batch_no','$production_lot','$parts_code','$line_no','$stock_address','$parts_name','$comment','$length','$quantity','$kanban_no_generated','$kanban','$serial_no','$date_updated')";
							if($conn_sql->query($sql1) === TRUE){
							}else{
								echo "Error: " . $sql1 . "<br>" . $conn_sql->error;
							}
						}
						
					}
				}
			}else{
			}
		}
	}
		//echo $html;
		echo 'uploaded~!~'.$batch_no;
	}
	else
	{
		die("<br/>Sorry, File type is not allowed. Only Excel file.");
	}
?>