@extends('admin.layout.' . $layout)

@section('subhead')
<title>Order Details - TRACESCI</title>
@endsection

@section('subcontent')
<div class="intro-y flex flex-col sm:flex-row items-center mt-8">
	<h2 class="text-lg font-medium mr-auto">{{__('order.order_invoice')}}</h2>
</div>
<!-- BEGIN: Order Invoice -->
<div class="intro-y box overflow-hidden mt-5" id="order">
	<div class="border-b border-gray-200 dark:border-dark-5 text-center sm:text-left">
		<div class="px-5 py-10 sm:px-10 sm:py-10">
			<div class="text-theme-1 dark:text-theme-10 font-semibold text-3xl">{{strtoupper(__('common.order'))}}</div>
			<div class="mt-2">
				{{__('order.receipt')}} <span class="font-medium">#{{'IN'.$order->id}}</span>
				@if($order->transaction_id)
				<br>
				{{__('order.payment_id')}} <span class="font-medium">#{{$order->transaction_id}}</span>
				@endif
				<br>
				{{__('common.dispatch_status')}} : <span class="font-medium {{$order->getCurrentStatusText->title=='Pending'|| $order->getCurrentStatusText->title =='Cancelled'?'text-red-500':'text-green-500'}}">{{__($order->getCurrentStatusText->title)}}</span>
			</div>
			<div class="mt-1">{{date('M d, Y',strtotime($order->updated_at))}}</div>
		</div>
		<div class="flex flex-col lg:flex-row px-5 sm:px-10 pt-10 pb-10 ">
			<div>
				<div class="text-base text-gray-600">{{__('common.user_details')}}</div>
				<div class="text-lg font-medium text-theme-1 dark:text-theme-10 mt-2">{{$order->getUser->name}}</div>
				<div class="mt-1">{{$order->getUser->email}}</div>
				<div class="mt-1">{{$order->getUser->address_one}}</div>
			</div>
			<div class="lg:text-right mt-10 lg:mt-0 lg:ml-auto">
				<div class="text-base text-gray-600">{{__('common.payment_to')}}</div>
				<div class="text-lg font-medium text-theme-1 dark:text-theme-10 mt-2">{{env('APP_NAME','TRACESCI')}}</div>
			</div>
		</div>
	</div>
	<div class="px-5 sm:px-10 py-10 sm:py-10">
		<div class="overflow-x-auto">
			<table class="table">
				<thead>
					<tr>
						<th class="border-b-2 dark:border-dark-5 whitespace-nowrap">Label Size</th>
						<th class="border-b-2 dark:border-dark-5 text-right whitespace-nowrap">Material Type</th>
						<th class="border-b-2 dark:border-dark-5 text-right whitespace-nowrap">Quantity</th>
					</tr>
				</thead>
				@php
				$description = json_decode($order->getInvoice->description,true);
				$total = $order->getInvoice->amount_inr;
				@endphp

				@if (!empty($description))				
				<tbody>
					<tr>
						<td class="border-b dark:border-dark-5">
							{{$description['width']}} <sup>"</sup> x {{$description['height']}} <sup>"</sup> <br>
							From : {{$description['start_code_no']}}
						</td>
						<td class="text-right border-b dark:border-dark-5 w-32">
							{{$description['material_type_name']}}
						</td>
						<td class="text-right border-b dark:border-dark-5 w-32">
							{{number_format((int)$description['quantity'])??''}}
						</td>
					</tr>
				</tbody>
				@endif
			</table>
		</div>
	</div>
</div>
<!-- END: Order Invoice -->

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
					<p class="mb-1">Date : {{date('d-M-Y h:i:s A',strtotime($log->created_at))}}</p>
					<p class="mb-1">{{__('order.order_status')}} : 
						@if ($log->initial_status)
						{{__('order.order_status_changed').' '.__($log->initial_status).' '.__('order.to').' '.__($log->current_status)}}
						@else
						{{__($log->current_status)}}
						@endif
					</p>
					<p class="mb-1">{{__('common.remarks')}} : 
						{{$log->remarks}}
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
		async function add() {

			cash('#update-form').find('.form__input').removeClass('border-theme-6')
			cash('#update-form').find('.login__input-error').html('')

			var formData = new FormData(document.querySelector('#update-form'))

			cash('#btn-update').html('<i data-loading-icon="oval" data-color="white" class="w-5 h-5 mx-auto"></i>').svgLoader()

			axios.post('{{ url('/admin/qr-label-orders/'.encrypt($order->id).'/edit') }}', formData).then(res => {
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

		cash('#btn-update').on('click', function() {
			add()
		})
	})
</script>
@endsection


