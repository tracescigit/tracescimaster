@extends('vendor.layout.' . $layout)

@section('subhead')
<title>Update Cashback - TRACESCI</title>
@endsection

@section('subcontent')
<div class="intro-y flex items-center mt-8">
	<h2 class="text-lg font-medium mr-auto">Update Cashback</h2>
</div>
<div class="grid grid-cols-12 gap-6 mt-5">
	<div class="intro-y col-span-12 lg:col-span-12">
		<form id="update-form">
			
			<div class="intro-y box">
				<div class="flex flex-col sm:flex-row items-center px-7 py-5 border-b border-gray-200 dark:border-dark-5">
					<h2 class="font-medium text-base mr-auto">Offer details</h2>
				</div>
				<div class="p-5">

					<div class="grid grid-cols-12">

						<div class="input-form col-span-12 lg:col-span-12 px-2 py-1">
							<label for="title" class="form-label w-full flex flex-col sm:flex-row">
								Offer Title
							</label>
							<input id="title" type="text" name="title" class="form-control form__input" value="{{$cashback->title}}" placeholder="Enter title" minlength="2">
							<div id="error-title" class="login__input-error w-5/6 text-theme-6"></div>
						</div>

						<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-2">
							<label for="from" class="form-label w-full flex flex-col sm:flex-row">
								From Date
							</label>
							<input id="from" type="date" name="from" class="form-control form__input" value="{{$cashback->from}}">
							<div id="error-from" class="login__input-error w-5/6 text-theme-6"></div>
						</div>

						<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-2">
							<label for="to" class="form-label w-full flex flex-col sm:flex-row">
								To Date
							</label>
							<input id="to" type="date" name="to" class="form-control form__input" value="{{$cashback->to}}">
							<div id="error-to" class="login__input-error w-5/6 text-theme-6"></div>
						</div>

						<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-2">
							<label for="allow_multiple" class="form-label w-full flex flex-col sm:flex-row">
								Allow Single User to Win Multiple
							</label>
							<select id="allow_multiple" name="allow_multiple" class="form-select form__input">
								<option value="Yes" {{$cashback->allow_multiple=='Yes'?'selected':''}}>Yes</option>
								<option value="No"  {{$cashback->allow_multiple=='No'?'selected':''}}>No</option>
							</select>
						</div>

						<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-2">
							<label for="reshuffle_items" class="form-label w-full flex flex-col sm:flex-row">
								Reshuffle Winning Items
							</label>
							<select id="reshuffle_items" name="reshuffle_items" class="form-select form__input">
								<option value="No" {{$cashback->reshuffle_items=='No'?'selected':''}}>No</option>
								<option value="Yes" {{$cashback->reshuffle_items=='Yes'?'selected':''}}>Yes</option>
							</select>
						</div>

						<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-2">
							<label for="status" class="form-label w-full flex flex-col sm:flex-row">
								Status
							</label>
							<select id="status" name="status" class="form-select form__input">
								<option value="Active" {{$cashback->status=='Active'?'selected':''}}>Active</option>
								<option value="Inactive" {{$cashback->status=='Inactive'?'selected':''}} >Inactive</option>
							</select>
						</div>

						<div class="input-form col-span-12 lg:col-span-12 px-2 py-1 mt-2">
							<label for="description" class="form-label w-full flex flex-col sm:flex-row">
								Description
							</label>
							<textarea id="description" rows="5" name="description" class="form-control form__input tinymce" placeholder="Enter description" minlength="2">{{$cashback->description}}</textarea>
							<div id="error-description" class="login__input-error w-5/6 text-theme-6"></div>
						</div>

					</div>
				</div>
			</div>

			<div class="intro-y box mt-4">
				<div class="flex flex-col sm:flex-row items-center px-7 py-5 border-b border-gray-200 dark:border-dark-5">
					<h2 class="font-medium text-base mr-auto">Codes Details</h2>
					<a href="javascript:;" class="float-right add-more-codes mr-3">Add More</a>
					<a href="javascript:;" class="float-right remove-codes" style="display:none;">Remove One</a>
				</div>
				<div class="p-5 codes-area">
					@php
					$codes = json_decode($cashback->codes,true);
					@endphp

					@if (!empty($codes))
					@foreach ($codes as $code)
					@include('vendor.cashbacks.codes')
					@endforeach
					@endif

				</div>
			</div>

			<div class="intro-y box mt-4">
				<div class="flex flex-col sm:flex-row items-center px-7 py-5 border-b border-gray-200 dark:border-dark-5">
					<h2 class="font-medium text-base mr-auto">Prizes Details</h2>
					<a href="javascript:;" class="float-right add-more-prizes mr-3">Add More</a>
					<a href="javascript:;" class="float-right remove-prizes" style="display:none;">Remove One</a>
				</div>
				<div class="p-5 prizes-area">
					@php
					$items = json_decode($cashback->items,true);
					@endphp

					@if (!empty($items))
					@foreach ($items as $item)
					@include('vendor.cashbacks.items')
					@endforeach
					@endif
				</div>
			</div>

			<div class="intro-y box mt-4">
				<div class="p-5">
					<div class="grid grid-cols-12">	
						<div class="input-form col-span-12 lg:col-span-12 px-2 py-1 mt-3">
							<button type="submit" id="btn-update" class="btn btn-primary w-full xl:w-32 xl:mr-3 align-top">Update Offer</button>
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
		async function update() {

			cash('#update-form').find('.form__input').removeClass('border-theme-6')
			cash('#update-form').find('.login__input-error').html('')

			var formData = new FormData(document.querySelector('#update-form'))

			cash('#btn-update').html('<i data-loading-icon="oval" data-color="white" class="w-5 h-5 mx-auto"></i>').svgLoader()
			cash('#btn-update').attr('disabled', 'true');

			axios.post('{{ url('/vendor/cashbacks/'.encrypt($cashback->id).'/edit') }}', formData).then(res => {
				
				showNotification('success','Success !',res.data.message)
				setTimeout(()=>{
					window.location.reload()
				},1000)

			}).catch(err => {
				showNotification('error','Error !',err.response.data.message)
				cash('#btn-update').html('Update Offer')    
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
			update()
		})

		cash('.add-more-codes').on('click', function(e) {
			e.preventDefault()
			addCodes()

			if(cash('.code-wrapper').length>1){
				cash('.remove-codes').show('slow')
			}
		})

		cash('.remove-codes').on('click', function(e) {
			e.preventDefault()
			removeCodes()

			if(cash('.code-wrapper').length<2){
				cash('.remove-codes').hide('slow')
			}
		})

		cash('.add-more-prizes').on('click', function(e) {
			e.preventDefault()
			addPrizes()

			if(cash('.prize-wrapper').length>1){
				cash('.remove-prizes').show('slow')
			}
		})

		cash('.remove-prizes').on('click', function(e) {
			e.preventDefault()
			removePrizes()

			if(cash('.prize-wrapper').length<2){
				cash('.remove-prizes').hide('slow')
			}
		})

		async function addCodes(){
			cash('.codes-area').append('<div class="grid grid-cols-12 code-wrapper">'+
				'<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-2">'+
				'<label class="form-label w-full flex flex-col sm:flex-row">'+
				'From Code'+
				'</label>'+
				'<input type="text" name="from_codes[]" class="form-control form__input" required>'+
				'</div>'+
				'<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-2">'+
				'<label class="form-label w-full flex flex-col sm:flex-row">'+
				'To Code'+
				'</label>'+
				'<input type="text" name="to_codes[]" class="form-control form__input" required>'+
				'</div>'+
				'</div>');
		}

		async function addPrizes(){
			cash('.prizes-area').append('<div class="grid grid-cols-12 prize-wrapper">'+
				'<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-2">'+
				'<label class="form-label w-full flex flex-col sm:flex-row">'+
				'Amount'+
				'</label>'+
				'<input type="number" min="1" name="items[]" class="form-control form__input" required>'+
				'</div>'+
				'<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-2">'+
				'<label class="form-label w-full flex flex-col sm:flex-row">'+
				'Quantity'+
				'</label>'+
				'<input type="number" min="1" step="1" name="quantity[]" class="form-control form__input" required>'+
				'</div>'+
				'</div>');
		}

		async function removeCodes(){
			cash('.code-wrapper').last().remove()	
		}

		async function removePrizes(){
			cash('.prize-wrapper').last().remove()	
		}

	})
</script>
@endsection
