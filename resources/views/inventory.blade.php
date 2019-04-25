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
                            @for($i=1; $i<=24; $i+=4)
                                <tr>
                                    <td>
                                        <img src='{{url($items->getIconPath($slots[$i]->item_id))}}'/>
                                        @if($slots[$i]->amount > 0)
                                            <sub>{{$slots[$i]->amount}}</sub>@endif
                                    </td>

                                    <td>
                                        <img src='{{url($items->getIconPath($slots[$i + 1]->item_id))}}'/>
                                        @if($slots[$i + 1]->amount > 0)
                                            <sub>{{$slots[$i + 1]->amount}}</sub>@endif
                                    </td>

                                    <td>
                                        <img src='{{url($items->getIconPath($slots[$i + 2]->item_id))}}'/>
                                        @if($slots[$i + 2]->amount > 0)
                                        <sub>{{$slots[$i + 2]->amount}}</sub>@endif
                                    </td>

                                    <td>
                                        <img src='{{url($items->getIconPath($slots[$i + 3]->item_id))}}'/>
                                        @if($slots[$i + 3]->amount > 0)
                                        <sub>{{$slots[$i + 3]->amount}}</sub>@endif
                                    </td>
                                </tr>
                            @endfor
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
