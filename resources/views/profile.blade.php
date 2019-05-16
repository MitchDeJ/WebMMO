@extends('layouts.app')

@section('content')
    <div class="main-content">
        <div class="container-fluid">
            <!-- OVERVIEW -->
            <div class="panel panel-headline">
                <div class="panel-heading">
                    <h3 class="panel-title">Profile</h3>
                    <div class="right">

                        <button type="button" class="btn-toggle-collapse"><i class="lnr lnr-chevron-up"></i></button>
                    </div>
                    <p class="panel-subtitle"><a href="#">Edit my profile</a></p>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-2">
                            <img src="{{ url('user_img/' . Auth::user()->avatar)}}" width="150px" height="150px"
                                 class="img-circle" alt="Avatar">
                        </div>
                        <div class="col-md-4">
                            <h4>{{Auth::user()->name}}</h4>
                            <p>{{Auth::user()->description}}</p>
                        </div>
                        <div class="col-md-3">
                            <h4>{{Auth::user()->name}}</h4>
                        </div>
                        <div class="col-md-3">
                            <h4>{{Auth::user()->name}}</h4>
                        </div>

                        {{--                    @foreach($skills as $skill)--}}
                        {{--                        <br>{{$skill->name}} level: {{$levels[$skill->id]}} xp: {{$xps[$skill->id]}}--}}
                        {{--                    @endforeach--}}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">Recent activity</h3>
                            <div class="right">
                                <button type="button" class="btn-toggle-collapse"><i class="lnr lnr-chevron-up"></i>
                                </button>
                            </div>
                        </div>
                        <div class="panel-body">
                            <ul class="list-unstyled activity-list">
                                <li>
                                    <img src="{{url('user_img/' . Auth::user()->avatar)}}" alt="Avatar" class="img-circle pull-left avatar">
                                    <p><a href="#">{{Auth::user()->name}}</a> has achieved 80% of his completed tasks <span
                                                class="timestamp">20 minutes ago</span></p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <!-- RECENT PURCHASES -->
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">Skill stats</h3>
                            <div class="right">
                                <button type="button" class="btn-toggle-collapse"><i class="lnr lnr-chevron-up"></i>
                                </button>
                            </div>
                        </div>

                        <div class="panel-body">
                            @foreach($skills as $skill)
                                <div class="col-md-4">
                                    <div class="metric">
                                        <span class="icon"><img src="{{ url($skill->getIconPath($skill->id))}}"
                                                                width="32px" height="32px"
                                                                alt="Avatar"></span>
                                        <p>
                                            <span class="number">Lvl {{$levels[$skill->id]}}</span>
                                            <span class="title">{{$xps[$skill->id]}}xp</span>
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                            <div class="panel-footer">
                                <div class="row">
                                </div>
                            </div>
                        </div>
                        <!-- END RECENT PURCHASES -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection