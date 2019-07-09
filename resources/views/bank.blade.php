@extends('layouts.app')
@section('content')
    <script>
        var redirect = '{{ url('')}}';
        var placeholders = '{!! json_encode($eqplaceholders, JSON_HEX_TAG) !!}';
    </script>
    <script src="{{ asset('assets/vendor/inventory/inventory_bank.js') }}"></script>
    <div class="main-content">
        <div class="container-fluid">
            <!-- OVERVIEW -->
            <div class="panel panel-headline">
                <div class="panel-heading">
                    <h3 class="panel-title">Bank &nbsp;<a
                                href="{{url('location')}}" class="btn btn-sm btn-primary" style="color: white;">Back to
                            location</a></h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-4">
                            <p>Bank</p>
                            @include('layouts.banktemp')
                        </div>
                        <div class="col-md-2">
                            <p>Inventory</p>
                            @include('layouts.inventorytemp')
                        </div>
                        <div class="col-md-6">
                            <p>Equips</p>
                            <table class="equip-table">
                                <tr>
                                    @for($i=0;$i<3;$i++)
                                        <td>
                                            <div class="equip_slot" id='e{{$i}}'>
                                                @if($equips[$i] == null)
                                                    <img class="equip_placeholder" src="{{url($eqplaceholders[$i])}}"/>
                                                @endif
                                                <div class="equip_item" @if($equips[$i] != null)
                                                title="{{$items->getName($equips[$i])}}"@endif>
                                                    <img src='{{url($items->getIconPath($equips[$i]))}}'/>
                                                </div>
                                            </div>
                                        </td>
                                    @endfor
                                </tr>
                                <tr>
                                    @for($i=3;$i<6;$i++)
                                        <td>
                                            <div class="equip_slot" id='e{{$i}}'>
                                                @if($equips[$i] == null)
                                                    <img class="equip_placeholder"  src="{{url($eqplaceholders[$i])}}"/>
                                                @endif
                                                <div class="equip_item" @if($equips[$i] != null)
                                                title="{{$items->getName($equips[$i])}}"@endif>
                                                    <img src='{{url($items->getIconPath($equips[$i]))}}'/>
                                                </div>
                                            </div>
                                        </td>
                                    @endfor
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
