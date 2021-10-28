<?php
	session_start();
	$username_session = $_SESSION["username_session"];
	if($username_session == ''){
		header("location:../index.php");
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>Live Store Out</title>
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
	<link href="mycss/spinners.css" rel="stylesheet">
	<link href="mycss/style1.css" rel="stylesheet">
	<link rel="shortcut icon" href="favicon.ico" type="image/ico">
	<link href="favicon.png" rel="icon">
</head>
<body class="bg">
<?php
	include 'Nav/header.php';
	include 'Modal/history_admin_modal.php';
?>
<div class="card_opa mx-0">
	<div class="row ml-0 mr-0">
		<div class="col-sm-4 col-md-4 col-lg-4">
		</div>
		<input type="hidden" id="entries_pending">
		<input type="hidden" id="entries_pending_count">
		<div class="col-sm-4 col-md-4 col-lg-4 text-center mt-1">
			<label class="h3"><i class="fas fa-history"></i>Live Store Out</label>	
		</div>
	</div>
	<div class="row mx-0 my-0 font-weight-bolder">
		<div class="col-sm-4 col-md-4 col-lg-4 mx-0 my-0">
			<div class="md-form form-md">
				<input type="datetime-local" id="date_from" class="form-control text-center" size="64">
				<label for="date_from" id="date_from_Label">Date From:</label>
			</div>
		</div>
		<div class="col-sm-4 col-md-4 col-lg-4 mx-0 my-0">
			<div class="md-form form-md">
				<input type="datetime-local" id="date_to" class="form-control text-center">
				<label for="date_to" id="date_from_Label">Date To:</label>
			</div>
		</div>
		<div class="col-sm-4 col-md-4 col-lg-4 mx-0 my-0" id="line_no_section">
			<div class="md-form form-md">
				<input type="text" id="line_no" class="form-control text-center">
				<label for="line_no" id="line_no_Label">Line No:</label>
			</div>
		</div>
		<div class="col-sm-3 col-md-3 col-lg-3 mx-0 my-0" id="parts_code_section">
			<div class="md-form form-md">
				<input type="text" id="parts_code" class="form-control text-center">
				<label for="parts_code" id="parts_code_Label">Parts Code:</label>
			</div>
		</div>
		<div class="col-sm-3 col-md-3 col-lg-3 mx-0 my-0" id="parts_code_section">
			<div class="md-form form-md">
				<input type="text" id="kanban_no" class="form-control text-center">
				<label for="kanban_no" id="kanban_no_Label">Kanban No:</label>
			</div>
		</div>
		<div class="col-sm-3 col-md-3 col-lg-3" style='display:none'>
			<button class="btn btn-default float-right" onclick="export_excel()"><i class="fas fa-file-download"></i> Excel</button>
		</div>
	</div>
	<div class="row mx-0 col-sm-12 col-md-12 col-lg-12">
		<table class="table table-bordered table-sm">
			<thead class="unique-color text-white" id="thead_history">
				<tr>
					<th class="h6">No</th>
					<th class="h6">Line No</th>
					<th class="h6">Parts Code</th>
					<th class="h6">Kanban No</th>
					<th class="h6">MM User</th>
					<th class="h6">Store Out Date & Time</th>
				</tr>
			</thead>
			<tbody id="history_section">
			</tbody>
		</table>
	</div>
	<div class="mx-0 col-sm-12 col-md-12 col-lg-12 text-right float-right">
		<label class="h4 text-right float-right" id="total_count_fsib"></label>
	</div>
	<div class="row mx-0 col-sm-12 col-md-12 col-lg-12" id="requested_parts_this_area">
		<div class="loader_popup text-center" id="loader_indicator" style="display:none;">Loading....</div>
		<div class="row mx-0 col-sm-12 col-md-12 col-lg-12">
			<input type="hidden" id="limiter_count" value="0"> <!--  Loadmore Limiter Count  -->
			<input type="hidden" id="filters_hidden" value="0"> <!--  Filters  -->
			<div class="rounded-circle default-color card-img-100 mx-auto mb-1 pulse" id="load_more_botton" style="margin-top:-10px;width:50px;height:50px;cursor:pointer;display:none;" onclick="load_more_history()">
				<i class="text-white fas fa-redo" style="margin-left:17px;margin-top:17px;"></i>
			</div>
		</div>
	</div>
</div>
<!--For Enter in Search-->
<script>
	//For Line No
	var line_no = document.getElementById("line_no");
	line_no.addEventListener("keyup", function(event) {
		if (event.keyCode === 13){
			event.preventDefault();
			search_action();
		}
	});

	//For Parts Code
	var parts_code = document.getElementById("parts_code");
	parts_code.addEventListener("keyup", function(event) {
		if (event.keyCode === 13){
			event.preventDefault();
			search_action();
		}
	});

	//For Parts Name
	var kanban_no = document.getElementById("kanban_no");
	kanban_no.addEventListener("keyup", function(event) {
		if (event.keyCode === 13){
			event.preventDefault();
			search_action();
		}
	});
</script>
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
const search_action =()=>{
	document.getElementById('loader_indicator').style.display="inline-block";
	let line_no = document.getElementById('line_no').value;
	let parts_code = document.getElementById('parts_code').value;
	let kanban_no = document.getElementById('kanban_no').value;
	let date_from = document.getElementById('date_from').value;
	let date_to = document.getElementById('date_to').value;
	let xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
	if(this.readyState == 4 && this.status == 200){
		let response = this.responseText;
		document.getElementById('limiter_count').value=20;
		document.getElementById('loader_indicator').style.display="none";
		document.getElementById('history_section').innerHTML=response;
		//count_all();
	}
	};
	xhttp.open("GET", "AJAX/live_store_out.php?operation=display_all&&line_no="+line_no+"&&parts_code="+parts_code+"&&date_from="+date_from+"&&date_to="+date_to+"&&limiter_count=0&&kanban_no="+kanban_no, true);
	xhttp.send();
}













function load_more_history(){
	document.getElementById('load_more_botton').style.display="none";
	document.getElementById('loader_indicator').style.display="inline-block";
	var line_no = document.getElementById('line_no').value;
	var parts_code = document.getElementById('parts_code').value;
	var kanban_no = document.getElementById('kanban_no').value;
	var date_from = document.getElementById('date_from').value;
	var date_to = document.getElementById('date_to').value;
	var limiter_count = parseInt(document.getElementById('limiter_count').value);
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
	if(this.readyState == 4 && this.status == 200){
		var response = this.responseText;
		var limiter_count1 = limiter_count + 20;
		document.getElementById('limiter_count').value=limiter_count1;
		document.getElementById('loader_indicator').style.display="none";
		document.getElementById('history_section').innerHTML += response;
		count_all();
	}
	};
	xhttp.open("GET", "../AJAX/store_out_fsib.php?operation=display_all&&line_no="+line_no+"&&parts_code="+parts_code+"&&date_from="+date_from+"&&date_to="+date_to+"&&limiter_count="+limiter_count+"&&kanban_no="+kanban_no, true);
	xhttp.send();
}
function count_all(){
	var line_no = document.getElementById('line_no').value;
	var parts_code = document.getElementById('parts_code').value;
	var kanban_no = document.getElementById('kanban_no').value;
	var date_from = document.getElementById('date_from').value;
	var date_to = document.getElementById('date_to').value;
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
	if(this.readyState == 4 && this.status == 200){
		//var response = parseInt(this.responseText);
		var response = this.responseText;
		var limiter_count = parseInt(document.getElementById('limiter_count').value);
		document.getElementById('total_count_fsib').innerHTML='Total '+response;
		if (limiter_count >= response){
			document.getElementById('load_more_botton').style.display='none';
		}else{
			document.getElementById('load_more_botton').style.display='inline-block';
		}
	}
	};
	xhttp.open("GET", "../AJAX/store_out_fsib.php?operation=count_all&&line_no="+line_no+"&&parts_code="+parts_code+"&&date_from="+date_from+"&&date_to="+date_to+"&&kanban_no="+kanban_no, true);
	xhttp.send();
}
function export_excel(){
	var line_no = document.getElementById('line_no').value;
	var parts_code = document.getElementById('parts_code').value;
	var parts_name = document.getElementById('parts_name').value;
	var date_from = document.getElementById('date_from').value;
	var date_to = document.getElementById('date_to').value;
	var limiter_count = document.getElementById('limiter_count').value;
	var scooter_station = document.getElementById('scooter_area_select').value;
	var shifting = document.getElementById('shifting').value;
	if (scooter_station == 'All' || scooter_station == 'Scooter Station'){
		scooter_station='';
	}else{
		var scooter_station = scooter_station;
	}
	window.open('export_history_mm.php?line_no='+line_no+'&&parts_code='+parts_code+'&&parts_name='+parts_name+'&&date_from='+date_from+'&&date_to='+date_to+'&&limiter_count='+limiter_count+'&&scooter_station='+scooter_station+'&&shifting='+shifting,'_blank');
}
</script>
</body>
</html>