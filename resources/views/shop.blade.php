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
                    <h3 class="panel-title">{{$shop->name}} &nbsp;<a href="{{url('location')}}"
                                                               class="btn btn-sm btn-info"
                                                               style="color: white;">Back to location</a></h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h3>Buy</h3>
                            <table border="1">
                                <tr>
                                    @foreach($shopitems as $i)
                                        <td>
                                            <span class="shop_slot" title='{{$items->getName($i->item_id)}}'
                                                  id="{{$i->id}}">
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
                                            <img style="width:16px;height:16px;"
                                                 src="{{url($items->getIconPath(17))}}"/> {{$i->sell_price}}gp
                                        </td>
                                    @endforeach
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-4">
                            <br>
                            @if(count($shopitems) > 0)
                                <div id="buy_details"><i>Choose an item you'd like to buy.</i></div>
                            @else
                                <div id="buy_details"><i>This shop is currently not selling any items.</i></div>
                            @endif
                            {!! Form::open(['id'=>'buy_menu','route' => ['shop.buy'], 'method' => 'post', 'class' => 'form-inline', 'hidden' => 'true']) !!}
                            {!! Form::hidden("shopitemid", $shopitems->first()->id) !!}
                            {!! Form::hidden("shopid", $shop->id) !!}
                            {!! Form::input('number', 'amount', 1, ['class' => 'form-control',
                             'min' => 1, 'step' => 1, 'style' => 'width:15%']) !!}
                            {!! Form::input('text', 'pricetotal', '1gp', ['class' => 'form-control',
                             'min' => 1, 'step' => 1, 'disabled', 'style' => 'width:25%']) !!}
                            <button type="submit" class="btn btn-default">Buy</button>
                            {!! Form::close() !!}
                        </div>
                        <div class="col-md-12">
                            <h3>Sell</h3>
                            <table border="1">
                                <tr>
                                    @foreach($canSell as $i)
                                        <td>
                                            <span class="shop_sell_slot" title='{{$items->getName($i[0]->item_id)}}'
                                                  id="{{$i[0]->item_id}}">
                                                    <img class="item"
                                                         src='{{url($items->getIconPath($i[0]->item_id))}}'/>
                                                <p hidden>{{$i[0]->buy_price}}</p>
                                                <i hidden>{{$i[1]}}</i>
                                            </span>
                                        </td>
                                    @endforeach
                                </tr>
                                <tr>
                                    @foreach($canSell as $i)
                                        <td>
                                            <img style="width:16px;height:16px;"
                                                 src="{{url($items->getIconPath(17))}}"/> {{$i[0]->buy_price}}gp
                                        </td>
                                    @endforeach
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-4">
                            <br>
                            @if(count($canSell) > 0)
                                <div id="sell_details"><i>Choose an item you'd like to sell.</i></div>
                                {!! Form::open(['id'=>'sell_menu','route' => ['shop.sell'], 'method' => 'post', 'class' => 'form-inline', 'hidden' => 'true']) !!}
                                {!! Form::hidden("shopsellitemid", $canSell[0][0]->first()->item_id) !!}
                                {!! Form::hidden("shopid", $shop->id) !!}
                                {!! Form::input('number', 'sellamount', 1, ['class' => 'form-control',
                                 'min' => 1, 'step' => 1, 'style' => 'width:15%']) !!}
                                {!! Form::input('text', 'sellpricetotal', '1gp', ['class' => 'form-control',
                                 'min' => 1,  'step' => 1, 'disabled', 'style' => 'width:25%']) !!}
                                <button type="submit" class="btn btn-default">Sell</button>
                                {!! Form::close() !!}
                            @else
                                <div id="sell_details"><i>You are not carrying an item which this shop wants to buy.</i></div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
