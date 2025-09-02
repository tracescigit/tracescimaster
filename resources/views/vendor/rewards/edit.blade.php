@extends('vendor.layout.' . $layout)

@section('subhead')
<title>Update Scheme - TRACESCI</title>
@endsection

@section('subcontent')
<div class="intro-y flex items-center mt-8">
	<h2 class="text-lg font-medium mr-auto">Update Scheme</h2>
</div>
<div class="grid grid-cols-12 gap-6 mt-5">
	<div class="intro-y col-span-12 lg:col-span-12">
		<form id="update-form">
			
			<div class="intro-y box">
				<div class="flex flex-col sm:flex-row items-center px-7 py-5 border-b border-gray-200 dark:border-dark-5">
					<h2 class="font-medium text-base mr-auto">Scheme details</h2>
				</div>
				<div class="p-5">

					<div class="grid grid-cols-12">

						<div class="input-form col-span-12 lg:col-span-12 px-2 py-1">
							<label for="title" class="form-label w-full flex flex-col sm:flex-row">
								Scheme Title
							</label>
							<input id="title" type="text" name="title" class="form-control form__input" value="{{$reward->title}}" placeholder="Enter title" minlength="2">
							<div id="error-title" class="login__input-error w-5/6 text-theme-6"></div>
						</div>

						<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-2">
							<label for="reward_points" class="form-label w-full flex flex-col sm:flex-row">
								Reward Points
							</label>
							<input id="reward_points" type="number" min="1" name="reward_points" class="form-control form__input" value="{{$reward->points}}" placeholder="Enter reward points" minlength="2">
							<div id="error-reward_points" class="login__input-error w-5/6 text-theme-6"></div>
						</div>


						<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-2">
							<label for="status" class="form-label w-full flex flex-col sm:flex-row">
								Status
							</label>
							<select id="status" name="status" class="form-select form__input">
								<option value="Active" {{$reward->status=='Active'?'selected':''}}>Active</option>
								<option value="Inactive" {{$reward->status=='Inactive'?'selected':''}} >Inactive</option>
							</select>
						</div>

						<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-2">
							<label for="from" class="form-label w-full flex flex-col sm:flex-row">
								From Date
							</label>
							<input id="from" type="date" name="from" class="form-control form__input" value="{{$reward->from}}">
							<div id="error-from" class="login__input-error w-5/6 text-theme-6"></div>
						</div>

						<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-2">
							<label for="to" class="form-label w-full flex flex-col sm:flex-row">
								To Date
							</label>
							<input id="to" type="date" name="to" class="form-control form__input" value="{{$reward->to}}">
							<div id="error-to" class="login__input-error w-5/6 text-theme-6"></div>
						</div>

						<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-2">
							<label for="product_selection_type" class="form-label w-full flex flex-col sm:flex-row">
								Product Selection Type
							</label>
							<select id="product_selection_type" name="product_selection_type" class="form-select form__input">
								<option value="product" {{$reward->product_selection_type=='product'?'selected':''}}>By Product Name</option>
								<option value="batch" {{$reward->product_selection_type=='batch'?'selected':''}}>By Batch Code</option>
								<option value="chunk" {{$reward->product_selection_type=='chunk'?'selected':''}}>By Ranges of Codes</option>
							</select>
						</div>

						<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-2 product-div" style="display:{{($reward->product_selection_type=='batch' || $reward->product_selection_type=='product')?'':'none'}};">
							<label for="product" class="form-label w-full flex flex-col sm:flex-row">
								Select product
							</label>
							<select id="product" name="product" class="form-control form__input">
								<option value="">Please select</option>
								@if (count($products)>0)
								@foreach ($products as $product)
								<option value="{{$product->id}}" {{$reward->product_id==$product->id?'selected':''}}>
									{{$product->name}}
								</option>
								@endforeach
								@endif

							</select>
							<div id="error-product" class="login__input-error w-5/6 text-theme-6"></div>
						</div>

						<div class="input-form col-span-12 lg:col-span-6 mt-2 py-1 px-2 batch-div" style="display:{{$reward->product_selection_type=='batch'?'':'none'}};">
							<label for="batch" class="form-label">
								Select Batch
							</label>
							<select id="batch" name="batch" class="form-control form__input">
								@if ($batch)
								<option value="{{$batch->code}}" selected>{{$batch->code}}</option>
								@endif
							</select>
							<div id="error-batch" class="login__input-error w-auto text-theme-6"></div>
						</div>

					</div>
				</div>
			</div>

			<div class="intro-y box mt-4 codes-div" style="display:{{$reward->product_selection_type=='chunk'?'':'none'}};">
				<div class="flex flex-col sm:flex-row items-center px-7 py-5 border-b border-gray-200 dark:border-dark-5">
					<h2 class="font-medium text-base mr-auto">Codes Details</h2>
					<a href="javascript:;" class="float-right add-more-codes mr-3">Add More</a>
					<a href="javascript:;" class="float-right remove-codes" style="display:none;">Remove One</a>
				</div>
				<div class="p-5 codes-area">
					@php
					$codes = json_decode($reward->codes,true);
					@endphp

					@if (!empty($codes))
					@foreach ($codes as $code)
					@include('vendor.rewards.codes')
					@endforeach
					@endif

				</div>
			</div>
			@php
			$items = json_decode($reward->items,true);
			@endphp
			<div class="intro-y box mt-4">
				<div class="flex flex-col sm:flex-row items-center px-7 py-5 border-b border-gray-200 dark:border-dark-5">
					<h2 class="font-medium text-base mr-auto">Prizes Details</h2>
					<a href="javascript:;" class="float-right add-more-rewards mr-3">Add More</a>
					<a href="javascript:;" class="float-right remove-rewards" style="display:{{count($items)>=2?'':'none'}};">Remove One</a>
				</div>
				<div class="p-5 rewards-area">
					@if (!empty($items))
					@foreach ($items as $item)
					@include('vendor.rewards.items')
					@endforeach
					@endif
				</div>
			</div>

			<div class="intro-y box mt-4">
				<div class="p-5">
					<div class="grid grid-cols-12">	
						<div class="input-form col-span-12 lg:col-span-12 px-2 py-1 mt-3">
							<button type="submit" id="btn-update" class="btn btn-primary w-full xl:w-32 xl:mr-3 align-top">Update Scheme</button>
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

			axios.post('{{ url('/vendor/rewards/'.encrypt($reward->id).'/edit') }}', formData).then(res => {
				
				showNotification('success','Success !',res.data.message)
				setTimeout(()=>{
					window.location.reload()
				},1000)

			}).catch(err => {
				showNotification('error','Error !',err.response.data.message)
				cash('#btn-update').html('Update reward')    
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

		cash('.add-more-rewards').on('click', function(e) {
			e.preventDefault()
			addPrizes()

			if(cash('.reward-wrapper').length>1){
				cash('.remove-rewards').show('slow')
			}
		})

		cash('.remove-rewards').on('click', function(e) {
			e.preventDefault()
			removePrizes()

			if(cash('.reward-wrapper').length<2){
				cash('.remove-rewards').hide('slow')
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
			cash('.rewards-area').append('<div class="grid grid-cols-12 reward-wrapper">'+
				'<div class="input-form col-span-12 lg:col-span-4 px-2 py-1 mt-2">'+
				'<label class="form-label w-full flex flex-col sm:flex-row">'+
				'Type'+
				'</label>'+
				'<select name="types[]" class="form-control form__input" required>'+
				'<option value="amount">Amount</option>'+
				'<option value="product">Product</option>'+
				'</select>'+
				'</div>'+
				'<div class="input-form col-span-12 lg:col-span-4 px-2 py-1 mt-2">'+
				'<label class="form-label w-full flex flex-col sm:flex-row">'+
				'Points'+
				'</label>'+
				'<input type="text" name="points[]" class="form-control form__input" required>'+
				'</div>'+
				'<div class="input-form col-span-12 lg:col-span-4 px-2 py-1 mt-2">'+
				'<label class="form-label w-full flex flex-col sm:flex-row">'+
				'Value/Item'+
				'</label>'+
				'<input type="text" name="items[]" class="form-control form__input" required>'+
				'</div>'+
				'</div>');
		}

		async function removeCodes(){
			cash('.code-wrapper').last().remove()	
		}

		async function removePrizes(){
			cash('.reward-wrapper').last().remove()	
		}

		async function fetchBatches() {

			let product_id = cash('#product').val()

			let formData = {
				product_id
			}

			axios.post('{{ url('/vendor/getbatches') }}', formData).then(res => {
				cash('#batch').html(res.data)
			}).catch(err => {
				showNotification('error','Error !',err.response.data.message)
			})
		}

		cash('#product').on('change', function() {
			fetchBatches()
		})

		cash('#product_selection_type').on('change', function() {
			switchTypes()
		})

		async function switchTypes() {

			let type = cash('#product_selection_type').val()
			
			if(type=='batch'){
				cash('.batch-div').show();
				cash('.product-div').show();
				cash('.codes-div').hide();
			}

			if(type=='product'){
				cash('.batch-div').hide();
				cash('.product-div').show();
				cash('.codes-div').hide();
			}

			if(type=='chunk'){
				cash('.batch-div').hide();
				cash('.product-div').hide();
				cash('.codes-div').show();
			}
			
		}

	})
</script>
@endsection
