@extends('vendor.layout.' . $layout)

@section('subhead')
<title>Add Product Template - TRACESCI</title>
@endsection

@section('subcontent')
<div class="intro-y flex items-center mt-8">
	<h2 class="text-lg font-medium mr-auto">Add Product Template</h2>
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
					<h2 class="font-medium text-base mr-auto">Template details</h2>
				</div>
				<div class="p-5">

					<div class="grid grid-cols-12">

						<div class="input-form col-span-12 lg:col-span-6 px-2 py-1">
							<label for="name" class="form-label w-full flex flex-col sm:flex-row">
								Template name
							</label>
							<input id="name" type="text" name="name" class="form-control form__input" placeholder="Enter Template name" minlength="2">
							<div id="error-name" class="login__input-error w-5/6 text-theme-6"></div>
						</div>




					</div>
				</div>
			</div>
			@php $i=1;
			@endphp
			<div class="intro-y box mt-5 p-5">
				<div class="grid grid-cols-12 gap-4">

					<div class="col-span-12">
						<label class="form-label">
							Select Fields
						</label>
					</div>

					@php $i = 1; @endphp

					@foreach(getProductFields() as $field)
					<div class="col-span-12 flex items-center justify-between border-b py-2">

						<!-- Field Name -->
						<div class="w-1/2">
							<label class="font-medium">
								{{ $i }}. {{ $field }}
							</label>
						</div>

						<!-- Checkbox -->
						<div class="w-1/2 flex items-center">
							<input
								type="checkbox"
								name="fields[]"
								value="{{ $field }}"
								class="form-check-input mr-2"
								id="field_{{ $i }}">

							<label for="field_{{ $i }}" class="cursor-pointer">
								{{ __('common.view') }}
							</label>
						</div>

					</div>

					@php $i++; @endphp
					@endforeach

				</div>
			</div>
			<div class="input-form col-span-12 lg:col-span-12 py-1 mt-3">
				<button type="submit" id="btn-add" class="btn btn-primary w-full xl:w-32 xl:mr-3 align-top">Add Template</button>
			</div>
		</form>
	</div>
	<x-notification></x-notification>
</div>
@endsection

@section('script')
<script>
	cash(function() {
		async function add() {

			cash('#add-form').find('.form__input').removeClass('border-theme-6')
			cash('#add-form').find('.login__input-error').html('')
			var formData = new FormData(document.querySelector('#add-form'))

			cash('#btn-add').attr('disabled', 'true');
			cash('#btn-add').html('<i data-loading-icon="oval" data-color="white" class="w-5 h-5 mx-auto"></i>').svgLoader()

			axios.post("{{ url('/vendor/products_template/create') }}", formData).then(res => {
				showNotification('success', 'Success !', res.data.message)
				setTimeout(() => {
					window.location.href = "{{ url('/vendor/products_template') }}"
				}, 1000)

			}).catch(err => {
				cash('#btn-add').removeAttr('disabled');
				showNotification('error', 'Error !', err.response.data.message)
				cash('#btn-add').html('Add product')

				if (err.response.data.errors) {
					for (const [key, val] of Object.entries(err.response.data.errors)) {
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