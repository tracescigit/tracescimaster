@extends('admin.layout.' . $layout)

@section('subhead')
<title>Invoice - TRACESCI</title>
@endsection

@section('subcontent')
<div class="intro-y flex flex-col sm:flex-row items-center mt-8">
	<h2 class="text-lg font-medium mr-auto">{{__('order.order_invoice')}}</h2>
</div>
<!-- BEGIN: Order Invoice -->
<div class="intro-y box overflow-hidden mt-5" id="order">
	<div class="border-b border-gray-200 dark:border-dark-5 text-center sm:text-left">
		<div class="px-5 py-10 sm:px-10 sm:py-10">
			<div class="text-theme-1 dark:text-theme-10 font-semibold text-3xl">{{strtoupper(__('common.invoices'))}}</div>
			
			<div class="float-right">
				<a href="{{ url('admin/download-invoice/'.encrypt($invoice->id)) }}"><button type="button" class="btn btn-rounded-primary">{{__('order.download_invoice')}}</button></a>	
			</div>
			
			<div class="mt-2">
				{{__('order.receipt')}} <span class="font-medium">{{prepareInvoiceId($invoice->id)}}</span>
				@if(isset($invoice->getOrder))
				<br>
				{{__('order.payment_id')}} <span class="font-medium">#{{$invoice->getOrder->transaction_id}}</span>
				
				<br>
				{{__('common.dispatch_status')}} : <span class="font-medium {{$invoice->getOrder->getCurrentStatusText->title=='Pending'|| $invoice->getOrder->getCurrentStatusText->title =='Cancelled'?'text-red-500':'text-green-500'}}">{{__($invoice->getOrder->getCurrentStatusText->title)}}</span>
				@endif
			</div>
			<div class="mt-1">{{date('M d, Y',strtotime($invoice->created_at))}}</div>
		</div>
		<div class="flex flex-col lg:flex-row px-5 sm:px-10 pt-10 pb-10 ">
			<div>
				<div class="text-base text-gray-600">{{__('common.user_details')}}</div>
				<div class="text-lg font-medium text-theme-1 dark:text-theme-10 mt-2">{{$invoice->getUser->name}}</div>
				<div class="mt-1">{{$invoice->getUser->email}}</div>
				<div class="mt-1">{{$invoice->getUser->address_one}}</div>
			</div>
			<div class="lg:text-right mt-10 lg:mt-0 lg:ml-auto">
				<div class="text-base text-gray-600">{{__('common.payment_to')}}</div>
				<div class="text-lg font-medium text-theme-1 dark:text-theme-10 mt-2">{{env('APP_NAME','TRACESCI')}}</div>
			</div>
		</div>
	</div>
	<div class="px-5 sm:px-10 py-10 sm:py-10">
		<div class="overflow-x-auto">
			@if($invoice->type!='2')
			<table class="table">
				<thead>
					<tr>
						<th class="border-b-2 dark:border-dark-5 whitespace-nowrap">DESCRIPTION</th>
						<th class="border-b-2 dark:border-dark-5 text-right whitespace-nowrap">QTY</th>
						<th class="border-b-2 dark:border-dark-5 text-right whitespace-nowrap">PRICE</th>
						<th class="border-b-2 dark:border-dark-5 text-right whitespace-nowrap">SUBTOTAL</th>
					</tr>
				</thead>
				@php
				$description = json_decode($invoice->description,true);
				$total = 0;
				@endphp
				@if (!empty($description))				
				<tbody>
					@foreach ($description as $key=>$data)
					<tr>
						<td class="border-b dark:border-dark-5">
							<div class="font-medium whitespace-nowrap">{{$data['plan']??''}}</div>
							@if (isset($data['credits']) && $data['credits']!='')
							<div class="text-gray-600 text-xs whitespace-nowrap">Credits : {{$data['credits']??''}}</div>
							@endif
						</td>
						<td class="text-right border-b dark:border-dark-5 w-32">1</td>
						<td class="text-right border-b dark:border-dark-5 w-32">
							{{number_format((float)$data['price_inr'],2,'.','')??''}}
						</td>
						<td class="text-right border-b dark:border-dark-5 w-32">
							&#8377; {{number_format((float)$data['price_inr'],2,'.','')??''}} 
							@if ($data['type']!='0' && $invoice->status!='1')
							<a href="javascript:void(0)" data-toggle="modal" data-target="#delete-confirmation-modal" title="Remove this plan" class="remove ml-2 text-theme-6" onclick="cash('#delete-confirmation-modal').find('#target').val('{{$data['plan_id']}}')"> <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> 
							</a>
							@endif
						</td>
					</tr>
					@php
					$total+=$data['price_inr'];
					@endphp
					@endforeach
				</tbody>
				@endif
			</table>
			@else
			<table class="table">
				<thead>
					<tr>
						<th class="border-b-2 dark:border-dark-5 whitespace-nowrap">Label Size</th>
						<th class="border-b-2 dark:border-dark-5 text-right whitespace-nowrap">Material Type</th>
						<th class="border-b-2 dark:border-dark-5 text-right whitespace-nowrap">Price/Label</th>
						<th class="border-b-2 dark:border-dark-5 text-right whitespace-nowrap">Quantity</th>
						<th class="border-b-2 dark:border-dark-5 text-right whitespace-nowrap">SUBTOTAL</th>
					</tr>
				</thead>
				@php
				$description = json_decode($invoice->description,true);
				$total = $invoice->amount_inr;
				@endphp
				@if (!empty($description))				
				<tbody>
					<tr>
						<td class="border-b dark:border-dark-5">
							{{$description['width']}} <sup>"</sup> x {{$description['height']}} <sup>"</sup> 
						</td>
						<td class="text-right border-b dark:border-dark-5 w-32">
							{{$description['material_type_name']}}
						</td>
						<td class="text-right border-b dark:border-dark-5 w-32">
							{{number_format((float)$description['rate'],2,'.','')??''}}
						</td>
						<td class="text-right border-b dark:border-dark-5 w-32">
							{{number_format((float)$description['quantity'],2,'.','')??''}}
						</td>
						<td class="text-right border-b dark:border-dark-5 w-32">
							{{number_format((float)$description['subtotal'],2,'.','')??''}}
						</td>
					</tr>
				</tbody>
				@endif
			</table>
			@endif
		</div>
	</div>
	<div class="px-5 sm:px-10 pb-10 sm:pb-20 flex flex-col-reverse sm:flex-row">

		<div class="text-center sm:text-right sm:ml-auto">
			@if($invoice->type!='2')

			<div class="text-center sm:text-right sm:ml-auto">
				<div class="mt-1 tetx-sm">Amount :&#8377; {{number_format((float)$total,2,'.','')}}</div>
				<div class="mt-1 tetx-sm">Subtotal : &#8377; {{number_format((float)$total,2,'.','')}}</div>

				@if ($invoice->igst && $invoice->igst>0)			
				<div class="mt-1 tetx-sm">IGST({{$invoice->igst}}%) :{{number_format((float)($invoice->amount_inr - $total),2,'.','')}}</div>
				@else			
				<div class="mt-1 tetx-sm">CGST({{$invoice->cgst}}%) :{{number_format((float)($invoice->amount_inr - $total)/2,2,'.','')}}</div>
				<div class="mt-1 tetx-sm">SGST({{$invoice->sgst}}%) :{{number_format((float)($invoice->amount_inr - $total)/2,2,'.','')}}</div>
				@endif

				<div class="text-base text-gray-600 mt-3">Total Amount</div>
				<div class="text-xl text-theme-1 dark:text-theme-10 font-medium mt-2">&#8377; {{number_format((float)$invoice->amount_inr,2,'.','')}}</div>
			</div>
			@else
			<div class="mt-1 tetx-sm">Subtotal : &#8377; {{number_format((float)$description['subtotal'],2,'.','')}}</div>

			@if ($invoice->igst && $invoice->igst>0)			
			<div class="mt-1 tetx-sm">IGST({{$invoice->igst}}%) :{{number_format((float)($invoice->amount_inr - $description['subtotal']),2,'.','')}}</div>
			@else			
			<div class="mt-1 tetx-sm">CGST({{$invoice->cgst}}%) :{{number_format((float)($invoice->amount_inr - $description['subtotal'])/2,2,'.','')}}</div>
			<div class="mt-1 tetx-sm">SGST({{$invoice->sgst}}%) :{{number_format((float)($invoice->amount_inr - $description['subtotal'])/2,2,'.','')}}</div>
			@endif

			<div class="text-base text-gray-600 mt-3">Total Amount</div>
			<div class="text-xl text-theme-1 dark:text-theme-10 font-medium mt-2">&#8377; {{number_format((float)$invoice->amount_inr,2,'.','')}}</div>
			@endif
		</div>
	</div>
</div>
<!-- END: Order Invoice -->

@endsection


