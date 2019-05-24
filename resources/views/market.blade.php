@extends('layouts.app')
@section('content')
    {{--load js inv script--}}
    <script>var redirect = '{{ url('')}}'</script>
    {{--load style --}}
    <script src="{{ asset('assets/vendor/market/market.js') }}"></script>
    <div class="main-content">
        <div class="container-fluid">
            <!-- OVERVIEW -->
            <div class="panel panel-headline">
                <div class="panel-heading">
                    <h3 class="panel-title">Marketplace</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <img style="width:16px;height:16px;" src="{{url($item->getIconPath(17))}}"/> <b>{{$gp}}
                                gp</b>
                        </div>
                        <div class="col-md-12">
                            <b>My Listings ({{count($userlistings)}})</b>
                        </div>
                        <div class="col-md-12">
                            <a href="{{url('newlisting')}}">New Listing</a>
                        </div>
                        @if(count($userlistings) > 0)
                            <div class="col-md-12">
                                <table border="1">
                                    <tr>
                                        <td><b>Item</b></td>
                                        <td><b>Sold</b></td>
                                        <td><b>Price</b></td>
                                        <td><b>Coffer</b></td>
                                        <td><b>Action</b></td>
                                    </tr>
                                    @foreach($userlistings as $l)
                                        <tr>
                                            <td>
                                                <img class="item" title="{{$item->getName($l->item_id)}}"
                                                     src="{{url($item->getIconPath($l->item_id))}}"/>
                                            </td>
                                            <td>{{$l->amount_sold}}/{{$l->amount}}</td>
                                            <td><img style="width:16px;height:16px;"
                                                     src="{{url($item->getIconPath(17))}}"/> {{($l->price)}}gp
                                            </td>
                                            @if ($l->amount_sold - $l->amount_collected > 0)
                                                <td><img style="width:16px;height:16px;"
                                                         src="{{url($item->getIconPath(17))}}"/> {{$l->price * ($l->amount_sold - $l->amount_collected)}}
                                                    gp
                                                </td>
                                                <td>
                                                    <form method="POST" action="{{url('/collectlisting')}}"
                                                          id="collect_market"
                                                          class="form-inline">
                                                        {{csrf_field()}}
                                                        <input type="hidden" name="id" value="{{$l->id}}"/>
                                                        <button class="btn btn-default">Collect</button>
                                                    </form>
                                                </td>
                                            @else
                                                <td>
                                                    The coffer is empty.
                                                </td>
                                                <td>
                                                    <form method="POST" action="{{url('/cancellisting')}}"
                                                          id="cancel_listing"
                                                          class="form-inline">
                                                        {{csrf_field()}}
                                                        <input type="hidden" name="id"  value="{{$l->id}}"/>
                                                        <button class="btn btn-default">Cancel</button>
                                                    </form>
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        @else
                            <div class="col-md-12">
                                <i>You currently have no market Listings.</i>
                            </div>
                        @endif
                        <br>
                        <div class="col-md-12">
                            <b>Search Listings</b>
                        </div>
                        <div class="col-md-12">
                            <form method="POST" action="{{url('/searchmarket')}}" id="search_market"
                                  class="form-inline">
                                {{csrf_field()}}
                                <select name="searchoption">
                                    <option value="item">Item</option>
                                    <option value="seller">Seller</option>
                                </select>
                                <input name="query" type="text" class="form-inline" autocomplete="off"/>
                                <button class="btn btn-default">Search</button>
                            </form>
                        </div>
                        <div class="col-md-12">
                            @if(!(isset($query) && isset($option)))
                                <i id="querytext">Showing: Most recent ({{count($listings)}})</i>
                            @else
                                <i id="querytext">Searching for {{$option}}: "{{$query}}" ({{count($listings)}})</i>
                            @endif
                        </div>
                        @if(count($listings) > 0)
                            <div class="col-md-12">
                                <table border="1">
                                    <tr>
                                        <td><b>Item</b></td>
                                        <td><b>Amount</b></td>
                                        <td><b>Price</b></td>
                                        <td width="30%"><b>Seller</b></td>
                                        <td><b>Action</b></td>
                                    </tr>
                                    @foreach($listings as $l)
                                        <tr>
                                            <td>
                                                <img class="item" title="{{$item->getName($l->item_id)}}"
                                                     src="{{url($item->getIconPath($l->item_id))}}"/>
                                            </td>
                                            <td>{{$l->amount - $l->amount_sold}}</td>
                                            <td><img style="width:16px;height:16px;"
                                                     src="{{url($item->getIconPath(17))}}"/> {{($l->price)}}gp
                                            </td>
                                            <td><a href="{{url('profile/'.(\App\User::find($l->user_id)->name))}}">{{\App\User::find($l->user_id)->name}}</a></td>
                                            <td>
                                                <form method="POST" action="{{url('/buylisting')}}" id="buy_market"
                                                      class="form-inline">
                                                    {{csrf_field()}}
                                                    <input type="number" name="amount" class="form-inline" min="1" value="1"
                                                           max="{{$l->amount - $l->amount_sold}}"/>
                                                    <input type="hidden" name="id" value="{{$l->id}}"/>
                                                    <button class="btn btn-default">Buy</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
