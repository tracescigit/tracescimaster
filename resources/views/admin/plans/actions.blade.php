<div class="flex lg:justify-center items-center">
	<a class="edit flex items-center mr-3 text-blue-500" href="{{ url('admin/plans/'.encrypt($id).'/edit') }}">
		<i data-feather="edit" class="w-4 h-4 mr-1"></i> Edit           
	</a>

	<a class="flex items-center text-theme-6" href="javascript:void(0);" data-toggle="modal" data-target="#delete-confirmation-modal" onclick="cash('#delete-confirmation-modal').find('#target').val('{{url('admin/plans/'.encrypt($id).'/destroy')}}')">
		<i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Delete
	</a>
</div>