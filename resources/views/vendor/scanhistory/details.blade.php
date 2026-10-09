@extends('vendor.layout.' . $layout)

@section('subhead')
<title>Scan History Details - TRACESCI</title>
@endsection

@section('subcontent')
@php
$location = json_decode($scandetail->location);
$lat=null;
$long=null;
@endphp

<div class="grid grid-cols-12 gap-6 mt-5">
	<div class="intro-y col-span-12 lg:col-span-12">
		<div class="intro-y box">
			<div class="flex flex-col sm:flex-row items-center px-7 py-5 border-b border-gray-200 dark:border-dark-5">
				<h2 class="font-medium text-base mr-auto">Scan History Details</h2>
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
						{{__('scanhistory.ip_address')}} : <span class="font-bold ml-2">{{$scandetail->ip_address??'-'}}</span>
					</div>
					<div class="col-span-12 lg:col-span-3 px-2 py-1">
						{{__('scanhistory.scanned_by')}} : <span class="font-bold ml-2">{{$scandetail->phone??'-'}}</span>
					</div>
					<div class="col-span-12 lg:col-span-3 px-2 py-1">
						{{__('common.batch_code')}} : <span class="font-bold ml-2">{{$scandetail->getCode->getBatch->code}}</span>
					</div>
					<div class="col-span-12 lg:col-span-3 px-2 py-1">
						{{__('scanhistory.scan_date')}} : <span class="font-bold ml-2">{{date('M d, Y',strtotime($scandetail->created_at))}}</span>
					</div>

					<div class="col-span-12 lg:col-span-3 px-2 py-1">
						{{__('scanhistory.scan_time')}} : <span class="font-bold ml-2">{{date('h:i A',strtotime($scandetail->created_at))}}</span>
					</div>

					<div class="col-span-12 lg:col-span-3 px-2 py-1">Genuine : <span class="font-bold ml-2">{{$scandetail->genuine=='1'?'Yes':'No'}}</span>
					</div>
				</div>
			</div>
		</div>

		<div class="intro-y box mt-5">
			<div class="flex flex-col sm:flex-row items-center px-7 py-5 border-b border-gray-200 dark:border-dark-5">
				<h2 class="font-medium text-base mr-auto">Scan Location</h2>
			</div>

			<div class="p-5">
				<div class="grid grid-cols-12">

					@php
					$locationData = (array) $location;
					dd($locationData);
					$lat = $locationData['lat'] ?? null;
					$long = $locationData['lng'] ?? $locationData['long'] ?? null;

					$city = $locationData['city'] ?? null;
					$region = $locationData['region'] ?? null;
					$country = $locationData['country'] ?? null;
					$source = $locationData['source'] ?? 'unknown';
					@endphp

					@if($lat !== null && $long !== null)

					{{-- Location Details --}}
					<div class="col-span-12 grid grid-cols-1 sm:grid-cols-3 gap-4">

						<div class="p-4 border border-gray-200 rounded">
							<div class="text-gray-500 text-sm">City</div>
							<div class="font-medium mt-1">
								{{ $city ?: 'Not available' }}
							</div>
						</div>

						<div class="p-4 border border-gray-200 rounded">
							<div class="text-gray-500 text-sm">State / Region</div>
							<div class="font-medium mt-1">
								{{ $region ?: 'Not available' }}
							</div>
						</div>

						<div class="p-4 border border-gray-200 rounded">
							<div class="text-gray-500 text-sm">Country</div>
							<div class="font-medium mt-1">
								{{ $country ?: 'Not available' }}
							</div>
						</div>

					</div>

					{{-- Source and Coordinates --}}
					<div class="col-span-12 text-gray-500 text-xs mt-3">
						Source: {{ strtoupper($source) }}
						| Coordinates: {{ $lat }}, {{ $long }}
					</div>

					{{-- Map --}}
					<div class="col-span-12 px-2 py-1 mt-3">
						<div id="map" style="height:400px; width:100%;"></div>
					</div>

					@else

					<div class="col-span-12 px-2 py-1 mt-2 text-red-500">
						Location Not Found!
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

		const latitude = parseFloat('{{$lat}}');
		const longitude = parseFloat('{{$long}}');

		const markerPosition = {
			lat: latitude,
			lng: longitude
		};

		const mapOptions = {
			zoom: 15,
			center: markerPosition,
		};

		map = new google.maps.Map(document.getElementById("map"), mapOptions);

		const marker = new google.maps.Marker({
			position: markerPosition,
			map: map,
		});

		const infowindow = new google.maps.InfoWindow({
			content: "<p>Marker Location: " + marker.getPosition() + "</p>",
		});

		google.maps.event.addListener(marker, "click", () => {
			infowindow.open(map, marker);
		});
	}

	cash(document).ready(function() {
		initMap();
	});
</script>
@endsection