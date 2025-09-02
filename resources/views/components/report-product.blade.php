<div id="report-modal" class="modal fade" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header py-3 px-5">
				<h3 class="text-xl font-normal">Report Product</h3>
			</div>
			<form id="report-form" class="col-span-12">
				<div class="modal-body p-5">
					<div class="grid grid-cols-12">

						<input type="hidden" name="product_id" class="report-modal-product">
						<input type="hidden" name="batch" class="report-modal-batch">
						<input type="hidden" name="token" class="report-modal-token">

						<div class="col-span-12 mb-4">
							<label for="issue_type">Select Issue</label>
							<select class="form-control form__input" name="issue_type" id="issue_type" required>
								<option value="">Please select</option>
								<option value="Damaged Product">Damaged Product</option>
								<option value="Suspicious Product">Suspicious Product</option>
								<option value="Change in Taste">Change in Taste</option>
								<option value="Wrong Product">Wrong Product</option>
								<option value="Retailer Issue">Retailer Issue</option>
								<option value="Product Details Mismatch">Product Details Mismatch</option>
								<option value="Label Altered">Label Altered</option>
								<option value="Other">Other</option>
							</select>
							<div id="error-issue_type" class="login__input-error w-auto text-theme-6"></div>
						</div>

						<div class="col-span-12 mb-4">
							<label for="description">Describe Your Issue</label>
							<textarea class="form-control form__input" name="description" id="description" required></textarea>
							<div id="error-description" class="login__input-error w-auto text-theme-6"></div>
						</div>

						<div id="report-message" class="login__input-error w-auto text-theme-6"></div>

					</div>
				</div>
				<div class="px-5 py-3 modal-footer">
					<button type="button" data-dismiss="modal" class="btn btn-outline-secondary w-24 mr-auto float-left dismiss-modal">Cancel</button>
					<button type="submit" class="btn btn-primary w-24 ml-auto" id="btn-report">Submit</button>
				</div>
			</form>
		</div>
	</div>
</div>