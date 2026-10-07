@extends('vendor.layout.' . $layout)

@section('subhead')
<title>Add Scheme - TRACESCI</title>
@endsection

@section('subcontent')
<div class="intro-y flex items-center mt-8">
	<h2 class="text-lg font-medium mr-auto">Add New Scheme</h2>
</div>

<div class="grid grid-cols-12 gap-6 mt-5">
	<div class="intro-y col-span-12 lg:col-span-12">

		<form id="add-form">
			@csrf

			<div class="intro-y box">

				<div class="flex flex-col sm:flex-row items-center px-7 py-5 border-b border-gray-200 dark:border-dark-5">
					<h2 class="font-medium text-base mr-auto">Scheme details</h2>
				</div>

				<div class="p-5">

					<div class="grid grid-cols-12">

						{{-- Scheme Title --}}
						<div class="input-form col-span-12 lg:col-span-12 px-2 py-1">

							<label for="title" class="form-label w-full flex flex-col sm:flex-row">
								Scheme Title
							</label>

							<input
								id="title"
								type="text"
								name="title"
								class="form-control form__input"
								placeholder="Enter title"
								minlength="2">

							<div
								id="error-title"
								class="login__input-error w-full text-theme-6"></div>

						</div>


						{{-- From Date --}}
						<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-2">

							<label for="from" class="form-label w-full flex flex-col sm:flex-row">
								From Date
							</label>

							<input
								id="from"
								type="date"
								name="from"
								class="form-control form__input">

							<div
								id="error-from"
								class="login__input-error w-full text-theme-6"></div>

						</div>


						{{-- To Date --}}
						<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-2">

							<label for="to" class="form-label w-full flex flex-col sm:flex-row">
								To Date
							</label>

							<input
								id="to"
								type="date"
								name="to"
								class="form-control form__input">

							<div
								id="error-to"
								class="login__input-error w-full text-theme-6"></div>

						</div>


						{{-- Allow Multiple --}}
						<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-2">

							<label for="allow_multiple" class="form-label w-full flex flex-col sm:flex-row">
								Allow Single User to Win Multiple
							</label>

							<select
								id="allow_multiple"
								name="allow_multiple"
								class="form-select form__input">
								<option value="Yes">Yes</option>
								<option value="No">No</option>
							</select>

							<div
								id="error-allow_multiple"
								class="login__input-error w-full text-theme-6"></div>

						</div>


						{{-- Reshuffle Items --}}
						<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-2">

							<label for="reshuffle_items" class="form-label w-full flex flex-col sm:flex-row">
								Reshuffle Winning Items
							</label>

							<select
								id="reshuffle_items"
								name="reshuffle_items"
								class="form-select form__input">
								<option value="No">No</option>
								<option value="Yes">Yes</option>
							</select>

							<div
								id="error-reshuffle_items"
								class="login__input-error w-full text-theme-6"></div>

						</div>


						{{-- Status --}}
						<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-2">

							<label for="status" class="form-label w-full flex flex-col sm:flex-row">
								Status
							</label>

							<select
								id="status"
								name="status"
								class="form-select form__input">
								<option value="Active">Active</option>
								<option value="Inactive">Inactive</option>
							</select>

							<div
								id="error-status"
								class="login__input-error w-full text-theme-6"></div>

						</div>


						{{-- Product Selection Type --}}
						<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-2">

							<label for="product_selection_type" class="form-label w-full flex flex-col sm:flex-row">
								Product Selection Type
							</label>

							<select
								id="product_selection_type"
								name="product_selection_type"
								class="form-select form__input">
								<option value="product">By Product Name</option>
								<option value="batch">By Batch Code</option>
								<option value="chunk">By Ranges of Codes</option>
							</select>

							<div
								id="error-product_selection_type"
								class="login__input-error w-full text-theme-6"></div>

						</div>


						{{-- Product --}}
						<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-2 product-div">

							<label for="product" class="form-label w-full flex flex-col sm:flex-row">
								Select Product
							</label>

							<select
								id="product"
								name="product"
								class="form-control form__input">
								<option value="">Please select</option>

								@if (count($products) > 0)

								@foreach ($products as $product)

								<option value="{{ $product->id }}">
									{{ $product->name }}
								</option>

								@endforeach

								@endif

							</select>

							<div
								id="error-product"
								class="login__input-error w-full text-theme-6"></div>

						</div>


						{{-- Batch --}}
						<div
							class="input-form col-span-12 lg:col-span-6 mt-2 py-1 px-2 batch-div"
							style="display:none;">

							<label for="batch" class="form-label">
								Select Batch
							</label>

							<select
								id="batch"
								name="batch"
								class="form-control form__input">
								<option value="">Please select</option>
							</select>

							<div
								id="error-batch"
								class="login__input-error w-full text-theme-6"></div>

						</div>

					</div>
				</div>
			</div>


			{{-- Codes --}}
			<div
				class="intro-y box mt-4 codes-div"
				style="display:none;">

				<div class="flex flex-col sm:flex-row items-center px-7 py-5 border-b border-gray-200 dark:border-dark-5">

					<h2 class="font-medium text-base mr-auto">
						Codes Details
					</h2>

					<a
						href="javascript:;"
						class="float-right add-more-codes mr-3">
						<i
							class="w-4 h-4"
							data-feather="plus"></i>
					</a>

					<a
						href="javascript:;"
						class="float-right remove-codes"
						style="display:none;">
						<i
							class="w-4 h-4"
							data-feather="minus"></i>
					</a>

				</div>

				<div class="p-5 codes-area"></div>

			</div>


			{{-- Prizes --}}
			<div class="intro-y box mt-4">

				<div class="flex flex-col sm:flex-row items-center px-7 py-5 border-b border-gray-200 dark:border-dark-5">

					<h2 class="font-medium text-base mr-auto">
						Prizes Details
					</h2>

					<a
						href="javascript:;"
						class="float-right add-more-prizes mr-3">
						<i
							class="w-4 h-4"
							data-feather="plus"></i>
					</a>

					<a
						href="javascript:;"
						class="float-right remove-prizes"
						style="display:none;">
						<i
							class="w-4 h-4"
							data-feather="minus"></i>
					</a>

				</div>

				<div class="p-5 prizes-area"></div>

			</div>


			{{-- Submit --}}
			<div class="intro-y box mt-4">

				<div class="p-5">

					<div class="grid grid-cols-12">

						<div class="input-form col-span-12 lg:col-span-12 px-2 py-1 mt-3">

							<button
								type="submit"
								id="btn-add"
								class="btn btn-primary w-full xl:w-32 xl:mr-3 align-top">
								Add Scheme
							</button>

						</div>

					</div>

				</div>

			</div>

		</form>

	</div>

	<x-notification></x-notification>

</div>

@endsection

@section('script')
<script>
	cash(function() {

		/* ==========================================
		 * DATE HELPERS
		 * ========================================== */

		function getToday() {

			let today = new Date();

			let month = String(today.getMonth() + 1).padStart(2, '0');

			let day = String(today.getDate()).padStart(2, '0');

			return `${today.getFullYear()}-${month}-${day}`;

		}


		function setupDateValidation() {

			// No minimum date restriction.
			// Past, today and future dates are allowed.

			let fromDate = cash('#from').val();

			if (fromDate) {

				// To date must be same or after From date

				cash('#to').attr('min', fromDate);

			}

		}


		/* ==========================================
		 * CLEAR FIELD ERROR
		 * ========================================== */

		function clearFieldError(field) {

			cash(field).removeClass('border-theme-6');

			let errorElement = cash(field)
				.closest('.input-form')
				.find('.login__input-error');

			errorElement.html('');

		}


		/* ==========================================
		 * DATE CHANGE
		 * ========================================== */

		cash('#from').on('change', function() {

			let fromDate = cash(this).val();

			clearFieldError('#from');

			if (fromDate) {

				// To date must be same or after From date

				cash('#to').attr('min', fromDate);

				let toDate = cash('#to').val();

				// If selected To Date is before From Date

				if (toDate && toDate < fromDate) {

					cash('#to').val('');

					cash('#to').addClass('border-theme-6');

					cash('#error-to').html(

						'To date must be the same as or after the From date.'

					);

				}

			}

		});


		cash('#to').on('change', function() {

			clearFieldError('#to');

			let fromDate = cash('#from').val();

			let toDate = cash(this).val();

			if (fromDate && toDate && toDate < fromDate) {

				cash('#to').addClass('border-theme-6');

				cash('#error-to').html(

					'To date must be the same as or after the From date.'

				);

			}

		});


		/* ==========================================
		 * SHOW VALIDATION ERRORS
		 * ========================================== */

		function showValidationErrors(errors) {

			for (const [key, value] of Object.entries(errors)) {

				let message = Array.isArray(value) ?
					value[0] :
					value;


				// ==========================================
				// NORMAL FIELDS
				// ==========================================

				if (cash(`#${key}`).length) {

					cash(`#${key}`)
						.addClass('border-theme-6');

					cash(`#error-${key}`)
						.html(message);

					continue;

				}


				// ==========================================
				// CODE FIELDS
				//
				// from_codes.0
				// to_codes.0
				// from_codes.1
				// to_codes.1
				// ==========================================

				let codeMatch = key.match(

					/^(from_codes|to_codes)\.(\d+)$/

				);

				if (codeMatch) {

					let type = codeMatch[1];

					let index = parseInt(codeMatch[2]);

					// Find the correct code-wrapper

					let wrapper = cash('.code-wrapper').eq(index);

					if (!wrapper.length) {

						continue;

					}


					// ======================================
					// FROM CODE
					// ======================================

					if (type === 'from_codes') {

						let input = wrapper.find('.from-code');

						input.addClass('border-theme-6');

						wrapper
							.find('.error-from-code')
							.html(message);

					}


					// ======================================
					// TO CODE
					// ======================================

					if (type === 'to_codes') {

						let input = wrapper.find('.to-code');

						input.addClass('border-theme-6');

						wrapper
							.find('.error-to-code')
							.html(message);

					}

					continue;

				}


				// ==========================================
				// PRIZE FIELDS
				//
				// items.0
				// quantity.0
				// ==========================================

				let prizeMatch = key.match(

					/^(items|quantity)\.(\d+)$/

				);

				if (prizeMatch) {

					let type = prizeMatch[1];

					let index = parseInt(prizeMatch[2]);

					let wrapper = cash('.prize-wrapper').eq(index);

					if (!wrapper.length) {

						continue;

					}


					if (type === 'items') {

						let input = wrapper.find(
							'input[name="items[]"]'
						);

						input.addClass('border-theme-6');

						wrapper
							.find('.error-item')
							.html(message);

					}


					if (type === 'quantity') {

						let input = wrapper.find(
							'input[name="quantity[]"]'
						);

						input.addClass('border-theme-6');

						wrapper
							.find('.error-quantity')
							.html(message);

					}

				}

			}

		}


		/* ==========================================
		 * CLEAR ERRORS WHEN USER CHANGES INPUT
		 * ========================================== */

		cash(document).on(

			'input change',

			'.form__input',

			function() {

				cash(this).removeClass('border-theme-6');

				cash(this)
					.closest('.input-form')
					.find('.login__input-error')
					.html('');

			}

		);


		/* ==========================================
		 * ADD SCHEME
		 * ========================================== */

		async function add() {

			// Clear all previous errors

			cash('#add-form')
				.find('.form__input')
				.removeClass('border-theme-6');

			cash('#add-form')
				.find('.login__input-error')
				.html('');


			/* ------------------------------------------
			 * Client-side date validation
			 * ------------------------------------------ */

			let fromDate = cash('#from').val();

			let toDate = cash('#to').val();

			let valid = true;


			// From date required

			if (!fromDate) {

				cash('#from').addClass('border-theme-6');

				cash('#error-from').html(

					'From date is required.'

				);

				valid = false;

			}


			// To date required

			if (!toDate) {

				cash('#to').addClass('border-theme-6');

				cash('#error-to').html(

					'To date is required.'

				);

				valid = false;

			}


			// To date must be same or after From date
			else if (fromDate && toDate < fromDate) {

				cash('#to').addClass('border-theme-6');

				cash('#error-to').html(

					'To date must be the same as or after the From date.'

				);

				valid = false;

			}


			// Stop submission if date validation fails

			if (!valid) {

				return;

			}


			/* ------------------------------------------
			 * Create FormData
			 * ------------------------------------------ */

			var formData = new FormData(

				document.querySelector('#add-form')

			);


			/* ------------------------------------------
			 * Loading state
			 * ------------------------------------------ */

			cash('#btn-add').html(

				'<i data-loading-icon="oval" data-color="white" class="w-5 h-5 mx-auto"></i>'

			).svgLoader();

			cash('#btn-add').attr(

				'disabled',

				'true'

			);


			/* ------------------------------------------
			 * Submit
			 * ------------------------------------------ */

			axios.post(

					'{{ url("/vendor/schemes/create") }}',

					formData

				)

				.then(res => {

					showNotification(

						'success',

						'Success !',

						res.data.message

					);

					setTimeout(() => {

						window.location.href =

							'{{ url("/vendor/schemes") }}';

					}, 1000);

				})

				.catch(err => {

					showNotification(

						'error',

						'Error !',

						err.response?.data?.message ||

						'Something went wrong.'

					);


					// Restore button

					cash('#btn-add').html(

						'Add Scheme'

					);

					cash('#btn-add').removeAttr(

						'disabled'

					);


					// Show Laravel validation errors

					if (

						err.response &&

						err.response.data &&

						err.response.data.errors

					) {

						showValidationErrors(

							err.response.data.errors

						);

					}

				});

		}


		/* ==========================================
		 * FORM SUBMIT
		 * ========================================== */

		cash('#add-form').on(

			'submit',

			function(e) {

				e.preventDefault();

				add();

			}

		);


		/* ==========================================
		 * INITIAL LOAD
		 * ========================================== */

		cash(document).ready(function() {

			setupDateValidation();

			addCodes();

			addPrizes();

		});


		/* ==========================================
		 * ADD CODES
		 * ========================================== */

		cash('.add-more-codes').on(

			'click',

			function(e) {

				e.preventDefault();

				addCodes();

				if (

					cash('.code-wrapper').length > 1

				) {

					cash('.remove-codes')

						.show('slow');

				}

			}

		);


		/* ==========================================
		 * REMOVE CODES
		 * ========================================== */

		cash('.remove-codes').on(

			'click',

			function(e) {

				e.preventDefault();

				removeCodes();

				if (

					cash('.code-wrapper').length < 2

				) {

					cash('.remove-codes')

						.hide('slow');

				}

			}

		);


		/* ==========================================
		 * ADD PRIZES
		 * ========================================== */

		cash('.add-more-prizes').on(

			'click',

			function(e) {

				e.preventDefault();

				addPrizes();

				if (

					cash('.prize-wrapper').length > 1

				) {

					cash('.remove-prizes')

						.show('slow');

				}

			}

		);


		/* ==========================================
		 * REMOVE PRIZES
		 * ========================================== */

		cash('.remove-prizes').on(

			'click',

			function(e) {

				e.preventDefault();

				removePrizes();

				if (

					cash('.prize-wrapper').length < 2

				) {

					cash('.remove-prizes')

						.hide('slow');

				}

			}

		);


		/* ==========================================
		 * ADD CODE ROW
		 * ========================================== */

		async function addCodes() {

			let index = cash('.code-wrapper').length;

			cash('.codes-area').append(

				'<div class="grid grid-cols-12 code-wrapper">' +

				'<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-2">' +

				'<label class="form-label w-full flex flex-col sm:flex-row">' +

				'From Code' +

				'</label>' +

				'<input type="text" ' +

				'name="from_codes[]" ' +

				'class="form-control form__input from-code">' +

				'<div class="login__input-error w-full text-theme-6 error-from-code"></div>' +

				'</div>' +

				'<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-2">' +

				'<label class="form-label w-full flex flex-col sm:flex-row">' +

				'To Code' +

				'</label>' +

				'<input type="text" ' +

				'name="to_codes[]" ' +

				'class="form-control form__input to-code">' +

				'<div class="login__input-error w-full text-theme-6 error-to-code"></div>' +

				'</div>' +

				'</div>'

			);

		}


		/* ==========================================
		 * ADD PRIZE ROW
		 * ========================================== */

		async function addPrizes() {

			cash('.prizes-area').append(

				'<div class="grid grid-cols-12 prize-wrapper">' +

				'<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-2">' +

				'<label class="form-label w-full flex flex-col sm:flex-row">' +

				'Item' +

				'</label>' +

				'<input ' +

				'type="text" ' +

				'name="items[]" ' +

				'class="form-control form__input" ' +

				'required>' +

				'<div class="login__input-error w-5/6 text-theme-6"></div>' +

				'</div>' +

				'<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-2">' +

				'<label class="form-label w-full flex flex-col sm:flex-row">' +

				'Quantity' +

				'</label>' +

				'<input ' +

				'type="number" ' +

				'min="1" ' +

				'step="1" ' +

				'name="quantity[]" ' +

				'class="form-control form__input" ' +

				'required>' +

				'<div class="login__input-error w-5/6 text-theme-6"></div>' +

				'</div>' +

				'</div>'

			);

		}


		/* ==========================================
		 * REMOVE CODE ROW
		 * ========================================== */

		async function removeCodes() {

			cash('.code-wrapper')

				.last()

				.remove();

		}


		/* ==========================================
		 * REMOVE PRIZE ROW
		 * ========================================== */

		async function removePrizes() {

			cash('.prize-wrapper')

				.last()

				.remove();

		}


		/* ==========================================
		 * FETCH BATCHES
		 * ========================================== */

		async function fetchBatches() {

			let product_id = cash('#product').val();

			let formData = {

				product_id: product_id

			};


			axios.post(

					'{{ url("/vendor/getbatches") }}',

					formData

				)

				.then(res => {

					cash('#batch').html(

						res.data

					);

				})

				.catch(err => {

					showNotification(

						'error',

						'Error !',

						err.response?.data?.message ||

						'Unable to fetch batches.'

					);

				});

		}


		/* ==========================================
		 * PRODUCT CHANGE
		 * ========================================== */

		cash('#product').on(

			'change',

			function() {

				// Clear product error

				clearFieldError('#product');

				fetchBatches();

			}

		);


		/* ==========================================
		 * PRODUCT SELECTION TYPE
		 * ========================================== */

		cash('#product_selection_type').on(

			'change',

			function() {

				switchTypes();

			}

		);


		/* ==========================================
		 * SWITCH PRODUCT TYPES
		 * ========================================== */

		async function switchTypes() {

			let type =

				cash('#product_selection_type').val();


			// By Batch

			if (type == 'batch') {

				cash('.batch-div').show();

				cash('.product-div').show();

				cash('.codes-div').hide();

			}


			// By Product

			if (type == 'product') {

				cash('.batch-div').hide();

				cash('.product-div').show();

				cash('.codes-div').hide();

			}


			// By Code Range

			if (type == 'chunk') {

				cash('.batch-div').hide();

				cash('.product-div').hide();

				cash('.codes-div').show();

			}

		}

	});
</script>

@endsection