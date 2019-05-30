@extends('layouts.app')
@section('content')
    {{--load js inv script--}}
    <script>var redirect = '{{ url('')}}'</script>
    {{--load style --}}
    <script src="{{ asset('assets/vendor/tooltips.js') }}"></script>
    <div class="main-content">
        <div class="container-fluid">
            <!-- OVERVIEW -->
            <div class="panel panel-headline">
                <div class="panel-heading">
                    <h3 class="panel-title">Highscores |&nbsp; @if(isset($skill))<img src="{{url($skill->getIconPath($skill->id))}}"/>
                        &nbsp;{{$skill->name}}@else{{$hsname}}@endif</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-12">
                                <table class="table table-responsive table-hover table-striped">
                                    <thead>
                                    <tr>
                                        <th width="4%">Rank</th>
                                        <th width="6%">Player</th>
                                        <th width="4%">{{$hsname}}</th>
                                        <th width="20%">XP</th>
                                    </tr>
                                    </thead>
                                    @php $i=1 @endphp
                                    @foreach($users as $u)
                                        <tr>
                                            <td>#{{$i}}</td>
                                            <td><a
                                                        href="{{url('/profile/'.$u->name)}}">{{$u->name}}</a></td>
                                            @if(isset($skill))
                                                <td>{{$u->getLevel($skill->id)}}</td>
                                                <td>{{$u->getXp($skill->id)}}</td>
                                            @else
                                                <td>{{$u->getTotalLevel()}}</td>
                                                <td>{{$u->getTotalXp()}}</td>
                                            @endif
                                        </tr>
                                        @php $i++ @endphp
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
