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
                        <b>Skilling spots</b>
                       <table>
                            @foreach($skillspots as $spot)
                                <tr>
                                    <td><img src='{{url($skill->getIconPath($spot->skill_id))}}'/></td>
                                    <td>{{$spot->name}}</td>
                                    <td>
                                        {!! Form::open(['route' => ['skillspot.use'], 'method' => 'post', 'class' => 'form-inline']) !!}
                                        {!! Form::hidden("id", $spot->id) !!}
                                        <button type="submit" class="btn-link">Use</button>
                                        {!! Form::close() !!}
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        <br>
                        <b>NPCs</b>
                        <table>
                            @foreach($npcs as $npc)
                                <?php $op = \App\Http\Controllers\NpcController::getOption($npc->id) ?>
                                <tr>
                                    <td><img src='{{url('/img/icons/'.$op.'.png')}}'/></td>
                                    <td>&nbsp;{{$npc->name}}</td>
                                    {!! Form::open(['route' => ['npc.interact'], 'method' => 'post', 'class' => 'form-inline']) !!}
                                    {!! Form::hidden("id", $npc->id) !!}
                                    <td><button type="submit" class="btn-link"> {{$op}}</button></td>
                                    {!! Form::close() !!}
                                </tr>
                            @endforeach
                        </table>
                        <br>
                        <b>Objects</b>
                        <table>
                            @foreach($objects as $o)
                                <tr>
                                    <td><img src='{{url($skill->getIconPath($objectskills[$o->id]))}}'/></td>
                                    <td>&nbsp;{{$o->name}}</td>
                                    {!! Form::open(['route' => ['object.interact'], 'method' => 'post', 'class' => 'form-inline']) !!}
                                    {!! Form::hidden("id", $o->id) !!}
                                    <td><button type="submit" class="btn-link">Use</button></td>
                                    {!! Form::close() !!}
                                </tr>
                            @endforeach
                        </table>
                        <br>
                        <b>Mobs</b>
                        <table>
                            @foreach($mobs as $mob)
                                <tr>
                                    <td><img src='{{url('/img/items/unknown.png')}}'/></td>
                                    <td>{{$mob->name}}</td>
                                    {!! Form::open(['route' => ['attack.mob'], 'method' => 'post', 'class' => 'form-inline']) !!}
                                    {!! Form::hidden("id", $mob->id) !!}
                                    <td><button type="submit" class="btn-link">Attack</button></td>
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
