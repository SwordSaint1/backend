<?php
	require_once 'Connection/ConnectSqlsrv.php';
	$ip = $_SERVER['REMOTE_ADDR'];
	session_start();
	$sql = "SELECT TOP 1 * FROM mm_scooter_area WHERE ip = '$ip'";
    $stmt = sqlsrv_query($conn_sqlsrv, $sql);
    $row = sqlsrv_has_rows($stmt);
    if ($row === true){
        while($rows = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){
			$_SESSION["scooter_area"] = $rows['scooter_area'];
        }
    }else{
        header("location:no_access.php");
	}
    sqlsrv_free_stmt($stmt);
    sqlsrv_close($conn_sqlsrv);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>E-Kanban MM</title>
	<link rel="stylesheet" href="Fontawesome/fontawesome-free-5.9.0-web/css/all.css">
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/mdb.min.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet">
	<link href="mycss/style1.css" rel="stylesheet">
	<link href="mycss/spinners.css" rel="stylesheet">
	<link href="mycss/tracking.css" rel="stylesheet">
	<link rel="shortcut icon" href="favicon.ico" type="image/ico">
	<link href="favicon.png" rel="icon">
</head>
<body class="bg">
<?php
	include 'Nav/header_scooter.php';
	include 'Modal/request_parts_modal.php';
	include 'Modal/requested_parts_station_modal.php';
	include 'Modal/add_remarks_distributor.php';
	include 'Modal/add_remarks_distributor_search.php';
	include 'Modal/add_remarks_distributor_notif.php';
	include 'Modal/delete_kanban_id_confirmation.php';
	include 'Modal/search_request_station.php'; 
	include 'Modal/news_windows.php';
?>
<div class="row ml-0 mr-0 card_opa">
	<div class="col-sm-4 col-md-4 col-lg-4">
	</div>
	<input type="hidden" id="entries_pending">
	<input type="hidden" id="entries_pending_count">
	<!-- For Realtime -->
	<input type="hidden" id="count_pending">
	<input type="hidden" id="count_op">
	<input type="hidden" id="scooter_station_real" value='<?php echo $_SESSION["scooter_area"]?>'>
	<div class="col-sm-4 col-md-4 col-lg-4 text-center mt-1">
		<label class="h3"><i class="fas fa-cogs"></i> Request Parts</label>	
	</div>
	<div class="col-sm-12 col-md-12 col-lg-12">
		<button class="btn unique-color white-text float-right" onclick="request_parts()"><i class="fas fa-plus-circle"></i> Request Parts</button>
		<button class="btn unique-color white-text float-right" onclick="search_modal_open()"><i class="fas fa-search"></i> Search</button>
	</div>
	<div class="col-sm-12 col-md-12 col-lg-12 text-center mt-1" id="pending_parts_label_section">
		<label class="h4"><i class="fas fa-cogs"></i> Pending Parts</label>	
	</div>
	<div class="row mx-0 col-sm-12 col-md-12 col-lg-12" id="pending_parts_section">
		<table class="table table-bordered table-sm">
			<thead class="unique-color white-text">
				<tr>
					<th class="h6">No</th>
					<th class="h6">Request ID</th>
					<th class="h6">Scooter Station</th>
					<th class="h6">Request Data & Time</th>
					<th class="h6">Kanban</th>
				</tr>
			</thead>
			<tbody id="requested_parts_this_area">
			</tbody>
		</table>
		<br>
		<br>
		<br>
	</div>
	<div class="col-sm-12 col-md-12 col-lg-12 text-center mt-1" id="ongoing_parts_label_section">
		<label class="h4"><i class="fas fa-spinner"></i> Ongoing Picking</label>	
	</div>
	<div class="row mx-0 col-sm-12 col-md-12 col-lg-12" id="ongoing_parts_section">
		<table class="table table-bordered table-sm">
			<thead class="unique-color white-text">
				<tr>
					<th class="h6">No</th>
					<th class="h6">Request ID</th>
					<th class="h6">Scooter Station</th>
					<th class="h6">Request Data & Time</th>
					<th class="h6">Kanban</th>
				</tr>
			</thead>
			<tbody id="ongoing_picking_parts_this_area">
			</tbody>
		</table>
	</div>
</div>
<script>
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
<!-- My JavaScript for Realtime Updates-->
<script type="text/javascript" src="myjs/realtime_station.js"></script>
<!-- My JacaScript of News-->
<script type="text/javascript" src="myjs/news_window.js"></script>
<!-- My Tooltip Initialization-->
<script type="text/javascript" src="myjs/tool_tip.js"></script>
<!-- My JavaScript for Realtime Converstation-->
<script type="text/javascript" src="myjs/realtime_conversation_station.js"></script>

<script>
	$('#Request_Parts').modal({backdrop: 'static', keyboard: false})
</script>
<!--  For Scanning of Kanban  -->
<script>
	let kanban_scan = document.getElementById("kanban_scan");
	kanban_scan.addEventListener("keyup", function(event) {
		if (event.keyCode === 13){
			event.preventDefault();
			kanban_scan_check();
		}
	});
	let id_scan_employee = document.getElementById("id_scan_employee");
	id_scan_employee.addEventListener("keyup", function(event) {
		if (event.keyCode === 13){
			event.preventDefault();
			confirmed_id();
		}
	});
	let confirm_to_delete = document.getElementById("confirm_to_delete");
	confirm_to_delete.addEventListener("keyup", function(event) {
		if (event.keyCode === 13){
			event.preventDefault();
			id_confirm_to_delete();
		}
	});
</script>
<!--For Enter in Search-->
<script>
//For Line No
let line_no_search = document.getElementById("line_no_search");
line_no_search.addEventListener("keyup", function(event) {
	if (event.keyCode === 13){
		event.preventDefault();
		search_action();
	}
});

//For Parts Code
let parts_code_search = document.getElementById("parts_code_search1");
parts_code_search.addEventListener("keyup", function(event) {
	if (event.keyCode === 13){
		event.preventDefault();
		search_action();
	}
});

//For Parts Name
let parts_name_search = document.getElementById("parts_name_search1");
parts_name_search.addEventListener("keyup", function(event) {
	if (event.keyCode === 13){
		event.preventDefault();
		search_action();
	}
});
</script>
<script>
const request_parts =()=>{
	$("#Request_Parts").modal('show');
	document.getElementById("kanban_scan").focus();
// 	$('#kanban_scan').focus();
// 	setTimeout(function (){
// 		$('#kanban_scan').focus();
// 	}, 100);
 }
//For Search Acion
const search_action =()=>{
	document.getElementById('search_result_all').innerHTML="";
	document.getElementById('loading_indicator_search').style.display="inline-block";
	document.getElementById('see_more_search').style.display="none";
	document.getElementById('tracked_pending_search').style.display="none";
	document.getElementById('tracked_op_search').style.display="none";
	let scooter_station = "<?php echo $_SESSION['scooter_area'];?>";
	let date_from = document.getElementById('date_from').value;
	let date_to = document.getElementById('date_to').value;
	let search_status = document.getElementById('search_status').value;
	let line_no_search = document.getElementById('line_no_search').value;
	let parts_name_search1 = document.getElementById('parts_name_search1').value;
	let parts_code_search1 = document.getElementById('parts_code_search1').value;
	let limiter_search = 0;
	let xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
		if (this.readyState == 4 && this.status == 200){
			let response = this.responseText;
			if (response ==''){
				document.getElementById('loading_indicator_search').style.display="none";
				document.getElementById('search_result_all').innerHTML= "<td colspan='14' style='font-weight:bold;color:red;'><center>NO DATA FOUND</center></td>";
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
	xhttp.open("GET", "AJAX/search_parts_station.php?operation=display_all&&scooter_station="+scooter_station+"&&date_from="+date_from+"&&date_to="+date_to+"&&search_status="+search_status+"&&line_no_search="+line_no_search+"&&parts_name_search1="+parts_name_search1+"&&parts_code_search1="+parts_code_search1+"&&limiter_search="+limiter_search, true);
	xhttp.send();
}
const search_counter =()=>{
	let scooter_station = "<?php echo $_SESSION['scooter_area'];?>";
	let date_from = document.getElementById('date_from').value;
	let date_to = document.getElementById('date_to').value;
	let search_status = document.getElementById('search_status').value;
	let line_no_search = document.getElementById('line_no_search').value;
	let parts_name_search1 = document.getElementById('parts_name_search1').value;
	let parts_code_search1 = document.getElementById('parts_code_search1').value;
	let xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
		if (this.readyState == 4 && this.status == 200){
			let response = this.responseText;
			let limiter_search = parseInt(document.getElementById('limiter_search').value);
			let total = parseInt(response);
			let table_rows = document.getElementById("search_result_all").rows.length;
			document.getElementById('counter_viewer').innerHTML=table_rows +' - '+ total;
			if (limiter_search >= total){
				document.getElementById('see_more_search').style.display="none";
			}else{
				document.getElementById('see_more_search').style.display="inline-block";
				document.getElementById('export_excel_showed').style.display='inline-block';

			}
		}
	};
	xhttp.open("GET", "AJAX/search_parts_station.php?operation=search_counter&&scooter_station="+scooter_station+"&&date_from="+date_from+"&&date_to="+date_to+"&&search_status="+search_status+"&&line_no_search="+line_no_search+"&&parts_name_search1="+parts_name_search1+"&&parts_code_search1="+parts_code_search1, true);
	xhttp.send();
}
const see_more_search =()=>{
	document.getElementById('loading_indicator_search').style.display="inline-block";
	document.getElementById('see_more_search').style.display="none";
	let scooter_station = "<?php echo $_SESSION['scooter_area'];?>";
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
				document.getElementById('search_result_all').innerHTML= "<td colspan='14' style='font-weight:bold;color:red;'><center>NO DATA FOUND</center></td>";
			}else{
				document.getElementById('limiter_search').value= parseInt(limiter_search) + 20;
				document.getElementById('loading_indicator_search').style.display="none";
				document.getElementById('search_result_all').innerHTML += response;
			}
			search_counter();
		}
	};
	xhttp.open("GET", "AJAX/search_parts_station.php?operation=display_all&&scooter_station="+scooter_station+"&&date_from="+date_from+"&&date_to="+date_to+"&&search_status="+search_status+"&&line_no_search="+line_no_search+"&&parts_name_search1="+parts_name_search1+"&&parts_code_search1="+parts_code_search1+"&&limiter_search="+limiter_search, true);
	xhttp.send();
}
//Checking Kanban
const kanban_scan_check =()=>{
	let kanban_scan = document.getElementById('kanban_scan').value;
	let kanban_scan_length = kanban_scan.length;
	document.getElementById("confirmation_output").innerHTML="";
	if (kanban_scan_length > 30 && kanban_scan_length < 104){
		kanban_scan_action(kanban_scan);
	}else if(kanban_scan_length > 0 && kanban_scan_length < 30){
		serial_no_scan_action(kanban_scan);
	}else{
		let audio= new Audio('Voice/PleaseScanyourKanban.mp3');
		audio.play();
		document.getElementById("confirmation_output").innerHTML="Please Scan your Kanban!";
		document.getElementById('kanban_scan').value = '';
	}
}
//For Serial No Scanning
const serial_no_scan_action =(x)=>{
	document.getElementById("kanban_scan").value='';
	let audio= new Audio('Voice/UnregisteredSerialNumber.mp3');
	audio.play();
	document.getElementById('error_kanban').innerHTML='Error: Unregistered Serial No!';
}
//Kanban Checking in FSIB Database
const kanban_scan_action =(x)=>{
	document.getElementById("kanban_scan").value='';
	let kanban_scan = x;
	let scooter_area = "<?php echo $_SESSION['scooter_area'];?>";
	document.getElementById("btn_save_request").disabled=false;
	let id_scanned_kanban = document.getElementById("id_scanned_kanban").value;
	let xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
		if (this.readyState == 4 && this.status == 200){
			var response = this.responseText;
			if(response == 'Error: Duplicate Entry!'){
				let audio= new Audio('Voice/DuplicateEntry.mp3');
				audio.play();
				document.getElementById('error_kanban').innerHTML='Error: Duplicate Entry!';
			}else if(response == 'Error: Already Requested!'){
				let audio= new Audio('Voice/AlreadyRequested.mp3');
				audio.play();
				document.getElementById('error_kanban').innerHTML='Error: Already Requested!';
			}else if(response == 'Error: Unregistered Kanban!'){
				let audio= new Audio('Voice/UnregisteredKanban.mp3');
				audio.play();
				document.getElementById('error_kanban').innerHTML='Error: Unregistered Kanban!';
			}else if(response == 'Error: Please Review your Kanban!'){
				let audio= new Audio('Voice/AnErrorDetectedPleaseReviewyourKanban.mp3');
				audio.play();
				document.getElementById('error_kanban').innerHTML='Error: Please Review your Kanban!';
			}else{
				document.getElementById('error_kanban').innerHTML='';
				document.getElementById("id_scanned_kanban").value=response;
				document.getElementById("id_scanned_kanban_modal").innerHTML=response;
				document.getElementById("confirmation_output").innerHTML="";
				let audio= new Audio('Voice/Added.mp3');
				audio.play();
				get_kanban(response);
			}
			
		}
	};
	if(kanban_scan == ''){
		document.getElementById("confirmation_output").innerHTML="Please Scan Kanban";
	}else{
		xhttp.open("GET", "AJAX/get_kanban_data.php?operation=get_scan_kanban&&kanban_scan="+kanban_scan+"&&id_scanned_kanban="+id_scanned_kanban+"&&scooter_area="+scooter_area, true);
		xhttp.send();
	}
}
const get_kanban =(x)=>{
	let xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
		if (this.readyState == 4 && this.status == 200) {
			let response = this.responseText;
			if (response !=''){
				document.getElementById('scanned_kanban_section').innerHTML=response;
				document.getElementById('row_table_requested_1').style='border-style: solid; border-width: medium;';
				scanned_kanban_count(x);
			}else{
				document.getElementById('scanned_kanban_section').innerHTML='';
			}
		}
	};
	xhttp.open("GET", "AJAX/get_kanban_data.php?operation=get_kanban&&id_scanned_kanban="+x, true);
	xhttp.send();
}
const scanned_kanban_count =(x)=>{
	let xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
	if (this.readyState == 4 && this.status == 200) {
		let response = this.responseText;
		document.getElementById('kanban_scanned_count').innerHTML=response;
	}
	};
	xhttp.open("GET", "AJAX/get_kanban_count.php?operation=get_kanban_count&&id_scanned_kanban="+x, true);
	xhttp.send();
}
const confirmed_id =()=>{
	let id_scan_employee = document.getElementById('id_scan_employee').value;
	let scooter_area = "<?php echo $_SESSION['scooter_area'];?>";
	let xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
		if (this.readyState == 4 && this.status == 200) {
			let response = this.responseText;
			if(response == "Unable to Request"){
				let audio= new Audio('Voice/UnabletoRequest.mp3');
				audio.play();
				document.getElementById('id_scan_employee').value='';
				document.getElementById('confirmation_output').innerHTML=response;
			}else{
				let audio= new Audio('Voice/RequestSuccessfully.mp3');
				audio.play();
				document.getElementById('confirmation_output').innerHTML="Requested";
				request_success(response);
			}
		}
	};
	xhttp.open("GET", "AJAX/id_confirmation.php?operation=confirmation_id&&id_scan_employee="+id_scan_employee+"&&scooter_area="+scooter_area, true);
	xhttp.send();
}
const request_success =(x)=>{
	let id_scanned_kanban = document.getElementById('id_scanned_kanban').value;
	let xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
		if (this.readyState == 4 && this.status == 200) {
			let response = this.responseText;
			setTimeout(out_modal, 2000);
		}
	};
	xhttp.open("GET", "AJAX/get_kanban_data.php?operation=request_success&&id_scanned_kanban="+id_scanned_kanban+"&&distributor="+x, true);
	xhttp.send();
}
const select_request =()=>{
	let scooter_area = "<?php echo $_SESSION['scooter_area'];?>";
	let xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
		if (this.readyState == 4 && this.status == 200) {
			let response = this.responseText;
			if(response == ""){
				document.getElementById('pending_parts_section').style.display="none";
				document.getElementById('pending_parts_label_section').style.display="none";
			}else{
				document.getElementById('pending_parts_section').style.display="inline-block";
				document.getElementById('pending_parts_label_section').style.display="inline-block";
				document.getElementById('requested_parts_this_area').innerHTML=response;
			}
			select_request_ongoing();
		}
	};
	xhttp.open("GET", "AJAX/get_requested.php?operation=select_request_scooter_area&&scooter_area="+scooter_area, true);
	xhttp.send();
}
const select_request_ongoing =()=>{
	let scooter_area = "<?php echo $_SESSION['scooter_area'];?>";
	let xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
		if (this.readyState == 4 && this.status == 200) {
			let response = this.responseText;
			if(response == ""){
				document.getElementById('ongoing_parts_section').style.display="none";
				document.getElementById('ongoing_parts_label_section').style.display="none";
			}else{
				document.getElementById('ongoing_parts_section').style.display="inline-block";
				document.getElementById('ongoing_parts_label_section').style.display="inline-block";
				document.getElementById('ongoing_picking_parts_this_area').innerHTML=response;
			}
		}
	};
	xhttp.open("GET", "AJAX/get_requested.php?operation=select_request_scooter_area_ongoing&&scooter_area="+scooter_area, true);
	xhttp.send();
}
const open_details_request =(x)=>{
	var split = x.split('~!~');
	var id_scanned_kanban = split[0];
	var status = split[1];
	var requested_by = split[2];
	$("#Requested_Parts").modal('show');
	//Getting the Requestor Name
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
	if(this.readyState == 4 && this.status == 200){
		var response = this.responseText;
		document.getElementById('requestor_name_section').innerHTML=response;
		document.getElementById('requested_id_section').innerHTML='<i class="fab fa-slack-hash"></i> '+id_scanned_kanban;
		document.getElementById('status_head_section').innerHTML='<i class="fas fa-ellipsis-h"></i> '+status;
		document.getElementById('open_details_distributor_status').value='Open';
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
	//Getting Request on Pending
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
	if(this.readyState == 4 && this.status == 200){
		var response = this.responseText;
		document.getElementById('tracked_pending').style.display='flex';
		document.getElementById('tracked_ongoing').style.display='none';
		document.getElementById('scanned_kanban_section_station').innerHTML=response;
	}
	};
	xhttp.open("GET", "AJAX/get_requested.php?operation=open_details_requested_pending&&id_scanned_kanban="+id_scanned_kanban, true);
	xhttp.send();
}
const open_details_requested_op =(id_scanned_kanban)=>{
	//Getting Request on Ongoing Picking
	let xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
	if(this.readyState == 4 && this.status == 200){
		let response = this.responseText;
		document.getElementById('tracked_pending').style.display='none';
		document.getElementById('tracked_ongoing').style.display='flex';
		document.getElementById('scanned_kanban_section_station').innerHTML=response;
	}
	};
	xhttp.open("GET", "AJAX/get_requested.php?operation=open_details_requested_op&&id_scanned_kanban="+id_scanned_kanban, true);
	xhttp.send();
}
function id_confirm_to_delete(){
	//Delete Request
	let distributor_id = document.getElementById('confirm_to_delete').value;
	let id_n_kanban = document.getElementById('kanban_request_id_and_kanban').value;
	let split = id_n_kanban.split('~!~');
	let id_scanned_kanban = split[0];
	let id = split[1];
	let xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
		if (this.readyState == 4 && this.status == 200){
			let response = this.responseText;
			if(response == 'Kanban Request Deleted!'){
				let audio = new Audio('Voice/RequestDeleted.mp3');
				audio.play();
				let id_scanned_kanban = document.getElementById("id_scanned_kanban").value;
				get_kanban(id_scanned_kanban);
				scanned_kanban_count(id_scanned_kanban);
				document.getElementById('deletation_confirmed').innerHTML='<i class="fas fa-check"></i> Kanban Request Deleted!';
				setTimeout(cancel_delete, 1000);
				document.getElementById('confirm_to_delete').value='';
			}else if(response == 'Unregistered ID Code!'){
				let audio = new Audio('Voice/UnregisteredCode.mp3');
				audio.play();
				document.getElementById('deletation_confirmed').innerHTML='<i class="fas fa-exclamation-triangle"></i> Unregistered ID Code!';
			}
		}
	};
	xhttp.open("GET", "AJAX/get_kanban_data.php?operation=delete_kanban&&id_scanned_kanban="+id_scanned_kanban+'&id='+id+'&&distributor_id='+distributor_id, true);
	xhttp.send();
}
const cancel_delete =(x)=>{
	$('#Confirm_Id_To_Delete').modal('hide');
	document.getElementById('confirm_to_delete').value='';
	document.getElementById('deletation_confirmed').innerHTML='';
}
const delete_request =(x)=>{
	$("#Confirm_Id_To_Delete").modal('show');
	setTimeout(function (){
		$('#confirm_to_delete').focus();
	}, 100);
	document.getElementById('kanban_request_id_and_kanban').value=x;

}
const save_request_parts =()=>{
	let audio= new Audio('Voice/PleaseScanYourCode.mp3');
	audio.play();
	document.getElementById('confirmation_output').innerHTML="Please count your Kanban!!!";
	document.getElementById('id_confirmation_section').style.display="inline-block";
	document.getElementById('id_scan_employee').focus();
}
const out_modal =()=>{
	$('#Request_Parts').modal('hide');
	select_request();
	clear();
}
const close_modal =()=>{
	$('#Requested_Parts').modal('hide');
	document.getElementById('open_details_distributor_status').value='Close';
}
const request_x_modal_func =()=>{
	let kanban_scanned_count = document.getElementById('kanban_scanned_count').innerHTML;
	let confirmation_output = document.getElementById('confirmation_output').innerHTML;
	if (kanban_scanned_count != '' && confirmation_output != 'Requested'){
		let audio= new Audio('Voice/PleaseScanYourCode.mp3');
		audio.play();
		document.getElementById('confirmation_output').innerHTML='Please Scan your ID Code!';
		document.getElementById('id_confirmation_section').style.display="inline-block";
		document.getElementById('id_scan_employee').focus();
	}else{
		out_modal();
	}
}
const clear =()=>{
	document.getElementById("kanban_scan").value="";
	document.getElementById("scanned_kanban").value="";
	document.getElementById("id_scanned_kanban").value="";
	document.getElementById("scanned_kanban_section").innerHTML="";
	document.getElementById("id_scan_employee").value="";
	document.getElementById("confirmation_output").innerHTML="";
	document.getElementById("id_confirmation_section").style.display="none";
	document.getElementById('kanban_scanned_count').innerHTML="";
	document.getElementById('error_kanban').innerHTML="";
	document.getElementById("id_scanned_kanban_modal").innerHTML='';
}
const add_remarks_distributor =(x)=>{
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
	xhttp.open("GET", "AJAX/remarks_distributor.php?operation=load_remarks_conversation&&remarks_id_scanned_kanban="+remarks_id_scanned_kanban+"&&remarks_kanban="+remarks_kanban+"&&remarks_kanban_num="+remarks_kanban_num+"&&remarks_scan_date_time="+remarks_scan_date_time+"&&remarks_request_date_time="+remarks_request_date_time+"&&scooter_station="+scooter_station, true);
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
	xhttp.open("GET", "AJAX/remarks_distributor.php?operation=update_seen&&remarks_id_scanned_kanban="+remarks_id_scanned_kanban+"&&remarks_kanban="+remarks_kanban+"&&remarks_kanban_num="+remarks_kanban_num+"&&remarks_scan_date_time="+remarks_scan_date_time+"&&remarks_request_date_time="+remarks_request_date_time+"&&scooter_station="+scooter_station, true);
	xhttp.send();
}
const save_distributor_remarks =()=>{
	let remarks_id_scanned_kanban = document.getElementById('remarks_id_scanned_kanban').value;
	let remarks_kanban = document.getElementById('remarks_kanban').value;
	let remarks_kanban_num = document.getElementById('remarks_kanban_num').value;
	let remarks_scan_date_time = document.getElementById('remarks_scan_date_time').value;
	let remarks_request_date_time = document.getElementById('remarks_request_date_time').value;
	let distributor_remarks = document.getElementById('distributor_remarks').value;
	let scooter_station = document.getElementById('remarks_scooter_station').value;
	let sender_remarks = "<?php echo $_SESSION['scooter_area'];?>";
	if(distributor_remarks == ''){
		document.getElementById('distributor_remarks_Label').innerHTML='Please Enter your Message!';
	}else{
		let xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			let response = this.responseText;
			document.getElementById('distributor_remarks').value='';
			load_remarks_conversation();
			check_data_to_reload();
		}
		};
		xhttp.open("GET", "AJAX/remarks_distributor.php?operation=add_remarks_distributor&&remarks_id_scanned_kanban="+remarks_id_scanned_kanban+"&&remarks_kanban="+remarks_kanban+"&&remarks_kanban_num="+remarks_kanban_num+"&&remarks_scan_date_time="+remarks_scan_date_time+"&&remarks_request_date_time="+remarks_request_date_time+"&&distributor_remarks="+distributor_remarks+"&&scooter_station="+scooter_station+"&&sender_remarks="+sender_remarks, true);
		xhttp.send();
	}
}
const check_data_to_reload =()=>{
	let open_details_distributor_status = document.getElementById('open_details_distributor_status').value;
	let search_distributor_status = document.getElementById('search_distributor_status').value;
	if (open_details_distributor_status == 'Open' && search_distributor_status == 'Close'){
		let id_scanned_kanban = document.getElementById('remarks_id_scanned_kanban').value;
		let remarks_status = document.getElementById('remarks_status').value;
		if(remarks_status == 'Pending'){
			open_details_requested_pending(id_scanned_kanban);
		}else if(remarks_status == 'Ongoing Picking'){
			open_details_requested_op(id_scanned_kanban);
		}
	}else if(open_details_distributor_status == 'Close' && search_distributor_status == 'Open'){
		load_search_remarks();
	}
}
const load_search_remarks =()=>{
	document.getElementById('see_more_search').style.display="none";
	let scooter_station = "<?php echo $_SESSION['scooter_area'];?>";
	let date_from = document.getElementById('date_from').value;
	let date_to = document.getElementById('date_to').value;
	let search_status = document.getElementById('search_status').value;
	let line_no_search = document.getElementById('line_no_search').value;
	let parts_name_search1 = document.getElementById('parts_name_search1').value;
	let parts_code_search1 = document.getElementById('parts_code_search1').value;
	let limiter_search = 0;
	let xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
		if (this.readyState == 4 && this.status == 200){
			let response = this.responseText;
			if (response ==''){
				document.getElementById('search_result_all').innerHTML= "<td colspan='14' style='font-weight:bold;color:red;'><center>NO DATA FOUND</center></td>";
			}else{
				document.getElementById('limiter_search').value=20;
				document.getElementById('search_result_all').innerHTML= response;
			}
			search_counter();
		}
	};
	xhttp.open("GET", "AJAX/search_parts_station.php?operation=display_all&&scooter_station="+scooter_station+"&&date_from="+date_from+"&&date_to="+date_to+"&&search_status="+search_status+"&&line_no_search="+line_no_search+"&&parts_name_search1="+parts_name_search1+"&&parts_code_search1="+parts_code_search1+"&&limiter_search="+limiter_search, true);
	xhttp.send();
}
const search_modal_open =()=>{
	$("#Search_Modal_Form_Station").modal('show');
	search_distributor_status = document.getElementById('search_distributor_status').value='Open';
}
const close_search_distributor =()=>{
	$("#Search_Modal_Form_Station").modal('hide');
	search_distributor_status = document.getElementById('search_distributor_status').value='Close';
}
const close_modal_remarks =()=>{
	$('#Add_Remarks_Form').modal('hide');
	document.getElementById('distributor_remarks').value='';
	document.getElementById('remarks_id_scanned_kanban').value='';
	document.getElementById('remarks_kanban').value='';
	document.getElementById('remarks_kanban_num').value='';
	document.getElementById('remarks_scan_date_time').value='';
	document.getElementById('remarks_request_date_time').value='';
	clearTimeout(convo_checker);
}
const status_change =()=>{
	search_action();
}
const export_excel =()=>{
	let date_from = document.getElementById('date_from').value;
	let date_to = document.getElementById('date_to').value;
	let search_status = document.getElementById('search_status').value;
	let line_no_search = document.getElementById('line_no_search').value;
	let parts_code_search1 = document.getElementById('parts_code_search1').value;
	let parts_name_search1 = document.getElementById('parts_name_search1').value;
	let scooter_station = '<?php echo $_SESSION["scooter_area"];?>';
	window.open('export_request_all_station.php?date_from='+date_from+'&&date_to='+date_to+'&&search_status='+search_status+'&&line_no_search='+line_no_search+'&&parts_code_search1='+parts_code_search1+'&&parts_name_search1='+parts_name_search1+'&&scooter_station='+scooter_station,'_blank');
}
const export_excel_showed =()=>{
	let date_from = document.getElementById('date_from').value;
	let date_to = document.getElementById('date_to').value;
	let search_status = document.getElementById('search_status').value;
	let line_no_search = document.getElementById('line_no_search').value;
	let parts_code_search1 = document.getElementById('parts_code_search1').value;
	let parts_name_search1 = document.getElementById('parts_name_search1').value;
	let limiter_search = document.getElementById('limiter_search').value;
	let scooter_station = '<?php echo $_SESSION["scooter_area"];?>';
	window.open('export_request_result_station.php?date_from='+date_from+'&&date_to='+date_to+'&&search_status='+search_status+'&&line_no_search='+line_no_search+'&&parts_code_search1='+parts_code_search1+'&&parts_name_search1='+parts_name_search1+'&&limiter_search='+limiter_search+'&&scooter_station='+scooter_station,'_blank');
}
const distributor_remarks_change =()=>{
	update_seen();
	let distributor_remarks_Label = document.getElementById('distributor_remarks_Label').innerHTML;
	if(distributor_remarks_Label != 'Remarks'){
		document.getElementById('distributor_remarks_Label').innerHTML='Remarks';
	}
}
select_request();
</script>
</body>
</html>
