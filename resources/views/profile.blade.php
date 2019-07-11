@extends('layouts.app')

@section('content')
    <div class="main-content">
        <div class="container-fluid">
            <!-- OVERVIEW -->
            <div class="panel panel-headline">
                <div class="panel-heading">
                    @if($user->id == Auth::user()->id)
                        <p class="panel-subtitle"><a href="{{url("/editprofile")}}">Edit profile</a> - <a href="{{url("/titles")}}">Title selection</a>
                    @endif
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-2">
                            <img src="{{ url('user_img/' . $user->avatar)}}" width="150px" height="150px" alt="Avatar">
                        </div>
                        <div class="col-md-4">
                            <h4><b style="color:{{Titles::getTitles()[$user->title][2]}}">
                                    {{Titles::getTitles()[$user->title][0]}}</b> {{$user->name}}</h4>
                            <p>{{$user->description}}</p>
                        </div>
                        <div class="col-md-3">
                            <h4>{{\App\Area::find($user->area_id)->name}}</h4>
                        </div>
                        <div class="col-md-3">
                            <h4>Started: {{$user->account_created_at}}</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">Recent activity</h3>
                        </div>
                        <div class="panel-body">
                            <ul class="list-unstyled activity-list">
                                @if (count($news) != 0)
                                @foreach($news as $n)
                                    <li>
                                        <img src="{{url('user_img/' . $user->avatar)}}" alt="Avatar"
                                             class="pull-left avatar" width="40px" height="40px">
                                        <p><a href="{{url('profile/'.$user->name)}}">{{$user->name}}</a> {{$n->message}}
                                            <span class="timestamp">
                                                {{App\Func::time_elapsed_string($n->timestamp)}}
                                            </span></p>
                                    </li>
                                @endforeach
                                @else
                                    <p>No activity to show yet.</p>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">Skill stats</h3>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection