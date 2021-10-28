<div class="modal fade" id="Reprint_Option_Kanban" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop='static' style="z-index: 2000 !important;overflow:scroll;">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header text-center">
				<h4 class="modal-title w-100 font-weight-bold grey-text">Reprinting Kanban</h4>
				<button type="button" class="close" aria-label="Close" data-dismiss="modal">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body row">
				<div class="col-sm-12 col-md-12 col-lg-12">
					<table class="table table-bordered table-sm">
						<thead class='unique-color text-white'>
							<tr>
								<th><strong>No</strong></th>
								<th><strong>Line No</strong></th>
								<th><strong>Parts Code</strong></th>
								<th><strong>Parts Name</strong></th>
								<th><strong>Kanban No</strong></th>
								<th><strong>Quantity</strong></th>
							</tr>
						</thead>
						<tbody id="reprint_pending_option">
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer d-flex justify-content-center">
				<button class="btn unique-color white-text float-rigth" onclick="reprint_kanban_new()" id="btn_reprint_kanban_new"> Reprint <i class="fas fa-print"></i></button>
				<button class="btn unique-color white-text float-rigth" onclick="cancel_printing_new_kanban()" id="btn_cancel_printing"> Close <i class="fas fa-times"></i></button>
			</div>
		</div>
	</div>
</div>
