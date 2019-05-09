@extends('layouts.app')
@section('content')
    <script>var redirect = '{{ url('')}}'; var delay= '{{ \App\Combat::getTimeToKill(Auth::user()->id, $mob->id)}}';</script>
    <script src="{{ asset('assets/vendor/mobs/fight.js') }}"></script>
    <div class="main-content">
        <div class="container-fluid">
            <!-- OVERVIEW -->
            <div class="panel panel-headline">
                <div class="panel-heading">
                </div>
                <div class="panel-body">
                    <div class="row">
                        <!-- CONTENT START -->
                        <b>Fighting: {{$mob->name}}</b><br>
                        Time per kill: {{\App\Combat::getTimeToKill(Auth::user()->id, $mob->id)}}s<br>
                        <div class="kills-text">Kills: {{$kills}}</div>
                        <b>{{Auth::user()->name}}</b><br>
                        <div class="hp-text">HP: {{$hp}}/{{$maxhp}}</div>
                        <progress class="hp-bar" value="{{$hp}}" max="{{$maxhp}}"></progress><br>
                        <div class="xp-text">XP gained: {{$mob->hitpoints * \App\Constants::$XP_PER_DAMAGE * $kills}}</div>
                        <!-- CONTENT END -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
