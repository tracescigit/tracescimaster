@php
$role = 'none';
@endphp

@foreach ($supply->getChildren as $child)
<div class="col-span-12 border p-2 mt-2 ml-4">
	<a href="javascript:;" data-id="{{encrypt($child->getUser->id)}}" class="child-has-children">[+]</a>
	<a href="javascript:;" data-id="{{encrypt($child->getUser->id)}}" class="user-data">{{$child->getUser->name}}</a>
	<span class="float-right bg-red-800 text-white px-1" style="font-size: 10px;">{{strtoupper($child->getUser->who_you_are)}}</span>
	<a href="javascript:;" class="text-red-400 ml-2" data-toggle="modal" data-target="#delete-confirmation-modal" onclick="cash('#delete-confirmation-modal').find('#target').val('{{url('vendor/supply-chain-management/'.encrypt($child->getUser->id).'/destroy')}}')">(x)</a>
	<div class="grid grid-cols-12 children-area">
	</div>
</div>
@php
$role = $child->getUser->who_you_are;
@endphp
@endforeach

<div class="col-span-12 bg-gray-200 p-2 mt-2 ml-4">
	<a href="javascript:;" data-toggle="modal" data-target="#add-new-modal" class="bg-gray-200 p-2 add-new" data-role="{{$role}}" data-parent="{{$supply->getUser->id}}">+ Add New</a>
</div>