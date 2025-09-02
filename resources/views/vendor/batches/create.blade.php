@extends('vendor.layout.' . $layout)

@section('subhead')
<title>Add Batches - TRACESCI</title>
@endsection

@section('subcontent')
<div class="intro-y flex items-center mt-8">
	<h2 class="text-lg font-medium mr-auto">Add New Batch</h2>
</div>
<div class="grid grid-cols-12 gap-6 mt-5">
	<div class="intro-y col-span-12 lg:col-span-12">
		<form id="add-form">
			@csrf
			<div class="intro-y box">
				<div class="flex flex-col sm:flex-row items-center px-7 py-5 border-b border-gray-200 dark:border-dark-5">
					<h2 class="font-medium text-base mr-auto">Batch details</h2>
				</div>
				<div class="p-5">

					<div class="grid grid-cols-12">

						<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-2">
							<label for="product" class="form-label w-full flex flex-col sm:flex-row">
								Select product
							</label>
							<select id="product" name="product" class="form-control form__input">
								<option value="">Please select</option>
								@if (count($products)>0)
								@foreach ($products as $product)
								<option value="{{$product->id}}">{{$product->name}}</option>
								@endforeach
								@endif

							</select>
							<div id="error-product" class="login__input-error w-5/6 text-theme-6"></div>
						</div>

						<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-2">
							<label for="code" class="form-label w-full flex flex-col sm:flex-row">
								Batch code
							</label>
							<input id="code" type="text" name="code" class="form-control form__input" placeholder="Enter batch code" >
							<div id="error-code" class="login__input-error w-5/6 text-theme-6"></div>
						</div>

						<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-2">
							<label for="gs1_code" class="form-label w-full flex flex-col sm:flex-row">
								GS1 code
							</label>
							<input id="gs1_code" type="text" name="gs1_code" class="form-control form__input" placeholder="Enter GS1 code" >
							<div id="error-gs1_code" class="login__input-error w-5/6 text-theme-6"></div>
						</div>

						<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-2">
							<label for="mfg_date" class="form-label w-full flex flex-col sm:flex-row">
								Manufactured at
							</label>
							<input id="mfg_date" type="date" name="mfg_date" class="form-control form__input" placeholder="Select" minlength="2">
							<div id="error-mfg_date" class="login__input-error w-5/6 text-theme-6"></div>
						</div>

						<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-2">
							<label for="exp_date" class="form-label w-full flex flex-col sm:flex-row">
								Expiry date
							</label>
							<input id="exp_date" type="date" name="exp_date" class="form-control form__input" placeholder="Select" minlength="2">
							<div id="error-exp_date" class="login__input-error w-5/6 text-theme-6"></div>
						</div>

						<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-2">
							<label for="status" class="form-label w-full flex flex-col sm:flex-row">
								Status
							</label>
							<select id="status" name="status" class="form-select form__input">
								<option value="1">Active</option>
								<option value="0">Inactive</option>
							</select>
						</div>

						<div class="input-form col-span-12 lg:col-span-12 px-2 py-1 mt-2">
							<label for="remarks" class="form-label w-full flex flex-col sm:flex-row">
								Remarks
							</label>
							<textarea id="remarks" rows="5" name="remarks" class="form-control form__input tinymce" placeholder="Enter remarks" minlength="2"></textarea>
							<div id="error-remarks" class="login__input-error w-5/6 text-theme-6"></div>
						</div>

					</div>

				</div>
			</div>
			<div class="input-form col-span-12 lg:col-span-12 py-1 mt-3">
				<button type="submit" id="btn-add" class="btn btn-primary w-full xl:w-32 xl:mr-3 align-top">Add batch</button>
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

			axios.post('{{ url('/vendor/batches/create') }}', formData).then(res => {
				showNotification('success','Success !',res.data.message)
				setTimeout(()=>{
					window.location.href = '{{ url('/vendor/batches') }}'
				},1000)

			}).catch(err => {
				showNotification('error','Error !',err.response.data.message)
				cash('#btn-add').html('Add batch')   
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

	})
</script>
@endsection
