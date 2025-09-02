@extends('vendor.layout.' . $layout)

@section('subhead')
<title>{{__('Supply Chain Users')}}</title>
@endsection

@section('subcontent')
<div class="intro-y flex items-center mt-8">
	<h2 class="text-lg font-medium mr-auto">{{__('Add New User')}}</h2>
</div>
<div class="grid grid-cols-12 gap-6 mt-5">
	<div class="intro-y col-span-12 lg:col-span-12">
		<form id="add-form">
			@csrf
			<div class="intro-y box">
				<div class="flex flex-col sm:flex-row items-center px-7 py-5 border-b border-gray-200 dark:border-dark-5">
					<h2 class="font-medium text-base mr-auto">{{__('common.basic_details')}}</h2>
				</div>
				<div class="p-5">

					<div class="grid grid-cols-12">

						<div class="input-form col-span-12 lg:col-span-6 px-2 py-1">
							<label for="full_name" class="form-label w-full flex flex-col sm:flex-row required">
								{{__('common.full_name')}}
							</label>
							<input id="full_name" type="text" name="full_name" class="form-control form__input" placeholder="{{__('common.enter')}} {{__('common.full_name')}}" minlength="2">
							<div id="error-full_name" class="login__input-error w-5/6 text-theme-6"></div>
						</div>

						<div class="input-form col-span-12 lg:col-span-6 px-2 py-1">
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
							<label for="email" class="form-label w-full flex flex-col sm:flex-row required">
								{{__('common.email')}}
							</label>
							<input id="email" type="text" name="email" class="form-control form__input" placeholder="{{__('common.enter')}} {{__('common.email')}}">
							<div id="error-email" class="login__input-error w-5/6 text-theme-6"></div>
						</div>

						<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-2">
							<label for="address" class="form-label w-full flex flex-col sm:flex-row">
								Address
							</label>
							<input id="address" type="text" name="address" class="form-control form__input" placeholder="Enter address">
							<div id="error-address" class="login__input-error w-5/6 text-theme-6"></div>
						</div>
					</div>
				</div>
			</div>

			<div class="intro-y box mt-5">
				<div class="flex flex-col sm:flex-row items-center px-7 py-5 border-b border-gray-200 dark:border-dark-5">
					<h2 class="font-medium text-base mr-auto">{{__('user.access_controls')}}</h2>
				</div>
				<div class="p-5">
					<div class="grid grid-cols-12">

						<div class="input-form col-span-12 lg:col-span-6 px-2 py-1">
							<label for="role" class="form-label w-full flex flex-col sm:flex-row required">
								{{__('common.role')}}
							</label>
							<select id="role" name="role" class="form-select form__input">
								<option value="">{{__('common.please_select')}}</option>
								@foreach ($roles as $role)
								<option value="{{$role->name}}">{{__($role->name)}}</option>
								@endforeach
							</select>
							<div id="error-role" class="login__input-error w-auto text-theme-6"></div>
						</div>

						<div class="input-form col-span-12 lg:col-span-6 px-2 py-1">
							<label for="parent_user" class="form-label w-full flex flex-col sm:flex-row required">
								{{__('Parent User')}}
							</label>
							<select id="parent_user" name="parent_user" class="form-select form__input">
								<option value="">{{__('common.please_select')}}</option>
							</select>
							<div id="error-parent_user" class="login__input-error w-auto text-theme-6"></div>
						</div>

						<div class="input-form col-span-12 lg:col-span-6 px-2 py-1">
							<label for="user_status" class="form-label w-full flex flex-col sm:flex-row">
								Active Status
							</label>
							<select id="user_status" name="user_status" class="form-select form__input">
								<option value="1">{{__('common.yes')}}</option>
								<option value="0">{{__('common.no')}}</option>
							</select>
						</div>
					</div>
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


			axios.post('{{ url('/vendor/supply-chain-users/create') }}', formData).then(res => {
				showNotification('success','{{__('common.success')}} !',res.data.message)
				setTimeout(()=>{
					window.location.href = '{{ url('/vendor/supply-chain-users') }}'
				},2000)

			}).catch(err => {
				showNotification('error','{{__('common.error')}} !',err.response.data.message)
				cash('#btn-add').html('{{__('common.submit')}}')   
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
			e.preventDefault();
			add();
		})

		cash('#role').on('change', function(e) {
			e.preventDefault();
			fetchUsers();
		})

		async function fetchUsers(){
			var role = cash('#role').val()

			if(role){
				axios.get(`{{ url('/vendor/get-supply-chain-users') }}/${role}`).then(res => {
					cash('#parent_user').html(res.data.users)
				}).catch(err => {
					console.log(err.response.data.message)
				})
			}else{
				cash('#parent_user').html('')
			}
		}
	})
</script>
@endsection
