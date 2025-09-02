<option value="">Please Select</option>
@forelse($users as $user)
<option value="{{$user->id}}">{{$user->name}} - {{$user->email}}</option>
@empty
<option value="">Please Select</option>
@endforelse