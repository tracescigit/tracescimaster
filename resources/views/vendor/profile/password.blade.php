@extends('vendor.layout.' . $layout)

@section('subhead')
<title>Profile - TRACESCI</title>
@endsection

@section('subcontent')
<div class="intro-y flex items-center mt-8">
	<h2 class="text-lg font-medium mr-auto">Profile</h2>
</div>
<div class="grid grid-cols-12 gap-6 mt-5">
	<div class="intro-y col-span-12 lg:col-span-12">
		<form id="add-form">
			@csrf
			<div class="intro-y box">
				<div class="flex flex-col sm:flex-row items-center px-7 py-5 border-b border-gray-200 dark:border-dark-5">
					<h2 class="font-medium text-base mr-auto">Change Password</h2>
				</div>
				<div class="p-5">

					<div class="grid grid-cols-12">
						<div class="input-form col-span-12 px-2 py-1 mt-2">
							<label for="old-password" class="form-label w-full flex flex-col sm:flex-row">
								Old Password
							</label>
							<input id="old-password" type="text" name="old_password" class="form-control form__input" placeholder="Enter old password" >
							<div id="error-old_password" class="login__input-error w-5/6 text-theme-6"></div>
						</div>

						<div class="input-form col-span-12 px-2 py-1 mt-2">
							<label for="new-password" class="form-label w-full flex flex-col sm:flex-row">
								New Password
							</label>
							<input id="new-password" type="text" name="new_password" class="form-control form__input" placeholder="Enter new password" >
							<div id="error-new_password" class="login__input-error w-5/6 text-theme-6"></div>
						</div>
					</div>

				</div>
			</div>
			<div class="input-form col-span-12 lg:col-span-12 py-1 mt-3">
				<button type="submit" id="btn-add" class="btn btn-primary w-full xl:w-64 xl:mr-3 align-top">Update Password</button>
			</div>
		</form>
	</div>
	<x-notification></x-notification>
</div> 
@endsection

@section('script')
<script>
	cash(function () {
		async function update() {

			cash('#add-form').find('.form__input').removeClass('border-theme-6')
			cash('#add-form').find('.login__input-error').html('')

			var formData = new FormData(document.querySelector('#add-form'))

			cash('#btn-add').html('<i data-loading-icon="oval" data-color="white" class="w-5 h-5 mx-auto"></i>').svgLoader()
			cash('#btn-add').attr('disabled', 'true'); 

			axios.post('{{ url('/vendor/change-password') }}', formData).then(res => {
				showNotification('success','Success !',res.data.message)
				setTimeout(()=>{
					window.location.href = res.data.url;
				},1000)
			}).catch(err => {
				showNotification('error','Error !',err.response.data.message)
				cash('#btn-add').html('Update Password')   
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
			update();
		})

	})
</script>
@endsection