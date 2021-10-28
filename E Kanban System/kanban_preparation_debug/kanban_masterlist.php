<?php
	session_start();
	$username_session = $_SESSION["username_session"];
	if($username_session == ''){
		header("location:index.php");
	}
	require 'AJAX/fetch.php';
	
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>MM Master List</title>
	<link rel="stylesheet" href="Fontawesome/fontawesome-free-5.9.0-web/css/all.css">
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/mdb.min.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet">
	<link href="mycss/style1.css" rel="stylesheet">
	<link rel="shortcut icon" href="favicon.ico" type="image/ico">
	<link href="favicon.png" rel="icon">
</head>
<body class="bg">
<?php
	include 'Nav/header.php';
	include 'Modal/uploadMasterlist.php';
	include 'Modal/add_parts_modal.php';
	include 'Modal/transferStationModal.php';
?>
<div class="row mx-0 my-0">
	<div class="col-sm-4 col-md-4 col-lg-4">
	</div>
	<!-- FIRST 100 -->
	<input type="hidden" id="limit" value="100">
	
	<div class="col-sm-4 col-md-4 col-lg-4 text-center mt-1">
		<label class="h3"><i class="fas fas fa-list-alt"></i> Kanban Masterlist </label>	
	</div>
	<div class="col-sm-12 col-md-12 col-lg-12">
		<!-- <button class="btn unique-color white-text float-right" id="add-item" onclick="add_item_modal()"><i class="fas fa-plus-circle"></i> ADD ITEM</button> -->
		<button class="btn unique-color white-text float-right" onclick="show_modal()"><i class="fas fa-plus-circle"></i> Upload Data</button>

	</div>
	<div class="col-sm-3">
		<select class="custom-select" id="station_select" onchange="load_master_via_filters()">
			<option value="">--SELECT SCOOTER STATION--</option>
		</select>
	</div>

	<div class="col-sm-3">
		<input type="text" class="form-control" name="" id="line_number" placeholder="LINE#" onchange="load_master_via_filters()">
	</div>

	<div class="col-sm-3">
		<input type="text" class="form-control" name="" id="parts_code" placeholder="PARTSCODE" onchange="load_master_via_filters()">
	</div>

	<div class="col-sm-3">
		<!-- <button class="btn unique-color white-text float-right" onclick="export_master()"><i class="fas fa-plus-circle"></i> Export</button> -->
	</div>

	<!-- MENU BUTTONS -->
	<div class="col-sm-12">
		<button id="delete_master_btn" class="btn red white-text btn-sm" style="height:40px;font-size:10px;" onclick="get_to_delete()" disabled="">Delete</button>
		<button id="transfer_master_btn" class="btn blue white-text btn-sm" style="height:40px;font-size:10px;" onclick="transfer_modal()" disabled="">Transfer</button>

	</div>



	<br><br>
	<div class="row mx-0 col-sm-12 col-md-12 col-lg-12" id="scooter_station_section">
		<table class="table table-bordered table-sm">
			<thead>
				<tr class="unique-color white-text"> 
					<td class="h6">
						<div class="form-check">
						  <input
						    class="form-check-input select_all_master"
						    type="checkbox"
						    value=""
						    id="check_all"
						    onclick="select_all_master()"
						  />
						</div>
					</td>
					<td class="h6">QR CODE</td>
					<td class="h6">STATION</td> 
					<td class="h6">KANBAN #</td>
					<td class="h6">LINE #</td>
					<td class="h6">PARTSCODE</td>
					<td class="h6">PARTSNAME</td>
					<td class="h6">QUANTITY</td>
					<td class="h6">SUPPLIER NAME</td>
					<td class="h6">STOCK ADDRESS</td>
					<td class="h6">DATE UPLOADED</td>
					<td class="h6">DATE UPDATED</td>
				</tr>
				<tbody id="masterlist_data">
				</tbody>
			</thead>
		</table>
	</div>
</div>

<!-- JQuery -->
<script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
<script type="text/javascript" src="plugins/sweetalert.min.js"></script>
<script type="text/javascript" src="js/popper.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/mdb.min.js"></script>
<script type="text/javascript" src="myjs/nav.js"></script>
<script>
	//FETCH MASTERLIST
	$(document).ready(function(){
		load_masterlist();
		load_scooter_station();
	});

	const load_masterlist =()=>{
		var limit = $('#limit').val();
		var limit = parseInt(limit) + 100;
		$('#limit').val(limit);
		var line_number = $('#line_number').val();
		var scooter_station = $('#station_select').val();
		var parts_code = $('#parts_code').val();
		$.ajax({
			url: 'AJAX/masterlist_controller.php',
			type: 'POST',
			cache: false,
			data:{
				method: 'load_masterlist',
				limit:limit,
				scooter_station:scooter_station,
				line_number:line_number,
				parts_code:parts_code
			},success:function(data){
				// console.log(response);
				$('#masterlist_data').html(data);

			}
		});	
	}
	// RESET THE LIMIT WHEN CHOOSE OTHER SCOOTER STATION
	const load_master_via_filters =()=>{
		$('#limit').val(100);
		load_masterlist();
	}

	const load_scooter_station =()=>{
		$.ajax({
			url: 'AJAX/masterlist_controller.php',
			type: 'POST',
			cache: false,
			data:{
				method: 'load_station'
			},success:function(x){
				// console.log(x);
				$('#station_select').html(x);
			}
		});
	}


	const load_transfer_station =()=>{
			$('#station_select_transfer').show(300);
			$.ajax({
			url: 'AJAX/masterlist_controller.php',
			type: 'POST',
			cache: false,
			data:{
				method: 'load_transfer_station'
			},success:function(x){
				// console.log(x);
				$('#station_select_transfer').html(x);
			}
		});
	}


	const transfer_modal =()=>{
		$('#transfer_kanban').modal('show');
		load_transfer_station();
	}

	const modal_close_transfer =()=>{
		$('#transfer_kanban').modal('hide');
	}
	// SHOW MODAL UPLOAD MASTERLIST
	const show_modal =()=>{
		$('#masterlist_upload').modal('show');
	}

	// UPLOAD MASTER MODAL CLOSE
	const modal_close_upload =()=>{
		$('#masterlist_upload').modal('hide');
	}

	// ADD ITEM

	const add_item_modal =()=> {
		$('#mm_add_parts').modal('show');
	}


	const close_modal_add =()=>{
		$('#mm_add_parts').modal('hide');
	}

	const select_all_master =()=>{
		var select_all = document.getElementById('check_all');
		 if(select_all.checked == true){
        console.log('check');
        $('.singleCheck').each(function(){
            this.checked=true;
        });
    }else{
        console.log('uncheck');
        $('.singleCheck').each(function(){
            this.checked=false;
        });
    	} 
    	get_checked_length();
	}

	// COUNT CHECKED
	const get_checked_length =()=>{
		var checkedArr = [];
		$('input.singleCheck:checkbox:checked').each(function(){
			checkedArr.push($(this).val());
		});
		var numberOfSelected = checkedArr.length;
		console.log(numberOfSelected);
		if(numberOfSelected > 0){
			$('#delete_master_btn').attr('disabled',false);
			$('#transfer_master_btn').attr('disabled',false);
		}else{
			$('#delete_master_btn').attr('disabled',true);
			$('#transfer_master_btn').attr('disabled',true);
		}
	}

	const get_master_to_delete =()=>{
		var checkedArr = [];
	    $('input.singleCheck:checkbox:checked').each(function(){
	        checkedArr.push($(this).val());
	    });
	    var number_of_selected = checkedArr.length;
	    // console.log(number_of_selected);
	    if(number_of_selected > 0){
	        $('#delete_master_btn').attr('disabled',false);
	        $('#transfer_master_btn').attr('disabled',false);
	    }else{
	       $('#delete_master_btn').attr('disabled',true);
	       $('#transfer_master_btn').attr('disabled',true);
	    }
	}

	// GET ID GOING TO DELETE
	const get_to_delete =()=>{
		var arrID = [];
		$('input.singleCheck:checkbox:checked').each(function(){
			arrID.push($(this).val());
		});
		console.log(arrID);
		var validateNum = arrID.length;
		if(validateNum > 0){
			var x = confirm('CONFIRM DELETE. PLEASE CLICK OK!');
			if(x == true){
				$('#delete_master_btn').attr('disabled',true);
				$('#transfer_master_btn').attr('disabled',true);
				$.ajax({
					url: 'AJAX/masterlist_controller.php',
					type: 'POST',
					cache: false,
					data:{
						method: 'delete_master',
						arrID:arrID
					},success:function(response){
						console.log(response);
						if(response == 'done'){
							swal('SUCCESSFULLY DELETED!','','info');
							load_masterlist();
						}else{
							swal('Error to delete!','','info');
						}
						get_master_to_delete();
						select_all_master();
					}
				});
			}else{
				// DO NOTHING
			}
		}else{
			swal('NO ITEM IS SELECTED','','info');
		}
	}

	// TRANSFER SELECTED 
	const transfer_selected =()=>{
		var arrID = [];	
		$('input.singleCheck:checkbox:checked').each(function(){
			arrID.push($(this).val());
		});
		var new_station = $('#station_select_transfer').val();
		console.log(arrID);
		var validate = arrID.length;
		if(validate > 0){
			$('#delete_master_btn').attr('disabled',true);
			$('#transfer_master_btn').attr('disabled',true);
			$.ajax({
				url: 'AJAX/masterlist_controller.php',
				type: 'POST',
				cache: false,
				data:{
					method: 'transfer_kanban_master',
					arrID:arrID,
					new_station:new_station
				},success:function(response){
					console.log(response);
					if(response == 'done'){
						swal('SUCCESSFULLY DELETED!','','info');
						load_masterlist();
						modal_close_transfer();
					}else{
						swal('Error to delete!','','info');
					}
					get_master_to_delete();
					select_all_master();
				}
			});
		}
	}

	$('#upload_master_btn').click(function(){
		console.log('submit');
		// $("#form_upload").attr("disabled","disabled");
		$(this).val('UPLOADING...');
		$(this).click(false);
	});

	const export_master =()=>{
		var scooter = $('#station_select').val();
		var line = $('#line_number').val();
		var partscode = $('#parts_code').val();
		window.open('export_masterlist.php?scooter_station='+scooter+'&&line='+line+'&&partscode='+partscode);
	}

</script>
</body>
</html>
