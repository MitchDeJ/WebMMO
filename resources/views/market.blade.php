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
                    <h3 class="panel-title">Marketplace &nbsp<a href="{{url('newlisting')}}"
                                                                class="btn btn-sm btn-success" style="color: white;">New
                            listing</a></h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h4>My Listings ({{count($userlistings)}})</h4>
                        </div>
                        @if(count($userlistings) > 0)
                            <div class="col-md-12">
                                <table class="table table-responsive table-hover">
                                    <thead>
                                    <tr>
                                        <th><b>Item</b></th>
                                        <th><b>Sold</b></th>
                                        <th><b>Price</b></th>
                                        <th><b>Coffer</b></th>
                                        <th><b>Action</b></th>
                                    </tr>
                                    </thead>
                                    @foreach($userlistings as $l)
                                        @if($l->amount_sold == $l->amount)
                                            <tr style="background-color:rgba(50,205,50, 0.3);">
                                        @elseif($l->amount_collected < $l->amount_sold)
                                            <tr style="background-color:rgba(255,165,0, 0.3);">
                                        @else
                                            <tr>
                                                @endif
                                                <td>
                                                    <img class="item" title="{{$item->getName($l->item_id)}}"
                                                         src="{{url($item->getIconPath($l->item_id))}}" width="26px"
                                                         height="26px"/>
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
                                                        Empty
                                                    </td>
                                                    <td>
                                                        <form method="POST" action="{{url('/cancellisting')}}"
                                                              id="cancel_listing"
                                                              class="form-inline">
                                                            {{csrf_field()}}
                                                            <input type="hidden" name="id" value="{{$l->id}}"/>
                                                            <button class="btn btn-sm btn-danger">Cancel</button>
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
                            <h4>Search Listings</h4>
                        </div>
                        <div class="col-md-12">
                            <form method="POST" action="{{url('/searchmarket')}}" id="search_market"
                                  class="form-inline">
                                {{csrf_field()}}
                                <select name="searchoption" class="form-control">
                                    <option value="item">Item</option>
                                    <option value="seller">Seller</option>
                                </select>
                                <input name="query" type="text" class="form-control form-inline" autocomplete="off"/>
                                <button class="btn btn-default">Search</button>
                            </form>
                            <br>
                        </div>
                        <div class="col-md-12">
                            @if(!(isset($query) && isset($option)))
                                <h4 id="querytext">Showing: Most recent ({{count($listings)}})</h4>
                            @else
                                <h4 id="querytext">Searching for {{$option}}: "{{$query}}" ({{count($listings)}})</h4>
                            @endif
                        </div>
                        @if(count($listings) > 0)
                            <div class="col-md-12">
                                <table class="table table-responsive table-hover">
                                    <thead>
                                    <tr>
                                        <th><b>Item</b></th>
                                        <th><b>Amount</b></th>
                                        <th><b>Price</b></th>
                                        <th width="30%"><b>Seller</b></th>
                                        <th><b>Action</b></th>
                                    </tr>
                                    </thead>
                                    @foreach($listings as $l)
                                        <tr>
                                            <td>
                                                <img class="item" title="{{$item->getName($l->item_id)}}"
                                                     src="{{url($item->getIconPath($l->item_id))}}" width="26px"
                                                     height="26px"/>
                                            </td>
                                            <td>{{$l->amount - $l->amount_sold}}</td>
                                            <td><img style="width:16px;height:16px;"
                                                     src="{{url($item->getIconPath(17))}}"/> {{($l->price)}}gp
                                            </td>
                                            <td>
                                                <a href="{{url('profile/'.(\App\User::find($l->user_id)->name))}}">{{\App\User::find($l->user_id)->name}}</a>
                                            </td>
                                            <td>
                                                <form method="POST" action="{{url('/buylisting')}}" id="buy_market"
                                                      class="form-inline">
                                                    {{csrf_field()}}
                                                    <input type="number" name="amount" class="form-control form-inline"
                                                           min="1"
                                                           value="1"
                                                           max="{{$l->amount - $l->amount_sold}}"/>
                                                    <input type="hidden" name="id" value="{{$l->id}}"/>
                                                    <button class="btn btn-primary">Buy</button>
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
