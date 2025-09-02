@extends('admin.layout.' . $layout)

@section('subhead')
<title>Registration Approval - TRACESCI</title>
@endsection

@section('subcontent')
<div class="intro-y flex items-center mt-8">
	<h2 class="text-lg font-medium mr-auto">Registration Approval</h2>
</div>
<div class="grid grid-cols-12 gap-6 mt-5">
	<div class="intro-y col-span-12 lg:col-span-12">
		<form id="update-form">
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
							<input id="name" type="text" value="{{$user->name}}" name="name" class="form-control form__input" placeholder="Enter full name" minlength="2">
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
									<option value="{{$country->phonecode}}" {{$country->phonecode==$user->phone_code?'selected':''}}>+{{$country->phonecode}}</option>
									@endforeach
									@else
									<option value="91">91</option>
									@endif
								</select>

								<input id="mobile" type="text" name="mobile" class="form-control form__input col-span-10" value="{{$user->phone}}" placeholder="{{__('common.enter')}}  {{__('common.mobile')}}">
								<div id="error-mobile" class="login__input-error text-theme-6 col-span-12"></div>
							</div>
						</div>

						<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-2">
							<label for="email" class="form-label w-full flex flex-col sm:flex-row">
								Email
							</label>
							<input id="email" type="text" value="{{$user->email}}" name="email" class="form-control form__input" placeholder="Enter email">
							<div id="error-email" class="login__input-error w-5/6 text-theme-6"></div>
						</div>

						<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-2">
							<label for="company_name" class="form-label w-full flex flex-col sm:flex-row">
								Company name
							</label>
							<input id="company_name" type="text" value="{{$user->getCompany?$user->getCompany->name:''}}" name="company_name" class="form-control form__input" placeholder="Enter company name">
							<div id="error-company_name" class="login__input-error w-5/6 text-theme-6"></div>
						</div>

						<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-2">
							<label for="company_address" class="form-label w-full flex flex-col sm:flex-row">
								Company address
							</label>
							<input id="company_address" type="text" value="{{$user->getCompany?$user->getCompany->address:''}}"  name="company_address" class="form-control form__input" placeholder="Enter company address">
							<div id="error-company_address" class="login__input-error w-5/6 text-theme-6"></div>
						</div>


						<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-2">
							<label for="city" class="form-label w-full flex flex-col sm:flex-row">
								City
							</label>
							<input id="city" type="text" name="city" class="form-control form__input" placeholder="Enter city name" value="{{$user->getCompany?$user->getCompany->city:''}}">
							<div id="error-city" class="login__input-error w-5/6 text-theme-6"></div>
						</div>

						<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-2">
							<label for="country" class="form-label w-full flex flex-col sm:flex-row">
								Country
							</label>
							<input id="country" type="text" name="country" class="form-control form__input" placeholder="Enter country name" value="{{$user->getCompany?$user->getCompany->country:''}}">
							<div id="error-country" class="login__input-error w-5/6 text-theme-6"></div>
						</div>

						<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-2">
							<label for="tax_registration_number" class="form-label w-full flex flex-col sm:flex-row">
								Tax registration number
							</label>
							<input id="tax_registration_number" type="text" name="tax_registration_number" class="form-control form__input" placeholder="Enter tax registration number" value="{{$user->getCompany?$user->getCompany->gst:''}}">
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
								<option value="{{$plan->id}}" {{($user->getSubscription && $user->getSubscription->plan_id==$plan->id)?'selected':''}}>{{$plan->title}}</option>
								@endforeach
							</select>
							<div id="error-default_plan" class="login__input-error w-5/6 text-theme-6"></div>
						</div>

					</div>

				</div>
			</div>


			<div class="intro-y box mt-5">
				<div class="flex flex-col sm:flex-row items-center px-7 py-5 border-b border-gray-200 dark:border-dark-5">
					<h2 class="font-medium text-base mr-auto">User self KYC</h2>
				</div>
				<div class="p-5">

					<div class="grid grid-cols-12">

						<div class="input-form col-span-12 lg:col-span-12 px-2 py-1">
							<label for="self_kyc" class="form-label w-full flex flex-col sm:flex-row">
								Self KYC
							</label>
							<input id="self_kyc" type="file" name="self_kyc" class="form-control form__input">
							<div id="error-self_kyc" class="login__input-error w-5/6 text-theme-6"></div>
						</div>

						<div class="input-form col-span-12 lg:col-span-12 px-2 py-1 mt-2">							
							<div class="flex items-center mr-auto mb-4">

								@if (getDocument($user->id,'self_kyc'))
								<a href="{{asset(getDocument($user->id,'self_kyc')->doc_url)}}" download="">
									<i data-feather='download'></i> Uploaded file
								</a>
								@endif

								<span class="{{getDocument($user->id,'self_kyc')?'ml-auto':''}}">
									<input id="approve_self_kyc" type="checkbox" class="form-check-input border mr-2" name="approve_self_kyc" {{(getDocument($user->id,'self_kyc')&&getDocument($user->id,'self_kyc')->status=='1')?'checked':''}}>
									<label class="cursor-pointer select-none" for="approve_self_kyc">Approve self KYC</label>
								</span>

							</div>
						</div>

					</div>

				</div>
			</div>

			<div class="intro-y box mt-5">
				<div class="flex flex-col sm:flex-row items-center px-7 py-5 border-b border-gray-200 dark:border-dark-5">
					<h2 class="font-medium text-base mr-auto">Company ROC</h2>
				</div>
				<div class="p-5">

					<div class="grid grid-cols-12">

						<div class="input-form col-span-12 lg:col-span-12 px-2 py-1">
							<label for="company_roc" class="form-label w-full flex flex-col sm:flex-row">
								Company ROC
							</label>
							<input id="company_roc" type="file" name="company_roc" class="form-control form__input">
							<div id="error-company_roc" class="login__input-error w-5/6 text-theme-6"></div>
						</div>

						<div class="input-form col-span-12 lg:col-span-12 px-2 py-1 mt-2">							
							<div class="flex items-center mr-auto mb-4">

								@if (getDocument($user->id,'company_roc'))
								<a href="{{asset(getDocument($user->id,'company_roc')->doc_url)}}" download="">
									<i data-feather='download'></i> Uploaded file
								</a>
								@endif

								<span class="{{getDocument($user->id,'company_roc')?'ml-auto':''}}">
									<input id="approve_company_roc" type="checkbox" class="form-check-input border mr-2" name="approve_company_roc" {{(getDocument($user->id,'company_roc')&&getDocument($user->id,'company_roc')->status=='1')?'checked':''}}>
									<label class="cursor-pointer select-none" for="approve_company_roc">Approve Company ROC</label>
								</span>

							</div>
						</div>

					</div>

				</div>
			</div>

			<div class="intro-y box mt-5">
				<div class="flex flex-col sm:flex-row items-center px-7 py-5 border-b border-gray-200 dark:border-dark-5">
					<h2 class="font-medium text-base mr-auto">Company GST certificate</h2>
				</div>
				<div class="p-5">

					<div class="grid grid-cols-12">

						<div class="input-form col-span-12 lg:col-span-12 px-2 py-1">
							<label for="company_gst" class="form-label w-full flex flex-col sm:flex-row">
								Company GST certificate
							</label>
							<input id="company_gst" type="file" name="company_gst" class="form-control form__input">
							<div id="error-company_gst" class="login__input-error w-5/6 text-theme-6"></div>
						</div>

						<div class="input-form col-span-12 lg:col-span-12 px-2 py-1 mt-2">
							<div class="flex items-center mr-auto mb-4">

								@if (getDocument($user->id,'company_gst'))
								<a href="{{asset(getDocument($user->id,'company_gst')->doc_url)}}" download="">
									<i data-feather='download'></i> Uploaded file
								</a>
								@endif

								<span class="{{getDocument($user->id,'company_gst')?'ml-auto':''}}">
									<input id="approve_company_gst" type="checkbox" class="form-check-input border mr-2" name="approve_company_gst" {{(getDocument($user->id,'company_gst')&&getDocument($user->id,'company_gst')->status=='1')?'checked':''}}>
									<label class="cursor-pointer select-none" for="approve_company_gst">Approve Company GST certificate</label>
								</span>

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
								<option value="1" {{$user->status=='1'?'selected':''}}>{{__('common.yes')}}</option>
								<option value="0" {{$user->status=='0'?'selected':''}}>{{__('common.no')}}</option>
							</select>
						</div>

					</div>
					<p class="m-2">{!!__('registration.always_allow')!!}
					</p>
				</div>
			</div>


			<div class="grid grid-cols-12 mt-4">
				<div class="input-form col-span-12 lg:col-span-12 py-1 mt-3">
					<button type="submit" id="btn-update" class="btn btn-primary w-full xl:w-32 xl:mr-3 align-top">{{__('common.submit')}}</button>
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

			cash('#update-form').find('.form__input').removeClass('border-theme-6')
			cash('#update-form').find('.login__input-error').html('')

			var formData = new FormData(document.querySelector('#update-form'))

			cash('#btn-update').html('<i data-loading-icon="oval" data-color="white" class="w-5 h-5 mx-auto"></i>').svgLoader()
			cash('#btn-update').attr('disabled', 'true');

			axios.post('{{ url('/admin/registrations/'.encrypt($user->id).'/edit') }}', formData).then(res => {
				
				showNotification('success','Success !',res.data.message)
				setTimeout(()=>{
					window.location.reload();
				},1000)

			}).catch(err => {
				showNotification('error','Error !',err.response.data.message)
				cash('#btn-update').html('Update user')      
				cash('#btn-update').removeAttr('disabled');             

				if (err.response.data.errors) {
					for (const [key, val] of Object.entries(err.response.data.errors)){
						cash(`#${key}`).addClass('border-theme-6')
						cash(`#error-${key}`).html(val)
					}
				}

			})
		}

		cash('#update-form').on('submit', function(e) {
			e.preventDefault()
			add()
		})

	})
</script>
@endsection
