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

						<div class="input-form col-span-12 lg:col-span-12 px-2 py-1">
							<label for="title" class="form-label w-full flex flex-col sm:flex-row">
								Scheme Title
							</label>
							<input id="title" type="text" name="title" class="form-control form__input" placeholder="Enter title" minlength="2">
							<div id="error-title" class="login__input-error w-5/6 text-theme-6"></div>
						</div>

						<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-2">
							<label for="reward_points" class="form-label w-full flex flex-col sm:flex-row">
								Reward Points
							</label>
							<input id="reward_points" type="number" min="1" name="reward_points" class="form-control form__input" placeholder="Enter reward points" minlength="2">
							<div id="error-reward_points" class="login__input-error w-5/6 text-theme-6"></div>
						</div>

						<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-2">
							<label for="status" class="form-label w-full flex flex-col sm:flex-row">
								Status
							</label>
							<select id="status" name="status" class="form-select form__input">
								<option value="Active">Active</option>
								<option value="Inactive">Inactive</option>
							</select>
						</div>

						<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-2">
							<label for="from" class="form-label w-full flex flex-col sm:flex-row">
								From Date
							</label>
							<input id="from" type="date" name="from" class="form-control form__input">
							<div id="error-from" class="login__input-error w-5/6 text-theme-6"></div>
						</div>

						<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-2">
							<label for="to" class="form-label w-full flex flex-col sm:flex-row">
								To Date
							</label>
							<input id="to" type="date" name="to" class="form-control form__input">
							<div id="error-to" class="login__input-error w-5/6 text-theme-6"></div>
						</div>

						<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-2">
							<label for="product_selection_type" class="form-label w-full flex flex-col sm:flex-row">
								Product Selection Type
							</label>
							<select id="product_selection_type" name="product_selection_type" class="form-select form__input">
								<option value="product">By Product Name</option>
								<option value="batch">By Batch Code</option>
								<option value="chunk">By products Serial Ranges</option>
							</select>
						</div>

						<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-2 product-div">
							<label for="product" class="form-label w-full flex flex-col sm:flex-row">
								Select product
							</label>
							<select id="product" name="product" class="form-control form__input">
								<option value="">Please select</option>
								@if (count($products)>0)
								@foreach ($products as $product)
								<option value="{{$product->id}}">{{$product->name}}</option>
								@endforeach
								@endif

							</select>
							<div id="error-product" class="login__input-error w-5/6 text-theme-6"></div>
						</div>

						<div class="input-form col-span-12 lg:col-span-6 mt-2 py-1 px-2 batch-div" style="display:none;">
							<label for="batch" class="form-label">
								Select Batch
							</label>
							<select id="batch" name="batch" class="form-control form__input">
							</select>
							<div id="error-batch" class="login__input-error w-auto text-theme-6"></div>
						</div>

					</div>
				</div>
			</div>

			<div class="intro-y box mt-4 codes-div" style="display:none;">
				<div class="flex flex-col sm:flex-row items-center px-7 py-5 border-b border-gray-200 dark:border-dark-5">
					<h2 class="font-medium text-base mr-auto">Codes Details</h2>
					<a href="javascript:;" class="float-right add-more-codes mr-3"><i class="w-4 h-4" data-feather="plus"></i></a>
					<a href="javascript:;" class="float-right remove-codes" style="display:none;"><i class="w-4 h-4" data-feather="minus"></i></a>
				</div>
				<div class="p-5 codes-area">
				</div>
			</div>

			<div class="intro-y box mt-4">
				<div class="flex flex-col sm:flex-row items-center px-7 py-5 border-b border-gray-200 dark:border-dark-5">
					<h2 class="font-medium text-base mr-auto">Reward Details</h2>
					<a href="javascript:;" class="float-right add-more-rewards mr-3"><i class="w-4 h-4" data-feather="plus"></i></a>
					<a href="javascript:;" class="float-right remove-rewards" style="display:none;"><i class="w-4 h-4" data-feather="minus"></i></a>
				</div>
				<div class="p-5 rewards-area">

				</div>
			</div>

			<div class="intro-y box mt-4">
				<div class="p-5">
					<div class="grid grid-cols-12">
						<div class="input-form col-span-12 lg:col-span-12 px-2 py-1 mt-3">
							<button type="submit" id="btn-add" class="btn btn-primary w-full xl:w-32 xl:mr-3 align-top">Add Scheme</button>
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

			// To date must be same as or after From date
			if (fromDate) {
				cash('#to').attr('min', fromDate);
			}
		}


		/* =====================================================
		 * CLEAR FIELD ERROR
		 * ===================================================== */

		function clearFieldError(input) {

			cash(input).removeClass('border-theme-6');

			cash(input)
				.closest('.input-form')
				.find('.login__input-error')
				.html('');
		}


		/* =====================================================
		 * FROM DATE CHANGE
		 * ===================================================== */

		cash('#from').on('change', function() {

			let fromDate = cash(this).val();

			clearFieldError('#from');

			if (fromDate) {

				// To date must be same or after From date
				cash('#to').attr('min', fromDate);

				let toDate = cash('#to').val();

				// Existing To Date is before From Date
				if (toDate && toDate < fromDate) {

					cash('#to').val('');

					cash('#to')
						.addClass('border-theme-6');

					cash('#error-to').html(
						'To date must be the same as or after the From date.'
					);
				}
			}
		});


		/* =====================================================
		 * TO DATE CHANGE
		 * ===================================================== */

		cash('#to').on('change', function() {

			let fromDate = cash('#from').val();
			let toDate = cash(this).val();

			clearFieldError('#to');

			if (fromDate && toDate && toDate < fromDate) {

				cash('#to')
					.addClass('border-theme-6');

				cash('#error-to').html(
					'To date must be the same as or after the From date.'
				);
			}
		});


		/* =====================================================
		 * SHOW VALIDATION ERRORS
		 * ===================================================== */

		function showValidationErrors(errors) {

			console.log('Laravel validation errors:', errors);

			for (const [key, val] of Object.entries(errors)) {

				let message = Array.isArray(val) ?
					val[0] :
					val;


				/* ---------------------------------------------
				 * NORMAL FIELDS
				 *
				 * title
				 * from
				 * to
				 * product
				 * batch
				 * --------------------------------------------- */

				if (cash('#' + key).length) {

					cash('#' + key)
						.addClass('border-theme-6');

					cash('#error-' + key)
						.html(message);

					continue;
				}


				/* ---------------------------------------------
				 * CODE FIELDS
				 *
				 * from_codes.0
				 * to_codes.0
				 * from_codes.1
				 * to_codes.1
				 * --------------------------------------------- */

				let codeMatch = key.match(
					/^(from_codes|to_codes)\.(\d+)$/
				);

				if (codeMatch) {

					let field = codeMatch[1];
					let index = parseInt(codeMatch[2]);

					let row = cash('.code-wrapper').eq(index);

					if (!row.length) {
						continue;
					}


					if (field === 'from_codes') {

						let input = row.find(
							'input[name="from_codes[]"]'
						);

						input.addClass('border-theme-6');

						input
							.next('.login__input-error')
							.html(message);
					}


					if (field === 'to_codes') {

						let input = row.find(
							'input[name="to_codes[]"]'
						);

						input.addClass('border-theme-6');

						input
							.next('.login__input-error')
							.html(message);
					}

					continue;
				}


				/* ---------------------------------------------
				 * REWARD FIELDS
				 *
				 * types.0
				 * points.0
				 * items.0
				 * --------------------------------------------- */

				let rewardMatch = key.match(
					/^(types|points|items)\.(\d+)$/
				);

				if (rewardMatch) {

					let field = rewardMatch[1];
					let index = parseInt(rewardMatch[2]);

					let row = cash('.reward-wrapper').eq(index);

					if (!row.length) {
						continue;
					}


					let input = row.find(
						`[name="${field}[]"]`
					);

					input.addClass('border-theme-6');

					input
						.next('.login__input-error')
						.html(message);
				}
			}
		}


		/* =====================================================
		 * CLEAR ERROR WHEN USER EDITS FIELD
		 * ===================================================== */

		cash(document).on(
			'input change',
			'.form__input',
			function() {

				clearFieldError(this);
			}
		);


		/* =====================================================
		 * ADD
		 * ===================================================== */

		async function add() {

			/* ---------------------------------------------
			 * Clear old errors
			 * --------------------------------------------- */

			cash('#add-form')
				.find('.form__input')
				.removeClass('border-theme-6');

			cash('#add-form')
				.find('.login__input-error')
				.html('');


			/* ---------------------------------------------
			 * Client-side date validation
			 * --------------------------------------------- */

			let fromDate = cash('#from').val();
			let toDate = cash('#to').val();

			let valid = true;


			// From date
			if (!fromDate) {

				cash('#from')
					.addClass('border-theme-6');

				cash('#error-from').html(
					'From date is required.'
				);

				valid = false;
			}


			// To date
			if (!toDate) {

				cash('#to')
					.addClass('border-theme-6');

				cash('#error-to').html(
					'To date is required.'
				);

				valid = false;

			} else if (fromDate && toDate < fromDate) {

				cash('#to')
					.addClass('border-theme-6');

				cash('#error-to').html(
					'To date must be the same as or after the From date.'
				);

				valid = false;
			}


			// Stop if date validation fails
			if (!valid) {
				return;
			}


			/* ---------------------------------------------
			 * Form Data
			 * --------------------------------------------- */

			var formData = new FormData(
				document.querySelector('#add-form')
			);


			/* ---------------------------------------------
			 * Loading
			 * --------------------------------------------- */

			cash('#btn-add')
				.html(
					'<i data-loading-icon="oval" data-color="white" class="w-5 h-5 mx-auto"></i>'
				)
				.svgLoader();

			cash('#btn-add')
				.attr('disabled', 'true');


			/* ---------------------------------------------
			 * Submit
			 * --------------------------------------------- */

			axios.post(
					'{{ url("/vendor/rewards/create") }}',
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
							'{{ url("/vendor/rewards") }}';

					}, 1000);
				})
				.catch(err => {

					console.log(
						'Server response:',
						err.response
					);


					/* -----------------------------------------
					 * Restore button
					 * ----------------------------------------- */

					cash('#btn-add')
						.html('Add Scheme');

					cash('#btn-add')
						.removeAttr('disabled');


					/* -----------------------------------------
					 * Notification
					 * ----------------------------------------- */

					if (
						err.response &&
						err.response.data &&
						err.response.data.message
					) {

						showNotification(
							'error',
							'Error !',
							err.response.data.message
						);
					}


					/* -----------------------------------------
					 * Laravel validation errors
					 * ----------------------------------------- */

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


		/* =====================================================
		 * FORM SUBMIT
		 * ===================================================== */

		cash('#add-form').on(
			'submit',
			function(e) {

				e.preventDefault();

				add();
			}
		);


		/* =====================================================
		 * DOCUMENT READY
		 * ===================================================== */

		cash(document).ready(function() {

			setupDateValidation();

			addCodes();

			addRewards();
		});


		/* =====================================================
		 * ADD MORE CODES
		 * ===================================================== */

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


		/* =====================================================
		 * REMOVE CODES
		 * ===================================================== */

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


		/* =====================================================
		 * ADD MORE REWARDS
		 * ===================================================== */

		cash('.add-more-rewards').on(
			'click',
			function(e) {

				e.preventDefault();

				addRewards();

				if (
					cash('.reward-wrapper').length > 1
				) {

					cash('.remove-rewards')
						.show('slow');
				}
			}
		);


		/* =====================================================
		 * REMOVE REWARDS
		 * ===================================================== */

		cash('.remove-rewards').on(
			'click',
			function(e) {

				e.preventDefault();

				removePrizes();

				if (
					cash('.reward-wrapper').length < 2
				) {

					cash('.remove-rewards')
						.hide('slow');
				}
			}
		);


		/* =====================================================
		 * ADD CODE ROW
		 * ===================================================== */

		async function addCodes() {

			let length =
				cash('.code-wrapper').length;


			cash('.codes-area').append(

				'<div class="grid grid-cols-12 code-wrapper">' +

				'<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-2">' +

				'<label class="form-label w-full flex flex-col sm:flex-row">' +
				'From Code' +
				'</label>' +

				'<input ' +
				'type="text" ' +
				'name="from_codes[]" ' +
				'class="form-control form__input">' +

				'<div class="login__input-error w-5/6 text-theme-6"></div>' +

				'</div>' +


				'<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-2">' +

				'<label class="form-label w-full flex flex-col sm:flex-row">' +
				'To Code' +
				'</label>' +

				'<input ' +
				'type="text" ' +
				'name="to_codes[]" ' +
				'class="form-control form__input">' +

				'<div class="login__input-error w-5/6 text-theme-6"></div>' +

				'</div>' +

				'</div>'
			);
		}


		/* =====================================================
		 * ADD REWARD ROW
		 * ===================================================== */

		async function addRewards() {

			cash('.rewards-area').append(

				'<div class="grid grid-cols-12 reward-wrapper">' +

				'<div class="input-form col-span-12 lg:col-span-4 px-2 py-1 mt-2">' +

				'<label class="form-label w-full flex flex-col sm:flex-row">' +
				'Type' +
				'</label>' +

				'<select ' +
				'name="types[]" ' +
				'class="form-control form__input" ' +
				'required>' +

				'<option value="amount">' +
				'Amount' +
				'</option>' +

				'<option value="product">' +
				'Product' +
				'</option>' +

				'</select>' +

				'<div class="login__input-error w-5/6 text-theme-6"></div>' +

				'</div>' +


				'<div class="input-form col-span-12 lg:col-span-4 px-2 py-1 mt-2">' +

				'<label class="form-label w-full flex flex-col sm:flex-row">' +
				'Points' +
				'</label>' +

				'<input ' +
				'type="text" ' +
				'name="points[]" ' +
				'class="form-control form__input" ' +
				'required>' +

				'<div class="login__input-error w-5/6 text-theme-6"></div>' +

				'</div>' +


				'<div class="input-form col-span-12 lg:col-span-4 px-2 py-1 mt-2">' +

				'<label class="form-label w-full flex flex-col sm:flex-row">' +
				'Value/Item' +
				'</label>' +

				'<input ' +
				'type="text" ' +
				'name="items[]" ' +
				'class="form-control form__input" ' +
				'required>' +

				'<div class="login__input-error w-5/6 text-theme-6"></div>' +

				'</div>' +

				'</div>'
			);
		}


		/* =====================================================
		 * REMOVE CODE
		 * ===================================================== */

		async function removeCodes() {

			cash('.code-wrapper')
				.last()
				.remove();
		}


		/* =====================================================
		 * REMOVE REWARD
		 * ===================================================== */

		async function removePrizes() {

			cash('.reward-wrapper')
				.last()
				.remove();
		}


		/* =====================================================
		 * FETCH BATCHES
		 * ===================================================== */

		async function fetchBatches() {

			let product_id =
				cash('#product').val();

			let formData = {
				product_id: product_id
			};


			axios.post(
					'{{ url("/vendor/getbatches") }}',
					formData
				)
				.then(res => {

					cash('#batch')
						.html(res.data);
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

		cash('#product').on(
			'change',
			function() {

				clearFieldError('#product');

				fetchBatches();
			}
		);


		/* =====================================================
		 * PRODUCT SELECTION TYPE
		 * ===================================================== */

		cash('#product_selection_type').on(
			'change',
			function() {

				clearFieldError(
					'#product_selection_type'
				);

				switchTypes();
			}
		);


		/* =====================================================
		 * SWITCH TYPES
		 * ===================================================== */

		async function switchTypes() {

			let type =
				cash('#product_selection_type').val();


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

	});
</script>

@endsection