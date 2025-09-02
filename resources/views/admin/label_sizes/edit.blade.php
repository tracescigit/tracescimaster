@extends('admin.layout.' . $layout)

@section('subhead')
<title>Update Label Sizes - TRACESCI</title>
@endsection

@section('subcontent')
<div class="intro-y flex items-center mt-8">
	<h2 class="text-lg font-medium mr-auto">Update Size</h2>
</div>
<div class="grid grid-cols-12 gap-6 mt-5">
	<div class="intro-y col-span-12 lg:col-span-12">
		<form id="update-form">
			@csrf
			<div class="intro-y box">
				<div class="flex flex-col sm:flex-row items-center px-7 py-5 border-b border-gray-200 dark:border-dark-5">
					<h2 class="font-medium text-base mr-auto">Size details</h2>
				</div>
				<div class="p-5">

					<div class="grid grid-cols-12">

						
						<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-2">
							<label for="width" class="form-label w-full flex flex-col sm:flex-row">
								Width (inches)
							</label>
							<input id="width" type="number" name="width" value="{{$label_size->width}}" class="form-control form__input" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" min="0" step="0.01" maxlength="10" placeholder="Enter width" minlength="2">
							<div id="error-width" class="login__input-error w-5/6 text-theme-6"></div>
						</div>

						<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-2">
							<label for="height" class="form-label w-full flex flex-col sm:flex-row">
								Height (inches)
							</label>
							<input id="height" type="number" name="height" value="{{$label_size->height}}" class="form-control form__input" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" min="0" step="0.01" maxlength="10" placeholder="Enter height" minlength="2">
							<div id="error-height" class="login__input-error w-5/6 text-theme-6"></div>
						</div>

						<div class="input-form col-span-12 lg:col-span-12 px-2 py-1 mt-2">
							<label for="file" class="form-label w-full flex flex-col sm:flex-row">
								Image
							</label>
							<input id="file" type="file" name="file" class="form-control form__input">
							<div id="error-file" class="login__input-error w-5/6 text-theme-6"></div>
						</div>

						@if ($label_size->image_url)
						<div class="input-form col-span-12 lg:col-span-12 px-2 py-1">
						</div>
						<div class="input-form col-span-12 lg:col-span-3 px-2 py-1 mt-3">
							<div class="h-40 relative image-fit cursor-pointer zoom-in mx-auto">
								<img class="rounded-md" alt="Image" src="{{ asset($label_size->image_url) }}">
							</div>
						</div>
						@endif

						<div class="input-form col-span-12 lg:col-span-12 px-2 py-1 mt-2">
							<label for="status" class="form-label w-full flex flex-col sm:flex-row">
								Status
							</label>
							<select id="status" name="status" class="form-select form__input">
								<option value="1" {{$label_size->status=='1'?'selected':''}}>Active</option>
								<option value="0" {{$label_size->status=='0'?'selected':''}}>Inactive</option>
							</select>
						</div>

						<div class="input-form col-span-12 lg:col-span-12 px-2 py-1 mt-3">
							<button type="submit" id="btn-update" class="btn btn-primary w-full xl:w-32 xl:mr-3 align-top">Update size</button>
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

			cash('#update-form').find('.form__input').removeClass('border-theme-6')
			cash('#update-form').find('.login__input-error').html('')

			var formData = new FormData(document.querySelector('#update-form'))

			cash('#btn-update').html('<i data-loading-icon="oval" data-color="white" class="w-5 h-5 mx-auto"></i>').svgLoader()
			cash('#btn-update').attr('disabled', 'true');

			axios.post('{{ url('/admin/label-sizes/'.encrypt($label_size->id).'/edit') }}', formData).then(res => {
				
				showNotification('success','Success !',res.data.message)
				setTimeout(()=>{
					window.location.reload()
				},1000)

			}).catch(err => {
				showNotification('error','Error !',err.response.data.message)
				cash('#btn-update').html('Update size')                   
				cash('#btn-update').removeAttr('disabled');

				if (err.response.data.errors) {
					for (const [key, val] of Object.entries(err.response.data.errors)){
						cash(`#${key}`).addClass('border-theme-6')
						cash(`#error-${key}`).html(val)
					}
				}

			})
		}

		cash('#update-form').on('submit', function(e) {
			e.preventDefault()
			add()			
		})
	})
</script>
@endsection
