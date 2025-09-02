<div class="flex lg:justify-center items-center">
	<a class="edit flex items-center mr-3 text-{{$code->status=='1'?'green-500':'red-500'}}" title="{{$code->status=='1'?'Deactivate Now':'Activate Now'}}" href="javascript:void(0);" data-toggle="modal" data-target="#deactivate-confirmation-modal" onclick="cash('#deactivate-confirmation-modal').find('#target').val('{{url('vendor/codes/'.encrypt($code->id).'/deactivate')}}')">
		<i data-feather="check-square" class="w-4 h-4 mr-1"></i> 
		{{$code->status=='1'?'Active':'Inactive'}}           
	</a>
</div>