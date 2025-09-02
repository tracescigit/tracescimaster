<div class="flex lg:justify-center items-center">
	<a class="edit flex items-center mr-3 text-green-500" href="{{ url('vendor/invoices/'.encrypt($id)) }}">
		<i data-feather="eye" class="w-4 h-4 mr-1"></i> View           
	</a>
</div>

@if($status == 1)
<div class="flex lg:justify-center items-center">
	<a class="edit flex items-center mr-3 text-red-500" href="{{ url('vendor/download-invoice/'.encrypt($id)) }}" target="_blank">
		<i data-feather="download" class="w-4 h-4 mr-1"></i> Download         
	</a>
</div>
@endif