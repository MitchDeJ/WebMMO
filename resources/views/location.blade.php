@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{$location->name}}</div>
                <div class="card-body">
                {{$location->description}}
                    <br>
                    <b>Skilling Spots</b>
                    <table border="1">
                        <tr></tr>
                        <th>Name</th>
                        <th>Skill</th>
                        <th>XP per action</th>
                        <th>Resource</th>
                        <th>Cooldown</th>
                        </tr>
                        @foreach($skillspots as $spot)
                            <tr>
                                <td>{{$spot->name}}</td>
                                <td><img src='{{url($skill->getIconPath($spot->skill_id))}}'/></td>
                                <td>{{$spot->xp_amount}}</td>
                                <td><img src='{{url($item->getIconPath($spot->item_id))}}' /></td>
                                <td>{{$spot->cooldown}}</td>
                            </tr>
                    @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
