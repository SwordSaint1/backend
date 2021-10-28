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
	<title>Truck Number</title>
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
</head>
<body class="bg">
<?php
	include 'Nav/header.php';
	include 'Modal/truck_no.php';
?>
<div class="row ml-0 mr-0">
	<div class="col-sm-4 col-md-4 col-lg-4">
	</div>
	<input type="hidden" id="entries_pending">
	<input type="hidden" id="entries_pending_count">
	<div class="col-sm-4 col-md-4 col-lg-4 text-center mt-1">
		<label class="h3"><i class="fas fa-truck-moving"></i> List of Truck No </label>	
	</div>
	<div class="col-sm-12 col-md-12 col-lg-12">
		<button class="btn unique-color white-text float-right" onclick="add_truck_no_button()"><i class="fas fa-plus-circle"></i> Add Truck No </button>
	</div>
	<div class="row mx-0 col-sm-12 col-md-12 col-lg-12" id="distributor_section">
		<table class="table table-bordered table-sm">
			<thead>
				<tr class="unique-color white-text"> 
					<td class="h6">NO</td>
					<td class="h6">Truck No</td>
					<td class="h6">From</td>
					<td class="h6">To</td>
					<td class="h6">Date Updated</td>
				</tr>
				<tbody id="truck_list">
				</tbody>
			</thead>
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
<script>
	const select_truck_no =()=>{
		let xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function(){
			if (this.readyState == 4 && this.status == 200) {
				let response = this.responseText;
				document.getElementById("truck_list").innerHTML=response;
			}
		};
		xhttp.open("GET", "AJAX/truck_no.php?operation=select_truck", true);
		xhttp.send();
	}
	const save_truck =()=>{
		let truck_no = document.getElementById("truck_no").value;
		let time_from = document.getElementById("time_from").value;
		let time_to = document.getElementById("time_to").value;
		let xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function(){
			if (this.readyState == 4 && this.status == 200) {
				let response = this.responseText;
				document.getElementById("out_truck").innerHTML=response;
				select_truck_no();
			}
		};
		xhttp.open("GET", "AJAX/truck_no.php?operation=save_truck&&truck_no="+truck_no+"&&time_from="+time_from+"&&time_to="+time_to, true);
		xhttp.send();
	}
	const add_truck_no_button =()=>{
		$("#Truck_Form").modal();
		document.getElementById("update_truck_button").style.display="none";
		document.getElementById("delete_truck_button").style.display="none";
		document.getElementById("save_truck_button").style.display="inline-block";
		document.getElementById('truck_no').value='';
		document.getElementById('time_from').value='';
		document.getElementById('time_from').value='';
		document.getElementById('out_truck').innerHTML='';
	}
	const get_this_truck =(data_param)=>{
		$("#Truck_Form").modal();
		let split = data_param.split('~!~');
		document.getElementById("id_hidden").value=split[0];
		document.getElementById("truck_no").value=split[1];
		document.getElementById("time_from").value=split[2];
		document.getElementById("time_to").value=split[3];
		document.getElementById("update_truck_button").style.display="inline-block";
		document.getElementById("delete_truck_button").style.display="inline-block";
		document.getElementById("save_truck_button").style.display="none";
	}
	const update_truck =()=>{
		let truck_no = document.getElementById("truck_no").value;
		let time_from = document.getElementById("time_from").value;
		let time_to = document.getElementById("time_to").value;
		let id_hidden = document.getElementById("id_hidden").value;
		let xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function(){
			if (this.readyState == 4 && this.status == 200) {
				let response = this.responseText;
				document.getElementById("out_truck").innerHTML=response;
				select_truck_no();
			}
		};
		xhttp.open("GET", "AJAX/truck_no.php?operation=update_truck&&truck_no="+truck_no+"&&time_from="+time_from+"&&time_to="+time_to+"&&id_hidden="+id_hidden, true);
		xhttp.send();
	}
	const delete_truck =()=>{
		let id_hidden = document.getElementById("id_hidden").value;
		let	xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function(){
			if (this.readyState == 4 && this.status == 200) {
				let response = this.responseText;
				document.getElementById("out_truck").innerHTML=response;
				select_truck_no();
			}
		};
		xhttp.open("GET", "AJAX/truck_no.php?operation=delete_truck&&id_hidden="+id_hidden, true);
		xhttp.send();
	}
	const close_modal =()=>{
		$('#Truck_Form').modal('toggle');
		document.getElementById("out_truck").innerHTML="";
		document.getElementById("truck_no").value="";
		document.getElementById("time_from").value="";
		document.getElementById("time_to").value="";
	}
	select_truck_no();
</script>
</body>
</html>
