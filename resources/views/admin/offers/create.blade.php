@extends('admin.layout.' . $layout)

@section('subhead')
<title>Add Offer - TRACESCI</title>
@endsection

@section('subcontent')
<div class="intro-y flex items-center mt-8">
	<h2 class="text-lg font-medium mr-auto">Add New Offer</h2>
</div>
<div class="grid grid-cols-12 gap-6 mt-5">
	<div class="intro-y col-span-12 lg:col-span-12">
		<form id="add-form">
			@csrf
			<div class="intro-y box">
				<div class="flex flex-col sm:flex-row items-center px-7 py-5 border-b border-gray-200 dark:border-dark-5">
					<h2 class="font-medium text-base mr-auto">Offer details</h2>
				</div>
				<div class="p-5">

					<div class="grid grid-cols-12">

						<div class="input-form col-span-12 lg:col-span-6 px-2 py-1">
							<label for="title" class="form-label w-full flex flex-col sm:flex-row">
								Offer title
							</label>
							<input id="title" type="text" name="title" class="form-control form__input" placeholder="Enter title" minlength="2">
							<div id="error-title" class="login__input-error w-5/6 text-theme-6"></div>
						</div>

						<div class="input-form col-span-12 lg:col-span-6 px-2 py-1">
							<label for="code" class="form-label w-full flex flex-col sm:flex-row">
								Offer code
							</label>
							<input id="code" type="text" name="code" class="form-control form__input" placeholder="Enter code" minlength="2">
							<div id="error-code" class="login__input-error w-5/6 text-theme-6"></div>
						</div>

						<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-2">
							<label for="type" class="form-label w-full flex flex-col sm:flex-row">
								Type
							</label>
							<select id="type" name="type" class="form-select form__input">
								<option value="1">Percentage</option>
								<option value="0">Price</option>
							</select>
						</div>

						<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-2">
							<label for="value" class="form-label w-full flex flex-col sm:flex-row">
								Value
							</label>
							<input id="value" type="number" name="value" class="form-control form__input" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" min="1" step="1" maxlength="10" placeholder="Enter value" minlength="1">
							<div id="error-value" class="login__input-error w-5/6 text-theme-6"></div>
						</div>

						<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-2">
							<label for="user" class="form-label w-full flex flex-col sm:flex-row">
								Offer is available for
							</label>
							<select id="user" name="user" class="form-select form__input">
								<option value="">All users</option>
								@if (count($companies)>0)
								@foreach ($companies as $user)
								<option value="{{$user->id}}">{{$user->name}} ({{$user->email}})</option>
								@endforeach
								@endif
							</select>
						</div>


						<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-2">
							<label for="limit" class="form-label w-full flex flex-col sm:flex-row">
								Limit
							</label>
							<input id="limit" type="number" name="limit" class="form-control form__input" oninput="javascript: if (this.limit.length > this.maxLength) this.limit = this.limit.slice(0, this.maxLength);" min="1" step="1" maxlength="10" placeholder="Enter limit" minlength="1">
							<div id="error-limit" class="login__input-error w-5/6 text-theme-6"></div>
						</div>


						<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-2">
							<label for="status" class="form-label w-full flex flex-col sm:flex-row">
								Status
							</label>
							<select id="status" name="status" class="form-select form__input">
								<option value="1">Active</option>
								<option value="0">Inactive</option>
							</select>
						</div>

						<div class="input-form col-span-12 lg:col-span-12 px-2 py-1 mt-2">
							<label for="description" class="form-label w-full flex flex-col sm:flex-row">
								Offer description
							</label>
							<textarea id="description" rows="5" name="description" class="form-control form__input tinymce" placeholder="Enter description" minlength="2"></textarea>
							<div id="error-description" class="login__input-error w-5/6 text-theme-6"></div>
						</div>

						<div class="input-form col-span-12 lg:col-span-12 px-2 py-1 mt-3">
							<button type="submit" id="btn-add" class="btn btn-primary w-full xl:w-32 xl:mr-3 align-top">Add offer</button>
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

			axios.post('{{ url('/admin/offers/create') }}', formData).then(res => {
				
				showNotification('success','Success !',res.data.message)
				setTimeout(()=>{
					window.location.href = '{{ url('/admin/offers') }}'
				},1000)

			}).catch(err => {
				showNotification('error','Error !',err.response.data.message)
				cash('#btn-add').html('Add offer')  
				cash('#btn-add').removeAttr('disabled');                 

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
