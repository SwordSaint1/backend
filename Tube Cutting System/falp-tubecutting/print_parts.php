<?php
	set_time_limit(0);
	session_start();
	$username_session = $_SESSION["username_session"];
	if($username_session == ''){
		header("location:index.php");
	}
	include 'Connection/Connect_sql.php';
?>
<?php
include ('phpbarcode/src/BarcodeGenerator.php');
include ('phpbarcode/src/BarcodeGeneratorPNG.php');
include ('phpbarcode/src/BarcodeGeneratorSVG.php');
include ('phpbarcode/src/BarcodeGeneratorJPG.php');
include ('phpbarcode/src/BarcodeGeneratorHTML.php');
$generator = new \Picqer\Barcode\BarcodeGeneratorPNG();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta charset="win-1252">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>Print Parts</title>
	<!-- Title Logo -->
	<!-- Font Awesome -->
	<!--link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css"-->
	<link rel="stylesheet" href="Fontawesome/fontawesome-free-5.9.0-web/css/all.css">
	<!-- Bootstrap core CSS -->
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<!-- Material Design Bootstrap -->
	<link href="css/mdb.min.css" rel="stylesheet">
	<!-- Your custom styles (optional) -->
	<link href="css/style.css" rel="stylesheet">
	<!-- My CSS -->
	<link href="mycss/style1.css" rel="stylesheet">
	<link rel="shortcut icon" href="favicon.ico" type="image/ico">
	<link href="favicon.png" rel="icon">
	<script src="myjs/jquery1-5-2.js"></script>
	<script type="text/javascript" src="jqueryqrcode/src/jquery.qrcode.js"></script>
	<script type="text/javascript" src="jqueryqrcode/src/qrcode.js"></script>
	<script src="myjs/JsBarcode.code128.min.js"></script>
	<style>
		@media print{@page {size: landscape}}
		table, tr, td{
			color:black;
			border: 1px solid black;
			border-width: medium;
		}
	</style>
</head>
<body class="mt-0 mb-0">
		<?php
			$page = 0;
			$request_id = mysqli_real_escape_string($conn_sql, $_GET['id_scanned_kanban']);
			$print_category = mysqli_real_escape_string($conn_sql, $_GET['print_category']);
			$sql = "SELECT * FROM tc_scanned_kanban WHERE request_id='$request_id' AND line_no LIKE '$print_category%' ORDER BY parts_name ASC, comment ASC";
			$result = $conn_sql->query($sql);
			if($result->num_rows > 0){
				$countID = mysqli_num_rows ( $result );
				while($row = $result->fetch_assoc()){
					echo'
						<table id="myTable" style="width:85%;">
						<tbody>
					';
					$id =$row['id'];
					$parts_code =$row['parts_code'];
					$kanban =$row['kanban'];
					$serial_no =$row['serial_no'];
					$identification_qr = substr($kanban, 0,3);
					if($identification_qr == 'TC-'){
						$new_iden_qr = 'N';
					}else{
						$new_iden_qr = 'O';
					}
					$kanban_no =$row['kanban_no'];
					$parts_name =$row['parts_name'];
					$request_date_time =$row['request_date_time'];
					$time_trucking = date("H:i:s",strtotime($request_date_time));
					$delivery_time =$row['scan_date_time'];
					$delivery_time_new = date('Y-m-d H:i:s',strtotime('+4 hour',strtotime($delivery_time)));
					$comment = $row['comment'];
					$scooter_station = $row['scooter_station'];
					if ($comment == ''){
						$comment1 = '';
					}else{
						$comment1 = '('.$comment.')';
					}
					
					$sql2 = "SELECT truck_no FROM truck_no WHERE time_from <= '$time_trucking' AND time_to >= '$time_trucking'";
					$result2 = $conn_sql->query($sql2);
					if($result2->num_rows > 0){
						while($row2 = $result2->fetch_assoc()){
							$truck_no = $row2['truck_no'];
						}
					}else{
						$truck_no = 'Undefined';
					}
					$sql3 = "SELECT route_no FROM route_no WHERE scooter_station = '$scooter_station'";
					$result3 = $conn_sql->query($sql3);
					if($result3->num_rows > 0){
						while($row3 = $result3->fetch_assoc()){
							$route_no = $row3['route_no'];
						}
					}else{
						$route_no = 'Undefined';
					}
					$sql4 = "SELECT prod_loc FROM tc_kanban_masterlist WHERE kanban = '$kanban' AND serial_no ='$serial_no'";
					$result4 = $conn_sql->query($sql4);
					if($result4->num_rows > 0){
						while($row4 = $result4->fetch_assoc()){
							$prod_loc = $row4['prod_loc'];
						}
					}else{
						$prod_loc = '';
					}
					
					$page = $page + 1;
					echo'
						<tr>
							<td class="p-0"><span class="font-weight-bold mt-1 ml-2" style="font-size: 18px;"> Location </span><span style="font-size: 18px;" class="font-weight-bold pl-2">4570 : FALP</span></td><td class="p-0"><span class="font-weight-bold ml-2 mt-1" style="font-size: 18px;"> Delivery </span><span style="font-size: 18px;" class="font-weight-bold pl-2">4570 : FALP</span></td><td rowspan="3" class="p-0 m-0 pt-1"><center><div id="qrcodeTable_'.$id.'"></div></center></td><td class="p-0 mx-0 my-0 px-0 py-0" rowspan="9" style="background-color:black;"><center><span style="writing-mode: vertical-rl;text-orientation: sideways-right;" class="h2 mx-0 my-0 text-white">Tube Cutting</span></center></td>
						</tr>
						<tr>
							<td class="p-0 pl-2"><span class="font-weight-bold" style="font-size: 18px;"> Production Lot: </span><span style="font-size: 40px;" class="font-weight-bold">'.$row['production_lot'].'</span></td><td class="p-0 pl-2"><span class="font-weight-bold" style="font-size: 18px;"> Qty: </span><span style="font-size: 40px;" class="font-weight-bold">'.$row['quantity'].'</span></td>
						</tr>
						<tr>
							<td class="p-0 pl-2"><span class="font-weight-bold" style="font-size: 18px;"> Parts Code: </span><span style="font-size: 40px;" class="font-weight-bold">'.$row['parts_code'].'</span></td><td class="p-0 pl-2"><span class="font-weight-bold" style="font-size: 18px;"> Prod Loc: </span><span style="font-size: 40px;" class="font-weight-bold">'.$prod_loc.'</span></td>
						</tr>
						';

						$countChar = strlen($row['line_no']);
						if ($countChar > 15) {
							echo'
						<tr>
							<td colspan="2" class="p-0 pl-2"><span class="font-weight-bold" style="font-size: 13px;"> Line No: </span><span style="font-size: 30px;" class="font-weight-bold">'.$row['line_no'].'</span></td><td class="p-0 pl-2"><span class="font-weight-bold" style="font-size: 18px;"> Station: </span><span style="font-size: 40px;" class="font-weight-bold">'.$row['scooter_station'].'</span></td>
						</tr>';
						}
						else
						{
							echo'
						<tr>
							<td colspan="2" class="p-0 pl-2"><span class="font-weight-bold" style="font-size: 18px;"> Line No: </span><span style="font-size: 40px;" class="font-weight-bold">'.$row['line_no'].'</span></td><td class="p-0 pl-2"><span class="font-weight-bold" style="font-size: 18px;"> Station: </span><span style="font-size: 40px;" class="font-weight-bold">'.$row['scooter_station'].'</span></td>
						</tr>';
						}

						echo'
						
						<tr>
							<td class="p-0 pl-2" colspan="2"><span class="font-weight-bold" style="font-size: 18px;"> Stock Address: </span><span style="font-size: 40px;" class="font-weight-bold">'.$row['stock_address'].'</span></td><td class="p-0 pl-2"><span class="font-weight-bold" style="font-size: 18px;"> Length(mm): </span><span style="font-size: 40px;" class="font-weight-bold">'.$row['length'].'</span></td>
						</tr>';
						if ($comment1 != ''){
							$back_c = "black";
							$text_c = "text-white";
						}else{
							$back_c = "";
							$text_c = "text-black";
						}
						echo'
						<tr>
							<td class="p-0 pl-2 '.$text_c.'" colspan="3" style="background-color:'.$back_c.'"><span class="font-weight-bold" style="font-size: 18px;"> Parts Name: </span><span style="font-size: 40px;" class="font-weight-bold">'.$row['parts_name'].'</span><span style="font-size: 40px;" class="font-weight-bold ml-3">'.$comment1.'</span></td>
						</tr>
						<tr>
							<td class="p-0"><span class="font-weight-bold mt-1 ml-2" style="font-size: 19px;"> Order </span><span style="font-size: 19px;" class="font-weight-bold pl-2">'.$row['scan_date_time'].'</span></td>
							<td class="p-0"><span class="font-weight-bold mt-1 ml-2" style="font-size: 19px;"> Delivery </span><span style="font-size: 19px;" class="font-weight-bold pl-2">'.$delivery_time_new.'</span></td><td class="p-0"><span class="font-weight-bold mt-1 ml-2" style="font-size: 19px;"> Truck </span><span style="font-size: 20px;" class="font-weight-bold pl-22">'.$truck_no.'</span></td>
						</tr>
						<tr>
							<td colspan="2" rowspan="2" class="p0 pt-1"><center><img id="barcodeTable_'.$id.'" class="pt-2 pb-2" style="width:420px; height:70px;"><br><label class="pt-1 font-weight-bold" style="font-size:18px;">'.$row['serial_no'].'</label></center></td><td class="p-0"><span class="font-weight-bold mt-1 ml-2" style="font-size: 18px;"> Route </span><span style="font-size: 22px;" class="font-weight-bold pl-2">'.$route_no.'</span>
						</tr>
						<tr>
							<td class="p-0"><span class="font-weight-bold mt-1 ml-2" style="font-size: 18px;"> No </span><span style="font-size: 40px;" class="font-weight-bold pl-2">'.$kanban_no.'</span> <span style="font-size: 18px;" class="font-weight-bold pr-3 float-right mt-5">'.$page.' '.$new_iden_qr.'</span></td>
						</tr>
						</tbody>
						</table>
					';
					echo'
						<script>
							var kanban = "'.$kanban.'";
							jQuery("#qrcodeTable_'.$id.'").qrcode({
								width:155,height:155,
								// render	: "table",
								text	: kanban
							});	

							JsBarcode("#barcodeTable_'.$id.'", "'.$row['serial_no'].'", {format: "CODE128", displayValue: false});
						</script>
						
					';
				}
			}else{
			}
			//<img src="data:image/png;base64,' . base64_encode($generator->getBarcode(''.$row['serial_no'].'', $generator::TYPE_CODE_128)) . '" class="pt-2 pb-2" style="width:420px; height:70px; ">
			$print_date_time = date("Y-m-d H:i:s");
			$sql = "UPDATE tc_scanned_kanban SET print_date_time='$print_date_time', status='Ongoing Picking' WHERE request_id='$request_id' AND line_no LIKE '$print_category%'";
			if ($conn_sql->query($sql) === TRUE) {
				//echo "Record updated successfully";
			} else {
				echo "Error updating record: " . $conn_sql->error;
			}
		?>
	<script>
	date_time();
	function date_time(){
		var date_time_q = "<?php echo $request_date_time;?>";
		//document.getElementById('req_date_time').innerHTML ='Forwarded to MM: '+ date_time_q;
	}
	
	</script>
<!-- JQuery -->
<script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
<!-- Bootstrap tooltips -->
<script type="text/javascript" src="js/popper.min.js"></script>
<!-- Bootstrap core JavaScript -->
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<!-- MDB core JavaScript -->
<script type="text/javascript" src="js/mdb.min.js"></script>
<!-- My JavaScript for Navigation-->
<script type="text/javascript" src="myjs/nav.js"></script>


<script>
	var printCount ='<?php echo $countID;?>';
	var waiting_time=printCount * 500;
	//alert(waiting_time);
	setTimeout(print_data, waiting_time);
	function print_data(){	
		 window.print();
	}
</script>
</body>
</html>
