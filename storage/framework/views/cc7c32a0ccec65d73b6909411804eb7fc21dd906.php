
<?php $__env->startSection('mainContent'); ?>
<section class="sms-breadcrumb mb-40 up_breadcrumb white-box">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1><?php echo app('translator')->get('lang.manage'); ?> <?php echo app('translator')->get('lang.student'); ?></h1>
            <div class="bc-pages">
                <a href="<?php echo e(url('dashboard')); ?>"><?php echo app('translator')->get('lang.dashboard'); ?></a>
                <a href="#"><?php echo app('translator')->get('lang.student'); ?> <?php echo app('translator')->get('lang.information'); ?></a>
                <a href="#"><?php echo app('translator')->get('lang.student_list'); ?></a>
            </div>
        </div>
    </div>
</section>
<section class="admin-visitor-area up_admin_visitor">
    <div class="container-fluid p-0">
            <div class="row">
                <div class="col-lg-8 col-md-6 col-sm-6">
                    <div class="main-title mt_0_sm mt_0_md">
                        <h3 class="mb-30  "><?php echo app('translator')->get('lang.select_criteria'); ?></h3>
                    </div>
                </div>

                <?php if(in_array(65, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1 ): ?>
                 <div class="col-lg-4 text-md-right text-left col-md-6 mb-30-lg col-sm-6 text_sm_right">
                    <a href="<?php echo e(route('student_admission')); ?>" class="primary-btn small fix-gr-bg">
                        <span class="ti-plus pr-2"></span>
                        <?php echo app('translator')->get('lang.add'); ?> <?php echo app('translator')->get('lang.student'); ?>
                    </a>
                </div>
            <?php endif; ?>
            </div>
            <?php echo e(Form::open(['class' => 'form-horizontal', 'files' => true, 'url' => 'student-list-search', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'id' => 'infix_form'])); ?>

            <div class="row">
                <div class="col-lg-12">
                <div class="white-box">
                    <div class="row">
                        <input type="hidden" name="url" id="url" value="<?php echo e(URL::to('/')); ?>">
                        <div class="col-lg-3">
                            <div class="input-effect sm2_mb_20 md_mb_20">
                                <select class="niceSelect w-100 bb form-control<?php echo e($errors->has('academic_year') ? ' is-invalid' : ''); ?>" name="academic_year" id="academic_year">
                                    <option data-display="<?php echo app('translator')->get('lang.academic_year'); ?> *" value=""><?php echo app('translator')->get('lang.academic_year'); ?> *</option>
                                    <?php $__currentLoopData = $sessions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $session): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($session->id); ?>" <?php echo e(old('session') == $session->id? 'selected': ''); ?>><?php echo e($session->year); ?>[<?php echo e($session->title); ?>]</option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <span class="focus-border"></span>
                                <?php if($errors->has('academic_year')): ?>
                                <span class="invalid-feedback invalid-select" role="alert">
                                    <strong><?php echo e($errors->first('academic_year')); ?></strong>
                                </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-lg-3 sm_mb_20 sm2_mb_20 md_mb_20" id="class-div">
                            <select class="niceSelect w-100 bb form-control <?php echo e($errors->has('class') ? ' is-invalid' : ''); ?>" id="classSelectStudent" name="class">
                                <option data-display="<?php echo app('translator')->get('lang.select'); ?> <?php echo app('translator')->get('lang.class'); ?> *" value=""><?php echo app('translator')->get('lang.select'); ?> <?php echo app('translator')->get('lang.class'); ?></option>
                               
                            </select>
                            <?php if($errors->has('class')): ?>
                            <span class="invalid-feedback invalid-select" role="alert">
                                <strong><?php echo e($errors->first('class')); ?></strong>
                            </span>
                            <?php endif; ?>
                        </div>
                        <div class="col-lg-2 col-md-3" id="sectionStudentDiv">
                                <select class="niceSelect w-100 bb form-control<?php echo e($errors->has('section') ? ' is-invalid' : ''); ?>" id="sectionSelectStudent" name="section">
                                    <option data-display="<?php echo app('translator')->get('lang.select_section'); ?>" value=""><?php echo app('translator')->get('lang.select_section'); ?></option>
                                </select>
                                <?php if($errors->has('section')): ?>
                                <span class="invalid-feedback invalid-select" role="alert">
                                    <strong><?php echo e($errors->first('section')); ?></strong>
                                </span>
                                <?php endif; ?>
                            </div>
                        <div class="col-lg-2">
                            <div class="input-effect sm_mb_20 sm2_mb_20 md_mb_20">
                                <input class="primary-input" type="text" name="name" value="<?php echo e(isset($name)?$name:''); ?>">
                                <label><?php echo app('translator')->get('lang.search_by_name'); ?></label>
                                <span class="focus-border"></span>
                            </div>
                        </div>
                       
                        <div class="col-lg-2">
                            <div class="input-effect sm_mb_20 sm2_mb_20 md_mb_20">
                                <input class="primary-input" type="text" name="roll_no" value="<?php echo e(isset($roll_no)?$roll_no:''); ?>">
                                <label><?php echo app('translator')->get('lang.search_by_roll_no'); ?></label>
                                <span class="focus-border"></span>
                            </div>
                        </div>
                        
                        <div class="col-lg-12 mt-20 text-right">
                            <button type="submit" class="primary-btn small fix-gr-bg" id="btnsubmit">
                                <span class="ti-search pr-2"></span>
                                <?php echo app('translator')->get('lang.search'); ?>
                            </button>
                        </div>
                    </div>
                    </div>
                </div>
            </div>

            <?php echo e(Form::close()); ?>

            <?php if(@$students): ?>
            <div class="row mt-40 full_wide_table">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-4 no-gutters">
                            <div class="main-title">
                                <h3 class="mb-0"><?php echo app('translator')->get('lang.student_list'); ?> (<?php echo e(@$students ? @$students->count() : 0); ?>)</h3>
                            </div>
                        </div>
                    </div>
                    <div class="row  ">
                        <div class="col-lg-12">
                            <table id="table_id" class="display school-table" cellspacing="0" width="100%">
                                <thead>
                                    <?php if(session()->has('message-success') != "" ||
                                    session()->get('message-danger') != ""): ?>
                                    <tr>
                                        <td colspan="10">
                                            <?php if(session()->has('message-success')): ?>
                                            <div class="alert alert-success">
                                                <?php echo e(session()->get('message-success')); ?>

                                            </div>
                                            <?php elseif(session()->has('message-danger')): ?>
                                            <div class="alert alert-danger">
                                                <?php echo e(session()->get('message-danger')); ?>

                                            </div>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endif; ?>
                                    <tr>
                                        <th><?php echo app('translator')->get('lang.admission'); ?><?php echo app('translator')->get('lang.no'); ?></th>
                                        <th><?php echo app('translator')->get('lang.roll'); ?> <?php echo app('translator')->get('lang.no'); ?></th>
                                        <th><?php echo app('translator')->get('lang.name'); ?></th>
                                        <th><?php echo app('translator')->get('lang.class'); ?></th>
                                        <th><?php echo app('translator')->get('lang.father_name'); ?></th>
                                        <th><?php echo app('translator')->get('lang.date_of_birth'); ?></th>
                                        <th><?php echo app('translator')->get('lang.gender'); ?></th>
                                        <th><?php echo app('translator')->get('lang.type'); ?></th>
                                        <th><?php echo app('translator')->get('lang.phone'); ?></th>
                                        <th><?php echo app('translator')->get('lang.actions'); ?></th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php $__currentLoopData = @$students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($student->admission_no); ?></td>
                                        <td><?php echo e($student->roll_no); ?></td>
                                        <td><?php echo e($student->first_name.' '.$student->last_name); ?></td> 
                                        <td><?php echo e(!empty($student->className)?$student->className->class_name:''); ?></td>

                                        <td><?php echo e(!empty($student->parents->fathers_name)?$student->parents->fathers_name:''); ?></td>
                                        <td  data-sort="<?php echo e(strtotime($student->date_of_birth)); ?>" >
                                           
                                        <?php echo e($student->date_of_birth != ""? App\SmGeneralSettings::DateConvater($student->date_of_birth):''); ?>


                                        </td>
                                        <td><?php echo e($student->gender != ""? $student->gender->base_setup_name :''); ?></td>
                                        <td><?php echo e(!empty($student->category)? $student->category->category_name:''); ?></td>
                                        <td><?php echo e($student->mobile); ?></td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn dropdown-toggle" data-toggle="dropdown">
                                                    <?php echo app('translator')->get('lang.select'); ?>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right">


                                                    
                                                    

                                                    <a class="dropdown-item" href="<?php echo e(route('student_view', [$student->id])); ?>"><?php echo app('translator')->get('lang.view'); ?></a>

                                                

                                                <?php if(in_array(66, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1 ): ?>
                                                    <a class="dropdown-item" href="<?php echo e(route('student_edit', [$student->id])); ?>"><?php echo app('translator')->get('lang.edit'); ?></a>
                                                <?php endif; ?>
                                                 <?php if(in_array(67, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1 ): ?>

                                                 <?php if(Illuminate\Support\Facades\Config::get('app.app_sync')): ?>
                                                 <span  data-toggle="tooltip" title="Disabled For Demo "> 
                                                    <a  class="dropdown-item" href="#" data-toggle="modal" data-target="#deleteStudentModal" data-id=""  ><?php echo app('translator')->get('lang.disable'); ?></a>
                                               
                                                     </span>
                                                     
                                                 <?php else: ?>
                                                 <a onclick="deleteId(<?php echo e($student->id); ?>);" class="dropdown-item" href="#" data-toggle="modal" data-target="#deleteStudentModal" data-id="<?php echo e($student->id); ?>"  ><?php echo app('translator')->get('lang.disable'); ?></a>
                                               
                                                 <?php endif; ?>
                                                  
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    
                                    
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
    </div>
</section>


    <div class="modal fade admin-query" id="deleteStudentModal" >
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><?php echo app('translator')->get('lang.disable'); ?> <?php echo app('translator')->get('lang.student'); ?></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    
                    <div class="text-center">
                        <h4><?php echo app('translator')->get('lang.are_you_sure_to_disable'); ?></h4>
                    </div>

                    <div class="mt-40 d-flex justify-content-between">
                        <button type="button" class="primary-btn tr-bg" data-dismiss="modal"><?php echo app('translator')->get('lang.cancel'); ?></button>
                        <?php echo e(Form::open(['url' => 'student-delete', 'method' => 'POST', 'enctype' => 'multipart/form-data'])); ?>

                    <input type="hidden" name="id" value="<?php echo e(@$student->id); ?>" id="student_delete_i">  
                            <button class="primary-btn fix-gr-bg" type="submit"><?php echo app('translator')->get('lang.disable'); ?></button>
                        <?php echo e(Form::close()); ?>

                    </div>

                </div>

            </div>
        </div>
    </div>
    

<?php $__env->stopSection(); ?>

<?php echo $__env->make('backEnd.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\Server3\htdocs\spondon\infixedu_lv7.0_rv_4.5\resources\views/backEnd/studentInformation/student_details.blade.php ENDPATH**/ ?>