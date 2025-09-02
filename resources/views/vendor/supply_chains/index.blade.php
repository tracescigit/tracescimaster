@extends('vendor.layout.' . $layout)

@section('subhead')
<title>Supply Chains - TRACESCI</title>
@endsection

@section('subcontent')
<div class="intro-y flex flex-col sm:flex-row items-center mt-8">
	<h2 class="text-lg font-medium mr-auto">Supply Chains</h2>
</div>

<div class="grid grid-cols-12">
	<div class="col-span-7 pr-2">
		<div class="intro-y box p-5 mt-5">
			<div class="grid grid-cols-12 gap-6">
				<div class="col-span-12 intro-y mt-1 mb-3">
					<input type="text" class="form-control" id="search" placeholder="Search" onkeyup="search()">
				</div>
			</div>

			<div class="col-span-12">
				<table class="table border-collapse border border-slate-400" id="table">
					<thead>
						<tr>
							<th>
								User Name <span class="float-right">Role</span>
							</th>
						</tr>
					</thead>
					<tbody>
						@php
						$role = 'none';
						@endphp
						@foreach ($users as $user)
						<tr>
							<td class="border border-slate-300">
								<a href="javascript:;" data-id="{{encrypt($user->id)}}" class="child-has-children closed">[+]</a>
								<a href="javascript:;" data-id="{{encrypt($user->id)}}" class="user-data">{{$user->name}}</a>
								<span class="float-right bg-red-800 text-white px-1" style="font-size: 10px;">{{strtoupper($user->who_you_are)}}</span>
								<a href="javascript:;" class="text-red-400 ml-2" data-toggle="modal" data-target="#delete-confirmation-modal" onclick="cash('#delete-confirmation-modal').find('#target').val('{{url('vendor/supply-chain-management/'.encrypt($user->id).'/destroy')}}')">(x)</a>
								<div class="grid grid-cols-12 children-area">
								</div>
							</td>
						</tr>
						@php
						$role = $user->who_you_are;
						@endphp
						@endforeach
						<tr>
							<td><a href="javascript:;" data-toggle="modal" data-target="#add-new-modal" class="bg-gray-200 p-2 add-new" data-role="{{$role}}" data-parent="">+ Add New</a></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="col-span-5 pl-2">
		<div class="intro-y box p-5 mt-5">
			<div class="grid grid-cols-12 gap-6">
				<div class="col-span-12 intro-y mt-1">
					<h2 class="text-lg font-medium mr-auto mb-4 text-center">Additional Info</h2>
				</div>
			</div>

			<div class="grid grid-cols-12 user-area" style="max-height: 300px; overflow-y: scroll;">
				<div class="col-span-12 text-center">Additional informations will come here</div>
			</div>
		</div>
	</div>
</div>
<x-notification></x-notification>
<x-supply_chain></x-supply_chain>
<x-delete-modal></x-delete-modal>
@endsection

@section('script')
<script>
	cash(function () {

		cash(document).on('click','.parent', function() {
			cash('.user-area').html('<div class="col-span-12 text-center">Additional informations will come here</div>')
			cash('.view-area').html('<div class="col-span-12"><h5 class="text-center">Please wait</h5></div>')
			var id = cash(this).data('id')
			axios.get(`{{ url('vendor/supply-chain-management') }}/${id}`).then(res => {
				cash('.view-area').html(res.data)
			}).catch(err => {
				showNotification('error','Error !',err.response.data.message)
				cash('.view-area').html('')
			})
		})

		cash(document).on('click','.child-has-children', function() {
			cash('.user-area').html('<div class="col-span-12 text-center">Additional informations will come here</div>')
			
			if(cash(this).hasClass('opened')){
				cash(this).html('[+]');
				cash(this).removeClass('opened');
				cash(this).addClass('closed');
				cash(this).parent().find('.children-area').html('')
			}else{
				cash(this).parent().find('.children-area').html('<div class="col-span-12"><h5 class="text-center">Please wait</h5></div>')
				var id = cash(this).data('id')
				axios.get(`{{ url('vendor/supply-chain-management') }}/${id}`).then(res => {
					cash(this).html('[-]');
					cash(this).removeClass('closed');
					cash(this).addClass('opened');
					cash(this).parent().find('.children-area').html(res.data)
				}).catch(err => {
					showNotification('error','Error !',err.response.data.message)
					cash(this).parent().find('.children-area').html('')
				})
			}
		})

		cash(document).on('click','.user-data', function() {
			cash('.user-data').removeClass('bg-gray-200')
			cash('.user-area').html('<div class="col-span-12"><h5 class="text-center">Please wait</h5></div>')
			var id = cash(this).data('id')
			cash(this).addClass('bg-gray-200')
			axios.get(`{{ url('vendor/supply-chain-management') }}/${id}/user-data`).then(res => {
				cash('.user-area').html(res.data)
			}).catch(err => {
				showNotification('error','Error !',err.response.data.message)
				cash('.user-area').html('<div class="col-span-12 text-center">Additional informations will come here</div>')
			})
		})

		async function action() {

			cash('#add-new-form').find('.form__input').removeClass('border-theme-6')
			cash('#add-new-form').find('.login__input-error').html('')

			var formData = new FormData(document.querySelector('#add-new-form'))

			cash('#add-new-button').html('<i data-loading-icon="oval" data-color="white" class="w-5 h-5 mx-auto"></i>').svgLoader()

			axios.post('{{ url('/vendor/supply-chain-management/create') }}', formData).then(res => {

				showNotification('success','Success !',res.data.message)

				setTimeout(()=>{
					window.location.reload()
				},1000)


			}).catch(err => {
				showNotification('error','Error !',err.response.data.message)
				cash('#add-new-button').html('Submit')                   

				if (err.response.data.errors) {
					for (const [key, val] of Object.entries(err.response.data.errors)){
						cash(`#${key}`).addClass('border-theme-6')
						cash(`#error-${key}`).html(val)
					}
				}

			})
		}

		cash('#add-new-button').on('click', function() {
			action()
		})

		cash(document).on('click','.add-new', function() {
			var role = cash(this).data('role')
			var parent = cash(this).data('parent')
			cash('#parent_id').val(parent)
			axios.get(`{{ url('vendor/supply-chain-management') }}/${role}/users?parent=${parent}`).then(res => {
				cash('#user').html(res.data)
			}).catch(err => {
				showNotification('error','Error !',err.response.data.message)
			})
		})

		async function del() {

			let url = cash('#target').val()

			if(!url){
				return false;
			}

			cash('#del-button').html('<i data-loading-icon="oval" data-color="white" class="w-5 h-5 mx-auto"></i>').svgLoader()

			let formData = {

			}

			axios.post(url, formData).then(res => {
				cash('#dismiss-modal').trigger('click')
				showNotification('success','Success !',res.data.message)
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
			del()
		})
	})

function search() {
	var input, filter, table, tr, td, i, txtValue;
	input = document.getElementById("search");
	filter = input.value.toUpperCase();
	table = document.getElementById("table");
	tr = table.getElementsByTagName("tr");

	for (i = 0; i < tr.length; i++) {
		td = tr[i].getElementsByTagName("td")[0];
		if (td) {
			txtValue = td.textContent || td.innerText;
			if (txtValue.toUpperCase().indexOf(filter) > -1) {
				tr[i].style.display = "";
			} else {
				tr[i].style.display = "none";
			}
		}
	}
}

</script>
@endsection

