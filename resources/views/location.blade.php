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
                            <th>XP per item</th>
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
                        NPCs
                        <table border="1">
                            <tr>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                            @foreach($npcs as $npc)
                                <tr>
                                    <td>{{$npc->name}}</td>
                                    {!! Form::open(['route' => ['npc.interact'], 'method' => 'post', 'class' => 'form-inline']) !!}
                                    {!! Form::hidden("id", $npc->id) !!}
                                    <td><button type="submit" class="btn btn-default">Talk</button></td>
                                    {!! Form::close() !!}
                                </tr>
                            @endforeach
                        </table>
                        <br>
                        Objects
                        <table border="1">
                            <tr>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                            @foreach($objects as $o)
                                <tr>
                                    <td>{{$o->name}}</td>
                                    {!! Form::open(['route' => ['object.interact'], 'method' => 'post', 'class' => 'form-inline']) !!}
                                    {!! Form::hidden("id", $o->id) !!}
                                    <td><button type="submit" class="btn btn-default">Use</button></td>
                                    {!! Form::close() !!}
                                </tr>
                            @endforeach
                        </table>
                        <br>
                        Mobs
                        <table border="1">
                            <tr>
                                <th>Name</th>
                                <th>Mel</th>
                                <th>Ran</th>
                                <th>Mag</th>
                                <th>Def</th>
                                <th>HP</th>
                                <th>Action</th>
                            </tr>
                            @foreach($mobs as $mob)
                                <tr>
                                    <td>{{$mob->name}}</td>
                                    <td>{{$mob->melee}}</td>
                                    <td>{{$mob->ranged}}</td>
                                    <td>{{$mob->magic}}</td>
                                    <td>{{$mob->defence}}</td>
                                    <td>{{$mob->hitpoints}}</td>
                                    {!! Form::open(['route' => ['attack.mob'], 'method' => 'post', 'class' => 'form-inline']) !!}
                                    {!! Form::hidden("id", $mob->id) !!}
                                    <td><button type="submit" class="btn btn-default">Attack</button></td>
                                    {!! Form::close() !!}
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
