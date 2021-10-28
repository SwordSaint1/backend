<div class="modal fade" id="Search_Modal_Form_admin" aria-labelledby="myModalLabel" aria-hidden="true" style='overflow:scroll;'>
	<div class="modal-dialog modal-fluid">
		<div class="modal-content">
			<div class="modal-header text-center">
				<h4 class="modal-title w-100 font-weight-bold grey-text" id="stock_address_modal_head">Search Parts</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" >
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body row">
				<div class="row col-sm-12 col-md-12 col-lg-12">
					<div class="md-form mb-0 col-sm-4">
						<input type="text" id="line_no_search" oninput="line_no_search_action()" class="form-control text-center">
						<label for="line_no_search" id="line_no_search_label" class="ml-3">Search Line No:</label>
					</div>
					<div class="md-form mb-0 col-sm-4">
						<input type="text" id="parts_code_search1" oninput="parts_code_search_action()" class="form-control text-center">
						<label for="parts_code_search1" id="parts_code_search_label" class="ml-3">Search Parts Code:</label>
					</div>
					<div class="md-form mb-0 col-sm-4">
						<input type="text" id="parts_name_search1" oninput="parts_name_search_action()" class="form-control text-center">
						<label for="parts_name_search1" id="parts_name_search_label" class="ml-3">Search Parts Name:</label>
					</div>
				</div>
				<div class="row col-sm-12 col-md-12 col-lg-12">
					<table class="table table-bordered">
						<thead class="blue-grey lighten-3">
							<tr>
								<th><strong>No</strong></th>
								<th><strong>Line No</strong></th>
								<th><strong>Stock Address</strong></th>
								<th><strong>Parts Code</strong></th>
								<th><strong>Parts Name</strong></th>
								<th><strong>Length(mm)</strong></th>
								<th><strong>Quantity</strong></th>
								<th><strong>Print</strong></th>
							</tr>
						</thead>
						<tbody id="search_result_all">
							
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>