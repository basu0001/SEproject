
<?php if(@in_array(1, App\GlobalVariable::GlobarModuleLinks())): ?>
    <li>
        <a href="<?php echo e(url('student-dashboard')); ?>">
            <span class="flaticon-resume"></span>
            <?php echo app('translator')->get('lang.dashboard'); ?>
        </a>
    </li>
<?php endif; ?>
<?php if(@in_array(11, App\GlobalVariable::GlobarModuleLinks())): ?>
    <li>
        <a href="<?php echo e(url('student-profile')); ?>">
            <span class="flaticon-resume"></span>
            <?php echo app('translator')->get('lang.my_profile'); ?>
        </a>
    </li>
<?php endif; ?>
<?php if(@in_array(20, App\GlobalVariable::GlobarModuleLinks())): ?>
    <li>
        <a href="#subMenuStudentFeesCollection" data-toggle="collapse" aria-expanded="false"
        class="dropdown-toggle" href="#">
            <span class="flaticon-wallet"></span>
            <?php echo app('translator')->get('lang.fees'); ?>
        </a>
        <ul class="collapse list-unstyled" id="subMenuStudentFeesCollection">
            <?php if(App\SmGeneralSettings::isModule('FeesCollection')== false ): ?>
            <li>
                <a href="<?php echo e(route('student_fees')); ?>"><?php echo app('translator')->get('lang.pay_fees'); ?></a>
            </li>
            <?php else: ?>
            <li>
                <a href="<?php echo e(url('feescollection/student-fees')); ?>">b@lang('lang.pay_fees')</a>
            </li>

            <?php endif; ?>
        </ul>
    </li>
<?php endif; ?>
<?php if(@in_array(22, App\GlobalVariable::GlobarModuleLinks())): ?>
    <li>
        <a href="<?php echo e(route('student_class_routine')); ?>">
            <span class="flaticon-calendar-1"></span>
            <?php echo app('translator')->get('lang.class_routine'); ?>
        </a>
    </li>
<?php endif; ?>
<?php if(@in_array(23, App\GlobalVariable::GlobarModuleLinks())): ?>
    <li>
        <a href="<?php echo e(route('student_homework')); ?>">
            <span class="flaticon-book"></span>
            <?php echo app('translator')->get('lang.home_work'); ?>
        </a>
    </li>
<?php endif; ?>
<?php if(@in_array(26, App\GlobalVariable::GlobarModuleLinks())): ?>
    <li>
        <a href="#subMenuDownloadCenter" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"
        href="#">
            <span class="flaticon-data-storage"></span>
            <?php echo app('translator')->get('lang.download_center'); ?>
        </a>
        <ul class="collapse list-unstyled" id="subMenuDownloadCenter">
            <?php if(@in_array(27, App\GlobalVariable::GlobarModuleLinks())): ?>
                <li>
                    <a href="<?php echo e(route('student_assignment')); ?>"><?php echo app('translator')->get('lang.assignment'); ?></a>
                </li>
            <?php endif; ?>
            <?php if(@in_array(29, App\GlobalVariable::GlobarModuleLinks())): ?>
                <li>
                    <a href="<?php echo e(route('student_study_material')); ?>"><?php echo app('translator')->get('lang.student_study_material'); ?></a>
                </li>
            <?php endif; ?>
            <?php if(@in_array(31, App\GlobalVariable::GlobarModuleLinks())): ?>
                <li>
                    <a href="<?php echo e(route('student_syllabus')); ?>"><?php echo app('translator')->get('lang.syllabus'); ?></a>
                </li>
            <?php endif; ?>
            <?php if(@in_array(33, App\GlobalVariable::GlobarModuleLinks())): ?>
                <li>
                    <a href="<?php echo e(route('student_others_download')); ?>"><?php echo app('translator')->get('lang.other_download'); ?></a>
                </li>
            <?php endif; ?>
        </ul>
    </li>
<?php endif; ?>
<?php if(@in_array(35, App\GlobalVariable::GlobarModuleLinks())): ?>
    <li>
        <a href="<?php echo e(route('student_my_attendance')); ?>">
            <span class="flaticon-authentication"></span>
            <?php echo app('translator')->get('lang.attendance'); ?>
        </a>
    </li>
<?php endif; ?>
<?php if(@in_array(36, App\GlobalVariable::GlobarModuleLinks())): ?>
    <li>
        <a href="#subMenuStudentExam" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"
        href="#">
            <span class="flaticon-test"></span>
            <?php echo app('translator')->get('lang.examinations'); ?>
        </a>
        <ul class="collapse list-unstyled" id="subMenuStudentExam">
            <?php if(@in_array(37, App\GlobalVariable::GlobarModuleLinks())): ?>
                <li>
                    <a href="<?php echo e(route('student_result')); ?>"><?php echo app('translator')->get('lang.result'); ?></a>
                </li>
            <?php endif; ?>
            <?php if(@in_array(38, App\GlobalVariable::GlobarModuleLinks())): ?>
                <li>
                    <a href="<?php echo e(route('student_exam_schedule')); ?>"><?php echo app('translator')->get('lang.exam_schedule'); ?></a>
                </li>
            <?php endif; ?>
        </ul>
    </li>
<?php endif; ?>
<?php if(@in_array(39, App\GlobalVariable::GlobarModuleLinks())): ?>
    <li>
        <a href="#subMenuLeaveManagement" data-toggle="collapse" aria-expanded="false"
            class="dropdown-toggle">
            <span class="flaticon-slumber"></span>
            <?php echo app('translator')->get('lang.leave'); ?>
        </a>
        <ul class="collapse list-unstyled" id="subMenuLeaveManagement">

            <?php if(@in_array(40, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 2): ?>

                <li>
                    <a href="<?php echo e(url('student-apply-leave')); ?>"><?php echo app('translator')->get('lang.apply_leave'); ?></a>
                </li>
            <?php endif; ?>

            <?php if(@in_array(44, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 2): ?>

                <li>
                        <a href="<?php echo e(url('student-pending-leave')); ?>"><?php echo app('translator')->get('lang.pending_leave_request'); ?></a>
                </li>
            <?php endif; ?>
        </ul>
    </li>
<?php endif; ?>
<?php if(@in_array(45, App\GlobalVariable::GlobarModuleLinks())): ?>
    <li>
        <a href="#subMenuStudentOnlineExam" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"
        href="#">
            <span class="flaticon-test-1"></span>
            <?php echo app('translator')->get('lang.online_exam'); ?>
        </a>
        <ul class="collapse list-unstyled" id="subMenuStudentOnlineExam">
            <?php if(@in_array(46, App\GlobalVariable::GlobarModuleLinks())): ?>
                <li>
                    <a href="<?php echo e(route('student_online_exam')); ?>"><?php echo app('translator')->get('lang.active_exams'); ?></a>
                </li>
            <?php endif; ?>
            <?php if(@in_array(47, App\GlobalVariable::GlobarModuleLinks())): ?>
                <li>
                    <a href="<?php echo e(route('student_view_result')); ?>"><?php echo app('translator')->get('lang.view_result'); ?></a>
                </li>
            <?php endif; ?>
        </ul>
    </li>
<?php endif; ?>
<?php if(@in_array(48, App\GlobalVariable::GlobarModuleLinks())): ?>

    <li>
        <a href="<?php echo e(route('student_noticeboard')); ?>">
            <span class="flaticon-poster"></span>
            <?php echo app('translator')->get('lang.notice_board'); ?>
        </a>
    </li>
<?php endif; ?>
<?php if(@in_array(49, App\GlobalVariable::GlobarModuleLinks())): ?>
    <li>
        <a href="<?php echo e(route('student_subject')); ?>">
            <span class="flaticon-reading-1"></span>
            <?php echo app('translator')->get('lang.subjects'); ?>
        </a>
    </li>
<?php endif; ?>
<?php if(@in_array(50, App\GlobalVariable::GlobarModuleLinks())): ?>
    <li>
        <a href="<?php echo e(route('student_teacher')); ?>">
            <span class="flaticon-professor"></span>
            <?php echo app('translator')->get('lang.teacher'); ?>
        </a>
    </li>
<?php endif; ?>
<?php if(@in_array(51, App\GlobalVariable::GlobarModuleLinks())): ?>
    <li>
        <a href="#subMenuStudentLibrary" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"
        href="#">
            <span class="flaticon-book-1"></span>
            <?php echo app('translator')->get('lang.library'); ?>
        </a>
        <ul class="collapse list-unstyled" id="subMenuStudentLibrary">
            <?php if(@in_array(52, App\GlobalVariable::GlobarModuleLinks())): ?>
                <li>
                    <a href="<?php echo e(route('student_library')); ?>"> <?php echo app('translator')->get('lang.book_list'); ?></a>
                </li>
            <?php endif; ?>
            <?php if(@in_array(53, App\GlobalVariable::GlobarModuleLinks())): ?>
                <li>
                    <a href="<?php echo e(route('student_book_issue')); ?>"><?php echo app('translator')->get('lang.book_issue'); ?></a>
                </li>
            <?php endif; ?>
        </ul>
    </li>
<?php endif; ?>
<?php if(@in_array(54, App\GlobalVariable::GlobarModuleLinks())): ?>
    <li>
        <a href="<?php echo e(route('student_transport')); ?>">
            <span class="flaticon-bus"></span>
            <?php echo app('translator')->get('lang.transport'); ?>
        </a>
    </li>
<?php endif; ?>
<?php if(@in_array(55, App\GlobalVariable::GlobarModuleLinks())): ?>
    <li>
        <a href="<?php echo e(route('student_dormitory')); ?>">
            <span class="flaticon-hotel"></span>
            <?php echo app('translator')->get('lang.dormitory'); ?>
        </a>
    </li>
<?php endif; ?>
<?php /**PATH E:\Server3\htdocs\spondon\infixedu_lv7.0_rv_4.5\resources\views/backEnd/partials/student_sidebar.blade.php ENDPATH**/ ?>