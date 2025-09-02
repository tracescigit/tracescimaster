@if($admin_assigned_to != null)
<div class="flex lg:justify-center items-center">
	<a class="edit flex items-center mr-3 text-green-500" href="{{ url('admin/viewreports/'.encrypt($id)) }}">
		<i data-feather="eye" class="w-4 h-4 mr-1"></i> {{__('common.view')}} {{__('common.details')}}         
	</a>
</div>
@else
<div class="flex lg:justify-center items-center">
	<a class="edit flex items-center mr-3 text-red-500" href="{{ url('admin/actreports/'.encrypt($id)) }}">
		<i data-feather="edit" class="w-4 h-4 mr-1"></i>  {{__('alert.act_now')}}        
	</a>
</div>
@endif