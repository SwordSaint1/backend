<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>History Tube Cutting</title>
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
	<link rel="shortcut icon" href="favicon.ico" type="image/ico">
	<link href="favicon.png" rel="icon">
</head>
<body class="bg">
<?php
	include 'Nav/header.php';
	include 'Modal/history_admin_modal.php';
	include 'Modal/news_windows.php';
?>
<div class="card_opa mx-0">
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
		<div class="md-form col-sm-4 col-md-4 col-lg-4 pb-0 mb-0" id="scooter_station_select_section">
			<select id="scooter_area_select" class="browser-default form-control pb-0 mb-0">
			  <option selected>Scooter Station</option>
			</select>
		</div>
		<div class="col-sm-4 col-md-4 col-lg-4 pb-0 mb-0">
			<div class="md-form form-md pb-0 mb-0">
				<input type="datetime-local" id="date_from" class="form-control text-center">
				<label for="date_from" id="date_from_Label">Date From:</label>
			</div>
		</div>
		<div class="col-sm-4 col-md-4 col-lg-4 pb-0 mb-0">
			<div class="md-form form-md pb-0 mb-0">
				<input type="datetime-local" id="date_to" class="form-control text-center">
				<label for="date_to" id="date_to_Label">Date To:</label>
			</div>
		</div>
		<div class="col-sm-4 col-md-4 col-lg-4 pb-0 mb-0" id="line_no_section">
			<div class="md-form form-md pb-0 mb-0">
				<input type="text" id="line_no" class="form-control text-center">
				<label for="line_no" id="line_no_Label">Line No.:</label>
			</div>
		</div>
		<div class="col-sm-4 col-md-4 col-lg-4 pb-0 mb-0" id="parts_code_section">
			<div class="md-form form-md pb-0 mb-0">
				<input type="text" id="parts_code" class="form-control text-center">
				<label for="parts_code" id="parts_code_Label">Parts Code.:</label>
			</div>
		</div>
		<div class="col-sm-4 col-md-4 col-lg-4 pb-0 mb-0" id="parts_name_section">
			<div class="md-form form-md pb-0 mb-0">
				<input type="text" id="parts_name" class="form-control text-center">
				<label for="parts_name" id="parts_name_Label">Parts Name:</label>
			</div>
		</div>
		<div class="col-sm-4 col-md-4 col-lg-4 pb-0 mb-0">
			<div class="md-form form-md pb-0 mb-0">
				<input type="text" id="comment" class="form-control text-center">
				<label for="comment" id="comment_Label">Comment</label>
			</div>
		</div>
		<div class="col-sm-4 col-md-4 col-lg-4 pb-0 mb-0">
			<div class="md-form form-md pb-0 mb-0">
				<input type="text" id="length" class="form-control text-center">
				<label for="length" id="length_Label">Length</label>
			</div>
		</div>
		<div class="col-sm-4 col-md-4 col-lg-4 pb-0 mb-0">
			<div class="md-form form-md pb-0 mb-0">
				<input type="text" id="kanban_no" class="form-control text-center">
				<label for="kanban_no" id="kanban_no_Label">Kanban No</label>
			</div>
		</div>
		<div class="col-sm-12 col-md-12 col-lg-12">
			<button class="btn btn-info float-right" onclick="export_excel()" data-toggle="tooltip" data-placement="top" title="Export All"><i class="fas fa-file-download"></i> Excel</button>
		</div>
	</div>
	<div class="row mx-0 col-sm-12 col-md-12 col-lg-12">
		<table class="table table-bordered table-sm">
			<thead class="blue-grey lighten-3" id="thead_history">
				<tr>
					<th class="h6">No</th>
					<th class="h6">Line No</th>
					<th class="h6">Stock Address</th>
					<th class="h6">Parts Code</th>
					<th class="h6">Parts Name</th>
					<th class="h6">Kanban No</th>
					<th class="h6">Length</th>
					<th class="h6">Quantity</th>
					<th class="h6">Comment</th>
					<th class="h6">Station</th>
					<th class="h6">Scan Date</th>
					<th class="h6">Request</th>
					<th class="h6">Print Date</th>
					<th class="h6">Store Out Date</th>
				</tr>
			</thead>
			<tbody id="history_section">
			</tbody>
		</table>
	</div>
	<div class="row mx-0 col-sm-12 col-md-12 col-lg-12" id="requested_parts_this_area">
	</div>
	<div class="col-sm-12 col-md-12 col-lg-12 text-rigth" id="export_excel_showed" style="display:none;">
		<button class="btn btn-info float-right" onclick="export_excel_showed()" data-toggle="tooltip" data-placement="top" title="Export Results"><i class="fas fa-file-download"></i> Excel</button>
	</div>
	<div class="col-sm-12 col-md-12 col-lg-12 text-center mt-0 mb-0 pt-0 pb-0">
		<div class="loader_popup text-info text-center" id="loader_indicator" style="display:none;">Loading....</div>
	</div>
	<div class="row mx-0 col-sm-12 col-md-12 col-lg-12">
		<input type="hidden" id="load_more_counter" value="0"> <!--  Loadmore Limiter Count  -->
		<input type="hidden" id="filters_hidden" value="0"> <!--  Filters  -->
		<div class="rounded-circle info-color card-img-100 mx-auto mb-1 pulse" id="load_more_botton" style="margin-top:-10px;width:50px;height:50px;cursor:pointer;display:none;" onclick="load_more_history()" data-toggle="tooltip" data-placement="top" title="Load More">
			<i class="text-white fas fa-redo" style="margin-left:17px;margin-top:17px;"></i>
		</div>
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

	//For Comment
	var comment = document.getElementById("comment");
	comment.addEventListener("keyup", function(event) {
		if (event.keyCode === 13){
			event.preventDefault();
			search_action();
		}
	});

	//For Length
	var length = document.getElementById("length");
	length.addEventListener("keyup", function(event) {
		if (event.keyCode === 13){
			event.preventDefault();
			search_action();
		}
	});

	//For Kanban No
	var kanban_no = document.getElementById("kanban_no");
	kanban_no.addEventListener("keyup", function(event) {
		if (event.keyCode === 13){
			event.preventDefault();
			search_action();
		}
	});
</script>
<script>
function reprint_kanban(x){
	window.open('print_kanban_history.php?id='+x,'_blank');
}
function search_action(){
	document.getElementById('loader_indicator').style.display="inline-block";
	var line_no = document.getElementById('line_no').value;
	var parts_code = document.getElementById('parts_code').value;
	var parts_name = document.getElementById('parts_name').value;
	var comment = document.getElementById('comment').value;
	var length = document.getElementById('length').value;
	var kanban_no = document.getElementById('kanban_no').value;
	var date_from = document.getElementById('date_from').value;
	var date_to = document.getElementById('date_to').value;
	var scooter_station = document.getElementById('scooter_area_select').value;
	if (scooter_station == 'All' || scooter_station == 'Scooter Station'){
		scooter_station='';
	}else{
		var scooter_station = scooter_station;
	}
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
	if(this.readyState == 4 && this.status == 200){
		var response = this.responseText;
		document.getElementById('load_more_counter').value=20;
		document.getElementById('load_more_botton').style.display="none";
		document.getElementById('history_section').innerHTML=response;
		document.getElementById('export_excel_showed').style.display='inline-block';
		document.getElementById('loader_indicator').style.display="none";
		count_all();
	}
	};
	xhttp.open("GET", "AJAX/history_admin1.php?operation=display_all&&line_no="+line_no+"&&parts_code="+parts_code+"&&parts_name="+parts_name+"&&comment="+comment+"&&length="+length+"&&kanban_no="+kanban_no+"&&date_from="+date_from+"&&date_to="+date_to+"&&scooter_station="+scooter_station+"&&limiter_count=0&&no=0", true);
	xhttp.send();
}
function count_all(){
	var line_no = document.getElementById('line_no').value;
	var parts_code = document.getElementById('parts_code').value;
	var parts_name = document.getElementById('parts_name').value;
	var comment = document.getElementById('comment').value;
	var length = document.getElementById('length').value;
	var kanban_no = document.getElementById('kanban_no').value;
	var date_from = document.getElementById('date_from').value;
	var date_to = document.getElementById('date_to').value;
	var scooter_station = document.getElementById('scooter_area_select').value;
	if (scooter_station == 'All' || scooter_station == 'Scooter Station'){
		scooter_station='';
	}else{
		var scooter_station = scooter_station;
	}
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
		if (this.readyState == 4 && this.status == 200){
			var response = this.responseText;
			var all_count = response;
			var load_more_counter = document.getElementById('load_more_counter').value;
			var total_count = parseInt(all_count);
			var load_more_counter = parseInt(load_more_counter);
			if (total_count > load_more_counter){
				document.getElementById('load_more_botton').style.display='inline-block';
			}else if (total_count < load_more_counter){
				document.getElementById('load_more_botton').style.display='none';
			}
		}
	};
	xhttp.open("GET", "AJAX/history_admin1.php?operation=count_all&&line_no="+line_no+"&&parts_code="+parts_code+"&&parts_name="+parts_name+"&&comment="+comment+"&&length="+length+"&&kanban_no="+kanban_no+"&&date_from="+date_from+"&&date_to="+date_to+"&&scooter_station="+scooter_station, true);
	xhttp.send();
}
function load_more_history(){
	document.getElementById('load_more_botton').style.display="none";
	document.getElementById('loader_indicator').style.display="inline-block";
	var line_no = document.getElementById('line_no').value;
	var parts_code = document.getElementById('parts_code').value;
	var parts_name = document.getElementById('parts_name').value;
	var comment = document.getElementById('comment').value;
	var length = document.getElementById('length').value;
	var kanban_no = document.getElementById('kanban_no').value;
	var date_from = document.getElementById('date_from').value;
	var date_to = document.getElementById('date_to').value;
	var scooter_station = document.getElementById('scooter_area_select').value;
	var load_more_counter = document.getElementById('load_more_counter').value;
	var total_load = parseInt(load_more_counter) + 1;
	if (scooter_station == 'All' || scooter_station == 'Scooter Station'){
		scooter_station='';
	}else{
		var scooter_station = scooter_station;
	}
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
	if(this.readyState == 4 && this.status == 200){
		var response = this.responseText;
		document.getElementById('load_more_counter').value= parseInt(load_more_counter) + 20;
		document.getElementById('history_section').innerHTML += response;
		document.getElementById('loader_indicator').style.display="none";
		count_all();
	}
	};
	xhttp.open("GET", "AJAX/history_admin1.php?operation=display_all&&line_no="+line_no+"&&parts_code="+parts_code+"&&parts_name="+parts_name+"&&comment="+comment+"&&length="+length+"&&kanban_no="+kanban_no+"&&date_from="+date_from+"&&date_to="+date_to+"&&scooter_station="+scooter_station+"&&limiter_count="+load_more_counter+"&&no="+load_more_counter, true);
	xhttp.send();
}
function export_excel(){
	var line_no = document.getElementById('line_no').value;
	var parts_code = document.getElementById('parts_code').value;
	var parts_name = document.getElementById('parts_name').value;
	var comment = document.getElementById('comment').value;
	var length = document.getElementById('length').value;
	var kanban_no = document.getElementById('kanban_no').value;
	var date_from = document.getElementById('date_from').value;
	var date_to = document.getElementById('date_to').value;
	var scooter_station = document.getElementById('scooter_area_select').value;
	if (scooter_station == 'All' || scooter_station == 'Scooter Station'){
		scooter_station='';
	}else{
		var scooter_station = scooter_station;
	}
	window.open('export_history_all.php?line_no='+line_no+'&&parts_code='+parts_code+'&&parts_name='+parts_name+'&&comment='+comment+'&&length='+length+'&&kanban_no='+kanban_no+'&&date_from='+date_from+'&&date_to='+date_to+'&&scooter_station='+scooter_station,'_blank');
}
function export_excel_showed(){
	var line_no = document.getElementById('line_no').value;
	var parts_code = document.getElementById('parts_code').value;
	var parts_name = document.getElementById('parts_name').value;
	var comment = document.getElementById('comment').value;
	var length = document.getElementById('length').value;
	var kanban_no = document.getElementById('kanban_no').value;
	var date_from = document.getElementById('date_from').value;
	var date_to = document.getElementById('date_to').value;
	var scooter_station = document.getElementById('scooter_area_select').value;
	var load_more_counter = document.getElementById('load_more_counter').value;
	if (scooter_station == 'All' || scooter_station == 'Scooter Station'){
		scooter_station='';
	}else{
		var scooter_station = scooter_station;
	}
	window.open('export_history_results.php?line_no='+line_no+'&&parts_code='+parts_code+'&&parts_name='+parts_name+'&&comment='+comment+'&&length='+length+'&&kanban_no='+kanban_no+'&&date_from='+date_from+'&&date_to='+date_to+'&&scooter_station='+scooter_station+"&&limiter="+load_more_counter,'_blank');
}
</script>

<script>
var xhttp = new XMLHttpRequest();
function select_request(){
	xhttp.onreadystatechange = function(){
		if (this.readyState == 4 && this.status == 200) {
			var response = this.responseText;
			document.getElementById('requested_parts_this_area').innerHTML=response;
		}
	};
	xhttp.open("GET", "AJAX/history.php?operation=select_request_scooter_area&&scooter_area=", true);
	xhttp.send();
}
//select_request();
</script>
<script>
function open_details_request(x){
	var split = x.split('~!~');
	var id_scanned_kanban = split[0];
	var real_time_status = split[1];
	$("#Requested_Parts").modal();
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
	if(this.readyState == 4 && this.status == 200){
		var response = this.responseText;
		get_requestor_name(id_scanned_kanban);
		document.getElementById('scanned_kanban_section_station').innerHTML=response;
	}
	};
	xhttp.open("GET", "AJAX/history_admin.php?operation=open_details_history&&id_scanned_kanban="+id_scanned_kanban, true);
	xhttp.send();
}
function open_details_request_lines(x){
	var split = x.split('~!~');
	var id_scanned_kanban = split[0];
	var real_time_status = split[1];
	var line_no = split[2];
	$("#Requested_Parts").modal();
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
	if(this.readyState == 4 && this.status == 200){
		var response = this.responseText;
		get_requestor_name(id_scanned_kanban);
		document.getElementById('scanned_kanban_section_station').innerHTML=response;
	}
	};
	xhttp.open("GET", "AJAX/history_admin.php?operation=open_details_history_lines&&id_scanned_kanban="+id_scanned_kanban+"&&line_no="+line_no, true);
	xhttp.send();
}
function get_requestor_name(x){
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			var response = this.responseText;
			document.getElementById('requestor_name_section').innerHTML="<i class='fas fa-user-tag'></i> Requestor Name: "+response;
		}
	};
	xhttp.open("GET", "AJAX/history.php?operation=get_requestor_name&&id_scanned_kanban="+x, true);
	xhttp.send();
}
function close_modal(){
	$('#Requested_Parts').modal('toggle');
	document.getElementById('scanned_kanban_section_station').innerHTML="";
}
</script>
<script>
	get_all_station();
	function get_all_station(){
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			var response = this.responseText;
			var response = "<option selected>Scooter Station</option><option>All</option>"+response;
			document.getElementById('scooter_area_select').innerHTML=response;
		}
		};
		xhttp.open("GET", "AJAX/history_admin1.php?operation=get_all_station", true);
		xhttp.send();
	}
</script>
</body>
</html>
