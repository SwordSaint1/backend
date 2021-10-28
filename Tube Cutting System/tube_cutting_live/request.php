<?php
	include 'Connection/Connect_sql.php';
	$ip = $_SERVER['REMOTE_ADDR'];
	$sql = "SELECT ip, scooter_area FROM tc_scooter_area WHERE ip='$ip'";
	$result = $conn_sql->query($sql);
	if($result->num_rows > 0){
		while($row = $result->fetch_assoc()){
			session_start();
			$_SESSION["scooter_area"] = $row['scooter_area'];
		}
	}else{
		header("location:no_access.php");
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>Tube Cutting</title>
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
	<link href="mycss/spinners.css" rel="stylesheet">
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
	<div class="col-sm-4 col-md-4 col-lg-4 text-center mt-1">
		<label class="h3"><i class="fas fa-cogs"></i> Request Parts</label>	
	</div>
	<div class="col-sm-12 col-md-12 col-lg-12">
		<button class="btn btn-info float-right" onclick="request_parts()"><i class="fas fa-plus-circle"></i> Request Parts</button>
		<button class="btn btn-info float-right" onclick="search_modal_open()"><i class="fas fa-search"></i> Search</button>
	</div>
	<div class="col-sm-12 col-md-12 col-lg-12 text-center mt-1" id="pending_parts_label_section">
		<label class="h4"><i class="fas fa-cogs"></i> Pending Parts</label>	
	</div>
	<div class="row mx-0 col-sm-12 col-md-12 col-lg-12" id="pending_parts_section">
		<table class="table table-bordered table-sm">
			<thead class="blue-grey lighten-3">
				<tr>
					<th class="h6">Request ID</th>
					<th class="h6">Scooter Station</th>
					<th class="h6">Request Data & Time</th>
					<th class="h6">Kanban</th>
					<th class="h6">Requested By</th>
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
			<thead class="blue-grey lighten-3">
				<tr>
					<th class="h6">Request ID</th>
					<th class="h6">Scooter Station</th>
					<th class="h6">Request Data & Time</th>
					<th class="h6">Kanban</th>
					<th class="h6">Requested By</th>
				</tr>
			</thead>
			<tbody id="ongoing_picking_parts_this_area">
			</tbody>
		</table>
	</div>
</div>
<!--For Enter in Search-->
<script>
//For Line No
var line_no_search = document.getElementById("line_no_search");
line_no_search.addEventListener("keyup", function(event) {
	if (event.keyCode === 13){
		event.preventDefault();
		search_action();
	}
});

//For Parts Code
var parts_code_search = document.getElementById("parts_code_search1");
parts_code_search.addEventListener("keyup", function(event) {
	if (event.keyCode === 13){
		event.preventDefault();
		search_action();
	}
});

//For Parts Name
var parts_name_search = document.getElementById("parts_name_search1");
parts_name_search.addEventListener("keyup", function(event) {
	if (event.keyCode === 13){
		event.preventDefault();
		search_action();
	}
});

//For Comment
var comment_search = document.getElementById("comment_search");
comment_search.addEventListener("keyup", function(event) {
	if (event.keyCode === 13){
		event.preventDefault();
		search_action();
	}
});

//For Length
var length_search = document.getElementById("length_search");
length_search.addEventListener("keyup", function(event) {
	if (event.keyCode === 13){
		event.preventDefault();
		search_action();
	}
});
</script>
<script>
	// For Search Parts In Modal
	function search_modal_open(){
		$("#Search_Modal_Form_Station").modal();
	}
	function status_change(){
		search_action();
	}
	function search_action(){
		document.getElementById('search_result_all').innerHTML="";
		document.getElementById('loading_indicator_search').style.display="inline-block";
		document.getElementById('see_more_search').style.display="none";
		var scooter_station = "<?php echo $_SESSION['scooter_area'];?>";
		var date_from = document.getElementById('date_from').value;
		var date_to = document.getElementById('date_to').value;
		var search_status = document.getElementById('search_status').value;
		var line_no_search = document.getElementById('line_no_search').value;
		var parts_name_search1 = document.getElementById('parts_name_search1').value;
		var parts_code_search1 = document.getElementById('parts_code_search1').value;
		var comment_search = document.getElementById('comment_search').value;
		var length_search = document.getElementById('length_search').value;
		var limiter_search = 0;
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function(){
			if (this.readyState == 4 && this.status == 200){
				var response = this.responseText;
				if (response ==''){
					document.getElementById('loading_indicator_search').style.display="none";
					document.getElementById('search_result_all').innerHTML= "<td colspan='14' style='font-weight:bold;color:red;'><center>NO DATA FOUND</center></td>";
				}else{
					document.getElementById('limiter_search').value=20;
					document.getElementById('loading_indicator_search').style.display="none";
					document.getElementById('search_result_all').innerHTML= response;
				}
				search_counter();
			}
		};
		xhttp.open("GET", "AJAX/search_parts_station.php?operation=display_all&&scooter_station="+scooter_station+"&&date_from="+date_from+"&&date_to="+date_to+"&&search_status="+search_status+"&&line_no_search="+line_no_search+"&&parts_name_search1="+parts_name_search1+"&&parts_code_search1="+parts_code_search1+"&&comment_search="+comment_search+"&&length_search="+length_search+"&&limiter_search="+limiter_search, true);
		xhttp.send();
	}
	function search_counter(){
		var scooter_station = "<?php echo $_SESSION['scooter_area'];?>";
		var date_from = document.getElementById('date_from').value;
		var date_to = document.getElementById('date_to').value;
		var search_status = document.getElementById('search_status').value;
		var line_no_search = document.getElementById('line_no_search').value;
		var parts_name_search1 = document.getElementById('parts_name_search1').value;
		var parts_code_search1 = document.getElementById('parts_code_search1').value;
		var comment_search = document.getElementById('comment_search').value;
		var length_search = document.getElementById('length_search').value;
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function(){
			if (this.readyState == 4 && this.status == 200){
				var response = this.responseText;
				var limiter_search = parseInt(document.getElementById('limiter_search').value);
				var total = parseInt(response);
				if (limiter_search >= total){
					document.getElementById('see_more_search').style.display="none";
				}else{
					document.getElementById('see_more_search').style.display="inline-block";
				}
			}
		};
		xhttp.open("GET", "AJAX/search_parts_station.php?operation=search_counter&&scooter_station="+scooter_station+"&&date_from="+date_from+"&&date_to="+date_to+"&&search_status="+search_status+"&&line_no_search="+line_no_search+"&&parts_name_search1="+parts_name_search1+"&&parts_code_search1="+parts_code_search1+"&&comment_search="+comment_search+"&&length_search="+length_search, true);
		xhttp.send();
	}
	function see_more_search(){
		document.getElementById('loading_indicator_search').style.display="inline-block";
		document.getElementById('see_more_search').style.display="none";
		var scooter_station = "<?php echo $_SESSION['scooter_area'];?>";
		var date_from = document.getElementById('date_from').value;
		var date_to = document.getElementById('date_to').value;
		var search_status = document.getElementById('search_status').value;
		var line_no_search = document.getElementById('line_no_search').value;
		var parts_name_search1 = document.getElementById('parts_name_search1').value;
		var parts_code_search1 = document.getElementById('parts_code_search1').value;
		var comment_search = document.getElementById('comment_search').value;
		var length_search = document.getElementById('length_search').value;
		var limiter_search = document.getElementById('limiter_search').value;
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function(){
			if (this.readyState == 4 && this.status == 200){
				var response = this.responseText;
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
		xhttp.open("GET", "AJAX/search_parts_station.php?operation=display_all&&scooter_station="+scooter_station+"&&date_from="+date_from+"&&date_to="+date_to+"&&search_status="+search_status+"&&line_no_search="+line_no_search+"&&parts_name_search1="+parts_name_search1+"&&parts_code_search1="+parts_code_search1+"&&comment_search="+comment_search+"&&length_search="+length_search+"&&limiter_search="+limiter_search, true);
		xhttp.send();
	}
</script>
<!--  For Scanning of Kanban  -->
<script>
	var kanban_scan = document.getElementById("kanban_scan");
	kanban_scan.addEventListener("keyup", function(event) {
		if (event.keyCode === 13){
			event.preventDefault();
			kanban_scan_check();
		}
	});
	var id_scan_employee = document.getElementById("id_scan_employee");
	id_scan_employee.addEventListener("keyup", function(event) {
		if (event.keyCode === 13){
			event.preventDefault();
			confirmed_id();
		}
	});
	var confirm_to_delete = document.getElementById("confirm_to_delete");
	confirm_to_delete.addEventListener("keyup", function(event) {
		if (event.keyCode === 13){
			event.preventDefault();
			id_confirm_to_delete();
		}
	});
</script>
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
<script type="text/javascript" src="myjs/realtime_scooter_station.js"></script>
<!-- My JacaScript of News-->
<script type="text/javascript" src="myjs/news_window.js"></script>

<script>
	$('#Request_Parts').modal({backdrop: 'static', keyboard: false})
</script>
<script>
function kanban_scan_check(){
	var kanban_scan = document.getElementById('kanban_scan').value;
	var kanban_scan_length = kanban_scan.length;
	document.getElementById("confirmation_output").innerHTML="";
	if (kanban_scan_length > 30 && kanban_scan_length < 200){
		kanban_scan_action(kanban_scan);
	}else if(kanban_scan_length > 0 && kanban_scan_length < 30){
		serial_no_scan_action(kanban_scan);
	}else{
		var audio= new Audio('Voice/PleaseScanyourKanban.mp3');
		audio.play();
		document.getElementById("confirmation_output").innerHTML="Please Scan your Kanban!";
	}
}
function serial_no_scan_action(x){
	document.getElementById("kanban_scan").value='';
	var serial_no_scan = x;
	var scooter_area = "<?php echo $_SESSION['scooter_area'];?>";
	document.getElementById("btn_save_request").disabled=false;
	var id_scanned_kanban = document.getElementById("id_scanned_kanban").value;
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
		if (this.readyState == 4 && this.status == 200){
			var response = this.responseText;
			if(response == 'Error: Duplicate Entry!'){
				var audio= new Audio('Voice/DuplicateEntry.mp3');
				audio.play();
				document.getElementById('error_kanban').innerHTML='Error: Duplicate Entry!';
			}else if(response == 'Error: Already Requested!'){
				var audio= new Audio('Voice/AlreadyRequested.mp3');
				audio.play();
				document.getElementById('error_kanban').innerHTML='Error: Already Requested!';
			}else if(response == 'Error: Unregistered Serial No!'){
				var audio= new Audio('Voice/UnregisteredSerialNumber.mp3');
				audio.play();
				document.getElementById('error_kanban').innerHTML='Error: Unregistered Serial No!';
			}else{
				document.getElementById('error_kanban').innerHTML='';
				document.getElementById("id_scanned_kanban").value=response;
				document.getElementById("id_scanned_kanban_modal").innerHTML=response;
				document.getElementById("confirmation_output").innerHTML="";
				get_kanban(response);
			}
		}
	};
	if(serial_no_scan == ''){
		var audio= new Audio('Voice/PleaseScanyourKanban.mp3');
		audio.play();
		document.getElementById("confirmation_output").innerHTML="Please Scan your Kanban!";
	}else{
		xhttp.open("GET", "AJAX/get_kanban_data.php?operation=get_scan_serial_no&&serial_no_scan="+serial_no_scan+"&&id_scanned_kanban="+id_scanned_kanban+"&&scooter_area="+scooter_area, true);
		xhttp.send();
	}
}
function kanban_scan_action(x){
	document.getElementById("kanban_scan").value='';
	var kanban_scan = x;
	var scooter_area = "<?php echo $_SESSION['scooter_area'];?>";
	document.getElementById("btn_save_request").disabled=false;
	var id_scanned_kanban = document.getElementById("id_scanned_kanban").value;
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
		if (this.readyState == 4 && this.status == 200){
			var response = this.responseText;
			if(response == 'Error: Duplicate Entry!'){
				var audio= new Audio('Voice/DuplicateEntry.mp3');
				audio.play();
				document.getElementById('error_kanban').innerHTML='Error: Duplicate Entry!';
			}else if(response == 'Error: Already Requested!'){
				var audio= new Audio('Voice/AlreadyRequested.mp3');
				audio.play();
				document.getElementById('error_kanban').innerHTML='Error: Already Requested!';
			}else if(response == 'Error: Unregistered Kanban!'){
				var audio= new Audio('Voice/UnregisteredKanban.mp3');
				audio.play();
				document.getElementById('error_kanban').innerHTML='Error: Unregistered Kanban!';
			}else{
				document.getElementById('error_kanban').innerHTML='';
				document.getElementById("id_scanned_kanban").value=response;
				document.getElementById("id_scanned_kanban_modal").innerHTML=response;
				document.getElementById("confirmation_output").innerHTML="";
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
function get_kanban(x){
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
		if (this.readyState == 4 && this.status == 200) {
			var response = this.responseText;
			if (response !=''){
				var audio= new Audio('Voice/Added.mp3');
				audio.play();
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
function delete_request(x){
	$("#Confirm_Id_To_Delete").modal();
	setTimeout(function (){
		$('#confirm_to_delete').focus();
	}, 100);
	document.getElementById('kanban_request_id_and_kanban').value=x;
}
function id_confirm_to_delete(){
	var distributor_id = document.getElementById('confirm_to_delete').value;
	var x = document.getElementById('kanban_request_id_and_kanban').value;
	var split = x.split('~!~');
	var id_scanned_kanban = split[0];
	var id = split[1];
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
		if (this.readyState == 4 && this.status == 200) {
			var response = this.responseText;
			if(response == 'Kanban Request Deleted!'){
				var id_scanned_kanban = document.getElementById("id_scanned_kanban").value;
				get_kanban(id_scanned_kanban);
				scanned_kanban_count(id_scanned_kanban);
				document.getElementById('deletation_confirmed').innerHTML='<i class="fas fa-check"></i> Kanban Request Deleted!';
				setTimeout(cancel_delete, 1000);
				document.getElementById('confirm_to_delete').value='';
			}else if(response == 'Unregistered ID Code!'){
				document.getElementById('deletation_confirmed').innerHTML='<i class="fas fa-exclamation-triangle"></i> Unregistered ID Code!';
			}
		}
	};
	xhttp.open("GET", "AJAX/get_kanban_fsib.php?operation=delete_kanban&&id_scanned_kanban="+id_scanned_kanban+'&id='+id+'&&distributor_id='+distributor_id, true);
	xhttp.send();
}
function scanned_kanban_count(x){
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
	if (this.readyState == 4 && this.status == 200) {
		var response = this.responseText;
		document.getElementById('kanban_scanned_count').innerHTML=response;
	}
	};
	xhttp.open("GET", "AJAX/get_kanban_count.php?operation=get_kanban_count&&id_scanned_kanban="+x, true);
	xhttp.send();
}
function save_request_parts(){
	var audio= new Audio('Voice/PleaseScanYourCode.mp3');
	audio.play();
	document.getElementById('confirmation_output').innerHTML="Please count your Kanban!!!";
	document.getElementById('id_confirmation_section').style.display="inline-block";
	document.getElementById('id_scan_employee').focus();
}
function confirmed_id(){
	var id_scan_employee = document.getElementById('id_scan_employee').value;
	var scooter_area = "<?php echo $_SESSION['scooter_area'];?>";
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
		if (this.readyState == 4 && this.status == 200) {
			var response = this.responseText;
			if(response == "Unable to Request"){
				var audio= new Audio('Voice/UnabletoRequest.mp3');
				audio.play();
				document.getElementById('id_scan_employee').value='';
				document.getElementById('confirmation_output').innerHTML=response;
			}else{
				var audio= new Audio('Voice/RequestSuccessfully.mp3');
				audio.play();
				document.getElementById('confirmation_output').innerHTML="Requested";
				request_success(response);
			}
		}
	};
	xhttp.open("GET", "AJAX/id_confirmation.php?operation=confirmation_id&&id_scan_employee="+id_scan_employee+"&&scooter_area="+scooter_area, true);
	xhttp.send();
}
function request_success(x){
	var id_scanned_kanban = document.getElementById('id_scanned_kanban').value;
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
		if (this.readyState == 4 && this.status == 200) {
			var response = this.responseText;
			//alert(response);
			setTimeout(out_modal, 2000);
		}
	};
	xhttp.open("GET", "AJAX/get_kanban_data.php?operation=request_success&&id_scanned_kanban="+id_scanned_kanban+"&&distributor="+x, true);
	xhttp.send();
}
function select_request(){
	var scooter_area = "<?php echo $_SESSION['scooter_area'];?>";
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
		if (this.readyState == 4 && this.status == 200) {
			var response = this.responseText;
			if(response == ""){
				document.getElementById('pending_parts_section').style.display="none";
				document.getElementById('pending_parts_label_section').style.display="none";
			}else{
				document.getElementById('pending_parts_section').style.display="inline-block";
				document.getElementById('pending_parts_label_section').style.display="inline-block";
				document.getElementById('requested_parts_this_area').innerHTML=response;
			}
			select_request_ongoing()
		}
	};
	xhttp.open("GET", "AJAX/get_requested.php?operation=select_request_scooter_area&&scooter_area="+scooter_area, true);
	xhttp.send();
}
function select_request_ongoing(){
	var scooter_area = "<?php echo $_SESSION['scooter_area'];?>";
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
		if (this.readyState == 4 && this.status == 200) {
			var response = this.responseText;
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
function display_all_requested_parts(x){
	document.getElementById('entries_pending').value=x;
	var scooter_area = "<?php echo $_SESSION['scooter_area'];?>";
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
		if (this.readyState == 4 && this.status == 200) {
			var response = this.responseText;
			//alert(response);
			if(response == ""){
				document.getElementById('pending_parts_section').style.display="none";
				document.getElementById('pending_parts_label_section').style.display="none";
			}else{
				document.getElementById('pending_parts_section').style.display="inline-block";
				document.getElementById('pending_parts_label_section').style.display="inline-block";
				document.getElementById('requested_parts_this_area').innerHTML=response;
			}
			select_request_ongoing()
		}
	};
	xhttp.open("GET", "AJAX/get_requested.php?operation=select_request_scooter_area&&scooter_area="+scooter_area, true);
	xhttp.send();
}
function display_all_requested_parts_by_not_pending(x){
	document.getElementById('entries_pending_count').value=x;
	var scooter_area = "<?php echo $_SESSION['scooter_area'];?>";
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
		if (this.readyState == 4 && this.status == 200) {
			var response = this.responseText;
			document.getElementById('requested_parts_this_area').innerHTML=response;
		}
	};
	xhttp.open("GET", "AJAX/get_requested.php?operation=select_request_scooter_area&&scooter_area="+scooter_area, true);
	xhttp.send();
}

function add_remarks_tc_search(x){
	var split = x.split('~!~');
	var id_scanned_kanban = split[0];
	var kanban = split[1];
	var kanban_num = split[2];
	var scan_date_time = split[3];
	var request_date_time = split[4];
	var remarks_real_time_status = split[5];
	document.getElementById('remarks_id_scanned_kanban').value = id_scanned_kanban;
	document.getElementById('remarks_kanban').value = kanban;
	document.getElementById('remarks_kanban_num').value = kanban_num;
	document.getElementById('remarks_scan_date_time').value = scan_date_time;
	document.getElementById('remarks_request_date_time').value = request_date_time;
	document.getElementById('remarks_real_time_status').value = remarks_real_time_status;
	$("#Add_Remarks_Form").modal();
}
function add_remarks_tc_search2(x){
	var split = x.split('~!~');
	var id_scanned_kanban = split[0];
	var kanban = split[1];
	var kanban_num = split[2];
	var scan_date_time = split[3];
	var request_date_time = split[4];
	var remarks_real_time_status = split[5];
	document.getElementById('remarks_id_scanned_kanban2').value = id_scanned_kanban;
	document.getElementById('remarks_kanban2').value = kanban;
	document.getElementById('remarks_kanban_num2').value = kanban_num;
	document.getElementById('remarks_scan_date_time2').value = scan_date_time;
	document.getElementById('remarks_request_date_time2').value = request_date_time;
	document.getElementById('remarks_real_time_status2').value = remarks_real_time_status;
	$("#Add_Remarks_Form2").modal();
}
function add_remarks_distributor(x){
	var split = x.split('~!~');
	var id_scanned_kanban = split[0];
	var kanban = split[1];
	var kanban_num = split[2];
	var scan_date_time = split[3];
	var request_date_time = split[4];
	var remarks_real_time_status = split[5];
	document.getElementById('remarks_id_scanned_kanban').value = id_scanned_kanban;
	document.getElementById('remarks_kanban').value = kanban;
	document.getElementById('remarks_kanban_num').value = kanban_num;
	document.getElementById('remarks_scan_date_time').value = scan_date_time;
	document.getElementById('remarks_request_date_time').value = request_date_time;
	document.getElementById('remarks_real_time_status').value = remarks_real_time_status;
	$("#Add_Remarks_Form").modal();
}
function add_remarks_distributor_notif(x){
	var split = x.split('~!~');
	var id_scanned_kanban = split[0];
	var kanban = split[1];
	var kanban_num = split[2];
	var scan_date_time = split[3];
	var request_date_time = split[4];
	var remarks_real_time_status = split[5];
	document.getElementById('remarks_id_scanned_kanban1').value = id_scanned_kanban;
	document.getElementById('remarks_kanban1').value = kanban;
	document.getElementById('remarks_kanban_num1').value = kanban_num;
	document.getElementById('remarks_scan_date_time1').value = scan_date_time;
	document.getElementById('remarks_request_date_time1').value = request_date_time;
	document.getElementById('remarks_real_time_status1').value = remarks_real_time_status;
	$("#Add_Remarks_Form1").modal();
}
function save_distributor_remarks(){
	var scooter_station = "<?php echo $_SESSION['scooter_area'];?>";
	var remarks_id_scanned_kanban = document.getElementById('remarks_id_scanned_kanban').value;
	var remarks_kanban = document.getElementById('remarks_kanban').value;
	var remarks_kanban_num = document.getElementById('remarks_kanban_num').value;
	var remarks_scan_date_time = document.getElementById('remarks_scan_date_time').value;
	var remarks_request_date_time = document.getElementById('remarks_request_date_time').value;
	var distributor_remarks = document.getElementById('distributor_remarks').value;
	var remarks_real_time_status = document.getElementById('remarks_real_time_status').value;
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
	if(this.readyState == 4 && this.status == 200){
		var response = this.responseText;
		select_request();
		document.getElementById('out_distributor_remarks').innerHTML=response;
		open_details_request2(remarks_id_scanned_kanban+'~!~'+remarks_real_time_status);
		setTimeout(close_modal_remarks, 1000);
	}
	};
	xhttp.open("GET", "AJAX/remarks.php?operation=add_remarks_distributor&&remarks_id_scanned_kanban="+remarks_id_scanned_kanban+"&&remarks_kanban="+remarks_kanban+"&&remarks_kanban_num="+remarks_kanban_num+"&&remarks_scan_date_time="+remarks_scan_date_time+"&&remarks_request_date_time="+remarks_request_date_time+"&&distributor_remarks="+distributor_remarks+"&&scooter_station="+scooter_station, true);
	xhttp.send();
}
function save_distributor_remarks1(){
	select_request();
	var scooter_station = "<?php echo $_SESSION['scooter_area'];?>";
	var remarks_id_scanned_kanban = document.getElementById('remarks_id_scanned_kanban1').value;
	var remarks_kanban = document.getElementById('remarks_kanban1').value;
	var remarks_kanban_num = document.getElementById('remarks_kanban_num1').value;
	var remarks_scan_date_time = document.getElementById('remarks_scan_date_time1').value;
	var remarks_request_date_time = document.getElementById('remarks_request_date_time1').value;
	var distributor_remarks = document.getElementById('distributor_remarks1').value;
	var remarks_real_time_status = document.getElementById('remarks_real_time_status1').value;
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
	if(this.readyState == 4 && this.status == 200){
		var response = this.responseText;
		document.getElementById('out_distributor_remarks1').innerHTML=response;
		open_details_request3(remarks_id_scanned_kanban+'~!~'+remarks_kanban+'~!~'+remarks_kanban_num+'~!~'+remarks_scan_date_time+'~!~'+remarks_request_date_time);
		setTimeout(close_modal_remarks1, 1000);
		realtime_remarks();
	}
	};
	xhttp.open("GET", "AJAX/remarks.php?operation=add_remarks_distributor&&remarks_id_scanned_kanban="+remarks_id_scanned_kanban+"&&remarks_kanban="+remarks_kanban+"&&remarks_kanban_num="+remarks_kanban_num+"&&remarks_scan_date_time="+remarks_scan_date_time+"&&remarks_request_date_time="+remarks_request_date_time+"&&distributor_remarks="+distributor_remarks+"&&scooter_station="+scooter_station, true);
	xhttp.send();
}
function save_distributor_remarks2(){
	var scooter_station = "<?php echo $_SESSION['scooter_area'];?>";
	var remarks_id_scanned_kanban = document.getElementById('remarks_id_scanned_kanban2').value;
	var remarks_kanban = document.getElementById('remarks_kanban2').value;
	var remarks_kanban_num = document.getElementById('remarks_kanban_num2').value;
	var remarks_scan_date_time = document.getElementById('remarks_scan_date_time2').value;
	var remarks_request_date_time = document.getElementById('remarks_request_date_time2').value;
	var distributor_remarks = document.getElementById('distributor_remarks2').value;
	var remarks_real_time_status = document.getElementById('remarks_real_time_status2').value;
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
	if(this.readyState == 4 && this.status == 200){
		var response = this.responseText;
		search_action();
		document.getElementById('out_distributor2_remarks').innerHTML=response;
		setTimeout(close_modal_remarks2, 1000);
	}
	};
	xhttp.open("GET", "AJAX/remarks.php?operation=add_remarks_distributor&&remarks_id_scanned_kanban="+remarks_id_scanned_kanban+"&&remarks_kanban="+remarks_kanban+"&&remarks_kanban_num="+remarks_kanban_num+"&&remarks_scan_date_time="+remarks_scan_date_time+"&&remarks_request_date_time="+remarks_request_date_time+"&&distributor_remarks="+distributor_remarks+"&&scooter_station="+scooter_station, true);
	xhttp.send();
}
function read_remarks(x){
	select_request();
	var split = x.split('~!~');
	var id_scanned_kanban = split[0];
	var kanban = split[1];
	var kanban_num = split[2];
	var scan_date_time = split[3];
	var request_date_time = split[4];
	$("#Requested_Parts").modal();
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
	if(this.readyState == 4 && this.status == 200){
		var response = this.responseText;
		get_requestor_name(id_scanned_kanban);
		document.getElementById('scanned_kanban_section_station').innerHTML=response;
	}
	};
	xhttp.open("GET", "AJAX/realtime_remarks.php?operation=read_remarks_now_station&&id_scanned_kanban="+id_scanned_kanban+"&&kanban="+kanban+"&&kanban_num="+kanban_num+"&&scan_date_time="+scan_date_time+"&&request_date_time="+request_date_time, true);
	xhttp.send();
}
select_request();
</script>
<script>
function open_details_request2(x){
	var split = x.split('~!~');
	var id_scanned_kanban = split[0];
	var real_time_status = split[1];
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			var response = this.responseText;
			get_requestor_name(id_scanned_kanban);
			document.getElementById('scanned_kanban_section_station').innerHTML=response;
		}
		};
		xhttp.open("GET", "AJAX/get_requested.php?operation=open_details_request_station&&id_scanned_kanban="+id_scanned_kanban, true);
		xhttp.send();
}
function open_details_request3(x){
	var split = x.split('~!~');
	var id_scanned_kanban = split[0];
	var kanban = split[1];
	var kanban_num = split[2];
	var scan_date_time = split[3];
	var request_date_time = split[4];
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			var response = this.responseText;
			get_requestor_name(id_scanned_kanban);
			document.getElementById('scanned_kanban_section_station').innerHTML=response;
		}
		};
		xhttp.open("GET", "AJAX/realtime_remarks.php?operation=reload_now_station&&id_scanned_kanban="+id_scanned_kanban+"&&kanban="+kanban+"&&kanban_num="+kanban_num+"&&scan_date_time="+scan_date_time+"&&request_date_time="+request_date_time, true);
		xhttp.send();
}
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
		xhttp.open("GET", "AJAX/get_requested.php?operation=open_details_request_station&&id_scanned_kanban="+id_scanned_kanban, true);
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
function out_modal(){
	$('#Request_Parts').modal('toggle');
	select_request();
	clear();
}
function request_x_modal_func(){
	var kanban_scanned_count = document.getElementById('kanban_scanned_count').innerHTML;
	var confirmation_output = document.getElementById('confirmation_output').innerHTML;
	if (kanban_scanned_count != '' && confirmation_output != 'Requested'){
		document.getElementById('confirmation_output').innerHTML='Please Scan your ID Code!';
	}else{
		out_modal();
	}
	
}
function close_modal(){
	$('#Requested_Parts').modal('toggle');
}
function close_modal_remarks(){
	$('#Add_Remarks_Form').modal('toggle');
	document.getElementById('out_distributor_remarks').innerHTML='';
	document.getElementById('distributor_remarks').value='';
	document.getElementById('remarks_id_scanned_kanban').value='';
	document.getElementById('remarks_kanban').value='';
	document.getElementById('remarks_kanban_num').value='';
	document.getElementById('remarks_scan_date_time').value='';
	document.getElementById('remarks_request_date_time').value='';
}
function cancel_delete(){
	$('#Confirm_Id_To_Delete').modal('toggle');
	$("#Request_Parts").modal();
	document.getElementById('confirm_to_delete').value='';
	document.getElementById('deletation_confirmed').innerHTML='';
}
function close_modal_remarks1(){
	$('#Add_Remarks_Form1').modal('toggle');
	document.getElementById('out_distributor_remarks1').innerHTML='';
	document.getElementById('distributor_remarks1').value='';
	document.getElementById('remarks_id_scanned_kanban1').value='';
	document.getElementById('remarks_kanban1').value='';
	document.getElementById('remarks_kanban_num1').value='';
	document.getElementById('remarks_scan_date_time1').value='';
	document.getElementById('remarks_request_date_time1').value='';
}
function close_modal_remarks2(){
	$('#Add_Remarks_Form2').modal('toggle');
	document.getElementById('out_distributor2_remarks').innerHTML='';
	document.getElementById('distributor_remarks2').value='';
	document.getElementById('remarks_id_scanned_kanban2').value='';
	document.getElementById('remarks_kanban2').value='';
	document.getElementById('remarks_kanban_num2').value='';
	document.getElementById('remarks_scan_date_time2').value='';
	document.getElementById('remarks_request_date_time2').value='';
}
function request_parts(){
	$("#Request_Parts").modal();
	setTimeout(function (){
		$('#kanban_scan').focus();
	}, 100);

}
function clear(){
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
request_parts();
</script>
</body>
</html>
