
<option value="">Please select</option>

@foreach ($users as $user)
	<option value="{{$user->id}}">{{$user->name}} : {{$user->who_you_are}}</option>
@endforeach