@extends('vendor.layout.' . $layout)

@section('subhead')
<title>Add Products - TRACESCI</title>
@endsection

@section('subcontent')
<div class="intro-y flex items-center mt-8">
	<h2 class="text-lg font-medium mr-auto">Add New Product</h2>
</div>
<div class="col-span-12 lg:col-span-12 bg-white">
	<div class="pos__ticket mt-5 p-5">
		<div class="col-span-12 lg:col-span-12 bg-gray-200 p-3 box">
			<p class="mb-2 text-md">{!!__('product.this_info_will')!!} </p>
		</div>
	</div>
</div>
<div class="grid grid-cols-12 gap-6 mt-5">
	<div class="intro-y col-span-12 lg:col-span-12">
		<form id="add-form">
			@csrf
			<div class="intro-y box">
				<div class="flex flex-col sm:flex-row items-center px-7 py-5 border-b border-gray-200 dark:border-dark-5">
					<h2 class="font-medium text-base mr-auto">Product details</h2>
				</div>
				<div class="p-5">

					<div class="grid grid-cols-12">

						<div class="input-form col-span-12 lg:col-span-6 px-2 py-1">
							<label for="name" class="form-label w-full flex flex-col sm:flex-row">
								Product name
							</label>
							<input id="name" type="text" name="name" class="form-control form__input" placeholder="Enter full name" minlength="2">
							<div id="error-name" class="login__input-error w-5/6 text-theme-6"></div>
						</div>

						<div class="input-form col-span-12 lg:col-span-6 px-2 py-1">
							<label for="brand" class="form-label w-full flex flex-col sm:flex-row">
								Brand name
							</label>
							<input id="brand" type="text" name="brand" class="form-control form__input" placeholder="Enter brand name" minlength="2">
							<div id="error-brand" class="login__input-error w-5/6 text-theme-6"></div>
						</div>

						<div class="input-form col-span-2 lg:col-span-2 px-2 py-1 mt-2">
							<label for="status" class="form-label w-full flex flex-col sm:flex-row">
								Currency
							</label>
							<select id="currency" name="currency" class="form-select form__input">
								@if (count(currencies())>0)
								@foreach (currencies() as $currency)
								<option value="{{$currency->currency}}" {{strtolower($currency->currency)=='inr'?'selected':''}}>{{$currency->currency}}</option>
								@endforeach
								@endif								
							</select>
						</div>

						<div class="input-form col-span-10 lg:col-span-10 px-2 py-1 mt-2">
							<label for="price" class="form-label w-full flex flex-col sm:flex-row">
								Price
							</label>
							<input id="price" type="number" name="price" class="form-control form__input" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" min="0" step="0.01" maxlength="10" placeholder="Enter price" minlength="2">
							<div id="error-price" class="login__input-error w-5/6 text-theme-6"></div>
						</div>

						<div class="input-form col-span-12 lg:col-span-12 px-2 py-1 mt-2">
							<label for="status" class="form-label w-full flex flex-col sm:flex-row">
								Status
							</label>
							<select id="status" name="status" class="form-select form__input">
								<option value="1">Active</option>
								<option value="0">Inactive</option>
							</select>
							<p class=" mt-2 mb-2 text-md">{!!__('product.status')!!} 
							</p>
						</div>

						<div class="input-form col-span-12 lg:col-span-12 px-2 py-1 mt-2">
							<label for="description" class="form-label w-full flex flex-col sm:flex-row">
								Product description
							</label>
							<textarea id="description" rows="5" name="description" class="form-control form__input tinymce" placeholder="Enter description" minlength="2"></textarea>
							<div id="error-description" class="login__input-error w-5/6 text-theme-6"></div>
						</div>

						<div class="input-form col-span-6 lg:col-span-6 px-2 py-1 mt-2">
							<label for="auth_required" class="form-label w-full flex flex-col sm:flex-row">
								Authentication Required
							</label>
							<select id="auth_required" name="auth_required" class="form-select form__input">
								<option value="1">Yes</option>
								<option value="0">No</option>
							</select>
						</div>
						<div class="input-form col-span-6 lg:col-span-6 px-2 py-1 mt-2">
							<label for="secret_pin" class="form-label w-full flex flex-col sm:flex-row">
								Generate Secret Pin
							</label>
							<select id="pin_required" name="pin_required" class="form-select form__input">
								<option value="1">Yes</option>
								<option value="0">No</option>
							</select>
						</div>
					</div>
				</div>
			</div>

			<div class="intro-y box mt-5">
				<div class="flex flex-col sm:flex-row items-center px-7 py-5 border-b border-gray-200 dark:border-dark-5">
					<h2 class="font-medium text-base mr-auto">Product image</h2>
				</div>
				<div class="p-5">

					<div class="grid grid-cols-12 mb-4">

						<div class="col-span-6">
							<div class="grid grid-cols-12">
								<div class="input-form col-span-12 px-2 py-1">
									<label for="file" class="form-label w-full flex flex-col sm:flex-row">
										Image
									</label>
									<input id="file" type="file" name="file" class="form-control form__input" accept="image/*">
									<div id="error-file" class="login__input-error w-5/6 text-theme-6"></div>
								</div>
							</div>
						</div>


						<div class="col-span-6">
							<div class="grid grid-cols-12">
								<div class="input-form col-span-12 px-2 py-1">
									<label for="product_label" class="form-label w-full flex flex-col sm:flex-row required">
										Product Label Image (max. image size 2mb)
									</label>
									<input id="product_label" type="file" name="product_label" class="form-control form__input" accept="image/*">
									<div id="error-product_label" class="login__input-error w-5/6 text-theme-6"></div>
								</div>
							</div>
						</div>
					</div>

					<div class="grid grid-cols-12 mt-6">
						<div class="input-form col-span-12 lg:col-span-6 px-2 py-1">
							<label for="media" class="form-label w-full flex flex-col sm:flex-row required">
								Product media
							</label>
							<input id="media" type="file" name="media" class="form-control form__input" accept="audio/*,video/*" />
							<div id="error-media" class="login__input-error w-5/6 text-theme-6"></div>
						</div>
					</div>

				</div>
			</div>

			<div class="input-form col-span-12 lg:col-span-12 py-1 mt-3">
				<button type="submit" id="btn-add" class="btn btn-primary w-full xl:w-32 xl:mr-3 align-top">Add product</button>
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

			cash('#btn-add').attr('disabled', 'true');
			cash('#btn-add').html('<i data-loading-icon="oval" data-color="white" class="w-5 h-5 mx-auto"></i>').svgLoader()

			axios.post('{{ url('/vendor/products/create') }}', formData).then(res => {
				showNotification('success','Success !',res.data.message)
				setTimeout(()=>{
					window.location.href = '{{ url('/vendor/products') }}'
				},1000)

			}).catch(err => {
				cash('#btn-add').removeAttr('disabled');
				showNotification('error','Error !',err.response.data.message)
				cash('#btn-add').html('Add product')                   

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
	})
</script>
@endsection
