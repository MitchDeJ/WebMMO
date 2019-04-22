@extends('layouts.app')

@section('content')
    <div class="main-content">
        <div class="container-fluid">
            <!-- OVERVIEW -->
            <div class="panel panel-headline">
                <div class="panel-heading">
                    <h3 class="panel-title">Dashboard</h3>
                    <p class="panel-subtitle">Period: Oct 14, 2016 - Oct 21, 2016</p>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <!-- CONTENT START -->
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <table border="1">
                            <tr>
                                <th>ID</th>
                                <th>Icon</th>
                                <th>Name</th>
                                <th>Description</th>
                            </tr>
                            @for($i=1; $i <= $item->getItemCount(); $i+=1)
                                <tr>
                                    <td>{{$i}}</td>
                                    <td><img src='{{url($item->getIconPath($i))}}'/></td>
                                    <td>{{$item->getName($i)}}</td>
                                    <td>{{$item->getDescription($i)}}</td>
                                </tr>
                            @endfor
                        </table>
                        <br>
                        <table border="1">
                            <tr>
                                <th>ID</th>
                                <th>Icon</th>
                                <th>Name</th>
                            </tr>
                            @for($i=1; $i <= $skill->getSkillCount(); $i+=1)
                                <tr>
                                    <td>{{$i}}</td>
                                    <td><img src='{{url($skill->getIconPath($i))}}'/></td>
                                    <td>{{$skill->getName($i)}}</td>
                                </tr>
                            @endfor
                        </table>
                        <!-- CONTENT END -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
