@extends('/gcodes/layout')
@section('title', 'Settings')
@section('content')
<div class="container">
<div calss="mt-5">
    @if(session()->has('error'))
    <div class="alert alert-danger">{{session('error')}}</div>
    @endif
</div>
<form method="post" action="{{route('Settings.post')}}">
@csrf
    <select name="selsect">
        <option value="theSpeed">The Speed</option>
        <option value="theAcceleration">The Acceleration</option>
    </select>
    <label for="value">Enter The value</label>
    <input type="text" name="value" class="" id="value">
    <button type="submit" class="">update</button>
</form>
</div>
@endsection