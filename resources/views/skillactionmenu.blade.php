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
                    <h3 class="panel-title"><img
                                src="{{url($skill->getIconPath($actions[0]->skill_id))}}"/> {{$object->name}} &nbsp;<a
                                href="{{url('location')}}"
                                class="btn btn-sm btn-primary" style="color: white;">Back to location</a></h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h4>Choose action</h4>
                            <div class="col-md-12">
                                <table class="table table-responsive table-hover">
                                    <thead>
                                    <tr>
                                        <th>Tool</th>
                                        <th>Required items</th>
                                        <th>Time</th>
                                        <th>Success rate</th>
                                        <th>Product</th>
                                        <th>XP</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    @php $i=0 @endphp
                                    @foreach($actions as $a)
                                        <tr>
                                            <td>
                                                @if($a->tool_item != null)
                                                    <img title="{{$item->getName($a->tool_item)}}" class="item"
                                                         src="{{url($item->getIconPath($a->tool_item))}}"/>
                                                @endif
                                            </td>
                                            <td>
                                                @if($a->req_item != null)
                                                    {{$a->req_item_amount}}x
                                                    <img title="{{$item->getName($a->req_item)}}" class="item"
                                                         src="{{url($item->getIconPath($a->req_item))}}"/>
                                                @endif
                                                @if($a->req_item_2 != null)
                                                    {{$a->req_item_2_amount}}x
                                                    <img title="{{$item->getName($a->req_item_2)}}" class="item"
                                                         src="{{url($item->getIconPath($a->req_item_2))}}"/>
                                                @endif
                                            </td>
                                            <td>
                                                {{$a->delay}} seconds
                                            </td>
                                            <td>
                                                {{$a->success_chance * 100}}%
                                            </td>
                                            <td>
                                                @if($a->product_item != null)
                                                    {{$a->product_item_amount}}x
                                                    <img src="{{url($item->getIconPath($a->product_item))}}"
                                                         class="item" title="{{$item->getName($a->product_item)}}"/>
                                                @endif
                                            </td>
                                            <td>
                                                {{$a->xp_amount}} XP
                                            </td>
                                            <td>
                                                <form method="POST" action="{{route("selectaction")}}">
                                                    {{csrf_field()}}
                                                    <input name="i" type="hidden" value="{{$i}}" />
                                                    <input name="obj" type="hidden" value="{{$object->id}}" />
                                                    <button class="btn btn-primary">Select</button>
                                                </form>
                                            </td>
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
