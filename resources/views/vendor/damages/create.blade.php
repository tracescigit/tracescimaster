@extends('vendor.layout.' . $layout)

@section('subhead')
<title>Report New TRACESCI</title>
@endsection

@section('subcontent')
<div class="intro-y flex items-center mt-8">
	<h2 class="text-lg font-medium mr-auto">Report New</h2>
</div>
<div class="col-span-12 lg:col-span-12 bg-white">
	<div class="pos__ticket mt-5 p-5">
		<div class="col-span-12 lg:col-span-12 bg-gray-200 p-3 box">
			<p class="mb-2 text-lg">Instructions: 
			</p>
			<p class="mb-2 text-md">
				Apply stamps on products carefully. Damaged stamps labels must be deactivated to avoid any misuse.<br>
				Brands should improve their process, if more than 1% cases of damage happens .<br>
			</p>
		</div>
	</div>
</div>

<div class="grid grid-cols-12 gap-6 mt-5">
	<div class="intro-y col-span-12 lg:col-span-12">
		<form id="damages-form">
			@csrf
			<div class="intro-y box">
				<div class="py-10 ml-3 ">
					<div class="grid grid-cols-12">

						<div class="col-span-6">
							<div class="grid grid-cols-12">
								<div class="input-form col-span-12 px-2 py-1">
									<label for="category" class="form-label w-full flex flex-col sm:flex-row">
										Report :
									</label>
									<select id="reason" name="reason" class="form-select form__input">
										<option value="Damaged Label">Damaged Labels</option>
										<option value="Lost/Stolen Label">Lost/Stolen Labels</option>
									</select>
								</div>

								<div class="input-form col-span-9 px-2 py-1 mt-2">
									<label for="stamp_sr_no" class="form-label w-full flex flex-col sm:flex-row required">
										Label Serial No 
									</label>
									<input id="stamp_sr_no" type="text" name="stamp_sr_no" class="form-control form__input" placeholder="{{__('common.enter')}} Label Serial No." minlength="2">
									<div id="error-stamp_sr_no" class="login__input-error w-5/6 text-theme-6"></div>
								</div>

								<div class="input-form col-span-3 px-2 mt-10 text-right">
									<button type="button" id="add-stamp" class="btn btn-warning" onclick="addLabel()">Add Label</button>
								</div>

								<div class="input-form col-span-12 lg:col-span-12 px-2 py-1 mt-10 text-right">
									{{-- <button type="button" class="btn btn-primary" onclick="printTable()">Print List</button> --}}
									<button type="button" id="submit" class="btn btn-primary ml-2" onclick="submitLot()">Submit Lot</button>
								</div>
							</div>

						</div>

						<div class="col-span-6">
							<div class="grid grid-cols-12">
								<div class="col-span-12 px-2 py-1" id="printable">
									<label for="category" class="form-label w-full flex flex-col sm:flex-row">
										Labels Selected :
									</label>

									<table id="stamps-table" class="table border"> 
										
									</table>
								</div>
							</div>
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

	let stamps = [];

	function addLabel(){

		cash('#damages-form').find('.form__input').removeClass('border-theme-6')
		cash('#damages-form').find('.login__input-error').html('')

		var formData = new FormData(document.querySelector('#damages-form'))

		cash('#add-stamp').html('<i data-loading-icon="oval" data-color="white" class="w-5 h-5 mx-auto"></i>').svgLoader()
		

		axios.post('{{ url('/vendor/check-stamps') }}', formData).then(res => {

			if(stamps.includes(res.data.stamp)){
				showNotification('error','{{__('common.error')}} !','Label is already added to this lot.')
				cash('#add-stamp').html('Add Label')
				return false;
			}
			else{
				stamps.push(res.data.stamp)
				cash('#add-stamp').html('Add Label')
				return displayTable()
			}

		}).catch(err => {
			showNotification('error','{{__('common.error')}} !',err.response.data.message)
			cash('#add-stamp').html('Add Label')                   

			if (err.response.data.errors) {
				for (const [key, val] of Object.entries(err.response.data.errors)){
					cash(`#${key}`).addClass('border-theme-6')
					cash(`#error-${key}`).html(val)
				}
			}

		})

	}

	function displayTable(){
		var html = "";
		for (var i = 0; i < stamps.length; i++) {
			html+="<tr>";
			html+="<td>"+stamps[i]+"</td>";
			html+="</tr>";

		}

		cash('#stamps-table').html(html);
	}	

	function printTable(){
		if (stamps.length>0) {
			var printContents = document.getElementById("printable").innerHTML;
			var originalContents = document.body.innerHTML;
			document.body.innerHTML = printContents;
			window.print();
			document.body.innerHTML = originalContents;
		}else{
			showNotification('error','{{__('common.error')}} !','Please add some stamps before printing.')
			return false;
		}
	}

	function submitLot(){
		if (stamps.length>0) {
			let reason = cash("#reason").val();
			let formData = {
				stamps,reason
			}

			cash('#submit').html('<i data-loading-icon="oval" data-color="white" class="w-5 h-5 mx-auto"></i>').svgLoader()

			axios.post('{{ url('/vendor/lost-damage/create') }}', formData).then(res => {
				showNotification('success','{{__('common.success')}} !',res.data.message)
				setTimeout(function(){
					window.location.reload();
				},1000)

				
			}).catch(err => {
				showNotification('error','{{__('common.error')}} !',err.response.data.message)
				cash('#submit').html('Submit Lot')
			})

		}else{
			showNotification('error','{{__('common.error')}} !','Please add some stamps before printing.')
			return false;
		}
	}

	cash('#damages-form').on('submit', function(e) {
		e.preventDefault();
	})

</script>


@endsection