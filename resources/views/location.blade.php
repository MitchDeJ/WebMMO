@extends('layouts.app')
@section('content')
    <script>
        var redirect = '{{ url('')}}'
        var cd = '{{$cd}}';
    </script>
    <script src="{{ asset('assets/vendor/location/location.js') }}"></script>
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
                        <div id="skillstatus">&nbsp;</div>
                        <b>Skilling spots</b>
                        <table>
                            @foreach($skillspots as $spot)
                                <tr>
                                    <td><img src='{{url($skill->getIconPath($spot->skill_id))}}'/></td>
                                    <td>{{$spot->name}}</td>
                                    <td>
                                        <p hidden>{{$spot->id}}</p>
                                        <button class="btn-link usespot">Use</button>
                                    </td>
                                    <td style="display: block; position: relative;">
                                        <img class="animitem" style="position: absolute; opacity: 0"
                                             src={{url($item->getIconPath($spot->item_id))}}>
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
                                    <td>
                                        <button type="submit" class="btn-link"> {{$op}}</button>
                                    </td>
                                    {!! Form::close() !!}
                                </tr>
                            @endforeach
                        </table>
                        <br>
                        <b>Objects</b>
                        <table>
                            @foreach($objects as $o)
                                <tr>
                                    <td><img src='{{$o->getIconPath()}}'/></td>
                                    <td>&nbsp;{{$o->name}}</td>
                                    {!! Form::open(['route' => ['object.interact'], 'method' => 'post', 'class' => 'form-inline']) !!}
                                    {!! Form::hidden("id", $o->id) !!}
                                    <td>
                                        <button type="submit" class="btn-link">Use</button>
                                    </td>
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
                                    <td>
                                        <button type="submit" class="btn-link">Attack</button>
                                    </td>
                                    {!! Form::close() !!}
                                </tr>
                            @endforeach
                        </table>
                        <br>
                        <b>Players ({{count($players)}})</b>
                        <table>
                            @foreach($players as $p)
                                <tr>
                                    <td><img src='{{url('/img/icons/view.png')}}'/></td>
                                    <td>{{$p->name}}</td>
                                    <form action="{{url('/profile/'.$p->name)}}">
                                        <td>
                                            <button class="btn-link">View profile</button>
                                        </td>
                                    </form>
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
