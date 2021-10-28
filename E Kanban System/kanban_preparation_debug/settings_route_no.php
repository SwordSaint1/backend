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
	<title>Route No</title>
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
	<link href="favicon.png" rel="icon">
</head>
<body class="bg">
<?php
	include 'Nav/header.php';
	include 'Modal/route_modal.php';
?>
<div class="row ml-0 mr-0">
	<div class="col-sm-4 col-md-4 col-lg-4">
	</div>
	<input type="hidden" id="entries_pending">
	<input type="hidden" id="entries_pending_count">
	<div class="col-sm-4 col-md-4 col-lg-4 text-center mt-1">
		<label class="h3"><i class="fas fa-route"></i> List of Route No</label>	
	</div>
	<div class="col-sm-12 col-md-12 col-lg-12">
		<button class="btn unique-color white-text float-right" onclick="add_route_button()"><i class="fas fa-plus-circle"></i> Add Route </button>
	</div>
	<div class="row mx-0 col-sm-12 col-md-12 col-lg-12" id="route_section">
		<table class="table table-bordered table-sm">
			<thead>
				<tr class="unique-color white-text"> 
					<td class="h6">No</td>
					<td class="h6">Route Number</td>
					<td class="h6">Scooter Station</td>
					<td class="h6">Carmaker</td>
					<td class="h6">Scooter Station</td>
				</tr>
				<tbody id="route_list">
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
	const select_route =()=>{
		let xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function(){
			if (this.readyState == 4 && this.status == 200) {
				let response = this.responseText;
				document.getElementById("route_list").innerHTML=response;
			}
		};
		xhttp.open("GET", "AJAX/route_no.php?operation=select_route", true);
		xhttp.send();
	}
	const save_route =()=>{
		let route_no = document.getElementById("route_no").value;
		let car_maker = document.getElementById("car_maker").value;
		let scooter_station = document.getElementById("scooter_station").value;
		let xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function(){
			if (this.readyState == 4 && this.status == 200) {
				let response = this.responseText;
				document.getElementById("out_route").innerHTML=response;
				select_route();
			}
		};
		xhttp.open("GET", "AJAX/route_no.php?operation=save_route&&route_no="+route_no+"&&car_maker="+car_maker+"&&scooter_station="+scooter_station, true);
		xhttp.send();
	}
	const add_route_button =()=>{
		$("#Route_Form").modal();
		document.getElementById("update_route_button").style.display="none";
		document.getElementById("delete_route_button").style.display="none";
		document.getElementById("save_route_button").style.display="inline-block";
		document.getElementById('out_route').innerHTML='';
	}
	const get_this_route =(data_param)=>{
		$("#Route_Form").modal();
		let split = data_param.split('~!~');
		document.getElementById("id_hidden").value=split[0];
		document.getElementById("route_no").value=split[1];
		document.getElementById("scooter_station").value=split[2];
		document.getElementById("car_maker").value=split[3];
		document.getElementById("update_route_button").style.display="inline-block";
		document.getElementById("delete_route_button").style.display="inline-block";
		document.getElementById("save_route_button").style.display="none";
	}
	const update_route =()=>{
		let route_no = document.getElementById("route_no").value;
		let car_maker = document.getElementById("car_maker").value;
		let scooter_station = document.getElementById("scooter_station").value;
		let id_hidden = document.getElementById("id_hidden").value;
		let xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function(){
			if (this.readyState == 4 && this.status == 200) {
				let response = this.responseText;
				document.getElementById("out_route").innerHTML=response;
				select_route();
			}
		};
		xhttp.open("GET", "AJAX/route_no.php?operation=update_route&&route_no="+route_no+"&&car_maker="+car_maker+"&&scooter_station="+scooter_station+"&&id_hidden="+id_hidden, true);
		xhttp.send();
	}
	const load_scooter_station =()=>{
		let	xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function(){
			if (this.readyState == 4 && this.status == 200){
				let response = this.responseText;
				document.getElementById("scooter_station").innerHTML=response;
			}
		};
		xhttp.open("GET", "AJAX/route_no.php?operation=load_scooter_station", true);
		xhttp.send();
	}
	const delete_route =()=>{
		let id_hidden = document.getElementById("id_hidden").value;
		let	xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function(){
			if (this.readyState == 4 && this.status == 200) {
				let response = this.responseText;
				document.getElementById("out_route").innerHTML=response;
				select_route();
			}
		};
		xhttp.open("GET", "AJAX/route_no.php?operation=delete_route&&id="+id_hidden, true);
		xhttp.send();
	}
	const close_modal =()=>{
		$('#Route_Form').modal('toggle');
		document.getElementById("route_no").innerHTML="";
		document.getElementById("car_maker").value="";
		document.getElementById("scooter_station").value="";
		document.getElementById("out_route").innerHTML="";
	}
	select_route();
	load_scooter_station();
</script>
</body>
</html>
