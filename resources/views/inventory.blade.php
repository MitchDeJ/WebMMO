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
                        <div class="col-md-2">
                            <table>
                                @for($i=1; $i<=28; $i+=4)
                                    <tr>
                                        <td>
                                            <div class="inv_slot" id='{{$i}}'>
                                                @if($slots[$i]->item_id != null)
                                                    <img class="item"
                                                         src='{{url($items->getIconPath($slots[$i]->item_id))}}'/>
                                                @endif
                                                <span class="slot_pos"></span>
                                            </div>
                                        </td>

                                        <td>
                                            <div class="inv_slot" id='{{$i + 1}}'>
                                                @if($slots[$i + 1]->item_id != null)
                                                    <img class="item"
                                                         src='{{url($items->getIconPath($slots[$i + 1]->item_id))}}'/>
                                                @endif
                                                <span class="slot_pos"></span>
                                            </div>
                                        </td>

                                        <td>
                                        <td>
                                            <div class="inv_slot" id='{{$i + 2}}'>
                                                @if($slots[$i + 2]->item_id != null)
                                                    <img class="item"
                                                         src='{{url($items->getIconPath($slots[$i + 2]->item_id))}}'/>
                                                @endif
                                                <span class="slot_pos"></span>
                                            </div>
                                        </td>
                                        </td>

                                        <td>
                                            <div class="inv_slot" id='{{$i + 3}}'>
                                                @if($slots[$i + 3]->item_id != null)
                                                    <img class="item"
                                                         src='{{url($items->getIconPath($slots[$i + 3]->item_id))}}'/>
                                                @endif
                                                <span class="slot_pos"></span>
                                            </div>
                                        </td>
                                    </tr>
                                @endfor
                            </table>
                        </div>
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
                                    <td><a href="{{url("unequip/0")}}"><img
                                                    src='{{url($items->getIconPath($equips[0]))}}'/></a>
                                    </td>
                                    <td><a href="{{url("unequip/1")}}"><img
                                                    src='{{url($items->getIconPath($equips[1]))}}'/></a>
                                    </td>
                                    <td><a href="{{url("unequip/2")}}"><img
                                                    src='{{url($items->getIconPath($equips[2]))}}'/></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td><a href="{{url("unequip/3")}}"><img
                                                    src='{{url($items->getIconPath($equips[3]))}}'/></a>
                                    </td>
                                    <td><a href="{{url("unequip/4")}}"><img
                                                    src='{{url($items->getIconPath($equips[4]))}}'/></a>
                                    </td>
                                    <td><a href="{{url("unequip/5")}}"><img
                                                    src='{{url($items->getIconPath($equips[5]))}}'/></a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
