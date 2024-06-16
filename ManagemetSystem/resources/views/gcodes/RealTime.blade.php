@extends('/gcodes/layout')
@section('title', 'Real Time INFO')
@section('bodyEvent', 'onload=autoReload()')
@section('content')
<div class="container">
    <div calss="mt-5">
        <div class="green ">From The Server: {{$gcodeRealTime['gcodeRealTime_fromphp']}}</div>
    </div>
</div>
<script type="text/javascript">function autoReload(){setTimeout(function(){location.reload();}, 500);}</script>
@endsection
