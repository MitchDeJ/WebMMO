@extends('layouts.app')

@section('content')
    <div class="main-content">
        <div class="container-fluid">
            <!-- OVERVIEW -->
            <div class="panel panel-headline">
                <div class="panel-heading">
                    <div class="right">

                        <button type="button" class="btn-toggle-collapse"><i class="lnr lnr-chevron-up"></i></button>
                    </div>
                    @if($user->id == Auth::user()->id)
                        <p class="panel-subtitle"><a href="{{url("/profile")}}">Back to profile</a></p>
                    @endif
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-2">
                            <img src="{{ url('user_img/' . $user->avatar)}}" width="150px" height="150px" alt="Avatar">
                            <form enctype="multipart/form-data" action="" method="POST">
                                <input type="file" required name="avatar" accept="image/*">
                                {{ csrf_field() }}
                                <button type="submit" class="btn btn-info btn-sm">Save</button>
                            </form>
                        </div>
                        <div class="col-md-4">
                            <h4>{{$user->name}}</h4>
                            <form method="POST" name="updateavatar" action="{{route("updateDesc")}}">
                                <label for="desc"></label>
                                <input name="desc" id="desc" type="text" class="form-control" value="{{$user->description}}" placeholder="Enter a description.">
                                {{ csrf_field() }}
                                <button type="submit" class="btn btn-sm btn-info">Save</button>
                            </form>
                        </div>
                        <div class="col-md-3">
                            <h4>{{\App\Area::find($user->area_id)->name}}</h4>
                        </div>
                        <div class="col-md-3">
                            <h4>{{$user->name}}</h4>
                        </div>
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