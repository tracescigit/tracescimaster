<div class="flex lg:justify-center items-center">
	<a class="edit flex items-center mr-3 text-green-500" href="{{ url('admin/qr-label-orders/'.encrypt($order->id).'/show') }}">
		<i data-feather="eye" class="w-4 h-4 mr-1"></i> {{__('order.view_order')}}           
	</a>

	{{-- <a class="download flex items-center mr-2 text-green-500" href="{{ url('admin/download-invoice/'.encrypt($order->getInvoice->id)) }}">
		<i data-feather="download" class="w-4 h-4 mr-1"></i> {{__('common.invoice')}}
	</a> --}}
</div>