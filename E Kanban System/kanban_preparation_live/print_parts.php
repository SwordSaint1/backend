<?php
	set_time_limit(0);
	session_start();
	$username_session = $_SESSION["username_session"];
	if($username_session == ''){
		header("location:index.php");
	}
	require_once 'Connection/ConnectSqlsrv.php';
?>
<?php
include('phpbarcode/src/BarcodeGenerator.php');
include('phpbarcode/src/BarcodeGeneratorPNG.php');
include('phpbarcode/src/BarcodeGeneratorSVG.php');
include('phpbarcode/src/BarcodeGeneratorJPG.php');
include('phpbarcode/src/BarcodeGeneratorHTML.php');
$generator = new \Picqer\Barcode\BarcodeGeneratorPNG();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
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
		$page_num = 0;
		$id_scanned_kanban = $_GET['id_scanned_kanban'];
		$print_category = $_GET['print_category'];
		$sql = "SELECT * FROM mm_scanned_kanban WHERE id_scanned_kanban='$id_scanned_kanban' AND line_no LIKE '$print_category%' ORDER BY line_no ASC, stock_address ASC , parts_code ASC";
		$stmt = sqlsrv_query($conn_sqlsrv, $sql);
		$row = sqlsrv_has_rows($stmt);
		if ($row === true){
			while($rows = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){
				$page_num = $page_num + 1;
				echo'
					<table id="myTable'.$page_num.'" class="mx-0 my-0" style="width:85%;">
					<tbody id="body'.$page_num.'">
				';
				$id =$rows['id'];
				$kanban =$rows['kanban'];
				$location =$rows['location'];
				$delivery =$rows['delivery'];
				$line_no =$rows['line_no'];
				$stock_address =$rows['stock_address'];
				$supplier_name =$rows['supplier_name'];
				$parts_code =$rows['parts_code'];
				$parts_name =$rows['parts_name'];
				$quantity =$rows['quantity'];
				$kanban_num =$rows['kanban_num'];
				$scooter_station =$rows['scooter_station'];
				$scan_date_time =date_format($rows['scan_date_time'],"Y-m-d H:i:s");
				$request_date_time =date_format($rows['request_date_time'],"Y-m-d H:i:s");
				$time_trucking = date("H:i:s",strtotime($request_date_time));
				$delivery_time_new = date('Y-m-d H:i:s',strtotime('+4 hour',strtotime($scan_date_time)));
				$requested_by =$rows['requested_by'];
				$selector_ip =$rows['selector_ip'];
				$selection_date_time = $rows['selection_date_time'];
				if($selection_date_time != NULL){ 
					$selection_date_time =date_format($selection_date_time,"Y-m-d H:i:s");
				}else{
					$selection_date_time = NULL;
				}

				//Generation of New Kanban Read
				$default_character = 'F1101';
				$generated_location = $location;
				$generated_delivery = $delivery;
				$generated_parts_code = str_pad($parts_code, 20, " ", STR_PAD_RIGHT);
				$generated_kanban_num = str_pad($kanban_num, 4, "0", STR_PAD_LEFT);
				$generated_line_no = str_pad($line_no, 10, " ", STR_PAD_RIGHT);
				$generated_whitespace = str_pad('', 53, " ", STR_PAD_LEFT);
				$generated_kanban_read = $default_character.''.$generated_location.''.$generated_delivery.''.$generated_parts_code.''.$generated_kanban_num.''.$generated_line_no.''.$generated_whitespace;
			
				//Checking the Truck No
				$sql1 = "SELECT truck_no FROM mm_truck_no WHERE time_from <= '$time_trucking' AND time_to >= '$time_trucking'";
				$stmt1 = sqlsrv_query($conn_sqlsrv, $sql1);
				$row1 = sqlsrv_has_rows($stmt1);
				if ($row1 === true){
					while($rows1 = sqlsrv_fetch_array($stmt1, SQLSRV_FETCH_ASSOC)){
						$truck_no = $rows1['truck_no'];
					}
				}else{
					$truck_no = 'Undefined';
				}
				//Checking the Route No
				$sql2 = "SELECT route_no FROM mm_route_no WHERE scooter_station = '$scooter_station'";
				$stmt2 = sqlsrv_query($conn_sqlsrv, $sql2);
				$row2 = sqlsrv_has_rows($stmt2);
				if ($row2 === true){
					while($rows2 = sqlsrv_fetch_array($stmt2, SQLSRV_FETCH_ASSOC)){
						$route_no = $rows2['route_no'];
					}
				}else{
					$route_no = 'Undefined';
				}
				//Designing Printed Kanban
				echo'
					<tr>
						<td rowspan="4" class="p-0 m-0 pt-1"><center><div id="qrcodeTable_'.$id.'"></div></center></td><td class="p-0"><span class="font-weight-bold mt-1 ml-2" style="font-size: 18px;"> Location </span><span style="font-size: 18px;" class="font-weight-bold pl-2">'.$location.' : FALP</span></td><td class="p-0"><span class="font-weight-bold ml-2 mt-1" style="font-size: 18px;"> Delivery </span><span style="font-size: 18px;" class="font-weight-bold pl-2">'.$delivery.' : FALP</span></td>
					</tr>
					<tr>
						<td colspan="2" class="p-0 pl-2"><span class="font-weight-bold" style="font-size: 18px;"> Parts Name: </span><span style="font-size: 40px;" class="font-weight-bold">'.$parts_name.'</span></td>
					</tr>
					<tr>
						<td colspan="2" class="p-0 pl-2"><span class="font-weight-bold" style="font-size: 18px;"> Parts Code: </span><span style="font-size: 40px;" class="font-weight-bold">'.$parts_code.'</span></td>
					</tr>
					<tr>
						<td colspan="2" class="p-0 pl-2"><span class="font-weight-bold" style="font-size: 18px;"> Stock Address: </span><span style="font-size: 40px;" class="font-weight-bold">'.$stock_address.'</span></td>
					</tr>
					<tr>
						<td colspan="3" class="p-0 pl-2"><span class="font-weight-bold" style="font-size: 18px;"> Supplier`s Name: </span><span style="font-size: 40px;" class="font-weight-bold">'.$supplier_name.'</span></td>
					</tr>
					<tr>
						<td class="p-0 pl-2"><span class="font-weight-bold" style="font-size: 18px;"> Quantity: </span><span style="font-size: 40px;" class="font-weight-bold">'.$quantity.'</span></td>
						<td class="p-0 pl-2" colspan="2"><span class="font-weight-bold" style="font-size: 18px;">Line: </span><span style="font-size: 40px;" class="font-weight-bold">'.$line_no.'</span></td>
					</tr>
					<tr>
						<td class="p-0 pl-2"><span class="font-weight-bold" style="font-size: 18px;"> Order: </span><span style="font-size: 18px;" class="font-weight-bold pl-2">'.$request_date_time.'</span></td><td rowspan="2"><span class="font-weight-bold" style="font-size: 18px;">Station: </span><span style="font-size: 40px;" class="font-weight-bold">'.$scooter_station.'</span></td><td rowspan="4" class="p-0 pt-1 pb-1"><center><div id="qrcodeTable2_'.$id.'"></div></center></td>
					</tr>
					<tr>
						<td class="p-0 pl-2"><span class="font-weight-bold" style="font-size: 18px;"> Delivery: </span><span style="font-size: 18px;" class="font-weight-bold pl-2">'.$delivery_time_new.'</span></td>
					</tr>
					<tr>
						<td class="p-0 pl-2"><span class="font-weight-bold" style="font-size: 18px;">Truck No.:</span><span style="font-size: 18px;" class="font-weight-bold pl-2">'.$truck_no.'</span></td>
						<td rowspan="2" class="p-0 pl-2 pt-0 pb-0"><span class="font-weight-bold" style="font-size: 18px;"> Kanban No.: </span><span style="font-size: 40px;" class="font-weight-bold pl-2">'.$kanban_num.'</span><br><span style="font-size: 18px;" class="font-weight-bold pull-bottom pr-2 float-right">'.$page_num.'</span></td>
					</tr>
					<tr>
						<td class="p-0 pl-2"><span class="font-weight-bold" style="font-size: 18px;">Route No.:</span><span style="font-size: 18px;" class="font-weight-bold pl-2">'.$route_no.'</span></td>
					</tr>
					</tbody>
					</table>
				';
				echo'
				<script>
					var kanban_read = "'.$generated_kanban_read.'";
					var kanban_read = kanban_read.substring(0, 100);
					jQuery("#qrcodeTable_'.$id.'").qrcode({
						width:200,height:200,
						// render	: "table",
						text	: kanban_read
					});	
					
					var supplier_name = "'.$supplier_name.'";
					jQuery("#qrcodeTable2_'.$id.'").qrcode({
						width:155,height:155,
						// render	: "table",
						text	: supplier_name
					});	
					
				</script>
				
				';
				$style="font-size: 40px;";
				$print_date_time = date("Y-m-d H:i:s");
				$sql3 = "INSERT INTO mm_ongoing_picking (id_scanned_kanban, kanban, location, delivery, line_no, stock_address, supplier_name, parts_code, parts_name, quantity, kanban_num, scooter_station, scan_date_time, request_date_time, requested_by, print_date_time, selector_ip, selection_date_time, status) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
				$params3 = array($id_scanned_kanban, $kanban, $location, $delivery, $line_no, $stock_address, $supplier_name, $parts_code, $parts_name, $quantity, $kanban_num, $scooter_station, $scan_date_time, $request_date_time, $requested_by, $print_date_time, $selector_ip, $selection_date_time, 'Ongoing Picking');
				$stmt3 = sqlsrv_query($conn_sqlsrv, $sql3, $params3);
				if($stmt3 === false){
					die( print_r( sqlsrv_errors(), true));
				}else{
					$sql4 = "DELETE FROM mm_scanned_kanban WHERE id_scanned_kanban = ? AND kanban=? AND status=?";
					$params4 = array($id_scanned_kanban, $kanban, 'Pending');
					$stmt4 = sqlsrv_query($conn_sqlsrv, $sql4, $params4);
					if($stmt4 === false ) {
						die( print_r( sqlsrv_errors(), true));
					}else{
					}
				}
			}
		}
		sqlsrv_free_stmt($stmt);
		sqlsrv_close($conn_sqlsrv);

	?>
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
	check_for_printing();
	function check_for_printing(){
		var page_num ='<?php echo $page_num;?>';
		var last_kanban = document.getElementById('body'+page_num).innerHTML;
		if (last_kanban != ''){
			console.log('has '+page_num);
			setTimeout(print_data, 2000);
		}else{
			console.log('none '+page_num);
			setTimeout(check_for_printing, 2000);
		}
	}
	function print_data(){	
		window.print();
	}

	//alert(last_kanban);
	// var printCount = 2;
	// var waiting_time=printCount * 500;
	// //alert(waiting_time);
	// setTimeout(print_data, waiting_time);
	// function print_data(){	
	// 	 window.print();
	// }
</script>
</body>
</html>
