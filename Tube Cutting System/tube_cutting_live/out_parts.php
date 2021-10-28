<?php
	session_start();
	$username_session = $_SESSION["username_session"];
	if($username_session == ''){
		header("location:index.php");
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>Store Out Parts</title>
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
	<link href="mycss/pulse.css" rel="stylesheet">
	<!-- My CSS -->
	<link href="mycss/style1.css" rel="stylesheet">
	<link rel="shortcut icon" href="favicon.ico" type="image/ico">
	<link href="favicon.png" rel="icon">
	<style>
		.tb{
			color:black;
			border: 1px solid black;
			border-width: small;
		}
	</style>
</head>
<body class="bg">
<?php
	include 'Nav/header_out.php';
	
?>
<?php
include('phpbarcode/src/BarcodeGenerator.php');
include('phpbarcode/src/BarcodeGeneratorPNG.php');
include('phpbarcode/src/BarcodeGeneratorSVG.php');
include('phpbarcode/src/BarcodeGeneratorJPG.php');
include('phpbarcode/src/BarcodeGeneratorHTML.php');
include 'Modal/news_windows.php';
$generator = new \Picqer\Barcode\BarcodeGeneratorPNG();
?>
<div class="card_opa ml-0 mr-0">
	<div class="row ml-0 mr-0">
		<div class="col-sm-4 col-md-4 col-lg-4">
		</div>
		<div class="col-sm-4 col-md-4 col-lg-4 text-center mt-1">
			<label class="h3 mt-1"><i class="fas fa-truck-loading"></i> Store Out Parts</label>
		</div>
		
		<div class="col-sm-12 col-md-12 col-lg-12 row">
			<div class="md-form mb-0 col-sm-5">
				<input type="text" id="kanban_scan_ready_delivery" class="form-control text-center" autofocus>
				<label for="kanban_scan_ready_delivery" id="kanban_scan_ready_delivery_label" class="ml-3">Scan Kanban:</label>
			</div>
			<div class="col-sm-5 text-center text-success" id="output_out">
			</div>
		</div>

	</div>
	<div class="col-sm-12 col-md-12 col-lg-12 text-center">
		<label class="h4 mt-1"><i class="fas fa-check"></i> Store Out Parts</label>
		<!-- SELECT LINE -->
		<div class="md-form mb-0 col-sm-3">
			<select name="" class="custom-select form-control" id="line_select" onchange="display_all()">
				<!-- LINE NUMBER LOAD HERE -->
			</select>
		</div>

	</div>
	<div class="mx-0 col-sm-12 col-md-12 col-lg-12">
		<table class="table table-bordered table-sm">
			<thead class="blue-grey lighten-3">
				<tr>
					<th class="h6">No</th>
					<th class="h6">Serial No</th>
					<th class="h6">Stock Address</th>
					<th class="h6">Line No.</th>
					<th class="h6">Parts Code</th>
					<th class="h6">Parts Name</th>
					<th class="h6">Comment</th>
					<th class="h6">Length</th>
					<th class="h6">Quantity</th>
					<th class="h6">Kanban No</th>
					<th class="h6">Store Out Date & Time</th>
					<th class="h6">Master Identification</th>
				</tr>
			</thead>
			<tbody id="out_parts">
			</tbody>
		</table>
	</div>
</div>
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
<!-- My JacaScript of News-->
<!--script type="text/javascript" src="myjs/news_window.js"></script-->
<script>
	var kanban_scan_ready_delivery = document.getElementById("kanban_scan_ready_delivery");
	kanban_scan_ready_delivery.addEventListener("keyup", function(event) {
		if (event.keyCode === 13){
			event.preventDefault();
			var kanban_scan_ready_delivery = document.getElementById('kanban_scan_ready_delivery').value;
			document.getElementById('output_out').innerHTML='<label class="h5 mt-4 text-success"></label>';
			kanban_scan_ready_delivery_action(kanban_scan_ready_delivery);
		}
	});
</script>
<script>
display_all();
line_all();
function kanban_scan_ready_delivery_action(kanban_scan_ready_delivery){
	document.getElementById("kanban_scan_ready_delivery").value='';
	var kanban_scan_ready_delivery = kanban_scan_ready_delivery;
	var username_session ="<?php echo $username_session;?>";
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			var response = this.responseText;
			if (response == 'Succesfully Store Out'){
				var audio= new Audio('Voice/SuccessfullyStoreOut.mp3');
				audio.play();
				document.getElementById('output_out').innerHTML='<label class="h5 mt-4 text-success">Successfully Store Out!</label>';
				display_all();
			}else if(response == 'This Kanban Is Not Requested'){
				var audio= new Audio('Voice/ThisKanbanIsNotRequested.mp3');
				audio.play();
				document.getElementById('output_out').innerHTML='<label class="h5 mt-4 text-danger">Error: This Kanban Is Not Requested!</label>';
			}else{
				var audio= new Audio('Voice/Attention.mp3');
				audio.play();
				document.getElementById('output_out').innerHTML= `<label class="h5 mt-4 text-danger"> ${response} </label>`;
			}
			//document.getElementById("kanban_scan_ready_delivery").value='';
		}
	};
	xhttp.open("GET", "AJAX/update_ready_delivery.php?operation=update_ready_for_delivery&&kanban_scan_ready_delivery="+kanban_scan_ready_delivery+"&&username_session="+username_session, true);
	xhttp.send();
}
function display_all(){
	var line = document.querySelector('#line_select').value;
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			var response = this.responseText;
			document.getElementById('out_parts').innerHTML=response;
		}
	};
	xhttp.open("GET", "AJAX/history_admin.php?operation=store_out_today&&kanban_scan_ready_delivery="+kanban_scan_ready_delivery+"&&line_no="+line, true);
	xhttp.send();
}

function line_all(){
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			var response = this.responseText;
			document.getElementById('line_select').innerHTML = response;
		}
	};
	xhttp.open("GET","AJAX/history_admin.php?operation=load_line",true);
	xhttp.send();
}
</script>
</body>
</html>
