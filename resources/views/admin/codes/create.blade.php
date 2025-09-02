@extends('admin.layout.' . $layout)

@section('subhead')
<title>Generate Code - TRACESCI</title>
@endsection

@section('subcontent')
<div class="intro-y flex flex-col sm:flex-row items-center mt-8">
	<h2 class="text-lg font-medium mr-auto">Generate Codes</h2>
</div>
<div class="pos intro-y grid grid-cols-12 gap-5">

	<div class="intro-y col-span-12 lg:col-span-12">
		<div class="grid grid-cols-12 gap-5 border-theme-5">
			<div class="intro-y col-span-12 lg:col-span-12 box mt-5">
				
				<div class="grid grid-cols-12">
					<h2 class="text-lg font-medium col-span-12 pt-5 px-5">Do you already have data to upload ?</h2>

					<h2 class="text-md col-span-12 mt-2 px-5">Download Sample File first and upload file should be in same format : <a class="btn btn-primary w-auto p-1 shadow-sm ml-auto float-right" href="{{ asset('samples/code_sample.xlsx') }}" download>Download Sample</a></h2>
					<form id="code-form" class="col-span-12">
						<div class="col-span-12 mt-5">
							<div class="grid grid-cols-12">

								@csrf
								<div class="col-span-12 lg:col-span-6 mt-2 px-5">
									<label for="product" class="form-label">
										Select product
									</label>
									<select id="product" type="text" name="product" class="form-select form__input">
										<option value="">Please select product</option>

										@if ($products && count($products)>0)
										@foreach ($products as $product)
										<option value="{{$product->id}}">{{$product->name}}</option>
										@endforeach
										@endif

									</select>
									<div id="error-product" class="login__input-error w-5/6 text-theme-6"></div>

								</div>

								<div class="col-span-12 lg:col-span-6 mt-2 px-5">
									<label for="batch" class="form-label">
										Batch
									</label>
									<input id="batch" type="text" name="batch" class="form-control form__input" placeholder="Enter batch" />
									<div id="error-batch" class="login__input-error w-5/6 text-theme-6"></div>

								</div>

								<div class="col-span-12 lg:col-span-12 mt-4 mb-5 px-5">
									<label for="file" class="form-label">
										File
									</label>
									<input id="file" type="file" name="file" class="form-control form__input" />
									<div id="error-file" class="login__input-error w-5/6 text-theme-6"></div>

								</div>

								<div class="col-span-12 lg:col-span-12 mt-0 mb-5 px-5">

									<div id="myProgress" style="width: 100%; background-color: #ddd; display: none;">
										<div id="myBar" style="  width: 1%;
										height: 30px;
										background-color: rgb(28 63 170);
										text-align: center;
										line-height: 30px;
										color: white;">0%</div>
									</div>

								</div>

							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<div class="col-span-12 lg:col-span-12">
		<div class="tab-content">
			<div  class="tab-pane active" role="tabpanel" aria-labelledby="ticket-tab">
				<div class="flex mt-5">
					<button  onclick="window.location.href='{{url('admin/codes')}}'" class="btn w-32 border-gray-400 dark:border-dark-5 text-gray-600 dark:text-gray-300">Back to codes</button>
					<button type="button" class="btn btn-primary w-32 shadow-md ml-auto" id="submit">Upload data</button>
				</div>
			</div>
		</div>
	</div>
	<x-notification></x-notification>
</div>

@endsection

@section('script')
<script>
	cash(function () {
		async function upload() {

			cash('#code-form').find('.form__input').removeClass('border-theme-6')
			cash('#code-form').find('.login__input-error').html('')

			var formData = new FormData(document.querySelector('#code-form'))

			cash('#submit').html('<i data-loading-icon="oval" data-color="white" class="w-5 h-5 mx-auto"></i>').svgLoader()

			var elem = document.getElementById("myBar");

			elem.style.width = 0 + "%";
			elem.innerHTML = 0  + "%";
			cash('#myProgress').hide();

			const config = {
				onUploadProgress: function(progressEvent) {
					cash('#myProgress').show();
					var percentCompleted = Math.round((progressEvent.loaded * 100) / progressEvent.total)
					elem.style.width = percentCompleted + "%";
					elem.innerHTML = percentCompleted  + "%";
				}
			}

			// await helper.delay(500)

			axios.post('{{ url('/admin/codes/create') }}', formData, config).then(res => {
				// cash('#submit').attr('disabled', 'true');
				showNotification('success','Success !',res.data.message)
				cash('#submit').html('Upload data')
				cash('#product').val('')
				cash('#file').val('')
				cash('#batch').val('')

				const method = 'GET';
				const url = '{{ url('/admin/codes/export') }}';
				
				axios.request({
					url,
					method,
					responseType: 'blob', 
				})
				.then(({ data }) => {
					const downloadUrl = window.URL.createObjectURL(new Blob([data]));
					const link = document.createElement('a');
					link.href = downloadUrl;
					link.setAttribute('download', 'code.xlsx'); 
					document.body.appendChild(link);
					link.click();
					link.remove();

					axios.get('{{ url('/admin/codes/mark-exported') }}', formData, config).then(res => {
						window.location.href = '{{ url('/admin/codes') }}'
					});

				});

			}).catch(err => {
				showNotification('error','Error !',err.response.data.message)
				cash('#submit').html('Upload data')                   

				if (err.response.data.errors) {
					for (const [key, val] of Object.entries(err.response.data.errors)){
						cash(`#${key}`).addClass('border-theme-6')
						cash(`#error-${key}`).html(val)
					}
				}

			})
		}

		// cash('#code-form').on('keyup', function(e) {
		// 	if (e.keyCode === 13) {
		// 		upload()
		// 	}
		// })

		cash('#submit').on('click', function() {
			upload()
		})
	})
</script>
@endsection