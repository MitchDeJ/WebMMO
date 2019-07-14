@extends('layouts.app')

@section('content')
    <script>
        var points = '{!! json_encode($points, JSON_HEX_TAG) !!}';
        var current = '{{ $current }}';
        var redirect = '{!! url('') !!}';
        var token = '{!! csrf_field() !!}';
    </script>
    <div class="main-content">
        <div class="container-fluid">
            <!-- OVERVIEW -->
            <div class="panel panel-headline">
                <div class="panel-heading">
                    <h3 class="panel-title">World Map</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <!-- CONTENT START -->
                        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.5.1/dist/leaflet.css"
                              integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
                              crossorigin=""/>
                        <!-- Make sure you put this AFTER Leaflet's CSS -->
                        <script src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js"
                                integrity="sha512-GffPMF3RvMeYyc1LWMHtK8EbPv0iNZ8/oTtHPx9/cc2ILxQ+u905qIwdpULaqDkyBKgOaB57QTMg7ztg8Jm2Og=="
                                crossorigin=""></script>
                        <div class="col-md-12">
                            <div id="map" style="height:75vh; width:auto;"></div>
                        </div>
                    </div>
                    <!-- CONTENT END -->
                    <script src="{{asset('assets/vendor/map/map.js')}}"></script>
                </div>
            </div>
        </div>
    </div>
@endsection
