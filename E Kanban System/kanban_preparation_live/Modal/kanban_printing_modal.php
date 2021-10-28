<div class="modal fade" id="Kanban_Printing_Form" aria-labelledby="myModalLabel" aria-hidden="true" >
	<div class="modal-dialog modal-fluid">
		<div class="modal-content">
			<div class="modal-header text-center">
				<h4 class="modal-title w-100 font-weight-bold grey-text">Kanban Printing</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body row">
				<div class="col-sm-12 col-md-12 col-lg-12 row">
					<div class="md-form mb-0 mt-0 col-sm-2">
						<select class="form-control browser-default custom-select" id="select_printing_category" onchange="printing_category()">
						  <option selected>Print Category</option>
						  <option value="By Batch" >By Batch</option>
						  <option value="By Line No" >By Line No</option>
						  <option value="By Latest Upload" >By Latest Upload</option>
						</select>
					</div>
					<div class="md-form mb-0 mt-0 col-sm-2">
						<!--For List of Scooter Station-->
						<select class="form-control browser-default custom-select" id="select_scooter_station">
						  <option selected>Select Station</option>
						  <option>N/A</option>
						</select>
					</div>
					<div class="md-form mb-0 mt-0 col-sm-2">						<!--For Printing By Batch-->
						<select class="form-control browser-default custom-select" id="select_batch_category" style="display:none;" onchange="printing_batch_cat()">
						  <option selected>Select Batch</option>
						</select>
						<!--For Printing By Line No-->
						<select class="form-control browser-default custom-select" id="select_line_category" style="display:none;" onchange="printing_line_cat()">
						  <option selected>Select Line No</option>
						</select>
					</div>
				</div>
				<div class="col-sm-12 col-md-12 col-lg-12">
					<button class="btn btn-info float-right" onclick="print_all_by_category()"><i class="fas fa-print"></i> Print All</button>
				</div>
				<div class="col-sm-12 col-md-12 col-lg-12" id="kanban_printing_table">
					<table class="table table-bordered table-sm">
						<thead class="blue-grey lighten-4">
							<tr>
								<th>No</th>
								<th>Line No</th>
								<th>Stock Address</th>
								<th>Parts Code</th>
								<th>Parts Name</th>
								<th>Length(mm)</th>
								<th>Quantity</th>
								<th>Print</th>
							</tr>
						</thead>
						<tbody id="kanban_printing_table_list">
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>