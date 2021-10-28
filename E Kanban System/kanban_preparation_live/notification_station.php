
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
	<title>Notification</title>
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
	include 'Modal/requested_parts_modal.php';
	include 'Modal/add_remarks_distributor.php';
	include 'Modal/add_remarks_distributor_notif.php';
	include 'Modal/news_windows.php'; 
?>
<input type='hidden' id='station_hidden' value='<?php echo $_SESSION["scooter_area"];?>'>
<input type='hidden' id='hidden_count_unread' value='0'>
<input type='hidden' id='notif_count_hidden' value='0'>
<div class="row ml-0 mr-0 card_opa">
	<div class="col-sm-4 col-md-4 col-lg-4">
	</div>
	<div class="col-sm-12 col-md-12 col-lg-12 text-center mt-3 mb-0 pb-0" id="pending_parts_label_section">
		<label class="h4"><i class="fas fa-pencil-alt"></i> <span id="header_notif">Remarks</span> </label>	
	</div>
	<div class="col-sm-12 col-md-12 col-lg-12 mt-0">
		<div class="md-form mb-0 col-sm-3 float-right mx-0 my-0">
			<select class="browser-default custom-select form-control" id="status_sender_id" onchange="status_sender()">
				<option selected>MM Remarks</option>
				<option>Production Remarks</option>
			</select>
		</div>
	</div>
	<div class="row mx-0 col-sm-12 col-md-12 col-lg-12" id="pending_parts_section">
		<table class="table table-bordered table-sm">
			<thead class="unique-color text-white">
				<tr>
					<th class="h6">No</th>
					<th class="h6">Line No</th>
					<th class="h6">Stock Address</th>
					<th class="h6">Parts Code</th>
					<th class="h6">Parts Name</th>
                    <th class="h6">Quantity</th>
                    <th class="h6">Kanban No</th>
                    <th class="h6">Scan Date & Time</th>
                    <th class="h6">Request Date & Time</th>
                    <th class="h6">Remarks</th>
					<th class="h6">Notif Date & Time</th>
                    <th class="h6">Status</th>
				</tr>
			</thead>
			<tbody id="remarks_area">
			</tbody>
		</table>
	</div>
    <div class="rounded-circle info-color card-img-100 mx-auto mb-1 pulse" id="see_more_search" style="margin-top:-10px;width:50px;height:50px;cursor:pointer;display:none;" onclick="see_more_search()" data-toggle="tooltip" data-placement="right" title="See More">
        <i class="text-white fas fa-redo" style="margin-left:17px;margin-top:17px;"></i>
    </div>
    <div class="col-sm-12 col-md-12 col-lg-12 text-center">
        <div class="loader_popup text-center" id="loading_indicator_notif" style="display:none;">Loading....</div>
    </div>
</div>
</body>
<script>
const status_sender =()=>{
	display_remarks();
}
const display_remarks =()=>{
    document.getElementById('remarks_area').innerHTML='';
    document.getElementById('loading_indicator_notif').style.display='inline-block';
	let status_sender_id = document.getElementById('status_sender_id').value;
	let scooter_station = '<?php echo $_SESSION["scooter_area"];?>';
	document.getElementById('header_notif').innerHTML=status_sender_id;
	let xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
            let response = this.responseText;
            document.getElementById('loading_indicator_notif').style.display='none';
            document.getElementById('remarks_area').innerHTML=response
		}
	};
	xhttp.open("GET", "AJAX/notification_station.php?operation=display_remarks&&status_sender_id="+status_sender_id+"&&scooter_station="+scooter_station, true);
	xhttp.send();
}
const add_remarks_station =(data_param)=>{
	let split = data_param.split('~!~');
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
const load_remarks_conversation_save =()=>{
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
	}
	};
	xhttp.open("GET", "AJAX/remarks_distributor.php?operation=load_remarks_conversation&&remarks_id_scanned_kanban="+remarks_id_scanned_kanban+"&&remarks_kanban="+remarks_kanban+"&&remarks_kanban_num="+remarks_kanban_num+"&&remarks_scan_date_time="+remarks_scan_date_time+"&&remarks_request_date_time="+remarks_request_date_time+"&&scooter_station="+scooter_station, true);
	xhttp.send();
}
const update_seen =()=>{
	let status_sender_id = document.getElementById('status_sender_id').value;
	if(status_sender_id == 'MM Remarks'){
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
			display_remarks_after_seen();
		}
		};
		xhttp.open("GET", "AJAX/remarks_distributor.php?operation=update_seen&&remarks_id_scanned_kanban="+remarks_id_scanned_kanban+"&&remarks_kanban="+remarks_kanban+"&&remarks_kanban_num="+remarks_kanban_num+"&&remarks_scan_date_time="+remarks_scan_date_time+"&&remarks_request_date_time="+remarks_request_date_time+"&&scooter_station="+scooter_station, true);
		xhttp.send();
	}else if(status_sender_id == 'Production Remarks'){
	}else{
	}
}
const display_remarks_after_seen =()=>{
	let status_sender_id = document.getElementById('status_sender_id').value;
	let scooter_station = '<?php echo $_SESSION["scooter_area"];?>';
	document.getElementById('header_notif').innerHTML=status_sender_id;
	let xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
            let response = this.responseText;
            document.getElementById('remarks_area').innerHTML=response
		}
	};
	xhttp.open("GET", "AJAX/notification_station.php?operation=display_remarks&&status_sender_id="+status_sender_id+"&&scooter_station="+scooter_station, true);
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
			load_remarks_conversation_save();
		}
		};
		xhttp.open("GET", "AJAX/remarks_distributor.php?operation=add_remarks_distributor&&remarks_id_scanned_kanban="+remarks_id_scanned_kanban+"&&remarks_kanban="+remarks_kanban+"&&remarks_kanban_num="+remarks_kanban_num+"&&remarks_scan_date_time="+remarks_scan_date_time+"&&remarks_request_date_time="+remarks_request_date_time+"&&distributor_remarks="+distributor_remarks+"&&scooter_station="+scooter_station+"&&sender_remarks="+sender_remarks, true);
		xhttp.send();
	}
}
const close_modal_remarks =()=>{
	$('#Add_Remarks_Form').modal('hide');
	document.getElementById('distributor_remarks').value='';
	document.getElementById('remarks_id_scanned_kanban').value='';
	document.getElementById('remarks_kanban').value='';
	document.getElementById('remarks_kanban_num').value='';
	document.getElementById('remarks_scan_date_time').value='';
	document.getElementById('remarks_request_date_time').value='';
	document.getElementById('active_conversation1').value='Close';
	clearTimeout(convo_checker);
}
const distributor_remarks_change =()=>{
	update_seen();
	let distributor_remarks_Label = document.getElementById('distributor_remarks_Label').innerHTML;
	if(distributor_remarks_Label != 'Remarks'){
		document.getElementById('distributor_remarks_Label').innerHTML='Remarks';
	}
}
display_remarks();
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
<script type="text/javascript" src="myjs/real_time_notif_page.js"></script>
<!-- My JavaScript for Realtime Conversations-->
<script type="text/javascript" src="myjs/realtime_conversation_station.js"></script>
<!-- My JacaScript of News-->
<script type="text/javascript" src="myjs/news_window.js"></script>
</html>
