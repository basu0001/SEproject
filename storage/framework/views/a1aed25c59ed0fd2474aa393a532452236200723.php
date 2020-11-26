
<?php $__env->startSection('mainContent'); ?>

<?php
    function showPicName($data){
        $name = explode('/',$data);
        if(!empty($name[4])){

        return $name[4];
        }else{
            return '';
        }
    }
?>

<?php  @$setting = App\SmGeneralSettings::find(1);  if(!empty(@$setting->currency_symbol)){ @$currency = @$setting->currency_symbol; }else{ @$currency = '$'; }   ?> 

<section class="student-details">
    <div class="container-fluid p-0">
        <div class="row">
            <div class="col-lg-12">
                <!-- Start Student Meta Information -->
                <div class="main-title">
                    <h3 class="mb-20"><?php echo app('translator')->get('lang.welcome'); ?> <?php echo app('translator')->get('lang.to'); ?> <strong> <?php echo e(@$student_detail->full_name); ?></strong> </h3>
                </div> 

            </div>
        </div>
            <div class="row">
                <?php if(@in_array(2, App\GlobalVariable::GlobarModuleLinks())): ?>
                <div class="col-lg-3 col-md-6">
                    <a href="#" class="d-block">
                        <div class="white-box single-summery">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h3><?php echo app('translator')->get('lang.subject'); ?></h3>
                                    <p class="mb-0"><?php echo app('translator')->get('lang.total'); ?> <?php echo app('translator')->get('lang.subject'); ?></p>
                                </div>
                                <h1 class="gradient-color2">
                                   
                                     <?php if(isset($totalSubjects)): ?>
                                        <?php echo e(count(@$totalSubjects)); ?>

                                    <?php endif; ?>
                                </h1>
                            </div>
                        </div>
                    </a>
                </div>
                <?php endif; ?>
                <?php if(@in_array(3, App\GlobalVariable::GlobarModuleLinks())): ?>
                <div class="col-lg-3 col-md-6">
                    <a href="#" class="d-block">
                        <div class="white-box single-summery">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h3><?php echo app('translator')->get('lang.notice'); ?></h3>
                                    <p class="mb-0"><?php echo app('translator')->get('lang.total'); ?> <?php echo app('translator')->get('lang.notice'); ?></p>
                                </div>
                                <h1 class="gradient-color2">
                                     <?php if(isset($totalNotices)): ?>
                                        <?php echo e(count(@$totalNotices)); ?>

                                    <?php endif; ?>
                                </h1>
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php endif; ?>
                    <?php if(@in_array(4, App\GlobalVariable::GlobarModuleLinks())): ?>
                <div class="col-lg-3 col-md-6">
                    <a href="#" class="d-block">
                        <div class="white-box single-summery">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h3><?php echo app('translator')->get('lang.exam'); ?></h3>
                                    <p class="mb-0"><?php echo app('translator')->get('lang.total'); ?> <?php echo app('translator')->get('lang.exam'); ?></p>
                                </div>
                                <h1 class="gradient-color2">
                                    <?php if(isset($exams)): ?>
                                        <?php echo e(count(@$exams)); ?>

                                    <?php endif; ?>
                                </h1>
                            </div>
                        </div>
                    </a>
                </div>
                <?php endif; ?>
                <?php if(@in_array(5, App\GlobalVariable::GlobarModuleLinks())): ?>
                <div class="col-lg-3 col-md-6">
                    <a href="<?php echo e(url('student-online-exam')); ?>" class="d-block">
                        <div class="white-box single-summery">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h3><?php echo app('translator')->get('lang.online_exam'); ?></h3>
                                    <p class="mb-0"><?php echo app('translator')->get('lang.total'); ?> <?php echo app('translator')->get('lang.online_exam'); ?></p>
                                </div>
                                <h1 class="gradient-color2">
                                     <?php if(isset($online_exams)): ?>
                                        <?php echo e(count(@$online_exams)); ?>

                                    <?php endif; ?>
                                </h1>
                            </div>
                        </div>
                    </a>
                </div>
                <?php endif; ?>
                <?php if(@in_array(6, App\GlobalVariable::GlobarModuleLinks())): ?>

                <div class="col-lg-3 col-md-6">
                    <a href="#" class="d-block">
                        <div class="white-box single-summery">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h3><?php echo app('translator')->get('lang.teachers'); ?></h3>
                                    <p class="mb-0"><?php echo app('translator')->get('lang.total'); ?> <?php echo app('translator')->get('lang.teachers'); ?></p>
                                </div>
                                <h1 class="gradient-color2"> <?php if(isset($teachers)): ?>
                                        <?php echo e(count(@$teachers)); ?>

                                    <?php endif; ?></h1>
                            </div>
                        </div>
                    </a>
                </div>
                <?php endif; ?>
                <?php if(@in_array(7, App\GlobalVariable::GlobarModuleLinks())): ?>
                <div class="col-lg-3 col-md-6">
                    <a href="#" class="d-block">
                        <div class="white-box single-summery">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h3><?php echo app('translator')->get('lang.issued'); ?> <?php echo app('translator')->get('lang.book'); ?></h3>
                                    <p class="mb-0"><?php echo app('translator')->get('lang.total'); ?> <?php echo app('translator')->get('lang.issued'); ?> <?php echo app('translator')->get('lang.book'); ?></p>
                                </div>
                                <h1 class="gradient-color2">
                                     <?php if(isset($issueBooks)): ?>
                                        <?php echo e(count(@$issueBooks)); ?>

                                    <?php endif; ?>
                                </h1>
                            </div>
                        </div>
                    </a>
                </div>
                <?php endif; ?>
                <?php if(@in_array(8, App\GlobalVariable::GlobarModuleLinks())): ?>
                <div class="col-lg-3 col-md-6">
                    <a href="#" class="d-block">
                        <div class="white-box single-summery">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h3><?php echo app('translator')->get('lang.pending'); ?> <?php echo app('translator')->get('lang.home_work'); ?></h3>
                                    <p class="mb-0"><?php echo app('translator')->get('lang.total'); ?> <?php echo app('translator')->get('lang.pending'); ?> <?php echo app('translator')->get('lang.home_work'); ?></p>
                                </div>
                                <h1 class="gradient-color2">
                                     <?php if(isset($homeworkLists)): ?>
                                        <?php echo e(count(@$homeworkLists)); ?>

                                    <?php endif; ?>
                                </h1>
                            </div>
                        </div>
                    </a>
                </div>
                <?php endif; ?>
                <?php if(@in_array(9, App\GlobalVariable::GlobarModuleLinks())): ?>
                <div class="col-lg-3 col-md-6">
                    <a href="#" class="d-block">
                        <div class="white-box single-summery">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h3><?php echo app('translator')->get('lang.attendance_this_month'); ?></h3>
                                    <p class="mb-0"><?php echo app('translator')->get('lang.total'); ?> <?php echo app('translator')->get('lang.attendance'); ?> <?php echo app('translator')->get('lang.in'); ?>  <?php echo app('translator')->get('lang.current_month'); ?></p>
                                </div>
                                <h1 class="gradient-color2">
                                     <?php if(isset($attendances)): ?>
                                        <?php echo e(count(@$attendances)); ?>

                                    <?php endif; ?>
                                </h1>
                            </div>
                        </div>
                    </a>
                </div>
                <?php endif; ?>


            </div>
           <?php if(@in_array(10, App\GlobalVariable::GlobarModuleLinks())): ?>
                <section class="mt-50">
                    <div class="container-fluid p-0">
                        <div class="row">
                        
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="main-title">
                                            <h3 class="mb-30"><?php echo app('translator')->get('lang.calendar'); ?></h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="white-box">
                                            <div class='common-calendar'>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>  

                    </div>
                </div>
                </section>
            <?php endif; ?>
        </div>
    </div> 
</section>

<div id="fullCalModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span> <span class="sr-only">close</span></button>
                    <h4 id="modalTitle" class="modal-title"></h4>
                </div>
                <div class="modal-body text-center">
                    <img src="" alt="There are no image" id="image" height="150" width="auto">
                    <div id="modalBody"></div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="primary-btn tr-bg" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


<?php

$count_event =0;
@$calendar_events = array();

foreach($holidays as $k => $holiday) {

    @$calendar_events[$k]['title'] = $holiday->holiday_title;
    
    $calendar_events[$k]['start'] = $holiday->from_date;
    
    $calendar_events[$k]['end'] = $holiday->to_date;

    $calendar_events[$k]['description'] = $holiday->details;

    $calendar_events[$k]['url'] = $holiday->upload_image_file;

    $count_event = $k;
    $count_event++;
}



foreach($events as $k => $event) {


    @$calendar_events[$count_event]['title'] = $event->event_title;
    
    $calendar_events[$count_event]['start'] = $event->from_date;
    
    $calendar_events[$count_event]['end'] = $event->to_date;
    $calendar_events[$count_event]['description'] = $event->event_des;
    $calendar_events[$count_event]['url'] = $event->uplad_image_file;
    $count_event++;
}





?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>

<script type="text/javascript">
    /*-------------------------------------------------------------------------------
       Full Calendar Js 
    -------------------------------------------------------------------------------*/
    if ($('.common-calendar').length) {
        $('.common-calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            eventClick:  function(event, jsEvent, view) {
                    $('#modalTitle').html(event.title);
                    $('#modalBody').html(event.description);
                    $('#image').attr('src',event.url);
                    $('#fullCalModal').modal();
                    return false;
                },
            height: 650,
            events: <?php echo json_encode($calendar_events);?> ,
        });
    }


</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('backEnd.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\Server3\htdocs\spondon\infixedu_lv7.0_rv_4.5\resources\views/backEnd/studentPanel/studentProfile.blade.php ENDPATH**/ ?>