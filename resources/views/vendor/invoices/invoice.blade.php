@extends('vendor.layout.' . $layout)

@section('subhead')
<title>Invoice - TRACESCI</title>
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
			@if ($invoice->status=='1')
			<div class="float-right">
				<a href="{{ url('vendor/download-invoice/'.encrypt($invoice->id))}}"><button type="button" class="btn btn-rounded-primary">Download Invoice</button></a>	
			</div>
			@endif
			<div class="mt-2">
				Receipt : <span class="font-medium">{{prepareInvoiceId($invoice->id)}}</span>
			</div>
			<div class="mt-1">{{date('M d, Y',strtotime($invoice->updated_at))}}</div>
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
		<div class="text-center sm:text-right sm:mr-auto">
			@if ($invoice->status=='0')
			<button type="button" id="pay-now" class="btn btn-rounded-primary py-3 px-4 block mx-auto mt-8">PAY NOW</button>
			@else
			<button type="button" class="btn btn-rounded-success py-3 px-4 block mx-auto mt-8">PAID</button>
			@endif
		</div>

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
	<x-notification></x-notification>
	<x-delete-modal></x-delete-modal>
</div>
<!-- END: Invoice -->

@endsection

@section('script')
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
	cash('#pay-now').on('click', function() {
		var base_url = window.location.origin;
		var brandLogoUrl = "{{ asset('dist/images/logo.svg') }}";
		var totalpay = '{{$invoice->amount_inr}}';
		var order_id = '{{$invoice->id}}';
		var rzp1 = '';

		cash('#pay-now').html('<i data-loading-icon="oval" data-color="white" class="w-5 h-5 mx-auto"></i>').svgLoader()
		cash('#pay-now').attr('disabled',true);

		var  options = {
			"key": "{{ env('RAZOR_API_KEY','rzp_test_fXUNEbBJUlfaME') }}",
			"amount":Math.round(totalpay * 100),
			"name":"{{env('APP_NAME','TRACESCI')}}",
			"description": 'INVOICE'+order_id,
			"image": brandLogoUrl,
			"currency": "INR",
			"readonly": { 'email': true, 'contact': false },
			"handler": async (response)=>{

				var razorpayId = response.razorpay_payment_id;

				if(razorpayId!=null){

					var orderData = {
						"_token"          : "{{ csrf_token() }}",
						"amount_paid"     : totalpay,
						"razorpayId"      : razorpayId,
						"order_id"        : order_id,
					}

					axios.post('{{ url('/vendor/invoice-transaction') }}', orderData).then(res => {
						showNotification('success','Payment success !','You successfully have paid invoice.')
						setTimeout(function(){
							window.location.href = '{{ url('vendor/invoices') }}'
						},1000)
					}).catch(err => {
						cash('#pay-now').html('Pay Now');
						cash('#pay-now').removeAttr('disabled');
						showNotification('error','Error !','Something went wrong! Please try again.')
						setTimeout(function(){
							window.location.reload();
						},1000)

					})

				}
			},
			"prefill": {
				"name":"{{Auth::user()->name}}",
				"email":"{{Auth::user()->email}}",
				"contact":"{{Auth::user()->phone}}"
			},
			"theme": {
				"color": "#1c3faa"
			}
		};
		rzp1 = new Razorpay(options);
		rzp1.open();
	});

	cash(function () {
		async function remove() {

			let url = '{{ url('vendor/invoice-remove') }}'
			let plan_id = cash('#target').val()

			if(!url){
				return false;
			}

			cash('#del-button').html('<i data-loading-icon="oval" data-color="white" class="w-5 h-5 mx-auto"></i>').svgLoader()

			let formData = {
				invoice_id : '{{$invoice->id}}',
				plan_id
			}

			axios.post(url, formData).then(res => {
				cash('#dismiss-modal').trigger('click')
				
				if(res.data.status==true)
				{
					showNotification('success','Success !',res.data.message)
				}else{
					showNotification('error','Error !',res.data.message)
				}

				setTimeout(()=>{
					window.location.reload()
				},1000)

			}).catch(err => {
				cash('#dismiss-modal').trigger('click')
				showNotification('error','Error !',err.response.data.message)
				cash('#del-button').html('Delete')
			})
		}

		cash('#del-button').on('click', function() {
			remove()
		})
	})
</script>
@endsection

