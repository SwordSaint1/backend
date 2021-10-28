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
	<title>Settings Stock Address</title>
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
	include 'Modal/stock_address.php';
?>
<div class="row ml-0 mr-0 card_opa">
	<div class="col-sm-4 col-md-4 col-lg-4">
	</div>
	<input type="hidden" id="entries_pending">
	<input type="hidden" id="entries_pending_count">
	<div class="col-sm-4 col-md-4 col-lg-4 text-center mt-1">
		<label class="h3"><i class="fas fa-location-arrow"></i></i> List of Stock Address </label>	
	</div>
	<div class="col-sm-12 col-md-12 col-lg-12">
		<div class="md-form mb-0 col-sm-4 col-md-4 col-lg-4">
			<input type="text" id="search_stock_address" class="form-control text-center" oninput="search_stock_address_action()">
			<label for="search_stock_address" id="search_stock_address_label" class="ml-3">Search:</label>
		</div>
	</div>
	<div class="col-sm-12 col-md-12 col-lg-12">
		<button class="btn btn-default float-right" onclick="add_stock_address_button()"><i class="fas fa-plus-circle"></i> Add Stock Address</button>
	</div>
	<div class="row mx-0 col-sm-12 col-md-12 col-lg-12" id="scooter_station_section">
		<table class="table table-bordered">
			<thead>
				<tr class="blue-grey lighten-3"> 
					<td class="h6">ID</td>
					<td class="h6">Stock Address</td>
					<td class="h6">Parts Code</td>
					<td class="h6">Parts Name</td>
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
function select_stock_address(){
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
		if (this.readyState == 4 && this.status == 200) {
			var response = this.responseText;
			document.getElementById("scooter_station_list").innerHTML=response;
		}
	};
	xhttp.open("GET", "AJAX/stock_address.php?operation=select_stock_address", true);
	xhttp.send();
}
function save_stock_address(){
	var stock_address = document.getElementById("stock_address").value;
	var parts_code = document.getElementById("parts_code").value;
	var parts_name = document.getElementById("parts_name").value;
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
		if (this.readyState == 4 && this.status == 200) {
			var response = this.responseText;
			document.getElementById("out_stock_address").innerHTML=response;
			select_stock_address();
		}
	};
	xhttp.open("GET", "AJAX/stock_address.php?operation=save_stock_address&&stock_address="+stock_address+"&&parts_code="+parts_code+"&&parts_name="+parts_name, true);
	xhttp.send();
}
function add_stock_address_button(){
	$("#Stock_Address_Form").modal();
	document.getElementById("update_stock_address_button").style.display="none";
	document.getElementById("delete_stock_address_button").style.display="none";
	document.getElementById("save_stock_address_button").style.display="inline-block";
	document.getElementById('stock_address_modal_head').innerHTML='Add Stock Address';
	document.getElementById('parts_code').value="";
	document.getElementById('parts_name').value="";
	document.getElementById('stock_address').value="";
}
function get_this_stock_address(x){
	$("#Stock_Address_Form").modal();
	document.getElementById("update_stock_address_button").style.display="inline-block";
	document.getElementById("delete_stock_address_button").style.display="inline-block";
	document.getElementById("save_stock_address_button").style.display="none";
	document.getElementById("id_hidden").value=x;
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
		if (this.readyState == 4 && this.status == 200) {
			var response = this.responseText;
			var split = response.split('~!~');
			document.getElementById("stock_address").value=split[0];
			document.getElementById("parts_code").value=split[1];
			document.getElementById("parts_name").value=split[2];
		}
	};
	xhttp.open("GET", "AJAX/stock_address.php?operation=select_single_stock_address&&stock_id="+x, true);
	xhttp.send();
}
function update_stock_address(){
	var stock_address = document.getElementById("stock_address").value;
	var parts_code = document.getElementById("parts_code").value;
	var parts_name = document.getElementById("parts_name").value;
	var id_hidden = document.getElementById("id_hidden").value;
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
		if (this.readyState == 4 && this.status == 200){
			var response = this.responseText;
			document.getElementById("out_stock_address").innerHTML=response;
			select_stock_address();
		}
	};
	xhttp.open("GET", "AJAX/stock_address.php?operation=update_stock_address&&stock_address="+stock_address+"&&parts_code="+parts_code+"&&parts_name="+parts_name+"&&id_hidden="+id_hidden, true);
	xhttp.send();
}
function delete_stock_address(){
	var id_hidden = document.getElementById("id_hidden").value;
	var stock_address = document.getElementById("stock_address").value;
	var parts_code = document.getElementById("parts_code").value;
	var parts_name = document.getElementById("parts_name").value;
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
		if (this.readyState == 4 && this.status == 200) {
			var response = this.responseText;
			document.getElementById("out_stock_address").innerHTML=response;
			select_stock_address();
		}
	};
	xhttp.open("GET", "AJAX/stock_address.php?operation=delete_stock_address&&id="+id_hidden+"&&stock_address="+stock_address+"&&parts_code="+parts_code+"&&parts_name="+parts_name, true);
	xhttp.send();
}
function search_stock_address_action(){
	var search_stock_address = document.getElementById("search_stock_address").value;
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
		if (this.readyState == 4 && this.status == 200) {
			var response = this.responseText;
			document.getElementById("scooter_station_list").innerHTML=response;
		}
	};
	xhttp.open("GET", "AJAX/stock_address.php?operation=search_stock_address&&keyword="+search_stock_address, true);
	xhttp.send();
}
function close_modal(){
	$('#Stock_Address_Form').modal('toggle');
	document.getElementById("out_stock_address").innerHTML="";
	document.getElementById("parts_code").value="";
	document.getElementById("parts_name").value="";
	document.getElementById("stock_address").value="";
}
select_stock_address();
</script>
</body>
</html>





