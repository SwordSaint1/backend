<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>E-Kanban History Search</title>
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
	<link href="mycss/pulse.css" rel="stylesheet">
	<link href="mycss/spinners.css" rel="stylesheet">
	<link href="mycss/tracking.css" rel="stylesheet">
	<link rel="shortcut icon" href="favicon.ico" type="image/ico">
	<link href="favicon.png" rel="icon">
</head>
<body class="bg">
<?php
	include 'Nav/header_search.php';
	include 'Modal/history_admin_modal.php';
	include 'Modal/news_windows.php';
?>
<div class="mx-0">
	<div class="row ml-0 mr-0">
		<div class="col-sm-4 col-md-4 col-lg-4">
		</div>
		<input type="hidden" id="entries_pending">
		<input type="hidden" id="entries_pending_count">
		<div class="col-sm-4 col-md-4 col-lg-4 text-center mt-1">
			<label class="h3"><i class="fas fa-history"></i> History </label>	
		</div>
	</div>
	<div class="row mx-0">
		<input type="hidden" id="operation_hidden">
		<div class="md-form mb-0 col-sm-4 col-md-4 col-lg-4" id="scooter_station_select_section">
			<select id="scooter_area_select" class="browser-default form-control">
			  <option selected>Scooter Station</option>
			</select>
		</div>
		<div class="col-sm-4 col-md-4 col-lg-4">
			<div class="md-form form-md">
				<input type="datetime-local" id="date_from" class="form-control text-center">
				<label for="date_from" id="date_from_Label">Date From:</label>
			</div>
		</div>
		<div class="col-sm-4 col-md-4 col-lg-4">
			<div class="md-form form-md">
				<input type="datetime-local" id="date_to" class="form-control text-center">
				<label for="date_to" id="date_to_Label">Date To:</label>
			</div>
		</div>
		<div class="col-sm-4 col-md-4 col-lg-4" id="line_no_section">
			<div class="md-form form-md">
				<input type="text" id="line_no" class="form-control text-center">
				<label for="line_no" id="line_no_Label">Line No.:</label>
			</div>
		</div>
		<div class="col-sm-4 col-md-4 col-lg-4" id="parts_code_section">
			<div class="md-form form-md">
				<input type="text" id="parts_code" class="form-control text-center">
				<label for="parts_code" id="parts_code_Label">Parts Code.:</label>
			</div>
		</div>
		<div class="col-sm-4 col-md-4 col-lg-4" id="parts_name_section">
			<div class="md-form form-md">
				<input type="text" id="parts_name" class="form-control text-center">
				<label for="parts_name" id="parts_name_Label">Search by Parts Name:</label>
			</div>
		</div>
		<div class="col-sm-12 col-md-12 col-lg-12 mt-1" id='tracking_storeout_search'>
			<div class="track mt-3" id='tracked_storeout' style='display:none;'>
				<div class="step active"> <span class="icon"> <i class="fa fa-check"></i> </span> <span class="text">Order confirmed</span> </div>
				<div class="step active"> <span class="icon"> <i class="fa fa-user"></i> </span> <span class="text"> Printed by MM</span> </div>
				<div class="step active"> <span class="icon"> <i class="fa fa-truck"></i> </span> <span class="text"> Store Out </span> </div>
				<!-- <div class="step"> <span class="icon"> <i class="fa fa-box"></i> </span> <span class="text">Ready for pickup</span> </div> -->
			</div>
		</div>
		<div class="col-sm-12 col-md-12 col-lg-12">
			<button class="btn unique-color white-text waves-effect float-right" onclick="export_excel()" data-toggle="tooltip" data-placement="top" title="Export All"><i class="fas fa-file-download"></i> Excel</button>
		</div>
	</div>
	<div class="row mx-0 col-sm-12 col-md-12 col-lg-12">
		<table class="table table-bordered table-sm">
			<thead class="unique-color text-white" id="thead_history">
				<tr>
					<th class="h6">No</th>
					<th class="h6">Line No</th>
					<th class="h6">Parts Code</th>
					<th class="h6">Parts Name</th>
					<th class="h6">Kanban No</th>
					<th class="h6">Quantity</th>
					<th class="h6">Station</th>
					<th class="h6">Truck No</th>
					<th class="h6">Scan Date</th>
					<th class="h6">Request Date</th>
					<th class="h6">Print Date</th>
					<th class="h6">Store Out Date</th>
				</tr>
			</thead>
			<tbody id="history_section">
			</tbody>
		</table>
	</div>
	<div class="col-sm-12 col-md-12 col-lg-12 text-center mt-0 mb-0 pt-0 pb-0">
		<div class="loader_popup text-center" id="loader_indicator" style="display:none;">Loading....</div>
	</div>
	<div class="my-0 mx-0 col-sm-12 col-md-12 col-lg-12">
		<label class="col-sm-12 col-md-12 col-lg-12 text-right" id="counter_viewer"></label>
	</div>
	<div class="col-sm-12 col-md-12 col-lg-12 text-rigth" id="export_excel_showed" style="display:none;">
		<button class="btn unique-color white-text waves-effect float-right" onclick="export_excel_showed()" data-toggle="tooltip" data-placement="top" title="Export Results"><i class="fas fa-file-download"></i> Excel</button>
	</div>
	<div class="row mx-0 col-sm-12 col-md-12 col-lg-12">
		<input type="hidden" id="load_more_counter" value="0"> <!--  Loadmore Limiter Count  -->
		<input type="hidden" id="filters_hidden" value="0"> <!--  Filters  -->
		<div class="rounded-circle unique-color white-text waves-effect card-img-100 mx-auto mb-1 pulse" id="load_more_botton" style="margin-top:-10px;width:50px;height:50px;cursor:pointer;display:none;" onclick="load_more_history()" data-toggle="tooltip" data-placement="top" title="Load More">
			<i class="text-white fas fa-redo" style="margin-left:17px;margin-top:17px;"></i>
		</div>
	</div>
</div>
</body>
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
<!-- My Tooltip Initialization-->
<script type="text/javascript" src="myjs/tool_tip.js"></script>
<!-- My JacaScript of News-->
<script type="text/javascript" src="myjs/news_window.js"></script>

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
	var parts_name = document.getElementById("parts_name");
	parts_name.addEventListener("keyup", function(event) {
		if (event.keyCode === 13){
			event.preventDefault();
			search_action();
		}
	});
</script>
<script>
const get_all_station =()=>{
	let xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
	if(this.readyState == 4 && this.status == 200){
		let response = this.responseText;
		document.getElementById('scooter_area_select').innerHTML=response;
	}
	};
	xhttp.open("GET", "AJAX/history_admin.php?operation=get_all_station", true);
	xhttp.send();
}
const search_action =()=>{
	document.getElementById('history_section').innerHTML='';
	document.getElementById('load_more_botton').style.display='none';
	document.getElementById('loader_indicator').style.display="inline-block";
	document.getElementById('tracked_storeout').style.display="none";
	let line_no = document.getElementById('line_no').value;
	let parts_code = document.getElementById('parts_code').value;
	let parts_name = document.getElementById('parts_name').value;
	let date_from = document.getElementById('date_from').value;
	let date_to = document.getElementById('date_to').value;
	let scooter_station = document.getElementById('scooter_area_select').value;
	if (scooter_station == 'All' || scooter_station == 'Scooter Station'){
		scooter_station = '';
	}else{
		scooter_station = scooter_station;
	}
	let xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
	if(this.readyState == 4 && this.status == 200){
		let response = this.responseText;
		document.getElementById('load_more_counter').value=20;
		document.getElementById('load_more_botton').style.display="none";
		document.getElementById('history_section').innerHTML=response;
		document.getElementById('loader_indicator').style.display="none";
		document.getElementById('tracked_storeout').style.display="flex";
		count_all();
	}
	};
	xhttp.open("GET", "AJAX/history_admin.php?operation=display_all&&line_no="+line_no+"&&parts_code="+parts_code+"&&parts_name="+parts_name+"&&date_from="+date_from+"&&date_to="+date_to+"&&scooter_station="+scooter_station+"&&limiter_count=0&&no=0", true);
	xhttp.send();
}
const count_all =()=>{
	let line_no = document.getElementById('line_no').value;
	let parts_code = document.getElementById('parts_code').value;
	let parts_name = document.getElementById('parts_name').value;
	let date_from = document.getElementById('date_from').value;
	let date_to = document.getElementById('date_to').value;
	let scooter_station = document.getElementById('scooter_area_select').value;
	if (scooter_station == 'All' || scooter_station == 'Scooter Station'){
		scooter_station ='';
	}else{
		scooter_station = scooter_station;
	}
	let xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
		if (this.readyState == 4 && this.status == 200){
			let response = this.responseText;
			let all_count = response;
			let load_more_counter = document.getElementById('load_more_counter').value;
			let total_count = parseInt(all_count);
			let table_rows = document.getElementById("history_section").rows.length;
			load_more_counter = parseInt(load_more_counter);
			document.getElementById('counter_viewer').innerHTML=table_rows +' - '+ total_count;
			if (total_count == 0){
				document.getElementById('load_more_botton').style.display='none';
			}else if (total_count > load_more_counter){
				document.getElementById('export_excel_showed').style.display='inline-block';
				document.getElementById('load_more_botton').style.display='inline-block';
			}else if (total_count < load_more_counter){
				document.getElementById('load_more_botton').style.display='none';
			}

		}
	};
	xhttp.open("GET", "AJAX/history_admin.php?operation=count_all&&line_no="+line_no+"&&parts_code="+parts_code+"&&parts_name="+parts_name+"&&date_from="+date_from+"&&date_to="+date_to+"&&scooter_station="+scooter_station, true);
	xhttp.send();
}
const load_more_history =()=>{
	document.getElementById('load_more_botton').style.display="none";
	document.getElementById('loader_indicator').style.display="inline-block";
	let line_no = document.getElementById('line_no').value;
	let parts_code = document.getElementById('parts_code').value;
	let parts_name = document.getElementById('parts_name').value;
	let date_from = document.getElementById('date_from').value;
	let date_to = document.getElementById('date_to').value;
	let scooter_station = document.getElementById('scooter_area_select').value;
	let load_more_counter = document.getElementById('load_more_counter').value;
	let total_load = parseInt(load_more_counter) + 1;
	if (scooter_station == 'All' || scooter_station == 'Scooter Station'){
		scooter_station='';
	}else{
		scooter_station = scooter_station;
	}
	let xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
	if(this.readyState == 4 && this.status == 200){
		let response = this.responseText;
		document.getElementById('load_more_counter').value= parseInt(load_more_counter) + 20;
		document.getElementById('history_section').innerHTML += response;
		document.getElementById('loader_indicator').style.display="none";
		count_all();
	}
	};
	xhttp.open("GET", "AJAX/history_admin.php?operation=display_all&&line_no="+line_no+"&&parts_code="+parts_code+"&&parts_name="+parts_name+"&&date_from="+date_from+"&&date_to="+date_to+"&&scooter_station="+scooter_station+"&&limiter_count=0"+total_load+"&&no="+load_more_counter, true);
	xhttp.send();
}
const export_excel =()=>{
	let scooter_area_select = document.getElementById('scooter_area_select').value;
	let date_from = document.getElementById('date_from').value;
	let date_to = document.getElementById('date_to').value;
	let line_no = document.getElementById('line_no').value;
	let parts_code = document.getElementById('parts_code').value;
	let parts_name = document.getElementById('parts_name').value;
	let load_more_counter = document.getElementById('load_more_counter').value;
	if (scooter_area_select == 'All' || scooter_area_select == 'Scooter Station'){
		scooter_area_select='';
	}else{
		scooter_area_select = scooter_area_select;
	}
	window.open('export_history_all.php?scooter_area_select='+scooter_area_select+'&&date_from='+date_from+'&&date_to='+date_to+'&&line_no='+line_no+'&&parts_code='+parts_code+'&&parts_name='+parts_name+'&&load_more_counter='+load_more_counter,'_blank');
}
const export_excel_showed =()=>{
	let scooter_area_select = document.getElementById('scooter_area_select').value;
	let date_from = document.getElementById('date_from').value;
	let date_to = document.getElementById('date_to').value;
	let line_no = document.getElementById('line_no').value;
	let parts_code = document.getElementById('parts_code').value;
	let parts_name = document.getElementById('parts_name').value;
	let load_more_counter = document.getElementById('load_more_counter').value;
	if (scooter_area_select == 'All' || scooter_area_select == 'Scooter Station'){
		scooter_area_select='';
	}else{
		scooter_area_select = scooter_area_select;
	}
	window.open('export_history_results.php?scooter_area_select='+scooter_area_select+'&&date_from='+date_from+'&&date_to='+date_to+'&&line_no='+line_no+'&&parts_code='+parts_code+'&&parts_name='+parts_name+'&&load_more_counter='+load_more_counter,'_blank');
}
get_all_station();
</script>
</html>
