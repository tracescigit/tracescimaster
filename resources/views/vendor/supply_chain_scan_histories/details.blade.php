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
						{{__('UNIQUE ID')}} : <span class="font-bold ml-2">{{$scandetail->aggregation_unique_id??'-'}}</span>
					</div>
					<div class="col-span-12 lg:col-span-3 px-2 py-1">
						{{__('scanhistory.ip_address')}} : <span class="font-bold ml-2">{{$scandetail->ip_address??'-'}}</span>
					</div>
					<div class="col-span-12 lg:col-span-3 px-2 py-1">
						{{__('scanhistory.scanned_by')}} : <span class="font-bold ml-2">{{$scandetail->getScannedBy->name??'-'}}</span>
					</div>
					<div class="col-span-12 lg:col-span-3 px-2 py-1">
						{{__('scanhistory.scan_date')}} : <span class="font-bold ml-2">{{date('M d, Y',strtotime($scandetail->created_at))}}</span>
					</div>
					<div class="col-span-12 lg:col-span-3 px-2 py-1">
						{{__('scanhistory.scan_time')}} : <span class="font-bold ml-2">{{date('h:i A',strtotime($scandetail->created_at))}}</span>
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
					@if($location && $location->lat && $location->long)
					@php
					$lat = $location->lat;
					$long = $location->long; 
					@endphp
					<div class="col-span-12  lg:col-span-12 px-2 py-1 mt-2">
						<div id="map" style="height:400px;"></div>
					</div>
					@else
					<div class="col-span-12 lg:col-span-12 px-2 py-1 mt-2 text-red-500">
						Location Not Found!
					</div>
					@endif
				</div>
			</div>
		</div>

		@if(!empty($journey) && count($journey)>0)

		<div class="intro-y box mt-5">
			<div class="flex flex-col sm:flex-row items-center px-7 py-5 border-b border-gray-200 dark:border-dark-5">
				<h2 class="font-medium text-base mr-auto">Journey</h2>
			</div>
			<div class="p-5">
				<div class="grid grid-cols-12">
					@foreach($journey as $key=>$detail)
					<div class="col-span-12 px-2 py-1 m-2 border-b">

						{{__('ACTION')}} : <span class="font-bold text-red-900 ml-2">{{$detail['action']?ucfirst($detail['action']):'-'}}</span><br>

						{{__('UNIQUE ID')}} : <span class="font-bold ml-2">{{$detail['code']??'-'}}</span><br>


						{{__('TYPE')}} : <span class="font-bold ml-2">{{$detail['type']??'-'}}</span><br>


						{{__('SCANNED AT')}} : <span class="font-bold ml-2">{{$detail['scanned_at']??''}}</span><br>


						{{__('SCANNED BY')}} : <span class="font-bold ml-2">{{$detail['scanned_by']??''}}</span><br>

					</div>
					@endforeach
				</div>
			</div>
		</div>		

		@endif
	</div>
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
@endsection