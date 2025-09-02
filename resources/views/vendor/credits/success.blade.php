@extends('vendor.layout.' . $layout)

@section('subhead')
<title>Success - TRACESCI</title>
@endsection

@section('subcontent')
<div class="intro-y flex items-center mt-8">
	<h2 class="text-lg font-medium mr-auto">Your order was completed successfully</h2>
</div>


<div class="intro-y box overflow-hidden mt-5">
	<div class="border-b border-gray-200 dark:border-dark-5 p-5 text-center sm:text-left">

		<h3 class="text-3xl text-center font-medium my-5">Thank You</h3>

		<h5 class="text-2xl text-center font-medium mb-6">
			Your order was completed successfully
		</h5>

		<p class="text-center mb-6">
			An email receipt including the details about your order has been sent to the email address provided. Please keep it for your records.
		</p>

		<p class="text-center">
			<button  onclick="window.location.href='{{url('vendor/credits')}}'" class="btn w-32 border-gray-400 dark:border-dark-5 text-gray-600 dark:text-gray-300">Back to credits</button>
		</p>

	</div>
</div>

@endsection


