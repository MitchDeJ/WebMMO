@extends('layouts.app')
@section('content')
    <script>
        var redirect = '{{ url('')}}';
        var delay= '{{ \App\Combat::getTimeToKill(Auth::user()->id, $mob->id) + $mob->respawn}}';
        var hp='{{$hp}}';
        var maxhp='{{$maxhp}}';
        var kills='{{$kills}}';
        var xpPerKill='{{$mob->hitpoints * \App\Constants::$XP_PER_DAMAGE}}';
        var lastUpdate ='{{$lastupdate}}';
    </script>
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
                        Respawn time: {{$mob->respawn}}s
                        <div class="kills-text">Kills: {{$kills}}</div>
                        <div id="progressBar" class="progressBar">
                            <div class="bar"></div>
                        </div>
                        <b>{{Auth::user()->name}}</b><br>
                        <div class="hp-text">HP: {{$hp}}/{{$maxhp}}</div>
                        <div id="hpBar" class="progressBar">
                            <div class="bar" style="background-color:green"></div>
                        </div>
                        <div class="xp-text">XP gained: {{$mob->hitpoints * \App\Constants::$XP_PER_DAMAGE * $kills}}</div>
                        <b>Loot</b>
                        <div class="loot">
                        @foreach($loot as $l)
                            <img src="{{url($item->getIconPath($l->item_id))}}" /> x{{$l->amount}}
                            @endforeach
                        </div>
                        <!-- CONTENT END -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
