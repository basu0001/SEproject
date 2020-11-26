
<?php $__env->startSection('mainContent'); ?>
<section class="sms-breadcrumb mb-40 white-box">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1><?php echo app('translator')->get('lang.class'); ?></h1>
            <div class="bc-pages">
                <a href="<?php echo e(url('dashboard')); ?>"><?php echo app('translator')->get('lang.dashboard'); ?></a>
                <a href="#"><?php echo app('translator')->get('lang.academics'); ?></a>
                <a href="#"><?php echo app('translator')->get('lang.class'); ?></a>
            </div>
        </div>
    </div>
</section>
<section class="admin-visitor-area up_st_admin_visitor">
    <div class="container-fluid p-0">
        <?php if(isset($sectionId)): ?>
         <?php if(in_array(266, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1 ): ?>
        <div class="row">
            <div class="offset-lg-10 col-lg-2 text-right col-md-12 mb-20">
                <a href="<?php echo e(url('class')); ?>" class="primary-btn small fix-gr-bg">
                    <span class="ti-plus pr-2"></span>
                    <?php echo app('translator')->get('lang.add'); ?>
                </a>
            </div>
        </div>
        <?php endif; ?>
        <?php endif; ?>
        <div class="row">
              <div class="col-lg-3">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="main-title">
                            <h3 class="mb-30"><?php if(isset($sectionId)): ?>
                                    <?php echo app('translator')->get('lang.edit'); ?>
                                <?php else: ?>
                                    <?php echo app('translator')->get('lang.add'); ?>
                                <?php endif; ?>
                                <?php echo app('translator')->get('lang.class'); ?>
                            </h3>
                        </div>
                        <?php if(isset($sectionId)): ?>
                        <?php echo e(Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'class_update', 'method' => 'POST'])); ?>

                        <?php else: ?>
                         <?php if(in_array(266, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1 ): ?>

                        <?php echo e(Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'class_store', 'method' => 'POST'])); ?>

                        <?php endif; ?>
                        <?php endif; ?>
                        <div class="white-box">
                            <div class="add-visitor">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <?php if(session()->has('message-success')): ?>
                                          <div class="alert alert-success">
                                              <?php echo e(session()->get('message-success')); ?>

                                          </div>
                                        <?php elseif(session()->has('message-danger')): ?>
                                          <div class="alert alert-danger">
                                              <?php echo e(session()->get('message-danger')); ?>

                                          </div>
                                        <?php endif; ?>

                                        <div class="input-effect">
                                            <input class="primary-input form-control<?php echo e(@$errors->has('name') ? ' is-invalid' : ''); ?>" type="text" name="name" autocomplete="off" value="<?php echo e(isset($classById)? @$classById->class_name: ''); ?>">
                                            <input type="hidden" name="id" value="<?php echo e(isset($classById)? $classById->id: ''); ?>">
                                            <label><?php echo app('translator')->get('lang.name'); ?> <span>*</span></label>
                                            <span class="focus-border"></span>
                                            <?php if($errors->has('name')): ?>
                                                <span class="invalid-feedback" role="alert">
                                                    <strong><?php echo e(@$errors->first('name')); ?></strong>
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-30">
                                    <div class="col-lg-12">
                                        <label><?php echo app('translator')->get('lang.section'); ?></label><br>
                                        <?php $__currentLoopData = $sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="">
                                            <?php if(isset($sectionId)): ?>
                                            <input type="checkbox" id="section<?php echo e(@$section->id); ?>" class="common-checkbox form-control<?php echo e(@$errors->has('section') ? ' is-invalid' : ''); ?>"  name="section[]" value="<?php echo e(@$section->id); ?>" <?php echo e(in_array(@$section->id, @$sectionId)? 'checked': ''); ?>>
                                            <label for="section<?php echo e(@$section->id); ?>">Section <?php echo e(@$section->section_name); ?></label>
                                            <?php else: ?>

                                            <input type="checkbox" id="section<?php echo e(@$section->id); ?>" class="common-checkbox form-control<?php echo e(@$errors->has('section') ? ' is-invalid' : ''); ?>" name="section[]" value="<?php echo e(@$section->id); ?>">


                                            <label for="section<?php echo e(@$section->id); ?>">Section <?php echo e(@$section->section_name); ?></label>


                                            <?php endif; ?>
                                        </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($errors->has('section')): ?>
                                            <span class="text-danger validate-textarea-checkbox" role="alert">
                                                <strong><?php echo e(@$errors->first('section')); ?></strong>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php
                                  $tooltip = "";
                                  if(in_array(266, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1 ){
                                        $tooltip = "";
                                    }else{
                                        $tooltip = "You have no permission to add";
                                    }
                                ?>
                                <div class="row mt-40">
                                    <div class="col-lg-12 text-center">
                                        <button class="primary-btn fix-gr-bg" data-toggle="tooltip" title="<?php echo e($tooltip); ?>">
                                            <span class="ti-check"></span>
                                            <?php if(isset($sectionId)): ?>
                                                <?php echo app('translator')->get('lang.update'); ?>
                                            <?php else: ?>
                                                <?php echo app('translator')->get('lang.save'); ?>
                                            <?php endif; ?>
                                            <?php echo app('translator')->get('lang.class'); ?>

                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php echo e(Form::close()); ?>

                    </div>
                </div>
            </div>

            <div class="col-lg-9">
                <div class="row">
                    <div class="col-lg-4 no-gutters">
                        <div class="main-title">
                            <h3 class="mb-0"><?php echo app('translator')->get('lang.class'); ?> <?php echo app('translator')->get('lang.list'); ?></h3>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">

                        <table id="table_id" class="display school-table" cellspacing="0" width="100%">

                            <thead>
                               <?php if(session()->has('message-success-delete') != "" ||
                                session()->get('message-danger-delete') != ""): ?>
                                <tr>
                                    <td colspan="3">
                                         <?php if(session()->has('message-success-delete')): ?>
                                          <div class="alert alert-success">
                                              <?php echo e(session()->get('message-success-delete')); ?>

                                          </div>
                                        <?php elseif(session()->has('message-danger-delete')): ?>
                                          <div class="alert alert-danger">
                                              <?php echo e(session()->get('message-danger-delete')); ?>

                                          </div>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                 <?php endif; ?>
                                <tr>
                                    <th><?php echo app('translator')->get('lang.class'); ?></th>
                                    <th><?php echo app('translator')->get('lang.section'); ?></th>
                                    <th><?php echo app('translator')->get('lang.action'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $classes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td valign="top"><?php echo e(@$class->class_name); ?></td>
                                    <td>
                                        <table>
                                            <?php
                                              @$classSections = @$class->classSection;
                                            ?>
                                            <?php $__currentLoopData = $classSections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $classSection): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td>
                                                    <?php $sectionName = App\SmSection::find(@$classSection->section_id);
                                                    ?>
                                                    <?php if(@$sectionName!=""): ?>
                                                        <?php echo e(@$sectionName->section_name); ?>

                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                        </table>
                                    </td>

                                    <td valign="top">
                                        <div class="dropdown">
                                            <button type="button" class="btn dropdown-toggle" data-toggle="dropdown">
                                                <?php echo app('translator')->get('lang.select'); ?>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <?php if(in_array(263, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1 ): ?>
                                                <a class="dropdown-item" href="<?php echo e(route('class_edit', [@$class->id])); ?>"><?php echo app('translator')->get('lang.edit'); ?></a>
                                               <?php endif; ?>
                                                <?php if(in_array(264, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1 ): ?>
                                                <a class="dropdown-item" data-toggle="modal" data-target="#deleteClassModal<?php echo e(@$class->id); ?>"  href="<?php echo e(route('class_delete', [@$class->id])); ?>"><?php echo app('translator')->get('lang.delete'); ?></a>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                  <div class="modal fade admin-query" id="deleteClassModal<?php echo e(@$class->id); ?>" >
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title"><?php echo app('translator')->get('lang.delete'); ?> <?php echo app('translator')->get('lang.class'); ?></h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>

                                            <div class="modal-body">
                                                <div class="text-center">
                                                    <h4><?php echo app('translator')->get('lang.are_you_sure_to_delete'); ?></h4>
                                                </div>

                                                <div class="mt-40 d-flex justify-content-between">
                                                    <button type="button" class="primary-btn tr-bg" data-dismiss="modal"><?php echo app('translator')->get('lang.cancel'); ?></button>
                                                    <a href="<?php echo e(route('class_delete', [$class->id])); ?>" class="text-light">
                                                    <button class="primary-btn fix-gr-bg" type="submit"><?php echo app('translator')->get('lang.delete'); ?></button>
                                                     </a>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backEnd.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\Server3\htdocs\spondon\infixedu_lv7.0_rv_4.5\resources\views/backEnd/academics/class.blade.php ENDPATH**/ ?>