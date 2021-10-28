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
	<title>Scooter Station Settings (Tube Cutting)</title>
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
	include 'Modal/scooter_station_modal.php';
?>
<div class="row ml-0 mr-0">
	<div class="col-sm-4 col-md-4 col-lg-4">
	</div>
	<input type="hidden" id="entries_pending">
	<input type="hidden" id="entries_pending_count">
	<div class="col-sm-4 col-md-4 col-lg-4 text-center mt-1">
		<label class="h3"><i class="fas fa-map-marker-alt"></i> List of Scooter Stations </label>	
	</div>
	<div class="col-sm-12 col-md-12 col-lg-12">
		<button class="btn unique-color white-text float-right" onclick="add_station_button()"><i class="fas fa-plus-circle"></i> Add Station</button>
	</div>
	<div class="row mx-0 col-sm-12 col-md-12 col-lg-12" id="scooter_station_section">
		<table class="table table-sm table-bordered">
			<thead>
				<tr class="unique-color white-text"> 
					<td class="h6">ID</td>
					<td class="h6">Scooter Station</td>
					<td class="h6">Ip Address</td>
					<td class="h6">Date Updated</td>
				</tr>
				<tbody id="scooter_station_list">
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
	const select_stations =()=>{
		let xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function(){
			if (this.readyState == 4 && this.status == 200) {
				let response = this.responseText;
				document.getElementById("scooter_station_list").innerHTML=response;
			}
		};
		xhttp.open("GET", "AJAX/scooter_station.php?operation=select_stations", true);
		xhttp.send();
	}
	const save_station =()=>{
		let scooter_area = document.getElementById("name_of_station").value;
		let ip = document.getElementById("ip").value;
		let xhttp = new XMLHttpRequest();
		var let = document.getElementById("ip").value;
		xhttp.onreadystatechange = function(){
			if (this.readyState == 4 && this.status == 200) {
				let response = this.responseText;
				document.getElementById("out_statition").innerHTML=response;
				select_stations();
			}
		};
		xhttp.open("GET", "AJAX/scooter_station.php?operation=save_station&&scooter_area="+scooter_area+"&&ip="+ip, true);
		xhttp.send();
	}
	const add_station_button =()=>{
		$("#Scooter_Station_Form").modal();
		document.getElementById("update_station_button").style.display="none";
		document.getElementById("delete_station_button").style.display="none";
		document.getElementById("save_station_button").style.display="inline-block";
		document.getElementById('scooter_station_modal_head').innerHTML='Add Scooter Station';
		document.getElementById('name_of_station').value="";
		document.getElementById('ip').value="";
	}
	const get_this_station =(data_param)=>{
		$("#Scooter_Station_Form").modal();
		document.getElementById("update_station_button").style.display="inline-block";
		document.getElementById("delete_station_button").style.display="inline-block";
		document.getElementById("save_station_button").style.display="none";
		let split = data_param.split('~!~');
		document.getElementById("id_hidden").value=split[0];
		document.getElementById("name_of_station").value=split[1];
		document.getElementById("ip").value=split[2];
	}
	const update_station =()=>{
		let scooter_area = document.getElementById("name_of_station").value;
		let ip = document.getElementById("ip").value;
		let id_hidden = document.getElementById("id_hidden").value;
		let xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function(){
			if (this.readyState == 4 && this.status == 200) {
				let response = this.responseText;
				document.getElementById("out_statition").innerHTML=response;
				select_stations();
			}
		};
		xhttp.open("GET", "AJAX/scooter_station.php?operation=update_station&&scooter_area="+scooter_area+"&&ip="+ip+"&&id="+id_hidden, true);
		xhttp.send();
	}
	const delete_station =()=>{
		let id_hidden = document.getElementById("id_hidden").value;
		let xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function(){
			if (this.readyState == 4 && this.status == 200) {
				let response = this.responseText;
				document.getElementById("out_statition").innerHTML=response;
				select_stations();
			}
		};
		xhttp.open("GET", "AJAX/scooter_station.php?operation=delete_station&&id="+id_hidden, true);
		xhttp.send();
	}
	const close_modal =()=>{
		$('#Scooter_Station_Form').modal('toggle');
		document.getElementById("out_statition").innerHTML="";
		document.getElementById("name_of_station").value="";
		document.getElementById("ip").value="";
	}
	select_stations();
</script>
</body>
</html>
