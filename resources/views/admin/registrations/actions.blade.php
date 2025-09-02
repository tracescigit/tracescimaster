<div class="flex lg:justify-center items-center">
	@if ($user->status!='2')
	<a class="edit flex items-center mr-3 text-blue-500" href="{{ url('admin/registrations/'.encrypt($user->id).'/edit') }}">
		<i data-feather="edit" class="w-4 h-4 mr-1"></i> Edit           
	</a>
	@else
	NA
	@endif
</div>