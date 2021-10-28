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
	<title>Truck No</title>
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
	include 'Modal/truck_no.php';
?>
<div class="row ml-0 mr-0 card_opa">
	<div class="col-sm-4 col-md-4 col-lg-4">
	</div>
	<input type="hidden" id="entries_pending">
	<input type="hidden" id="entries_pending_count">
	<div class="col-sm-4 col-md-4 col-lg-4 text-center mt-1">
		<label class="h3"><i class="fas fa-truck"></i> List of Truck No </label>	
	</div>
	<div class="col-sm-12 col-md-12 col-lg-12">
		<button class="btn btn-info float-right" onclick="add_truck_no_button()"><i class="fas fa-plus-circle"></i> Add Truck</button>
	</div>
	<div class="row mx-0 col-sm-12 col-md-12 col-lg-12" id="scooter_station_section">
		<table class="table table-bordered">
			<thead>
				<tr class="blue-grey lighten-3"> 
					<td class="h6">ID</td>
					<td class="h6">Truck No</td>
					<td class="h6">Time From</td>
					<td class="h6">Time To</td>
				</tr>
				<tbody id="truck_no_list">
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
	function select_truck_no(){
		xhttp.onreadystatechange = function(){
			if (this.readyState == 4 && this.status == 200) {
				var response = this.responseText;
				document.getElementById("truck_no_list").innerHTML=response;
			}
		};
		xhttp.open("GET", "AJAX/truck_no.php?operation=select_truck_no", true);
		xhttp.send();
	}
	function save_truck_no_button(){
		var truck_no = document.getElementById("truck_no").value;
		var time_from = document.getElementById("time_from").value;
		var time_to = document.getElementById("time_to").value;
		xhttp.onreadystatechange = function(){
			if (this.readyState == 4 && this.status == 200) {
				var response = this.responseText;
				document.getElementById("out_truck_no").innerHTML=response;
				select_truck_no();
			}
		};
		xhttp.open("GET", "AJAX/truck_no.php?operation=save_truck_no&&truck_no="+truck_no+"&&time_from="+time_from+"&&time_to="+time_to, true);
		xhttp.send();
	}
	function update_truck_no_button(){
		var truck_no = document.getElementById("truck_no").value;
		var time_from = document.getElementById("time_from").value;
		var time_to = document.getElementById("time_to").value;
		var id_hidden = document.getElementById("id_hidden").value;
		xhttp.onreadystatechange = function(){
			if (this.readyState == 4 && this.status == 200) {
				var response = this.responseText;
				document.getElementById("out_truck_no").innerHTML=response;
				select_truck_no();
			}
		};
		xhttp.open("GET", "AJAX/truck_no.php?operation=update_truck_no&&truck_no="+truck_no+"&&time_from="+time_from+"&&time_to="+time_to+"&&id_hidden="+id_hidden, true);
		xhttp.send();
	}
	function delete_truck_no_button(){
		var id_hidden = document.getElementById("id_hidden").value;
		xhttp.onreadystatechange = function(){
			if (this.readyState == 4 && this.status == 200) {
				var response = this.responseText;
				document.getElementById("out_truck_no").innerHTML=response;
				select_truck_no();
			}
		};
		xhttp.open("GET", "AJAX/truck_no.php?operation=delete_truck_no&&id_hidden="+id_hidden, true);
		xhttp.send();
	}
	function add_truck_no_button(){
		$("#Truck_No_Form").modal();
		document.getElementById("update_truck_no_button").style.display="none";
		document.getElementById("delete_truck_no_button").style.display="none";
		document.getElementById("save_truck_no_button").style.display="inline-block";
		document.getElementById('truck_no').value="";
		document.getElementById('time_from').value="";
		document.getElementById('time_to').value="";
	}
	function get_this_truck_no(x){
		$("#Truck_No_Form").modal();
		document.getElementById("update_truck_no_button").style.display="inline-block";
		document.getElementById("delete_truck_no_button").style.display="inline-block";
		document.getElementById("save_truck_no_button").style.display="none";
		document.getElementById("id_hidden").value=x;
		xhttp.onreadystatechange = function(){
			if (this.readyState == 4 && this.status == 200) {
				var response = this.responseText;
				var split = response.split('~!~');
				document.getElementById("truck_no").value=split[0];
				document.getElementById("time_from").value=split[1];
				document.getElementById("time_to").value=split[2];
			}
		};
		xhttp.open("GET", "AJAX/truck_no.php?operation=select_single_truck_no&&truck_id="+x, true);
		xhttp.send();
	}
	function close_modal(){
		$('#Truck_No_Form').modal('toggle');
		document.getElementById("out_truck_no").innerHTML="";
		document.getElementById("truck_no").value="";
		document.getElementById("time_from").value="";
		document.getElementById("time_to").value="";
	}
	select_truck_no();
</script>
</body>
</html>
