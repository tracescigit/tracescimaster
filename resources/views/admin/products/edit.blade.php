@extends('admin.layout.' . $layout)

@section('subhead')
<title>Update Products - TRACESCI</title>
@endsection

@section('subcontent')
<div class="intro-y flex items-center mt-8">
	<h2 class="text-lg font-medium mr-auto">Update New Product</h2>
</div>
<div class="grid grid-cols-12 gap-6 mt-5">
	<div class="intro-y col-span-12 lg:col-span-12">
		<form id="update-form">
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
							<input id="name" type="text" name="name" class="form-control form__input" value="{{$product->name}}" placeholder="Enter full name" minlength="2">
							<div id="error-name" class="login__input-error w-5/6 text-theme-6"></div>
						</div>

						<div class="input-form col-span-12 lg:col-span-6 px-2 py-1">
							<label for="brand" class="form-label w-full flex flex-col sm:flex-row">
								Brand name
							</label>
							<input id="brand" type="text" name="brand" class="form-control form__input" value="{{$product->brand}}" placeholder="Enter brand name" minlength="2">
							<div id="error-brand" class="login__input-error w-5/6 text-theme-6"></div>
						</div>

						<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-2">
							<label for="price" class="form-label w-full flex flex-col sm:flex-row">
								Price
							</label>
							<input id="price" type="number" name="price" class="form-control form__input" value="{{$product->price}}" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" min="0" step="0.01" maxlength="10" placeholder="Enter price" minlength="2">
							<div id="error-price" class="login__input-error w-5/6 text-theme-6"></div>
						</div>

						<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-2">
							<label for="status" class="form-label w-full flex flex-col sm:flex-row">
								Status
							</label>
							<select id="status" name="status" class="form-select form__input">
								<option value="1" {{$product->status=='1'?'selected':''}}>Active</option>
								<option value="0" {{$product->status=='0'?'selected':''}}>Inactive</option>
							</select>
						</div>

						<div class="input-form col-span-12 lg:col-span-12 px-2 py-1 mt-2">
							<label for="description" class="form-label w-full flex flex-col sm:flex-row">
								Product description
							</label>
							<textarea id="description" rows="5" name="description" class="form-control form__input" placeholder="Enter description" minlength="2">{{$product->description}}</textarea>
							<div id="error-description" class="login__input-error w-5/6 text-theme-6"></div>
						</div>
					</div>
				</div>
			</div>

			<div class="intro-y box mt-5">
				<div class="flex flex-col sm:flex-row items-center px-7 py-5 border-b border-gray-200 dark:border-dark-5">
					<h2 class="font-medium text-base mr-auto">Inventory details</h2>
				</div>
				<div class="p-5">

					<div class="grid grid-cols-12">

						<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-2">
							<label for="unique_id" class="form-label w-full flex flex-col sm:flex-row">
								Unique ID
							</label>
							<input id="unique_id" type="text" name="unique_id" class="form-control form__input" value="{{$product->unique_id}}" placeholder="Enter unique id" minlength="2">
							<div id="error-unique_id" class="login__input-error w-5/6 text-theme-6"></div>
						</div>

						<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-2">
							<label for="batch_code" class="form-label w-full flex flex-col sm:flex-row">
								Batch code
							</label>
							<input id="batch_code" type="text" name="batch_code" class="form-control form__input" value="{{$product->batch_code}}"  placeholder="Enter batch code" minlength="2">
							<div id="error-batch_code" class="login__input-error w-5/6 text-theme-6"></div>
						</div>

						<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-2">
							<label for="gs1_code" class="form-label w-full flex flex-col sm:flex-row">
								GS1 code
							</label>
							<input id="gs1_code" type="text" name="gs1_code" class="form-control form__input" value="{{$product->gs1_code}}" placeholder="Enter GS1 code" minlength="2">
							<div id="error-gs1_code" class="login__input-error w-5/6 text-theme-6"></div>
						</div>

						<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-2">
							<label for="mfg_date" class="form-label w-full flex flex-col sm:flex-row">
								Manufactured at
							</label>
							<input id="mfg_date" type="date" name="mfg_date" class="form-control form__input" placeholder="Select" value="{{$product->mfg_date}}" minlength="2">
							<div id="error-mfg_date" class="login__input-error w-5/6 text-theme-6"></div>
						</div>

						<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-2">
							<label for="exp_date" class="form-label w-full flex flex-col sm:flex-row">
								Expiry date
							</label>
							<input id="exp_date" type="date" name="exp_date" class="form-control form__input" value="{{$product->exp_date}}" placeholder="Select" minlength="2">
							<div id="error-exp_date" class="login__input-error w-5/6 text-theme-6"></div>
						</div>

					</div>

				</div>
			</div>

			<div class="intro-y box mt-5">
				<div class="flex flex-col sm:flex-row items-center px-7 py-5 border-b border-gray-200 dark:border-dark-5">
					<h2 class="font-medium text-base mr-auto">Product image</h2>
				</div>
				<div class="p-5">

					<div class="grid grid-cols-12">

						<div class="input-form col-span-12 lg:col-span-6 px-2 py-1">
							<label for="file" class="form-label w-full flex flex-col sm:flex-row">
								Image
							</label>
							<input id="file" type="file" name="file" class="form-control form__input">
							<div id="error-file" class="login__input-error w-5/6 text-theme-6"></div>
						</div>

						@if ($product->image_url)
						<div class="input-form col-span-12 lg:col-span-6 px-2 py-1">
						</div>
						<div class="input-form col-span-12 lg:col-span-3 px-2 py-1 mt-3">
							<div class="h-40 relative image-fit cursor-pointer zoom-in mx-auto">
								<img class="rounded-md" alt="Product Image" src="{{ asset($product->image_url) }}">
							</div>
						</div>
						@endif

						<div class="input-form col-span-12 lg:col-span-12 px-2 py-1 mt-3">
							<button type="button" id="btn-update" class="btn btn-primary w-full xl:w-32 xl:mr-3 align-top">Update product</button>
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
			// await helper.delay(500)

			axios.post('{{ url('/admin/products/'.encrypt($product->id).'/edit') }}', formData).then(res => {
				// cash('#btn-update').attr('disabled', 'true');
				showNotification('success','Success !',res.data.message)
				setTimeout(()=>{
					window.location.reload()
				},1000)

			}).catch(err => {
				showNotification('error','Error !',err.response.data.message)
				cash('#btn-update').html('Update product')                   

				if (err.response.data.errors) {
					for (const [key, val] of Object.entries(err.response.data.errors)){
						cash(`#${key}`).addClass('border-theme-6')
						cash(`#error-${key}`).html(val)
					}
				}

			})
		}

		cash('#update-form').on('keyup', function(e) {
			if (e.keyCode === 13) {
				add()
			}
		})

		cash('#btn-update').on('click', function() {
			add()
		})
	})
</script>
@endsection
