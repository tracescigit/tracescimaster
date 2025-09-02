@extends('admin.layout.' . $layout)

@section('subhead')
<title>{{__('user.create_users')}} TRACESCI</title>
@endsection

@section('subcontent')
<div class="intro-y flex items-center mt-8">
	<h2 class="text-lg font-medium mr-auto">{{__('user.add_new_user')}}</h2>
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
							<label for="allow_login" class="form-label w-full flex flex-col sm:flex-row ">
								Active Status/{{__('common.allow_login')}}
							</label>
							<select id="allow_login" name="allow_login" class="form-select form__input">
								<option value="1">{{__('common.yes')}}</option>
								<option value="0">{{__('common.no')}}</option>
							</select>
						</div>
					</div>
				</div>
			</div>

			<div class="intro-y box mt-5">
				<div class="flex flex-col sm:flex-row items-center px-7 py-5 border-b border-gray-200 dark:border-dark-5">
					<h2 class="font-medium text-base mr-auto">{{__('user.permissions')}}</h2>
				</div>
				<div class="p-5">
					<div class="grid grid-cols-12">

						@foreach ($modules as $key=>$module)

						@if ($module->slug!='categories' && $module->slug!='profile' && $module->slug!='users')						
						<div class="input-form col-span-3 px-2 py-1">
							<label>{{$key+1}}. {{__($module->name)}}</label>
						</div>
						<div class="input-form col-span-9 px-2 py-1">
							<div class="flex flex-col sm:flex-row">
								<div class="form-check mr-5">
									<input id="{{$module->slug}}-view" class="form-check-input" type="checkbox" name="view[]" value="{{$module->id}}" {{$module->slug=='dashboard'?'checked':''}}>
									<label class="form-check-label" for="{{$module->slug}}-view">{{__('common.view')}}</label>
								</div>

								@if ($module->slug!='dashboard')
								<div class="form-check mr-2 mt-2 sm:mt-0">
									<input id="{{$module->slug}}-modify" class="form-check-input" type="checkbox" name="modify[]" value="{{$module->id}}">
									<label class="form-check-label" for="{{$module->slug}}-modify">{{__('common.modify')}}</label>
								</div>
								@endif
							</div>
						</div>
						@endif
						@endforeach

						<div class="col-span-12 mt-4 px-2">
							{{__('user.note')}}
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

			axios.post('{{ url('/admin/users/create') }}', formData).then(res => {
				
				showNotification('success','{{__('common.success')}} !',res.data.message)
				setTimeout(()=>{
					window.location.href = '{{ url('/admin/users') }}'
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
			e.preventDefault()
			add()
		})
	})

	cash('#role').on('change',function(){
		var role = cash('#role').val()
		
		if(role=="Province Governor" || role=="DGDA Inspector"){
			cash("#province-div").show();
		}else{
			cash("#province-div").hide();
		}
	});
</script>
@endsection
