<div class="modal fade" id="masterlist_upload" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header text-center">
				<h4 class="modal-title w-100 font-weight-bold grey-text" id="accounts_head">Upload Masterlist</h4>
				<button type="button" class="close" onclick="modal_close_upload()" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body row" id="form_upload">
				<div class="row col-sm-12 col-md-12 col-lg-12 justify-content-center" id="">
					<form action="" method="POST" enctype="multipart/form-data" style="text-align: center;">
						<div class="md-form mb-0 col-sm-12 col-md-12 col-lg-12">
							<input type="file" id="csv_file" name="file" class="green btn">
						</div>
						<div class="md-form mb-0 col-sm-12">
							<input type="submit" class="btn btn blue" id="upload_master_btn" name="upload" value="upload">
						</div>
					</form>
					

					<div class="md-form mb-0 col-sm-6 col-md-6 col-lg-12">
						<a href="Format/Master List Format.csv" class="btn blue" download>Download Template</a>
						
					</div>
					
				</div>
				
			</div>
			<div class="modal-footer d-flex justify-content-center">
				<!-- <button class="btn unique-color white-text" onclick="preview_data_from_csv()" id="save_accounts_button">UPLOAD<i class="fas fa-check"></i></button> -->
			</div>
		</div>
	</div>
</div>