@extends('vendor.layout.' . $layout)

@section('subhead')
<title>{{__('user.update_user')}}</title>
@endsection

@section('subcontent')
<div class="intro-y flex items-center mt-8">
	<h2 class="text-lg font-medium mr-auto">{{__('user.update_user')}}</h2>
</div>
<div class="grid grid-cols-12 gap-6 mt-5">
	<div class="intro-y col-span-12 lg:col-span-12">
		<form id="update-form">
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
							<input id="full_name" type="text" name="full_name" value="{{$user->name}}" class="form-control form__input" placeholder="{{__('common.enter')}} {{__('common.name')}}" minlength="2">
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
									<option value="{{$country->phonecode}}" {{$country->phonecode==$user->phone_code?'selected':''}}>+{{$country->phonecode}}</option>
									@endforeach
									@else
									<option value="91">91</option>
									@endif
								</select>

								<input id="mobile" type="text" name="mobile" value="{{$user->phone}}" class="form-control form__input col-span-10" placeholder="{{__('common.enter')}}  {{__('common.mobile')}}">
								<div id="error-mobile" class="login__input-error text-theme-6 col-span-12"></div>
							</div>
						</div>

						<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-2">
							<label for="email" class="form-label w-full flex flex-col sm:flex-row required">
								{{__('common.email')}}
							</label>
							<input id="email" type="text" name="email" value="{{$user->email}}" class="form-control form__input" placeholder="{{__('common.enter')}} {{__('common.email')}}">
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
								<option value="{{$role->name}}" {{$role->name==$user->who_you_are?'selected':''}}>{{__($role->name)}}</option>
								@endforeach
							</select>
							<div id="error-role" class="login__input-error w-auto text-theme-6"></div>
						</div>

						<div class="input-form col-span-12 lg:col-span-6 px-2 py-1" style="display:none" id="brand">
							<label for="brand" class="form-label w-full flex flex-col sm:flex-row required">
								{{__('common.brand')}}
							</label>
							<select id="brand" name="brand" class="form-select form__input">
								<option value="">{{__('common.please_select')}}</option>
								@foreach ($brands as $item)
								<option value="{{$item}}" {{$user->brand==$item?'selected':''}}>{{__($item)}}</option>
								@endforeach
							</select>
							<div id="error-brand" class="login__input-error w-auto text-theme-6"></div>
						</div>

						<div class="input-form col-span-12 lg:col-span-6 px-2 py-1">
							<label for="allow_login" class="form-label w-full flex flex-col sm:flex-row">
								Active Status/{{__('common.allow_login')}}
							</label>
							<select id="allow_login" name="allow_login" class="form-select form__input">
								<option value="1" {{$user->status=='1'?'selected':''}}>{{__('common.yes')}}</option>
								<option value="0" {{$user->status=='0'?'selected':''}}>{{__('common.no')}}</option>
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
						@php
						$i=1;
						@endphp
						@foreach ($modules as $key=>$module)
						@if ($module->slug!='profile' && $module->slug!='users')
						<div class="input-form col-span-3 px-2 py-1">
							<label>{{$i}}. {{__($module->name)}}</label>
						</div>
						<div class="input-form col-span-9 px-2 py-1">
							<div class="flex flex-col sm:flex-row">
								<div class="form-check mr-5">
									<input id="{{$module->slug}}-view" class="form-check-input" type="checkbox" name="view[]" value="{{$module->id}}" {{inAllowedPermissions($user->id,$module->id,'view')==true?'checked':''}}>
									<label class="form-check-label" for="{{$module->slug}}-view">{{__('common.view')}}</label>
								</div>

								@if ($module->slug!='dashboard')
								<div class="form-check mr-2 mt-2 sm:mt-0">
									<input id="{{$module->slug}}-modify" class="form-check-input" type="checkbox" name="modify[]" value="{{$module->id}}" {{inAllowedPermissions($user->id,$module->id,'modify')==true?'checked':''}}>
									<label class="form-check-label" for="{{$module->slug}}-modify">{{__('common.modify')}}</label>
								</div>
								@endif
							</div>
						</div>
						@php
						$i++;
						@endphp
						@endif
						@endforeach

						<div class="col-span-12 mt-4 px-2">
							{{__('user.note')}}
						</div>
					</div>
				</div>
			</div>

			@if (hasRoutePermission('vendor-update-user',Auth::id()))
			<div class="grid grid-cols-12 mt-4">
				<div class="input-form col-span-12 lg:col-span-12 py-1 mt-3">
					<button type="submit" id="btn-update" class="btn btn-primary w-full xl:w-32 xl:mr-3 align-top">{{__('common.submit')}}</button>
				</div>
			</div>
			@endif

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

			axios.post('{{ url('/vendor/users/'.encrypt($user->id).'/edit') }}', formData).then(res => {
				cash('#btn-update').attr('disabled', 'true');
				showNotification('success','{{__('common.success')}} !',res.data.message)
				setTimeout(()=>{
					window.location.reload();
				},1000)

			}).catch(err => {
				showNotification('error','{{__('common.error')}} !',err.response.data.message)
				cash('#btn-update').html('{{__('common.submit')}}')  
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
			e.preventDefault();
			add();
		})

		cash('#role').on('change', function(event) {
			event.preventDefault();
			return brandAction()
		});

		cash(document).ready(function($) {
			return brandAction()			
		});

		async function brandAction(){
			var value = cash('#role').val()
			if(value=='Brand User'){
				cash('#brand').show();
				cash('#scan-history-view').prop('checked', true);

			}else{
				cash('#scan-history-view').prop('checked', false);
				cash('#brand').hide()
			}
		}
	})
</script>
@endsection
