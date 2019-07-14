@extends('layouts.app')
@section('content')
    <script>
        var redirect = '{{ url('')}}'
        var cd = '{{$cd}}';
        var combatcd = '{{$combatcd}}';
    </script>
    <script src="{{ asset('assets/vendor/location/location.js') }}"></script>

    <div class="main-content">
        <div class="container-fluid">
            <!-- OVERVIEW -->
            <div class="row">

                <div class="col-md-6">
                    <div class="panel panel-headline">
                        <div class="panel-heading">
                            <h3 class="panel-title">{{$location->name}}</h3>
                            <p class="panel-subtitle">{{$location->description}}</p>
                        </div>
                        <div class="panel-body">
                            <ul class="list-unstyled activity-list">

                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">NPCs</h3>
                        </div>
                        <div class="panel-body">
                            @if(count($npcs) > 0)
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
                            @else
                                <p style="color:#8D99A8">There are no NPCs in this area.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">Skilling spots</h3>
                        </div>
                        <div class="panel-body">
                            <div id="skillstatus"></div>
                            @if(count($skillspots) > 0)
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
                            @else
                                <p style="color:#8D99A8">There are no skilling spots in this area.</p>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">Objects</h3>
                        </div>
                        <div class="panel-body">
                            @if(count($objects) > 0)
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
                            @else
                                <p style="color:#8D99A8">There are no objects in this area.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">Mobs</h3>
                        </div>
                        <div class="panel-body">
                            @if(count($mobs) > 0)
                                <table>
                                    @foreach($mobs as $mob)
                                        <tr>
                                            <td><img src='{{url('/img/items/unknown.png')}}'/></td>
                                            <td>{{$mob->name}}</td>
                                            {!! Form::open(['route' => ['attack.mob'], 'method' => 'post', 'class' => 'form-inline']) !!}
                                            {!! Form::hidden("id", $mob->id) !!}
                                            <td>
                                                <button type="submit" class="btn-link attackmob">Attack</button>
                                            </td>
                                            {!! Form::close() !!}
                                        </tr>
                                    @endforeach
                                </table>
                            @else
                                <p style="color:#8D99A8">There are no mobs in this area.</p>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">Players ({{count($players)}})</h3>
                        </div>
                        <div class="panel-body">
                            @if(count($players) > 0)
                                <table>
                                    @foreach($players as $p)
                                        <tr>
                                            <td><img src='{{url('/img/icons/view.png')}}'/></td>
                                            <td><b style="color:{{Titles::getTitles()[$p->title][2]}}">
                                                    {{Titles::getTitles()[$p->title][0]}}</b> {{$p->name}}</td>
                                            <form action="{{url('/profile/'.$p->name)}}">
                                                <td>
                                                    <button class="btn-link">View profile</button>
                                                </td>
                                            </form>
                                        </tr>
                                    @endforeach
                                </table>
                            @else
                                <p style="color:#8D99A8">There are no other players in this area.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
