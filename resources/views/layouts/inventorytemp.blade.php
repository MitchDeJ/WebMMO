<script src="{{ asset('assets/vendor/inventory/inventory.js') }}"></script>
<link rel="stylesheet" href="{{ asset('assets/vendor/inventory/inventory_style.css') }}">
<div class="col-md-2">
    <table>
        @for($i=1; $i<=28; $i+=4)
            <tr>
                <td>
                    <div class="inv_slot" id='{{$i}}'>
                        @if($slots[$i]->item_id != null)
                            <div class="item" @if($slots[$i]->item_id != null)
                            title="{{$items->getName($slots[$i]->item_id)}}
                            @if ($items->isStackable($slots[$i]->item_id))
                                    ({{$slots[$i]->amount}})
                                                    @endif
                                    "
                                    @endif>
                                <img src='{{url($items->getIconPath($slots[$i]->item_id))}}'/>
                            </div>
                        @endif
                        <span class="slot_pos"></span>
                    </div>
                </td>

                <td>
                    <div class="inv_slot" id='{{$i + 1}}'>
                        @if($slots[$i + 1]->item_id != null)
                            <div class="item" @if($slots[$i + 1]->item_id != null)
                            title="{{$items->getName($slots[$i + 1]->item_id)}}
                            @if ($items->isStackable($slots[$i + 1]->item_id))
                                    ({{$slots[$i + 1]->amount}})
                                                    @endif
                                    "
                                    @endif>
                                <img src='{{url($items->getIconPath($slots[$i + 1]->item_id))}}'/>
                            </div>
                        @endif
                        <span class="slot_pos"></span>
                    </div>
                </td>

                <td>
                <td>
                    <div class="inv_slot" id='{{$i + 2}}'>
                        @if($slots[$i + 2]->item_id != null)
                            <div class="item" @if($slots[$i + 2]->item_id != null)
                            title="{{$items->getName($slots[$i + 2]->item_id)}}
                            @if ($items->isStackable($slots[$i + 2]->item_id))
                                    ({{$slots[$i + 2]->amount}})
                                                    @endif
                                    "
                                    @endif>
                                <img src='{{url($items->getIconPath($slots[$i + 2]->item_id))}}'/>
                            </div>
                        @endif
                        <span class="slot_pos"></span>
                    </div>
                </td>
                </td>

                <td>
                    <div class="inv_slot" id='{{$i + 3}}'>
                        @if($slots[$i + 3]->item_id != null)
                            <div class="item" @if($slots[$i + 3]->item_id != null)
                            title="{{$items->getName($slots[$i + 3]->item_id)}}
                            @if ($items->isStackable($slots[$i + 3]->item_id))
                                    ({{$slots[$i + 3]->amount}})
                                                    @endif
                                    "
                                    @endif
                            >
                                <img src='{{url($items->getIconPath($slots[$i + 3]->item_id))}}'/>
                            </div>
                        @endif
                        <span class="slot_pos"></span>
                    </div>
                </td>
            </tr>
        @endfor
    </table>
</div>