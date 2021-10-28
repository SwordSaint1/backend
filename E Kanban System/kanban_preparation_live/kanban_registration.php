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
	<title>Kanban Registration (Tube Cutting)</title>
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
	<link rel="shortcut icon" href="favicon.ico" type="image/ico">
	<link href="favicon.png" rel="icon">
	<style>
	.btn-file {
		position: relative;
		overflow: hidden;
		}
		.btn-file input[type=file] {
		position: absolute;
		top: 0;
		right: 0;
		min-width: 100%;
		min-height: 100%;
		font-size: 100px;
		text-align: right;
		filter: alpha(opacity=0);
		opacity: 0;
		outline: none;   
		cursor: inherit;
		display: block;
		}
	</style>
</head>
<body class="bg">
<?php
	include 'Nav/header.php';
	include 'Modal/kanban_registration_modal.php';
	include 'Modal/batch_modal.php';
	include 'Modal/kanban_printing_modal.php';
	include 'Modal/search_admin_kbn.php';
?>
<div class="row ml-0 mr-0 card_opa">
	<div class="col-sm-4 col-md-4 col-lg-4">
	</div>
	<input type="hidden" id="entries_pending">
	<input type="hidden" id="entries_pending_count">
	<div class="col-sm-4 col-md-4 col-lg-4 text-center mt-1">
		<label class="h3"><i class="fas fa-cogs"></i> Kanban Registration</label>	
	</div>
	<div class="col-sm-12 col-md-12 col-lg-12">
		<button class="btn btn-info float-right" onclick="print_kanban_button()"><i class="fas fa-print"></i> Print Kanban</button>
		<button class="btn btn-info float-right" onclick="adding_kanban()"><i class="fas fa-plus-circle"></i> Add Kanban</button>
		<button class="btn btn-info btn-file float-right">
			<form method="post" action="Import/ExcelUpload.php" enctype="multipart/form-data">
				<i class="fas fa-arrow-up"></i><label class="mx-0 my-0" id="loading_indicator"> Upload CSV </label><input type="file" id="file" name="file" onchange="upload_csv()" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
			</form>
		</button>
		<a href="Format/Master List Format.xlsx" download><button class="btn btn-info float-right"><i class="fas fa-arrow-down"></i> Download Format</button></a>
		<button class="btn btn-info float-right" onclick="search_modal_open()"><i class="fas fa-search"></i> Search</button>
	</div>
	<div class="col-sm-12 col-md-12 col-lg-12 text-center mt-1" id="pending_parts_label_section">
		<label class="h4"><i class="fas fa-cogs"></i> Registered Kanban</label>	
	</div>
	<div class="row mx-0 col-sm-12 col-md-12 col-lg-12" id="pending_parts_section">
		<table class="table table-bordered table-sm">
			<thead class="blue-grey lighten-3">
				<tr>
					<th class="h6">No.</th>
					<th class="h6">Line No</th>
					<th class="h6">Stock Address</th>
					<th class="h6">Parts Code</th>
					<th class="h6">Parts Name</th>
					<th class="h6">Comment</th>
					<th class="h6">Length</th>
					<th class="h6">Quantity</th>
					<th class="h6">Kanban No</th>
					<th class="h6">Master Identification</th>
				</tr>
			</thead>
			<tbody id="kanban_list">
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
<!-- For upload Files -->
<script type="text/javascript">
function upload_csv(){
	document.getElementById('loading_indicator').innerHTML = ' Upload Please Wait...';
	var form_data = new FormData();
	var ins = document.getElementById('file').files.length;
	for (var x = 0; x < ins; x++) {
		form_data.append("file", document.getElementById('file').files[x]);
	}
	$.ajax({
		url: 'Import/excelUpload.php', // point to server-side PHP script 
		dataType: 'text', // what to expect back from the PHP script
		cache: false,
		contentType: false,
		processData: false,
		data: form_data,
		type: 'post',
		success: function (response){
			var split = response.split('~!~');
			var status = split[0];
			var batch_no = split[1];
			if(status == 'uploaded'){
				document.getElementById('loading_indicator').innerHTML=' Upload CSV ';
				open_modal_for_print(batch_no);
				select_all();
			}
			},
			error: function (response) {
			$('#msg').html(response); // display error response from the PHP script
			}
	});
}
</script>
<!--For Enter in Search-->
<script>
//For Line No
var line_no_search = document.getElementById("line_no_search");
line_no_search.addEventListener("keyup", function(event) {
	if (event.keyCode === 13){
		event.preventDefault();
		line_no_search_action();
	}
});

//For Parts Code
var parts_code_search = document.getElementById("parts_code_search1");
parts_code_search.addEventListener("keyup", function(event) {
	if (event.keyCode === 13){
		event.preventDefault();
		parts_code_search_action();
	}
});

//For Parts Name
var parts_name_search = document.getElementById("parts_name_search1");
parts_name_search.addEventListener("keyup", function(event) {
	if (event.keyCode === 13){
		event.preventDefault();
		parts_name_search_action();
	}
});

//For Length
var length_search1 = document.getElementById("length_search1");
length_search1.addEventListener("keyup", function(event) {
	if (event.keyCode === 13){
		event.preventDefault();
		length_search1();
	}
});
</script>

<script>
	load_all_station();
	// For Search Parts In Modal
	function search_modal_open(){
		$("#Search_Modal_Form_admin").modal();
	}
	function line_no_search_action(){
		var line_no_search = document.getElementById('line_no_search').value;
		var parts_name_search1 = document.getElementById('parts_name_search1').value;
		var parts_code_search1 = document.getElementById('parts_code_search1').value;
		var length_search1 = document.getElementById('length_search1').value;
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function(){
			if (this.readyState == 4 && this.status == 200){
				var response = this.responseText;
				document.getElementById('search_result_all').innerHTML= response;
			}
		};
		xhttp.open("GET", "AJAX/search_parts.php?operation=display_all&&line_no_search="+line_no_search+"&&parts_code_search1="+parts_code_search1+"&&parts_name_search1="+parts_name_search1+"&&length_search1="+length_search1, true);
		xhttp.send();
	}
	function parts_code_search_action(){
		var line_no_search = document.getElementById('line_no_search').value;
		var parts_name_search1 = document.getElementById('parts_name_search1').value;
		var parts_code_search1 = document.getElementById('parts_code_search1').value;
		var length_search1 = document.getElementById('length_search1').value;
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function(){
			if (this.readyState == 4 && this.status == 200){
				var response = this.responseText;
				document.getElementById('search_result_all').innerHTML= response;
			}
		};
		xhttp.open("GET", "AJAX/search_parts.php?operation=display_all&&line_no_search="+line_no_search+"&&parts_code_search1="+parts_code_search1+"&&parts_name_search1="+parts_name_search1+"&&length_search1="+length_search1, true);
		xhttp.send();
	}
	function parts_name_search_action(){
		var line_no_search = document.getElementById('line_no_search').value;
		var parts_name_search1 = document.getElementById('parts_name_search1').value;
		var parts_code_search1 = document.getElementById('parts_code_search1').value;
		var length_search1 = document.getElementById('length_search1').value;
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function(){
			if (this.readyState == 4 && this.status == 200){
				var response = this.responseText;
				document.getElementById('search_result_all').innerHTML= response;
			}
		};
		xhttp.open("GET", "AJAX/search_parts.php?operation=display_all&&line_no_search="+line_no_search+"&&parts_code_search1="+parts_code_search1+"&&parts_name_search1="+parts_name_search1+"&&length_search1="+length_search1, true);
		xhttp.send();
	}
	function load_all_station(){
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function(){
			if (this.readyState == 4 && this.status == 200){
				var response = this.responseText;
				document.getElementById('select_scooter_station').innerHTML += response;
			}
		};
		xhttp.open("GET", "AJAX/search_parts.php?operation=load_all_station", true);
		xhttp.send();
	}
	function length_search1(){
		var line_no_search = document.getElementById('line_no_search').value;
		var parts_name_search1 = document.getElementById('parts_name_search1').value;
		var parts_code_search1 = document.getElementById('parts_code_search1').value;
		var length_search1 = document.getElementById('length_search1').value;
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function(){
			if (this.readyState == 4 && this.status == 200){
				var response = this.responseText;
				console.log('hi');
				document.getElementById('search_result_all').innerHTML= response;
			}
		};
		xhttp.open("GET", "AJAX/search_parts.php?operation=display_all&&line_no_search="+line_no_search+"&&parts_code_search1="+parts_code_search1+"&&parts_name_search1="+parts_name_search1+"&&length_search1="+length_search1, true);
		xhttp.send();
	}
</script>
<script>
	select_all();
	function print_kanban_button(){
		$("#Kanban_Printing_Form").modal();
	}
	function printing_category(){
		var category = document.getElementById('select_printing_category').value;
		if(category == 'By Batch'){
			document.getElementById('select_batch_category').style.display="inline-block";
			document.getElementById('select_line_category').style.display="none";
			get_all_batch();
		}else if(category == 'By Line No'){
			document.getElementById('select_line_category').style.display="inline-block";
			document.getElementById('select_batch_category').style.display="none";
			get_all_line();
		}else if(category == 'By Latest Upload'){
			document.getElementById('select_batch_category').style.display="none";
			document.getElementById('select_line_category').style.display="none";
			get_latest();
		}
	}
	function get_all_batch(){
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			var response = this.responseText;
			document.getElementById('select_batch_category').innerHTML= response;
		}
		};
		xhttp.open("GET", "AJAX/kanban_printing.php?operation=by_batch", true);
		xhttp.send();
	}
	function get_all_line(){
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			var response = this.responseText;
			document.getElementById('select_line_category').innerHTML= response;
		}
		};
		xhttp.open("GET", "AJAX/kanban_printing.php?operation=by_line", true);
		xhttp.send();
	}
	function get_latest(){
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			var response = this.responseText;
			document.getElementById('kanban_printing_table_list').innerHTML= response;
		}
		};
		xhttp.open("GET", "AJAX/kanban_printing.php?operation=by_latest", true);
		xhttp.send();
	}
	function printing_batch_cat(){
		var batch_id = document.getElementById('select_batch_category').value;
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			var response = this.responseText;
			document.getElementById('kanban_printing_table_list').innerHTML= response;
		}
		};
		xhttp.open("GET", "AJAX/kanban_printing.php?operation=by_batch_cat&&batch_id="+batch_id, true);
		xhttp.send();
	}
	function printing_line_cat(){
		var line_no = document.getElementById('select_line_category').value;
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			var response = this.responseText;
			document.getElementById('kanban_printing_table_list').innerHTML= response;
		}
		};
		xhttp.open("GET", "AJAX/kanban_printing.php?operation=by_line_cat&&line_no="+line_no, true);
		xhttp.send();
	}
	function print_all_by_category(){
		var category = document.getElementById('select_printing_category').value;
		var select_station_category = document.getElementById('select_scooter_station').value;
		if(category == 'By Batch'){
			var batch_id = document.getElementById('select_batch_category').value;
			window.open('print_by_batch.php?batch_no='+batch_id+'&&select_station_category='+select_station_category,'_blank');
		}else if(category == 'By Line No'){
			var line = document.getElementById('select_line_category').value;
			window.open('print_by_line.php?line='+line+'&&select_station_category='+select_station_category,'_blank');
		}else if(category == 'By Latest Upload'){
			window.open('print_by_latest.php?select_station_category='+select_station_category,'_blank');
		}
	}
	function print_single_kanban(x){
		window.open('print_kanban_missing.php?id='+x,'_blank');
	}
	
	
	function adding_kanban(){
		$("#Kanban_Registration_Form").modal();
		document.getElementById('btn_save_kanban').style.display="inline-block";
		document.getElementById('btn_update_kanban').style.display="none";
		document.getElementById('btn_delete_kanban').style.display="none";
		document.getElementById('required_knb_section').style.display="inline-block";
	}
	function open_modal_for_print(x){
		document.getElementById('batch_no_hidden').value=x;
		$("#Uploaded_kanban_Form").modal();
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			var response = this.responseText;
			select_station_category();
			document.getElementById('batch_list').innerHTML= response;
		}
		};
		xhttp.open("GET", "AJAX/kanban_registered.php?operation=by_batch&&batch_no="+x, true);
		xhttp.send();
	}
	function select_station_category(x){
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			var response = this.responseText;
			document.getElementById('select_station_category').innerHTML= response;
		}
		};
		xhttp.open("GET", "AJAX/kanban_registered.php?operation=select_station", true);
		xhttp.send();
	}
	function save_kanban(){
		var production_lot = document.getElementById('production_lot').value;
		var parts_code = document.getElementById('parts_code').value;
		var line_no = document.getElementById('line_no').value;
		var stock_address = document.getElementById('stock_address').value;
		var parts_name = document.getElementById('parts_name').value;
		var comment = document.getElementById('comment').value;
		var length = document.getElementById('length').value;
		var quantity = document.getElementById('quantity').value;
		var required_knb = document.getElementById('required_knb').value;
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			var response = this.responseText;
			var split = response.split('~!~');
			var x = split[0];
			var batch_id = split[1];
			open_modal_for_print(batch_id);
			document.getElementById('production_lot').value='';
			document.getElementById('parts_code').value='';
			document.getElementById('line_no').value='';
			document.getElementById('stock_address').value='';
			document.getElementById('parts_name').value='';
			document.getElementById('comment').value='';
			document.getElementById('length').value='';
			document.getElementById('quantity').value='';
			document.getElementById('required_knb').value='';
			document.getElementById('hidden_id_kanban').value='';
		}
		};
		xhttp.open("GET", "AJAX/kanban_reg.php?operation=add_kanban&&production_lot="+production_lot+"&&parts_code="+parts_code+"&&line_no="+line_no+"&&stock_address="+stock_address+"&&parts_name="+parts_name+"&&comment="+comment+"&&length="+length+"&&quantity="+quantity+"&&required_knb="+required_knb, true);
		xhttp.send();
	}
	function update_kanban(){
		var production_lot = document.getElementById('production_lot').value;
		var parts_code = document.getElementById('parts_code').value;
		var line_no = document.getElementById('line_no').value;
		var stock_address = document.getElementById('stock_address').value;
		var parts_name = document.getElementById('parts_name').value;
		var comment = document.getElementById('comment').value;
		var length = document.getElementById('length').value;
		var quantity = document.getElementById('quantity').value;
		var id_hidden = document.getElementById('hidden_id_kanban').value;
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			var response = this.responseText;
			document.getElementById('output_data').innerHTML=response;
			document.getElementById('production_lot').value='';
			document.getElementById('parts_code').value='';
			document.getElementById('line_no').value='';
			document.getElementById('stock_address').value='';
			document.getElementById('parts_name').value='';
			document.getElementById('comment').value='';
			document.getElementById('length').value='';
			document.getElementById('quantity').value='';
			document.getElementById('hidden_id_kanban').value='';
			setTimeout(function (){
				$('#Kanban_Registration_Form').modal('toggle');
				select_all();
				document.getElementById('production_lot').value='';
				document.getElementById('parts_code').value='';
				document.getElementById('line_no').value='';
				document.getElementById('stock_address').value='';
				document.getElementById('parts_name').value='';
				document.getElementById('comment').value='';
				document.getElementById('length').value='';
				document.getElementById('quantity').value='';
				document.getElementById('hidden_id_kanban').value='';
				document.getElementById('output_data').innerHTML='';
			}, 1000);
		}
		};
		xhttp.open("GET", "AJAX/kanban_reg.php?operation=update_kanban&&production_lot="+production_lot+"&&parts_code="+parts_code+"&&line_no="+line_no+"&&stock_address="+stock_address+"&&parts_name="+parts_name+"&&comment="+comment+"&&length="+length+"&&quantity="+quantity+"&&id_hidden="+id_hidden, true);
		xhttp.send();
	}
	function open_details(x){
		$("#Kanban_Registration_Form").modal();
		document.getElementById('hidden_id_kanban').value=x;
		document.getElementById('btn_save_kanban').style.display="none";
		document.getElementById('btn_update_kanban').style.display="inline-block";
		document.getElementById('btn_delete_kanban').style.display="inline-block";
		document.getElementById('required_knb_section').style.display="none";
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			var response = this.responseText;
			var split = response.split('~!~');
			document.getElementById('production_lot').value=split[0];
			document.getElementById('parts_code').value=split[1];
			document.getElementById('line_no').value=split[2];
			document.getElementById('stock_address').value=split[3];
			document.getElementById('parts_name').value=split[4];
			document.getElementById('comment').value=split[5];
			document.getElementById('length').value=split[6];
			document.getElementById('quantity').value=split[7];
		}
		};
		xhttp.open("GET", "AJAX/kanban_masterlist.php?operation=open_details&&id="+x, true);
		xhttp.send();
	}
	function delete_kanban(){
		var id_hidden = document.getElementById('hidden_id_kanban').value;
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			var response = this.responseText;
			document.getElementById('output_data').innerHTML=response;
			setTimeout(function (){
				$('#Kanban_Registration_Form').modal('toggle');
				select_all();
				document.getElementById('production_lot').value='';
				document.getElementById('parts_code').value='';
				document.getElementById('line_no').value='';
				document.getElementById('stock_address').value='';
				document.getElementById('parts_name').value='';
				document.getElementById('comment').value='';
				document.getElementById('length').value='';
				document.getElementById('quantity').value='';
				document.getElementById('hidden_id_kanban').value='';
				document.getElementById('output_data').innerHTML='';
			}, 1000);
		}
		};
		xhttp.open("GET", "AJAX/kanban_masterlist.php?operation=delete_kanban&&&&id_hidden="+id_hidden, true);
		xhttp.send();
	}
	function select_all(){
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			var response = this.responseText;
			document.getElementById('kanban_list').innerHTML=response;
		}
		};
		xhttp.open("GET", "AJAX/kanban_masterlist.php?operation=select_all", true);
		xhttp.send();
	}
	function print_by_batch_id(){
		var batch_no = document.getElementById('batch_no_hidden').value;
		var select_station_category = document.getElementById('select_station_category').value;
		window.open('print_by_batch.php?batch_no='+batch_no+'&&select_station_category='+select_station_category,'_blank');
	}
</script>
</body>
</html>
