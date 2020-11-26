
<?php $__env->startSection('mainContent'); ?>
<section class="admin-visitor-area">
    <div class="container-fluid p-0">
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="main-title">
                        <h3 class="mb-30"><?php echo app('translator')->get('lang.select_criteria'); ?></h3>
                    </div>
                </div>
            </div>
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
                    <div class="white-box">
                        <?php echo e(Form::open(['class' => 'form-horizontal', 'files' => true, 'url' => 'fees-discount-assign-search', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'id' => 'search_studentA'])); ?>

                            <div class="row">
                                <input type="hidden" name="url" id="url" value="<?php echo e(URL::to('/')); ?>">
                                <input type="hidden" name="fees_discount_id" id="fees_discount_id" value="<?php echo e($fees_discount_id); ?>">
                                <div class="col-lg-3 mt-30-md">
                                    <select class="niceSelect w-100 bb form-control<?php echo e($errors->has('class') ? ' is-invalid' : ''); ?>" id="select_class" name="class">
                                        <option data-display="<?php echo app('translator')->get('lang.select_class'); ?>" value=""><?php echo app('translator')->get('lang.select_class'); ?>*</option>
                                        <?php $__currentLoopData = $classes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($class->id); ?>" <?php echo e(isset($class_id)? ($class_id == $class->id? 'selected':''):''); ?>><?php echo e($class->class_name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                     <?php if($errors->has('class')): ?>
                                    <span class="invalid-feedback invalid-select" role="alert">
                                        <strong><?php echo e($errors->first('class')); ?></strong>
                                    </span>
                                    <?php endif; ?>
                                </div>
                                <div class="col-lg-3 mt-30-md" id="select_section_div">
                                    <select class="niceSelect w-100 bb form-control<?php echo e($errors->has('section') ? ' is-invalid' : ''); ?>" id="select_section" name="section">
                                        <option data-display="<?php echo app('translator')->get('lang.select_section'); ?>" value=""><?php echo app('translator')->get('lang.select_section'); ?></option>
                                    </select>
                                    <?php if($errors->has('section')): ?>
                                    <span class="invalid-feedback invalid-select" role="alert">
                                        <strong><?php echo e($errors->first('section')); ?></strong>
                                    </span>
                                    <?php endif; ?>
                                </div>
                                <div class="col-lg-3 mt-30-md">
                                    <select class="niceSelect w-100 bb form-control<?php echo e($errors->has('category') ? ' is-invalid' : ''); ?>" name="category">
                                        <option data-display="<?php echo app('translator')->get('lang.select'); ?> <?php echo app('translator')->get('lang.category'); ?>" value=""><?php echo app('translator')->get('lang.select'); ?> <?php echo app('translator')->get('lang.category'); ?></option>
                                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($category->id); ?>")}} <?php echo e(isset($category_id)? ($category_id == $category->id? 'selected':''):''); ?>><?php echo e($category->category_name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <?php if($errors->has('category')): ?>
                                    <span class="invalid-feedback invalid-select" role="alert">
                                        <strong><?php echo e($errors->first('category')); ?></strong>
                                    </span>
                                    <?php endif; ?>
                                </div>
                                <div class="col-lg-3 mt-30-md">
                                    <select class="niceSelect w-100 bb form-control<?php echo e($errors->has('section') ? ' is-invalid' : ''); ?>" name="gender">
                                        <option data-display="<?php echo app('translator')->get('lang.select'); ?> <?php echo app('translator')->get('lang.gender'); ?>" value=""><?php echo app('translator')->get('lang.select'); ?> <?php echo app('translator')->get('lang.gender'); ?> </option>
                                        <?php $__currentLoopData = $genders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gender): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($gender->id); ?>" <?php echo e(isset($gender_id)? ($gender_id == $gender->id? 'selected':''):''); ?>><?php echo e($gender->base_setup_name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <?php if($errors->has('section')): ?>
                                    <span class="invalid-feedback invalid-select" role="alert">
                                        <strong><?php echo e($errors->first('section')); ?></strong>
                                    </span>
                                    <?php endif; ?>
                                </div>
                                <div class="col-lg-12 mt-20 text-right">
                                    <button type="submit" class="primary-btn small fix-gr-bg">
                                        <span class="ti-search pr-2"></span>
                                        <?php echo app('translator')->get('lang.search'); ?>
                                    </button>
                                </div>
                            </div>
                        <?php echo e(Form::close()); ?>

                    </div>
                </div>
            </div>

            
    <?php if(isset($students)): ?>

        
            <?php echo e(Form::open(['class' => 'form-horizontal', 'files' => true, 'method' => 'POST', 'url' => 'fees-assign-store', 'enctype' => 'multipart/form-data'])); ?>

       


            <div class="row mt-40">
                <div class="col-lg-12">
                    <div class="row mb-30">
                        <div class="col-lg-6 no-gutters">
                            <div class="main-title">
                                <h3 class="mb-0"><?php echo app('translator')->get('lang.assign'); ?> <?php echo app('translator')->get('lang.fees_discount'); ?></h3>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="fees_discount_id" value="<?php echo e($fees_discount_id); ?>" id="fees_discount_id">
                      
                    <!-- </div> -->
                    <div class="row">
                        <div class="col-lg-4">
                            <table id="table_id_table" class="display school-table" cellspacing="0" width="100%">  
                                <thead>
                                    <tr>
                                        <tr>
                                            <th><?php echo app('translator')->get('lang.fees_discount'); ?></th>
                                            <th></th>
                                        </tr>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr>
                                        <td><?php echo e($fees_discount->name); ?></td>
                                        <td><?php echo e($fees_discount->amount); ?></td>
                                    </tr> 
                                </tbody>
                            </table>
                        </div>
                        <div class="col-lg-8">
                            <table  class="display school-table school-table-style" cellspacing="0" width="100%">
                                        
                                <thead>
                                    <tr>
                                        <th width="10%">
                                            <input type="checkbox" id="checkAll" class="common-checkbox" name="checkAll"  <?php
                                                if(count($students) > 0){
                                                    if(count($students) == count($pre_assigned)){
                                                        echo 'checked';
                                                    }         
                                                }
                                            ?>>
                                            <label for="checkAll" 
                                                
                                           
                                            > <?php echo app('translator')->get('lang.all'); ?></label>
                                        </th>
                                        <th width="20%"><?php echo app('translator')->get('lang.student'); ?> <?php echo app('translator')->get('lang.name'); ?></th>
                                        <th width="10%"><?php echo app('translator')->get('lang.admission'); ?> <?php echo app('translator')->get('lang.no'); ?></th>
                                        <th width="15%"><?php echo app('translator')->get('lang.class'); ?></th>
                                        <th width="15%"><?php echo app('translator')->get('lang.fees_type'); ?></th>
                                        <th width="15%"><?php echo app('translator')->get('lang.father_name'); ?></th>
                                        <th width="10%"><?php echo app('translator')->get('lang.category'); ?></th>
                                        <th width="5%"><?php echo app('translator')->get('lang.gender'); ?></th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td>
                                            <input type="checkbox" id="student.<?php echo e($student->id); ?>" class="common-checkbox" name="student_checked[]" value="<?php echo e($student->id); ?>" <?php echo e(in_array($student->id, $pre_assigned)? 'checked':''); ?>>
                                            <label for="student.<?php echo e($student->id); ?>"></label>
                                        </td>
                                        <td><?php echo e($student->first_name.' '.$student->last_name); ?> <input type="hidden" name="id[]" value="<?php echo e(isset($update)? $student->forwardBalance->id: $student->id); ?>"></td>
                                        <td><?php echo e($student->admission_no); ?></td>
                                        <td><?php echo e($student->className != ""? @$student->className->class_name :""); ?> <?php echo e('('.$student->section!=""? $student->section->section_name:"".')'); ?></td>
                                        <td>
                                            
                                            <?php
                                            $check_discount_apply=DB::table('sm_fees_assign_discounts')
                                            ->where('student_id',$student->id)
                                            ->where('fees_discount_id',$fees_discount_id)
                                            ->where('unapplied_amount','<',$fees_discount->amount)
                                            ->first();
                                            $check_yearly_apply=DB::table('sm_fees_assign_discounts')
                                            ->where('student_id',$student->id)
                                            ->where('fees_discount_id',$fees_discount_id)
                                            // ->where('unapplied_amount','<',$fees_discount->amount)
                                            ->first();
                                            // dd($check_discount_apply);
                                            ?>

                                            

                                            <?php if($fees_discount->type=='once'): ?>

                                                    <?php if($check_discount_apply==''): ?> 
                                                    <select class="niceSelect w-100  form-control<?php echo e($errors->has('fees_master_id') ? ' is-invalid' : ''); ?> select_fees_master" name="fees_master_id[]" id="fees_master<?php echo e($student->id); ?>">
                                                            <option data-display="<?php echo app('translator')->get('lang.select'); ?> <?php echo app('translator')->get('lang.fees_type'); ?> *" value=""><?php echo app('translator')->get('lang.select'); ?> <?php echo app('translator')->get('lang.fees_type'); ?> *</option>
                                                            <?php $__currentLoopData = $assigned_fees_types[$student->id]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fees_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($fees_type->id); ?>")}} ><?php echo e($fees_type->name); ?></option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </select>
                                                        <?php if($errors->has('fees_master_id')): ?>
                                                        <span class="invalid-feedback invalid-select" role="alert">
                                                            <strong><?php echo e($errors->first('fees_master_id')); ?></strong>
                                                        </span>
                                                        <?php endif; ?>
                                                    <?php else: ?> 
                                                        Applied
                                                <?php endif; ?>
                                            <?php else: ?> 
                                            <?php
                                            $group_ids= array();
                                            ?>
                                            <?php if($check_yearly_apply==''): ?>  
                                                        <select class="niceSelect w-100  form-control<?php echo e($errors->has('fees_master_id') ? ' is-invalid' : ''); ?> select_fees_master" name="fees_master_id[]" id="fees_master<?php echo e($student->id); ?>">
                                                             <option data-display="<?php echo app('translator')->get('lang.select'); ?> <?php echo app('translator')->get('lang.fees_group'); ?> *" value=""><?php echo app('translator')->get('lang.select'); ?> <?php echo app('translator')->get('lang.fees_group'); ?> *</option>
                                                             <?php $__currentLoopData = $assigned_fees_groups[$student->id]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=> $fees_group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            
                                                                         <?php
                                                                         // $group_ids=$fees_group->group_id;
                                                                         
                                                                         if( in_array($fees_group->group_id, $group_ids) ) { 
                                                                         continue;
                                                                         }
                                                                         array_push($group_ids,$fees_group->group_id);
                                                                         ?>
                                                                 <option value="<?php echo e($fees_group->group_id); ?>"  ><?php echo e($fees_group->name); ?> </option>
                                                             <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                          </select>
                                                         <?php if($errors->has('fees_master_id')): ?>
                                                         <span class="invalid-feedback invalid-select" role="alert">
                                                             <strong><?php echo e($errors->first('fees_master_id')); ?></strong>
                                                         </span>
                                                         <?php endif; ?>
                                                    <?php else: ?> 
                                                    <select class="niceSelect w-100  form-control<?php echo e($errors->has('fees_master_id') ? ' is-invalid' : ''); ?> select_fees_master" name="fees_master_id[]" id="fees_master<?php echo e($student->id); ?>" disabled>
                                                             <option data-display="<?php echo app('translator')->get('lang.select'); ?> <?php echo app('translator')->get('lang.fees_group'); ?> *" value=""><?php echo app('translator')->get('lang.select'); ?> <?php echo app('translator')->get('lang.fees_group'); ?> *</option>
                                                             <?php $__currentLoopData = $assigned_fees_groups[$student->id]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=> $fees_group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            
                                                                         <?php
                                                                         // $group_ids=$fees_group->group_id;
                                                                         
                                                                         if( in_array($fees_group->group_id, $group_ids) ) { 
                                                                         continue;
                                                                         }
                                                                         array_push($group_ids,$fees_group->group_id);
                                                                         ?>
                                                                 <option value="<?php echo e($fees_group->group_id); ?>" <?php echo e($fees_group->group_id == $check_yearly_apply->fees_group_id? 'selected':''); ?>><?php echo e($fees_group->name); ?> (Applied) </option>
                                                             <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                          </select>
                                                         <?php if($errors->has('fees_master_id')): ?>
                                                         <span class="invalid-feedback invalid-select" role="alert">
                                                             <strong><?php echo e($errors->first('fees_master_id')); ?></strong>
                                                         </span>
                                                         <?php endif; ?>
                                                    <?php endif; ?>
                                            <?php endif; ?>
                                            
                                                


                                          
                                            
                                        
                                        </td>
                                        
                                        <td><?php echo e($student->parents!=""?$student->parents->fathers_name:""); ?></td>
                                        <td><?php echo e($student->category!=""?$student->category->category_name:""); ?></td>
                                        <td><?php echo e($student->gender!=""?$student->gender->base_setup_name:""); ?></td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    
                                </tbody>
                                <?php if($students->count() > 0): ?>
                                <tr>
                                    <td colspan="7">
                                        <div class="text-center">
                                            <button type="button" class="primary-btn fix-gr-bg mb-0" id="btn-assign-fees-discount">
                                                <span class="ti-save pr"></span>
                                                <?php echo app('translator')->get('lang.assign'); ?>  <?php echo app('translator')->get('lang.discount'); ?>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <?php endif; ?>
                                       
                            </table>
                        </div>

                    </div>
                </div>
            </div>
    <?php echo e(Form::close()); ?>

    <?php endif; ?>

    </div>
</section>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('backEnd.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\Server3\htdocs\spondon\infixedu_lv7.0_rv_4.5\resources\views/backEnd/feesCollection/fees_discount_assign.blade.php ENDPATH**/ ?>