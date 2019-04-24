@extends('layouts.app')

@section('content')
    <div class="main-content">
        <div class="container-fluid">
            <!-- OVERVIEW -->
            <div class="panel panel-headline">
                <div class="panel-heading">
                    <h3 class="panel-title">{{$location->name}}</h3>
                    <p class="panel-subtitle">{{$location->description}}</p>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <!-- CONTENT START -->
                        <table border="1">
                            <tr>
                            <th>Name</th>
                            <th>Skill</th>
                            <th>XP per action</th>
                            <th>Requirements</th>
                            <th>Resource</th>
                            <th>Cooldown</th>
                            <th>Action</th>
                            </tr>
                            @foreach($skillspots as $spot)
                                <tr>
                                    <td>{{$spot->name}}</td>
                                    <td><img src='{{url($skill->getIconPath($spot->skill_id))}}'/></td>
                                    <td>{{$spot->xp_amount}}</td>
                                    <td>
                                        @foreach ($reqs[$spot->id] as $req)
                                                <img src='{{url($skill->getIconPath($req->skill_id))}}'/> {{$req->requirement}}
                                            @endforeach
                                    </td>
                                    <td><img src='{{url($item->getIconPath($spot->item_id))}}' /></td>
                                    <td>{{$spot->cooldown}}</td>
                                    <td>
                                        {!! Form::open(['route' => ['skillspot.use'], 'method' => 'post', 'class' => 'form-inline']) !!}
                                        {!! Form::hidden("id", $spot->id) !!}
                                        <button type="submit" class="btn btn-default">Use</button>
                                        {!! Form::close() !!}
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        <br>
                        <table border="1">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                            </tr>
                            @foreach($npcs as $npc)
                                <tr>
                                    <td>{{$npc->id}}</td>
                                    <td>{{$npc->name}}</td>
                                </tr>
                            @endforeach
                        </table>
                        <!-- CONTENT END -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
