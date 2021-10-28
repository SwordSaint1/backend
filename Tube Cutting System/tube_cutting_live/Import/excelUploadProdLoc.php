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
			$serial_no = isset($Row[0]) ? $Row[0] : '';
			$kanban_read = isset($Row[1]) ? $Row[1] : '';
			$parts_code = isset($Row[2]) ? $Row[2] : '';
			$line_no = isset($Row[3]) ? $Row[3] : '';
			$stock_address = isset($Row[4]) ? $Row[4] : '';
			$parts_name = isset($Row[5]) ? $Row[5] : '';
			$comment = isset($Row[6]) ? $Row[6] : '';
			$length = isset($Row[7]) ? $Row[7] : '';
			$quantity = isset($Row[8]) ? $Row[8] : '';
			$production_location = isset($Row[9]) ? $Row[9] : '';
			$date_updated = date("Y-m-d H:i:s");
			$sql = "UPDATE tc_kanban_masterlist SET prod_loc='$production_location' WHERE serial_no='$serial_no' AND kanban='$kanban_read'";
			if ($conn_sql->query($sql) === TRUE) {
				//echo "User Updated Successfully";
			} else {
				echo "Error updating record: " . $conn_sql->error;
			}
		}
	}
		echo "Updating Sucessfully";
	}
	else
	{
		die("<br/>Sorry, File type is not allowed. Only Excel file.");
	}
?>