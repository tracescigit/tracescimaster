@extends('vendor.layout.' . $layout)

@section('subhead')
<title>Report Detail - TRACESCI</title>
@endsection

@section('subcontent')

<div class="grid grid-cols-12 gap-6 mt-5">
	<div class="intro-y col-span-12 lg:col-span-12">
		<div class="intro-y box">
			<div class="flex flex-col sm:flex-row items-center px-7 py-5 border-b border-gray-200 dark:border-dark-5">
				<h2 class="font-medium text-base mr-auto">Report Detail</h2>
			</div>
			<div class="p-5">
				<div class="grid grid-cols-12">
					<div class="col-span-12 lg:col-span-4 px-2 py-1">
						{{__('common.product_name')}} : <span class="font-bold ml-2">{{$report->product_name??'-'}}</span>
					</div>
					<div class="col-span-12 lg:col-span-4 px-2 py-1">
						Product Serial No. : <span class="font-bold ml-2">{{$report->getCode->code_data??'-'}}</span>
					</div>

					<div class="col-span-12 lg:col-span-4 px-2 py-1">
						{{__('common.batch_code')}} : <span class="font-bold ml-2">{{$report->getCode->getBatch->code??'-'}}</span>
					</div>
					<div class="col-span-12 lg:col-span-4 px-2 py-1">
						{{__('report.issue_type')}} : <span class="font-bold ml-2">{{$report->issue_type??'-'}}</span>
					</div>
					<div class="col-span-12 lg:col-span-4 px-2 py-1 mt-2">
						{{__('report.reported_by')}} : <span class="font-bold ml-2">{{$report->getUser?($report->getUser->name??''):'-'}}</span>
					</div>
					<div class="col-span-12 lg:col-span-4 px-2 py-1 mt-2">
						{{__('common.created_on')}} : <span class="font-bold ml-2">{{date('M d, Y',strtotime($report->created_at))}}</span>
					</div>
				</div>
			</div>
			<hr>
			<div class="pl-5 pb-5 mb-4">
				<div class="grid grid-cols-12">
					<div class="col-span-12 lg:col-span-8 px-2 py-1 mt-2">
						Description : <p class="font-bold mt-1">{{$report->alert_message}}</p>	
					</div>

					<div class="col-span-6 lg:col-span-6 px-2 py-1">
						<form id="assign-form" class="col-span-12">
							<div class="col-span-12 mt-5">
								<div class="grid grid-cols-12">

									@csrf
									<div class="col-span-12 lg:col-span-12 mt-2">
										<label for="assigned_to" class="form-label">
											{{__('alert.assigned_to')}}
										</label>
										@if($report->manufacturer_assigned_to == null)
										<select id="assigned_to" type="text" name="assigned_to" class="form-select form__input">
											<option value="">Please Select</option>
											@if (getOperations(Auth::id()) && count(getOperations(Auth::id()))>0)
											@foreach (getOperations(Auth::id()) as $operation)
											<option value="{{$operation->id}}">{{$operation->name??''}}</option>
											@endforeach
											@endif

										</select>
										<div id="error-order_item" class="login__input-error w-auto text-theme-6"></div>
										@else
										<input type="text" name="assigned_to" value="{{$report->getAssignedToVendor->name}}" class="form__input form-control" readonly="">
										@endif
									</div>
								</div>
							</div>
						</form>
						<div class="mt-4 text-right">
							@if($report->manufacturer_assigned_to == null)
							<button type="button" class="btn btn-primary w-32 shadow-md ml-auto" id="submit">{{__('common.submit')}}</button>
							@endif
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="intro-y box mt-5">
			<div class="flex flex-col sm:flex-row items-center px-7 py-5 border-b border-gray-200 dark:border-dark-5">
				<h2 class="font-medium text-base mr-auto">Report Image</h2>
			</div>
			<div class="p-5">
				<div class="grid grid-cols-12">
					@if($report->image != '')
					<div class="col-span-12  lg:col-span-12 px-2 py-1 mt-2">
						<img src="{{$report->image}}">
					</div>
					@else
					<div class="col-span-12  lg:col-span-12 px-2 py-1 mt-2">
						<h4 class="text-red-600">Image not found !</h4>
					</div>
					@endif
				</div>
			</div>

			@if($report->manufacturer_assigned_to != null)
			<div class="intro-y col-span-12 lg:col-span-12 mt-0 p-5">
				<h5 class="my-3 font-bold">Investigation History</h5>

				<table class="table-auto">
					<thead>
						<tr>
							<th class="p-5 border border-dark-5 ">Reported On</th>
							<th class="p-5 border border-dark-5 ">Assigned To</th>
							<th class="p-5 border border-dark-5  text-center">Inspector Comments</th>
							<th class="p-5 border border-dark-5 ">Last Updated On</th>
							<th class="p-5 border border-dark-5 ">Status</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td class="p-5 border border-dark-5 text-center">{{	date('M d, Y',strtotime($report->created_at))}}</td>
							<td class="p-5 border border-dark-5 text-center">{{$report->getAssignedToVendor->name}}</td>
							<td class="p-5 border border-dark-5 text-center">{{$report->manufacturer_comment}}</td>
							<td class="p-5 border border-dark-5 text-center">{{	date('M d, Y',strtotime($report->updated_at))}}</td>
							<td class="p-5 border border-dark-5 text-center">{{ $report->status=='0'?'Open':'Closed'	}}</td>
						</tr>
					</tbody>
				</table>
			</div>
			@endif
		</div>
	</div>
</div>
<x-notification></x-notification>
@endsection

@section('script')
<script>
	cash(function () {
		async function add() {

			cash('#assign-form').find('.form__input').removeClass('border-theme-6')
			cash('#assign-form').find('.login__input-error').html('')

			var formData = new FormData(document.querySelector('#assign-form'))

			cash('#submit').html('<i data-loading-icon="oval" data-color="white" class="w-5 h-5 mx-auto"></i>').svgLoader()
			// await helper.delay(500)

			axios.post('{{ url('/vendor/reports/assign/'.$report->id) }}', formData).then(res => {
				cash('#submit').attr('disabled', 'true');
				showNotification('success','{{__('common.success')}} !',res.data.message)
				setTimeout(()=>{
					window.location.href = '{{ url('/vendor/reports') }}'
				},2000)

			}).catch(err => {
				showNotification('error','{{__('common.error')}} !',err.response.data.message)
				cash('#submit').html('{{__('common.submit')}}')                   

				if (err.response.data.errors) {
					for (const [key, val] of Object.entries(err.response.data.errors)){
						cash(`#${key}`).addClass('border-theme-6')
						cash(`#error-${key}`).html(val)
					}
				}

			})
		}

		cash('#assign-form').on('keyup', function(e) {
			if (e.keyCode === 13) {
				add()
			}
		})

		cash('#submit').on('click', function() {
			add()
		})
	})
</script>
@endsection