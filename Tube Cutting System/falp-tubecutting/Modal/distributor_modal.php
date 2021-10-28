<div class="modal fade" id="Distributor_Form" aria-labelledby="myModalLabel" aria-hidden="true" style='overflow:scroll;'>
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header text-center">
				<h4 class="modal-title w-100 font-weight-bold grey-text" id="scooter_distributor_modal_head">Add Scooter Station</h4>
				<button type="button" class="close" onclick="close_modal()" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body row">
				<input type="hidden" id="id_hidden">
				<div class="row col-sm-12 col-md-12 col-lg-12" id="name_of_station_section">
					<div class="md-form mb-0 col-sm-6 col-md-6 col-lg-6">
						<input type="text" id="id_no" class="form-control text-center" value="ID No">
						<label for="id_no" id="id_no_label" class="ml-3">ID No:</label>
					</div>
					<div class="md-form mb-0 col-sm-6 col-md-6 col-lg-6">
						<input type="text" id="name" class="form-control text-center" value="Name">
						<label for="name" id="name_label" class="ml-3">Name:</label>
					</div>
					<div class="md-form mb-0 col-sm-6 col-md-6 col-lg-6">
						<select id="scooter_area" class="browser-default form-control">
						</select>
					</div>
				</div>
				<div class="col-sm-12 col-md-12 col-lg-12 text-center">
					<label class="h6" id="out_distributor"></label>
				</div>
			</div>
			<div class="modal-footer d-flex justify-content-center">
				<button class="btn btn-info" onclick="save_distributor()" id="save_distributor_button"> Save <i class="fas fa-check"></i></button>
				<button class="btn btn-info" onclick="update_distributor()" id="update_distributor_button" style="display:none;"> Update <i class="far fa-edit"></i></i></button>
				<button class="btn btn-info" onclick="delete_distributor()" id="delete_distributor_button" style="display:none;"> Delete <i class="fas fa-trash"></i></button>
			</div>
		</div>
	</div>
</div>
<script>
	var xhttp;
	if(window.XMLHttpRequest){
		xhttp = new XMLHttpRequest();
	}else{
		xhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xhttp.onreadystatechange = function(){
		if (this.readyState == 4 && this.status == 200){
			var response = this.responseText;
			document.getElementById("scooter_area").innerHTML=response;
		}
	};
	xhttp.open("GET", "AJAX/distributor.php?operation=get_stations", true);
	xhttp.send();
</script>