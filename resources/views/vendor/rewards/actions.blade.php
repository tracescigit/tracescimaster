<div class="flex lg:justify-center items-center">

	<a class="edit flex items-center mr-3 text-blue-500" href="{{ url('vendor/rewards/'.encrypt($reward->id).'/edit') }}">
		<i data-feather="edit" class="w-4 h-4 mr-1"></i> Edit
	</a>

	<a class="edit flex items-center mr-3 text-blue-500" href="{{ url('vendor/rewards/'.encrypt($reward->id).'/download') }}">
		<i data-feather="download" class="w-4 h-4 mr-1"></i> Download
	</a>
	
	<a class="edit flex items-center mr-3 text-green-500" href="{{ url('vendor/rewards/'.encrypt($reward->id).'/show') }}">
		<i data-feather="eye" class="w-4 h-4 mr-1"></i> {{__('Transactions')}}           
	</a>
</div>