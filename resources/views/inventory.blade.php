@extends('layouts.app')
@section('content')
    <div class="main-content">
        <div class="container-fluid">
            <!-- OVERVIEW -->
            <div class="panel panel-headline">
                <div class="panel-heading">
                    <h3 class="panel-title">Inventory</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <table border=1>
                            @for($i=1; $i<=28; $i+=4)
                                <tr>
                                    <td>
                                        <a href="{{url("useitem/".$i)}}" ><img
                                                    src='{{url($items->getIconPath($slots[$i]->item_id))}}'/></a>
                                        @if($slots[$i]->amount > 0)
                                            <sub>{{$slots[$i]->amount}}</sub>@endif
                                    </td>

                                    <td>
                                        <a href="{{url("useitem/".($i+1))}}"><img
                                                    src='{{url($items->getIconPath($slots[$i + 1]->item_id))}}'/></a>
                                        @if($slots[$i + 1]->amount > 0)
                                            <sub>{{$slots[$i + 1]->amount}}</sub>@endif
                                    </td>

                                    <td>
                                        <a href="{{url("useitem/".($i+2))}}"><img
                                                    src='{{url($items->getIconPath($slots[$i + 2]->item_id))}}'/></a>
                                        @if($slots[$i + 2]->amount > 0)
                                            <sub>{{$slots[$i + 2]->amount}}</sub>@endif
                                    </td>

                                    <td>
                                        <a href="{{url("useitem/".($i+3))}}"><img
                                                    src='{{url($items->getIconPath($slots[$i + 3]->item_id))}}'/></a>
                                        @if($slots[$i + 3]->amount > 0)
                                            <sub>{{$slots[$i + 3]->amount}}</sub>@endif
                                    </td>
                                </tr>
                            @endfor
                        </table>
                        <br>
                        <p>Equips</p>
                        <table border="1">
                            <tr>
                                <td><a href="{{url("unequip/0")}}"><img src='{{url($items->getIconPath($equips[0]))}}'/></a></td>
                                <td><a href="{{url("unequip/1")}}"><img src='{{url($items->getIconPath($equips[1]))}}'/></a></td>
                                <td><a href="{{url("unequip/2")}}"><img src='{{url($items->getIconPath($equips[2]))}}'/></a></td>
                            </tr>
                            <tr>
                                <td><a href="{{url("unequip/3")}}"><img src='{{url($items->getIconPath($equips[3]))}}'/></a></td>
                                <td><a href="{{url("unequip/4")}}"><img src='{{url($items->getIconPath($equips[4]))}}'/></a></td>
                                <td><a href="{{url("unequip/5")}}"><img src='{{url($items->getIconPath($equips[5]))}}'/></a></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
