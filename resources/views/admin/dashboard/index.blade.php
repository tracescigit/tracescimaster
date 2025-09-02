@extends('admin.layout.' . $layout)

@section('subhead')
<title>Dashboard - TRACESCI</title>
@endsection

@section('subcontent')
<div class="grid grid-cols-12 gap-6">

    <div class="col-span-12 xxl:col-span-9">
        <div class="grid grid-cols-12 gap-6">
            <!-- BEGIN: General Report -->
            <div class="col-span-12 mt-4">
                <div class="intro-y flex items-center h-10">
                    <h2 class="text-lg font-medium truncate mr-5">General Report</h2>
                    <a href="" class="ml-auto flex text-theme-1 dark:text-theme-10">
                        <i data-feather="refresh-ccw" class="w-4 h-4 mr-3"></i> Reload Data
                    </a>
                </div>
                <div class="grid grid-cols-12 gap-6 mt-1">

                    @if (Auth::user()->parent_id==null)
                    <div class="col-span-12 xxl:col-span-12">
                        <div class="grid grid-cols-12 gap-6">
                            @if ($pendingUsers>0)
                            <div class="col-span-12 mt-2 mb-0">
                                <x-alert class="warning text-sm p-2 mb-0" message="Pending Registration Approvals - {{$pendingUsers}}"></x-alert>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif

                    <div class="col-span-12 sm:col-span-4 xl:col-span-4 intro-y text-center">
                        <div class="report-box zoom-in" onclick="location.href='{{url('admin/codes')}}'">
                            <div class="box p-2 py-5 graph-box">
                                <div class="text-base mt-2">
                                    <h2 class="text-xl text-pink-700 font-medium">Total Codes this month</h2>
                                </div>
                                <div class="text-3xl font-bold leading-8 mt-1">
                                    {{getTotalQR()['total']}}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-span-12 sm:col-span-4 xl:col-span-4 intro-y text-center">
                        <div class="report-box zoom-in" onclick="location.href='{{url('admin/codes')}}'">
                            <div class="box p-2 py-5 graph-box">
                                <div class="text-base mt-2">
                                    <h2 class="text-xl text-pink-700 font-medium">Active Codes this month</h2>
                                </div>
                                <div class="text-3xl font-bold text-green-600 leading-8 mt-1">
                                    {{getTotalQR()['active']}}
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-span-12 sm:col-span-4 xl:col-span-4 intro-y text-center">
                        <div class="report-box zoom-in" onclick="location.href='{{url('admin/codes')}}'">
                            <div class="box p-2 py-5 graph-box">
                                <div class="text-base mt-2">
                                    <h2 class="text-xl text-pink-700 font-medium">Inactive Codes this month</h2>
                                </div>
                                <div class="text-3xl font-bold text-gray-400 leading-8 mt-1">
                                    {{getTotalQR()['inactive']}}
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="col-span-6 sm:col-span-6 xl:col-span-6 intro-y text-center">
                        <div class="report-box zoom-in" onclick="location.href='{{url('admin/codes')}}'">
                            <div class="box p-2">
                                <h2 class="text-xl text-red-400 font-medium">Products Seized
                                </h2>

                                <h3 class="text-small font-medium">
                                    <span class="text-medium">
                                        (<span class="text-pink-400">This month</span> / <span class="text-black-400">Total</span>)
                                    </span>
                                </h3>

                                <div class="font-bold leading-8">
                                    <span class="text-3xl text-pink-400">
                                        {{codesSeizedThisMonth()}}
                                    </span>
                                    <span class="text-3xl text-pink-400">/</span>
                                    <span class="text-3xl text-black-400">
                                        {{codesSeized()}}
                                    </span>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="col-span-6 sm:col-span-6 xl:col-span-6 intro-y text-center">
                        <div class="report-box zoom-in" onclick="location.href='{{url('admin/alerts')}}'">
                            <div class="box p-2">
                                <h2 class="text-xl text-blue-400 font-medium">No. of Open Cases
                                </h2>

                                <h3 class="text-small font-medium">
                                    <span class="text-medium">
                                        (<span class="text-blue-600">This month</span> / <span class="text-black-400">Total</span>)
                                    </span>
                                </h3>

                                <div class="font-bold leading-8">
                                    <span class="text-3xl text-blue-600">
                                        {{getReportAndAlertCount('month','0')['alerts'] + getReportAndAlertCount('month','0')['reports']}}
                                    </span>
                                    <span class="text-3xl text-blue-600">/</span>
                                    <span class="text-3xl text-black-400">
                                        {{getReportAndAlertCount(null,'0')['alerts'] + getReportAndAlertCount(null,'0')['reports']}}
                                    </span>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="col-span-6 sm:col-span-6 xl:col-span-6 intro-y text-center p-2 mb-3">
                        <div class="report-box zoom-in" onclick="location.href='{{url('admin/scanhistory')}}'">
                            <div class="box p-2">
                                <h2 class="text-xl text-blue-400 font-medium">No of Scans
                                </h2>

                                <h3 class="text-small font-medium">
                                    <span class="text-lg">
                                        (<span class="text-green-400">Consumer</span> / <span class="text-red-400">Authority</span>)
                                    </span>
                                </h3>

                                <div class="text-base mt-2">
                                    This month
                                </div>
                                <div class="font-bold leading-8">
                                    <span class="text-3xl text-green-400">
                                        {{getScansCount('month')['consumer']}}
                                    </span>
                                    <span class="text-3xl text-green-400">/</span>
                                    <span class="text-3xl text-red-400">
                                        {{getScansCount('month')['authority']}}
                                    </span>
                                </div>

                                <div class="text-base mt-2">
                                    Total
                                </div>
                                <div class="font-bold leading-8">
                                    <span class="text-3xl text-green-400">
                                        {{getScansCount()['consumer']}}
                                    </span>
                                    <span class="text-3xl text-green-400">/</span>
                                    <span class="text-3xl text-red-400">
                                        {{getScansCount()['authority']}}
                                    </span>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="col-span-6 sm:col-span-6 xl:col-span-6 intro-y text-center p-2 mb-3">
                        <div class="report-box zoom-in" onclick="location.href='{{url('admin/alerts')}}'">
                            <div class="box p-2">
                                <h2 class="text-xl text-red-400 font-medium">Alerts
                                </h2>

                                <h3 class="text-small font-medium">
                                    <span class="text-lg">
                                        (<span class="text-green-400">App Reports</span> / <span class="text-purple-400">Alerts</span>)
                                    </span>
                                </h3>

                                <div class="text-base mt-2">
                                    This month
                                </div>
                                <div class="font-bold leading-8">
                                    <span class="text-3xl text-green-400">
                                        {{getReportAndAlertCount('month')['reports']}}
                                    </span>
                                    <span class="text-3xl text-green-400">/</span>
                                    <span class="text-3xl text-purple-400">
                                        {{getReportAndAlertCount('month')['alerts']}}
                                    </span>
                                </div>

                                <div class="text-base mt-2">
                                    Total
                                </div>
                                <div class="font-bold leading-8">
                                    <span class="text-3xl text-green-400">
                                        {{getReportAndAlertCount()['reports']}}
                                    </span>
                                    <span class="text-3xl text-green-400">/</span>
                                    <span class="text-3xl text-purple-400">
                                        {{getReportAndAlertCount()['alerts']}}
                                    </span>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="col-span-12 sm:col-span-12 text-center p-2 intro-y">
                        <div class="report-box zoom-in">
                            <div class="box p-2">
                                <h2 class="text-lg font-medium">Scanned locations this month
                                </h2>
                                <div id="gmap" style="height:320px;">

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')

<script type="text/javascript">

    var locations = [
    @if (count(scanLocations())>0)
    @foreach(scanLocations() as $location)
    ['{{$location['user']}}', parseFloat("{{$location['lat']}}"), parseFloat("{{$location['long']}}")],
    @endforeach
    @endif
    ];

    var map = new google.maps.Map(document.getElementById('gmap'), {
        zoom: 3.5,
        center: new google.maps.LatLng(20.5937, 78.9629),
        mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    var infowindow = new google.maps.InfoWindow();

    var marker, i;

    for (i = 0; i < locations.length; i++) { 
        marker = new google.maps.Marker({
            position: new google.maps.LatLng(locations[i][1], locations[i][2]),
            map: map
        });

        google.maps.event.addListener(marker, 'click', (function(marker, i) {
            return function() {
              infowindow.setContent(locations[i][0]);
              infowindow.open(map, marker);
          }
      })(marker, i));
    }

</script>
@endsection
