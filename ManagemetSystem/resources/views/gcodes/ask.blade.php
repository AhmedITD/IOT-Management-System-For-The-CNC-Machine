@extends('layout')
@section('title', 'sigCreate')
@section('content')
<div class="container">
    <div class="app">
    <div calss="mt-5">
        @if($errors->any())
        <div class="clo-12">
            @foreach($errors->all() as $error)
            <div class="alert alert-danger">{{$error}}</div>
            @endforeach
        </div>    
        @endif
    </div>
    <form method="post" action="{{route('gcodes.askPost', ['gcode' => $gcode])}}">
    @csrf
    <label for="input-password">Enter The password</label>
    <input type="password" name="password" class="password" id="input-password">

    <button type="submit" class="the_button">Ask</button>
    </form>
    </div>
</div>
@endsection
