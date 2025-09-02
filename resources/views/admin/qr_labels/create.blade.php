@extends('vendor.layout.' . $layout)

@section('subhead')
<title>Order QR Labels - TRACESCI</title>
@endsection

@section('subcontent')
<div class="intro-y flex items-center mt-8">
	<h2 class="text-lg font-medium mr-auto">Order your labels</h2>
</div>
<div class="grid grid-cols-12 gap-6 mt-5">
	
	<div class="intro-y col-span-8 lg:col-span-8">
		<div class="intro-y box">
			<div class="p-5">

				<div class="grid grid-cols-12">

					<div class="col-span-12 intro-y">
						<div class="grid grid-cols-12">
							<div class="input-form col-span-12 lg:col-span-5">
								<label for="label_size" class="form-label w-full flex flex-col sm:flex-row">
									Step 1 : Select Label Size  (Inches)
								</label>
							</div>
							<div class="input-form col-span-12 lg:col-span-7">
								<select id="label_size" name="label_size" class="form-control form__input">
									<option value="">Please select</option>
									@if (count($label_sizes)>0)
									@foreach ($label_sizes as $label_size)
									<option value="{{$label_size->id}}">
										{{$label_size->width}}<sup>"</sup> x {{$label_size->height}}<sup>"</sup>
									</option>
									@endforeach
									@endif
									<option value="other">Other</option>

								</select>
								<div id="error-label_size" class="login__input-error w-5/6 text-theme-6"></div>
							</div>
						</div>
					</div>

					<div class="col-span-12 intro-y mt-2 other-div" style="display:none;">
						<div class="grid grid-cols-12">
							<div class="input-form col-span-12 lg:col-span-5">
							</div>
							<div class="input-form col-span-12 lg:col-span-7">
								<div class="grid grid-cols-12">
									<div class="col-span-6 pr-1">
										<input id="width" type="number" name="width" class="form-control form__input" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" min="1" step="1" maxlength="10" value="" placeholder="Width" minlength="1">
										<div id="error-width" class="login__input-error w-5/6 text-theme-6"></div>
									</div>
									<div class="col-span-6 pl-1">
										<input id="height" type="number" name="height" class="form-control form__input" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" min="1" step="1" maxlength="10" value="" placeholder="Height" minlength="1">
										<div id="error-height" class="login__input-error w-5/6 text-theme-6"></div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="col-span-12 intro-y mt-4">
						<div class="grid grid-cols-12">
							<div class="input-form col-span-12 lg:col-span-5">
								<label for="label_size" class="form-label w-full flex flex-col sm:flex-row">
									Or upload your design <br>(JPG/JPEG/PNG format only)
								</label>
							</div>
							<div class="input-form col-span-12 lg:col-span-7">
								<input id="image" type="file" name="image" class="form-control form__input" accept=".jpg,.jpeg,.png">
								<div id="error-image" class="login__input-error w-5/6 text-theme-6"></div>
							</div>
						</div>
					</div>

					<div class="col-span-12 intro-y mt-4">
						<div class="grid grid-cols-12">
							<div class="input-form col-span-12 lg:col-span-5">
								<label for="material_type" class="form-label w-full flex flex-col sm:flex-row">
									Step 2 : Select Material Type
								</label>
							</div>
							<div class="input-form col-span-12 lg:col-span-7">
								<select id="material_type" name="material_type" class="form-control form__input">
									<option value="">Please select</option>
									@if (count($material_types)>0)
									@foreach ($material_types as $material_type)
									<option value="{{$material_type->id}}">
										{{$material_type->type}}
									</option>
									@endforeach
									@endif

								</select>
								<div id="error-material_type" class="login__input-error w-5/6 text-theme-6"></div>
								<input type="hidden" name="material_cost" id="material_cost">
								<input type="hidden" name="material_gsm" id="material_gsm">
								<input type="hidden" name="black_and_white" id="black_and_white" value="{{$printing_cost->black_and_white}}">
								<input type="hidden" name="color" id="color" value="{{$printing_cost->color}}">
							</div>
						</div>
					</div>

					<div class="col-span-12 intro-y mt-4 codes-quantity-div">
						<div class="grid grid-cols-12">
							<div class="input-form col-span-12 lg:col-span-5">
								<label for="material_type" class="form-label w-full flex flex-col sm:flex-row">
									Step 3 : Start Code No.
								</label>
							</div>
							<div class="input-form col-span-12 lg:col-span-7">
								<input id="start_code_no" type="text" name="start_code_no" class="form-control form__input" placeholder="Please enter" >
								<div id="error-start_code_no" class="login__input-error w-5/6 text-theme-6"></div>
							</div>

							<div class="input-form col-span-12 lg:col-span-5 mt-2">
								<label for="material_type" class="form-label w-full flex flex-col sm:flex-row">
									No. of codes
								</label>
							</div>
							<div class="input-form col-span-12 lg:col-span-7 mt-2">
								<input id="quantity" type="number" name="quantity" class="form-control form__input" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" min="1" step="1" maxlength="10" value="" placeholder="Please enter" minlength="1">
								<input type="hidden" id="codes_ready" value="no">
								<div id="error-quantity" class="login__input-error w-5/6 text-theme-6"></div>
								<div id="codes-message" class="login__input-success w-5/6 text-green-600 codes-message"></div>
							</div>
						</div>
					</div>

					<div class="col-span-12 intro-y mt-8">
						<div class="grid grid-cols-12">
							<div class="input-form col-span-12 lg:col-span-5 mb-2">
								<input id="add_company_logo" type="checkbox" name="add_company_logo" class="form-check-input" onchange="cash('.eg-logo').toggle()">
								<label for="add_company_logo" class="form-check-label align-top">
									Add Company Logo
								</label>
							</div>

							<div class="input-form col-span-12 lg:col-span-7 mb-2">
								<input id="sr_no_below_2d_code" type="checkbox" name="sr_no_below_2d_code" class="form-check-input" onchange="cash('.eg-code-data').toggle()">
								<label for="sr_no_below_2d_code" class="form-check-label align-top">
									Sr. No. Below 2D Code
								</label>
							</div>

							<div class="input-form col-span-12 lg:col-span-5 mb-2">
								<input id="full_cmyk_color_print" type="checkbox" name="full_cmyk_color_print" class="form-check-input">
								<label for="full_cmyk_color_print" class="form-check-label align-top">
									Full CMYK Color Print
								</label>
							</div>
						</div>
					</div>

				</div>

			</div>
		</div>
	</div>

	<div class="intro-y col-span-4 lg:col-span-4">
		<div class="intro-y box">
			<div class="p-5">
				<div class="grid grid-cols-12">
					<div class="col-span-12">
						<div class="text-center">
							<h5 class="text-xl font-medium leading-tight mb-2 eg-logo" style="display: none;">
								<img src="{{ asset('dist/images/monotech.png') }}" class="w-32 mb-2 mx-auto"/>
							</h5>
							<img src="{{ asset('dist/images/eg-qr-code.png') }}" class="rounded-lg w-32 mb-2 mx-auto eg-code"/>
							<label class="eg-code-data" style="display: none;">0000000000</label>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="intro-y box mt-2">
			<div class="p-5">
				<div class="grid grid-cols-12">
					<div class="col-span-12">
						<label for="">Price / Label</label>
						<span class="price-per-label float-right">0</span>
						<input type="hidden" name="rate" id="price-per-label">
					</div>
					<div class="col-span-12 mt-2">
						<label for="">Subtotal</label>
						<span class="subtotal float-right">0</span>
						<input type="hidden" name="subtotal" id="subtotal">
					</div>
					<div class="col-span-12 mt-2">
						<label for="">GST (18%)</label>
						<span class="gst float-right">0</span>
						<input type="hidden" name="gst" id="gst">
					</div>
					<div class="col-span-12 mt-2">
						<label for="">Total Cost</label>
						<span class="total float-right">0</span>
						<input type="hidden" name="total" id="total">
					</div>
				</div>
			</div>
		</div>

		<div class="input-form col-span-12 lg:col-span-12 py-1 mt-3 text-right">
			<button type="button" id="pay-now" class="btn btn-primary w-full xl:w-32 align-top" style="display: none;">Pay Now</button>
		</div>
	</div>
	<x-notification></x-notification>
</div> 
@endsection

@section('script')
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>

	async function setQrImage(url=null){
		if(url){
			cash('.eg-code').attr('src',url)
		}else{
			cash('.eg-code').attr('src','{{asset('dist/images/eg-qr-code.png')}}')		
		}
	}

	cash('#label_size').on('change', async function(e) {
		var size = e.target.value;
		if(size!='other'){
			cash('.other-div').hide();
			fetchAndSetSizeParams(size);
		}else{
			cash('.other-div').show();
			resetSizeParams()
			calculatePrice()			
		}
		setQrImage()
	})

	async function resetSizeParams(){
		cash('#width').val('');
		cash('#height').val('');
	}

	async function fetchAndSetSizeParams(size){
		var formData = {
			'key'  :'label_size',
			'value':size
		};

		axios.post('{{ url('/vendor/qr-labels/resources') }}', formData).then(res => {
			if(res.data.url){
				setQrImage(res.data.url)
			}
			if(res.data.width){
				cash('#width').val(res.data.width);
			}
			if(res.data.height){
				cash('#height').val(res.data.height);
			}
			calculatePrice()
		}).catch(err => {
			resetSizeParams()
		})
	}

	cash('#width').on('change', async function(e) {
		calculatePrice()
	})

	cash('#height').on('change', async function(e) {
		calculatePrice()
	})

	cash('#image').on('change', async function(e) {
		var file = e.target.files[0];

		if(file){
			url = URL.createObjectURL(file);
			setQrImage(url)
		}else{
			setQrImage()
		}
	})

	cash('#material_type').on('change', async function(e) {
		var type = e.target.value;
		if(type){
			fetchAndSetMaterialParams(type);
		}else{
			resetMaterialParams()			
		}
	})

	async function resetMaterialParams(){
		cash('#material_cost').val('');
		cash('#material_gsm').val('');
	}

	async function fetchAndSetMaterialParams(type){
		var formData = {
			'key'  :'material_type',
			'value':type
		};

		axios.post('{{ url('/vendor/qr-labels/resources') }}', formData).then(res => {
			if(res.data.material_cost){
				cash('#material_cost').val(res.data.material_cost);
			}
			if(res.data.material_gsm){
				cash('#material_gsm').val(res.data.material_gsm);
			}
			calculatePrice()
		}).catch(err => {
			resetMaterialParams()
		})
	}

	cash('#quantity').on('blur', async function(e) {
		var quantity = e.target.value;
		var start_code_no = cash('#start_code_no').val()
		varifyCodesAndQuantity(start_code_no,quantity);
	})

	cash('#start_code_no').on('blur', async function(e) {
		var start_code_no = e.target.value;
		var quantity = cash('#quantity').val()
		varifyCodesAndQuantity(start_code_no,quantity);
	})

	async function resetCodesMessage(){
		cash('.codes-message').html('')
	}

	async function varifyCodesAndQuantity(start_code_no,quantity){

		cash('.codes-quantity-div').find('.form__input').removeClass('border-theme-6')
		cash('.codes-quantity-div').find('.login__input-error').html('')
		cash('.codes-quantity-div').find('.login__input-success').html('')

		resetCodesMessage()

		var formData = {
			'key'  : 'code',
			'value': start_code_no,
			'quantity':quantity
		};

		axios.post('{{ url('/vendor/qr-labels/resources') }}', formData).then(res => {
			cash('.codes-message').html(res.data.message)
			cash('#codes_ready').val('yes')
			calculatePrice()
		}).catch(err => {
			cash('#codes_ready').val('no')
			calculatePrice()
			if (err.response.data.errors) {
				for (const [key, val] of Object.entries(err.response.data.errors)){
					cash(`#${key}`).addClass('border-theme-6')
					cash(`#error-${key}`).html(val)
				}
			}
		})
	}

	cash('#full_cmyk_color_print').on('change', async function(e) {
		calculatePrice()
	})

	async function calculatePrice(){
		var width 			= parseFloat(cash('#width').val())
		var height 		    = parseFloat(cash('#height').val())
		var material_cost   = parseFloat(cash('#material_cost').val())
		var quantity        = parseFloat(cash('#quantity').val())
		var black_and_white = parseFloat(cash('#black_and_white').val())
		var color 			= parseFloat(cash('#color').val())
		var codes_ready 	= cash('#codes_ready').val()
		
		var cost = 0;

		if(cash('#full_cmyk_color_print').is(':checked')){
			cost = color
		}else{
			cost = black_and_white
		}

		if (width && height && material_cost && quantity && cost && codes_ready=='yes') {
			var A = height*width*material_cost*cost 
			var B = A*0.40
			var price_per_label = (A+B).toFixed(2)
			cash('.price-per-label').html(price_per_label)
			cash('#price-per-label').val(price_per_label)
			var subtotal = (price_per_label*quantity).toFixed(2) 
			cash('.subtotal').html(subtotal)
			cash('#subtotal').val(subtotal)
			var gst = (subtotal*0.18).toFixed(2) 
			cash('.gst').html(gst)
			cash('#gst').val(gst)
			var total = (eval(subtotal)+eval(gst)).toFixed(2)
			cash('.total').html(total)
			cash('#total').val(total)
			cash('#pay-now').show()
		}else{
			resetPricings()
		}
	}

	async function resetPricings(){
		cash('.price-per-label').html('0')
		cash('.subtotal').html('0')
		cash('.gst').html('0')
		cash('.total').html('0')
		cash('#price-per-label').val('')
		cash('#subtotal').val('')
		cash('#gst').val('')
		cash('#total').val('')
		cash('#pay-now').hide()
	}

	function makeid(length) {
		var result           = '';
		var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
		var charactersLength = characters.length;
		for ( var i = 0; i < length; i++ ) {
			result += characters.charAt(Math.floor(Math.random() * 
				charactersLength));
		}
		return result;
	}

	function payNow() {

		cash('#pay-now').html('<i data-loading-icon="oval" data-color="white" class="w-5 h-5 mx-auto"></i>').svgLoader()
		var total = parseFloat(cash('.total').html());

		var base_url = window.location.origin;
		var brandLogoUrl = "{{ asset('dist/images/logo.svg') }}";
		var totalpay = total;
		var order_id = makeid(5);
		var rzp1 = '';

		var  options = {
			"key": "{{ env('RAZOR_API_KEY','rzp_test_fXUNEbBJUlfaME') }}",
			"amount":Math.round(totalpay * 100),
			"name":"{{env('APP_NAME','TRACESCI')}}",
			"description": order_id,
			"image": brandLogoUrl,
			"currency": "INR",
			"readonly": { 'email': true, 'contact': false },
			"handler": (response)=>{

				var razorpayId = response.razorpay_payment_id;

				if(razorpayId!=null){

					var label_size 				= cash('#label_size').val();
					var width 	   				= cash('#width').val();
					var height     				= cash('#height').val();
					var material_type 			= cash('#material_type').val();
					var material_cost 			= cash('#material_cost').val();
					var material_gsm 			= cash('#material_gsm').val();
					var start_code_no 			= cash('#start_code_no').val();
					var quantity 				= cash('#quantity').val();
					var add_company_logo		= cash('#add_company_logo').val();
					var sr_no_below_2d_code 	= cash('#sr_no_below_2d_code').val();
					var full_cmyk_color_print 	= cash('#full_cmyk_color_print').val();
					var rate 					= cash('#price-per-label').val();
					var subtotal 				= cash('#subtotal').val();
					var gst 					= cash('#gst').val();
					var total 					= cash('#total').val();

					var formData = new FormData();
					var image = document.querySelector('#image');
					
					if(image.files[0]){
						formData.append("image", image.files[0]);
					}

					formData.append("label_size", label_size);
					formData.append("width", width);
					formData.append("height", height);
					formData.append("material_type", material_type);
					formData.append("material_cost", material_cost);
					formData.append("material_gsm", material_gsm);
					formData.append("start_code_no", start_code_no);
					formData.append("quantity", quantity);
					formData.append("add_company_logo", add_company_logo);
					formData.append("sr_no_below_2d_code", sr_no_below_2d_code);
					formData.append("full_cmyk_color_print", full_cmyk_color_print);
					formData.append("rate", rate);
					formData.append("subtotal", subtotal);
					formData.append("gst", gst);
					formData.append("total", total);
					formData.append("razorpayId", razorpayId);
					formData.append("rz_order_id", order_id);
					formData.append("_token", "{{ csrf_token() }}");
					// APi Call here
					
					axios.post('{{ url('/vendor/qr-labels/create') }}', formData, {
						headers: {
							'Content-Type': 'multipart/form-data'
						}
					}).then(res => {
						showNotification('success','Success !',res.data.message)
						setTimeout(()=>{
							window.location.href = '{{ url('/vendor/qr-labels') }}'
						},1000)

					}).catch(err => {
						showNotification('error','Error !',err.response.data.message)
						setTimeout(()=>{
							window.location.href = '{{ url('/vendor/qr-labels/create') }}'
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


	cash('#pay-now').on('click', function(e) {
		e.preventDefault()
		payNow()
	})
</script>
@endsection
