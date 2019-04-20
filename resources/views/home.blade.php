@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
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
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
