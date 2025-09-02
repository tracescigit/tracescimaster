<div class="flex lg:justify-center items-center ">
	<a class="edit flex items-center mr-3 text-green-500" href="{{ url('admin/invoices/'.encrypt($id)) }}">
		<i data-feather="eye" class="w-4 h-4 mr-1"></i> View          
	</a>

	@if($status == 1)
	<a class="edit flex items-center mr-3 text-red-500" href="{{ url('admin/download-invoice/'.encrypt($id)) }}" target="_blank">
		<i data-feather="download" class="w-4 h-4 mr-1"></i> Download         
	</a>
	@endif

</div>