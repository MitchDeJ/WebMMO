<?php ?>
@if(Session::get('success'))
    <div id="succes" class="alert alert-success" align="center">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <strong>{{ Session::get('success') }}</strong>
    </div>
@endif
@if(Session::get('fail'))
    <div id="fail" class="alert alert-danger" align="center">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <strong>{{ Session::get('fail') }}</strong>
    </div>
@endif
@if(Session::get('neutral'))
    <div id="neutral" class="alert alert-info" align="center">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <strong>{{ Session::get('neutral') }}</strong>
    </div>
@endif