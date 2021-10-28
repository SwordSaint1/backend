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
<div class="row ml-0 mr-0">
	<div class="col-sm-4 col-md-4 col-lg-4">
	</div>
	<input type="hidden" id="entries_pending">
	<input type="hidden" id="entries_pending_count">
	<div class="col-sm-4 col-md-4 col-lg-4 text-center mt-1">
		<label class="h3"><i class="fas fa-users"></i> List of Distributor </label>	
	</div>
	<div class="col-sm-12 col-md-12 col-lg-12">
		<button class="btn unique-color white-text float-right" onclick="add_distibutor_button()"><i class="fas fa-plus-circle"></i> Add Distributor </button>
	</div>
	<div class="row mx-0 col-sm-12 col-md-12 col-lg-12" id="distributor_section">
		<table class="table table-bordered table-sm">
			<thead>
				<tr class="unique-color white-text"> 
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
	const select_distributor =()=>{
		let xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function(){
			if (this.readyState == 4 && this.status == 200) {
				let response = this.responseText;
				document.getElementById("distributor_list").innerHTML=response;
			}
		};
		xhttp.open("GET", "AJAX/distributor.php?operation=select_distributor", true);
		xhttp.send();
	}
	const save_distributor =()=>{
		let id_no = document.getElementById("id_no").value;
		let name = document.getElementById("name").value;
		let scooter_area = document.getElementById("scooter_area").value;
		let xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function(){
			if (this.readyState == 4 && this.status == 200) {
				let response = this.responseText;
				document.getElementById("out_distributor").innerHTML=response;
				select_distributor();
			}
		};
		xhttp.open("GET", "AJAX/distributor.php?operation=save_distributor&&id_no="+id_no+"&&name="+name+"&&scooter_area="+scooter_area, true);
		xhttp.send();
	}
	const add_distibutor_button =()=>{
		load_scooter_area();
		$("#Distributor_Form").modal();
		document.getElementById("update_distributor_button").style.display="none";
		document.getElementById("delete_distributor_button").style.display="none";
		document.getElementById("save_distributor_button").style.display="inline-block";
		document.getElementById('scooter_distributor_modal_head').innerHTML='Add Distributor';
		document.getElementById('id_no').value='';
		document.getElementById('name').value='';
		document.getElementById('out_distributor').innerHTML='';
	}
	const get_this_distributor =(data_param)=>{
		$("#Distributor_Form").modal();
		let split = data_param.split('~!~');
		document.getElementById("id_hidden").value=split[0];
		document.getElementById("id_no").value=split[1];
		document.getElementById("scooter_area").value=split[2];
		document.getElementById("name").value=split[3];
		document.getElementById("update_distributor_button").style.display="inline-block";
		document.getElementById("delete_distributor_button").style.display="inline-block";
		document.getElementById("save_distributor_button").style.display="none";
	}
	const update_distributor =()=>{
		let id_no = document.getElementById("id_no").value;
		let name = document.getElementById("name").value;
		let scooter_area = document.getElementById("scooter_area").value;
		let id_hidden = document.getElementById("id_hidden").value;
		let xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function(){
			if (this.readyState == 4 && this.status == 200) {
				let response = this.responseText;
				document.getElementById("out_distributor").innerHTML=response;
				select_distributor();
			}
		};
		xhttp.open("GET", "AJAX/distributor.php?operation=update_distributor&&scooter_area="+scooter_area+"&&name="+name+"&&id="+id_hidden+"&&id_no="+id_no, true);
		xhttp.send();
	}
	const load_scooter_area =()=>{
		let	xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function(){
			if (this.readyState == 4 && this.status == 200){
				let response = this.responseText;
				document.getElementById("scooter_area").innerHTML=response;
			}
		};
		xhttp.open("GET", "AJAX/distributor.php?operation=load_scooter_area", true);
		xhttp.send();
	}
	const delete_distributor =()=>{
		let id_hidden = document.getElementById("id_hidden").value;
		let	xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function(){
			if (this.readyState == 4 && this.status == 200) {
				let response = this.responseText;
				document.getElementById("out_distributor").innerHTML=response;
				select_distributor();
			}
		};
		xhttp.open("GET", "AJAX/distributor.php?operation=delete_distributor&&id="+id_hidden, true);
		xhttp.send();
	}
	const close_modal =()=>{
		$('#Distributor_Form').modal('toggle');
		document.getElementById("out_distributor").innerHTML="";
		document.getElementById("name").value="";
		document.getElementById("id_no").value="";
	}
	select_distributor();
	load_scooter_area();
</script>
</body>
</html>
