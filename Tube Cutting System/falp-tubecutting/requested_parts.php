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
	<title>Requested Parts</title>
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
	<link href="mycss/pulse.css" rel="stylesheet">
	<!-- My CSS -->
	<link href="mycss/style1.css" rel="stylesheet">
	<link href="mycss/spinners.css" rel="stylesheet">
	<link rel="shortcut icon" href="favicon.ico" type="image/ico">
	<link href="favicon.png" rel="icon">
</head>
<body class="bg"> 
<?php
	include 'Nav/header_mm.php';
	include 'Modal/requested_parts_modal.php';
	include 'Modal/add_remarks_mm.php';
	include 'Modal/add_remarks_mm_notif.php';
	include 'Modal/search_tc.php';
	include 'Modal/add_remarks_tc_search.php';
	include 'Modal/news_windows.php'; 
?>
<div class="card_opa ml-0 mr-0">
	<div class="row ml-0 mr-0">
		<div class="col-sm-4 col-md-4 col-lg-4">
		</div>
		<div class="col-sm-4 col-md-4 col-lg-4 text-center mt-1">
			<label class="h3"><i class="fas fa-cogs"></i><i class="fas fa-user-tag"></i> Requested Parts</label>
		</div>
		<div class="col-sm-12 col-md-12 col-lg-12 text-center mt-1">
			<button class="btn btn-info float-right" onclick="search_modal_open()"><i class="fas fa-search"></i> Search</button>
		</div>
	</div>
	<input type="hidden" id="count_kanban_entries">
	<div class="row mx-0 col-sm-12 col-md-12 col-lg-12">
		<table class="table table-bordered table-sm" id='idtb_all_req'>
			<thead class="blue-grey lighten-3">
				<tr>
					<th class="h6">No</th>
					<th class="h6">Request ID</th>
					<th class="h6">Scooter Station</th>
					<th class="h6">Request Data & Time</th>
					<th class="h6">Kanban</th>
					<th class="h6">Requested By</th>
				</tr>
			</thead>
			<tbody id="requested_parts">
			</tbody>
		</table>
	</div>
		<br>
		<br>
		<br>
	<div class="col-sm-12 col-md-12 col-lg-12 text-center mt-1" id="ongoing_parts_label_section">
		<label class="h4"><i class="fas fa-sync"></i> Ongoing Picking</label>	
	</div>
	<div class="row mx-0 col-sm-12 col-md-12 col-lg-12" id="ongoing_parts_section">
		<table class="table table-bordered table-sm">
			<thead class="blue-grey lighten-3">
				<tr>
					<th class="h6">No</th>
					<th class="h6">Request ID</th>
					<th class="h6">Scooter Station</th>
					<th class="h6">Request Data & Time</th>
					<th class="h6">Kanban</th>
					<th class="h6">Requested By</th>
				</tr>
			</thead>
			<tbody id="ongoing_picking_parts">
			</tbody>
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
<!-- My Realtime Notification-->
<script type="text/javascript" src="myjs/realtime_mm.js"></script>
<!--script type="text/javascript" src="myjs/check_out.js"></script-->
<!-- My JacaScript of News-->
<!--script type="text/javascript" src="myjs/news_window.js"></script-->

<!--For Enter in Search-->
<script>
//For Line No
var line_no_search = document.getElementById("line_no_search");
line_no_search.addEventListener("keyup", function(event) {
	if (event.keyCode === 13){
		event.preventDefault();
		search_action_tc();
	}
});

//For Parts Code
var parts_code_search = document.getElementById("parts_code_search1");
parts_code_search.addEventListener("keyup", function(event) {
	if (event.keyCode === 13){
		event.preventDefault();
		search_action_tc();
	}
});

//For Parts Name
var parts_name_search = document.getElementById("parts_name_search1");
parts_name_search.addEventListener("keyup", function(event) {
	if (event.keyCode === 13){
		event.preventDefault();
		search_action_tc();
	}
});

//For Comment
var comment_search = document.getElementById("comment_search1");
comment_search.addEventListener("keyup", function(event) {
	if (event.keyCode === 13){
		event.preventDefault();
		search_action_tc();
	}
});

//For Length
var length_search = document.getElementById("length_search1");
length_search.addEventListener("keyup", function(event) {
	if (event.keyCode === 13){
		event.preventDefault();
		search_action_tc();
	}
});
</script>
<script>
	// For Search Parts In Modal
	function search_modal_open(){
		$("#Search_Modal_Form_admin").modal();
	}
	function status_change(){
		search_action_tc();
	}
	function search_action_tc(){
		document.getElementById('search_result_all').innerHTML="";
		document.getElementById('loading_indicator_search').style.display="inline-block";
		document.getElementById('load_more_botton').style.display="none";
		var date_from = document.getElementById('date_from').value;
		var date_to = document.getElementById('date_to').value;
		var search_status = document.getElementById('search_status').value;
		var line_no_search = document.getElementById('line_no_search').value;
		var parts_code_search1 = document.getElementById('parts_code_search1').value;
		var parts_name_search1 = document.getElementById('parts_name_search1').value;
		var comment_search1 = document.getElementById('comment_search1').value;
		var length_search1 = document.getElementById('length_search1').value;
		var limiter_search = 0;
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function(){
			if (this.readyState == 4 && this.status == 200){
				var response = this.responseText;
				if (response == ''){
					document.getElementById('loading_indicator_search').style.display="none";
					document.getElementById('search_result_all').innerHTML= "<td colspan='15' style='font-weight:bold;color:red;'><center>NO DATA FOUND</center></td>";
				}else{
					document.getElementById('limiter_search').value=20;
					document.getElementById('loading_indicator_search').style.display="none";
					document.getElementById('search_result_all').innerHTML= response;
				}
				search_counter();
			}
		};
		xhttp.open("GET", "AJAX/search_parts_prod.php?operation=display_all&&date_from="+date_from+"&&date_to="+date_to+"&&search_status="+search_status+"&&line_no_search="+line_no_search+"&&parts_name_search1="+parts_name_search1+"&&parts_code_search1="+parts_code_search1+"&&comment_search1="+comment_search1+"&&length_search1="+length_search1+"&&limiter_search="+limiter_search, true);
		xhttp.send();
	}
	function search_counter(){
		var date_from = document.getElementById('date_from').value;
		var date_to = document.getElementById('date_to').value;
		var search_status = document.getElementById('search_status').value;
		var line_no_search = document.getElementById('line_no_search').value;
		var parts_code_search1 = document.getElementById('parts_code_search1').value;
		var parts_name_search1 = document.getElementById('parts_name_search1').value;
		var comment_search1 = document.getElementById('comment_search1').value;
		var length_search1 = document.getElementById('length_search1').value;
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function(){
			if (this.readyState == 4 && this.status == 200){
				var response = this.responseText;
				var limiter_search = parseInt(document.getElementById('limiter_search').value);
				var total = parseInt(response);
				if (limiter_search >= total){
					document.getElementById('load_more_botton').style.display="none";
				}else{
					document.getElementById('load_more_botton').style.display="inline-block";
				}
			}
		};
		xhttp.open("GET", "AJAX/search_parts_prod.php?operation=search_counter&&date_from="+date_from+"&&date_to="+date_to+"&&search_status="+search_status+"&&line_no_search="+line_no_search+"&&parts_name_search1="+parts_name_search1+"&&parts_code_search1="+parts_code_search1+"&&comment_search1="+comment_search1+"&&length_search1="+length_search1, true);
		xhttp.send();
	}
	function see_more_search(){
		document.getElementById('loading_indicator_search').style.display="inline-block";
		document.getElementById('load_more_botton').style.display="none";
		var date_from = document.getElementById('date_from').value;
		var date_to = document.getElementById('date_to').value;
		var search_status = document.getElementById('search_status').value;
		var line_no_search = document.getElementById('line_no_search').value;
		var parts_name_search1 = document.getElementById('parts_name_search1').value;
		var parts_code_search1 = document.getElementById('parts_code_search1').value;
		var comment_search1 = document.getElementById('comment_search1').value;
		var length_search1 = document.getElementById('length_search1').value;
		var limiter_search = document.getElementById('limiter_search').value;
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function(){
			if (this.readyState == 4 && this.status == 200){
				var response = this.responseText;
				if (response ==''){
					document.getElementById('loading_indicator_search').style.display="none";
					document.getElementById('search_result_all').innerHTML= "<td colspan='15' style='font-weight:bold;color:red;'><center>NO DATA FOUND</center></td>";
				}else{
					document.getElementById('limiter_search').value= parseInt(limiter_search) + 20;
					document.getElementById('loading_indicator_search').style.display="none";
					document.getElementById('search_result_all').innerHTML += response;
				}
				search_counter();
			}
		};
		xhttp.open("GET", "AJAX/search_parts_prod.php?operation=display_all&&date_from="+date_from+"&&date_to="+date_to+"&&search_status="+search_status+"&&line_no_search="+line_no_search+"&&parts_name_search1="+parts_name_search1+"&&parts_code_search1="+parts_code_search1+"&&comment_search1="+comment_search1+"&&length_search1="+length_search1+"&&limiter_search="+limiter_search, true);
		xhttp.send();
	}
</script>
<script>
	var kanban_scan_ready_delivery = document.getElementById("kanban_scan_ready_delivery");
	kanban_scan_ready_delivery.addEventListener("keyup", function(event) {
		if (event.keyCode === 13){
			event.preventDefault();
			kanban_scan_ready_delivery_action();
		}
	});
</script>
<script>
	var user_id = document.getElementById("user_id");
	user_id.addEventListener("keyup", function(event) {
		if (event.keyCode === 13){
			event.preventDefault();
			user_id_confirmation();
		}
	});
</script>
<script>
function display_all_requested(){
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			var response = this.responseText;
			document.getElementById('requested_parts').innerHTML=response;
			display_all_requested_ongoing();
			
		}
	};
	xhttp.open("GET", "AJAX/get_requested.php?operation=display_all", true);
	xhttp.send();
}
function display_all_requested_ongoing(){
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			var response = this.responseText;
			document.getElementById('ongoing_picking_parts').innerHTML=response;
			
		}
	};
	xhttp.open("GET", "AJAX/get_requested.php?operation=display_all_ongoing", true);
	xhttp.send();
}
function open_details_request(x){
	var split = x.split('~!~');
	var id_scanned_kanban = split[0];
	var real_time_status = split[1];
	$("#Requested_Parts").modal();
	if(real_time_status == 'Pending'){
		display_print_category_pending(id_scanned_kanban);
		document.getElementById('print_this_button').style.display="inline-block";
		document.getElementById('confirm_id_button').style.display="none";
		document.getElementById('content_section_for_kanban').innerHTML='<table class="table table-bordered"><thead class="blue-grey lighten-4"><tr><th>Line No</th><th>Stock Address</th><th>Parts Code</th><th>Parts Name</th><th>Comment</th><th>Length(mm)</th><th>Quantity</th><th>KBN No</th><th>Time Scanned</th><th>Receiving Time</th></tr></thead><tbody id="scanned_kanban_section_mm"></tbody></table>';
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			var response = this.responseText;
			get_requestor_name(id_scanned_kanban);
			document.getElementById('scanned_kanban_section_mm').innerHTML=response;
			document.getElementById('id_scanned_kanban_selected').value=x;
		}
		};
		xhttp.open("GET", "AJAX/get_requested.php?operation=open_details_request&&id_scanned_kanban="+id_scanned_kanban, true);
		xhttp.send();
	}else if(real_time_status == 'Ongoing Picking'){
		display_print_category_ongoing_picking(id_scanned_kanban);
		//document.getElementById('confirm_id_button').style.display="inline-block";
		//document.getElementById('print_this_button').style.display="none";
		document.getElementById('id_scanned_kanban_selected').value=x;
		document.getElementById('requestor_name_section').innerHTML='';
		document.getElementById('update_ready_for_delivery_section').style.display='inline-block';
		setTimeout(function (){
			$('#kanban_scan_ready_delivery').focus();
		}, 100);
		get_update_to_delivery();
	}
}
function display_print_category_pending(x){
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			var response = this.responseText;
			document.getElementById('select_print_category').innerHTML='<option selected>Please Select</option>'+response;
		}
	};
	xhttp.open("GET", "AJAX/get_requested.php?operation=display_print_category_pending&&id_scanned_kanban="+x, true);
	xhttp.send();
}
function display_print_category_ongoing_picking(x){
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			var response = this.responseText;
			document.getElementById('select_print_category').innerHTML='<option selected>Please Select</option>'+response;
		}
	};
	xhttp.open("GET", "AJAX/get_requested.php?operation=display_print_category_ongoing_picking&&id_scanned_kanban="+x, true);
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
	xhttp.open("GET", "AJAX/get_requested.php?operation=get_requestor_name&&id_scanned_kanban="+x, true);
	xhttp.send();
}
function kanban_scan_ready_delivery_action(){
	var id_scanned_kanban = document.getElementById('id_scanned_kanban_selected').value;
	var split = id_scanned_kanban.split('~!~');
	var id_scanned_kanban = split[0];
	var kanban_scan_ready_delivery = document.getElementById("kanban_scan_ready_delivery").value;
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			var response = this.responseText;
			if(response == "Record updated successfully"){
				get_update_to_delivery();
			}else{
				document.getElementById("kanban_scan_ready_delivery").value='';
			}
		}
	};
	xhttp.open("GET", "AJAX/update_ready_delivery.php?operation=update_ready_for_delivery&&kanban_scan_ready_delivery="+kanban_scan_ready_delivery+"&&id_scanned_kanban="+id_scanned_kanban, true);
	xhttp.send();
}
function get_update_to_delivery(){
	var id_scanned_kanban = document.getElementById('id_scanned_kanban_selected').value;
	var split = id_scanned_kanban.split('~!~');
	var id_scanned_kanban = split[0];
	document.getElementById('content_section_for_kanban').innerHTML='<table class="table table-bordered"><thead class="blue-grey lighten-4"><tr><th>Line No</th><th>Stock Address</th><th>Parts Code</th><th>Parts Name</th><th>Comment</th><th>Length(mm)</th><th>Quantity</th><th>KBN No</th><th>Time Scanned</th><th>Receiving Time</th><th>Remarks</th><th>Distributor Remarks</th></tr></thead><tbody id="scanned_kanban_section_mm"></tbody></table>';
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
	if(this.readyState == 4 && this.status == 200){
		var response = this.responseText;
		get_requestor_name(id_scanned_kanban);
		document.getElementById('scanned_kanban_section_mm').innerHTML=response;
		document.getElementById('kanban_scan_ready_delivery').value='';
	}
	};
	xhttp.open("GET", "AJAX/get_requested.php?operation=open_details_request_ready_delivery&&id_scanned_kanban="+id_scanned_kanban, true);
	xhttp.send();
}
function add_remarks_mm(x){
	var split = x.split('~!~');
	var id_scanned_kanban = split[0];
	var kanban = split[1];
	var kanban_num = split[2];
	var scan_date_time = split[3];
	var request_date_time = split[4];
	var scooter_station = split[5];
	document.getElementById('remarks_id_scanned_kanban').value = id_scanned_kanban;
	document.getElementById('remarks_kanban').value = kanban;
	document.getElementById('remarks_kanban_num').value = kanban_num;
	document.getElementById('remarks_scan_date_time').value = scan_date_time;
	document.getElementById('remarks_request_date_time').value = request_date_time;
	document.getElementById('remarks_scooter_station').value = scooter_station;
	$("#Add_Remarks_Form").modal();
}
function save_tc_remarks_search(){
	display_all_requested();
	var remarks_id_scanned_kanban = document.getElementById('remarks_id_scanned_kanban_search').value;
	var remarks_kanban = document.getElementById('remarks_kanban_search').value;
	var remarks_kanban_num = document.getElementById('remarks_kanban_num_search').value;
	var remarks_scan_date_time = document.getElementById('remarks_scan_date_time_search').value;
	var remarks_request_date_time = document.getElementById('remarks_request_date_time_search').value;
	var mm_remarks = document.getElementById('mm_remarks_search').value;
	var scooter_station = document.getElementById('remarks_scooter_station_search').value;
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
	if(this.readyState == 4 && this.status == 200){
		var response = this.responseText;
		document.getElementById('out_tc_remarks_search').innerHTML=response;
		get_update_to_delivery();
		setTimeout(close_modal_remarks_search, 1000);
	}
	};
	xhttp.open("GET", "AJAX/remarks.php?operation=add_remarks_mm&&remarks_id_scanned_kanban="+remarks_id_scanned_kanban+"&&remarks_kanban="+remarks_kanban+"&&remarks_kanban_num="+remarks_kanban_num+"&&remarks_scan_date_time="+remarks_scan_date_time+"&&remarks_request_date_time="+remarks_request_date_time+"&&mm_remarks="+mm_remarks+"&&scooter_station="+scooter_station, true);
	xhttp.send();
}
function save_mm_remarks(){
	display_all_requested();
	var remarks_id_scanned_kanban = document.getElementById('remarks_id_scanned_kanban').value;
	var remarks_kanban = document.getElementById('remarks_kanban').value;
	var remarks_kanban_num = document.getElementById('remarks_kanban_num').value;
	var remarks_scan_date_time = document.getElementById('remarks_scan_date_time').value;
	var remarks_request_date_time = document.getElementById('remarks_request_date_time').value;
	var mm_remarks = document.getElementById('mm_remarks').value;
	var scooter_station = document.getElementById('remarks_scooter_station').value;
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
	if(this.readyState == 4 && this.status == 200){
		var response = this.responseText;
		document.getElementById('out_mm_remarks').innerHTML=response;
		get_update_to_delivery();
		setTimeout(close_modal_remarks, 1000);
	}
	};
	xhttp.open("GET", "AJAX/remarks.php?operation=add_remarks_mm&&remarks_id_scanned_kanban="+remarks_id_scanned_kanban+"&&remarks_kanban="+remarks_kanban+"&&remarks_kanban_num="+remarks_kanban_num+"&&remarks_scan_date_time="+remarks_scan_date_time+"&&remarks_request_date_time="+remarks_request_date_time+"&&mm_remarks="+mm_remarks+"&&scooter_station="+scooter_station, true);
	xhttp.send();
}
function save_mm_remarks1(){
	display_all_requested();
	var remarks_id_scanned_kanban = document.getElementById('remarks_id_scanned_kanban1').value;
	var remarks_kanban = document.getElementById('remarks_kanban1').value;
	var remarks_kanban_num = document.getElementById('remarks_kanban_num1').value;
	var remarks_scan_date_time = document.getElementById('remarks_scan_date_time1').value;
	var remarks_request_date_time = document.getElementById('remarks_request_date_time1').value;
	var mm_remarks = document.getElementById('mm_remarks1').value;
	var scooter_station = document.getElementById('remarks_scooter_station1').value;
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
	if(this.readyState == 4 && this.status == 200){
		var response = this.responseText;
		document.getElementById('out_mm_remarks1').innerHTML=response;
		get_update_to_delivery1(remarks_id_scanned_kanban+'~!~'+remarks_kanban+'~!~'+remarks_kanban_num+'~!~'+remarks_scan_date_time+'~!~'+remarks_request_date_time);
		setTimeout(close_modal_remarks1, 1000);
		realtime_remarks();
	}
	};
	xhttp.open("GET", "AJAX/remarks.php?operation=add_remarks_mm&&remarks_id_scanned_kanban="+remarks_id_scanned_kanban+"&&remarks_kanban="+remarks_kanban+"&&remarks_kanban_num="+remarks_kanban_num+"&&remarks_scan_date_time="+remarks_scan_date_time+"&&remarks_request_date_time="+remarks_request_date_time+"&&mm_remarks="+mm_remarks+"&&scooter_station="+scooter_station, true);
	xhttp.send();
}
function get_update_to_delivery1(x){
	var split = x.split('~!~');
	var id_scanned_kanban = split[0];
	var kanban = split[1];
	var kanban_num = split[2];
	var scan_date_time = split[3];
	var request_date_time = split[4];
	document.getElementById('content_section_for_kanban').innerHTML='<table class="table table-bordered"><thead class="blue-grey lighten-4"><tr><th>Line No</th><th>Stock Address</th><th>Parts Code</th><th>Parts Name</th><th>Quantity</th><th>Time Scanned</th><th>Receiving Time</th><th>Remarks</th><th>Distributor Remarks</th><th>Status</th></tr></thead><tbody id="scanned_kanban_section_mm"></tbody></table>';
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
	if(this.readyState == 4 && this.status == 200){
		var response = this.responseText;
		get_requestor_name(id_scanned_kanban);
		document.getElementById('scanned_kanban_section_mm').innerHTML=response;
		document.getElementById('kanban_scan_ready_delivery').value='';
	}
	};
	xhttp.open("GET", "AJAX/realtime_remarks.php?operation=reload_now_mm&&id_scanned_kanban="+id_scanned_kanban+"&&kanban="+kanban+"&&kanban_num="+kanban_num+"&&scan_date_time="+scan_date_time+"&&request_date_time="+request_date_time, true);
	xhttp.send();
}
function read_remarks(x){
	display_all_requested();
	var split = x.split('~!~');
	var id_scanned_kanban = split[0];
	var kanban = split[1];
	var kanban_num = split[2];
	var scan_date_time = split[3];
	var request_date_time = split[4];
	var scooter_station = split[5];
	$("#Requested_Parts").modal();
	document.getElementById('content_section_for_kanban').innerHTML='<table class="table table-bordered"><thead class="blue-grey lighten-4"><tr><th>Line No</th><th>Stock Address</th><th>Parts Code</th><th>Parts Name</th><th>Comment</th><th>Length(mm)</th><th>Quantity</th><th>Time Scanned</th><th>Receiving Time</th><th>Remarks</th><th>Distributor Remarks</th><th>Status</th></tr></thead><tbody id="scanned_kanban_section_mm"></tbody></table>';
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
	if(this.readyState == 4 && this.status == 200){
		var response = this.responseText;
		get_requestor_name(id_scanned_kanban);
		document.getElementById('scanned_kanban_section_mm').innerHTML=response;
	}
	};
	xhttp.open("GET", "AJAX/realtime_remarks.php?operation=read_remarks_now_mm&&id_scanned_kanban="+id_scanned_kanban+"&&kanban="+kanban+"&&kanban_num="+kanban_num+"&&scan_date_time="+scan_date_time+"&&request_date_time="+request_date_time+"&&scooter_station="+scooter_station, true);
	xhttp.send();
}
function add_remarks_mm_notif(x){
	var split = x.split('~!~');
	var id_scanned_kanban = split[0];
	var kanban = split[1];
	var kanban_num = split[2];
	var scan_date_time = split[3];
	var request_date_time = split[4];
	var remarks_real_time_status = split[5];
	var scooter_station = split[6];
	document.getElementById('remarks_id_scanned_kanban1').value = id_scanned_kanban;
	document.getElementById('remarks_kanban1').value = kanban;
	document.getElementById('remarks_kanban_num1').value = kanban_num;
	document.getElementById('remarks_scan_date_time1').value = scan_date_time;
	document.getElementById('remarks_request_date_time1').value = request_date_time;
	document.getElementById('remarks_real_time_status1').value = remarks_real_time_status;
	document.getElementById('remarks_scooter_station1').value = scooter_station;
	$("#Add_Remarks_Form1").modal();
}
function user_id_confirmation(){
	var id_scanned_kanban = document.getElementById('id_scanned_kanban_selected').value;
	var split = id_scanned_kanban.split('~!~');
	var id_scanned_kanban = split[0];
	var user_id = document.getElementById('user_id').value;
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
	if(this.readyState == 4 && this.status == 200){
		var response = this.responseText;
		document.getElementById('out_delivery').innerHTML=response;
		if(response == 'Parts is Ready for Delivery'){
			display_all_requested();
			go_to_history();
		}else if(response == 'Unable to Update'){
			
		}
	}
	};
	xhttp.open("GET", "AJAX/id_confirmation.php?operation=confirm_id_to_delivery&&user_id="+user_id+"&&id_scanned_kanban="+id_scanned_kanban, true);
	xhttp.send();
}
function go_to_history(){
	var id_scanned_kanban = document.getElementById('id_scanned_kanban_selected').value;
	var split = id_scanned_kanban.split('~!~');
	var id_scanned_kanban = split[0];
	var user_id = document.getElementById('user_id').value;
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
	if(this.readyState == 4 && this.status == 200){
		var response = this.responseText;
		document.getElementById('user_id').value='';
		setTimeout(close_modal,2000);
		
	}
	};
	xhttp.open("GET", "AJAX/update_history.php?operation=update_history&&user_id="+user_id+"&&id_scanned_kanban="+id_scanned_kanban, true);
	xhttp.send();
}
function confirm_id(){
	document.getElementById('user_id_section').style.display='inline-block';
	document.getElementById('user_id').focus();
}
function print_this(){
	var select_print_category = document.getElementById('select_print_category').value;
	var id_scanned_kanban = document.getElementById('id_scanned_kanban_selected').value;
	var split = id_scanned_kanban.split('~!~');
	var id_scanned_kanban = split[0];
	window.open('print_parts.php?id_scanned_kanban='+id_scanned_kanban+'&&print_category='+select_print_category,'_blank');
	setTimeout(display_all_requested,5000);
}
function close_modal(){
	$('#Requested_Parts').modal('toggle');
	clear();
}
function close_modal_remarks(){
	$('#Add_Remarks_Form').modal('toggle');
	document.getElementById('out_mm_remarks').innerHTML='';
	document.getElementById('mm_remarks').value='';
	document.getElementById('remarks_id_scanned_kanban').value='';
	document.getElementById('remarks_kanban').value='';
	document.getElementById('remarks_kanban_num').value='';
	document.getElementById('remarks_scan_date_time').value='';
	document.getElementById('remarks_request_date_time').value='';
}
function close_modal_remarks1(){
	$('#Add_Remarks_Form1').modal('toggle');
	document.getElementById('out_mm_remarks1').innerHTML='';
	document.getElementById('mm_remarks1').value='';
	document.getElementById('remarks_id_scanned_kanban1').value='';
	document.getElementById('remarks_kanban1').value='';
	document.getElementById('remarks_kanban_num1').value='';
	document.getElementById('remarks_scan_date_time1').value='';
	document.getElementById('remarks_request_date_time1').value='';
}
function close_modal_remarks_search(){
	$('#Add_Remarks_Form_Search').modal('toggle');
	document.getElementById('out_tc_remarks_search').innerHTML='';
	document.getElementById('mm_remarks_search').value='';
	document.getElementById('remarks_id_scanned_kanban').value='';
	document.getElementById('remarks_kanban').value='';
	document.getElementById('remarks_kanban_num').value='';
	document.getElementById('remarks_scan_date_time').value='';
	document.getElementById('remarks_request_date_time').value='';
}
function clear(){
	document.getElementById('out_delivery').innerHTML='';
	document.getElementById('content_section_for_kanban').innerHTML='';
	document.getElementById('requestor_name_section').innerHTML='';
	document.getElementById('user_id').value='';
	document.getElementById('kanban_scan_ready_delivery').value='';
	document.getElementById('user_id_section').style.display='none';
	document.getElementById('update_ready_for_delivery_section').style.display='none';
	
}
function add_remarks_tc_search(x){
	var split = x.split('~!~');
	var id_scanned_kanban = split[0];
	var kanban = split[1];
	var kanban_num = split[2];
	var scan_date_time = split[3];
	var request_date_time = split[4];
	var remarks_scooter_station = split[5];
	document.getElementById('remarks_id_scanned_kanban_search').value = id_scanned_kanban;
	document.getElementById('remarks_kanban_search').value = kanban;
	document.getElementById('remarks_kanban_num_search').value = kanban_num;
	document.getElementById('remarks_scan_date_time_search').value = scan_date_time;
	document.getElementById('remarks_request_date_time_search').value = request_date_time;
	document.getElementById('remarks_scooter_station_search').value = remarks_scooter_station;
	$("#Add_Remarks_Form_Search").modal();
}
function print_kanban_search(x){
	window.open('print_parts_search.php?id='+x,'_blank');
}
display_all_requested();
</script>
</body>
</html>
