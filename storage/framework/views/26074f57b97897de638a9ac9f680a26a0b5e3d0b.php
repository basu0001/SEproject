<?php
    $setting = App\SmGeneralSettings::where('school_id',Auth::user()->school_id)->first();
    if(isset($setting->copyright_text)){ $copyright_text = $setting->copyright_text; }else{ $copyright_text = 'Copyright 2019 All rights reserved by Codethemes'; }

?>
</div>
</div>

<div class="has-modal modal fade" id="showDetaildModal">
    <div class="modal-dialog modal-dialog-centered" id="modalSize">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title" id="showDetaildModalTile"><?php echo app('translator')->get('lang.new_client_information'); ?></h4>
                <button type="button" class="close icons" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body" id="showDetaildModalBody">

            </div>

            <!-- Modal footer -->

        </div>
    </div>
</div>


<!--  Start Modal Area -->
<div class="modal fade invoice-details" id="showDetaildModalInvoice">
    <div class="modal-dialog large-modal modal-dialog-centered" >
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo app('translator')->get('lang.add'); ?> <?php echo app('translator')->get('lang.invoice'); ?></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body" id="showDetaildModalBodyInvoice">
            </div>

        </div>
    </div>
</div>

<!--
<div class="skype-button bubble" data-bot-id="spondonit"></div>


================Footer Area ================= -->
<footer class="footer-area">
    <div class="container">
        <div class="row">

            <div class="col-lg-12 text-center">
                <p><?php echo $copyright_text; ?> </p>
            </div>
        </div>
    </div>
</footer>
<!-- ================End Footer Area ================= -->

<script src="<?php echo e(asset('public/backEnd/')); ?>/vendors/js/jquery-3.2.1.min.js"></script>
<script src="<?php echo e(asset('public/backEnd/')); ?>/vendors/js/jquery-ui.js">
</script>
<script src="<?php echo e(asset('public/backEnd/')); ?>/vendors/js/jquery.data-tables.js">
</script>
<script src="<?php echo e(asset('public/backEnd/')); ?>/vendors/js/dataTables.buttons.min.js">
</script>
<script src="<?php echo e(asset('public/backEnd/')); ?>/vendors/js/buttons.flash.min.js">
</script>
<script src="<?php echo e(asset('public/backEnd/')); ?>/vendors/js/jszip.min.js"></script>
<script src="<?php echo e(asset('public/backEnd/')); ?>/vendors/js/pdfmake.min.js"></script>
<script src="<?php echo e(asset('public/backEnd/')); ?>/vendors/js/vfs_fonts.js"></script>
<script src="<?php echo e(asset('public/backEnd/')); ?>/vendors/js/buttons.html5.min.js">
</script>
<script src="<?php echo e(asset('public/backEnd/')); ?>/vendors/js/buttons.print.min.js">
</script>
<script src="<?php echo e(asset('public/backEnd/')); ?>/vendors/js/dataTables.rowReorder.min.js">
</script>
<script src="<?php echo e(asset('public/backEnd/')); ?>/vendors/js/dataTables.responsive.min.js">
</script>
<script src="<?php echo e(asset('public/backEnd/')); ?>/vendors/js/buttons.colVis.min.js">
</script>
<script src="<?php echo e(asset('public/backEnd/')); ?>/vendors/js/popper.js">
</script>


<script src="<?php echo e(asset('public/backEnd/')); ?>/css/rtl/bootstrap.min.js">
</script>


<script src="<?php echo e(asset('public/backEnd/')); ?>/vendors/js/nice-select.min.js"></script>
<script src="<?php echo e(asset('public/backEnd/')); ?>/vendors/js/jquery.magnific-popup.min.js">
</script>
<script src="<?php echo e(asset('public/backEnd/')); ?>/vendors/js/fastselect.standalone.min.js">
</script>
<script src="<?php echo e(asset('public/backEnd/')); ?>/vendors/js/raphael-min.js">
</script>
<script src="<?php echo e(asset('public/backEnd/')); ?>/vendors/js/morris.min.js">
</script>
<script src="<?php echo e(asset('public/backEnd/')); ?>/vendors/js/ckeditor.js"></script>

<script type="text/javascript" src="<?php echo e(asset('public/backEnd/')); ?>/vendors/js/toastr.min.js"></script>

<script type="text/javascript" src="<?php echo e(asset('public/backEnd/')); ?>/vendors/js/moment.min.js"></script>
<script src="<?php echo e(asset('public/backEnd/')); ?>/vendors/js/ckeditor.js"></script>
<script src="<?php echo e(asset('public/backEnd/')); ?>/vendors/js/bootstrap_datetimepicker.min.js"></script>
<script src="<?php echo e(asset('public/backEnd/')); ?>/vendors/js/bootstrap-datepicker.min.js"></script>


<script type="text/javascript" src="<?php echo e(asset('public/backEnd/')); ?>/vendors/js/fullcalendar.min.js"></script>


<script type="text/javascript" src="<?php echo e(asset('public/backEnd/')); ?>/js/jquery.validate.min.js"></script>
<script src="<?php echo e(asset('public/backEnd/')); ?>/vendors/js/select2/select2.min.js"></script>

<script src="<?php echo e(asset('public/backEnd/')); ?>/js/main.js"></script>
<script src="<?php echo e(asset('public/backEnd/')); ?>/js/custom.js"></script>

<?php if(App\SmGeneralSettings::isModule('Saas')== TRUE): ?>
<script src="<?php echo e(asset('public/backEnd/')); ?>/saas/js1/custom.js"></script>
<?php endif; ?>

<script src="<?php echo e(asset('public/')); ?>/js/registration_custom.js"></script>
<script src="<?php echo e(asset('public/backEnd/')); ?>/js/developer.js"></script>


<script type="text/javascript">
    //$('table').parent().addClass('table-responsive pt-4');
    // for select2 multiple dropdown in send email/Sms in Individual Tab
    $("#selectStaffss").select2();
    $("#checkbox").click(function () {
        if ($("#checkbox").is(':checked')) {
            $("#selectStaffss > option").prop("selected", "selected");
            $("#selectStaffss").trigger("change");
        } else {
            $("#selectStaffss > option").removeAttr("selected");
            $("#selectStaffss").trigger("change");
        }
    });


    // for select2 multiple dropdown in send email/Sms in Class tab
    $("#selectSectionss").select2();
    $("#checkbox_section").click(function () {
        if ($("#checkbox_section").is(':checked')) {
            $("#selectSectionss > option").prop("selected", "selected");
            $("#selectSectionss").trigger("change");
        } else {
            $("#selectSectionss > option").removeAttr("selected");
            $("#selectSectionss").trigger("change");
        }
    });

</script>

 <script>


    $('.close_modal').on('click', function() {
        $('.custom_notification').removeClass('open_notification');
    });
    $('.notification_icon').on('click', function() {
        $('.custom_notification').addClass('open_notification');
    });
    $(document).click(function(event) {
        if (!$(event.target).closest(".custom_notification").length) {
            $("body").find(".custom_notification").removeClass("open_notification");
        }
    });



</script>
<script src="<?php echo e(asset('public/backEnd/')); ?>/js/search.js"></script>

<?php echo Toastr::message(); ?>





<?php echo $__env->yieldContent('script'); ?>

</body>
</html>

<?php /**PATH E:\Server3\htdocs\spondon\infixedu_lv7.0_rv_4.5\resources\views/backEnd/partials/footer.blade.php ENDPATH**/ ?>