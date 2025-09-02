@if(isset($genuine) && $genuine=='1')
<div class="flex text-green-600">
	<i data-feather="check" class="font-bold">Yes</i>
</div>
@else
<div class="flex text-red-600">
	<i data-feather="x" class="font-bold">No</i>
</div>
@endif