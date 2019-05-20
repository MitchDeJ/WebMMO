@extends('layouts.app')
@section('content')
    {{--load js inv script--}}
    <script>var redirect = '{{ url('')}}'</script>
    {{--load style --}}
    <link rel="stylesheet" href="{{ asset('assets/vendor/inventory/inventory_style.css') }}">
    <script src="{{ asset('assets/vendor/inventory/shop.js') }}"></script>
    <div class="main-content">
        <div class="container-fluid">
            <!-- OVERVIEW -->
            <div class="panel panel-headline">
                <div class="panel-heading">
                    <h3 class="panel-title">{{$shop->name}}</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table border="1">
                                <tr>
                                @foreach($shopitems as $i)
                                        <td>
                                            <span class="shop_slot" title='{{$items->getName($i->item_id)}}' id="{{$i->id}}">
                                                    <img class="item"
                                                         src='{{url($items->getIconPath($i->item_id))}}'/>
                                                <p hidden>{{$i->sell_price}}</p>
                                            </span>
                                        </td>
                                        @endforeach
                                    </tr>
                                <tr>
                                    @foreach($shopitems as $i)
                                        <td>
                                            <img style="width:16px;height:16px;" src="{{url($items->getIconPath(17))}}"/> {{$i->sell_price}}gp
                                        </td>
                                    @endforeach
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-12">
                            <br>
                            <img style="width:16px;height:16px;" src="{{url($items->getIconPath(17))}}"/> <b>{{$gp}}gp</b>
                        </div>
                        <div class="col-md-4">
                            <br>
                            <div id="buy_details"><i>Choose an item you'd like to buy.</i></div>
                            {!! Form::open(['id'=>'buy_menu','route' => ['shop.buy'], 'method' => 'post', 'class' => 'form-inline', 'hidden' => 'true', 'onsubmit' => 'clearPost();']) !!}
                            {!! Form::hidden("shopitemid", $shopitems->first()->id) !!}
                            {!! Form::hidden("shopid", $shop->id) !!}
                            {!! Form::input('number', 'amount', 1, ['class' => 'form-control',
                             'min' => 1, 'step' => 1]) !!}
                            {!! Form::input('text', 'pricetotal', '1gp', ['class' => 'form-control',
                             'min' => 1, 'step' => 1, 'disabled']) !!}
                            <button type="submit" class="btn btn-default">Buy</button>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
