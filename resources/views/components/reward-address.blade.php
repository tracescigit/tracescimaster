<div id="address-modal" class="modal fade" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header py-3 px-5">
				<h3 class="text-xl font-normal">Redeem Reward</h3>
			</div>
			<form id="address-form" class="col-span-12">
				<div class="modal-body p-5">
					<div class="grid grid-cols-12 row">
						<input type="hidden" name="scheme_id" class="address-modal-scheme">
						<input type="hidden" name="brand" class="address-modal-brand">
						<input type="hidden" name="points" class="address-modal-points">
						<input type="hidden" name="token" class="address-modal-token">

						<div class="col-sm-12 mb-4">
							<label for="name">Name</label>
							<input type="text" class="form-control form__input" name="name" id="name" required/>
							<div id="error-name" class="login__input-error w-auto text-theme-6"></div>
						</div>

						<div class="col-sm-12 mb-4">
							<label for="address">Address</label>
							<input type="text" class="form-control form__input" name="address" id="address" required/>
							<div id="error-address" class="login__input-error w-auto text-theme-6"></div>
						</div>

						<div class="col-sm-6 mb-4">
							<label for="city">City</label>
							<input type="text" class="form-control form__input" name="city" id="city" required/>
							<div id="error-city" class="login__input-error w-auto text-theme-6"></div>
						</div>

						<div class="col-sm-6 mb-4">
							<label for="state">State</label>
							<input type="text" class="form-control form__input" name="state" id="state" required/>
							<div id="error-state" class="login__input-error w-auto text-theme-6"></div>
						</div>

						<div class="col-sm-12 mb-4">
							<label for="pin_code">Pin Code</label>
							<input type="text" class="form-control form__input" name="pin_code" id="pin_code" required/>
							<div id="error-pin_code" class="login__input-error w-auto text-theme-6"></div>
						</div>

						<div id="address-message" class="login__input-error w-auto text-theme-6 col-sm-12"></div>

					</div>
				</div>
				<div class="px-5 py-3 modal-footer">
					<button type="button" data-dismiss="modal" class="btn btn-outline-secondary w-24 mr-auto float-left dismiss-modal">Cancel</button>
					<button type="submit" class="btn btn-primary w-24 ml-auto" id="btn-address">Submit</button>
				</div>
			</form>
		</div>
	</div>
</div>