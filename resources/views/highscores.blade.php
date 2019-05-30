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
                    <h3 class="panel-title">Highscores |&nbsp; @if(isset($skill))<img
                                src="{{url($skill->getIconPath($skill->id))}}"/>
                        &nbsp;{{$skill->name}}@else{{$hsname}}@endif</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
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
                                @php $i=(($num-1) * $perPage) + 1 @endphp
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
                        <div class="col-md-1">
                            <form action="{{route("highscores.getPage")}}" method="POST" id="pageselect">
                                <label for="pageselect">Page</label>
                                {{csrf_field()}}
                                <select name="pageselected" class="form-control form-control-sm" form="pageselect"
                                        onchange="this.form.submit()">
                                    @for($i=1; $i<=$pages; $i++)
                                        <option value="{{$i}}"
                                                @if ($i == $num) selected="selected"@endif>{{$i}}</option>
                                    @endfor
                                </select>
                                @if(isset($skill))
                                    <input type="hidden" name="skill" value="{{$skill->name}}"/>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
