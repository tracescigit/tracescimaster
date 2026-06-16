@extends('web.layouts.app')

@section('title',$brand)

@section('content')

<style>
	html,
	body {
		background: #f5f5f5;
	}

	.scan-minimal {
		min-height: 100vh;
		display: flex;
		align-items: center;
		justify-content: center;
		padding: 40px 20px;
		background: #f5f5f5;
	}

	.scan-minimal-box {
		width: 100%;
		max-width: 400px;
		position: relative;
		background: #ffffff;
		border: 1px solid #000;
		border-radius: 12px;
		padding: 36px 32px;
		box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
	}

	.scan-minimal-icon {
		width: 52px;
		height: 52px;
		border-radius: 12px;
		background: #000;
		border: 1px solid #000;
		display: flex;
		align-items: center;
		justify-content: center;
		color: #fff;
		font-size: 22px;
		margin: 0 auto 24px;
	}

	.scan-eyebrow {
		font-family: 'JetBrains Mono', 'SF Mono', Consolas, monospace;
		font-size: 11px;
		letter-spacing: 0.18em;
		text-transform: uppercase;
		color: #000;
		text-align: center;
		margin: 0 0 10px;
		font-weight: 600;
	}

	.text-bg {
		font-family: 'Sora', 'Helvetica Neue', Arial, sans-serif !important;
		font-size: 26px !important;
		color: #000 !important;
		padding: 0 !important;
		text-transform: none !important;
		line-height: 1.3 !important;
		border-width: 0 !important;
		margin: 0 0 8px !important;
		text-align: center !important;
		letter-spacing: -0.01em !important;
		font-weight: 700 !important;
	}

	.scan-minimal-sub {
		color: #666;
		font-size: 14px;
		text-align: center;
		margin: 0 0 32px;
		line-height: 1.6;
		font-family: 'Inter', 'Helvetica Neue', Arial, sans-serif;
	}

	#main.wrapper {
		padding-top: 0;
	}

	.scan-minimal-form .form-div {
		margin-bottom: 16px;
	}

	.scan-minimal-form .form-control {
		border: 1px solid #d9d9d9;
		border-radius: 10px;
		height: 50px;
		font-size: 15px;
		color: #000;
		background: #fff;
		box-shadow: none;
		text-align: center;
		font-family: 'Inter', 'Helvetica Neue', Arial, sans-serif;
		transition: all 0.2s ease;
	}

	.scan-minimal-form .form-control:focus {
		border-color: #000;
		outline: none;
		box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.08);
	}

	.scan-minimal-form select.form-control {
		font-weight: 600;
		color: #000;
	}

	.scan-minimal-form input::placeholder {
		text-align: center;
		color: #999;
	}

	.scan-field-error {
		color: #c0392b;
		font-size: 12px;
		margin-top: 6px;
		text-align: center;
		font-family: 'Inter', 'Helvetica Neue', Arial, sans-serif;
	}

	.scan-otp-success {
		color: #000;
		background: #fff;
		border: 1px solid #000;
		padding: 12px 16px;
		border-radius: 10px;
		font-size: 13px;
		text-align: center;
		font-weight: 600;
		margin-bottom: 16px;
		font-family: 'Inter', 'Helvetica Neue', Arial, sans-serif;
	}

	.scan-minimal-form .contact-btn,
	.scan-minimal-form .secret-btn {
		width: 100%;
		background: #000 !important;
		border: 1px solid #000 !important;
		color: #fff !important;
		border-radius: 10px;
		height: 50px;
		font-size: 15px;
		font-weight: 700;
		letter-spacing: 0.01em;
		text-transform: none;
		font-family: 'Sora', 'Helvetica Neue', Arial, sans-serif;
		transition: all 0.2s ease;
	}

	.scan-minimal-form .contact-btn:hover,
	.scan-minimal-form .secret-btn:hover {
		background: #222 !important;
		border-color: #222 !important;
	}

	.scan-minimal-form .contact-btn:active,
	.scan-minimal-form .secret-btn:active {
		transform: scale(0.98);
	}

	.scan-minimal-hint {
		font-size: 12px;
		color: #888;
		text-align: center;
		margin-top: 24px;
		line-height: 1.6;
		font-family: 'Inter', 'Helvetica Neue', Arial, sans-serif;
	}

	.row.form-div,
	.row.secret-div {
		margin: 0 !important;
	}

	.info-div {
		margin-top: 0;
	}

	@media (max-width: 420px) {
		.scan-minimal {
			padding: 24px 16px;
		}

		.scan-minimal-box {
			padding: 28px 22px;
		}

		.text-bg {
			font-size: 21px !important;
		}
	}
</style>

<div class="scan-minimal">
	<div class="scan-minimal-box">

		<div class="scan-minimal-icon">
			<i class="fa fa-qrcode"></i>
		</div>

		<div class="scan-eyebrow">Authenticity check</div>

		<div class="text-bg">
			You're one step from the details
		</div>
		<div class="scan-minimal-sub">
			Verify your phone number to view this product's journey.
		</div>

		<div id="main" class="wrapper">

			<div class="scan-minimal-form">

				<div class="row" style="margin: 0;">
					<div class="col-xs-4 col-sm-3 form-div">
						<select name="country_code" class="form-control form__input" id="country_code" style="opacity:{{$auth_required==true?'':'0'}};">
							@if (count(countries())>0)
							@foreach (countries() as $country)
							<option value="{{$country->phonecode}}" {{$country->phonecode=='91'?'selected':''}}>+{{$country->phonecode}}</option>
							@endforeach
							@else
							<option value="91">+91</option>
							@endif
						</select>
					</div>

					<div class="col-xs-8 col-sm-9 form-div" style="opacity:{{$auth_required==true?'':'0'}};">
						<input class="form-control form__input" type="tel" name="phone" id="phone" placeholder="Phone number" maxlength="10" minlength="10" value="{{$auth_required==true?'':'0000000000'}}">
						<div id="error-phone" class="text-red-600 form__input-error scan-field-error w-5/6 text-theme-6 mt-0"></div>
					</div>

					<div class="col-xs-12 form-div otp-div" style="display: none;">
						<input class="form-control form__input" type="tel" name="otp" id="otp" placeholder="Enter OTP" maxlength="10" minlength="10">
						<div id="error-otp" class="text-red-600 form__input-error scan-field-error w-5/6 text-theme-6 mt-0"></div>
					</div>

					<div class="col-xs-12 form-div secret-code" style="display: none;">
						<p class="otp-verified-message scan-otp-success" style="display:none;">
							OTP verified successfully
						</p>
						<input class="form-control form__input" type="text" name="secret-code" id="secret-code" placeholder="Enter Secret Code" maxlength="10" minlength="10">
						<input type="hidden" type="text" id="token" name="token" value="">
						<div id="error-secret-code" class="text-red-600 form__input-error scan-field-error w-5/6 text-theme-6 mt-2"></div>
					</div>

					<div class="col-xs-12 info-div text-black" style="display: none;">
					</div>
				</div>

				<div class="row form-div">
					<button class="btn contact-btn" id="btn-get-otp" style="opacity:{{$auth_required==true?'':'0'}};">
						Continue
					</button>

					<button class="btn contact-btn" id="btn-submit-otp" style="display: none;">
						Verify OTP
					</button>
				</div>

				<div class="row secret-div" style="display:none">
					<button class="btn secret-btn" id="btn-verify-secret_code">
						Verify secret code
					</button>
				</div>

				<div class="scan-minimal-hint">
					Your location may be used to verify product journey and detect counterfeit activity.
				</div>

			</div>

			{{-- <x-notification></x-notification> --}}
			<x-image-preview></x-image-preview>
			<x-offer-preview></x-offer-preview>
			<x-redeem-reward></x-redeem-reward>
			<x-reward-address></x-reward-address>
			<x-report-product></x-report-product>
		</div>

	</div>
</div>

@endsection

@section('script')

<script type="text/javascript">
	var lat = 0
	var long = 0
	var global_token = ''
	let otpVerified = 0;

	function assignPosition(position) {
		lat = position.coords.latitude;
		long = position.coords.longitude;
	}

	function showError(error) {
		console.log("Error getting location:", error.message);
	}

	function getLocation() {
		if (navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(assignPosition, showError);
		} else {
			alert("Geolocation is not supported by this browser.");
		}
	}

	getLocation();

	// ── Manual Modal Helpers (Bootstrap JS not available) ────────
	function showModal(modalId) {
		var modal = document.getElementById(modalId);
		if (!modal) return;

		var old = document.getElementById('pd-backdrop');
		if (old) old.remove();

		modal.style.display = 'block';
		modal.classList.add('in');
		modal.removeAttribute('aria-hidden');
		document.body.classList.add('modal-open');

		var backdrop = document.createElement('div');
		backdrop.className = 'modal-backdrop fade in';
		backdrop.id = 'pd-backdrop';
		document.body.appendChild(backdrop);

		backdrop.addEventListener('click', function() {
			hideModal(modalId);
		});
	}

	function hideModal(modalId) {
		var modal = document.getElementById(modalId);
		if (!modal) return;

		modal.style.display = 'none';
		modal.classList.remove('in');
		modal.setAttribute('aria-hidden', 'true');
		document.body.classList.remove('modal-open');
		document.body.style.paddingRight = '';

		var backdrop = document.getElementById('pd-backdrop');
		if (backdrop) backdrop.remove();
	}

	cash(function() {
		async function getOtp() {

			cash('.form__input').removeClass('border-red-600')
			cash('.form__input-error').html('')

			let country_code = cash('#country_code').val()
			let phone = cash('#phone').val()

			cash('#btn-get-otp').html('Please wait...')

			axios.post("{{ url('api/get-otp')}}", {
				country_code: country_code,
				phone: phone
			}).then(res => {

				cash('#btn-get-otp').hide();
				cash('#country_code').attr('disabled', true);
				cash('#phone').attr('disabled', true);

				cash('.otp-div').show();
				cash('#btn-submit-otp').show();

				console.log(res)
			}).catch(err => {
				cash('#btn-get-otp').html('Submit')

				if (err.response.data.errors) {
					for (const [key, val] of Object.entries(err.response.data.errors)) {
						cash(`#${key}`).addClass('border-red-600')
						cash(`#error-${key}`).html(val)
					}
				}
			})
		}

		async function submitOtp() {

			cash('.form__input').removeClass('border-red-600')
			cash('.form__input-error').html('')

			let country_code = cash('#country_code').val()
			let phone = cash('#phone').val()
			let otp = cash('#otp').val()

			cash('#btn-submit-otp').html('Please wait...')

			axios.post("{{ url('api/verify-otp')}}", {
				country_code: country_code,
				phone: phone,
				otp: otp,
			}).then(res => {

				cash('#btn-submit-otp').hide();
				cash('.form-div').hide();
				cash('.otp-div').hide();

				cash('.otp-verified-message').show();

				global_token = res.data.token;
				console.log('global_token set after OTP:', global_token);

				@if($secret_code_check_required)

				cash('.secret-div').show();
				cash('#btn-verify-secret_code').show();
				cash('.secret-code').show();

				cash('#token').val(res.data.token);

				@else

				proceedtoProductPage(res.data.token);

				@endif

			}).catch(err => {

				cash('#btn-submit-otp').show().html('Submit OTP');

				if (err.response && err.response.data && err.response.data.errors) {
					for (const [key, val] of Object.entries(err.response.data.errors)) {
						cash(`#${key}`).addClass('border-red-600');
						cash(`#error-${key}`).html(val);
					}
				}
			});
		}

		cash('#btn-submit-otp').on('click', function() {
			submitOtp()
		})

		cash('#btn-get-otp').on('click', function() {
			@if($auth_required == true)
			getOtp()
			@else
			getProductWithoutAuth()
			@endif
		})

		@if($auth_required == false)
		cash(document).ready(function() {
			getProductWithoutAuth()
		});
		@endif

		async function getProductWithoutAuth() {

			cash('.form__input').removeClass('border-red-600')
			cash('.form__input-error').html('')

			let country_code = cash('#country_code').val()
			let phone = cash('#phone').val()

			cash('#btn-get-otp').html('Please wait...')

			axios.post("{{ url('api/without-auth')}}", {
				country_code: country_code,
				phone: phone
			}).then(res => {
				cash('#btn-get-otp').hide();

				global_token = res.data.token;
				console.log('global_token set after without-auth:', global_token);

				if (!empty($secret_code_check_required)) {
					verifysecretCode(res.data.token);
				} else {
					proceedtoProductPage2(res.data.token)
				}

			}).catch(err => {
				console.log(err)
				cash('#btn-get-otp').html('Submit')

				if (err?.response?.data?.errors) {
					for (const [key, val] of Object.entries(err.response.data.errors)) {
						cash(`#${key}`).addClass('border-red-600');
						cash(`#error-${key}`).html(val);
					}
				}
			})
		}

		cash(document).on('click', '.image-link', function(event) {
			event.preventDefault();
			var src = $(this).data('src')
			cash('.image-modal-img').attr('src', src);
		});

		cash(document).on('click', '.report-link', function(event) {
			event.preventDefault();
			var batch = $(this).data('batch')
			var product = $(this).data('product')
			cash('.report-modal-product').val(product);
			cash('.report-modal-batch').val(batch);
			cash('.report-modal-token').val(global_token);
		});

		async function report() {

			cash('#report-form').find('.form__input').removeClass('border-theme-6')
			cash('#report-form').find('.login__input-error').html('')

			var formData = new FormData(document.querySelector('#report-form'))

			cash('#btn-report').html('Please wait')
			cash('#btn-report').attr('disabled', 'true');

			axios.post("{{ url('/api/report')}}", formData).then(res => {
				cash('#btn-report').html('Submit')
				cash('#btn-report').removeAttr('disabled')
				$('#report-message').html(res.data.message)
				setTimeout(function() {
					hideModal('report-modal');
				}, 3000)
			}).catch(err => {
				cash('#btn-report').html('Submit')
				cash('#btn-report').removeAttr('disabled')

				if (err.response.data.errors) {
					for (const [key, val] of Object.entries(err.response.data.errors)) {
						cash(`#${key}`).addClass('border-theme-6')
						cash(`#error-${key}`).html(val)
					}
				}

				if (err.response.data.message) {
					$('#report-message').html(err.response.data.message)
				}
			})
		}

		cash('#report-form').on('submit', function(e) {
			e.preventDefault()
			report()
		})

		cash('#btn-verify-secret_code').on('click', function(e) {
			e.preventDefault();
			let token = cash('#token').val();
			verifysecretCode(token);
		});

		cash(document).on('click', '.redeem-points', function(event) {
			event.preventDefault();
			cash('.redeem-points').html('Please Wait');
			cash('.redeem-points').attr('disabled', 'true');
			cash('#redeem-message').html('');

			var coupon_code = cash('#coupon_code').val();
			var scan_id = cash('.redeem-points').data('scan');

			axios.post("{{ url('/api/redeem-points')}}", {
				coupon_code,
				scan_id,
				token: global_token
			}).then(res => {
				cash('.redeem-points').html('Claim Points')
				cash('.redeem-points').removeAttr('disabled')
				cash('#coupon_code').val('');
				cash('#redeem-message').html(res.data.message)

				if (res.data.balance) {
					cash('#wallet_balance').html(res.data.balance)
				}
			}).catch(err => {
				cash('.redeem-points').html('Claim Points')
				cash('.redeem-points').removeAttr('disabled')
				if (err.response.data.message) {
					cash('#redeem-message').html(err.response.data.message)
				}
			})
		});

		cash(document).on('click', '.redeem', function(event) {
			event.preventDefault();
			var points = $(this).data('points')
			var scheme = $(this).data('scheme')
			var brand = $(this).data('brand')
			cash('.reward-modal-points').val(points);
			cash('.reward-modal-scheme').val(scheme);
			cash('.reward-modal-brand').val(brand);
			cash('.reward-modal-token').val(global_token);
			cash('.address-modal-points').val(points);
			cash('.address-modal-scheme').val(scheme);
			cash('.address-modal-brand').val(brand);
			cash('.address-modal-token').val(global_token);
		});

		async function reward() {

			cash('#reward-form').find('.form__input').removeClass('border-theme-6')
			cash('#reward-form').find('.login__input-error').html('')

			var formData = new FormData(document.querySelector('#reward-form'))

			cash('#btn-reward').html('Please wait')
			cash('#btn-reward').attr('disabled', 'true');

			axios.post("{{ url('/api/redeem-rewards') }}", formData).then(res => {
				cash('#btn-reward').html('Submit')
				cash('#btn-reward').removeAttr('disabled')
				$('#reward-message').html(res.data.message)
				if (res.data.balance) {
					cash('#wallet_balance').html(res.data.balance)
				}
				setTimeout(function() {
					hideModal('reward-modal');
				}, 3000)
			}).catch(err => {
				cash('#btn-reward').html('Submit')
				cash('#btn-reward').removeAttr('disabled')

				if (err.response.data.errors) {
					for (const [key, val] of Object.entries(err.response.data.errors)) {
						cash(`#${key}`).addClass('border-theme-6')
						cash(`#error-${key}`).html(val)
					}
				}

				if (err.response.data.message) {
					$('#reward-message').html(err.response.data.message)
				}
			})
		}

		cash('#reward-form').on('submit', function(e) {
			e.preventDefault()
			reward()
		})

		cash(document).on('click', '#redeem-menu', function(event) {
			event.preventDefault();
			cash('.redeem-div').show();
			cash('.claim-div').hide();
		});

		cash(document).on('click', '#claim-menu', function(event) {
			event.preventDefault();
			cash('.claim-div').show();
			cash('.redeem-div').hide();
		});

		async function address() {

			cash('#address-form').find('.form__input').removeClass('border-theme-6')
			cash('#address-form').find('.login__input-error').html('')

			var formData = new FormData(document.querySelector('#address-form'))

			cash('#btn-address').html('Please wait')
			cash('#btn-address').attr('disabled', 'true');

			axios.post("{{ url('/api/order-product') }}", formData).then(res => {
				cash('#btn-address').html('Submit')
				cash('#btn-address').removeAttr('disabled')
				$('#address-message').html(res.data.message)
				if (res.data.balance) {
					cash('#wallet_balance').html(res.data.balance)
				}
				setTimeout(function() {
					hideModal('address-modal');
				}, 3000)
			}).catch(err => {
				cash('#btn-address').html('Submit')
				cash('#btn-address').removeAttr('disabled')

				if (err.response.data.errors) {
					for (const [key, val] of Object.entries(err.response.data.errors)) {
						cash(`#${key}`).addClass('border-theme-6')
						cash(`#error-${key}`).html(val)
					}
				}

				if (err.response.data.message) {
					$('#address-message').html(err.response.data.message)
				}
			})
		}

		cash('#address-form').on('submit', function(e) {
			e.preventDefault()
			address()
		})

		// ── second param removed to avoid shadowing outer global_token ──
		async function verifysecretCode(token) {
			let secret_code = cash('#secret-code').val()
			let code = '{{$code}}';
			axios.post("{{ url('api/verify-secret-code') }}", {
				code: code,
				secret_code: secret_code
			}).then(res => {
				cash('.secret-code').hide();
				cash('.secret-div').hide();
				global_token = token;
				console.log('global_token set after secret code:', global_token);
				proceedtoProductPage(token);

			}).catch(err => {
				if (err.response.data.errors) {
					for (const [key, val] of Object.entries(err.response.data.errors)) {
						cash(`#${key}`).addClass('border-red-600')
						cash(`#error-${key}`).html(val)
					}
				}
			})
		}

		// ── second param removed to avoid shadowing outer global_token ──
		async function proceedtoProductPage(token) {
			global_token = token;
			console.log('global_token set in proceedtoProductPage:', global_token);

			axios.post("{{ url('api/p/'.$code) }}", {
				token,
				location: {
					lat,
					long
				}
			}).then(res => {
				console.log(res)
				cash('.info-div').show()
				cash('.form-div').hide()
				cash('.scan-minimal-icon').hide()
				cash('.scan-minimal-sub').hide()
				cash('.scan-minimal-hint').hide()
				cash('.scan-eyebrow').hide()
				cash('.scan-minimal').css({
					'align-items': 'flex-start',
					'padding-top': '40px'
				})
				cash('.scan-minimal-box').css('max-width', '600px')
				cash('.info-div').html(res.data.view)
				cash('.text-bg').text("")
				pdIdx = 0;

				if (res.data.product.applied_offer) {
					cash('#offer-modal-btn').trigger('click');
					cash('#offer-modal-title').html(res.data.product.applied_offer.title);
					cash('#offer-modal-description').html(res.data.product.applied_offer.description);
				}

			}).catch(err => {
				alert(err.response.data.message)
				window.location.reload()
			})
		}

		// ── second param removed to avoid shadowing outer global_token ──
		async function proceedtoProductPage2(token) {
			global_token = token;
			console.log('global_token set in proceedtoProductPage2:', global_token);

			axios.post("{{ url('api/p/'.$code)}}", {
				token,
				location: {
					lat,
					long
				}
			}).then(res => {
				cash('.info-div').show()
				cash('.scan-minimal-icon').hide()
				cash('.scan-minimal-sub').hide()
				cash('.scan-minimal-hint').hide()
				cash('.scan-eyebrow').hide()
				cash('.scan-minimal').css({
					'align-items': 'flex-start',
					'padding-top': '40px'
				})
				cash('.scan-minimal-box').css('max-width', '600px')
				cash('.info-div').html(res.data.view)
				cash('.text-bg').text("")
				pdIdx = 0;

				if (res.data.product.applied_offer) {
					cash('#offer-modal-btn').trigger('click');
					cash('#offer-modal-title').html(res.data.product.applied_offer.title);
					cash('#offer-modal-description').html(res.data.product.applied_offer.description);
				}
			}).catch(err => {
				alert(err.response.data.message)
				window.location.reload()
			})
		}

		// ── Tab delegation ──────────────────────────────────────────
		cash(document).on('click', '[data-pd-tab]', function() {
			var tabId = cash(this).data('pd-tab');
			var root = document.getElementById('pd-page-root');
			if (!root) return;

			cash(root).find('.pd-tab-link').removeClass('pd-on');
			cash(root).find('.pd-tab-panel').removeClass('pd-on');

			cash(this).addClass('pd-on');
			cash('#pd-tab-' + tabId).addClass('pd-on');
		});

		// ── Report button ───────────────────────────────────────────
		cash(document).on('click', '.pd-report-btn', function(e) {
			e.preventDefault();
			e.stopPropagation();
			var product = cash(this).data('product');
			var batch = cash(this).data('batch');
			console.log('product:', product, 'batch:', batch, 'token:', global_token);
			cash('.report-modal-product').val(product);
			cash('.report-modal-batch').val(batch);
			cash('.report-modal-token').val(global_token);
			showModal('report-modal');
		});

		// ── Claim Reward button ─────────────────────────────────────
		cash(document).on('click', '.pd-claim-btn', function(e) {
			e.preventDefault();
			e.stopPropagation();
			cash('.reward-modal-token').val(global_token);
			showModal('reward-modal');
		});

		// ── Dismiss modal buttons ───────────────────────────────────
		cash(document).on('click', '.dismiss-modal, [data-dismiss="modal"]', function(e) {
			e.preventDefault();
			e.stopPropagation();
			var modalEl = cash(this).closest('.modal');
			if (modalEl.length) hideModal(modalEl.attr('id'));
		});

		// ── Carousel ────────────────────────────────────────────────
		var pdIdx = 0;

		window.pdCarGo = function(n) {
			var slides = document.querySelectorAll('.pd-slide');
			var dots = document.querySelectorAll('.pd-car-dot');
			if (!slides.length) return;

			slides[pdIdx].classList.remove('pd-on');
			if (dots[pdIdx]) dots[pdIdx].classList.remove('pd-on');

			pdIdx = ((n % slides.length) + slides.length) % slides.length;

			slides[pdIdx].classList.add('pd-on');
			if (dots[pdIdx]) dots[pdIdx].classList.add('pd-on');
		};

		window.pdCarMove = function(dir) {
			pdCarGo(pdIdx + dir);
		};

	})
</script>
@endsection