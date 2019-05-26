@extends('layouts.app')
@section('content')
    <script>
        var redirect = '{{ url('')}}';
        var startTime = '{{$userAction->start}}';
        var goal = '{{$action->delay * $userAction->amount}}';
        var results = '{!! json_encode($results, JSON_HEX_TAG) !!}';
        var token = '{!! csrf_field() !!}';
    </script>
    <script src="{{ asset('assets/vendor/skillaction/skillaction.js') }}"></script>
    <script src="{{ asset('assets/vendor/tooltips.js') }}"></script>
    <div class="main-content">
        <div class="container-fluid">
            <!-- OVERVIEW -->
            <div class="panel panel-headline">
                <div class="panel-heading">
                    <h3 class="panel-title"><img
                                src="{{url($skill->getIconPath($action->skill_id))}}"/> {{$skill->getName($action->skill_id)}} &nbsp;<a
                                href="{{url('location')}}" class="btn btn-sm btn-primary" style="color: white;">Back to
                            location</a></h3>
                    </h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <!-- CONTENT START -->
                            @if($action->tool_item !=null)
                                <p><b>Tool</b></p>
                                <p>- <img title="{{$item->getName($action->tool_item)}}" class="item"
                                          src='{{url($item->getIconPath($action->tool_item))}}'/></p>
                            @endif
                            <p><b>Input</b></p>
                            @if($action->req_item != null)
                                <p>- {{$userAction->amount * $action->req_item_amount}}x <img
                                            src='{{url($item->getIconPath($action->req_item))}}' class="item"
                                            title="{{$item->getName($action->req_item)}}"/></p>
                            @endif
                            @if($action->req_item_2 != null)
                                <p>- {{$userAction->amount * $action->req_item_2_amount}}x <img
                                            src='{{url($item->getIconPath($action->req_item_2))}}' class="item"
                                            title="{{$item->getName($action->req_item_2)}}"/></p>
                            @endif
                            @if($action->success_chance != 1.0)
                                <p><b>Output on success ({{$action->success_chance * 100}}% chance)</b></p>
                                @if($action->product_item != null)
                                    <p>+ {{$action->product_item_amount}}x <img
                                                src='{{url($item->getIconPath($action->product_item))}}' class="item"
                                                title="{{$item->getName($action->product_item)}}"/></p>
                                    <p>+ {{$action->xp_amount}} {{$skill->getName($action->skill_id)}} XP</p>
                                @endif
                            @else
                                <p><b>Output:</b></p>
                                @if($action->product_item != null)
                                    <p>+ {{$action->product_item_amount * $userAction->amount}}x <img class="item" src='{{url($item->getIconPath($action->product_item))}}'
                                                                                                      title="{{$item->getName($action->product_item)}}"/></p>
                                    <p>+ {{$action->xp_amount * $userAction->amount}}
                                        {{$skill->getName($action->skill_id)}} XP</p>
                                @endif
                            @endif
                            <p><b>Action details</b></p>
                            <p>Time per action: <b>{{$action->delay}}s</b></p>
                            <p>Total time: <b>{{$action->delay * $userAction->amount}}s</b></p>
                            <br>
                            <p><b>Progress</b></p>
                            <div id="progressBar" class="progressBar" style="width:20%">
                                <div class="bar" style="background-color:cornflowerblue"></div>
                            </div>
                            <br>
                            <div id="result"></div>
                            <br>
                            <div id="completion"></div>
                            <!-- CONTENT END -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
