@extends('vendor.layout.' . $layout)

@section('subhead')
<title>Dashboard - TRACESCI</title>
@endsection

@section('subcontent')
<div class="grid grid-cols-12 gap-6">
    <div class="col-span-12 xxl:col-span-9">
        <div class="grid grid-cols-12 gap-6">

            @if (Auth::user()->active=='1' && paymentReminder(Auth::id())['critical']==0)
            @if(paymentReminder(Auth::id())['count']>0)
            <div class="col-span-12 mt-8">
                <x-alert class="danger" message="You have pending invoices to pay. Pay before due date to enjoy our uninterrupted services."></x-alert>
            </div>
            @endif
            <div class="col-span-12 {{paymentReminder(Auth::id())['count']>0?'mt-0':'mt-8'}}">
                <div class="intro-y flex items-center h-10">
                    <h2 class="text-lg font-medium truncate mr-5">General Report</h2>
                    <a href="" class="ml-auto flex text-theme-1 dark:text-theme-10">
                        <i data-feather="refresh-ccw" class="w-4 h-4 mr-3"></i> Reload Data
                    </a>
                </div>
                <div class="grid grid-cols-12 gap-6 mt-5">

                    <div class="col-span-12 lg:col-span-3 intro-y mt-3">
                        <div class="report-box zoom-in">
                            <div class="box p-5">
                                <div class="flex">
                                    <i data-feather="credit-card" class="report-box__icon text-theme-10"></i>

                                </div>
                                <div class="text-3xl font-bold leading-8 mt-6">
                                    @if (Auth::user()->getSubscription)
                                    {{Auth::user()->getSubscription->plan_name}}
                                    @else
                                    No active plans
                                    @endif
                                </div>
                                <div class="text-base text-gray-600 mt-1">Current Plan</div>
                            </div>
                        </div>
                    </div>

                    <div class="col-span-12 lg:col-span-3 intro-y mt-3">
                        <div class="report-box zoom-in">
                            <div class="box p-5">
                                <div class="flex">
                                    <i data-feather="credit-card" class="report-box__icon text-theme-10"></i>

                                </div>
                                <div class="text-3xl font-bold leading-8 mt-6">
                                    {{getAvailableCredits(Auth::id())}}
                                </div>
                                <div class="text-base text-gray-600 mt-1">Available Credits</div>
                            </div>
                        </div>
                    </div>

                    <div class="col-span-12 lg:col-span-3 intro-y mt-3">
                        <div class="report-box zoom-in">
                            <div class="box p-5">
                                <div class="flex">
                                    <i data-feather="credit-card" class="report-box__icon text-theme-10"></i>

                                </div>
                                <div class="text-3xl font-bold leading-8 mt-6">{{getUsedCredits(Auth::id())}}</div>
                                <div class="text-base text-gray-600 mt-1">Used Credits</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-span-12 lg:col-span-3 intro-y mt-3">
                        <div class="report-box zoom-in">
                            <div class="box p-5">
                                <div class="flex">
                                    <i data-feather="credit-card" class="report-box__icon text-theme-10"></i>

                                </div>
                                <div class="text-3xl font-bold leading-8 mt-6">{{getLatestCreditAmount(Auth::id())}}</div>
                                <div class="text-base text-gray-600 mt-1">Latest Credit</div>
                            </div>
                        </div>
                    </div>

                    <div class="col-span-12 sm:col-span-4 xl:col-span-4 intro-y text-center">
                        <div class="report-box zoom-in" onclick="location.href='{{url('vendor/codes')}}'">
                            <div class="box p-5 mini-graph-box">
                                <div class="text-base text-xl mt-2">
                                    Total Codes
                                </div>
                                <div class="text-3xl font-bold leading-8 mt-1">
                                    {{getTotalQR(Auth::user()->parent_id??Auth::id())['total']}}
                                </div>

                                <div class="text-base text-xl mt-2">
                                    Active Codes
                                </div>
                                <div class="text-3xl font-bold text-green-600 leading-8 mt-1">
                                    {{getTotalQR(Auth::user()->parent_id??Auth::id())['active']}}
                                </div>

                                <div class="text-base text-xl mt-2">
                                    Inactive Codes
                                </div>
                                <div class="text-3xl font-bold text-gray-400 leading-8 mt-1">
                                    {{getTotalQR(Auth::user()->parent_id??Auth::id())['inactive']}}
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="col-span-12 sm:col-span-4 lg:col-span-4">
                        <div class="intro-y box mini-graph-box">
                            <div class="flex flex-col sm:flex-row items-center p-5 border-b border-gray-200 dark:border-dark-5">
                                <h2 class="font-medium text-base text-center mx-auto">
                                    Activation Done
                                </h2>
                            </div>
                            <div id="horizontal-bar-chart" class="p-5">
                                <div class="preview">
                                    <canvas id="horizontal-bar-chart-widget" height="180"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-span-12 sm:col-span-4 xl:col-span-4 intro-y text-center">
                        <div class="report-box zoom-in">
                            <div class="box p-3 graph-box">

                                <h3 class="font-medium text-blue-500 text-xl text-base text-center mx-auto">
                                    No. of Scans
                                </h3>

                                <div class="text-base mt-2">
                                    This Month
                                </div>
                                <div class="text-2xl font-bold text-green-600 leading-8 mt-1">
                                    {{totalScans(Auth::user()->parent_id??Auth::id(),'month')}}
                                </div>

                                <div class="text-base mt-2">
                                    Total
                                </div>
                                <div class="text-2xl font-bold text-yellow-400 leading-8 mt-1">
                                    {{totalScans(Auth::user()->parent_id??Auth::id())}}
                                </div>

                                <div class="text-base mt-2">
                                    Total Open Cases
                                </div>
                                <div class="text-2xl font-bold text-blue-700 leading-8 mt-1">
                                    {{totalAlerts(Auth::user()->parent_id??Auth::id())}}
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="col-span-12 sm:col-span-6 xl:col-span-4 intro-y">
                        <div class="report-box zoom-in">
                            <div class="box p-5">
                                <div class="flex">
                                    <i data-feather="monitor" class="report-box__icon text-theme-12"></i>
                                    
                                </div>
                                <div class="text-3xl font-bold leading-8 mt-6">
                                    {{getTotalProducts(Auth::id())}}
                                </div>
                                <a href="{{url('vendor/products')}}"><div class="text-base text-gray-600 mt-1">Total Products</div></a>
                            </div>
                        </div>
                    </div>

                    <div class="col-span-12 sm:col-span-6 xl:col-span-4 intro-y">
                        <div class="report-box zoom-in">
                            <div class="box p-5">
                                <div class="flex">
                                    <i data-feather="shopping-cart" class="report-box__icon text-theme-11"></i>
                                </div>
                                <div class="text-3xl font-bold leading-8 mt-6">
                                    {{getCodesGenerated(Auth::id())}}
                                </div>
                                <a href="{{url('vendor/codes')}}"><div class="text-base text-gray-600 mt-1">Codes Generated</div></a>
                            </div>
                        </div>
                    </div>

                    <div class="col-span-12 sm:col-span-6 xl:col-span-4 intro-y">
                        <div class="report-box zoom-in">
                            <div class="box p-5">
                                <div class="flex">
                                    <i data-feather="user" class="report-box__icon text-theme-9"></i>
                                </div>
                                <div class="text-3xl font-bold leading-8 mt-6">{{getMyUsers(Auth::id())}}</div>
                                <a href="{{url('vendor/users')}}"><div class="text-base text-gray-600 mt-1">Employees</div></a>
                            </div>
                        </div>
                    </div>

                    <div class="col-span-12 sm:col-span-12 text-center">
                        <div class="report-box graph-box">
                            <div class="box p-2">
                                <h2 class="text-lg font-medium">Scanned locations this month
                                </h2>
                                <div id="gmap" style="height:350px;">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            @else
            @if(paymentReminder(Auth::id())['critical']>0)
            <div class="col-span-12 mt-8">
                <x-alert class="danger" message="You are currently restricted to use our services. Please pay your pending invoices to use our services."></x-alert>
            </div>
            @else 
            <div class="col-span-12 mt-8">
                <x-alert class="danger" message="You are currently restricted to use our services. Please check documents in your profile section."></x-alert>
            </div>
            @endif
            @endif
        </div>
    </div>
</div>
@endsection

@section('global_script')
<script type="text/javascript">
var bar2ChartLabel = ["{{getActivation(Auth::user()->parent_id??Auth::id(),-2)['month']}}","{{getActivation(Auth::user()->parent_id??Auth::id(),-1)['month']}}","{{getActivation(Auth::user()->parent_id??Auth::id(),0)['month']}}"];

var bar2ChartDataSets = [{
  label: "Activation Done",
  barPercentage: 10,
  barThickness: 50,
  maxBarThickness: 50,
  minBarLength: 2,
  data: ["{{getActivation(Auth::user()->parent_id??Auth::id(),-2)['count']}}","{{getActivation(Auth::user()->parent_id??Auth::id(),-1)['count']}}","{{getActivation(Auth::user()->parent_id??Auth::id(),0)['count']}}"],
  backgroundColor: "#3160D8"
}];
</script>

@endsection

@section('script')

<script type="text/javascript">
    var locations = [
    @if (count(scanLocations(Auth::user()->parent_id??Auth::id()))>0)
    @foreach(scanLocations(Auth::user()->parent_id??Auth::id()) as $location)
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