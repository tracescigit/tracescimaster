@extends('vendor.layout.' . $layout)

@section('subhead')
<title>Choose Plan - TRACESCI</title>
@endsection

@section('subcontent')
<div class="intro-y flex items-center mt-8">
	<h2 class="text-lg font-medium mr-auto">Choose a topup for your current plan</h2>
</div>


<div class="grid grid-cols-12 gap-6 mt-4">
	<div class="col-span-12 lg:col-span-12 bg-white">
		<div class="pos__ticket p-5">
			<div class="col-span-12 lg:col-span-12 bg-gray-200 p-3 box">
				<p class="mb-2"><strong>Instructions:</strong></p>
				
				<p class="mb-0"><strong>Add Credits:</strong></p>
				<p class="mb-2">You can see credit top ups available in with your current active plans. You can choose any, proceed for payment. After successful payment, credits will be added into your account. After that you can upload more equivalent data.</p>

				<p class="mb-0"><strong>Upgrade Plan:</strong></p>
				<p class="mb-0">In case you want to upgrade current plan, choose once from below plans based on your usage, proceed for payments.After successful payment, your new plan will be activated. In case you want to buy more credits, you can choose any of the top-up available.
				</p>
				
			</div>
		</div>
	</div>
</div>

<div class="intro-y box flex flex-col lg:flex-row mt-5">
	@if (count($topups)>0)
	@foreach ($topups as $topup)
	<div class="intro-y flex-1 px-5 py-16 border">
		<i data-feather="credit-card" class="block w-12 h-12 text-theme-1 dark:text-theme-10 mx-auto"></i>
		<div class="text-xl font-medium text-center mt-10">{{$topup->title}}</div>
		<div class="text-gray-700 dark:text-gray-600 text-center mt-5">
			{{$topup->credits}} Credits
		</div>
		<div class="text-gray-600 dark:text-gray-400 px-10 text-center mx-auto mt-2">
			{!!$topup->description!!}
		</div>
		<div class="flex justify-center">
			<div class="relative text-5xl font-semibold mt-8 mx-auto">
				&#8377; {{number_format((float)$topup->price_inr,2,'.','')}}
			</div>
		</div>
		<button type="button" onclick="window.location.href='{{ url('vendor/payment/'.encrypt($topup->id)) }}'" class="btn btn-rounded-primary py-3 px-4 block mx-auto mt-8">PURCHASE NOW</button>
	</div>
	@endforeach
	@else
	<div class="intro-y flex-1 px-5 py-16">
		<i data-feather="alert-triangle" class="block w-12 h-12 text-theme-1 dark:text-theme-10 mx-auto"></i>
		<div class="text-xl font-medium text-center mt-10">Sorry no topups available now</div>
	</div>
	@endif
</div>

@if (count($plans)>0)
<div class="intro-y flex items-center mt-8">
	<h2 class="text-lg font-medium mr-auto">Migrate from your current plan</h2>
</div>
<div class="intro-y box flex flex-col lg:flex-row mt-5">
	@foreach ($plans as $plan)
	<div class="intro-y flex-1 px-5 py-16 border">
		<i data-feather="credit-card" class="block w-12 h-12 text-theme-1 dark:text-theme-10 mx-auto"></i>
		<div class="text-xl font-medium text-center mt-10">{{$plan->title}}</div>
		<div class="text-gray-700 dark:text-gray-600 text-center mt-5">
			{{$plan->credits}} Credits
		</div>
		<div class="text-gray-600 dark:text-gray-400 px-10 text-center mx-auto mt-2">
			{!!$plan->description!!}
		</div>
		<div class="flex justify-center">
			<div class="relative text-5xl font-semibold mt-8 mx-auto">
				&#8377; {{number_format((float)$plan->price_inr,2,'.','')}} 
			</div>
		</div>
		<button type="button" onclick="window.location.href='{{ url('vendor/payment/'.encrypt($plan->id)) }}'" class="btn btn-rounded-primary py-3 px-4 block mx-auto mt-8">PURCHASE NOW</button>
	</div>
	@endforeach
</div>
@endif

@endsection


