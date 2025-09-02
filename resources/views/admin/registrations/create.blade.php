@extends('admin.layout.' . $layout)

@section('subhead')
<title>Registrations - TRACESCI</title>
@endsection

@section('subcontent')
<div class="intro-y flex items-center mt-8">
	<h2 class="text-lg font-medium mr-auto">Register New</h2>
</div>
<div class="grid grid-cols-12 gap-6 mt-5">
	<div class="intro-y col-span-12 lg:col-span-12">
		<form id="add-form">
			@csrf
			<div class="intro-y box">
				<div class="flex flex-col sm:flex-row items-center px-7 py-5 border-b border-gray-200 dark:border-dark-5">
					<h2 class="font-medium text-base mr-auto">Basic details</h2>
				</div>
				<div class="p-5">

					<div class="grid grid-cols-12">

						<div class="input-form col-span-12 lg:col-span-6 px-2 py-1">
							<label for="name" class="form-label w-full flex flex-col sm:flex-row">
								Full name
							</label>
							<input id="name" type="text" name="name" class="form-control form__input" placeholder="Enter full name" minlength="2">
							<div id="error-name" class="login__input-error w-5/6 text-theme-6"></div>
						</div>

						<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 ">
							<label for="mobile" class="form-label w-full flex flex-col sm:flex-row required">
								{{__('common.mobile')}}
							</label>
							<div class="grid grid-cols-12">
								<select name="phone_code" class="form-control col-span-2" id="phone_code">
									@if (count(countries())>0)
									@foreach (countries() as $country)
									<option value="{{$country->phonecode}}" {{$country->phonecode=='91'?'selected':''}}>+{{$country->phonecode}}</option>
									@endforeach
									@else
									<option value="91">91</option>
									@endif
								</select>

								<input id="mobile" type="text" name="mobile" class="form-control form__input col-span-10" placeholder="{{__('common.enter')}}  {{__('common.mobile')}}">
								<div id="error-mobile" class="login__input-error text-theme-6 col-span-12"></div>
							</div>
						</div>

						<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-2">
							<label for="email" class="form-label w-full flex flex-col sm:flex-row">
								Email
							</label>
							<input id="email" type="text" name="email" class="form-control form__input" placeholder="Enter email">
							<div id="error-email" class="login__input-error w-5/6 text-theme-6"></div>
						</div>

						<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-2">
							<label for="company_name" class="form-label w-full flex flex-col sm:flex-row">
								Company name
							</label>
							<input id="company_name" type="text" name="company_name" class="form-control form__input" placeholder="Enter company name">
							<div id="error-company_name" class="login__input-error w-5/6 text-theme-6"></div>
						</div>

						<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-2">
							<label for="company_address" class="form-label w-full flex flex-col sm:flex-row">
								Company address
							</label>
							<input id="company_address" type="text" name="company_address" class="form-control form__input" placeholder="Enter company address">
							<div id="error-company_address" class="login__input-error w-5/6 text-theme-6"></div>
						</div>

						<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-2">
							<label for="city" class="form-label w-full flex flex-col sm:flex-row">
								City
							</label>
							<input id="city" type="text" name="city" class="form-control form__input" placeholder="Enter city name">
							<div id="error-city" class="login__input-error w-5/6 text-theme-6"></div>
						</div>

						<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-2">
							<label for="country" class="form-label w-full flex flex-col sm:flex-row">
								Country
							</label>
							<input id="country" type="text" name="country" class="form-control form__input" placeholder="Enter country name">
							<div id="error-country" class="login__input-error w-5/6 text-theme-6"></div>
						</div>

						<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-2">
							<label for="tax_registration_number" class="form-label w-full flex flex-col sm:flex-row">
								Tax registration number
							</label>
							<input id="tax_registration_number" type="text" name="tax_registration_number" class="form-control form__input" placeholder="Enter tax registration number">
							<div id="error-tax_registration_number" class="login__input-error w-5/6 text-theme-6"></div>
						</div>						
					</div>
				</div>
			</div>
			<div class="intro-y box mt-5">
				<div class="flex flex-col sm:flex-row items-center px-7 py-5 border-b border-gray-200 dark:border-dark-5">
					<h2 class="font-medium text-base mr-auto">Subscription</h2>
				</div>
				<div class="p-5">

					<div class="grid grid-cols-12">

						<div class="input-form col-span-12 lg:col-span-6 px-2 py-1">
							<label for="default_plan" class="form-label w-full flex flex-col sm:flex-row">
								Select default plan for this user
							</label>
							<select id="default_plan" name="default_plan" class="form-control form__input">
								@foreach ($plans as $plan)
								<option value="{{$plan->id}}">{{$plan->title}}</option>
								@endforeach
							</select>
							<div id="error-default_plan" class="login__input-error w-5/6 text-theme-6"></div>
						</div>

					</div>

				</div>
			</div>
			<div class="intro-y box mt-5">
				<div class="flex flex-col sm:flex-row items-center px-7 py-5 border-b border-gray-200 dark:border-dark-5">
					<h2 class="font-medium text-base mr-auto">Upload documents</h2>
				</div>
				<div class="p-5">

					<div class="grid grid-cols-12">

						<div class="input-form col-span-12 lg:col-span-6 px-2 py-1">
							<label for="self_kyc" class="form-label w-full flex flex-col sm:flex-row">
								Self KYC
							</label>
							<input id="self_kyc" type="file" name="self_kyc" class="form-control form__input">
							<div id="error-self_kyc" class="login__input-error w-5/6 text-theme-6"></div>
						</div>

						<div class="input-form col-span-12 lg:col-span-6 px-2 py-1">
							<label for="company_roc" class="form-label w-full flex flex-col sm:flex-row">
								Company ROC
							</label>
							<input id="company_roc" type="file" name="company_roc" class="form-control form__input">
							<div id="error-company_roc" class="login__input-error w-5/6 text-theme-6"></div>
						</div>

						<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-2">
							<label for="company_gst" class="form-label w-full flex flex-col sm:flex-row">
								Company GST certificate
							</label>
							<input id="company_gst" type="file" name="company_gst" class="form-control form__input">
							<div id="error-company_gst" class="login__input-error w-5/6 text-theme-6"></div>
						</div>

						<div class="input-form col-span-12 lg:col-span-12 px-2 py-1 mt-4">

							<div class="flex items-center mr-auto">
								<input id="default_approve" type="checkbox" class="form-check-input border mr-2" name="default_approve">
								<label class="cursor-pointer select-none" for="default_approve">Approve all documents for this user</label>
							</div>

						</div>
						
					</div>

				</div>
			</div>

			<div class="intro-y box mt-5">
				<div class="p-5">
					<div class="grid grid-cols-12">
						<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-2">
							<label for="allow_login" class="form-label w-full flex flex-col sm:flex-row">
								{{__('common.allow_login')}}
							</label>
							<select id="allow_login" name="allow_login" class="form-select form__input">
								<option value="1">{{__('common.yes')}}</option>
								<option value="0">{{__('common.no')}}</option>
							</select>
						</div>

					</div>
					<p class="m-2">{!!__('registration.always_allow')!!}
					</p>
				</div>
			</div>

			<div class="grid grid-cols-12 mt-4">
				<div class="input-form col-span-12 lg:col-span-12 py-1 mt-3">
					<button type="submit" id="btn-add" class="btn btn-primary w-full xl:w-32 xl:mr-3 align-top">{{__('common.submit')}}</button>
				</div>
			</div>
		</form>
	</div>
	<x-notification></x-notification>
</div> 
@endsection

@section('script')
<script>
	cash(function () {
		async function add() {

			cash('#add-form').find('.form__input').removeClass('border-theme-6')
			cash('#add-form').find('.login__input-error').html('')

			var formData = new FormData(document.querySelector('#add-form'))

			cash('#btn-add').html('<i data-loading-icon="oval" data-color="white" class="w-5 h-5 mx-auto"></i>').svgLoader()
			cash('#btn-add').attr('disabled', 'true');

			axios.post('{{ url('/admin/registrations/create') }}', formData).then(res => {
				showNotification('success','Success !',res.data.message)
				setTimeout(()=>{
					window.location.href = '{{ url('/admin/registrations') }}'
				},2000)

			}).catch(err => {
				showNotification('error','Error !',err.response.data.message)
				cash('#btn-add').html('Register Now')                   
				cash('#btn-add').removeAttr('disabled');
				if (err.response.data.errors) {
					for (const [key, val] of Object.entries(err.response.data.errors)){
						cash(`#${key}`).addClass('border-theme-6')
						cash(`#error-${key}`).html(val)
					}
				}

			})
		}

		cash('#add-form').on('submit', function(e) {
			e.preventDefault()
			add()			
		})

	})
</script>
@endsection
