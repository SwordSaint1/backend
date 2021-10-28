<?php
	// session_start();
	// $username_session = $_SESSION["username_session"];
	// if($username_session == ''){
	// 	header("location:index.php");
	// }
	$view = "prod";
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
	<nav class="navbar fixed-top navbar-expand-lg navbar-dark info-color" style="font-size: 20px;font-weight: bold;color:white;">
	TUBECUTTING MISSING KANBAN - PRODUCTION
	</nav>
<!-- 	<br> -->
<?php
	// include 'Nav/header_mm.php';
	include 'Modal/modal_missing_prod.php';
?>
<div class="row mt-3 ml-0 mr-0 card_opa">
	<div class="row col-lg-12 col-md-12 col-sm-12 mt-2">
		<div class="md-form col-sm-4 col-md-4 col-lg-4 pb-0 mb-0">
			<select id="cycle_day" class="browser-default form-control">
				<option>Cycle Day</option>
				<option>1</option>
				<option>2</option>
				<option selected>3</option>
				<option>4</option>
				<option>5</option>
				<option>6</option>
				<option>7</option>
				<option>8</option>
				<option>9</option>
				<option>10</option>
				<option>11</option>
				<option>12</option>
				<option>13</option>
				<option>14</option>
				<option>15</option>
				<option>16</option>
				<option>17</option>
				<option>18</option>
				<option>19</option>
				<option>20</option>
			</select>
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
				<label for="parts_code" id="parts_code_Label">Parts Code</label>
			</div>
		</div>
		<div class="col-sm-4 col-md-4 col-lg-4 pb-0 mb-0">
			<div class="md-form form-md pb-0 mb-0">
				<input type="text" id="parts_name" class="form-control text-center">
				<label for="parts_name" id="parts_name_Label">Parts Name</label>
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
		<label class="h3"><i class="fas fa-print"></i> Missing Kanban </label>	
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
					<th class="h6">Last Transaction Date</th>
					<th class="h6">Transaction Details</th>
				</tr>
			</thead>
			<tbody id="missing_kanban_list">
			</tbody>
		</table>
	</div>
	<div class="col-sm-12 col-md-12 col-lg-12 text-right mt-0 mb-0 pt-0 pb-0">
		<label id="viewer_count"></label>
	</div>
	<div class="col-sm-12 col-md-12 col-lg-12 text-center mt-0 mb-0 pt-0 pb-0">
		<div class="loader_popup text-info text-center" id="loader_indicator" style="display:none;">Loading....</div>
	</div>
	<div class="col-sm-12 col-md-12 col-lg-12 text-rigth" id="export_excel_showed" style="display:none;">
		<button class="btn btn-info float-right" onclick="export_excel_showed()" data-toggle="tooltip" data-placement="top" title="Export Results"><i class="fas fa-file-download"></i> Excel</button>
	</div>
	<div class="row mx-0 col-sm-12 col-md-12 col-lg-12">
		<input type="hidden" id="load_more_counter" value="0"> <!--  Loadmore Limiter Count  -->
		<div class="rounded-circle info-color card-img-100 mx-auto mb-1 pulse" id="load_more_botton" style="margin-top:-10px;width:50px;height:50px;cursor:pointer;display:none;" onclick="load_more_missing()" data-toggle="tooltip" data-placement="top" title="Load More">
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
<script type="text/javascript">
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

//For Length
var length = document.getElementById("length");
length.addEventListener("keyup", function(event) {
	if (event.keyCode === 13){
		event.preventDefault();
		search_action();
	}
});

search_action();

function search_action(){
	document.getElementById('missing_kanban_list').innerHTML='';
	document.getElementById('loader_indicator').style.display="inline-block";
	var line_no = document.getElementById('line_no').value;
	var parts_code = document.getElementById('parts_code').value;
	var parts_name = document.getElementById('parts_name').value;
	var length = document.getElementById('length').value;
	var kanban_no = document.getElementById('kanban_no').value;
	var cycle_day = document.getElementById('cycle_day').value;
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
	if(this.readyState == 4 && this.status == 200){
		var response = this.responseText;
		document.getElementById('load_more_counter').value=200;
		document.getElementById('load_more_botton').style.display="none";
		document.getElementById('missing_kanban_list').innerHTML=response;
		document.getElementById('export_excel_showed').style.display='inline-block';
		document.getElementById('loader_indicator').style.display="none";
		count_all();
	}
	};
	xhttp.open("GET", "AJAX/missing_kanban.php?operation=display_all&&line_no="+line_no+"&&parts_code="+parts_code+"&&parts_name="+parts_name+"&&length="+length+"&&kanban_no="+kanban_no+"&&cycle_day="+cycle_day+"&&limiter_count=0&&no=0", true);
	xhttp.send();
}
function count_all(){
	var line_no = document.getElementById('line_no').value;
	var parts_code = document.getElementById('parts_code').value;
	var parts_name = document.getElementById('parts_name').value;
	var length = document.getElementById('length').value;
	var kanban_no = document.getElementById('kanban_no').value;
	var cycle_day = document.getElementById('cycle_day').value;
	var load_more_counter = parseInt(document.getElementById('load_more_counter').value);
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
		if (this.readyState == 4 && this.status == 200){
			var response = this.responseText;
			var total_count = parseInt(response);
			var row_count = document.getElementById('missing_kanban_list').rows.length;
			if (total_count > load_more_counter){
				document.getElementById('load_more_botton').style.display='inline-block';
			}else if (total_count < load_more_counter){
				document.getElementById('load_more_botton').style.display='none';
			}
			document.getElementById('viewer_count').innerHTML =row_count+' / '+total_count;
		}
	};
	xhttp.open("GET", "AJAX/missing_kanban.php?operation=count_all&&line_no="+line_no+"&&parts_code="+parts_code+"&&parts_name="+parts_name+"&&length="+length+"&&kanban_no="+kanban_no+"&&cycle_day="+cycle_day+"&&limiter_count="+load_more_counter, true);
	xhttp.send();
}

function load_more_missing(){
	document.getElementById('loader_indicator').style.display="inline-block";
	var line_no = document.getElementById('line_no').value;
	var parts_code = document.getElementById('parts_code').value;
	var parts_name = document.getElementById('parts_name').value;
	var length = document.getElementById('length').value;
	var kanban_no = document.getElementById('kanban_no').value;
	var cycle_day = document.getElementById('cycle_day').value;
	var load_more_counter = parseInt(document.getElementById('load_more_counter').value);
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
	if(this.readyState == 4 && this.status == 200){
		var response = this.responseText;
		document.getElementById('load_more_counter').value = load_more_counter + 200;
		document.getElementById('load_more_botton').style.display="none";
		document.getElementById('missing_kanban_list').innerHTML += response;
		document.getElementById('export_excel_showed').style.display='inline-block';
		document.getElementById('loader_indicator').style.display="none";
		count_all();
	}
	};
	xhttp.open("GET", "AJAX/missing_kanban.php?operation=display_all&&line_no="+line_no+"&&parts_code="+parts_code+"&&parts_name="+parts_name+"&&length="+length+"&&kanban_no="+kanban_no+"&&cycle_day="+cycle_day+"&&limiter_count="+load_more_counter+"&&no="+load_more_counter, true);
	xhttp.send();
}
function open_history_kanban(data_param){
	var split = data_param.split('~!~');
	var kanban = split[0];
	var serial_no = split[1];
	$("#Missing_Kanban_History").modal();
	document.getElementById('loader_indicator_history').style.display="inline-block";
	document.getElementById('hidden_kanban').value=kanban;
	document.getElementById('hidden_serial').value=serial_no;
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
		if (this.readyState == 4 && this.status == 200){
			var response = this.responseText;
			document.getElementById('missing_history_section').innerHTML=response;
			document.getElementById('loader_indicator_history').style.display="none";
		}
	};
	xhttp.open("GET", "AJAX/missing_kanban.php?operation=open_history_kanban&&kanban="+kanban+"&&serial_no="+serial_no+"&&limiter_count=0", true);
	xhttp.send();
}
function close_modal(){
	$('#Missing_Kanban_History').modal('toggle');
	document.getElementById('missing_history_section').innerHTML="";
	document.getElementById('hidden_kanban').value='';
	document.getElementById('hidden_serial').value='';
}
function print_missing(){
	var hidden_kanban = document.getElementById('hidden_kanban').value;
	var hidden_serial = document.getElementById('hidden_serial').value;
	window.open('print_missing_prod.php?serial_no='+hidden_serial,'_blank');
}

function export_excel(){
	var cycle_day = document.getElementById('cycle_day').value;
	var line_no = document.getElementById('line_no').value;
	var parts_code = document.getElementById('parts_code').value;
	var parts_name = document.getElementById('parts_name').value;
	var length = document.getElementById('length').value;
	var kanban_no = document.getElementById('kanban_no').value;
	window.open('export_missing_kanban.php?cycle_day='+cycle_day+
				'&&line_no='+line_no+
				'&&parts_code='+parts_code+
				'&&parts_name='+parts_name+
				'&&length='+length+
				'&&kanban_no='+kanban_no,'_blank');
}

function export_excel_showed(){
	var cycle_day = document.getElementById('cycle_day').value;
	var line_no = document.getElementById('line_no').value;
	var parts_code = document.getElementById('parts_code').value;
	var parts_name = document.getElementById('parts_name').value;
	var length = document.getElementById('length').value;
	var kanban_no = document.getElementById('kanban_no').value;
	var load_more_counter = document.getElementById('load_more_counter').value;
	var count = document.querySelector('#viewer_count').innerHTML;
	var split_count = count.split('/');
	var total_result = split_count[1];
	// console.log(count);
	// console.log(total_result);
	// console.log(load_more_counter);
	window.open('export_search_result_missing_kanban.php?cycle_day='+cycle_day+
				'&&line_no='+line_no+
				'&&parts_code='+parts_code+
				'&&parts_name='+parts_name+
				'&&length='+length+
				'&&kanban_no='+kanban_no+
				'&&limiter='+load_more_counter+
				'&&total_result='+total_result,'_blank');
}
</script> 
</body>
</html>
