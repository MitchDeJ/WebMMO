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
                        <img src="{{ url('user_img/' . Auth::user()->avatar)}}" width="150px" height="150px" class="img-circle" alt="Avatar">
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
                            <button type="button" class="btn-toggle-collapse"><i class="lnr lnr-chevron-up"></i></button>
                        </div>
                    </div>
                    <div class="panel-body">
                        <ul class="list-unstyled activity-list">
                            <li>
                                <img src="assets/img/user1.png" alt="Avatar" class="img-circle pull-left avatar">
                                <p><a href="#">Michael</a> has achieved 80% of his completed tasks <span class="timestamp">20 minutes ago</span></p>
                            </li>
                            <li>
                                <img src="assets/img/user2.png" alt="Avatar" class="img-circle pull-left avatar">
                                <p><a href="#">Daniel</a> has been added as a team member to project <a href="#">System Update</a> <span class="timestamp">Yesterday</span></p>
                            </li>
                            <li>
                                <img src="assets/img/user3.png" alt="Avatar" class="img-circle pull-left avatar">
                                <p><a href="#">Martha</a> created a new heatmap view <a href="#">Landing Page</a> <span class="timestamp">2 days ago</span></p>
                            </li>
                            <li>
                                <img src="assets/img/user4.png" alt="Avatar" class="img-circle pull-left avatar">
                                <p><a href="#">Jane</a> has completed all of the tasks <span class="timestamp">2 days ago</span></p>
                            </li>
                        </ul>
                        <button type="button" class="btn btn-primary btn-bottom center-block">Load More</button>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <!-- RECENT PURCHASES -->
                <div class="panel">
                    <div class="panel-heading">
                        <h3 class="panel-title">Skill stats</h3>
                        <div class="right">
                            <button type="button" class="btn-toggle-collapse"><i class="lnr lnr-chevron-up"></i></button>
                        </div>
                    </div>

                    <div class="panel-body">
                        <div class="col-md-4">
                            <div class="metric">
                                <span class="icon"><img src="{{ url('user_img/' . Auth::user()->avatar)}}" width="55px" height="55px" class="img-circle" alt="Avatar"></span>
                                <p>
                                    <span class="number">Lvl 73</span>
                                    <span class="title">21.455.666 xp</span>
                                </p>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="metric">
                                <span class="icon"><i class="fa fa-download"></i></span>
                                <p>
                                    <span class="number">1,252</span>
                                    <span class="title">Downloads</span>
                                </p>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="metric">
                                <span class="icon"><i class="fa fa-download"></i></span>
                                <p>
                                    <span class="number">1,252</span>
                                    <span class="title">Downloads</span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="panel-footer">
                        <div class="row">
                            <div class="col-md-6"><span class="panel-note"><i class="fa fa-clock-o"></i> Last 24 hours</span></div>
                            <div class="col-md-6 text-right"><a href="#" class="btn btn-primary">View All Purchases</a></div>
                        </div>
                    </div>
                </div>
                <!-- END RECENT PURCHASES -->
            </div>
        </div>
    </div>
</div>
@endsection