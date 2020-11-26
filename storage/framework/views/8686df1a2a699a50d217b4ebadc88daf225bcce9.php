  <?php if(@in_array(56, App\GlobalVariable::GlobarModuleLinks())): ?>
             <li>
                <a href="<?php echo e(url('parent-dashboard')); ?>">
                    <span class="flaticon-resume"></span>
                    <?php echo app('translator')->get('lang.dashboard'); ?>
                </a>
            </li>
            <?php endif; ?>
            <?php if(@in_array(66, App\GlobalVariable::GlobarModuleLinks())): ?>
                <li>
                    <a href="#subMenuParentMyChildren" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <span class="flaticon-reading"></span>
                        <?php echo app('translator')->get('lang.my_children'); ?>
                    </a>
                    <ul class="collapse list-unstyled" id="subMenuParentMyChildren">
                        <?php $__currentLoopData = $childrens; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $children): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li>
                                <a href="<?php echo e(route('my_children', [$children->id])); ?>"><?php echo e($children->full_name); ?></a>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </li>
            <?php endif; ?>
            <?php if(@in_array(71, App\GlobalVariable::GlobarModuleLinks())): ?>
                <li>
                    <a href="#subMenuParentFees" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <span class="flaticon-wallet"></span>
                        <?php echo app('translator')->get('lang.fees'); ?>
                    </a>
                    <ul class="collapse list-unstyled" id="subMenuParentFees">
                        <?php $__currentLoopData = $childrens; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $children): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if(App\SmGeneralSettings::isModule('FeesCollection')== false ): ?>
                            <li>
                                <a href="<?php echo e(route('parent_fees', [$children->id])); ?>"><?php echo e($children->full_name); ?></a>
                            </li>
                        <?php else: ?>
                            <li>
                                <a href="<?php echo e(url('feescollection/parent-fee-payment', [$children->id])); ?>"><?php echo e($children->full_name); ?></a>
                            </li>

                        <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </li>
            <?php endif; ?>
            <?php if(@in_array(72, App\GlobalVariable::GlobarModuleLinks())): ?>
                <li>
                    <a href="#subMenuParentClassRoutine" data-toggle="collapse" aria-expanded="false"
                    class="dropdown-toggle">
                        <span class="flaticon-calendar-1"></span>
                        <?php echo app('translator')->get('lang.class_routine'); ?>
                    </a>
                    <ul class="collapse list-unstyled" id="subMenuParentClassRoutine">
                        <?php $__currentLoopData = $childrens; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $children): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li>
                                <a href="<?php echo e(route('parent_class_routine', [$children->id])); ?>"><?php echo e($children->full_name); ?></a>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </li>
            <?php endif; ?>
            <?php if(@in_array(73, App\GlobalVariable::GlobarModuleLinks())): ?>
                <li>
                    <a href="#subMenuParentHomework" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <span class="flaticon-book"></span>
                        <?php echo app('translator')->get('lang.home_work'); ?>
                    </a>
                    <ul class="collapse list-unstyled" id="subMenuParentHomework">
                        <?php $__currentLoopData = $childrens; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $children): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li>
                                <a href="<?php echo e(route('parent_homework', [$children->id])); ?>"><?php echo e($children->full_name); ?></a>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </li>
            <?php endif; ?>
            <?php if(@in_array(75, App\GlobalVariable::GlobarModuleLinks())): ?>
                <li>
                    <a href="#subMenuParentAttendance" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <span class="flaticon-authentication"></span>
                        <?php echo app('translator')->get('lang.attendance'); ?>
                    </a>
                    <ul class="collapse list-unstyled" id="subMenuParentAttendance">
                        <?php $__currentLoopData = $childrens; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $children): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li>
                                <a href="<?php echo e(route('parent_attendance', [$children->id])); ?>"><?php echo e($children->full_name); ?></a>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </li>
            <?php endif; ?>
            <?php if(@in_array(76, App\GlobalVariable::GlobarModuleLinks())): ?>
                <li>
                    <a href="#subMenuParentExamination" data-toggle="collapse" aria-expanded="false"
                    class="dropdown-toggle">
                        <span class="flaticon-test"></span>
                        <?php echo app('translator')->get('lang.exam'); ?>
                    </a>
                    <ul class="collapse list-unstyled" id="subMenuParentExamination">
                        <?php $__currentLoopData = $childrens; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $children): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if(@in_array(77, App\GlobalVariable::GlobarModuleLinks())): ?>
                                <li>
                                    <a href="<?php echo e(route('parent_examination', [$children->id])); ?>"><?php echo e($children->full_name); ?></a>
                                </li>
                            <?php endif; ?>
                            <?php if(@in_array(78, App\GlobalVariable::GlobarModuleLinks())): ?>
                                <li>
                                    <a href="<?php echo e(route('parent_exam_schedule', [$children->id])); ?>"><?php echo app('translator')->get('lang.exam_schedule'); ?></a>
                                </li>
                            <?php endif; ?>
                            <?php if(@in_array(79, App\GlobalVariable::GlobarModuleLinks())): ?>
                                <li>
                                    <a href="<?php echo e(url('parent-online-examination', [$children->id])); ?>"><?php echo app('translator')->get('lang.online_exam'); ?></a>
                                </li>
                            <?php endif; ?>
                            <hr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </li>
            <?php endif; ?>
            <?php if(@in_array(80, App\GlobalVariable::GlobarModuleLinks())): ?>
                <li>
                    <a href="#subMenuParentLeave" data-toggle="collapse" aria-expanded="false"
                    class="dropdown-toggle">
                        <span class="flaticon-test"></span>
                        <?php echo app('translator')->get('lang.leave'); ?>
                    </a>
                    <ul class="collapse list-unstyled" id="subMenuParentLeave">
                        <?php if(@in_array(81, App\GlobalVariable::GlobarModuleLinks())): ?>
                            <li>
                                <a href="<?php echo e(url('parent-apply-leave')); ?>"><?php echo app('translator')->get('lang.apply_leave'); ?></a>
                            </li>
                        <?php endif; ?>
                        <?php if(@in_array(82, App\GlobalVariable::GlobarModuleLinks())): ?>
                            <li>
                                <a href="<?php echo e(url('parent-pending-leave')); ?>"><?php echo app('translator')->get('lang.pending_leave_request'); ?></a>
                            </li>
                        <?php endif; ?>
                        <hr>
                        <?php $__currentLoopData = $childrens; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $children): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li>
                                <a href="<?php echo e(route('parent_leave', [$children->id])); ?>"><?php echo e($children->full_name); ?></a>
                            </li>
                        <hr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </li>
            <?php endif; ?>
            <?php if(@in_array(85, App\GlobalVariable::GlobarModuleLinks())): ?>
                <li>
                    <a href="<?php echo e(route('parent_noticeboard')); ?>">
                        <span class="flaticon-poster"></span>
                        <?php echo app('translator')->get('lang.notice_board'); ?>
                    </a>
                </li>
            <?php endif; ?>
            <?php if(@in_array(86, App\GlobalVariable::GlobarModuleLinks())): ?>
                <li>
                    <a href="#subMenuParentSubject" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <span class="flaticon-reading-1"></span>
                        <?php echo app('translator')->get('lang.subjects'); ?>
                    </a>
                    <ul class="collapse list-unstyled" id="subMenuParentSubject">
                        <?php $__currentLoopData = $childrens; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $children): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li>
                                <a href="<?php echo e(route('parent_subjects', [$children->id])); ?>"><?php echo e($children->full_name); ?></a>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </li>
            <?php endif; ?>
            <?php if(@in_array(87, App\GlobalVariable::GlobarModuleLinks())): ?>
                <li>
                    <a href="#subMenuParentTeacher" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <span class="flaticon-professor"></span>
                        <?php echo app('translator')->get('lang.teacher_list'); ?>
                    </a>
                    <ul class="collapse list-unstyled" id="subMenuParentTeacher">
                        <?php $__currentLoopData = $childrens; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $children): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li>
                                <a href="<?php echo e(route('parent_teacher_list', [$children->id])); ?>"><?php echo e($children->full_name); ?></a>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </li>
            <?php endif; ?>
            <?php if(@in_array(88, App\GlobalVariable::GlobarModuleLinks())): ?>
                <li>
                    <a href="#subMenuStudentLibrary" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"
                    href="#">
                        <span class="flaticon-book-1"></span>
                        <?php echo app('translator')->get('lang.library'); ?>
                    </a>
                    <ul class="collapse list-unstyled" id="subMenuStudentLibrary">
                        <?php if(@in_array(89, App\GlobalVariable::GlobarModuleLinks())): ?>
                            <li>
                                <a href="<?php echo e(route('parent_library')); ?>"> <?php echo app('translator')->get('lang.book_list'); ?></a>
                            </li>
                        <?php endif; ?>
                        <?php if(@in_array(90, App\GlobalVariable::GlobarModuleLinks())): ?>
                            <li>
                                <a href="<?php echo e(route('parent_book_issue')); ?>"><?php echo app('translator')->get('lang.book_issue'); ?></a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>
            <?php if(@in_array(91, App\GlobalVariable::GlobarModuleLinks())): ?>
                <li>
                    <a href="#subMenuParentTransport" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <span class="flaticon-bus"></span>
                        <?php echo app('translator')->get('lang.transport'); ?>
                    </a>
                    <ul class="collapse list-unstyled" id="subMenuParentTransport">
                        <?php $__currentLoopData = $childrens; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $children): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li>
                                <a href="<?php echo e(route('parent_transport', [$children->id])); ?>"><?php echo e($children->full_name); ?></a>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </li>
            <?php endif; ?>
            <?php if(@in_array(92, App\GlobalVariable::GlobarModuleLinks())): ?>
                <li>
                    <a href="#subMenuParentDormitory" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <span class="flaticon-hotel"></span>
                        <?php echo app('translator')->get('lang.dormitory_list'); ?>
                    </a>
                    <ul class="collapse list-unstyled" id="subMenuParentDormitory">
                        <?php $__currentLoopData = $childrens; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $children): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li>
                                <a href="<?php echo e(route('parent_dormitory_list', [$children->id])); ?>"><?php echo e($children->full_name); ?></a>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </li>
            <?php endif; ?>
<?php /**PATH E:\Server3\htdocs\spondon\infixedu_lv7.0_rv_4.5\resources\views/backEnd/partials/parents_sidebar.blade.php ENDPATH**/ ?>