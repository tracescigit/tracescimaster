@if (count($batches)>0)
<option value="">Please select batch</option>
@foreach ($batches as $batch)
	<option value="{{$batch->code}}">{{$batch->code}}</option>
@endforeach
@endif