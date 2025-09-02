<div class="flex lg:justify-center items-center">
	@if($level=='All')
	<a class="edit flex items-center mr-3 text-green-500 parent" href="javascript:;" data-id="{{encrypt($id)}}">
		<i data-feather="eye" class="w-4 h-4 mr-1"></i> View           
	</a>
	@else
	<a class="edit flex items-center mr-3 text-green-500" href="{{ url('vendor/aggregations/'.encrypt($id).'/edit') }}">
		<i data-feather="eye" class="w-4 h-4 mr-1"></i> View           
	</a>
	@endif
</div>