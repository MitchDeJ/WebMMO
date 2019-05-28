<!-- Levelup Modal -->
<div class="modal fade" id="popup" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title  text-center"><b>Level up!</b></h4>
            </div>
            <div class="modal-body text-center" id="popup-content" style="margin: auto;">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@if(Session::get('levelUp') == true)
    <script> triggerLevelUp('{{Session::get('skillIcon')}}', '{{Session::get('skillName')}}','{{Session::get('skillLevel')}}') </script>
@endif