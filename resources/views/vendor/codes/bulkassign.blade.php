<div id="assign-modal" class="modal" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header py-3 px-5">
				<h3 class="text-xl font-normal">Bulk assignment</h3>
			</div>
			<div class="modal-body p-5">
				<div class="grid grid-cols-12">
					<h6 class="col-span-12 mb-4">Please fill the form below for bulk assignment.</h6>
					<form id="assign-form" class="col-span-12">
						<div class="col-span-12 mb-4">
							<label for="from_serial_no">From serial number</label>
							<input type="text" placeholder="Enter serial number" min="1" step="1" class="form-control form__input" name="from_serial_no" id="from_serial_no">
							<div id="error-from_serial_no" class="login__input-error w-auto text-theme-6"></div>
						</div>
						<input type="hidden" name="direction" id="direction" value=">=">						
						<div class="col-span-12 mb-4">
							<label for="quantity">Quantity</label>
							<input type="number" placeholder="Enter quantity" min="1" step="1" class="form-control form__input" name="quantity" id="quantity">
							<div id="error-quantity" class="login__input-error w-auto text-theme-6"></div>
						</div>
						<div class="col-span-12 mb-4">
							<label for="product" class="form-label">
								Select product
							</label>
							<select id="product" type="text" name="product" class="form-select form__input">
								<option value="">Please select product</option>
								@if ($products && count($products)>0)
								@foreach ($products as $product)
								<option value="{{$product->id}}">{{$product->name}}</option>
								@endforeach
								@endif
							</select>
							<div id="error-product" class="login__input-error w-auto text-theme-6"></div>
						</div>

						<div class="col-span-12 mb-4">
							<label for="batch" class="form-label">
								Batch
							</label>
							<select id="batch" name="batch" class="form-control form__input">
							</select>
							<div id="error-batch" class="login__input-error w-auto text-theme-6"></div>
						</div>
						
					</form>
				</div>
			</div>
			<div class="px-5 py-3 modal-footer">
				<button type="button" data-dismiss="modal" class="btn btn-outline-secondary w-24 mr-auto float-left">Cancel</button>
				<button type="button" class="btn btn-primary w-24 ml-auto" id="assign-button">Submit</button>
			</div>
		</div>
	</div>
</div>