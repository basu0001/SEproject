
<?php $__env->startSection('mainContent'); ?>
<?php
    function showPicName($data){
        $name = explode('/', $data);
        return $name[3];
    }
?>
<section class="sms-breadcrumb mb-40 white-box up_breadcrumb">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1><?php echo app('translator')->get('lang.bank'); ?>  <?php echo app('translator')->get('lang.payment'); ?></h1>
            <div class="bc-pages">
                <a href="<?php echo e(url('dashboard')); ?>"><?php echo app('translator')->get('lang.dashboard'); ?></a>
                <a href="#"><?php echo app('translator')->get('lang.fees_collection'); ?></a>
                <a href="#"><?php echo app('translator')->get('lang.bank'); ?>  <?php echo app('translator')->get('lang.payment'); ?></a>
            </div>
        </div>
    </div>
</section>

<section class="admin-visitor-area up_admin_visitor">
    <div class="container-fluid p-0">
        
        <div class="row">
           

            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-4 no-gutters">
                        <div class="main-title">
                            <h3 class="mb-0">  <?php echo app('translator')->get('lang.bank'); ?>  <?php echo app('translator')->get('lang.payment'); ?> <?php echo app('translator')->get('lang.list'); ?></h3>
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
                                    <td colspan="6">
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
                                    <th><?php echo app('translator')->get('lang.student'); ?> <?php echo app('translator')->get('lang.name'); ?></th>
                                    <th><?php echo app('translator')->get('lang.fees_type'); ?></th>
                                    <th><?php echo app('translator')->get('lang.date'); ?></th>
                                    <th><?php echo app('translator')->get('lang.amount'); ?></th>
                                    <th><?php echo app('translator')->get('lang.note'); ?></th>
                                    <th><?php echo app('translator')->get('lang.slip'); ?></th>
                                    <th><?php echo app('translator')->get('lang.status'); ?></th>
                                    <th><?php echo app('translator')->get('lang.actions'); ?></th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php $__currentLoopData = $bank_slips; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bank_slip): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e(@$bank_slip->studentInfo->full_name); ?></td>
                                    <td><?php echo e(@$bank_slip->feesType->name); ?></td>
                                    <td  data-sort="<?php echo e(strtotime(@$bank_slip->date)); ?>" ><?php echo e(!empty($bank_slip->date)? App\SmGeneralSettings::DateConvater(@$bank_slip->date):''); ?></td>
                                    <td><?php echo e(@$bank_slip->amount); ?></td>
                                    <td><?php echo e(@$bank_slip->note); ?></td>
                                    
                                    <td><a class="text-color" data-toggle="modal" data-target="#showCertificateModal<?php echo e(@$bank_slip->id); ?>"  href="#"><?php echo app('translator')->get('lang.view'); ?></a></td>
                                    <td><?php echo e(@$bank_slip->approve_status == 0? 'Pending':'Approved'); ?></td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn dropdown-toggle" data-toggle="dropdown">
                                                <?php echo app('translator')->get('lang.select'); ?>
                                            </button>
                                            <?php if($bank_slip->approve_status == 0): ?>
                                            <div class="dropdown-menu dropdown-menu-right">


                                                   
                                                <a onclick="enableId(<?php echo e($bank_slip->id); ?>);" class="dropdown-item" href="#" data-toggle="modal" data-target="#enableStudentModal" data-id="<?php echo e($bank_slip->id); ?>"  ><?php echo app('translator')->get('lang.approve'); ?></a>


                                                
                                            </div>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>

                                <div class="modal fade admin-query" id="showCertificateModal<?php echo e(@$bank_slip->id); ?>">
                                    <div class="modal-dialog modal-dialog-centered large-modal">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title"><?php echo app('translator')->get('lang.view'); ?> <?php echo app('translator')->get('lang.slip'); ?></h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>
                                            <div class="modal-body p-0">
                                                <div class="container student-certificate">
                                                    <div class="row justify-content-center">
                                                        <div class="col-lg-12 text-center">
                                                            <div class="mb-5">
                                                                <img class="img-fluid" src="<?php echo e(asset($bank_slip->slip)); ?>">
                                                            </div>
                                                        </did> 
                                                        </div>
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

<div class="modal fade admin-query" id="enableStudentModal" >
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo app('translator')->get('lang.approve'); ?> <?php echo app('translator')->get('lang.payment'); ?></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <div class="text-center">
                    <h4><?php echo app('translator')->get('lang.are_you_sure_to_approve'); ?></h4>
                </div>

                <div class="mt-40 d-flex justify-content-between">
                    <button type="button" class="primary-btn tr-bg" data-dismiss="modal"><?php echo app('translator')->get('lang.cancel'); ?></button>
                     <?php echo e(Form::open(['url' => 'approve-fees-payment', 'method' => 'POST', 'enctype' => 'multipart/form-data'])); ?>

                     <input type="hidden" name="id" value="" id="student_enable_i">  
                    <button class="primary-btn fix-gr-bg" type="submit"><?php echo app('translator')->get('lang.approve'); ?></button>
                     <?php echo e(Form::close()); ?>

                </div>
            </div>

        </div>
    </div>
</div>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('backEnd.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\Server3\htdocs\spondon\infixedu_lv7.0_rv_4.5\resources\views/backEnd/feesCollection/bank_payment_slip.blade.php ENDPATH**/ ?>