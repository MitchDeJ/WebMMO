@extends('layouts.app')
@section('content')
    {{--load js inv script--}}
    <script>var redirect = '{{ url('')}}'</script>
    {{--load style --}}
    <link rel="stylesheet" href="{{ asset('assets/vendor/inventory/inventory_style.css') }}">
    <script src="{{ asset('assets/vendor/inventory/shop.js') }}"></script>
    <div class="main-content">
        <div class="container-fluid">
            <!-- OVERVIEW -->
            <div class="panel panel-headline">
                <div class="panel-heading">
                    <h3 class="panel-title">{{$object->name}}</h3>
                </div>
                <div class="panel-body">
                    <div class="row">

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
