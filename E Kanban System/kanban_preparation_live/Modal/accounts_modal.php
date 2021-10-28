<div class="modal fade" id="Accounts_Form" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header text-center">
				<h4 class="modal-title w-100 font-weight-bold grey-text" id="accounts_head">Add User Account</h4>
				<button type="button" class="close" onclick="close_modal()" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body row">
				<input type="hidden" id="id_hidden">
				<div class="row col-sm-12 col-md-12 col-lg-12" id="name_of_station_section">
					<div class="md-form mb-0 col-sm-6 col-md-6 col-lg-6">
						<input type="text" id="name" class="form-control text-center" value="Name">
						<label for="name" id="name_label" class="ml-3">Name:</label>
					</div>
					<div class="md-form mb-0 col-sm-6 col-md-6 col-lg-6">
						<input type="text" id="username" class="form-control text-center" value="Username">
						<label for="username" id="username_label" class="ml-3">Username:</label>
					</div>
					<div class="md-form mb-0 col-sm-6 col-md-6 col-lg-6">
						<input type="password" id="password" class="form-control text-center">
						<label for="password" id="password_label" class="ml-3">Password:</label>
					</div>
					<div class="md-form mb-0 col-sm-6 col-md-6 col-lg-6">
						<select id="role" class="browser-default form-control">
							<option>Role</option>
							<option>Admin</option>
							<option>MM</option>
						</select>
					</div>
				</div>
				<div class="col-sm-12 col-md-12 col-lg-12 text-center">
					<label class="h6" id="out_account"></label>
				</div>
			</div>
			<div class="modal-footer d-flex justify-content-center">
				<button class="btn unique-color white-text" onclick="save_accounts()" id="save_accounts_button"> Save <i class="fas fa-check"></i></button>
				<button class="btn unique-color white-text" onclick="update_accounts()" id="update_accounts_button" style="display:none;"> Update <i class="far fa-edit"></i></i></button>
				<button class="btn unique-color white-text" onclick="delete_accounts()" id="delete_accounts_button" style="display:none;"> Delete <i class="fas fa-trash"></i></button>
			</div>
		</div>
	</div>
</div>