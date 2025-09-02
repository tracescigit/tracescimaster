@if (count($upload_progress)>0)
@foreach ($upload_progress as $key=>$progress)

@php
$total_rows 	= $progress->total_rows;
$processed_rows = $progress->processed_rows;
$uploaded_rows 	= $progress->uploaded_rows;
$process_percentage = ($processed_rows/$total_rows)*100;
$upload_percentage  = ($uploaded_rows/$total_rows)*100;
@endphp
<div class="flex justify-between mb-2">
	<span class="font-medium text-sm text-red-700 dark:text-white">Codes Upload Progress {{$key+1}}</span>
	<span class="text-sm font-medium text-red-700 dark:text-white">{{$process_percentage}}%</span>
</div>
<div class="w-full bg-gray-200 rounded-full dark:bg-gray-700 mb-3">
	<div class="bg-red-800 rounded-full text-center text-gray-300 text-xs py-0" style="width: {{$process_percentage}}%">
		@if ($process_percentage>40)
		{{$processed_rows}} rows processed and {{$uploaded_rows}} codes uploaded out of {{$total_rows}}.
		@else
		Processing...
		@endif
	</div>
</div>
@endforeach
@endif