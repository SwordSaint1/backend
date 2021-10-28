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
	$conn_sql->close();
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
	include 'Modal/search_tc.php';
	include 'Modal/add_remarks_tc_search.php';
	include 'Modal/news_windows.php'; 
?>
<input type='hidden' id='station_hidden' value='<?php echo $_SESSION["scooter_area"];?>'>
<input type='hidden' id='hidden_count_unread' value='0'>
<div class="row ml-0 mr-0 card_opa">
	<div class="col-sm-4 col-md-4 col-lg-4">
	</div>
	<div class="col-sm-12 col-md-12 col-lg-12 text-center mt-3 mb-0 pb-0" id="pending_parts_label_section">
		<label class="h4"><i class="fas fa-pencil-alt"></i> Remarks </label>	
	</div>
	<div class="col-sm-12 col-md-12 col-lg-12 mt-0">
		<div class="md-form mb-0 col-sm-3 float-right mt-0">
			<select class="browser-default custom-select form-control" id="status_sender_id" onchange="status_sender()">
				<option selected>Tubecutting Remarks</option>
				<option>Production Remarks</option>
			</select>
		</div>
	</div>
	<div class="row mx-0 col-sm-12 col-md-12 col-lg-12" id="pending_parts_section">
		<table class="table table-bordered table-sm">
			<thead class="blue-grey lighten-3">
				<tr>
					<th class="h6">No</th>
					<th class="h6">Line No</th>
					<th class="h6">Stock Address</th>
					<th class="h6">Parts Code</th>
					<th class="h6">Parts Name</th>
					<th class="h6">Comment</th>
                    <th class="h6">Length</th>
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
        <div class="loader_popup text-info text-center" id="loading_indicator_notif" style="display:none;">Loading....</div>
    </div>
</div>
</body>
<script>
display_remarks();
function status_sender(){
	display_remarks();
}
function display_remarks(){
	document.getElementById('remarks_area').innerHTML='';
    document.getElementById('loading_indicator_notif').style.display='inline-block';
    var scooter_station = "<?php echo $_SESSION['scooter_area'];?>";
	var status_sender_id = document.getElementById('status_sender_id').value;
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
            var response = this.responseText;
			document.getElementById('loading_indicator_notif').style.display='none';
            document.getElementById('remarks_area').innerHTML=response
		}
	};
	xhttp.open("GET", "AJAX/notification_station.php?operation=display_remarks&&scooter_station="+scooter_station+"&&status_sender_id="+status_sender_id, true);
	xhttp.send();
}
function save_distributor_remarks1(){
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
		setTimeout(close_modal_remarks1, 1000);
		display_remarks();
	}
	};
	xhttp.open("GET", "AJAX/remarks.php?operation=add_remarks_distributor&&remarks_id_scanned_kanban="+remarks_id_scanned_kanban+"&&remarks_kanban="+remarks_kanban+"&&remarks_kanban_num="+remarks_kanban_num+"&&remarks_scan_date_time="+remarks_scan_date_time+"&&remarks_request_date_time="+remarks_request_date_time+"&&distributor_remarks="+distributor_remarks+"&&scooter_station="+scooter_station, true);
	xhttp.send();
}
function add_remarks_distributor_notif(x){
	read_remarks(x);
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
function read_remarks(x){
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
	}
	};
xhttp.open("GET", "AJAX/realtime_remarks.php?operation=read_remarks_now_station&&id_scanned_kanban="+id_scanned_kanban+"&&kanban="+kanban+"&&kanban_num="+kanban_num+"&&scan_date_time="+scan_date_time+"&&request_date_time="+request_date_time, true);
	xhttp.send();
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
function real_time_refresh(){
    var scooter_station = "<?php echo $_SESSION['scooter_area'];?>";
	var status_sender_id = document.getElementById('status_sender_id').value;
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
            var response = this.responseText;
            document.getElementById('remarks_area').innerHTML=response
		}
	};
	xhttp.open("GET", "AJAX/notification_station.php?operation=display_remarks&&scooter_station="+scooter_station+"&&status_sender_id="+status_sender_id, true);
	xhttp.send();
}
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
<script type="text/javascript" src="myjs/realtime_notif_new.js"></script>
<!-- My JacaScript of News-->
<script type="text/javascript" src="myjs/news_window.js"></script>
</html>
