@extends('layouts.app')

@section('content')
    <script>
        var dialogue = '{!! json_encode($dialogue, JSON_HEX_TAG) !!}';
        var username = '{{ $user->name }}';
        var npcname = '{!! $npc->name !!}';
        var redirect = '{!! url('') !!}';
        var dId = '{{$dId}}';
    </script>
    <script src="{{asset('assets/vendor/dialogue/dialogue.js')}}"></script>
    <div class="main-content">
        <div class="container-fluid">
            <!-- OVERVIEW -->
            <div class="panel panel-headline">
                <div class="panel-body">
                    <div class="row">
                        <!-- CONTENT START -->
                        <div id="dia_actor">actor</div>
                        <div id="dia_text">text</div>
                        <br>
                        <button id="dia_button">Continue</button>
                    </div>
                    <!-- CONTENT END -->
                </div>
            </div>
        </div>
    </div>
@endsection
