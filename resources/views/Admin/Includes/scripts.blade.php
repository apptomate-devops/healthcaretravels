<!-- BEGIN VENDOR JS-->
<script src="{{URL::asset('/app-assets/vendors/js/vendors.min.js') }}" type="text/javascript"></script>
<!-- BEGIN VENDOR JS-->
<script src="{{URL::asset('/app-assets/vendors/js/pickers/pickadate/picker.js') }}"></script>
<script src="{{URL::asset('/app-assets/vendors/js/pickers/pickadate/picker.date.js') }}"></script>
<script src="{{URL::asset('/app-assets/vendors/js/pickers/pickadate/picker.time.js') }}"></script>
<script src="{{URL::asset('/app-assets/vendors/js/pickers/daterange/daterangepicker.js') }}"></script>
<!-- BEGIN PAGE VENDOR JS-->
<script src="{{URL::asset('/app-assets/vendors/js/tables/jquery.dataTables.min.js') }}" type="text/javascript"></script>
<script src="{{URL::asset('/app-assets/vendors/js/tables/datatable/dataTables.bootstrap4.min.js') }}"
        type="text/javascript"></script>
<script src="{{URL::asset('/app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js') }}"
        type="text/javascript"></script>
<script src="{{URL::asset('/app-assets/vendors/js/tables/datatable/dataTables.rowReorder.min.js') }}"
        type="text/javascript"></script>
<script src="{{URL::asset('/app-assets/vendors/js/forms/icheck/icheck.min.js') }}" type="text/javascript"></script>
<!-- END PAGE VENDOR JS-->
<!-- BEGIN MODERN JS-->
<script src="{{URL::asset('/app-assets/js/core/app-menu.js') }}" type="text/javascript"></script>
<script src="{{URL::asset('/app-assets/js/core/app.js') }}" type="text/javascript"></script>
<script src="{{URL::asset('/app-assets/js/scripts/customizer.js') }}" type="text/javascript"></script>
<!-- END MODERN JS-->
<!-- BEGIN PAGE LEVEL JS-->
<script src="{{URL::asset('/app-assets/js/scripts/pages/users-contacts.js') }}" type="text/javascript"></script>
<script src="{{URL::asset('/app-assets/js/scripts/tables/datatables/datatable-basic.js') }}"
        type="text/javascript"></script>
<!-- END PAGE LEVEL JS-->


<script src="{{URL::asset('/app-assets/vendors/js/forms/toggle/bootstrap-switch.min.js') }}"
        type="text/javascript"></script>
<script src="{{URL::asset('/app-assets/vendors/js/forms/toggle/bootstrap-checkbox.min.js') }}"
        type="text/javascript"></script>
<script src="{{URL::asset('/app-assets/vendors/js/forms/toggle/switchery.min.js') }}" type="text/javascript"></script>
<script src="{{URL::asset('/app-assets/js/scripts/forms/switch.js') }}" type="text/javascript"></script>
<script src="{{URL::asset('/app-assets/vendors/js/heic2any.min.js') }}" type="text/javascript"></script>
<script type="text/javascript">
    $('img[data-enlargable]').addClass('img-enlargable').click(function() {
        var src = $(this).attr('src');
        var modal;
        function removeModal() {
            modal.remove();
            $('body').off('keyup.modal-close');
        }
        var downloadLink = '<a class="modal-buttons button-download" href="'+ src +'" target="_blank" itemprop="contentUrl"><img src="/assets/icons/others/download_white.svg"></a>';
        var closeButton = '<span class="modal-buttons modal-close-x">X</span>';
        modal = $('<div><div class="modal-buttons-wrapper">'+ downloadLink + closeButton +'</div></div>').css({
            background: 'RGBA(0,0,0,.8) url('+src+') no-repeat center',
            backgroundSize: 'contain',
            width: '100%',
            height: '100%',
            position: 'fixed',
            zIndex: '10000',
            top: '0',
            left: '0',
            cursor: 'zoom-out'
        }).click(function() {
            removeModal();
        }).appendTo('body');

        // Handle Escape key
        $('body').on('keyup.modal-close', function(e){
            if(e.key === 'Escape') {
                removeModal();
            }
        });
    });
</script>
