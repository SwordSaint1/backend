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
	<title>Request Parts</title>
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
			border-width: medium;}
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
			xhttp.open("GET", "phpqrcode/qrcode_kanban_printing.php?data="+id_img, true);
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
		$request_id = mysqli_real_escape_string($conn_sql, $_GET['request_id']);
		$sql2 = "SELECT * FROM kanban_printing WHERE request_id='$request_id'";
		$result2 = $conn_sql->query($sql2);
		if($result2->num_rows > 0){
			while($row2 = $result2->fetch_assoc()){
				$kanban_read = $row2['kanban_read'];
				$date_print = $row2['date_print'];
				$query = oci_parse($conn_oracle, "SELECT KANBAN_READ, C_BHNSZINAM, C_BHNSZICOD, C_LINENUM, C_LOCCOD, C_SYKBSYCOD, L_MINLOTSUU, L_KNBNUM FROM FSIB.T_ZAIKNBHRIIPTZAN_RUISEKI WHERE KANBAN_READ LIKE '%$kanban_read%' AND ROWNUM <= 1");
				oci_execute($query);
				while($row=oci_fetch_assoc($query)){
					$kanban_num = $row['L_KNBNUM'];
					$kanban = $row['KANBAN_READ'];
					$parts_name = $row['C_BHNSZINAM'];
					$parts_code = $row['C_BHNSZICOD'];
					$line_no = $row['C_LINENUM'];
					$location = $row['C_LOCCOD'];
					$delivery = $row['C_SYKBSYCOD'];
					$quantity = $row['L_MINLOTSUU'];
					$scan_date_time = date("Y-m-d H:i:s");
					$supplier_name = '';
					$query1 = oci_parse($conn_oracle, "SELECT C_BHNSZICOD, C_BHNSZINAM, C_KNYSAKBHNNAM FROM FSIB.T_ZAINAIJIDAT WHERE C_BHNSZICOD = '$parts_code' AND C_BHNSZINAM = '$parts_name'AND ROWNUM <= 1");
					oci_execute($query1);
					while($row1=oci_fetch_assoc($query1)){
						$supplier_name = $row1['C_KNYSAKBHNNAM'];
					}
					echo'
						<table id="myTable" class="table table-bordered table-sm mx-0 my-0" style="width:85%;">
						<tbody>
					';
					$supplier_name = $supplier_name;
					if($supplier_name != ''){
						$supplier_name = $supplier_name;
					}else{
						$supplier_name = "No Supplier Name";
					}
					$parts_code =$parts_code;
					$parts_name =$parts_name;
					$request_date_time =$date_print;
					$delivery_time =$date_print;
					$delivery_time_new = date('Y-m-d H:i:s',strtotime('+2 hour',strtotime($delivery_time)));
					$sql1 = "SELECT identification_code, parts_code, parts_name FROM identification_code WHERE parts_code='$parts_code' AND parts_name='$parts_name' ";
					$result1 = $conn_sql->query($sql1);
					if($result1->num_rows > 0){
						while($row1 = $result1->fetch_assoc()){
							$identity_code = $row1['identification_code'];
						}
					}else{
						$identity_code = '';
					}
					$sql1 = "SELECT stock_address, parts_code, parts_name FROM stock_address WHERE parts_code='$parts_code' AND parts_name='$parts_name' ";
					$result1 = $conn_sql->query($sql1);
					if($result1->num_rows > 0){
						while($row1 = $result1->fetch_assoc()){
							$stock_address = $row1['stock_address'];
						}
					}else{
						$stock_address = '';
					}
					//$row_count = $row_count + 1;
					echo'
						<script>
							qrcode_kanban_read("'.$request_id.'");
							qrcode_identity("'.$identity_code.'~!~'.$request_id.'");
						</script>
						<tr>
							<td class="p-0">
								<span class="font-weight-bold mt-1 ml-2" style="font-size: 18px;"> Location </span>
								<span style="font-size: 18px;" class="font-weight-bold pl-2">'.$location.' : FALP</span>
							</td>
							<td class="p-0">
								<span class="font-weight-bold ml-2 mt-1" style="font-size: 18px;"> Delivery </span>
								<span style="font-size: 18px;" class="font-weight-bold pl-2">'.$delivery.' : FALP</span>
							</td>
							<td rowspan="3" class="p-0 m-0 pt-1">
								<center>
									<img id="kanban_read_'.$request_id.'" src="Images/white.png" class="m-0 p-0 pb-1" style="width:155px">
								</center>
							</td>
						</tr>
						<tr>
							<td colspan="2" class="p-0 pl-2">
								<span class="font-weight-bold" style="font-size: 18px;"> Parts Name: </span>
								<span style="font-size: 40px;" class="font-weight-bold">'.$parts_name.'</span>
							</td>
						</tr>
						<tr>
							<td colspan="2" class="p-0 pl-2">
								<span class="font-weight-bold" style="font-size: 18px;"> Parts Code: </span>
								<span style="font-size: 40px;" class="font-weight-bold">'.$parts_code.'</span>
							</td>
						</tr>
						<tr>
							<td colspan="3" class="p-0 pl-2">
								<span class="font-weight-bold" style="font-size: 18px;"> Supplier`s Name: </span>
								<span style="font-size: 40px;" class="font-weight-bold">'.$supplier_name.'</span>
							</td>
						</tr>
						<tr>
							<td class="p-0 pl-2">
								<span class="font-weight-bold" style="font-size: 18px;"> Quantity: </span>
								<span style="font-size: 40px;" class="font-weight-bold">'.$quantity.'</span>
							</td>
							<td class="p-0 pl-2">
								<span class="font-weight-bold" style="font-size: 18px;"> Stock Address: </span>
								<span style="font-size: 40px;" class="font-weight-bold">'.$stock_address.'</span>
							</td>
							<td>
								<span class="font-weight-bold" style="font-size: 18px;">Station: </span>
								<span style="font-size: 40px;" class="font-weight-bold"></span>
							</td>
						</tr>
						<tr>
							<td rowspan="3" class="p-0">
								<center><img src="Images/white.png" class="pt-4 m-0 p-0" width="180px" id="identity_'.$request_id.'"></center>
							</td>
							<td class="p-0 pl-2">
								<span class="font-weight-bold" style="font-size: 18px;"> Order Date: </span>
								<span style="font-size: 18px;" class="font-weight-bold pl-2">'.$scan_date_time.'</span>
							</td>
							<td rowspan="2">
								<span class="font-weight-bold" style="font-size: 18px;">Line: </span>
								<span style="font-size: 40px;" class="font-weight-bold">'.$line_no.'</span>
							</td>
						</tr>
						<tr>
							<td class="p-0 pl-2">
								<span class="font-weight-bold" style="font-size: 18px;"> Delivery Date: </span>
								<span style="font-size: 18px;" class="font-weight-bold pl-2">'.$delivery_time_new.'</span>
							</td>
						</tr>
						<tr>
							<td colspan="2" class="p0 pt-1">
								<center>
									<img src="data:image/png;base64,' . base64_encode($generator->getBarcode(''.$parts_name.'', $generator::TYPE_CODE_128)) . '" class="pt-2 pb-2" style="width:500px; height:100px; ">
									<br>
									<label class="pt-1 font-weight-bold" style="font-size:18px;">'.$parts_name.'</label>
								</center>
							</td>
						</tr>
						</tbody>
						</table>
					';
				}
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
