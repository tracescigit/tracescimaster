@if ($notify)
<h5 class="font-medium mb-3"> <strong class="text-red-800">Upload Progress : </strong> {{$notify->processed_rows}} rows processed and {{$notify->uploaded_rows}} codes uploaded out of {{$notify->total_rows}}.</h5>

@php
$errors = json_decode($notify->error_logs,true);
@endphp

@if (!empty($errors))
<h6 class="text-red-800 font-bold">Error Logs</h6>
<ul class="mt-3" style="height: 200px; overflow-y: scroll;">
	@foreach ($errors as $error)
	<li class="mb-1">{{$error}}</li>
	@endforeach
</ul>
@endif

@endif