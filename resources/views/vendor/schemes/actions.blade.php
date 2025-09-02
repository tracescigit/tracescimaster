<div class="flex lg:justify-center items-center">
	<a class="edit flex items-center mr-3 text-green-500" href="{{ url('vendor/schemes/'.encrypt($scheme->id).'/show') }}">
		<i data-feather="eye" class="w-4 h-4 mr-1"></i> {{__('View')}}           
	</a>

	@if($scheme->status!='Finalized')
	<a class="edit flex items-center mr-3 text-blue-500" href="{{ url('vendor/schemes/'.encrypt($scheme->id).'/edit') }}">
		<i data-feather="edit" class="w-4 h-4 mr-1"></i> Edit           
	</a>
	@endif

</div>