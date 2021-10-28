<?php
	set_time_limit(0);
	session_start();
	$username_session = $_SESSION["username_session"];
	if($username_session == ''){
		header("location:index.php");
	}
	include 'Connection/Connect_sql.php';
	include 'Connection/Connect_oracle.php';
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
	<meta charset="win-1252">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>Printing Kanban</title>
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
	<style>
		@media print{@page {size: landscape}}
		table, tr, td{
			color:black;
			border: 1px solid black;
			border-width: medium;
		}
	</style>
	<script>
		function qrcode_kanban_read(x){
			var id_img = x;
			var xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function(){
				if (this.readyState == 4 && this.status == 200) {
					var response = this.responseText;
					document.getElementById('kanban_read_'+id_img).src='phpqrcode/'+response;
				}
			};
			xhttp.open("GET", "phpqrcode/qrcode_kanban_printing_history.php?data="+id_img, true);
			xhttp.send();
		}
		function qrcode_identity(x){
			var split = x.split('~!~');
				var identity = split[0];
				var id_img = split[1];
			if(identity != ''){
				var identity = identity;
				var xhttp = new XMLHttpRequest();
				xhttp.onreadystatechange = function() {
					if (this.readyState == 4 && this.status == 200) {
						var response = this.responseText;
						document.getElementById('identity_'+id_img).src='phpqrcode/'+response;
					}
				};
				xhttp.open("GET", "phpqrcode/qrcode_identity.php?data="+identity, true);
				xhttp.send();
			}else{
				
			}
		}
	</script>
</head>
<body class="mt-0 mb-0">
	<?php
		//$row_count = 0;
		$id = mysqli_real_escape_string($conn_sql, $_GET['id']);
		$sql2 = "SELECT * FROM tc_history WHERE id='$id'";
		$result2 = $conn_sql->query($sql2);
		if($result2->num_rows > 0){
			while($row2 = $result2->fetch_assoc()){
				$parts_code =$row2['parts_code'];
				$scan_date_time =$row2['scan_date_time'];
				$delivery_time =$row2['scan_date_time'];
				$delivery_time_new = date('Y-m-d H:i:s',strtotime('+2 hour',strtotime($delivery_time)));
				$comment = $row2['comment'];
				if ($comment == ''){
					$comment1 = '';
				}else{
					$comment1 = '('.$comment.')';
				}
					echo'
						<table id="myTable" class="mx-0 my-0" style="width:85%;">
						<tbody>
					';
					echo'
						<script>
							qrcode_kanban_read("'.$row2['id'].'");
						</script>
						<tr>
							<td class="p-0"><span class="font-weight-bold mt-1 ml-2" style="font-size: 18px;"> Location </span><span style="font-size: 18px;" class="font-weight-bold pl-2">4570 : FALP</span></td><td class="p-0"><span class="font-weight-bold ml-2 mt-1" style="font-size: 18px;"> Delivery </span><span style="font-size: 18px;" class="font-weight-bold pl-2">4570 : FALP</span></td><td rowspan="3" class="p-0 m-0 pt-1"><center><img id="kanban_read_'.$row2['id'].'" src="Images/white.png" class="m-0 p-0 pb-1" style="width:155px"></center></td><td class="p-0 mx-0 my-0 px-0 py-0" rowspan="8" style="background-color:black;"><center><span style="writing-mode: vertical-rl;text-orientation: sideways-right;" class="h2 mx-0 my-0 text-white">Tube Cutting</span></center></td>
						</tr>
						<tr>
							<td class="p-0 pl-2"><span class="font-weight-bold" style="font-size: 18px;"> Production Lot: </span><span style="font-size: 40px;" class="font-weight-bold">'.$row2['production_lot'].'</span></td><td class="p-0 pl-2"><span class="font-weight-bold" style="font-size: 18px;"> Station: </span><span style="font-size: 40px;" class="font-weight-bold">N/A</span></td>
						</tr>
						<tr>
							<td colspan="2" class="p-0 pl-2"><span class="font-weight-bold" style="font-size: 18px;"> Parts Code: </span><span style="font-size: 40px;" class="font-weight-bold">'.$row2['parts_code'].'</span></td>
						</tr>
						<tr>
							<td colspan="2" class="p-0 pl-2"><span class="font-weight-bold" style="font-size: 18px;"> Line No: </span><span style="font-size: 40px;" class="font-weight-bold">'.$row2['line_no'].'</span></td><td class="p-0 pl-2"><span class="font-weight-bold" style="font-size: 18px;"> Qty: </span><span style="font-size: 40px;" class="font-weight-bold">'.$row2['quantity'].'</span></td>
						</tr>
						<tr>
							<td class="p-0 pl-2" colspan="2"><span class="font-weight-bold" style="font-size: 18px;"> Stock Address: </span><span style="font-size: 40px;" class="font-weight-bold">'.$row2['stock_address'].'</span></td><td class="p-0 pl-2"><span class="font-weight-bold" style="font-size: 18px;"> Length(mm): </span><span style="font-size: 40px;" class="font-weight-bold">'.$row2['length'].'</span></td>
						</tr>
						<tr>
							<td class="p-0 pl-2" colspan="3"><span class="font-weight-bold" style="font-size: 18px;"> Parts Name: </span><span style="font-size: 40px;" class="font-weight-bold">'.$row2['parts_name'].'</span><span style="font-size: 40px;background-color:black;" class="font-weight-bold ml-2 text-white">'.$comment1.'</span></td>
						</tr>
						<tr>
							<td colspan="2" rowspan="2" class="p0 pt-1"><center><img src="data:image/png;base64,' . base64_encode($generator->getBarcode(''.$row2['serial_no'].'', $generator::TYPE_CODE_128)) . '" class="pt-2 pb-2" style="width:420px; height:100px; "><br><label class="pt-1 font-weight-bold" style="font-size:18px;">'.$row2['serial_no'].'</label></center></td><td class="p-0"><span class="font-weight-bold mt-1 ml-2" style="font-size: 18px;"> Order: </span><span style="font-size: 18px;" class="font-weight-bold pl-2">'.$scan_date_time.'</span>
						</tr>
						<tr>
							<td class="p-0"><span class="font-weight-bold mt-1 ml-2" style="font-size: 18px;"> Delivery: </span><span style="font-size: 18px;" class="font-weight-bold pl-2">'.$delivery_time_new.'</span>
						</tr>
						</tbody>
						</table>
					';
			}
		}else{
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
setTimeout(print_data, 4000);
function print_data(){	
	window.print();
}
</script>
</body>
</html>
