
<?php $__env->startSection('mainContent'); ?>
<?php  $setting = App\SmGeneralSettings::find(1); if(!empty($setting->currency_symbol)){ $currency = $setting->currency_symbol; }else{ $currency = '$'; } ?>
<section class="sms-breadcrumb mb-40 white-box">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1><?php echo app('translator')->get('lang.fees'); ?></h1>
            <div class="bc-pages">
                <a href="<?php echo e(url('dashboard')); ?>"><?php echo app('translator')->get('lang.dashboard'); ?></a>
                <a href="#"><?php echo app('translator')->get('lang.fees'); ?></a>
                <a href="<?php echo e(route('student_fees')); ?>"><?php echo app('translator')->get('lang.pay_fees'); ?></a>
            </div>
        </div>
    </div>
</section>

<input type="hidden" id="url" value="<?php echo e(URL::to('/')); ?>">
<input type="hidden" id="student_id" value="<?php echo e($student->id); ?>">
<section class="">
    <div class="container-fluid p-0 table-responsive">
        <div class="row">
            <div class="col-lg-4 no-gutters">
                <div class="d-flex justify-content-between">
                    <div class="main-title">
                        <h3 class="mb-30"><?php echo app('translator')->get('lang.fees'); ?> <?php echo app('translator')->get('lang.info'); ?></h3>
                    </div>
                </div>
            </div>
        </div>
              <?php if(session()->has('message-success')): ?>
                <div class="alert alert-success">
                  <?php echo e(session()->get('message-success')); ?>

              </div>
              <?php elseif(session()->has('message-danger')): ?>
              <div class="alert alert-danger">
                  <?php echo e(session()->get('message-danger')); ?>

              </div>
              <?php endif; ?>

        <div class="row">

            <div class="col-md-12">
                <table class="display school-table school-table-style-parent-fees" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th><?php echo app('translator')->get('lang.fees_group'); ?></th>
                            <th><?php echo app('translator')->get('lang.due_date'); ?></th>
                            <th><?php echo app('translator')->get('lang.status'); ?></th>
                            <th><?php echo app('translator')->get('lang.amount'); ?> (<?php echo e($currency); ?>)</th>
                            <th><?php echo app('translator')->get('lang.payment_id'); ?></th>
                            <th><?php echo app('translator')->get('lang.mode'); ?></th>
                            <th><?php echo app('translator')->get('lang.date'); ?></th>
                            <th><?php echo app('translator')->get('lang.discount'); ?> (<?php echo e($currency); ?>)</th>
                            <th><?php echo app('translator')->get('lang.fine'); ?> (<?php echo e($currency); ?>)</th>
                            <th><?php echo app('translator')->get('lang.paid'); ?> (<?php echo e($currency); ?>)</th>
                            <th><?php echo app('translator')->get('lang.balance'); ?> (<?php echo e($currency); ?>)</th>
                            <th><?php echo app('translator')->get('lang.payment'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $grand_total = 0;
                            $total_fine = 0;
                            $total_discount = 0;
                            $total_paid = 0;
                            $total_grand_paid = 0;
                            $total_balance = 0;
                            $count = 0;
                        ?>

                        <?php $__currentLoopData = $fees_assigneds; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fees_assigned): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                           <?php
                           $count++;

                                   $grand_total += $fees_assigned->feesGroupMaster->amount;
                                

                            ?>

                            <?php
                                $discount_amount = $fees_assigned->applied_discount;
                                $total_discount += $discount_amount;
                                $student_id = $fees_assigned->student_id;
                            ?>
                            <?php
                                $paid = App\SmFeesAssign::discountSum($fees_assigned->student_id, $fees_assigned->feesGroupMaster->feesTypes->id, 'amount');
                                $total_grand_paid += $paid;
                            ?>
                            <?php
                                $fine = App\SmFeesAssign::discountSum($fees_assigned->student_id, $fees_assigned->feesGroupMaster->feesTypes->id, 'fine');
                                $total_fine += $fine;
                            ?>

                            <?php
                                $total_paid = $discount_amount + $paid;
                            ?>
                        <tr>
                            <input type="hidden" name="url" id="url" value="<?php echo e(URL::to('/')); ?>">
                            <td><?php echo e(@$fees_assigned->feesGroupMaster->feesGroups->name); ?> / <?php echo e(@$fees_assigned->feesGroupMaster->feesTypes->name); ?></td>
                            <td>
                           <?php echo e(@$fees_assigned->feesGroupMaster->date != ""? App\SmGeneralSettings::DateConvater(@$fees_assigned->feesGroupMaster->date):''); ?>


                            </td>
                            <?php
                                $total_payable_amount=number_format($fees_assigned->feesGroupMaster->amount, 2, '.', '');
                            ?>
                            <?php
                            
                            $rest_amount = $fees_assigned->fees_amount;
                                $total_balance +=  $rest_amount;
                                $balance_amount=number_format($rest_amount+$fine, 2, '.', '');
                        ?>
                        <td>
                            
                            <?php if($balance_amount ==0): ?>
                                <button class="primary-btn small bg-success text-white border-0"><?php echo app('translator')->get('lang.paid'); ?></button>
                            <?php elseif($paid != 0): ?>
                                <button class="primary-btn small bg-warning text-white border-0"><?php echo app('translator')->get('lang.partial'); ?></button>
                            <?php elseif($paid == 0): ?>
                                <button class="primary-btn small bg-danger text-white border-0"><?php echo app('translator')->get('lang.unpaid'); ?></button>
                            <?php endif; ?>
                            
                        </td>
                            <td>
                                <?php
                                    echo $total_payable_amount;
                                ?>
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><?php echo e(number_format($discount_amount, 2, '.', '')); ?></td>
                            <td><?php echo e(number_format($fine, 2, '.', '')); ?></td>
                            <td><?php echo e(number_format($paid, 2, '.', '')); ?></td>
                            <td>
                                <?php

                                        $rest_amount = $fees_assigned->fees_amount;
                                   
                                    // $total_balance +=  $rest_amount;
                                    echo number_format($fees_assigned->fees_amount, 2, '.', '');
                                ?>
                            </td>
                            <td>
                                <?php if($rest_amount != 0): ?>

                                <?php
                                    $already_add = App\SmBankPaymentSlip::where('student_id', $fees_assigned->student_id)->where('fees_type_id', $fees_assigned->feesGroupMaster->fees_type_id)->first();
                                ?>


                                <div class="dropdown">
                                    <button type="button" class="btn dropdown-toggle" data-toggle="dropdown">
                                        <?php echo app('translator')->get('lang.select'); ?>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">

                                        <?php if($already_add == ""): ?>

                                        <?php if(@$data['bank_info']->active_status == 1 || @$data['cheque_info']->active_status == 1): ?>

                                        <a class="dropdown-item modalLink" data-modal-size="modal-lg" title="<?php echo e($fees_assigned->feesGroupMaster->feesGroups->name.': '. $fees_assigned->feesGroupMaster->feesTypes->name); ?>"  href="<?php echo e(url('fees-generate-modal-child', [$rest_amount+$total_fine, $fees_assigned->student_id, $fees_assigned->feesGroupMaster->fees_type_id])); ?>" ><?php echo app('translator')->get('lang.add'); ?> <?php echo app('translator')->get('lang.bank'); ?> <?php echo app('translator')->get('lang.payment'); ?></a>
                                        <?php endif; ?>



                                        <?php else: ?>


                                        <a class="dropdown-item modalLink" data-modal-size="modal-lg" title="<?php echo e($fees_assigned->feesGroupMaster->feesGroups->name.': '. $fees_assigned->feesGroupMaster->feesTypes->name); ?>"  href="<?php echo e(url('fees-generate-modal-child-view', [$already_add->id])); ?>" ><?php echo app('translator')->get('lang.view'); ?> <?php echo app('translator')->get('lang.bank'); ?> <?php echo app('translator')->get('lang.payment'); ?></a>


                                        <?php if($already_add->approve_status == 0): ?>



                                        <a onclick="deleteId(<?php echo e($already_add->id); ?>);" class="dropdown-item" href="#" data-toggle="modal" data-target="#deleteStudentModal" data-id="<?php echo e($already_add->id); ?>"  ><?php echo app('translator')->get('lang.delete'); ?> <?php echo app('translator')->get('lang.bank'); ?> <?php echo app('translator')->get('lang.payment'); ?></a>

                                        <?php endif; ?>
                                        <?php endif; ?>


                                    <?php
                                        $is_paystack = DB::table('sm_payment_methhods')->where('method','Paystack')->where('active_status',1)->first();
                                    ?>
                                    <?php if(!empty($is_paystack)): ?>
                                    <form method="POST" action="<?php echo e(route('pay-with-paystack')); ?>" accept-charset="UTF-8" class="form-horizontal" role="form">

                                        <input type="hidden" name="email" value="otemuyiwa@gmail.com"> 
                                        <input type="hidden" name="orderID" value="345">
                                        <input type="hidden" name="amount" value="<?php echo e($fees_assigned->fees_amount * 100); ?>"> 
                                        <input type="hidden" name="quantity" value="3">
                                        <input type="hidden" name="fees_type_id" value="<?php echo e($fees_assigned->feesGroupMaster->fees_type_id); ?>">
                                        <input type="hidden" name="student_id" value="<?php echo e($student->id); ?>">
                                        <input type="hidden" name="metadata" value="<?php echo e(json_encode($array = ['key_name' => 'value',])); ?>" > 
                                        <input type="hidden" name="reference" value="<?php echo e(Paystack::genTranxRef()); ?>"> 
                                        <input type="hidden" name="key" value="<?php echo e(config('paystack.secretKey')); ?>"> 
                                        <?php echo e(csrf_field()); ?> 

                                         <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>"> 


                                        <button type="submit" class=" dropdown-item">Pay via Paystack </i></button>

                                    </form>
                                    <?php endif; ?>

                                    <?php
                                        $is_stripe = DB::table('sm_payment_methhods')->where('method','Stripe')->where('active_status',1)->where('school_id', Auth::user()->school_id)->first();
                                    ?>
                                    <?php if(!empty($is_stripe)): ?>

                                    <a class="dropdown-item modalLink" data-modal-size="modal-lg" title="<?php echo app('translator')->get('lang.pay'); ?> <?php echo app('translator')->get('lang.fees'); ?> " href="<?php echo e(url('fees-payment-stripe', [@$fees_assigned->feesGroupMaster->fees_type_id, $student->id, $rest_amount])); ?>">Pay via Stripe</a>

                                    <?php endif; ?>



                                    

                                    <?php if(App\SmGeneralSettings::isModule('RazorPay')== TRUE ): ?>

                                    <?php
                                        $is_RazorPay = DB::table('sm_payment_methhods')->where('method','RazorPay')->where('active_status',1)->where('school_id', Auth::user()->school_id)->first();

                                        $razorpay_info = DB::table('sm_payment_gateway_settings')->where('gateway_name','RazorPay')->where('school_id', Auth::user()->school_id)->first();
                                    ?>
                                <?php if(App\SmGeneralSettings::isModule('RazorPay') == TRUE && !empty($is_RazorPay)): ?>
                                    <form id="rzp-footer-form_<?php echo e($count); ?>" action="<?php echo url('razorpay/dopayment'); ?>" method="POST" style="width: 100%; text-align: center" >
                                        <?php echo csrf_field(); ?>

                                        <input type="hidden" name="amount" id="amount" value="<?php echo e($fees_assigned->fees_amount * 100); ?>"/>

                                        <input type="hidden" name="fees_type_id" id="fees_type_id" value="<?php echo e($fees_assigned->feesGroupMaster->fees_type_id); ?>">
                                        <input type="hidden" name="student_id" id="student_id" value="<?php echo e($student->id); ?>">


                                        <input type="hidden" name="amount" id="amount" value="<?php echo e($fees_assigned->fees_amount); ?>"/>
                                        <div class="pay">
                                            <button class="dropdown-item razorpay-payment-button btn filled small" id="paybtn_<?php echo e($count); ?>" type="button">Pay via Razorpay</button>
                                        </div>
                                    </form>
                                    <?php endif; ?>

                                    </div>
                                </div>


                                <script src="https://checkout.razorpay.com/v1/checkout.js"></script>

                                <!-- start razorpay code -->

                                <script>


                                    $('#rzp-footer-form_<?php echo $count; ?>').submit(function (e) {
                                        var button = $(this).find('button');
                                        var parent = $(this);
                                        button.attr('disabled', 'true').html('Please Wait...');
                                        $.ajax({
                                            method: 'get',
                                            url: this.action,
                                            data: $(this).serialize(),
                                            complete: function (r) {
                                                console.log('complete');
                                                console.log(r);
                                            }
                                        })
                                        return false;
                                    })
                                </script>

                                <script>
                                    function padStart(str) {
                                        return ('0' + str).slice(-2)
                                    }

                                    function demoSuccessHandler(transaction) {
                                        // You can write success code here. If you want to store some data in database.
                                        $("#paymentDetail").removeAttr('style');
                                        $('#paymentID').text(transaction.razorpay_payment_id);
                                        var paymentDate = new Date();
                                        $('#paymentDate').text(
                                                padStart(paymentDate.getDate()) + '.' + padStart(paymentDate.getMonth() + 1) + '.' + paymentDate.getFullYear() + ' ' + padStart(paymentDate.getHours()) + ':' + padStart(paymentDate.getMinutes())
                                                );

                                        $.ajax({
                                            method: 'post',
                                            url: "<?php echo url('razorpay/dopayment'); ?>",
                                            data: {
                                                "_token": "<?php echo e(csrf_token()); ?>",
                                                "razorpay_payment_id": transaction.razorpay_payment_id,
                                                "amount": <?php echo $rest_amount * 100; ?>,
                                                "fees_type_id": <?php echo $fees_assigned->feesGroupMaster->fees_type_id; ?>,
                                                "student_id": <?php echo $student->id; ?>
                                            },
                                            complete: function (r) {
                                                console.log('complete');
                                                console.log(r);

                                                setTimeout(function () {
                                                    toastr.success('Operation successful', 'Success', {
                                                        "iconClass": 'customer-info'
                                                    }, {
                                                        timeOut: 2000
                                                    });
                                                }, 500);

                                                location.reload();
                                            }
                                        })
                                    }
                                </script>
                                <script>
                                    var options_<?php echo $count; ?> = {
                                        key: "<?php echo e(@$razorpay_info->gateway_secret_key); ?>",
                                        amount: <?php echo $rest_amount * 100;?>,
                                        name: 'Online fee payment',
                                        image: 'https://i.imgur.com/n5tjHFD.png',
                                        handler: demoSuccessHandler
                                    }
                                </script>
                                <script>
                                    window.r_<?php echo $count; ?> = new Razorpay(options_<?php echo $count; ?>);
                                    document.getElementById('paybtn_<?php echo $count; ?>').onclick = function () {
                                        r_<?php echo $count; ?>.open()
                                    }
                                </script>
                                <!-- end razorpay code -->

                                <?php endif; ?>
                                
                                <?php endif; ?>

                                

                            </td>

                        </tr>
                            <?php
                                $payments = App\SmFeesAssign::feesPayment($fees_assigned->feesGroupMaster->feesTypes->id, $fees_assigned->student_id);


                                $i = 0;
                            ?>

                            <?php $__currentLoopData = $payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="text-right"><img src="<?php echo e(asset('public/backEnd/img/table-arrow.png')); ?>"></td>
                                <td>


                                <?php
                                    $created_by = App\User::find($payment->created_by);
                                ?>

                                <?php if($created_by != ""): ?>
                                        <a href="#" data-toggle="tooltip" data-placement="right" title="<?php echo e('Collected By: '.$created_by->full_name); ?>"><?php echo e($payment->fees_type_id.'/'.$payment->id); ?></a></td>
                                <?php endif; ?>


                                <td>
                                <?php echo e($payment->payment_mode); ?>

                                </td>
                                <td>
                                 <?php echo e($payment->payment_date != ""? App\SmGeneralSettings::DateConvater($payment->payment_date):''); ?>

                                </td>
                                <td><?php echo e(number_format($payment->discount_amount, 2, '.', '')); ?></td>
                                <td><?php echo e(number_format($payment->fine, 2, '.', '')); ?></td>
                                <td><?php echo e(number_format($payment->amount, 2, '.', '')); ?></td>
                                <td></td>
                                <td>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php $__currentLoopData = $fees_discounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fees_discount): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td> <?php echo app('translator')->get('lang.discount'); ?></td>
                            <td><?php echo e($fees_discount->feesDiscount !=""?$fees_discount->feesDiscount->name:""); ?></td>
                            <td></td>
                            <td><?php if(in_array($fees_discount->id, $applied_discount)): ?>
                                <?php
                                    $createdBy = App\SmFeesAssign::createdBy($student_id, $fees_discount->id);
                                ?>

                                <?php if($createdBy != ""): ?>
                                   <?php
                                     $created_by = App\User::find($createdBy->created_by)
                                   ?>
                                    <?php if(!empty( $created_by )): ?>
                                        <a href="#" data-toggle="tooltip" data-placement="right" title="<?php echo e('Collected By: '.$created_by->full_name); ?>"><?php echo app('translator')->get('lang.discount'); ?> <?php echo app('translator')->get('lang.of'); ?> <?php echo e($currency); ?><?php echo e(number_format($fees_discount->feesDiscount->amount, 2, '.', '')); ?> <?php echo app('translator')->get('lang.applied'); ?> : <?php echo e($createdBy->id.'/'.$createdBy->created_by); ?></a>
                                    <?php endif; ?>

                                <?php endif; ?>

                                <?php else: ?>
                                <?php echo app('translator')->get('lang.discount_of'); ?> <?php echo e($currency); ?><?php echo e($fees_discount->feesDiscount !=""?number_format($fees_discount->feesDiscount->amount, 2, '.', '') :""); ?> <?php echo app('translator')->get('lang.assigned'); ?>
                                <?php endif; ?>
                            </td>
                            <td><?php echo e($fees_discount->name); ?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </tbody>
                    <tfoot>
                        <tr>
                            <th></th>
                            <th><?php echo app('translator')->get('lang.grand_total'); ?> (<?php echo e($currency); ?>)</th>
                            <th></th>
                            <th><?php echo e(number_format($grand_total, 2, '.', '')); ?></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th><?php echo e(number_format($total_discount, 2, '.', '')); ?></th>
                            <th><?php echo e(number_format($total_fine, 2, '.', '')); ?></th>
                            <th><?php echo e(number_format($total_grand_paid, 2, '.', '')); ?></th>
                            <th><?php echo e(number_format($total_balance, 2, '.', '')); ?></th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</section>

<div class="modal fade admin-query" id="deleteFeesPayment" >
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo app('translator')->get('lang.delete'); ?> <?php echo app('translator')->get('lang.item'); ?></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <div class="text-center">
                    <h4><?php echo app('translator')->get('lang.are_you_sure_to_delete'); ?></h4>
                </div>

                <div class="mt-40 d-flex justify-content-between">
                    <button type="button" class="primary-btn tr-bg" data-dismiss="modal"><?php echo app('translator')->get('lang.cancel'); ?></button>
                     <?php echo e(Form::open(['url' => 'fees-payment-delete', 'method' => 'POST', 'enctype' => 'multipart/form-data'])); ?>

                     <input type="hidden" name="id" id="feep_payment_id">
                    <button class="primary-btn fix-gr-bg" type="submit"><?php echo app('translator')->get('lang.delete'); ?></button>
                     <?php echo e(Form::close()); ?>

                </div>
            </div>

        </div>
    </div>
</div>
<div class="modal fade admin-query" id="deleteStudentModal" >
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                 <h4 class="modal-title"><?php echo app('translator')->get('lang.delete'); ?> <?php echo app('translator')->get('lang.item'); ?></h4> 
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <div class="text-center">
                    <h4><?php echo app('translator')->get('lang.are_you_sure_to_delete'); ?></h4> 
                </div>

                <div class="mt-40 d-flex justify-content-between">
                    <button type="button" class="primary-btn tr-bg" data-dismiss="modal"><?php echo app('translator')->get('lang.cancel'); ?></button>
                     <?php echo e(Form::open(['url' => 'child-bank-slip-delete', 'method' => 'POST', 'enctype' => 'multipart/form-data'])); ?>

                     <input type="hidden" name="id" value="" id="student_delete_i">  
                    <button class="primary-btn fix-gr-bg" type="submit"><?php echo app('translator')->get('lang.delete'); ?></button>
                     <?php echo e(Form::close()); ?>

                </div>
            </div>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backEnd.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\Server3\htdocs\spondon\infixedu_lv7.0_rv_4.5\resources\views/backEnd/parentPanel/childrenFees.blade.php ENDPATH**/ ?>