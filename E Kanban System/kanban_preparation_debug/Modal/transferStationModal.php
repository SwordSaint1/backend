<div class="modal fade" id="transfer_kanban" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header text-center">
				<h4 class="modal-title w-100 font-weight-bold grey-text" id="accounts_head">Transfer Kanban</h4>
				<button type="button" class="close" onclick="modal_close_transfer()" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body row" id="form_upload">
				<div class="row col-sm-12 col-md-12 col-lg-12 justify-content-center" id="">
					<!-- SELECTING STATION -->
					<select class="custom-select col-sm-6 z-depth-4" id="station_select_transfer" onchange="" style="display:none;">
						<option value="">--SELECT NEW SCOOTER STATION--</option>
					</select>
					
				</div>
				
			</div>
			<div class="modal-footer d-flex justify-content-center">
				<button class="btn unique-color white-text" onclick="transfer_selected()" id="transferKanbanBtn">Transfer<i class="fas fa-check"></i></button>
			</div>
		</div>
	</div>
</div>