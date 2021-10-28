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
	<title>Kanban Printing</title>
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
</head>
<body class="bg">
<?php
	include 'Nav/header_mm.php';
?>
<div class="card_opa ml-0 mr-0">
	<div class="row ml-0 mr-0">
		<div class="col-sm-4 col-md-4 col-lg-4">
		</div>
		<div class="col-sm-4 col-md-4 col-lg-4 text-center mt-1">
			<label class="h3"><i class="fas fa-cogs"></i><i class="fas fa-user-tag"></i>Kanban Printing</label>
		</div>
		<div class="md-form mb-0 col-sm-6">
			<input type="text" id="kanban_scan" class="form-control text-center" autofocus>
			<label for="kanban_scan" id="kanban_scan_label" class="ml-3">Scan Kanban:</label>
			<input type="hidden" id="scanned_kanban">
			<input type="hidden" id="id_scanned_kanban">
			<input type="hidden" id="request_id">
		</div>
		<div class="col-sm-12 col-md-12 col-lg-12 text-center mt-1">
			<label class="h3"><i class="fas fa-list-ul"></i> Kanban List</label>
		</div>
		<div class="col-sm-12 col-md-12 col-lg-12 text-center mt-1">
			<table class="table table-bordered table-sm">
				<thead class="blue-grey lighten-3">
					<tr>
						<th>NO</th>
						<th>Serial No</th>
						<th>Stock Address</th>
						<th>Parts Code</th>
						<th>Parts Name</th>
						<th>Length</th>
						<th>Quantity</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody id="kanban_list">
				</tbody>
			</table>
		</div>
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
<!-- My Realtime Notification-->
<script>
	var kanban_scan = document.getElementById("kanban_scan");
	kanban_scan.addEventListener("keyup", function(event) {
		if (event.keyCode === 13){
			event.preventDefault();
			kanban_read();
		}
	});
</script>
<script>
function kanban_read(){
	var kanban_scan = document.getElementById("kanban_scan").value;
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			var response = this.responseText;
			var split = response.split('~!~');
			document.getElementById('kanban_scan').value="";
			document.getElementById('kanban_list').innerHTML=split[0];
			document.getElementById('request_id').innerHTML=split[1];
		}
	};
	xhttp.open("GET", "AJAX/get_kanban_data_printing.php?operation=get_scan_kanban&&kanban_scan="+kanban_scan, true);
	xhttp.send();
}
function reprint_kanban(x){
	window.open('print_kanban_missing.php?id='+x,'_blank');
}
</script>
</body>
</html>