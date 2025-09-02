@extends('admin.layout.' . $layout)

@section('subhead')
<title>Printing Cost - TRACESCI</title>
@endsection

@section('subcontent')
<div class="intro-y flex items-center mt-8">
	<h2 class="text-lg font-medium mr-auto">Printing Cost</h2>
</div>
<div class="grid grid-cols-12 gap-6 mt-5">
	<div class="intro-y col-span-12 lg:col-span-12">
		<form id="add-form">
			@csrf
			<div class="intro-y box">
				<div class="flex flex-col sm:flex-row items-center px-7 py-5 border-b border-gray-200 dark:border-dark-5">
					<h2 class="font-medium text-base mr-auto">Cost details</h2>
				</div>
				<div class="p-5">

					<div class="grid grid-cols-12">

						<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-2">
							<label for="black_and_white" class="form-label w-full flex flex-col sm:flex-row">
								Black and White
							</label>
							<input id="black_and_white" type="number" name="black_and_white" class="form-control form__input" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" min="0" step="0.01" maxlength="10" placeholder="Enter price in INR" minlength="2" value="{{$cost->black_and_white??''}}" required>
							<div id="error-black_and_white" class="login__input-error w-5/6 text-theme-6"></div>
						</div>
						<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-2">
							<label for="black_and_white_price_usd" class="form-label w-full flex flex-col sm:flex-row">
								Price in usd
							</label>
							<input id="black_and_white_price_usd" type="number" name="black_and_white_price_usd" class="form-control form__input" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" min="0" step="0.01" maxlength="10" placeholder="Enter price in usd" minlength="2">
							<div id="error-price_usd" class="login__input-error w-5/6 text-theme-6"></div>
						</div>

						<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-2">
							<label for="color" class="form-label w-full flex flex-col sm:flex-row">
								Color
							</label>
							<input id="color" type="number" name="color" class="form-control form__input" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" min="0" step="0.01" maxlength="10" placeholder="Enter price in INR" minlength="2" value="{{$cost->color??''}}"  required>
							<div id="error-color" class="login__input-error w-5/6 text-theme-6"></div>
						</div>

						<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-2">
							<label for="color_price_usd" class="form-label w-full flex flex-col sm:flex-row">
								Price in usd
							</label>
							<input id="color_price_usd" type="number" name="color_price_usd" class="form-control form__input" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" min="0" step="0.01" maxlength="10" placeholder="Enter price in usd" minlength="2">
							<div id="error-price_usd" class="login__input-error w-5/6 text-theme-6"></div>
						</div>						
						<div class="input-form col-span-12 lg:col-span-12 px-2 py-1 mt-3">
							<button type="submit" id="btn-add" class="btn btn-primary w-full xl:w-32 xl:mr-3 align-top">Submit</button>
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
		async function add() {

			cash('#add-form').find('.form__input').removeClass('border-theme-6')
			cash('#add-form').find('.login__input-error').html('')

			var formData = new FormData(document.querySelector('#add-form'))

			cash('#btn-add').html('<i data-loading-icon="oval" data-color="white" class="w-5 h-5 mx-auto"></i>').svgLoader()
			cash('#btn-add').attr('disabled', 'true');

			axios.post('{{ url('/admin/printing-cost/create') }}', formData).then(res => {
				showNotification('success','Success !',res.data.message)
				setTimeout(()=>{
					window.location.href = '{{ url('/admin/printing-cost') }}'
				},1000)

			}).catch(err => {
				showNotification('error','Error !',err.response.data.message)
				cash('#btn-add').html('Submit')                   
				cash('#btn-add').removeAttr('disabled')                   

				if (err.response.data.errors) {
					for (const [key, val] of Object.entries(err.response.data.errors)){
						cash(`#${key}`).addClass('border-theme-6')
						cash(`#error-${key}`).html(val)
					}
				}

			})
		}

		cash('#add-form').on('submit', function(e) {
			e.preventDefault()
			add()
		})
	})
</script>
@endsection
