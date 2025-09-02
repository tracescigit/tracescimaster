@extends('vendor.layout.' . $layout)

@section('subhead')
<title>Order - TRACESCI</title>
@endsection

@section('subcontent')
<div class="intro-y flex flex-col sm:flex-row items-center mt-8">
	<h2 class="text-lg font-medium mr-auto">Order</h2>
</div>
<!-- BEGIN: Order -->
<div class="intro-y box overflow-hidden mt-5" id="order">
	<div class="border-b border-gray-200 dark:border-dark-5 text-center sm:text-left">
		<div class="px-5 py-10 sm:px-10 sm:py-10">
			<div class="text-theme-1 dark:text-theme-10 font-semibold text-3xl">ORDER</div>
			<div class="mt-1">#{{$order->id}}</div>
			<div class="mt-1">{{date('M d, Y',strtotime($order->updated_at))}}</div>
		</div>
		<div class="flex flex-col lg:flex-row px-5 sm:px-10 pt-10 pb-10 ">
			<div>
				<div class="text-base text-gray-600">Shipping Details</div>
				<div class="text-lg font-medium text-theme-1 dark:text-theme-10 mt-2">{{$order->name}}</div>
				<div class="mt-1">{{$order->phone}}</div>
				<div class="mt-1">{{$order->address}}</div>
				<div class="mt-1">{{$order->city}}</div>
				<div class="mt-1">{{$order->state}}</div>
				<div class="mt-1">{{$order->pin_code}}</div>
			</div>
			<div class="lg:text-right mt-10 lg:mt-0 lg:ml-auto">
				<div class="text-base text-gray-600">Payment to</div>
				<div class="text-lg font-medium text-theme-1 dark:text-theme-10 mt-2">{{env('APP_NAME','TRACESCI')}}</div>
			</div>
		</div>
	</div>

	<div class="px-5 sm:px-10 py-10 sm:py-10">
		<div class="overflow-x-auto">
			<table class="table">
				<thead>
					<tr>
						<th class="border-b-2 dark:border-dark-5 whitespace-nowrap">DESCRIPTION</th>
						<th class="border-b-2 dark:border-dark-5 text-right whitespace-nowrap">QTY</th>
						<th class="border-b-2 dark:border-dark-5 text-right whitespace-nowrap">POINTS USED</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class="border-b dark:border-dark-5">
							<div class="font-medium whitespace-nowrap">{{$order->product??''}}</div>
						</td>
						<td class="text-right border-b dark:border-dark-5 w-32">1</td>
						<td class="text-right border-b dark:border-dark-5 w-32">
							{{number_format((float)$order->points,2,'.','')??''}}
						</td>
					</tr>
				</tbody>
			</table>
		</div>

		<div class="text-center sm:text-right sm:ml-auto">
			<div class="text-base text-gray-600 mt-3">Points Used</div>
			<div class="text-xl text-theme-1 dark:text-theme-10 font-medium mt-2">{{number_format((float)$order->points,2,'.','')}}</div>
		</div>
	</div>
</div>
<!-- END: Order -->

<div class="intro-y box overflow-hidden mt-5 px-5">
	<div class="text-center sm:text-left">
		<form id="update-form">
			@csrf
			<div class="grid grid-cols-12 p-5">
				<div class="col-span-12 lg:col-span-12">
					<div class="text-base text-gray-600">{{__('Update Status')}}</div>
					<span> Current dispatch status : {{$order->dispatch_status??"-"}} </span>
				</div>

				<div class="col-span-12 lg:col-span-12 mt-5">
					<div class="grid grid-cols-12">
						<div class="input-form col-span-9 px-2 py-1 mt-2">
							<label for="status" class="form-label w-full flex flex-col sm:flex-row">
								Status
							</label>
							<select id="status" name="status" class="form-select form__input" required>
								<option value="">Please Select</option>
								@foreach(updatedbleOrderStatuses($order->dispatch_status) as $status)
								<option value="{{$status}}">{{$status}}</option>
								@endforeach
							</select>
						</div>

						<div class="input-form col-span-3 px-2 py-5 mt-5">
							<button type="submit" id="btn-update" class="btn btn-primary w-full xl:w-32 xl:mr-3 align-top">Update</button>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>

@php
$logs = json_decode($order->history,true);
@endphp
<div class="intro-y box overflow-hidden mt-5 px-5">
	<div class="text-center sm:text-left">
		<div class="grid grid-cols-12 p-5">
			<div class="col-span-12 lg:col-span-12">
				<div class="text-base text-gray-600">{{__('order.order_logs')}}</div>
			</div>
			@if ($logs && count($logs)>0)
			<div class="col-span-12 lg:col-span-12 mt-5">
				@foreach ($logs as $log)
				<div class="col-span-12 lg:col-span-12 mb-4 bg-gray-100 p-2">
					<p class="mb-1">Date : {{$log['date']}}</p>
					<p class="mb-1">{{__('Status')}} : 
						{{$log['message']}}
					</p>
				</div>
				@endforeach
			</div>
			@endif
		</div>
	</div>
</div>
<x-notification></x-notification>
@endsection

@section('script')
<script>
	cash(function () {
		async function update() {

			cash('#update-form').find('.form__input').removeClass('border-theme-6')
			cash('#update-form').find('.login__input-error').html('')

			var formData = new FormData(document.querySelector('#update-form'))

			cash('#btn-update').html('<i data-loading-icon="oval" data-color="white" class="w-5 h-5 mx-auto"></i>').svgLoader()

			axios.post('{{ url('/vendor/reward-orders/'.encrypt($order->id).'/edit') }}', formData).then(res => {
				cash('#btn-update').attr('disabled', 'true');
				showNotification('success','{{__('common.success')}} !',res.data.message)
				setTimeout(()=>{
					window.location.reload()
				},1000)

			}).catch(err => {
				showNotification('error','{{__('common.error')}} !',err.response.data.message)
				cash('#btn-update').html('Update order')                  

				if (err.response.data.errors) {
					for (const [key, val] of Object.entries(err.response.data.errors)){
						cash(`#${key}`).addClass('border-theme-6')
						cash(`#error-${key}`).html(val)
					}
				}

			})
		}

		cash('#btn-update').on('click', function(e) {
			e.preventDefault()
			update()
		})
	})
</script>
@endsection

