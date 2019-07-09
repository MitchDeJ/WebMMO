<div class="col-md-2">
    <table class="inv-table">
        @for($i=1; $i<=70; $i+=10)
            <tr>
                <td>
                    <div class="inv_slot" id='b{{$i}}'>
                        @if($bankslots[$i]->item_id != null)
                            <div class="item" @if($bankslots[$i]->item_id != null)title="{{$items->getName($bankslots[$i]->item_id)}}@if ($items->isStackable($bankslots[$i]->item_id)) ({{$bankslots[$i]->amount}})@endif"@endif>
                                <img src='{{url($items->getIconPath($bankslots[$i]->item_id))}}'/>
                            </div>
                        @endif
                        <span class="slot_pos"></span>
                    </div>
                </td>
                <td>
                    <div class="inv_slot" id='b{{$i + 1}}'>
                        <div class="item" @if($bankslots[$i + 1]->item_id != null)title="{{$items->getName($bankslots[$i + 1]->item_id)}}@if ($items->isStackable($bankslots[$i + 1]->item_id)) ({{$bankslots[$i + 1]->amount}})@endif"@endif>
                            <img src='{{url($items->getIconPath($bankslots[$i + 1]->item_id))}}'/>
                        </div>
                        <span class="slot_pos"></span>
                    </div>
                </td>                <td>
                    <div class="inv_slot" id='b{{$i + 2}}'>
                        <div class="item" @if($bankslots[$i + 2]->item_id != null)title="{{$items->getName($bankslots[$i + 2]->item_id)}}@if ($items->isStackable($bankslots[$i + 2]->item_id)) ({{$bankslots[$i + 2]->amount}})@endif"@endif>
                            <img src='{{url($items->getIconPath($bankslots[$i + 2]->item_id))}}'/>
                        </div>
                        <span class="slot_pos"></span>
                    </div>
                </td>                <td>
                    <div class="inv_slot" id='b{{$i + 3}}'>
                        <div class="item" @if($bankslots[$i + 3]->item_id != null)title="{{$items->getName($bankslots[$i + 3]->item_id)}}@if ($items->isStackable($bankslots[$i + 3]->item_id)) ({{$bankslots[$i + 3]->amount}})@endif"@endif>
                            <img src='{{url($items->getIconPath($bankslots[$i + 3]->item_id))}}'/>
                        </div>
                        <span class="slot_pos"></span>
                    </div>
                </td>                <td>
                    <div class="inv_slot" id='b{{$i + 4}}'>
                        <div class="item" @if($bankslots[$i + 4]->item_id != null)title="{{$items->getName($bankslots[$i + 4]->item_id)}}@if ($items->isStackable($bankslots[$i + 4]->item_id)) ({{$bankslots[$i + 4]->amount}})@endif"@endif>
                            <img src='{{url($items->getIconPath($bankslots[$i + 4]->item_id))}}'/>
                        </div>
                        <span class="slot_pos"></span>
                    </div>
                </td>                <td>
                    <div class="inv_slot" id='b{{$i + 5}}'>
                        <div class="item" @if($bankslots[$i + 5]->item_id != null)title="{{$items->getName($bankslots[$i + 5]->item_id)}}@if ($items->isStackable($bankslots[$i + 5]->item_id)) ({{$bankslots[$i + 5]->amount}})@endif"@endif>
                            <img src='{{url($items->getIconPath($bankslots[$i + 5]->item_id))}}'/>
                        </div>
                        <span class="slot_pos"></span>
                    </div>
                </td>                <td>
                    <div class="inv_slot" id='b{{$i + 6}}'>
                        <div class="item" @if($bankslots[$i + 6]->item_id != null)title="{{$items->getName($bankslots[$i + 6]->item_id)}}@if ($items->isStackable($bankslots[$i + 6]->item_id)) ({{$bankslots[$i + 6]->amount}})@endif"@endif>
                            <img src='{{url($items->getIconPath($bankslots[$i + 6]->item_id))}}'/>
                        </div>
                        <span class="slot_pos"></span>
                    </div>
                </td>                <td>
                    <div class="inv_slot" id='b{{$i + 7}}'>
                        <div class="item" @if($bankslots[$i + 7]->item_id != null)title="{{$items->getName($bankslots[$i + 7]->item_id)}}@if ($items->isStackable($bankslots[$i + 7]->item_id)) ({{$bankslots[$i + 7]->amount}})@endif"@endif>
                            <img src='{{url($items->getIconPath($bankslots[$i + 7]->item_id))}}'/>
                        </div>
                        <span class="slot_pos"></span>
                    </div>
                </td>                <td>
                    <div class="inv_slot" id='b{{$i + 8}}'>
                        <div class="item" @if($bankslots[$i + 8]->item_id != null)title="{{$items->getName($bankslots[$i + 8]->item_id)}}@if ($items->isStackable($bankslots[$i + 8]->item_id)) ({{$bankslots[$i + 8]->amount}})@endif"@endif>
                            <img src='{{url($items->getIconPath($bankslots[$i + 8]->item_id))}}'/>
                        </div>
                        <span class="slot_pos"></span>
                    </div>
                </td>                <td>
                    <div class="inv_slot" id='b{{$i + 9}}'>
                        <div class="item" @if($bankslots[$i + 9]->item_id != null)title="{{$items->getName($bankslots[$i + 9]->item_id)}}@if ($items->isStackable($bankslots[$i + 9]->item_id)) ({{$bankslots[$i + 9]->amount}})@endif"@endif>
                            <img src='{{url($items->getIconPath($bankslots[$i + 9]->item_id))}}'/>
                        </div>
                        <span class="slot_pos"></span>
                    </div>
                </td>
            </tr>
        @endfor
    </table>
</div>