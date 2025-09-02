@extends('vendor.layout.' . $layout)

@section('subhead')
<title>Credit Invoice - TRACESCI</title>
@endsection

@section('subcontent')
<div class="intro-y flex flex-col sm:flex-row items-center mt-8">
	<h2 class="text-lg font-medium mr-auto">Invoice</h2>
	{{-- <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
		<button class="btn btn-primary shadow-md" onclick="printInvoice()">Print</button>
	</div> --}}
</div>
<!-- BEGIN: Invoice -->
<div class="intro-y box overflow-hidden mt-5" id="invoice">
	<div class="border-b border-gray-200 dark:border-dark-5 text-center sm:text-left">
		<div class="px-5 py-10 sm:px-10 sm:py-10">
			<div class="text-theme-1 dark:text-theme-10 font-semibold text-3xl">INVOICE</div>
			<div class="mt-2">
				Receipt : <span class="font-medium">{{prepareInvoiceId($credit->getInvoice->id)}}</span>
			</div>
			<div class="mt-1">{{date('M d, Y',strtotime($credit->updated_at))}}</div>
		</div>
		<div class="flex flex-col lg:flex-row px-5 sm:px-10 pt-10 pb-10 ">
			<div>
				<div class="text-base text-gray-600">User Details</div>
				<div class="text-lg font-medium text-theme-1 dark:text-theme-10 mt-2">{{Auth::user()->name}}</div>
				<div class="mt-1">{{Auth::user()->email}}</div>
				<div class="mt-1">{{Auth::user()->address_one}}</div>
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
						<th class="border-b-2 dark:border-dark-5 text-right whitespace-nowrap">PRICE</th>
						<th class="border-b-2 dark:border-dark-5 text-right whitespace-nowrap">SUBTOTAL</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class="border-b dark:border-dark-5">
							<div class="font-medium whitespace-nowrap">{{$credit->plan_name??''}}</div>
							<div class="text-gray-600 text-xs whitespace-nowrap">Credits : {{$credit->credits??''}}</div>
						</td>
						<td class="text-right border-b dark:border-dark-5 w-32">1</td>
						<td class="text-right border-b dark:border-dark-5 w-32">{{number_format((float)$credit->amount,2,'.','')}}</td>
						<td class="text-right border-b dark:border-dark-5 w-32 font-medium">&#8377; {{number_format((float)$credit->amount,2,'.','')}}</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	<div class="px-5 sm:px-10 pb-10 sm:pb-20 flex flex-col-reverse sm:flex-row">
		<div class="text-center sm:text-right sm:ml-auto">
			<div class="mt-1 tetx-sm">Amount :&#8377; {{number_format((float)$credit->amount,2,'.','')}}</div>
			
			@if($credit->getOffer)
			<div class="mt-1 tetx-sm">Discount : {{$credit->amount-$credit->discounted_amount}}</div>
			<div class="mt-1 tetx-sm">Offer Applied : {{$credit->getOffer->code}}</div>
			@endif

			@php
			$taxable = $credit->discounted_amount??$credit->amount;
			@endphp
			<div class="mt-1 tetx-sm">Subtotal : &#8377; {{number_format((float)$taxable,2,'.','')}}</div>

			@if ($credit->igst && $credit->igst>0)			
			<div class="mt-1 tetx-sm">IGST({{$credit->igst}}%) :{{number_format((float)($credit->payable - $taxable),2,'.','')}}</div>
			@else			
			<div class="mt-1 tetx-sm">CGST({{$credit->cgst}}%) :{{number_format((float)($credit->payable - $taxable)/2,2,'.','')}}</div>
			<div class="mt-1 tetx-sm">SGST({{$credit->sgst}}%) :{{number_format((float)($credit->payable - $taxable)/2,2,'.','')}}</div>
			@endif	

			<div class="text-base text-gray-600 mt-3">Total Amount</div>
			<div class="text-sm text-theme-1 dark:text-theme-10 font-medium mt-1">&#8377; {{number_format((float)$credit->payable,2,'.','')}}</div>
			
		</div>
	</div>
</div>
<!-- END: Invoice -->

@endsection

@section('script')
<script>

</script>
@endsection

