<div id="reward-modal" class="modal fade" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header py-3 px-5">
				<h3 class="text-xl font-normal">Redeem Reward</h3>
			</div>
			<form id="reward-form" class="col-span-12">
				<div class="modal-body p-5">
					<div class="grid grid-cols-12">
						<input type="hidden" name="scheme_id" class="reward-modal-scheme">
						<input type="hidden" name="brand" class="reward-modal-brand">
						<input type="hidden" name="points" class="reward-modal-points">
						<input type="hidden" name="token" class="reward-modal-token">

						<div class="col-span-12 mb-4">
							<label for="upi_id">Enter UPI Id</label>
							<input type="text" class="form-control form__input" name="upi_id" id="upi_id" required/>
							<div id="error-upi_id" class="login__input-error w-auto text-theme-6"></div>
						</div>

						<div id="reward-message" class="login__input-error w-auto text-theme-6"></div>

					</div>
				</div>
				<div class="px-5 py-3 modal-footer">
					<button type="button" data-dismiss="modal" class="btn btn-outline-secondary w-24 mr-auto float-left dismiss-modal">Cancel</button>
					<button type="submit" class="btn btn-primary w-24 ml-auto" id="btn-reward">Submit</button>
				</div>
			</form>
		</div>
	</div>
</div>