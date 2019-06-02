@extends('layouts.app')
@section('content')
    {{--load js inv script--}}
    <script>var redirect = '{{ url('')}}'</script>
    {{--load style --}}
    <script src="{{ asset('assets/vendor/tooltips.js') }}"></script>
    <div class="main-content">
        <div class="container-fluid">
            <!-- OVERVIEW -->
            <div class="panel panel-headline">
                <div class="panel-heading">
                    <h3 class="panel-title">Settings</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-3">
                            <form action="{{route("setCombatFocus")}}" method="POST" id="xpfocus">
                                <label for="focus">Combat XP focus</label>
                                {{csrf_field()}}
                                <select id="focus" name="focus" class="form-control form-control-sm" form="xpfocus"
                                        onchange="this.form.submit()">
                                    <option value=1 @if($focus == 1) selected @endif>Primary (100% Combat style XP)</option>
                                    <option value=2 @if($focus == 2) selected @endif>Shared (50/50% Combat style / Defence XP)</option>
                                    <option value=3 @if($focus == 3) selected @endif>Defensive (100% Defence XP)</option>
                                </select>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
