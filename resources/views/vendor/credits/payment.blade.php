@extends('vendor.layout.' . $layout)

@section('subhead')
<title>Checkout - TRACESCI</title>
@endsection

@section('subcontent')
<div class="intro-y flex flex-col sm:flex-row items-center mt-8">
	<h2 class="text-lg font-medium mr-auto">Checkout</h2>
</div>


<div class="grid grid-cols-12 gap-6 mt-4">
	<div class="col-span-12 lg:col-span-12 bg-white">
		<div class="pos__ticket p-5">
			<div class="col-span-12 lg:col-span-12 bg-gray-200 p-3 box">
				<p class="mb-2"><strong>Instructions:</strong></p>
				<p class="mb-0">Review all details before proceeding for payments.</p>
				<p class="mb-0">If you have any promo code , please use to avail benefits. Click on ‘Pay Now’.</p>
				<p class="mb-0">This will lead you to secure payment gateway, choose any of the payment option and do the payments.</p>
			</div>
		</div>
	</div>
</div>

<div class="pos intro-y grid grid-cols-12 gap-5">

	<div class="intro-y col-span-12 lg:col-span-8">
		<div class="grid grid-cols-12 gap-5 border-theme-5">
			<div class="intro-y col-span-12 lg:col-span-12">
				<div class="intro-y box flex flex-col lg:flex-row mt-5">
					<div class="intro-y flex-1 px-5 py-16 border">
						<i data-feather="credit-card" class="block w-12 h-12 text-theme-1 dark:text-theme-10 mx-auto"></i>
						<div class="text-xl font-medium text-center mt-10">{{$plan->title}}</div>
						<div class="text-gray-700 dark:text-gray-600 text-center mt-5">
							{{$plan->credits}} Credits
						</div>
						<div class="text-gray-600 dark:text-gray-400 px-10 text-center mx-auto mt-2">
							{!!$plan->description!!}
						</div>
						<div class="flex justify-center">
							<div class="relative text-5xl font-semibold mt-8 mx-auto">
								{{number_format((float)$plan->price_inr,2,'.','')}} <span class="absolute text-2xl top-0 right-0 text-gray-500 -mr-4 mt-1">&#8377;</span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="col-span-12 lg:col-span-4">

		<div class="tab-content">
			<div id="ticket" class="tab-pane active" role="tabpanel" aria-labelledby="ticket-tab">
				<div class="pos__ticket box p-2 mt-5">
					
					<a href="javascript:;" class="flex items-center p-3 cursor-pointer transition duration-300 ease-in-out bg-white dark:bg-dark-3 hover:bg-gray-200 dark:hover:bg-dark-1 rounded-md">
						<div class="pos__ticket__item-name truncate mr-1">{{ $plan->title }}</div> 
						<div class="text-gray-600">x 1</div>
						<div class="ml-auto font-medium">&#8377; {{number_format((float)$plan->price_inr,2,'.','')}}</div>
					</a>
					
				</div>
				<div class="box flex p-5 mt-5">
					<div class="w-full relative text-gray-700">
						<input id="offer_code" type="text" class="form-control py-3 px-4 w-full bg-gray-200 border-gray-200 pr-10 placeholder-theme-13" placeholder="Use offer code...">
						<div id="error-offer_code" class="login__input-error text-theme-6"></div>
					</div>
					<button class="btn btn-primary ml-2" id="fetch-offer">Apply</button>
				</div>

				<form id="checkout-form">
					@csrf
					<input type="hidden" id="plan_id" name="plan_id" value="{{encrypt($plan->id)}}" >
					<input type="hidden" id="subtotal" name="subtotal"  value="{{$plan->price_inr}}">
					<input type="hidden" id="offer_id" name="offer_id" >
					<input type="hidden" id="discount" name="discount" >
					<input type="hidden" id="total" name="total"  value="{{$plan->price_inr}}">
					<div class="box p-5 mt-5">
						<div class="flex">
							<div class="mr-auto">Price</div>
							<div class="font-medium">{{number_format((float)$plan->price_inr,2,'.','')}}</div>
						</div>
						<div class="flex mt-4">
							<div class="mr-auto">Discount</div>
							<div class="font-medium text-theme-6" id="discount-display">0</div>
						</div>
						<div class="flex mt-2" id="message">
							
						</div>

						<div class="flex mt-3">
							<div class="mr-auto">Subtotal</div>
							<div class="font-medium" id="total-display">{{number_format((float)$plan->price_inr,2,'.','')}}</div>
						</div>

						@if (igstApplicable(Auth::id())==true)
						<div class="flex mt-2">
							<div class="mr-auto">IGST ({{taxPercentage()}}%) </div>
							<div class="font-medium text-theme-6" id="igst-display">
								{{number_format((float)(gstAmount($plan->price_inr)-$plan->price_inr),2,'.','')}}
							</div>
						</div>
						@else
						<div class="flex mt-2">
							<div class="mr-auto">CGST ({{taxPercentage()/2}}%) </div>
							<div class="font-medium text-theme-6" id="cgst-display">
								{{number_format((float)(gstAmount($plan->price_inr)-$plan->price_inr)/2,2,'.','')}}
							</div>
						</div>

						<div class="flex mt-2">
							<div class="mr-auto">SGST ({{taxPercentage()/2}}%) </div>
							<div class="font-medium text-theme-6" id="sgst-display">
								{{number_format((float)(gstAmount($plan->price_inr)-$plan->price_inr)/2,2,'.','')}}
							</div>
						</div>
						@endif

						<div class="flex mt-4 pt-4 border-t border-gray-200 dark:border-dark-5">
							<div class="mr-auto font-medium text-base">Total Charge</div>
							<div class="font-medium text-base" id="payable-display">&#8377; {{number_format((float)gstAmount($plan->price_inr),2,'.','')}}</div>
						</div>
					</div>
					<div class="flex mt-5">
						<button  onclick="window.location.href='{{url('vendor/credits')}}'" class="btn w-32 border-gray-400 dark:border-dark-5 text-gray-600 dark:text-gray-300">Back to credits</button>
						<button type="button" class="btn btn-primary w-32 shadow-md ml-auto" id="pay-now">Pay now</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<x-notification></x-notification>

</div>
@endsection

@section('script')
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<script>

	function removeOffer(){
		var subtotal  = parseInt(cash('#subtotal').val());
		cash("#message").html('');
		cash("#offer_id").val('');
		cash("#discount").val('');
		cash("#total").val(+subtotal);
		cash("#total-display").html(subtotal);
		cash("#discount-display").html('0');
		cash('#offer_code').val('')
		applyTax(subtotal)
	}
	
	function fetch_offer() {

		cash('#offer_code').removeClass('border-theme-6')
		cash('.login__input-error').html('')

		cash('#fetch-offer').html('<i data-loading-icon="oval" data-color="white" class="w-5 h-5 mx-auto"></i>').svgLoader()

		axios.post('{{ url('/vendor/get-offer') }}', {offer_code:cash('#offer_code').val()}).then(res => {
			

			if(res.data.limit!=0){
				return applyOffer(res.data)
			}else{
				showNotification('error','Error !','Offer limit is exceeded. Please try again with another offer.')
				return removeOffer()
			}
			console.log(res)
		}).catch(err => {
			console.log(err)
			removeOffer()

			showNotification('error','Error !',err.response.data.message)
			cash('#fetch-offer').html('Apply')                   

			if (err.response.data.errors) {
				for (const [key, val] of Object.entries(err.response.data.errors)){
					cash(`#${key}`).addClass('border-theme-6')
					cash(`#error-${key}`).html(val)
				}
			}

		})
	}

	function applyOffer(offer) {
		var subtotal  = parseInt(cash('#subtotal').val());
		var total     = parseInt(cash('#total').val());
		var offertype = offer.type;
		var value     = offer.value;  
		var id        = offer.id; 
		var code      = offer.code; 


		cash("#message").html('');
		cash("#total").val('');
		cash("#offer_id").val('');
		cash("#discount").val('');

		cash('#fetch-offer').html('Apply')

		if (offertype=='1')
		{   				
			var discount = (subtotal*value/100)
			var final = (subtotal-discount); 

			cash("#total").val(+final);
			cash("#offer_id").val(+id);

			cash("#total-display").html(final);
			cash("#discount-display").html(discount);
			cash("#discount").val(discount);

			cash("#message").html('<span class="text-green-600 text-sm">Offer code '+code+' applied</span> <a onclick="removeOffer()" href="javascript:void(0);" class="text-red-900 float-right ml-auto">x remove</a>');

			cash("#offer_code").val(code);

			applyTax(final)

		}
		else
		{
			if(value<subtotal)
			{   
				var final = (subtotal-value);
				cash("#total").val(+final);
				cash("#offer_id").val(+id);

				cash("#total-display").html(final);
				cash("#discount-display").html(value);
				cash("#discount").val(value);

				cash("#message").html('<span class="text-green-600 text-sm">Offer code '+code+' applied</span> <a onclick="removeOffer()" href="javascript:void(0);" class="text-red-900 float-right ml-auto">x remove</a>');

				cash("#offer_code").val(code);   

				applyTax(final)           
			}
			else
			{   
				cash("#total").val(+subtotal);
				cash("#offer_id").val('');

				cash("#total-display").html(subtotal);
				cash("#discount-display").html('0');
				cash("#discount").val('');

				cash("#message").html('<span class="text-red-600 text-sm">Insufficient amount for this offer.</span>');

				applyTax(subtotal)
			}
		}
	}

	function applyTax(amount){
		var percent = {{taxPercentage()}};

		var igst = (amount*percent/100);
		var sgst = (amount*percent/100)/2;
		var cgst = (amount*percent/100)/2;

		var payable = Math.ceil(amount+(amount*percent/100));

		if(cash('#igst-display').length>0){
			cash('#igst-display').html(igst);
		}

		if(cash('#cgst-display').length>0){
			cash('#cgst-display').html(cgst);
		}

		if(cash('#sgst-display').length>0){
			cash('#sgst-display').html(sgst);
		}

		cash('#payable-display').html(payable);

	}

	function payNow() {

		cash('#pay-now').html('<i data-loading-icon="oval" data-color="white" class="w-5 h-5 mx-auto"></i>').svgLoader()

		var formData = new FormData(document.querySelector('#checkout-form'))

		axios.post('{{ url('/vendor/order') }}',formData).then(res => {
			console.log(res)	

			if(res.data.total>0) {
				var base_url = window.location.origin;
				var brandLogoUrl = "{{ asset('dist/images/logo.svg') }}";
				var totalpay = res.data.total;
				var order_id = res.data.order_id;
				var rzp1 = '';

				var  options = {
					"key": "{{ env('RAZOR_API_KEY','rzp_test_fXUNEbBJUlfaME') }}",
					"amount":Math.round(totalpay * 100),
					"name":"{{env('APP_NAME','TRACESCI')}}",
					"description": 'CREDIT'+res.data.order_id,
					"image": brandLogoUrl,
					"currency": "INR",
					"readonly": { 'email': true, 'contact': false },
					"handler": (response)=>{

						var razorpayId = response.razorpay_payment_id;

						if(razorpayId!=null){

							var orderData = {
								"_token"          : "{{ csrf_token() }}",
								"amount_paid"     : totalpay,
								"razorpayId"      : razorpayId,
								"order_id"        : order_id,
							}

							axios.post('{{ url('/vendor/transaction') }}', orderData).then(res => {
								showNotification('success','Payment success !','You successfully have purchased credits.')
								setTimeout(function(){
									window.location.href = '{{ url('vendor/buy-credits?page=success') }}'
								},1000)
							}).catch(err => {
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
			}
		}).catch(err => {
			console.log(err)
			showNotification('error','Error !','Something went wrong! Please try again.')
		})
	}

	cash('#fetch-offer').on('click', function() {
		fetch_offer()
	})

	cash('#pay-now').on('click', function() {
		payNow()
	})

</script>

@endsection

