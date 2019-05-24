@extends('layouts.app')
@section('content')
    {{--load js inv script--}}
    <script>
        var redirect = '{{ url('')}}';
        var counts = '{!! json_encode($counts, JSON_HEX_TAG) !!}';
    </script>
    {{--load style --}}
    <script src="{{ asset('assets/vendor/market/newlisting.js') }}"></script>
    <div class="main-content">
        <div class="container-fluid">
            <!-- OVERVIEW -->
            <div class="panel panel-headline">
                <div class="panel-heading">
                    <h3 class="panel-title">Marketplace > New Listing</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form method="POST" action="{{url('/submitlisting')}}" id="submit_listing" class="form-inline">
                                <input type="number" name="amount" id="amount"  min="1" placeholder="Amount"/>
                                <select name="itemselect" id="itemselect">
                                    @foreach($sellables as $s)
                                        <option value="{{$s['itemId']}}">{{$s['itemName']}}</option>
                                    @endforeach
                                </select>
                                <br>
                                <input type="number" name="price" id="price"  min="1" placeholder="Price (ea)"/>
                                <input type="text" name="total" id="total"  min="1" placeholder="Total price" disabled/>
                                {{csrf_field()}}
                                <br>
                                <button class="btn btn-default">Create</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
