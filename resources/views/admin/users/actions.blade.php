@if (hasRoutePermission('admin-edit-users',Auth::id()))	
<div class="flex lg:justify-center items-center">
	<a class="edit flex items-center mr-3 text-blue-500" href="{{ url('admin/users/'.encrypt($id).'/edit') }}">
		<i data-feather="edit" class="w-4 h-4 mr-1"></i> {{__('common.edit')}}           
	</a>
</div>
@endif