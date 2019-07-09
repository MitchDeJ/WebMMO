@extends('layouts.app')
@section('content')
    {{--load js inv script--}}
    <script>var redirect = '{{ url('')}}'</script>
    {{--load style --}}
    <div class="main-content">
        <div class="container-fluid">
            <!-- OVERVIEW -->
            <div class="panel panel-headline">
                <div class="panel-heading">
                    <h3 class="panel-title">Coinflip table &nbsp;<a href="{{url('location')}}"
                                                                    class="btn btn-sm btn-info"
                                                                    style="color: white;">Back to location</a></h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h4>New game</h4>
                            <form class="form-inline" method="POST" action="{{url('/newcoinflip')}}">
                                {{csrf_field()}}
                                <input type="number" name="bet" placeholder="Bet amount" class="form-control"
                                       style="width:10%"/>
                                <input type="submit" value="New game" class="btn btn-sm btn-success form-control"
                                       style="width:7%"/>
                            </form>
                        </div>
                        <div class="col-md-12">
                            <br>
                            <h4>My games</h4>
                            @if(count($myflips) > 0)
                            <table class="table table-responsive table-striped table-hover">
                                <thead>
                                <th width="20%">Host</th>
                                <th width="20%">Bet</th>
                                <th width="20%">Action</th>
                                </thead>
                                @foreach($myflips as $c)
                                    <tr>
                                        <td>{{\App\User::find($c->user_id)->name}}</td>
                                        <td><img style="width:16px;height:16px;"
                                                 src="{{url($items->getIconPath(17))}}"/> {{$c->bet}}</td>
                                        <td>
                                            <form method="POST" action="{{url('/removecoinflip')}}"
                                                  class="form-inline">
                                                {{csrf_field()}}
                                                <input type="hidden" name="id" value="{{$c->id}}"/>
                                                <button class="btn btn-danger">Remove</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                                @else
                            You don't have any active games.
                            @endif
                        </div>
                        <div class="col-md-12">
                            <br>
                            <h4>Active games</h4>
                            @if((count($coinflips) - count($myflips)) > 0)
                            <table class="table table-responsive table-striped table-hover">
                                <thead>
                                <th width="20%">Host</th>
                                <th width="20%">Bet</th>
                                <th width="20%">Action</th>
                                </thead>
                                @foreach($coinflips as $c)
                                    @if($c->user_id != Auth::user()->id)
                                        <tr>
                                            <td>{{\App\User::find($c->user_id)->name}}</td>
                                            <td><img style="width:16px;height:16px;"
                                                     src="{{url($items->getIconPath(17))}}"/> {{$c->bet}}</td>
                                            <td>
                                                <form method="POST" action="{{url('/playcoinflip')}}"
                                                      class="form-inline">
                                                    {{csrf_field()}}
                                                    <input type="hidden" name="id" value="{{$c->id}}"/>
                                                    <button class="btn btn-info">Play</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </table>
                            @else
                                Currently there aren't any active games.
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
