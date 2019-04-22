@extends('layouts.app')

@section('content')
<div class="main-content">
    <div class="container-fluid">
        <!-- OVERVIEW -->
        <div class="panel panel-headline">
            <div class="panel-heading">
                <h3 class="panel-title">Dashboard</h3>
                <p class="panel-subtitle">Period: Oct 14, 2016 - Oct 21, 2016</p>
            </div>
            <div class="panel-body">
                <div class="row">
                    <!-- CONTENT START -->
                    {{Auth::user()->name}}
                    {{Auth::user()->description}}
                    @foreach($skills as $skill)
                        <br>{{$skill->name}} level: {{$levels[$skill->id]}} xp: {{$xps[$skill->id]}}
                    @endforeach
                    <!-- CONTENT END -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection