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
	<link href="mycss/tracking.css" rel="stylesheet">
	<link rel="shortcut icon" href="favicon.ico" type="image/ico">
	<link href="favicon.png" rel="icon">
</head>
<body class="bg"> 
<?php
	include 'Nav/header_mm.php';
	include 'Modal/requested_parts_modal.php';
	include 'Modal/add_remarks_mm.php';
	include 'Modal/add_remarks_mm_notif.php';
	include 'Modal/search_mm.php';
	include 'Modal/add_remarks_tc_search.php';
	include 'Modal/open_reprint_history.php';
	include 'Modal/reprint_option.php';
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
			<button class="btn unique-color text-white float-right" onclick="search_modal_open()"><i class="fas fa-search"></i> Search</button>
		</div>
	</div>
	<input type="hidden" id="count_kanban_entries">
	<!-- For Realtime -->
	<input type="hidden" id="count_pending">
	<input type="hidden" id="count_op">
	<div class="row mx-0 col-sm-12 col-md-12 col-lg-12">
		<table class="table table-bordered table-sm" id='idtb_all_req'>
			<thead class="unique-color text-white">
				<tr>
					<th class="h6">No</th>
					<th class="h6">Request ID</th>
					<th class="h6">Scooter Station</th>
					<th class="h6">Request Data & Time</th>
					<th class="h6">Kanban</th>
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
			<thead class="unique-color text-white">
				<tr>
					<th class="h6">No</th>
					<th class="h6">Request ID</th>
					<th class="h6">Scooter Station</th>
					<th class="h6">Request Data & Time</th>
					<th class="h6">Kanban</th>
				</tr>
			</thead>
			<tbody id="ongoing_picking_parts">
			</tbody>
		</table>
	</div>
	<div class="col-sm-12 col-md-12 col-lg-12 text-center mt-0 mb-0 pt-0 pb-0">
		<div class="loader_popup text-center" id="loader_indicator_op" style="display:none;">Loading....</div>
	</div>
	<div class="my-0 mx-0 col-sm-12 col-md-12 col-lg-12">
		<label class="col-sm-12 col-md-12 col-lg-12 text-right" id="counter_viewer_op"></label>
	</div>
	<div class="row mx-0 col-sm-12 col-md-12 col-lg-12">
		<input type="hidden" id="load_more_counter_op" value="0"> <!--  Loadmore Limiter Count  -->
		<!-- <input type="hidden" id="filters_hidden" value="0">  Filters  -->
		<div class="rounded-circle unique-color white-text waves-effect card-img-100 mx-auto mb-1 pulse" id="load_more_botton_op" style="margin-top:-10px;width:50px;height:50px;cursor:pointer;display:none;" onclick="load_more_request_op()" data-toggle="tooltip" data-placement="top" title="Load More">
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
<!-- My Realtime Notification-->
<script type="text/javascript" src="myjs/realtime_mm.js"></script>
<!-- My Tooltip Initialization-->
<script type="text/javascript" src="myjs/tool_tip.js"></script>
<!-- My Realtime Conversation-->
<script type="text/javascript" src="myjs/realtime_conversation.js"></script>
<!--script type="text/javascript" src="myjs/check_out.js"></script-->
<!-- My JavaScript of News-->
<script type="text/javascript" src="myjs/news_window.js"></script>

<!--For Enter in Search-->
<script>
	//For Line No
	var line_no_search = document.getElementById("line_no_search");
	line_no_search.addEventListener("keyup", function(event) {
		if (event.keyCode === 13){
			event.preventDefault();
			search_action_mm();
		}
	});

	//For Parts Code
	var parts_code_search = document.getElementById("parts_code_search1");
	parts_code_search.addEventListener("keyup", function(event) {
		if (event.keyCode === 13){
			event.preventDefault();
			search_action_mm();
		}
	});

	//For Parts Name
	var parts_name_search = document.getElementById("parts_name_search1");
	parts_name_search.addEventListener("keyup", function(event) {
		if (event.keyCode === 13){
			event.preventDefault();
			search_action_mm();
		}
	});
</script>
<script>
// For Search Parts In Modal
const search_modal_open =()=>{
	$("#Search_Modal_Form_admin").modal('show');
	document.getElementById('search_mm_status').value='Open';
}
const status_change =()=>{
	search_action_mm();
}
const display_all_requested =()=>{
let xhttp = new XMLHttpRequest();
xhttp.onreadystatechange = function(){
	if(this.readyState == 4 && this.status == 200){
		let response = this.responseText;
		document.getElementById('requested_parts').innerHTML=response;
		display_all_requested_ongoing();
	}
};
xhttp.open("GET", "AJAX/get_requested_printing.php?operation=display_pending", true);
xhttp.send();
}
const display_all_requested_ongoing =()=>{
	let xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			let response = this.responseText;
			document.getElementById('ongoing_picking_parts').innerHTML=response;
			document.getElementById('load_more_counter_op').value=50;
			count_requested_ongoing();
		}
	};
	xhttp.open("GET", "AJAX/get_requested_printing.php?operation=display_ongoing&&limiter_count=0", true);
	xhttp.send();
}
const count_requested_ongoing =()=>{
	let xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			let response = this.responseText;
			let total_count = parseInt(response);
			let table_rows = parseInt(document.getElementById("ongoing_picking_parts").rows.length);
			let load_more_counter_op = document.getElementById('load_more_counter_op').value;
			document.getElementById('counter_viewer_op').innerHTML=table_rows +' - '+ total_count;
			if (total_count == 0){
				document.getElementById('load_more_botton_op').style.display='none';
			}else if (total_count > load_more_counter_op){
				document.getElementById('load_more_botton_op').style.display='inline-block';
			}else if (total_count < load_more_counter_op){
				document.getElementById('load_more_botton_op').style.display='none';
			}
		}
	};
	xhttp.open("GET", "AJAX/get_requested_printing.php?operation=count_requested_ongoing", true);
	xhttp.send();
}
const load_more_request_op =()=>{
	document.getElementById('load_more_botton_op').style.display="none";
	document.getElementById('loader_indicator_op').style.display="inline-block";
	let load_more_counter_op = parseInt(document.getElementById('load_more_counter_op').value);
	let xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			let response = this.responseText;
			document.getElementById('ongoing_picking_parts').innerHTML+=response;
			document.getElementById('loader_indicator_op').style.display="none";
			document.getElementById('load_more_counter_op').value = load_more_counter_op + 50;
			count_requested_ongoing();
		}
	};
	xhttp.open("GET", "AJAX/get_requested_printing.php?operation=display_ongoing&&limiter_count="+load_more_counter_op, true);
	xhttp.send();
}
const open_details_request =(x)=>{
	let split = x.split('~!~');
	let id_scanned_kanban = split[0];
	let status = split[1];
	let requested_by = split[2];
	$("#Requested_Parts").modal('show');
	//Getting the Requestor Name
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
	if(this.readyState == 4 && this.status == 200){
		var response = this.responseText;
		document.getElementById('requestor_name_section').innerHTML=response;
		document.getElementById('requested_id_section').innerHTML='<i class="fab fa-slack-hash"></i> '+id_scanned_kanban;
		document.getElementById('status_head_section').innerHTML='<i class="fas fa-ellipsis-h"></i> '+status;
		document.getElementById('id_scanned_kanban_selected').value=x;
		document.getElementById('open_details_mm_status').value='Open';
		if(status == 'Pending'){
			//Getting Request on Pending
			open_details_requested_pending(id_scanned_kanban);
		}else{
			//Getting Request on Ongoing Picking
			open_details_requested_op(id_scanned_kanban);
		}
	}
	};
	xhttp.open("GET", "AJAX/get_requested.php?operation=get_requestor_name&&id_scanned_kanban="+id_scanned_kanban+"&&requested_by="+requested_by, true);
	xhttp.send();
}
const open_details_requested_pending =(id_scanned_kanban)=>{
	//Getting All Pending
	let xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
	if(this.readyState == 4 && this.status == 200){
		let response = this.responseText;
		document.getElementById('tracked_pending').style.display='flex';
		document.getElementById('tracked_ongoing').style.display='none';
		document.getElementById('scanned_kanban_section_mm').innerHTML=response;
		display_print_category_pending(id_scanned_kanban);
	}
	};
	xhttp.open("GET", "AJAX/get_requested_printing.php?operation=open_details_requested_pending&&id_scanned_kanban="+id_scanned_kanban, true);
	xhttp.send();
}
const open_details_requested_op =(id_scanned_kanban)=>{
	//Getting All Ongoing Picking
	let xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
	if(this.readyState == 4 && this.status == 200){
		let response = this.responseText;
		document.getElementById('tracked_pending').style.display='none';
		document.getElementById('tracked_ongoing').style.display='flex';
		document.getElementById('scanned_kanban_section_mm').innerHTML=response;
		display_print_category_ongoing_picking(id_scanned_kanban);
	}
	};
	xhttp.open("GET", "AJAX/get_requested_printing.php?operation=open_details_requested_op&&id_scanned_kanban="+id_scanned_kanban, true);
	//xhttp.open("GET", "AJAX/open_details_requested_op.php?operation=open_details_requested_pending&&id_scanned_kanban="+id_scanned_kanban, true);
	xhttp.send();
}
const display_print_category_pending =(id_scanned_kanban)=>{
	let xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			let response = this.responseText;
			update_selection(id_scanned_kanban);
			document.getElementById('select_print_category').innerHTML='<option selected>Please Select</option>'+response;
		}
	};
	xhttp.open("GET", "AJAX/get_requested_printing.php?operation=display_print_category_pending&&id_scanned_kanban="+id_scanned_kanban, true);
	xhttp.send();
}
const display_print_category_ongoing_picking =(id_scanned_kanban)=>{
	let xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			let response = this.responseText;
			//update_selection(id_scanned_kanban);
			document.getElementById('select_print_category').innerHTML='<option selected>Please Select</option>'+response;
		}
	};
	xhttp.open("GET", "AJAX/get_requested_printing.php?operation=display_print_category_ongoing_picking&&id_scanned_kanban="+id_scanned_kanban, true);
	xhttp.send();
}
const update_selection =(id_scanned_kanban)=>{
	let xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			let response = this.responseText;
		}
	};
	xhttp.open("GET", "AJAX/get_requested_printing.php?operation=update_selection&&id_scanned_kanban="+id_scanned_kanban, true);
	xhttp.send();
}
const print_this =()=>{
	let select_print_category = document.getElementById('select_print_category').value;
	let id_scanned_kanban_selected = document.getElementById('id_scanned_kanban_selected').value;
	let split = id_scanned_kanban_selected.split('~!~');
	let id_scanned_kanban = split[0];
	let status = split[1];
	let requested_by = split[2];
	if(status == 'Pending'){
		window.open('print_parts.php?id_scanned_kanban='+id_scanned_kanban+'&&print_category='+select_print_category,'_blank');
		setTimeout(open_reprint_option, 2500);//Show the Confirmation after 2.5secs
	}else if (status == 'Ongoing Picking'){
		window.open('print_ongoing.php?id_scanned_kanban='+id_scanned_kanban+'&&print_category='+select_print_category,'_blank');
	}
	setTimeout(display_all_requested,5000);
}
const open_reprint_option =()=>{
	$('#Reprint_Option_Kanban').modal('show');
	let select_print_category = document.getElementById('select_print_category').value;
	let id_scanned_kanban_selected = document.getElementById('id_scanned_kanban_selected').value;
	let split = id_scanned_kanban_selected.split('~!~');
	let id_scanned_kanban = split[0];
	let status = split[1];
	let requested_by = split[2];
	let xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
		if (this.readyState == 4 && this.status == 200){
			let response = this.responseText;
			document.getElementById('reprint_pending_option').innerHTML=response;
		}
	};
	xhttp.open("GET", "AJAX/get_requested_printing.php?operation=open_reprint_option&&id_scanned_kanban="+id_scanned_kanban+"&&print_category="+select_print_category, true);
	xhttp.send();

}
const reprint_kanban_new =()=>{
	let select_print_category = document.getElementById('select_print_category').value;
	let id_scanned_kanban_selected = document.getElementById('id_scanned_kanban_selected').value;
	let split = id_scanned_kanban_selected.split('~!~');
	let id_scanned_kanban = split[0];
	let status = split[1];
	let requested_by = split[2];
	window.open('print_ongoing.php?id_scanned_kanban='+id_scanned_kanban+'&&print_category='+select_print_category,'_blank');
}
const cancel_printing_new_kanban =()=>{
	$('#Reprint_Option_Kanban').modal('hide');
}
const close_modal =()=>{
	$('#Requested_Parts').modal('hide');
	document.getElementById('open_details_mm_status').value='Close';
}
const search_action_mm =()=>{
	document.getElementById('search_result_all').innerHTML="";
	document.getElementById('loading_indicator_search').style.display="inline-block";
	document.getElementById('load_more_botton').style.display="none";
	document.getElementById('tracked_pending_search').style.display="none";
	document.getElementById('tracked_op_search').style.display="none";
	let date_from = document.getElementById('date_from').value;
	let date_to = document.getElementById('date_to').value;
	let search_status = document.getElementById('search_status').value;
	let line_no_search = document.getElementById('line_no_search').value;
	let parts_code_search1 = document.getElementById('parts_code_search1').value;
	let parts_name_search1 = document.getElementById('parts_name_search1').value;
	let limiter_search = 0;
	let xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
		if (this.readyState == 4 && this.status == 200){
			let response = this.responseText;
			if (response == ''){
				document.getElementById('loading_indicator_search').style.display="none";
				document.getElementById('search_result_all').innerHTML= "<td colspan='15' style='font-weight:bold;color:red;'><center>NO DATA FOUND</center></td>";
			}else{
				if(search_status == 'Pending'){
					document.getElementById('tracked_pending_search').style.display="flex";
					document.getElementById('tracked_op_search').style.display="none";
				}else if(search_status == 'Ongoing Picking'){
					document.getElementById('tracked_pending_search').style.display="none";
					document.getElementById('tracked_op_search').style.display="flex";
				}
				document.getElementById('limiter_search').value=20;
				document.getElementById('loading_indicator_search').style.display="none";
				document.getElementById('search_result_all').innerHTML= response;
			}
			search_counter();
		}
	};
	xhttp.open("GET", "AJAX/search_parts_mm.php?operation=display_all&&date_from="+date_from+"&&date_to="+date_to+"&&search_status="+search_status+"&&line_no_search="+line_no_search+"&&parts_name_search1="+parts_name_search1+"&&parts_code_search1="+parts_code_search1+"&&limiter_search="+limiter_search, true);
	xhttp.send();
}
const search_counter =()=>{
	let date_from = document.getElementById('date_from').value;
	let date_to = document.getElementById('date_to').value;
	let search_status = document.getElementById('search_status').value;
	let line_no_search = document.getElementById('line_no_search').value;
	let parts_code_search1 = document.getElementById('parts_code_search1').value;
	let parts_name_search1 = document.getElementById('parts_name_search1').value;
	let xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
		if (this.readyState == 4 && this.status == 200){
			let response = this.responseText;
			let limiter_search = parseInt(document.getElementById('limiter_search').value);
			let total = parseInt(response);
			let table_rows = document.getElementById("search_result_all").rows.length;
			document.getElementById('counter_viewer').innerHTML=table_rows +' - '+ total;
			if (total == 0){
				document.getElementById('load_more_botton').style.display="none";
			}else if (limiter_search >= total){
				document.getElementById('load_more_botton').style.display="none";
			}else{
				document.getElementById('load_more_botton').style.display="inline-block";
				document.getElementById('export_excel_showed').style.display='inline-block';
			}
		}
	};
	xhttp.open("GET", "AJAX/search_parts_mm.php?operation=search_counter&&date_from="+date_from+"&&date_to="+date_to+"&&search_status="+search_status+"&&line_no_search="+line_no_search+"&&parts_name_search1="+parts_name_search1+"&&parts_code_search1="+parts_code_search1, true);
	xhttp.send();
}
const see_more_search =()=>{
	document.getElementById('loading_indicator_search').style.display="inline-block";
	document.getElementById('load_more_botton').style.display="none";
	let date_from = document.getElementById('date_from').value;
	let date_to = document.getElementById('date_to').value;
	let search_status = document.getElementById('search_status').value;
	let line_no_search = document.getElementById('line_no_search').value;
	let parts_name_search1 = document.getElementById('parts_name_search1').value;
	let parts_code_search1 = document.getElementById('parts_code_search1').value;
	let limiter_search = document.getElementById('limiter_search').value;
	let xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
		if (this.readyState == 4 && this.status == 200){
			let response = this.responseText;
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
	xhttp.open("GET", "AJAX/search_parts_mm.php?operation=display_all&&date_from="+date_from+"&&date_to="+date_to+"&&search_status="+search_status+"&&line_no_search="+line_no_search+"&&parts_name_search1="+parts_name_search1+"&&parts_code_search1="+parts_code_search1+"&&limiter_search="+limiter_search, true);
	xhttp.send();
}
const add_remarks_mm =(x)=>{
	let split = x.split('~!~');
	let id_scanned_kanban = split[0];
	let kanban = split[1];
	let kanban_num = split[2];
	let scan_date_time = split[3];
	let request_date_time = split[4];
	let scooter_station = split[5];
	let status = split[6];
	document.getElementById('active_conversation').value='Open';
	document.getElementById('remarks_id_scanned_kanban').value = id_scanned_kanban;
	document.getElementById('remarks_kanban').value = kanban;
	document.getElementById('remarks_kanban_num').value = kanban_num;
	document.getElementById('remarks_scan_date_time').value = scan_date_time;
	document.getElementById('remarks_request_date_time').value = request_date_time;
	document.getElementById('remarks_scooter_station').value = scooter_station;
	document.getElementById('remarks_status').value = status;
	$("#Add_Remarks_Form").modal();
	load_remarks_conversation();
	check_conversation_section();
}
const load_remarks_conversation =()=>{
	let remarks_id_scanned_kanban = document.getElementById('remarks_id_scanned_kanban').value;
	let remarks_kanban = document.getElementById('remarks_kanban').value;
	let remarks_kanban_num = document.getElementById('remarks_kanban_num').value;
	let remarks_scan_date_time = document.getElementById('remarks_scan_date_time').value;
	let remarks_request_date_time = document.getElementById('remarks_request_date_time').value;
	let scooter_station = document.getElementById('remarks_scooter_station').value;
	let xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
	if(this.readyState == 4 && this.status == 200){
		let response = this.responseText;
		document.getElementById('convo_remarks').innerHTML=response;
		update_seen();
	}
	};
	xhttp.open("GET", "AJAX/remarks_mm.php?operation=load_remarks_conversation&&remarks_id_scanned_kanban="+remarks_id_scanned_kanban+"&&remarks_kanban="+remarks_kanban+"&&remarks_kanban_num="+remarks_kanban_num+"&&remarks_scan_date_time="+remarks_scan_date_time+"&&remarks_request_date_time="+remarks_request_date_time+"&&scooter_station="+scooter_station, true);
	xhttp.send();
}
const update_seen = ()=>{
	let remarks_id_scanned_kanban = document.getElementById('remarks_id_scanned_kanban').value;
	let remarks_kanban = document.getElementById('remarks_kanban').value;
	let remarks_kanban_num = document.getElementById('remarks_kanban_num').value;
	let remarks_scan_date_time = document.getElementById('remarks_scan_date_time').value;
	let remarks_request_date_time = document.getElementById('remarks_request_date_time').value;
	let scooter_station = document.getElementById('remarks_scooter_station').value;
	let xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
	if(this.readyState == 4 && this.status == 200){
		let response = this.responseText;
	}
	};
	xhttp.open("GET", "AJAX/remarks_mm.php?operation=update_seen&&remarks_id_scanned_kanban="+remarks_id_scanned_kanban+"&&remarks_kanban="+remarks_kanban+"&&remarks_kanban_num="+remarks_kanban_num+"&&remarks_scan_date_time="+remarks_scan_date_time+"&&remarks_request_date_time="+remarks_request_date_time+"&&scooter_station="+scooter_station, true);
	xhttp.send();
}
const save_mm_remarks =()=>{
	let remarks_id_scanned_kanban = document.getElementById('remarks_id_scanned_kanban').value;
	let remarks_kanban = document.getElementById('remarks_kanban').value;
	let remarks_kanban_num = document.getElementById('remarks_kanban_num').value;
	let remarks_scan_date_time = document.getElementById('remarks_scan_date_time').value;
	let remarks_request_date_time = document.getElementById('remarks_request_date_time').value;
	let mm_remarks = document.getElementById('mm_remarks').value;
	let scooter_station = document.getElementById('remarks_scooter_station').value;
	let sender_remarks = '<?php echo $_SESSION['username_session'];?>';
	if(mm_remarks == ''){
		document.getElementById('mm_remarks_Label').innerHTML='Please Enter your Message!';
	}else{
		let xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			let response = this.responseText;
			document.getElementById('mm_remarks').value='';
			load_remarks_conversation();
			check_data_to_reload();
		}
		};
		xhttp.open("GET", "AJAX/remarks_mm.php?operation=add_remarks_mm&&remarks_id_scanned_kanban="+remarks_id_scanned_kanban+"&&remarks_kanban="+remarks_kanban+"&&remarks_kanban_num="+remarks_kanban_num+"&&remarks_scan_date_time="+remarks_scan_date_time+"&&remarks_request_date_time="+remarks_request_date_time+"&&mm_remarks="+mm_remarks+"&&scooter_station="+scooter_station+"&&sender_remarks="+sender_remarks, true);
		xhttp.send();
	}
}
const check_data_to_reload =()=>{
	let open_details_mm_status = document.getElementById('open_details_mm_status').value;
	let search_mm_status = document.getElementById('search_mm_status').value;
	if (open_details_mm_status == 'Open' && search_mm_status == 'Close'){
		let id_scanned_kanban = document.getElementById('remarks_id_scanned_kanban').value;
		let remarks_status = document.getElementById('remarks_status').value;
		if(remarks_status == 'Pending'){
			open_details_requested_pending(id_scanned_kanban);
		}else if(remarks_status == 'Ongoing Picking'){
			open_details_requested_op(id_scanned_kanban);
		}
	}else if(open_details_mm_status == 'Close' && search_mm_status == 'Open'){
		load_search_remarks();
	}
}
const load_search_remarks =()=>{
	// document.getElementById('search_result_all').innerHTML="";
	// document.getElementById('loading_indicator_search').style.display="inline-block";
	document.getElementById('load_more_botton').style.display="none";
	let date_from = document.getElementById('date_from').value;
	let date_to = document.getElementById('date_to').value;
	let search_status = document.getElementById('search_status').value;
	let line_no_search = document.getElementById('line_no_search').value;
	let parts_code_search1 = document.getElementById('parts_code_search1').value;
	let parts_name_search1 = document.getElementById('parts_name_search1').value;
	let limiter_search = 0;
	let xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
		if (this.readyState == 4 && this.status == 200){
			let response = this.responseText;
			if (response == ''){
				//document.getElementById('loading_indicator_search').style.display="none";
				document.getElementById('search_result_all').innerHTML= "<td colspan='15' style='font-weight:bold;color:red;'><center>NO DATA FOUND</center></td>";
			}else{
				document.getElementById('limiter_search').value=20;
				//document.getElementById('loading_indicator_search').style.display="none";
				document.getElementById('search_result_all').innerHTML= response;
			}
			search_counter();
		}
	};
	xhttp.open("GET", "AJAX/search_parts_mm.php?operation=display_all&&date_from="+date_from+"&&date_to="+date_to+"&&search_status="+search_status+"&&line_no_search="+line_no_search+"&&parts_name_search1="+parts_name_search1+"&&parts_code_search1="+parts_code_search1+"&&limiter_search="+limiter_search, true);
	xhttp.send();
}
const close_modal_remarks =()=>{
	$('#Add_Remarks_Form').modal('hide');
	document.getElementById('mm_remarks').value='';
	document.getElementById('remarks_id_scanned_kanban').value='';
	document.getElementById('remarks_kanban').value='';
	document.getElementById('remarks_kanban_num').value='';
	document.getElementById('remarks_scan_date_time').value='';
	document.getElementById('remarks_request_date_time').value='';
	document.getElementById('active_conversation').value='Close';
	clearTimeout(convo_checker);
}
const close_search_mm =()=>{
	$('#Search_Modal_Form_admin').modal('hide');
	document.getElementById('search_mm_status').value='Close';
}
const print_kanban_search =(data_param)=>{
	let split = data_param.split('~!~');
	let id = split[0];
	let status = split[1];
	if (status == 'Pending'){
		window.open('print_search_pending.php?id='+id,'_blank');
	}else if(status == 'Ongoing Picking'){
		window.open('print_search_op.php?id='+id,'_blank');
	}
	// load_search_remarks();
}
const open_reprint_history =(data_param)=>{
	$('#Open_Reprint_History').modal('show');
	let split = data_param.split('~!~');
	let id_scanned_kanban = split[0];
	let kanban = split[1];
	let scan_date_time = split[2];
	let request_date_time = split[3];
	let scooter_station = split[4];
	let status = split[5];
	let xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
		if (this.readyState == 4 && this.status == 200){
			let response = this.responseText;
			document.getElementById('reprint_history_section').innerHTML=response;
		}
	};
	xhttp.open("GET", "AJAX/get_requested_printing.php?operation=open_reprint_history&&id_scanned_kanban="+id_scanned_kanban+"&&kanban="+kanban+"&&scan_date_time="+scan_date_time+"&&request_date_time="+request_date_time+"&&scooter_station="+scooter_station+"&&status="+status, true);
	xhttp.send();
}
const close_modal_reprint_history =(data_param)=>{
	$('#Open_Reprint_History').modal('hide');
}
const export_excel =()=>{
	let date_from = document.getElementById('date_from').value;
	let date_to = document.getElementById('date_to').value;
	let search_status = document.getElementById('search_status').value;
	let line_no_search = document.getElementById('line_no_search').value;
	let parts_code_search1 = document.getElementById('parts_code_search1').value;
	let parts_name_search1 = document.getElementById('parts_name_search1').value;
	window.open('export_request_all.php?date_from='+date_from+'&&date_to='+date_to+'&&search_status='+search_status+'&&line_no_search='+line_no_search+'&&parts_code_search1='+parts_code_search1+'&&parts_name_search1='+parts_name_search1,'_blank');
}
const export_excel_showed =()=>{
	let date_from = document.getElementById('date_from').value;
	let date_to = document.getElementById('date_to').value;
	let search_status = document.getElementById('search_status').value;
	let line_no_search = document.getElementById('line_no_search').value;
	let parts_code_search1 = document.getElementById('parts_code_search1').value;
	let parts_name_search1 = document.getElementById('parts_name_search1').value;
	let limiter_search = document.getElementById('limiter_search').value;
	window.open('export_request_result.php?date_from='+date_from+'&&date_to='+date_to+'&&search_status='+search_status+'&&line_no_search='+line_no_search+'&&parts_code_search1='+parts_code_search1+'&&parts_name_search1='+parts_name_search1+'&&limiter_search='+limiter_search,'_blank');
}
const mm_remarks_change =()=>{
	update_seen();
	let distributor_remarks_Label = document.getElementById('mm_remarks_Label').innerHTML;
	if(distributor_remarks_Label != 'Remarks'){
		document.getElementById('mm_remarks_Label').innerHTML='Remarks';
	}
}
display_all_requested();
</script>
</body>
</html>
