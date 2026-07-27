@extends('admin.layout.' . $layout)

@section('subhead')
<title>{{__('scanhistory.scan_history_details')}} - TRACESCI</title>
@endsection

@section('subcontent')
@php
$location = json_decode($scandetail->location);

$lat = null;
$long = null;
$source = null;

if($location){
$lat = $location->lat ?? null;

// Support both old and new data
$long = $location->lng ?? $location->long ?? null;

$source = $location->source ?? 'gps';
}
@endphp

<div class="grid grid-cols-12 gap-6 mt-5">
	<div class="intro-y col-span-12 lg:col-span-12">
		<div class="intro-y box">
			<div class="flex flex-col sm:flex-row items-center px-7 py-5 border-b border-gray-200 dark:border-dark-5">
				<h2 class="font-medium text-base mr-auto">{{__('scanhistory.scan_history_details')}}</h2>
			</div>
			<div class="p-5 mb-4">
				<div class="grid grid-cols-12">
					<div class="col-span-12 lg:col-span-3 px-2 py-1">
						{{__('common.product_name')}} : <span class="font-bold ml-2">{{$scandetail->getCode->getProduct->name??'-'}}</span>
					</div>
					<div class="col-span-12 lg:col-span-3 px-2 py-1">
						Product Serial No. : <span class="font-bold ml-2">{{$scandetail->getCode->code_data??'-'}}</span>
					</div>
					<div class="col-span-12 lg:col-span-3 px-2 py-1">
						{{__('common.manufacturer_name')}}: <span class="font-bold ml-2">{{$scandetail->getCode->getProduct->getUser->getCompany->name??'-'}}</span>
					</div>
					<div class="col-span-12 lg:col-span-3 px-2 py-1">
						{{__('scanhistory.ip_address')}} : <span class="font-bold ml-2">{{$scandetail->ip_address??'-'}}</span>
					</div>
					<div class="col-span-12 lg:col-span-3 px-2 py-1">
						{{__('scanhistory.scanned_by')}} : <span class="font-bold ml-2">{{$scandetail->phone??'-'}}</span>
					</div>
					<div class="col-span-12 lg:col-span-3 px-2 py-1 mt-2">
						{{__('common.batch_code')}} : <span class="font-bold ml-2">{{$scandetail->getCode->getBatchData->code??'-'}}</span>
					</div>
					<div class="col-span-12 lg:col-span-3 px-2 py-1 mt-2">
						{{__('scanhistory.scan_date')}} : <span class="font-bold ml-2">{{date('M d, Y',strtotime($scandetail->created_at))}}</span>
					</div>

					<div class="col-span-12 lg:col-span-3 px-2 py-1 mt-2">
						{{__('scanhistory.scan_time')}} : <span class="font-bold ml-2">{{date('h:i A',strtotime($scandetail->created_at))}}</span>
					</div>
				</div>
			</div>
		</div>
		<div class="intro-y box mt-5">
			<div class="flex flex-col sm:flex-row items-center px-7 py-5 border-b border-gray-200 dark:border-dark-5">
				<h2 class="font-medium text-base mr-auto">{{__('scanhistory.scan_location')}}</h2>
			</div>
			<div class="p-5">
				<div class="grid grid-cols-12">

					@if($lat !== null && $long !== null)

					<div class="col-span-12 px-2 py-2">
						@if($source == 'ip')
						<span class="text-yellow-600 font-medium">
							📍 Approximate Location (Based on IP Address)
						</span>
						@else
						<span class="text-green-600 font-medium">
							📍 Exact GPS Location
						</span>
						@endif
					</div>

					<div class="col-span-12 lg:col-span-12 px-2 py-1 mt-2">
						<div id="map" style="height:400px;"></div>
					</div>

					@if($source == 'ip')
					<div class="col-span-12 mt-3 px-2">
						<strong>City :</strong> {{ $location->city ?? 'N/A' }}
					</div>

					<div class="col-span-12 px-2 mt-1">
						<strong>Region :</strong> {{ $location->region ?? 'N/A' }}
					</div>

					<div class="col-span-12 px-2 mt-1">
						<strong>Country :</strong> {{ $location->country ?? 'N/A' }}
					</div>

					<div class="col-span-12 px-2 mt-1">
						<strong>IP :</strong> {{ $location->ip ?? $scandetail->ip_address ?? 'N/A' }}
					</div>
					@endif

					@if($full_address)
					<div class="col-span-12 mt-3 px-2">
						<strong>Complete Address :</strong> {{ $full_address }}
					</div>
					@endif

					@else

					<div class="col-span-12 lg:col-span-12 px-2 py-1 mt-2 text-red-500">
						{{ __('scanhistory.location_not_found') }}!
					</div>

					@endif

				</div>
			</div>
		</div>
	</div>
</div>

@endsection

@section('script')

<script>
	let map;

	function initMap() {

		const latitude = parseFloat('{{ $lat }}');
		const longitude = parseFloat('{{ $long }}');

		const mapOptions = {
			zoom: {
				{
					$source == 'ip' ? 12 : 16
				}
			},
			center: {
				lat: latitude,
				lng: longitude
			},
		};

		map = new google.maps.Map(document.getElementById("map"), mapOptions);

		const marker = new google.maps.Marker({
			position: {
				lat: latitude,
				lng: longitude
			},
			map: map,
		});

		const infoWindow = new google.maps.InfoWindow({
			content: `{!! $source == 'ip'
                ? '<strong>Approximate Location (IP Based)</strong>'
                : '<strong>Exact GPS Location</strong>' !!}`
		});

		marker.addListener("click", function() {
			infoWindow.open(map, marker);
		});

		// Optional: Open the info window automatically
		infoWindow.open(map, marker);
	}

	cash(document).ready(function() {
		initMap();
	});
</script>
@endsection