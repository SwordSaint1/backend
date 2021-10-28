<div class="modal fade" id="Uploaded_kanban_Form" aria-labelledby="myModalLabel" aria-hidden="true" style="z-index: 2000 !important;" style='overflow:scroll;'>
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header text-center">
				<h4 class="modal-title w-100 font-weight-bold grey-text">Kanban Uploaded</h4>
				<button type="button"class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body row">
				<div class="col-sm-12 col-md-12 col-lg-12 row">
					<div class="col-sm-6 col-md-6 col-lg-6">
						<select class="form-control browser-default custom-select mt-2" id="select_station_category">
						  <option selected>Select Station</option>
						</select>
					</div>
					<div class="col-sm-6 col-md-6 col-lg-6">
						<input type="hidden" id="batch_no_hidden">
						<button class="btn btn-info float-right" onclick="print_by_batch_id()" id="print_by_batch"> Print <i class="fas fa-check"></i></button>
					</div>
				</div>
				<div class="col-sm-12 col-md-12 col-lg-12">
					<table class="table table-bordered">
						<thead class="blue-grey lighten-4">
							<tr>
								<th>No</th>
								<th>Line No</th>
								<th>Stock Address</th>
								<th>Parts Code</th>
								<th>Parts Name</th>
								<th>Length(mm)</th>
								<th>Quantity</th>
							</tr>
						</thead>
						<tbody id="batch_list">
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>