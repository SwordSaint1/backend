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
	<link rel="shortcut icon" href="Icon/favicon.ico" type="image/ico">
	<link href="Icon/favicon.png" rel="icon">
</head>
<body class="bg">
<?php
	include 'Nav/header.php';
	include 'Modal/route_no.php';
?>
<div class="row ml-0 mr-0 card_opa">
	<div class="col-sm-4 col-md-4 col-lg-4">
	</div>
	<input type="hidden" id="entries_pending">
	<input type="hidden" id="entries_pending_count">
	<div class="col-sm-4 col-md-4 col-lg-4 text-center mt-1">
		<label class="h3"><i class="fas fa-route"></i> List of Route No </label>	
	</div>
	<div class="col-sm-12 col-md-12 col-lg-12">
		<button class="btn btn-info float-right" onclick="add_route_no_button()"><i class="fas fa-plus-circle"></i> Add Route</button>
	</div>
	<div class="row mx-0 col-sm-12 col-md-12 col-lg-12" id="route_no_section">
		<table class="table table-bordered">
			<thead>
				<tr class="blue-grey lighten-3"> 
					<td class="h6">ID</td>
					<td class="h6">Route No</td>
					<td class="h6">Carmaker</td>
					<td class="h6">Scooter Station</td>
				</tr>
				<tbody id="route_no_list">
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

	var xhttp;
	if(window.XMLHttpRequest){
		xhttp = new XMLHttpRequest();
	}else{
		xhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	function get_line_by_scooter_station(){
		var scooter_station = document.getElementById("scooter_station").value;
		xhttp.onreadystatechange = function(){
			if (this.readyState == 4 && this.status == 200) {
				var response = this.responseText;
				document.getElementById("lines_select").innerHTML=response;
			}
		};
		xhttp.open("GET", "AJAX/route_no.php?operation=select_line_no&&scooter_station="+scooter_station, true);
		xhttp.send();
	}
	function select_scooter_station(){
		xhttp.onreadystatechange = function(){
			if (this.readyState == 4 && this.status == 200) {
				var response = this.responseText;
				document.getElementById("scooter_station").innerHTML=response;
			}
		};
		xhttp.open("GET", "AJAX/route_no.php?operation=select_scooter_station", true);
		xhttp.send();
	}
	function select_route_no(){
		select_scooter_station();
		xhttp.onreadystatechange = function(){
			if (this.readyState == 4 && this.status == 200) {
				var response = this.responseText;
				document.getElementById("route_no_list").innerHTML=response;
			}
		};
		xhttp.open("GET", "AJAX/route_no.php?operation=select_route_no", true);
		xhttp.send();
	}
	function save_route_no_button(){
		var route_no = document.getElementById("route_no").value;
		var car_maker = document.getElementById("car_maker").value;
		var scooter_station = document.getElementById("scooter_station").value;
		xhttp.onreadystatechange = function(){
			if (this.readyState == 4 && this.status == 200) {
				var response = this.responseText;
				document.getElementById("out_route_no").innerHTML=response;
				select_route_no();
			}
		};
		xhttp.open("GET", "AJAX/route_no.php?operation=save_route_no&&route_no="+route_no+"&&car_maker="+car_maker+"&&scooter_station="+scooter_station, true);
		xhttp.send();
	}
	function update_route_no_button(){
		var route_no = document.getElementById("route_no").value;
		var car_maker = document.getElementById("car_maker").value;
		var scooter_station = document.getElementById("scooter_station").value;
		var id_hidden = document.getElementById("id_hidden").value;
		xhttp.onreadystatechange = function(){
			if (this.readyState == 4 && this.status == 200) {
				var response = this.responseText;
				document.getElementById("out_route_no").innerHTML=response;
				select_route_no();
			}
		};
		xhttp.open("GET", "AJAX/route_no.php?operation=update_route_no&&route_no="+route_no+"&&car_maker="+car_maker+"&&scooter_station="+scooter_station+"&&id_hidden="+id_hidden, true);
		xhttp.send();
	}
	function delete_route_no_button(){
		var id_hidden = document.getElementById("id_hidden").value;
		xhttp.onreadystatechange = function(){
			if (this.readyState == 4 && this.status == 200) {
				var response = this.responseText;
				document.getElementById("out_route_no").innerHTML=response;
				select_route_no();
			}
		};
		xhttp.open("GET", "AJAX/route_no.php?operation=delete_route_no&&id_hidden="+id_hidden, true);
		xhttp.send();
	}
	function add_route_no_button(){
		select_scooter_station();
		$("#Route_No_Form").modal();
		document.getElementById("update_route_no_button").style.display="none";
		document.getElementById("delete_route_no_button").style.display="none";
		document.getElementById("save_route_no_button").style.display="inline-block";
		document.getElementById('route_no').value="";
		document.getElementById('car_maker').value="";
		document.getElementById('out_route_no').value="";
	}
	function get_this_route_no(x){
		$("#Route_No_Form").modal();
		document.getElementById("update_route_no_button").style.display="inline-block";
		document.getElementById("delete_route_no_button").style.display="inline-block";
		document.getElementById("save_route_no_button").style.display="none";
		document.getElementById("id_hidden").value=x;
		xhttp.onreadystatechange = function(){
			if (this.readyState == 4 && this.status == 200) {
				var response = this.responseText;
				var split = response.split('~!~');
				document.getElementById("route_no").value=split[0];
				document.getElementById("car_maker").value=split[1];
				document.getElementById("scooter_station").value=split[2];
			}
		};
		xhttp.open("GET", "AJAX/route_no.php?operation=select_single_route_no&&id="+x, true);
		xhttp.send();
	}
	function close_modal(){
		$('#Route_No_Form').modal('toggle');
		document.getElementById("out_route_no").innerHTML="";
		document.getElementById("route_no").value="";
		document.getElementById("car_maker").value="";
		document.getElementById("scooter_station").value="";
	}
	select_route_no();
	//select_scooter_station();
</script>
</body>
</html>
