@extends('web.layouts.app')

@section('title',$brand)

@section('content')
<div class="main-slider" style="height: 150px; background: transparent linear-gradient( 
	45deg , #700877 0%, #ff2759 100%, #ff2759 100%) repeat scroll 0 0;">
</div>
<div class="text-bg" style="font-size: 36px;
color: rgb(209, 86, 136);
padding: 6px 18px 7px;
text-transform: uppercase;
transition: none 0s ease 0s;
line-height: 45px;
border-width: 0px;
margin: 0px auto;
text-align: center;
letter-spacing: 2px;
font-weight: 900;
margin-top: 20px;">
	Details just a Few step away
</div>
<div id="main" class="wrapper">
	<section class="bg-white border-b mx-auto py-4">
		<div class="container mx-auto flex flex-wrap mb-4">
			<div class="row" style="margin-top: 50px; padding: 0 15px;">
				<div class="col-xs-4 col-sm-2 form-div">
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

				<div class="col-xs-8 col-sm-10 form-div" style="opacity:{{$auth_required==true?'':'0'}};">
					<input class="form-control form__input" type="tel" name="phone" id="phone" placeholder="Enter phone number" maxlength="10" minlength="10" value="{{$auth_required==true?'':'0000000000'}}">
					<div id="error-phone" class="text-red-600 form__input-error w-5/6 text-theme-6 mt-0"></div>
				</div>

				<div class="col-xs-12 px-2 mt-4 form-div otp-div" style="display: none; margin-top: 25px;">
					<input class="form-control form__input" type="tel" name="otp" id="otp" placeholder="Enter otp" maxlength="10" minlength="10">
					<div id="error-otp" class="text-red-600 form__input-error w-5/6 text-theme-6 mt-0"></div>
				</div>
				<div class="col-xs-12 px-2 mt-4 form-div secret-code" style="display: none; margin-top: 25px;">
					<p class="otp-verified-message" style="color: #155724; background-color: #d4edda; padding: 10px; border-radius: 5px;display:none;">
						Otp Verified Successfully
					</p>
					<input class="form-control form__input" type="text" name="secret-code" id="secret-code" placeholder="Enter Secret Code" maxlength="10" minlength="10">
					<input type="hidden" type="text" id="token" name="token" value="">
					<div id="error-secret-code" class="text-red-600 form__input-error w-5/6 text-theme-6 mt-2" style="color:red"></div>
				</div>

				<div class="col-xs-12 px-2 mt-4 info-div text-black" style="display: none; margin:30px 0; padding:10px;">
				</div>
			</div>

			<div class="row form-div" style="margin-top: 50px;">
				<div class="col-sm-12 px-3 text-center ">
					<button class="btn btn-primary contact-btn" id="btn-get-otp" style="opacity:{{$auth_required==true?'':'0'}};">
						Submit
					</button>

					<button class="btn btn-primary contact-btn" id="btn-submit-otp" style="display: none;">
						Submit otp
					</button>
				</div>
			</div>
			<div class="row secret-div" style="margin-top: 50px;display:none">
				<div class="col-sm-12 px-3 text-center ">
					<button class="btn btn-primary secret-btn" id="btn-verify-secret_code">
						Verify Secret Code
					</button>
				</div>
			</div>
		</div>
		{{-- <x-notification></x-notification> --}}
		<x-image-preview></x-image-preview>
		<x-offer-preview></x-offer-preview>
		<x-redeem-reward></x-redeem-reward>
		<x-reward-address></x-reward-address>
		<x-report-product></x-report-product>
	</section>
</div>

@endsection

@section('script')

<script type="text/javascript">
	var lat = 0
	var long = 0
	var global_token = ''
	let otpVerified = 0;

	function assignPosition(position) {
		lat = position.coords.latitude
		long = position.coords.longitude
	}

	cash(function() {
		async function getOtp() {

			cash('.form__input').removeClass('border-red-600')
			cash('.form__input-error').html('')

			let country_code = cash('#country_code').val()
			let phone = cash('#phone').val()

			cash('#btn-get-otp').html('Please wait...')

			// await helper.delay(500)

			axios.post("{{ url('api/get-otp')}}", {
				country_code: country_code,
				phone: phone
			}).then(res => {
				// showNotification('success','Success !',res.data.message)
				// setTimeout(()=>{
				// 	window.location.reload()
				// },2000)

				cash('#btn-get-otp').hide();
				cash('#country_code').attr('disabled', true);
				cash('#phone').attr('disabled', true);

				cash('.otp-div').show();
				cash('#btn-submit-otp').show();

				console.log(res)
			}).catch(err => {
				// showNotification('error','Error !',err.response.data.message)
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

			// await helper.delay(500)
			axios.post("{{ url('api/verify-otp')}}", {
				country_code: country_code,
				phone: phone,
				otp: otp,
			}).then(res => {

				cash('#btn-submit-otp').hide();
				cash('.form-div').hide();
				cash('.otp-div').hide();

				cash('.otp-verified-message').show();

				@if($secret_code_check_required)

				cash('.secret-div').show();
				cash('#btn-verify-secret_code').show();
				cash('.secret-code').show();

				cash('#token').val(res.data.token);

				@else

				proceedtoProductPage(res.data.token, res.data.token);

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
				if ($secret_code_check_required) {
					verifysecretCode(res.data.token, res.data.token);

				} else {
					proceedtoProductPage2(res.data.token, res.data.token)
				}


			}).catch(err => {
				console.log(err)
				cash('#btn-get-otp').html('Submit')

				if (err.response.data.errors) {
					for (const [key, val] of Object.entries(err.response.data.errors)) {
						cash(`#${key}`).addClass('border-red-600')
						cash(`#error-${key}`).html(val)
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
					cash('.dismiss-modal').trigger('click')
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

			verifysecretCode(token, token);
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
					cash('.dismiss-modal').trigger('click')
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
					cash('.dismiss-modal').trigger('click')
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
		async function verifysecretCode(token, global_token) {
			let secret_code = cash('#secret-code').val()
			let code='{{$code}}';
			axios.post("{{ url('api/verify-secret-code') }}", {
				code: code,
				secret_code:secret_code
			}).then(res => {
				// showNotification('success','Success !',res.data.message)
				// setTimeout(()=>{
				// 	window.location.reload()
				// },2000)
				cash('.secret-code').hide();
				cash('.secret-div').hide();
				proceedtoProductPage(token, global_token);

			}).catch(err => {
				// showNotification('error','Error !',err.response.data.message)
				if (err.response.data.errors) {
					for (const [key, val] of Object.entries(err.response.data.errors)) {
						cash(`#${key}`).addClass('border-red-600')
						cash(`#error-${key}`).html(val)
					}
				}
			})
		}
		async function proceedtoProductPage(token, global_token) {
			axios.post("{{ url('api/p/'.$code) }}", {
				token,
				location: {
					lat,
					long
				}
			}).then(res => {
				console.log(res)
				// showNotification('success','Success !',res.data.message)
				cash('.info-div').show()
				cash('.form-div').hide()
				cash('.info-div').html(res.data.view)
				cash('.text-bg').text("Product Details")

				if (res.data.product.applied_offer) {
					cash('#offer-modal-btn').trigger('click');
					cash('#offer-modal-title').html(res.data.product.applied_offer.title);
					cash('#offer-modal-description').html(res.data.product.applied_offer.description);
				}

			}).catch(err => {
				console.log
				alert(err.response.data.message)
				window.location.reload()
			})
		}
		async function proceedtoProductPage2(token, global_token) {
			axios.post("{{ url('api/p/'.$code)}}", {
				token,
				location: {
					lat,
					long
				}
			}).then(res => {
				cash('.info-div').show()
				cash('.info-div').html(res.data.view)
				cash('.text-bg').text("Product Details")

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
	})
</script>
@endsection