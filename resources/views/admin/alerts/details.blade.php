@extends('admin.layout.' . $layout)

@section('subhead')
<title>{{__('alert.alert_details')}} - TRACESCI</title>
@endsection

@section('subcontent')
@php

$location = json_decode($alert->location);
$lat=null;
$long=null;
@endphp

<div class="grid grid-cols-12 gap-6 mt-5">
	
	<div class="intro-y col-span-12 lg:col-span-12">
		<div class="intro-y box">
			<div class="flex flex-col sm:flex-row items-center px-7 py-5 border-b border-gray-200 dark:border-dark-5">
				<h2 class="font-medium text-base mr-auto">{{__('alert.alert_details')}}</h2>
			</div>
			<div class="p-5 mb-4 ">
				<div class="grid grid-cols-12 pb-10">
					<div class="intro-y col-span-12 lg:col-span-6">
						<div class="col-span-12 lg:col-span-3 items-center px-2 py-5 ">
							<h2 class="font-medium text-base mr-auto">{{__('common.product_details')}}</h2>
						</div>
						<div class="col-span-12 lg:col-span-3 px-2 py-1">
							{{__('common.product_name')}} : <span class="font-bold ml-2">{{$alert->getProduct->name??'-'}}</span>
						</div>

						<div class="col-span-12 lg:col-span-3 px-2 py-1">
							Product Serial No. : <span class="font-bold ml-2">{{$alert->getCode->code_data??'-'}}</span>
						</div>
						{{-- <div class="col-span-12 lg:col-span-3 px-2 py-1">
							{{__('common.batch_id')}} : <span class="font-bold ml-2">{{$alert->getBatch->id??'-'}}</span>
						</div> --}}
						<div class="col-span-12 lg:col-span-3 px-2 py-1">
							{{__('common.batch_code')}} : <span class="font-bold ml-2">{{$alert->getBatch->code??'-'}}</span>
						</div>
						@if(isset($alert->getBatch->mfg_date) && isset($alert->getBatch->exp_date))
						<div class="col-span-12 lg:col-span-3 px-2 py-1">
							{{__('common.manufactured_date')}} : <span class="font-bold ml-2">{{date('M d, Y',strtotime($alert->getBatch->mfg_date))??'-'}}</span>
						</div>
						<div class="col-span-12 lg:col-span-3 px-2 py-1">
							{{__('common.expiry_date')}} : <span class="font-bold ml-2">{{date('M d, Y',strtotime($alert->getBatch->exp_date))??'-'}}</span>
						</div>
						@endif
						<div class="col-span-12 lg:col-span-3 px-2 py-1">
							{{__('Product Status')}}: <span class="font-bold ml-2 {{$alert->getProduct?($alert->getProduct->status==0?'text-red-500':'text-green-500'):''}}">{{$alert->getProduct?($alert->getProduct->status==0?__('common.inactive'):__('common.active')):''}}</span>
						</div>

						<div class="col-span-12 lg:col-span-3 px-2 py-1">
							{{__('QR Code Status')}}: <span class="font-bold ml-2 {{$alert->getCode?($alert->getCode->status==0?'text-red-500':'text-green-500'):''}}">{{$alert->getCode?($alert->getCode->status==0?__('common.inactive'):__('common.active')):''}}</span>
						</div>

						<div class="col-span-12 lg:col-span-3 mt-5 px-2 py-1">
							{{__('scanhistory.scanned_by')}} : <span class="font-bold ml-2">{{$alert->getUser?($alert->getUser->phone??'-'):'-'}}</span>
						</div>
					</div>

					<div class="intro-y col-span-12 lg:col-span-6">
						<div class="col-span-12 lg:col-span-3 items-center px-2 py-5 ">
							<h2 class="font-medium text-base mr-auto">Manufacturer Details</h2>
						</div>

						<div class="col-span-12 lg:col-span-3 px-2 py-1">
							{{__('common.manufacturer_name')}} : <span class="font-bold ml-2">{{$alert->getProduct->getUser->getCompany->name??'-'}}</span>
						</div>

						<div class="col-span-12 lg:col-span-3 px-2 py-1">
							{{__('common.email')}} : <span class="font-bold ml-2">{{$alert->getProduct->getUser->email??'-'}}</span>
						</div>

						<div class="col-span-12 lg:col-span-3 px-2 py-1">
							{{__('common.mobile')}} : <span class="font-bold ml-2">{{$alert->getProduct->getUser->phone??'-'}}</span>
						</div>

						<div class="col-span-12 lg:col-span-3 px-2 py-1">
							Address : <span class="font-bold ml-2">{{$alert->getProduct->getUser->getCompany->address??'-'}}</span>
						</div>

						<div class="col-span-12 lg:col-span-3 px-2 py-1">
							City : <span class="font-bold ml-2">{{$alert->getProduct->getUser->getCompany->city??'-'}}</span>
						</div>

						<div class="col-span-12 lg:col-span-3 px-2 py-1">
							Country : <span class="font-bold ml-2">{{$alert->getProduct->getUser->getCompany->country??'-'}}</span>
						</div>

					</div>

					<div class="intro-y col-span-12 lg:col-span-6 ">
						<div class="grid grid-cols-12">
							@if($location && $location->lat && $location->long)
							@php
							$lat = $location->lat;
							$long = $location->long; 
							@endphp
							<div class="col-span-12  lg:col-span-12 px-2 py-1 mt-2">
								<div id="map" style="height:300px; width:100%;"></div>
							</div>
							@else
							<div class="col-span-12 lg:col-span-12 px-2 py-1 mt-2 text-red-500">
								{{__('scanhistory.location_not_found')}}!
							</div>
							@endif
						</div>
						<form id="assign-form" class="col-span-12">
							<div class="col-span-12 mt-5">
								<div class="grid grid-cols-12">

									@csrf
									<div class="col-span-12 lg:col-span-10 mt-2 px-2">
										@if($alert->admin_assigned_to != null || Auth::user()->who_you_are=='Province Governor')
										<label for="assigned_to" class="form-label">
											{{__('alert.assigned_to')}}
										</label>
										@endif
										
										@if($alert->admin_assigned_to == null)

										@if (Auth::user()->who_you_are=='Province Governor')

										<select id="assigned_to" type="text" name="assigned_to" class="form-select form__input">
											<option value="">{{__('common.please_select')}}</option>
											@if (getProvinceInspector($alert->id) && count(getProvinceInspector($alert->id))>0)
											@foreach (getProvinceInspector($alert->id) as $inspector)
											<option value="{{$inspector->id}}">{{$inspector->name??''}}</option>
											@endforeach
											@endif
										</select>
										<div id="error-order_item" class="login__input-error w-auto text-theme-6"></div>
										{{-- expr --}}
										@endif
										@else
										<input type="text" name="assigned_to" value="{{$alert->getAssignedToAdmin->name??""}}" class="form__input form-control" readonly="">
										@endif
									</div>
								</div>
							</div>
						</form>
						<div class="mt-4 text-right lg:mr-28 sm:mr-5 ">
							@if($alert->admin_assigned_to == null && Auth::user()->who_you_are=='Province Governor')
							<button type="button" class="btn btn-primary w-32 shadow-md ml-auto" id="submit">{{__('common.submit')}}</button>
							@endif
						</div>
					</div>
					@if($alert->admin_assigned_to != null)
					<div class="intro-y col-span-12 lg:col-span-12 mt-10 px-2">
						<h5 class="my-3 font-bold">Investigation History</h5>
						<table class="table-auto">
							<thead>
								<tr>
									<th class="p-5 border border-dark-5 ">Reported On</th>
									<th class="p-5 border border-dark-5 ">Assigned To</th>
									<th class="p-5 border border-dark-5  text-center">Inspector Comments</th>
									<th class="p-5 border border-dark-5 ">Last Updated On</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td class="p-5 border border-dark-5 text-center">{{	date('M d, Y',strtotime($alert->created_at))}}</td>
									<td class="p-5 border border-dark-5 text-center">{{$alert->getAssignedToAdmin->name??''}}</td>
									<td class="p-5 border border-dark-5 text-center">{{$alert->admin_comment}}</td>
									<td class="p-5 border border-dark-5 text-center">{{	date('M d, Y',strtotime($alert->updated_at))}}</td>
								</tr>
							</tbody>
						</table>
					</div>
					@endif
				</div>
			</div>
		</div>
	</div>
	<x-notification></x-notification>
</div>


@endsection

@section('script')

<script>
	let map;

	function initMap() {

		const mapOptions = {
			zoom: 4,
			center: { lat: 20.5937, lng: 78.9629 },
		};
		map = new google.maps.Map(document.getElementById("map"), mapOptions);
		const marker = new google.maps.Marker({
    // The below line is equivalent to writing:
    // position: new google.maps.LatLng(-34.397, 150.644)
    position: { lat:parseFloat('{{$lat}}') , lng: parseFloat('{{$long}}') },
    map: map,
  });
  // You can use a LatLng literal in place of a google.maps.LatLng object when
  // creating the Marker object. Once the Marker object is instantiated, its
  // position will be available as a google.maps.LatLng object. In this case,
  // we retrieve the marker's position using the
  // google.maps.LatLng.getPosition() method.
  const infowindow = new google.maps.InfoWindow({
  	content: "<p>Marker Location:" + marker.getPosition() + "</p>",
  });
  google.maps.event.addListener(marker, "click", () => {
  	infowindow.open(map, marker);
  });
}

cash(document).ready(function(){
	initMap();
});
</script>

<script>
	cash(function () {
		async function add() {

			cash('#assign-form').find('.form__input').removeClass('border-theme-6')
			cash('#assign-form').find('.login__input-error').html('')

			var formData = new FormData(document.querySelector('#assign-form'))

			cash('#submit').html('<i data-loading-icon="oval" data-color="white" class="w-5 h-5 mx-auto"></i>').svgLoader()
			// await helper.delay(500)

			axios.post('{{ url('/admin/alerts/assign/'.$alert->id) }}', formData).then(res => {
				cash('#submit').attr('disabled', 'true');
				showNotification('success','{{__('common.success')}} !',res.data.message)
				setTimeout(()=>{
					window.location.href = '{{ url('/admin/alerts') }}'
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