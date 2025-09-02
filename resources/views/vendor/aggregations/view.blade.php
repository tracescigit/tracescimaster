@if (strtolower($aggregation->level)=='primary')

@foreach ($aggregation->getCodes as $code)
<div class="col-span-12 bg-gray-200 p-2 mt-2">
	<a href="javascript:;" data-id="{{encrypt($code->id)}}" class="code-data bg-white p-2">
		{{$code->code_data}}
	</a>
</div>
@endforeach

@else
@foreach ($aggregation->getChildren as $child)
<div class="col-span-12 bg-gray-200 p-2 mt-2">

	@if(strtolower($child->level)=='primary')
	@if ($child->getCodes && count($child->getCodes)>0)
	<a href="javascript:;" data-id="{{encrypt($child->id)}}" class="child-has-children">[+]</a>
	@endif
	{{$child->unique_id}}
	@if ($child->getCodes && count($child->getCodes)>0)
	<div class="grid grid-cols-12 children-area">
	</div>
	@endif
	@else
	@if ($child->getChildren && count($child->getChildren)>0)
	<a href="javascript:;" data-id="{{encrypt($child->id)}}" class="child-has-children">[+]</a>
	@endif
	{{$child->unique_id}}
	@if ($child->getChildren && count($child->getChildren)>0)
	<div class="grid grid-cols-12 children-area">
	</div>
	@endif
	@endif
</div>
@endforeach
@endif