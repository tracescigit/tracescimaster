@extends('vendor.layout.' . $layout)

@section('subhead')
<title>Bulk Upload - TRACESCI</title>
@endsection

@section('subcontent')
<div class="intro-y flex flex-col sm:flex-row items-center mt-8">
	<h2 class="text-lg font-medium mr-auto">Bulk Upload</h2>

	<div class="w-full sm:w-auto flex mt-4 sm:mt-0">
		<a href="javascript:void(0);" data-toggle="modal" data-target="#assign-modal" class="btn btn-primary shadow-md">Assign Product</a>
	</div>

</div>
<div class="pos intro-y grid grid-cols-12 gap-5">

	<div class="intro-y col-span-12 lg:col-span-12">
		<div class="grid grid-cols-12 gap-5 border-theme-5">
			<div class="intro-y col-span-12 lg:col-span-12 box mt-5">
				
				<div class="grid grid-cols-12">
					<h2 class="text-lg font-medium col-span-12 pt-5 px-5">Do you already have data to upload ?</h2>

					<h2 class="text-md col-span-12 mt-2 px-5">Download Sample File first and upload file should be in same format : <a class="btn btn-primary w-auto p-1 shadow-sm ml-auto float-right" href="{{ asset('samples/code_sample.csv') }}" download>Download Sample</a></h2>
					<form id="code-form" class="col-span-12">
						<div class="col-span-12 mt-5">
							<div class="grid grid-cols-12">
								@csrf
								<div class="col-span-12 lg:col-span-12 mt-4 mb-5 px-5">
									<label for="file" class="form-label">
										File
									</label>
									<input id="file" type="file" name="file" class="form-control form__input" />
									<div id="error-file" class="login__input-error w-auto text-theme-6"></div>
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
					<button  onclick="window.location.href='{{url('vendor/codes')}}'" class="btn w-32 border-gray-400 dark:border-dark-5 text-gray-600 dark:text-gray-300">Back to codes</button>
					<button type="button" class="btn btn-primary w-32 shadow-md ml-auto" id="submit">Upload data</button>
				</div>
			</div>
		</div>
	</div>
	<x-notification></x-notification>
	@include('vendor.codes.bulkassign')
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
			cash('#submit').attr('disabled', 'true');

			axios.post('{{ url('/vendor/bulk-upload') }}', formData).then(res => {
				showNotification('success','Success !',res.data.message)
				cash('#submit').html('Upload data')
				cash('#file').val('')
				cash('#submit').removeAttr('disabled');

				setTimeout(function(){
					window.location.href = '{{ url('vendor/bulk-upload') }}';
				},2000);
			}).catch(err => {
				showNotification('error','Error !',err.response.data.message)
				cash('#submit').html('Upload data')      
				cash('#submit').removeAttr('disabled');             

				if (err.response.data.errors) {
					for (const [key, val] of Object.entries(err.response.data.errors)){
						cash(`#${key}`).addClass('border-theme-6')
						cash(`#error-${key}`).html(val)
					}
				}

			})
		}

		cash('#submit').on('click', function(e) {
			upload();
		})

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

		async function assign() {

			cash('#assign-form').find('.form__input').removeClass('border-theme-6')
			cash('#assign-form').find('.login__input-error').html('')

			var formData = new FormData(document.querySelector('#assign-form'))

			cash('#assign-button').html('<i data-loading-icon="oval" data-color="white" class="w-5 h-5 mx-auto"></i>').svgLoader()

			axios.post('{{ url('/vendor/bulk-upload-assign') }}', formData).then(res => {
				cash('#assign-button').attr('disabled', 'true');
				showNotification('success','Success !',res.data.message)
				cash('#assign-button').html('Submit')
				cash('#assign-modal').modal('hide')
				
				setTimeout(()=>{
					window.location.href = '{{ url('/vendor/bulk-upload') }}'
				},1000)

			}).catch(err => {
				showNotification('error','Error !',err.response.data.message)
				cash('#assign-button').html('Submit')     
				cash('#assign-button').removeAttr('disabled');              

				if (err.response.data.errors) {
					for (const [key, val] of Object.entries(err.response.data.errors)){
						cash(`#${key}`).addClass('border-theme-6')
						cash(`#error-${key}`).html(val)
					}
				}

			})
		}

		cash('#assign-button').on('click', function() {
			assign()
		})
	})
</script>
@endsection