@extends('admin.layout.' . $layout)

@section('subhead')
<title>Update Plans - TRACESCI</title>
@endsection

@section('subcontent')
<div class="intro-y flex items-center mt-8">
	<h2 class="text-lg font-medium mr-auto">Update Plan</h2>
</div>
<div class="grid grid-cols-12 gap-6 mt-5">
	<div class="intro-y col-span-12 lg:col-span-12">
		<form id="update-form">
			@csrf
			<div class="intro-y box">
				<div class="flex flex-col sm:flex-row items-center px-7 py-5 border-b border-gray-200 dark:border-dark-5">
					<h2 class="font-medium text-base mr-auto">Plan details</h2>
				</div>
				<div class="p-5">

					<div class="grid grid-cols-12">

						<div class="input-form col-span-12 lg:col-span-6 px-2 py-1">
							<label for="title" class="form-label w-full flex flex-col sm:flex-row">
								Plan title
							</label>
							<input id="title" type="text" name="title" class="form-control form__input" value="{{$plan->title}}" placeholder="Enter title" minlength="2">
							<div id="error-title" class="login__input-error w-5/6 text-theme-6"></div>
						</div>

						<div class="input-form col-span-12 lg:col-span-6 px-2 py-1">
							<label for="credits" class="form-label w-full flex flex-col sm:flex-row">
								Credits
							</label>
							<input id="credits" type="number" name="credits" class="form-control form__input" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" min="1" step="1" maxlength="10" value="{{$plan->credits}}" placeholder="Enter credits" minlength="1">
							<div id="error-credits" class="login__input-error w-5/6 text-theme-6"></div>
						</div>

						<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-2">
							<label for="allowed_products" class="form-label w-full flex flex-col sm:flex-row">
								Allowed products
							</label>
							<input id="allowed_products" type="number" name="allowed_products" class="form-control form__input" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" min="1" step="1" maxlength="10" value="{{$plan->products}}" placeholder="Enter allowed products" minlength="1">
							<div id="error-allowed_products" class="login__input-error w-5/6 text-theme-6"></div>
						</div>

						<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-2">
							<label for="allowed_users" class="form-label w-full flex flex-col sm:flex-row">
								Allowed users
							</label>
							<input id="allowed_users" type="number" name="allowed_users" class="form-control form__input" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" min="1" step="1" maxlength="10" value="{{$plan->users}}" placeholder="Enter allowed users" minlength="1">
							<div id="error-allowed_users" class="login__input-error w-5/6 text-theme-6"></div>
						</div>

						<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-2">
							<label for="price_inr" class="form-label w-full flex flex-col sm:flex-row">
								Price in inr
							</label>
							<input id="price_inr" type="number" name="price_inr" class="form-control form__input" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" min="0" step="0.01" maxlength="10" value="{{number_format((float)$plan->price_inr,2,'.','')}}" placeholder="Enter price in inr" minlength="2">
							<div id="error-price_inr" class="login__input-error w-5/6 text-theme-6"></div>
						</div>

						<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-2">
							<label for="price_usd" class="form-label w-full flex flex-col sm:flex-row">
								Price in usd
							</label>
							<input id="price_usd" type="number" name="price_usd" class="form-control form__input" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" min="0" step="0.01" maxlength="10" value="{{number_format((float)$plan->price_usd,2,'.','')}}" placeholder="Enter price in usd" minlength="2">
							<div id="error-price_usd" class="login__input-error w-5/6 text-theme-6"></div>
						</div>


						<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-2">
							<label for="status" class="form-label w-full flex flex-col sm:flex-row">
								Status
							</label>
							<select id="status" name="status" class="form-select form__input">
								<option value="1" {{$plan->status=='1'?'selected':''}}>Active</option>
								<option value="0" {{$plan->status=='0'?'selected':''}}>Inactive</option>
							</select>
						</div>

						<div class="input-form col-span-12 lg:col-span-12 px-2 py-1 mt-2">
							<label for="description" class="form-label w-full flex flex-col sm:flex-row">
								Plan description
							</label>
							<textarea id="description" rows="5" name="description" class="form-control form__input tinymce" placeholder="Enter description" minlength="2">{{$plan->description}}</textarea>
							<div id="error-description" class="login__input-error w-5/6 text-theme-6"></div>
						</div>

						<div class="input-form col-span-12 lg:col-span-12 px-2 py-1 mt-3">
							<button type="submit" id="btn-update" class="btn btn-primary w-full xl:w-32 xl:mr-3 align-top">Update plan</button>
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

			axios.post('{{ url('/admin/plans/'.encrypt($plan->id).'/edit') }}', formData).then(res => {
				
				showNotification('success','Success !',res.data.message)
				setTimeout(()=>{
					window.location.reload()
				},1000)

			}).catch(err => {
				showNotification('error','Error !',err.response.data.message)
				cash('#btn-update').html('Update plan')                   
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
