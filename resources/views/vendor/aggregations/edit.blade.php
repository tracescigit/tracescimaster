@extends('vendor.layout.' . $layout)

@section('subhead')
<title>Aggregation Details - TRACESCI</title>
@endsection

@section('subcontent')
<div class="intro-y flex flex-col sm:flex-row items-center mt-8">
	<h2 class="text-lg font-medium mr-auto">Aggregation Details</h2>
</div>
<!-- BEGIN: Aggregation Details -->
<div class="intro-y box overflow-hidden mt-5">
	<div class="border-b border-gray-200 dark:border-dark-5 text-center sm:text-left">
		<div class="px-5 py-10 sm:px-10 sm:py-10">
			<div class="text-theme-1 dark:text-theme-10 font-semibold text-3xl">{{strtoupper($aggregation->level)}}</div>
			<div class="mt-2">
				Unique ID : <span class="font-medium">{{strtoupper($aggregation->unique_id)}}</span>
			</div>
			<div class="mt-1">{{date('M d, Y',strtotime($aggregation->updated_at))}}</div>
		</div>
	</div>
</div>

<div class="grid grid-cols-12 gap-6 mt-5">
	@if (strtolower($aggregation->level)=='primary')
	<div class="col-span-12 intro-y mt-1">
		<h2 class="text-lg font-medium mr-auto">QR Codes in this aggregation</h2>
	</div>
	@foreach ($aggregation->getCodes as $code)
	<div class="col-span-12 lg:col-span-3 intro-y mt-1">
		<div class="report-box zoom-in">
			<div class="box p-5 text-center">
				<div class="text-base text-gray-600 mt-1">
					Serial No : {{$code->code_data}} <br>
					Product : {{$code->getProduct->name}}
				</div>
			</div>
		</div>
	</div>
	@endforeach
	@else
	<div class="col-span-12 intro-y mt-1">
		<h2 class="text-lg font-medium mr-auto">Aggregations included in this {{$aggregation->level}} aggregation</h2>
	</div>
	@foreach ($aggregation->getChildren as $child)
	<div class="col-span-12 lg:col-span-3 intro-y mt-1">
		<div class="report-box zoom-in">
			<a target="_blank" href="{{ url('vendor/aggregations/'.encrypt($child->id).'/edit') }}">
				<div class="box p-5 text-center">
					<div class="text-base text-gray-600 mt-1">
						Serial No : {{$child->unique_id}} <br>
						Level : {{ucfirst($child->level)}}
					</div>
				</div>
			</a>
		</div>
	</div>
	@endforeach
	@endif
</div>
<!-- END: Aggregation Details -->

@endsection

@section('script')

@endsection

