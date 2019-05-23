@extends('layouts.app')
@section('content')
    {{--load js inv script--}}
    <script>var redirect = '{{ url('')}}'</script>
    <script src="{{ asset('assets/vendor/inventory/inventory.js') }}"></script>
    {{--load style --}}
    <link rel="stylesheet" href="{{ asset('assets/vendor/inventory/inventory_style.css') }}">
    <div class="main-content">
        <div class="container-fluid">
            <!-- OVERVIEW -->
            <div class="panel panel-headline">
                <div class="panel-heading">
                    <h3 class="panel-title">Inventory</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        @include('layouts.inventorytemp')
                        <div class="col-md-2"
                             style="height: 280px; width: 264px; border:1px solid black; text-align: center">
                            <div class="item-infos"></div>
                            <div class="options"></div>
                        </div>
                    </div>
                    <div class="row">
                        <p>Equips</p>
                        <div class="col-md-12">
                            <table border="1">
                                <tr>
                                    @for($i=0;$i<3;$i++)
                                        <td>
                                        <div class="equip_slot" id='e{{$i}}'>
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
