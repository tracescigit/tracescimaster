<div class="flex lg:justify-center items-center">
	@if($amount>0)
	<a class="edit flex items-center mr-3 text-green-500" href="{{ url('vendor/credits/'.encrypt($id)) }}">
		<i data-feather="eye" class="w-4 h-4 mr-1"></i> View           
	</a>
	
	<a class="edit flex items-center mr-3 text-green-500" href="{{ url('vendor/credits/'.encrypt($id).'/?download=invoice') }}">
		<i data-feather="eye" class="w-4 h-4 mr-1"></i> Invoice           
	</a>
	@else
	-
	@endif
</div>