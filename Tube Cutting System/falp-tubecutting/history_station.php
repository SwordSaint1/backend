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
	<title>Station History</title>
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
	include 'Nav/header_scooter.php';
	include 'Modal/history_station.php';
	include 'Modal/news_windows.php';
?>
<div class="row ml-0 mr-0 card_opa">
	<div class="row col-lg-12 col-md-12 col-sm-12 mt-2">
		<div class="col-sm-4 col-md-4 col-lg-4m pb-0 mb-0">
			<div class="md-form form-md pb-0 mb-0">
				<input type="datetime-local" id="date_from" class="form-control text-center">
				<label for="date_from" id="date_from_Label">Date From:</label>
			</div>
		</div>
		<div class="col-sm-4 col-md-4 col-lg-4 pb-0 mb-0">
			<div class="md-form form-md pb-0 mb-0">
				<input type="datetime-local" id="date_to" class="form-control text-center">
				<label for="date_to" id="date_from_Label">Date To:</label>
			</div>
		</div>
		<div class="col-sm-4 col-md-4 col-lg-4 pb-0 mb-0">
			<div class="md-form form-md pb-0 mb-0">
				<input type="text" id="line_no" class="form-control text-center">
				<label for="line_no" id="line_no_Label">Line No</label>
			</div>
		</div>
		<div class="col-sm-4 col-md-4 col-lg-4 pb-0 mb-0">
			<div class="md-form form-md pb-0 mb-0">
				<input type="text" id="parts_code" class="form-control text-center">
				<label for="parts_code" id="parts_code_Label">Parst Code</label>
			</div>
		</div>
		<div class="col-sm-4 col-md-4 col-lg-4 pb-0 mb-0">
			<div class="md-form form-md pb-0 mb-0">
				<input type="text" id="parts_name" class="form-control text-center">
				<label for="parts_name" id="parts_name_Label">Parst Name</label>
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
	<div class="col-sm-4 col-md-4 col-lg-4">
	</div>
	<input type="hidden" id="entries_pending">
	<input type="hidden" id="entries_pending_count">
	
	<div class="col-sm-4 col-md-4 col-lg-4 text-center mt-1">
		<label class="h3"><i class="fas fa-history"></i> History </label>	
	</div>
	<div class="row mx-0 col-sm-12 col-md-12 col-lg-12" id="ongoing_parts_section">
		<table class="table table-bordered table-sm pl-0 pr-0" id="table_his">
			<thead class="blue-grey lighten-3">
				<tr>
					<th class="h6">No</th>
					<th class="h6">Line No</th>
					<th class="h6">Stock Address</th>
					<th class="h6">Parts Code</th>
					<th class="h6">Parts Name</th>
					<th class="h6">Comment</th>
					<th class="h6">Length(mm)</th>
					<th class="h6">Quantity</th>
					<th class="h6">Kanban No</th>
					<th class="h6">Scooter Station</th>
					<th class="h6">Scan Date</th>
					<th class="h6">Request Date</th>
					<th class="h6">Print Date</th>
					<th class="h6">Store Out Date</th>
				</tr>
			</thead>
			<tbody id="requested_parts_this_area">
			</tbody>
		</table>
	</div>
	<div class="col-sm-12 col-md-12 col-lg-12 text-center mt-0 mb-0 pt-0 pb-0">
		<div class="loader_popup text-info text-center" id="loader_indicator" style="display:none;">Loading....</div>
	</div>
	<div class="col-sm-12 col-md-12 col-lg-12 text-rigth" id="export_excel_showed" style="display:none;">
		<button class="btn btn-info float-right" onclick="export_excel_showed()" data-toggle="tooltip" data-placement="top" title="Export Results"><i class="fas fa-file-download"></i> Excel</button>
	</div>
	<div class="row mx-0 col-sm-12 col-md-12 col-lg-12">
		<input type="hidden" id="load_more_counter" value="0"> <!--  Loadmore Limiter Count  -->
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
<!--For Enter in Search-->
<!-- My Tooltip Initialization-->
<script type="text/javascript" src="myjs/tool_tip.js"></script>
<!-- My JacaScript of News-->
<script type="text/javascript" src="myjs/news_window.js"></script>
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

//For Kanaban No
var kanban_no = document.getElementById("kanban_no");
kanban_no.addEventListener("keyup", function(event) {
	if (event.keyCode === 13){
		event.preventDefault();
		search_action();
	}
});
</script>
<script>
	function search_action(){
		document.getElementById('requested_parts_this_area').innerHTML="";
		document.getElementById('loader_indicator').style.display="inline-block";
		document.getElementById('load_more_botton').style.display="none";
		document.getElementById('export_excel_showed').style.display='none';
		var date_from = document.getElementById('date_from').value;
		var date_to = document.getElementById('date_to').value;
		var line_no = document.getElementById('line_no').value;
		var parts_code = document.getElementById('parts_code').value;
		var parts_name = document.getElementById('parts_name').value;
		var comment = document.getElementById('comment').value;
		var length = document.getElementById('length').value;
		var kanban_no = document.getElementById('kanban_no').value;
		var scooter_station = "<?php echo $_SESSION['scooter_area'];?>";
		var load_more_counter = 0;
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			var response = this.responseText;
			if(response == ''){
				document.getElementById('loader_indicator').style.display="none";
				document.getElementById('requested_parts_this_area').innerHTML= "<td colspan='14' style='font-weight:bold;color:red;'><center>NO DATA FOUND</center></td>";
				document.getElementById('export_excel_showed').style.display='none';
			}else{
				document.getElementById('load_more_counter').value=20;
				document.getElementById('requested_parts_this_area').innerHTML=response;
				document.getElementById('loader_indicator').style.display="none";
				document.getElementById('export_excel_showed').style.display='inline-block';
			}
			count_all();
		}
		};
		xhttp.open("GET", "AJAX/history_station.php?operation=display_all&&date_from="+date_from+"&&date_to="+date_to+"&&line_no="+line_no+"&&parts_code="+parts_code+"&&parts_name="+parts_name+"&&comment="+comment+"&&length="+length+"&&kanban_no="+kanban_no+"&&scooter_station="+scooter_station+"&&load_more_counter="+load_more_counter, true);
		xhttp.send();
	}
	function count_all(){
		var date_from = document.getElementById('date_from').value;
		var date_to = document.getElementById('date_to').value;
		var line_no = document.getElementById('line_no').value;
		var parts_code = document.getElementById('parts_code').value;
		var parts_name = document.getElementById('parts_name').value;
		var comment = document.getElementById('comment').value;
		var length = document.getElementById('length').value;
		var kanban_no = document.getElementById('kanban_no').value;
		var scooter_station = "<?php echo $_SESSION['scooter_area'];?>";
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function(){
			if (this.readyState == 4 && this.status == 200){
				var response = this.responseText;
				var load_more_counter = parseInt(document.getElementById('load_more_counter').value);
				var total = parseInt(response);
				if (load_more_counter >= total){
					document.getElementById('load_more_botton').style.display="none";
				}else{
					document.getElementById('load_more_botton').style.display="inline-block";
				}
			}
		};
		xhttp.open("GET", "AJAX/history_station.php?operation=count_all&&date_from="+date_from+"&&date_to="+date_to+"&&line_no="+line_no+"&&parts_code="+parts_code+"&&parts_name="+parts_name+"&&comment="+comment+"&&length="+length+"&&kanban_no="+kanban_no+"&&scooter_station="+scooter_station, true);
		xhttp.send();
	}
	function load_more_history(){
		document.getElementById('loader_indicator').style.display="inline-block";
		document.getElementById('load_more_botton').style.display="none";
		var date_from = document.getElementById('date_from').value;
		var date_to = document.getElementById('date_to').value;
		var line_no = document.getElementById('line_no').value;
		var parts_code = document.getElementById('parts_code').value;
		var parts_name = document.getElementById('parts_name').value;
		var comment = document.getElementById('comment').value;
		var length = document.getElementById('length').value;
		var kanban_no = document.getElementById('kanban_no').value;
		var scooter_station = "<?php echo $_SESSION['scooter_area'];?>";
		var load_more_counter = document.getElementById('load_more_counter').value;
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			var response = this.responseText;
			if(response == ''){
				document.getElementById('loader_indicator').style.display="none";
				document.getElementById('requested_parts_this_area').innerHTML= "<td colspan='14' style='font-weight:bold;color:red;'><center>NO DATA FOUND</center></td>";
			}else{
				document.getElementById('load_more_counter').value = parseInt(load_more_counter) + 20;
				document.getElementById('requested_parts_this_area').innerHTML+=response;
				document.getElementById('loader_indicator').style.display="none";
				document.getElementById('export_excel_showed').style.display='inline-block';
			}
			count_all();
		}
		};
		xhttp.open("GET", "AJAX/history_station.php?operation=display_all&&date_from="+date_from+"&&date_to="+date_to+"&&line_no="+line_no+"&&parts_code="+parts_code+"&&parts_name="+parts_name+"&&comment="+comment+"&&length="+length+"&&kanban_no="+kanban_no+"&&scooter_station="+scooter_station+"&&load_more_counter="+load_more_counter, true);
		xhttp.send();
	}
	function export_excel(){
	var date_from = document.getElementById('date_from').value;
	var date_to = document.getElementById('date_to').value;
	var line_no = document.getElementById('line_no').value;
	var parts_code = document.getElementById('parts_code').value;
	var parts_name = document.getElementById('parts_name').value;
	var comment = document.getElementById('comment').value;
	var length = document.getElementById('length').value;
	var kanban_no = document.getElementById('kanban_no').value;
	var scooter_station = "<?php echo $_SESSION['scooter_area'];?>";
	window.open('export_history_all.php?line_no='+line_no+'&&parts_code='+parts_code+'&&parts_name='+parts_name+'&&date_from='+date_from+'&&date_to='+date_to+'&&scooter_station='+scooter_station+'&&comment='+comment+'&&length='+length+'&&kanban_no='+kanban_no,'_blank');
	}
	function export_excel_showed(){
	var date_from = document.getElementById('date_from').value;
	var date_to = document.getElementById('date_to').value;
	var line_no = document.getElementById('line_no').value;
	var parts_code = document.getElementById('parts_code').value;
	var parts_name = document.getElementById('parts_name').value;
	var comment = document.getElementById('comment').value;
	var length = document.getElementById('length').value;
	var kanban_no = document.getElementById('kanban_no').value;
	var load_more_counter = document.getElementById('load_more_counter').value;
	var scooter_station = "<?php echo $_SESSION['scooter_area'];?>";
		window.open('export_history_results.php?line_no='+line_no+'&&parts_code='+parts_code+'&&parts_name='+parts_name+'&&date_from='+date_from+'&&date_to='+date_to+'&&scooter_station='+scooter_station+"&&limiter="+load_more_counter+'&&comment='+comment+'&&length='+length+'&&kanban_no='+kanban_no,'_blank');
	}
</script>
</body>
</html>
