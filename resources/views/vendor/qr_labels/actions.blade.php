<div class="flex lg:justify-center items-center">
	<a class="edit flex items-center mr-3 text-green-500" href="{{ url('vendor/qr-labels/'.encrypt($order->id).'/show') }}">
		<i data-feather="eye" class="w-4 h-4 mr-1"></i> {{__('order.view_order')}}           
	</a>


</div>