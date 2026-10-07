@extends('vendor.layout.' . $layout)

@section('subhead')
<title>Update Scheme - TRACESCI</title>
@endsection

@section('subcontent')
<div class="intro-y flex items-center mt-8">
	<h2 class="text-lg font-medium mr-auto">Update Scheme</h2>
</div>
<div class="grid grid-cols-12 gap-6 mt-5">
	<div class="intro-y col-span-12 lg:col-span-12">
		<form id="update-form">

			<div class="intro-y box">
				<div class="flex flex-col sm:flex-row items-center px-7 py-5 border-b border-gray-200 dark:border-dark-5">
					<h2 class="font-medium text-base mr-auto">Scheme details</h2>
				</div>
				<div class="p-5">

					<div class="grid grid-cols-12">

						<div class="input-form col-span-12 lg:col-span-12 px-2 py-1">
							<label for="title" class="form-label w-full flex flex-col sm:flex-row">
								Scheme Title
							</label>
							<input id="title" type="text" name="title" class="form-control form__input" value="{{$scheme->title}}" placeholder="Enter title" minlength="2">
							<div id="error-title" class="login__input-error w-5/6 text-theme-6"></div>
						</div>

						<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-2">
							<label for="from" class="form-label w-full flex flex-col sm:flex-row">
								From Date
							</label>
							<input id="from" type="date" name="from" class="form-control form__input" value="{{$scheme->from}}">
							<div id="error-from" class="login__input-error w-5/6 text-theme-6"></div>
						</div>

						<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-2">
							<label for="to" class="form-label w-full flex flex-col sm:flex-row">
								To Date
							</label>
							<input id="to" type="date" name="to" class="form-control form__input" value="{{$scheme->to}}">
							<div id="error-to" class="login__input-error w-5/6 text-theme-6"></div>
						</div>

						<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-2">
							<label for="allow_multiple" class="form-label w-full flex flex-col sm:flex-row">
								Allow Single User to Win Multiple
							</label>
							<select id="allow_multiple" name="allow_multiple" class="form-select form__input">
								<option value="Yes" {{$scheme->allow_multiple=='Yes'?'selected':''}}>Yes</option>
								<option value="No" {{$scheme->allow_multiple=='No'?'selected':''}}>No</option>
							</select>
						</div>

						<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-2">
							<label for="reshuffle_items" class="form-label w-full flex flex-col sm:flex-row">
								Reshuffle Winning Items
							</label>
							<select id="reshuffle_items" name="reshuffle_items" class="form-select form__input">
								<option value="No" {{$scheme->reshuffle_items=='No'?'selected':''}}>No</option>
								<option value="Yes" {{$scheme->reshuffle_items=='Yes'?'selected':''}}>Yes</option>
							</select>
						</div>

						<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-2">
							<label for="status" class="form-label w-full flex flex-col sm:flex-row">
								Status
							</label>
							<select id="status" name="status" class="form-select form__input">
								<option value="Active" {{$scheme->status=='Active'?'selected':''}}>Active</option>
								<option value="Inactive" {{$scheme->status=='Inactive'?'selected':''}}>Inactive</option>
							</select>
						</div>

						<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-2">
							<label for="product_selection_type" class="form-label w-full flex flex-col sm:flex-row">
								Product Selection Type
							</label>
							<select id="product_selection_type" name="product_selection_type" class="form-select form__input">
								<option value="product" {{$scheme->product_selection_type=='product'?'selected':''}}>By Product Name</option>
								<option value="batch" {{$scheme->product_selection_type=='batch'?'selected':''}}>By Batch Code</option>
								<option value="chunk" {{$scheme->product_selection_type=='chunk'?'selected':''}}>By Ranges of Codes</option>
							</select>
						</div>

						<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-2 product-div" style="display:{{($scheme->product_selection_type=='batch' || $scheme->product_selection_type=='product')?'':'none'}};">
							<label for="product" class="form-label w-full flex flex-col sm:flex-row">
								Select product
							</label>
							<select id="product" name="product" class="form-control form__input">
								<option value="">Please select</option>
								@if (count($products)>0)
								@foreach ($products as $product)
								<option value="{{$product->id}}" {{$scheme->product_id==$product->id?'selected':''}}>
									{{$product->name}}
								</option>
								@endforeach
								@endif

							</select>
							<div id="error-product" class="login__input-error w-5/6 text-theme-6"></div>
						</div>

						<div class="input-form col-span-12 lg:col-span-6 mt-2 py-1 px-2 batch-div" style="display:{{$scheme->product_selection_type=='batch'?'':'none'}};">
							<label for="batch" class="form-label">
								Select Batch
							</label>
							<select id="batch" name="batch" class="form-control form__input">
								@if ($batch)
								<option value="{{$batch->code}}" selected>{{$batch->code}}</option>
								@endif
							</select>
							<div id="error-batch" class="login__input-error w-auto text-theme-6"></div>
						</div>

					</div>
				</div>
			</div>

			<div class="intro-y box mt-4 codes-div" style="display:{{$scheme->product_selection_type=='chunk'?'':'none'}};">
				<div class="flex flex-col sm:flex-row items-center px-7 py-5 border-b border-gray-200 dark:border-dark-5">
					<h2 class="font-medium text-base mr-auto">Codes Details</h2>
					<a href="javascript:;" class="float-right add-more-codes mr-3">Add More</a>
					<a href="javascript:;" class="float-right remove-codes" style="display:none;">Remove One</a>
				</div>
				<div class="p-5 codes-area">
					@php
					$codes = json_decode($scheme->codes,true);
					@endphp

					@if (!empty($codes))
					@foreach ($codes as $code)
					@include('vendor.schemes.codes')
					@endforeach
					@endif

				</div>
			</div>

			<div class="intro-y box mt-4">
				<div class="flex flex-col sm:flex-row items-center px-7 py-5 border-b border-gray-200 dark:border-dark-5">
					<h2 class="font-medium text-base mr-auto">Prizes Details</h2>
					<a href="javascript:;" class="float-right add-more-prizes mr-3">Add More</a>
					<a href="javascript:;" class="float-right remove-prizes" style="display:none;">Remove One</a>
				</div>
				<div class="p-5 prizes-area">
					@php
					$items = json_decode($scheme->items,true);
					@endphp

					@if (!empty($items))
					@foreach ($items as $item)
					@include('vendor.schemes.items')
					@endforeach
					@endif
				</div>
			</div>

			<div class="intro-y box mt-4">
				<div class="p-5">
					<div class="grid grid-cols-12">
						<div class="input-form col-span-12 lg:col-span-12 px-2 py-1 mt-3">
							<button type="submit" id="btn-update" class="btn btn-primary w-full xl:w-32 xl:mr-3 align-top">Update Scheme</button>
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

		/* =====================================================
		 * DATE HELPERS
		 * ===================================================== */

		function getToday() {

			let today = new Date();

			let month = String(today.getMonth() + 1).padStart(2, '0');

			let day = String(today.getDate()).padStart(2, '0');

			return today.getFullYear() + '-' + month + '-' + day;

		}


		function setupDateValidation() {

			// No minimum date restriction.
			// Past, today and future dates are allowed.

			let fromDate = cash('#from').val();

			if (fromDate) {

				// To date must be same as or after From date

				cash('#to').attr('min', fromDate);

			}

		}


		/* =====================================================
		 * CLEAR FIELD ERROR
		 * ===================================================== */

		function clearFieldError(selector) {

			cash(selector).removeClass('border-theme-6');

			cash(selector)
				.closest('.input-form')
				.find('.login__input-error')
				.html('');

		}


		/* =====================================================
		 * FROM DATE CHANGE
		 * ===================================================== */

		cash('#from').on('change', function() {

			let fromDate = cash('#from').val();

			let toDate = cash('#to').val();

			clearFieldError('#from');

			clearFieldError('#to');

			if (!fromDate) {

				return;

			}


			// To date must be From date or later

			cash('#to').attr('min', fromDate);

			if (toDate && toDate < fromDate) {

				cash('#to').addClass('border-theme-6');

				cash('#error-to').html(

					'To date must be the same as or after the From date.'

				);

			}

		});


		/* =====================================================
		 * TO DATE CHANGE
		 * ===================================================== */

		cash('#to').on('change', function() {

			let fromDate = cash('#from').val();

			let toDate = cash('#to').val();

			clearFieldError('#to');

			if (!toDate) {

				return;

			}


			// To date must be same as or after From date

			if (fromDate && toDate < fromDate) {

				cash('#to').addClass('border-theme-6');

				cash('#error-to').html(

					'To date must be the same as or after the From date.'

				);

			}

		});


		/* =====================================================
		 * DISPLAY LARAVEL VALIDATION ERRORS
		 * ===================================================== */

		function displayValidationErrors(errors) {

			for (const [key, val] of Object.entries(errors)) {

				let message = Array.isArray(val) ? val[0] : val;


				/*
				 * NORMAL INPUTS
				 *
				 * Examples:
				 * title
				 * from
				 * to
				 * product
				 * batch
				 */

				if (cash('#' + key).length) {

					cash('#' + key)
						.addClass('border-theme-6');

					cash('#error-' + key)
						.html(message);

					continue;

				}


				/*
				 * ARRAY INPUTS
				 *
				 * Examples:
				 * from_codes.0
				 * from_codes.1
				 * to_codes.0
				 * to_codes.1
				 */

				let match = key.match(

					/^(from_codes|to_codes)\.(\d+)$/

				);

				if (match) {

					let fieldName = match[1];

					let index = parseInt(match[2]);

					let input = cash(

						'input[name="' + fieldName + '[]"]'

					).eq(index);

					if (input.length) {

						input.addClass('border-theme-6');

						input
							.closest('.input-form')
							.find('.login__input-error')
							.html(message);

					}

				}

			}

		}


		/* =====================================================
		 * UPDATE SCHEME
		 * ===================================================== */

		async function update() {

			/*
			 * Clear previous errors
			 */

			cash('#update-form')
				.find('.form__input')
				.removeClass('border-theme-6');

			cash('#update-form')
				.find('.login__input-error')
				.html('');


			/* =================================================
			 * DATE VALIDATION
			 * ================================================= */

			let fromDate = cash('#from').val();

			let toDate = cash('#to').val();

			let valid = true;


			/*
			 * FROM DATE REQUIRED
			 */

			if (!fromDate) {

				cash('#from').addClass('border-theme-6');

				cash('#error-from').html(

					'From date is required.'

				);

				valid = false;

			}


			/*
			 * TO DATE REQUIRED
			 */

			if (!toDate) {

				cash('#to').addClass('border-theme-6');

				cash('#error-to').html(

					'To date is required.'

				);

				valid = false;

			}


			/*
			 * TO DATE MUST BE SAME OR AFTER FROM DATE
			 */
			else if (fromDate && toDate < fromDate) {

				cash('#to').addClass('border-theme-6');

				cash('#error-to').html(

					'To date must be the same as or after the From date.'

				);

				valid = false;

			}


			/*
			 * STOP IF DATE VALIDATION FAILED
			 */

			if (!valid) {

				return;

			}


			/* =================================================
			 * FORM DATA
			 * ================================================= */

			var formData = new FormData(

				document.querySelector('#update-form')

			);


			/* =================================================
			 * BUTTON LOADING
			 * ================================================= */

			cash('#btn-update')
				.html(

					'<i data-loading-icon="oval" data-color="white" class="w-5 h-5 mx-auto"></i>'

				)
				.svgLoader();

			cash('#btn-update')
				.attr('disabled', 'true');


			/* =================================================
			 * AXIOS REQUEST
			 * ================================================= */

			axios.post(

					'{{ url("/vendor/schemes/".encrypt($scheme->id)."/edit") }}',

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

						err.response.data.message

					);

					cash('#btn-update')

						.html('Update scheme');

					cash('#btn-update')

						.removeAttr('disabled');


					/*
					 * Display Laravel validation errors
					 */

					if (

						err.response &&

						err.response.data &&

						err.response.data.errors

					) {

						displayValidationErrors(

							err.response.data.errors

						);

					}

				});

		}


		/* =====================================================
		 * FORM SUBMIT
		 * ===================================================== */

		cash('#update-form').on('submit', function(e) {

			e.preventDefault();

			update();

		});


		/* =====================================================
		 * ADD MORE CODES
		 * ===================================================== */

		cash('.add-more-codes').on('click', function(e) {

			e.preventDefault();

			addCodes();

			if (cash('.code-wrapper').length > 1) {

				cash('.remove-codes').show('slow');

			}

		});


		/* =====================================================
		 * REMOVE CODES
		 * ===================================================== */

		cash('.remove-codes').on('click', function(e) {

			e.preventDefault();

			removeCodes();

			if (cash('.code-wrapper').length < 2) {

				cash('.remove-codes').hide('slow');

			}

		});


		/* =====================================================
		 * ADD MORE PRIZES
		 * ===================================================== */

		cash('.add-more-prizes').on('click', function(e) {

			e.preventDefault();

			addPrizes();

			if (cash('.prize-wrapper').length > 1) {

				cash('.remove-prizes').show('slow');

			}

		});


		/* =====================================================
		 * REMOVE PRIZES
		 * ===================================================== */

		cash('.remove-prizes').on('click', function(e) {

			e.preventDefault();

			removePrizes();

			if (cash('.prize-wrapper').length < 2) {

				cash('.remove-prizes').hide('slow');

			}

		});


		/* =====================================================
		 * ADD CODES
		 * ===================================================== */

		async function addCodes() {

			cash('.codes-area').append(

				'<div class="grid grid-cols-12 code-wrapper">' +

				'<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-2">' +

				'<label class="form-label w-full flex flex-col sm:flex-row">' +

				'From Code' +

				'</label>' +

				'<input type="text" name="from_codes[]" class="form-control form__input" required>' +

				'<div class="login__input-error w-5/6 text-theme-6"></div>' +

				'</div>' +

				'<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-2">' +

				'<label class="form-label w-full flex flex-col sm:flex-row">' +

				'To Code' +

				'</label>' +

				'<input type="text" name="to_codes[]" class="form-control form__input" required>' +

				'<div class="login__input-error w-5/6 text-theme-6"></div>' +

				'</div>' +

				'</div>'

			);

		}


		/* =====================================================
		 * ADD PRIZES
		 * ===================================================== */

		async function addPrizes() {

			cash('.prizes-area').append(

				'<div class="grid grid-cols-12 prize-wrapper">' +

				'<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-2">' +

				'<label class="form-label w-full flex flex-col sm:flex-row">' +

				'Item' +

				'</label>' +

				'<input type="text" name="items[]" class="form-control form__input" required>' +

				'</div>' +

				'<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-2">' +

				'<label class="form-label w-full flex flex-col sm:flex-row">' +

				'Quantity' +

				'</label>' +

				'<input type="number" min="1" step="1" name="quantity[]" class="form-control form__input" required>' +

				'</div>' +

				'</div>'

			);

		}


		/* =====================================================
		 * REMOVE CODES
		 * ===================================================== */

		async function removeCodes() {

			cash('.code-wrapper')
				.last()
				.remove();

		}


		/* =====================================================
		 * REMOVE PRIZES
		 * ===================================================== */

		async function removePrizes() {

			cash('.prize-wrapper')
				.last()
				.remove();

		}


		/* =====================================================
		 * FETCH BATCHES
		 * ===================================================== */

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

					cash('#batch').html(res.data);

				})

				.catch(err => {

					showNotification(

						'error',

						'Error !',

						err.response.data.message

					);

				});

		}


		/* =====================================================
		 * PRODUCT CHANGE
		 * ===================================================== */

		cash('#product').on('change', function() {

			fetchBatches();

		});


		/* =====================================================
		 * PRODUCT SELECTION TYPE CHANGE
		 * ===================================================== */

		cash('#product_selection_type').on('change', function() {

			switchTypes();

		});


		/* =====================================================
		 * SWITCH TYPES
		 * ===================================================== */

		async function switchTypes() {

			let type = cash('#product_selection_type').val();


			if (type == 'batch') {

				cash('.batch-div').show();

				cash('.product-div').show();

				cash('.codes-div').hide();

			}


			if (type == 'product') {

				cash('.batch-div').hide();

				cash('.product-div').show();

				cash('.codes-div').hide();

			}


			if (type == 'chunk') {

				cash('.batch-div').hide();

				cash('.product-div').hide();

				cash('.codes-div').show();

			}

		}


		/* =====================================================
		 * INITIALIZE
		 * ===================================================== */

		cash(document).ready(function() {

			setupDateValidation();

		});

	});
</script>

@endsection