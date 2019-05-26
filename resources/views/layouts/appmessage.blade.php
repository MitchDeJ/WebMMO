<?php ?>
@if(Session::get('success'))
    <div style="padding: 2px 10px; margin-bottom: -35px; margin-top: 1%;">
        <div class="container-fluid">
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                <i class="fa fa-check-circle"></i> {{Session::get('success')}}
            </div>
        </div>
    </div>
@endif
@if(Session::get('fail'))
    <div style="padding: 2px 10px; margin-bottom: -35px; margin-top: 1%;">
        <div class="container-fluid">
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                <i class="fa fa-times-circle"></i> {{Session::get('fail')}}
            </div>
        </div>
    </div>
@endif
@if(Session::get('neutral'))
    <div style="padding: 2px 10px; margin-bottom: -35px; margin-top: 1%;">
        <div class="container-fluid">
            <div class="alert alert-info alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                <i class="fa fa-info-circle"></i> {{Session::get('info')}}
            </div>
        </div>
    </div>
@endif