@extends('gcodes/layout')
@section('title', 'sigCreate')
@section('style', asset('assets/css/create.css'))
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
    <form method="post" action="{{route('gcodes.create.post')}}" class="form" enctype="multipart/form-data">
    @csrf
    <div class="p">
        <label for="input-username">Enter The username</label>
        <input type="text" name="name" class="username" id="input-username">
    </div>
    <div class="p">   
        <label for="input-email">Enter The email</label>
        <input type="email" name="email" class="email" id="input-email">
    </div>   
    <div class="p">
        <label for="input-password">Enter The password</label>
        <input type="password" name="password" class="password" id="input-password">
    </div>
    <div class="p">
        <label for="password-confirm">Confirm Password</label>
        <input id="password-confirm" type="password" name="password_confirmation" autocomplete="new-password">
    </div>
    <div class="p"> 
        <label for="file-photo">Choose an image</label>
        <input type="file" name="photo" id="file-photo" class="photo">
        <button class="btnImage">Choose an image</button>
        <span class="photoName"></span>
    </div> 
    <div class="p">
        <label for="file-gcode">Choose a gcode</label>
        <input type="file" name="gcode" class="gcode" id="file-gcode">
        <button class="btngcode">Choose a gcode</button>
        <span class="sigName">make sure that the separator between the lines is a new line</span>
    </div>  
    <button type="submit" class="the_button">Create</button>
    </form>
</div>
</div>
@section('script', asset('assets/js/create.js'))
@endsection
