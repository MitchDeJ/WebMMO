@extends('layouts.app')
@section('content')
    <div class="main-content">
        <div class="container-fluid">
            <!-- OVERVIEW -->
            <div class="panel panel-headline">
                <div class="panel-heading">
                    <h3 class="panel-title">Titles &nbsp;<a
                                href="{{url('profile')}}" class="btn btn-sm btn-primary" style="color: white;">Back to
                            profile</a></h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-responsive table-striped table-hover">
                                <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>
                                @foreach($titles as $t)
                                    @if($loop->index == 0)
                                        <tr>
                                            <td><b>Remove title</b></td>
                                            <td>Remove your current title.</td>
                                            <td>
                                                <form method="POST" action="{{url('/removetitle')}}"
                                                      id="title_select"
                                                      class="form-inline">
                                                    {{csrf_field()}}
                                                    <input type="hidden" name="id" value="{{$loop->index}}"/>
                                                    <button class="btn btn-danger">Remove</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @else
                                        <tr>
                                            <td><b style="color:{{$t[2]}}">{{$t[0]}}</b></td>
                                            <td>{{$t[1]}}</td>
                                            <td>
                                                <form method="POST" action="{{url('/selecttitle')}}"
                                                      id="title_select"
                                                      class="form-inline">
                                                    {{csrf_field()}}
                                                    <input type="hidden" name="id" value="{{$loop->index}}"/>
                                                    @if(Auth::user()->title == $loop->index)
                                                        <button class="btn btn-success" disabled>Select</button>
                                                    @else
                                                        <button class="btn btn-primary">Select</button>
                                                    @endif
                                                </form>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
