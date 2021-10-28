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
	<title>Distributor Settings (Advance Kanban Preparation)</title>
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
	include 'Modal/distributor_modal.php';
?>
<div class="row ml-0 mr-0 card_opa">
	<div class="col-sm-4 col-md-4 col-lg-4">
	</div>
	<input type="hidden" id="entries_pending">
	<input type="hidden" id="entries_pending_count">
	<div class="col-sm-4 col-md-4 col-lg-4 text-center mt-1">
		<label class="h3"><i class="fas fa-users"></i> List of Distributor </label>	
	</div>
	<div class="col-sm-12 col-md-12 col-lg-12">
		<button class="btn btn-info float-right" onclick="add_distibutor_button()"><i class="fas fa-plus-circle"></i> Add Distributor </button>
	</div>
	<div class="row mx-0 col-sm-12 col-md-12 col-lg-12" id="distributor_section">
		<table class="table table-bordered table-sm">
			<thead>
				<tr class="blue-grey lighten-3"> 
					<td class="h6">ID</td>
					<td class="h6">ID Number</td>
					<td class="h6">Scooter Station</td>
					<td class="h6">Name</td>
					<td class="h6">Date Updated</td>
				</tr>
				<tbody id="distributor_list">
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
	function select_distributor(){
		xhttp.onreadystatechange = function(){
			if (this.readyState == 4 && this.status == 200) {
				var response = this.responseText;
				document.getElementById("distributor_list").innerHTML=response;
			}
		};
		xhttp.open("GET", "AJAX/distributor.php?operation=select_distributor", true);
		xhttp.send();
	}
	function save_distributor(){
		var id_no = document.getElementById("id_no").value;
		var name = document.getElementById("name").value;
		var scooter_area = document.getElementById("scooter_area").value;
		xhttp.onreadystatechange = function(){
			if (this.readyState == 4 && this.status == 200) {
				var response = this.responseText;
				document.getElementById("out_distributor").innerHTML=response;
				select_distributor();
			}
		};
		xhttp.open("GET", "AJAX/distributor.php?operation=save_distributor&&id_no="+id_no+"&&name="+name+"&&scooter_area="+scooter_area, true);
		xhttp.send();
	}
	function add_distibutor_button(){
		$("#Distributor_Form").modal();
		document.getElementById("update_distributor_button").style.display="none";
		document.getElementById("delete_distributor_button").style.display="none";
		document.getElementById("save_distributor_button").style.display="inline-block";
		document.getElementById('scooter_distributor_modal_head').innerHTML='Add Distributor';
		document.getElementById('id_no').value='';
		document.getElementById('name').value='';
		document.getElementById('out_distributor').innerHTML='';
	}
	function get_this_distributor(x){
		$("#Distributor_Form").modal();
		document.getElementById("update_distributor_button").style.display="inline-block";
		document.getElementById("delete_distributor_button").style.display="inline-block";
		document.getElementById("save_distributor_button").style.display="none";
		document.getElementById("id_hidden").value=x;
		xhttp.onreadystatechange = function(){
			if (this.readyState == 4 && this.status == 200) {
				var response = this.responseText;
				var split = response.split('~!~');
				document.getElementById("id_no").value=split[0];
				document.getElementById("name").value=split[1];
				document.getElementById("scooter_area").value=split[2];
			}
		};
		xhttp.open("GET", "AJAX/distributor.php?operation=select_single_distributor&&id="+x, true);
		xhttp.send();
	}
	function update_distributor(){
		var id_no = document.getElementById("id_no").value;
		var name = document.getElementById("name").value;
		var scooter_area = document.getElementById("scooter_area").value;
		var id_hidden = document.getElementById("id_hidden").value;
		xhttp.onreadystatechange = function(){
			if (this.readyState == 4 && this.status == 200) {
				var response = this.responseText;
				document.getElementById("out_distributor").innerHTML=response;
				select_distributor();
			}
		};
		xhttp.open("GET", "AJAX/distributor.php?operation=update_distributor&&scooter_area="+scooter_area+"&&name="+name+"&&id="+id_hidden+"&&id_no="+id_no, true);
		xhttp.send();
	}
	function delete_distributor(){
		var id_hidden = document.getElementById("id_hidden").value;
		xhttp.onreadystatechange = function(){
			if (this.readyState == 4 && this.status == 200) {
				var response = this.responseText;
				document.getElementById("out_distributor").innerHTML=response;
				select_distributor();
			}
		};
		xhttp.open("GET", "AJAX/distributor.php?operation=delete_distributor&&id="+id_hidden, true);
		xhttp.send();
	}
	function close_modal(){
		$('#Distributor_Form').modal('toggle');
		document.getElementById("out_distributor").innerHTML="";
		document.getElementById("name").value="";
		document.getElementById("id_no").value="";
	}
	select_distributor();
</script>
</body>
</html>
