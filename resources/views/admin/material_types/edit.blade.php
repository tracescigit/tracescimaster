@extends('admin.layout.' . $layout)

@section('subhead')
<title>Update Material Types - TRACESCI</title>
@endsection

@section('subcontent')
<div class="intro-y flex items-center mt-8">
	<h2 class="text-lg font-medium mr-auto">Update Material Type</h2>
</div>
<div class="grid grid-cols-12 gap-6 mt-5">
	<div class="intro-y col-span-12 lg:col-span-12">
		<form id="update-form">
			@csrf
			<div class="intro-y box">
				<div class="flex flex-col sm:flex-row items-center px-7 py-5 border-b border-gray-200 dark:border-dark-5">
					<h2 class="font-medium text-base mr-auto">Material Type Details</h2>
				</div>
				<div class="p-5">

					<div class="grid grid-cols-12">

						
						<div class="input-form col-span-12 lg:col-span-6 px-2 py-1">
							<label for="type" class="form-label w-full flex flex-col sm:flex-row">
								Type
							</label>
							<input id="type" type="text" name="type" value="{{$material_type->type}}" class="form-control form__input" placeholder="Enter type" minlength="2">
							<div id="error-type" class="login__input-error w-5/6 text-theme-6"></div>
						</div>

						<div class="input-form col-span-12 lg:col-span-6 px-2 py-1">
							<label for="gsm" class="form-label w-full flex flex-col sm:flex-row">
								GSM
							</label>
							<input id="gsm" type="number" name="gsm" value="{{$material_type->gsm}}" class="form-control form__input" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" min="0" step="0.01" maxlength="10" placeholder="Enter gsm" minlength="2">
							<div id="error-gsm" class="login__input-error w-5/6 text-theme-6"></div>
						</div>

						<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-2">
							<label for="cost" class="form-label w-full flex flex-col sm:flex-row">
								Cost/Square Inch
							</label>
							<input id="cost" type="number" name="cost" value="{{$material_type->cost}}" class="form-control form__input" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" min="0" step="0.01" maxlength="10" placeholder="Enter cost" minlength="2">
							<div id="error-cost" class="login__input-error w-5/6 text-theme-6"></div>
						</div>

						<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-2">
							<label for="cost_usd" class="form-label w-full flex flex-col sm:flex-row">
								Cost/Square Inch (USD)
							</label>
							<input id="cost_usd" type="number" name="cost_usd" class="form-control form__input" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" min="0" step="0.01" maxlength="10" placeholder="Enter cost USD" minlength="2">
							<div id="error-cost" class="login__input-error w-5/6 text-theme-6"></div>
						</div>

						
						<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-2">
							<label for="status" class="form-label w-full flex flex-col sm:flex-row">
								Status
							</label>
							<select id="status" name="status" class="form-select form__input">
								<option value="1" {{$material_type->status=='1'?'selected':''}}>Active</option>
								<option value="0" {{$material_type->status=='0'?'selected':''}}>Inactive</option>
							</select>
						</div>

						<div class="input-form col-span-12 lg:col-span-12 px-2 py-1 mt-3">
							<button type="submit" id="btn-update" class="btn btn-primary w-full xl:w-32 xl:mr-3 align-top">Update type</button>
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
	cash(function () {
		async function add() {

			cash('#update-form').find('.form__input').removeClass('border-theme-6')
			cash('#update-form').find('.login__input-error').html('')

			var formData = new FormData(document.querySelector('#update-form'))

			cash('#btn-update').html('<i data-loading-icon="oval" data-color="white" class="w-5 h-5 mx-auto"></i>').svgLoader()
			cash('#btn-update').attr('disabled', 'true');

			axios.post('{{ url('/admin/material-types/'.encrypt($material_type->id).'/edit') }}', formData).then(res => {
				
				showNotification('success','Success !',res.data.message)
				setTimeout(()=>{
					window.location.reload()
				},1000)

			}).catch(err => {
				showNotification('error','Error !',err.response.data.message)
				cash('#btn-update').html('Update type')                   
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
