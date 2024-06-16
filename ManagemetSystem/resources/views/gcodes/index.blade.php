@extends('gcodes/layout')
@section('title', 'gcodes')
@section('style', asset('assets/css/index.css'))
@section('content')
<div class="container">
<div class="app">
    <nav>
      <li><a href="gcodes/logout">logout</a></li>
    </nav>
    <form  action="{{route('gcodes.create')}}" class="form">
      <button class="create">Create</button>
    </form>
    <form  action="{{route('RealTime')}}" class="form">
      <button class="create">ESP32 Live</button>
    </form>
    <form  action="{{route('Settings')}}" class="form">
      <button class="create">Settings</button>
    </form>
    @if(session()->has('succes'))
    <div class="green">{{session('succes')}}</div>
    @endif
    @if(session()->has('error'))
    <div class="red">{{session('error')}}</div>
    @endif
    <div calss="mt-5">
      @if($errors->any())
      <div class="clo-12">
          @foreach($errors->all() as $error)
          <div class="alert alert-danger">{{$error}}</div>
          @endforeach
      </div>
      @endif
    </div>
    @foreach ($gcodes as $gcode)
    <div class="content">
      <div class="outher_content">
        <h1 class="name">name: {{$gcode->name}}</h1>
        <h1 class="email">email: {{$gcode->email}}</h1>

        <h2 class="data">created at: {{$gcode->created_at}}</h2>
        <div class="the_buttons_L">
          <form method="post" action="{{route('gcodes.delete' , ['gcode' => $gcode])}}" >
          @method('delete')
          @csrf
          <button type="submit" class="delete">Delete</button>
          </form>
          <form method="get" action="{{route('gcodes.edite' , ['gcode' => $gcode])}}" >
          @csrf
          <button type="submit" class="edite">Edite</button>        
          </form>
          <form method="get" action="{{route('gcodes.ask' , ['gcode' => $gcode])}}" >
          @csrf
          <button type="submit" class="gcodeAsk">Ask</button>           
          </form>
        </div>
      </div>
      <div class="img_content">
        <img  class="image" src="{{asset('assets/uploades/' . $gcode->photo)}}">
      </div>
    </div>
    @endforeach
</div>
</div>
@endsection
