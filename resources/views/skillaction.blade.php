@extends('layouts.app')

@section('content')
    <script>
        var redirect = '{!! url('') !!}';
        var token = '{!! csrf_field() !!}';
    </script>
    <script src="{{ asset('assets/vendor/tooltips.js') }}"></script>
    <div class="main-content">
        <div class="container-fluid">
            <!-- OVERVIEW -->
            <div class="panel panel-headline">
                <div class="panel-heading">
                    <h3 class="panel-title"><img
                                src="{{url($skill->getIconPath($action->skill_id))}}"/> {{$object->name}} &nbsp;<a
                                href="{{url('location')}}" class="btn btn-sm btn-primary" style="color: white;">Back to
                            location</a></h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <b>To complete this action you need:</b><br>
                            @if($action->tool_item != null)
                                - <img title="{{$item->getName($action->tool_item)}}" class="item" src="{{url($item->getIconPath($action->tool_item))}}"/>
                            @endif
                            @if($action->req_item != null)
                                - {{$action->req_item_amount}}x
                                <img title="{{$item->getName($action->req_item)}}" class="item" src="{{url($item->getIconPath($action->req_item))}}"/>
                            @endif
                            @if($action->req_item_2 != null)
                                - {{$action->req_item_2_amount}}x
                                <img title="{{$item->getName($action->req_item_2)}}" class="item" src="{{url($item->getIconPath($action->req_item_2))}}"/>
                            @endif
                            <p><br><b>Action details</b></p>
                            <p>Time per action: <b>{{$action->delay}}s</b></p>
                            @if ($action->succes_chance != 1.0)
                                <p>Success rate: <b>{{$action->success_chance * 100}}%</b></p>
                            @endif
                            <p><br><b>Upon success you will receive:</b></p>
                            @if($action->product_item != null)
                                <p>- {{$action->product_item_amount}}x
                                    <img src="{{url($item->getIconPath($action->product_item))}}" class="item" title="{{$item->getName($action->product_item)}}"/></p>
                            @endif
                            - {{$action->xp_amount}} {{$skill->getName($action->skill_id)}} XP
                            <br><br>
                            <p><b>Start action</b></p>
                            <p>Amount</p>
                            {!! Form::open(['route' => ['start.action'], 'method' => 'post', 'class' => 'form-inline']) !!}
                            {!! Form::hidden("id", $object->id) !!}
                            {!! Form::input('number', 'amount', $max, ['class' => 'form-control',
                             'min' => 1, 'max' => $max, 'step' => 1]) !!}
                            @if(isset($i))
                            <input type="hidden" name="i" value={{$i}} />
                            @endif
                            <button type="submit" class="btn btn-default">Start</button>
                            {!! Form::close() !!}
                        </div>
                    </div>
                    <!-- CONTENT END -->
                </div>
            </div>
        </div>
    </div>
@endsection
