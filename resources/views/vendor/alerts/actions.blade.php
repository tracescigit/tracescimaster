@if($vendor_assigned_to != null)
<div class="flex lg:justify-center items-center">
	<a class="edit flex items-center mr-3 text-green-500" href="{{ url('vendor/viewalerts/'.encrypt($id)) }}">
		<i data-feather="eye" class="w-4 h-4 mr-1"></i> Details      
	</a>
</div>
@else
<div class="flex lg:justify-center items-center">
	<a class="edit flex items-center mr-3 text-red-500" href="{{ url('vendor/actalerts/'.encrypt($id)) }}">
		<i data-feather="edit" class="w-4 h-4 mr-1"></i> Act Now    
	</a>
</div>
@endif