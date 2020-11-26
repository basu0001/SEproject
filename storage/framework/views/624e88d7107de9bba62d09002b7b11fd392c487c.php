
<script src="<?php echo e(asset('public/backEnd/')); ?>/js/main.js"></script>
<script src="<?php echo e(asset('public/backEnd/')); ?>/vendors/js/jquery-3.2.1.min.js"></script>

<style type="text/css">
    .bank-details p, .cheque-details p{
        margin:0 !important;
    }
</style>

<?php if(@$method['bank_info']->active_status == 1): ?>

<style type="text/css">

    .cheque-details{
        display: none;
    }

</style>

<?php elseif(@$method['cheque_info']->active_status == 1): ?>

<style type="text/css">

    .bank-details{
        display: none;
    }
    
</style>

<?php endif; ?>

<div class="container-fluid">
    
    <?php echo e(Form::open(['class' => 'form-horizontal', 'files' => true, 'url' => 'child-bank-slip-store',
                        'method' => 'POST', 'enctype' => 'multipart/form-data', 'name' => 'myForm', 'onsubmit' => "return validateFormFees()"])); ?>



        <div class="row">
            <div class="col-lg-12">
                <div class="row mt-25">
                    <div class="col-lg-12">
                        <div class="no-gutters input-right-icon">
                            <div class="col">
                                <div class="input-effect">
                                    <input class="primary-input date form-control" id="startDate" type="text"
                                         name="date" value="<?php echo e(isset($fees_payment)? date('m/d/Y', strtotime($fees_payment->date)) : date('m/d/Y')); ?>" readonly>
                                        <label><?php echo app('translator')->get('lang.date'); ?></label>
                                        <span class="focus-border"></span>
                                </div>
                            </div>
                            <div class="col-auto">
                                <button class="" type="button">
                                    <i class="ti-calendar" id="start-date-icon"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <input type="hidden" name="url" id="url" value="<?php echo e(URL::to('/')); ?>">
                <input type="hidden" name="real_amount" id="real_amount" value="<?php echo e($amount); ?>">
                <input type="hidden" name="student_id" value="<?php echo e($student_id); ?>">
                <input type="hidden" name="fees_type_id" value="<?php echo e($fees_type_id); ?>">

                <div class="row mt-25">
                    <div class="col-lg-12" id="sibling_class_div">
                        <div class="input-effect">
                            <input class="primary-input form-control" type="text" name="amount" value="<?php echo e(isset($fees_payment)? $fees_payment->amount: $amount); ?>" id="amount">
                            <label><?php echo app('translator')->get('lang.amount'); ?> <span>*</span> </label>
                            <span class="focus-border"></span>
                            
                            <span class=" text-danger" role="alert" id="amount_error">
                                
                            </span>
                            
                        </div>
                    </div>
                </div>
                <div class="row mt-25" id="fine_title" style="display:none">
                   
                    <div class="col-lg-12">
                        <div class="input-effect">
                            <input class="primary-input form-control"  type="text" name="fine_title" >
                            <label><?php echo app('translator')->get('lang.fine'); ?> <?php echo app('translator')->get('lang.title'); ?> <span>*</span> </label>
                            <span class="focus-border"></span>
                        </div>
                    </div>
                </div>
                <script>
                function checkFine(){
                    var fine_amount=document.getElementById("fine_amount").value;
                    var fine_title=document.getElementById("fine_title");
                    if (fine_amount>0) {
                        fine_title.style.display = "block";
                    } else {
                        fine_title.style.display = "none";
                    }
                }
                </script>
                <div class="row mt-50">
                    <div class="col-lg-3">
                        <p class="text-uppercase fw-500 mb-10"><?php echo app('translator')->get('lang.payment'); ?> <?php echo app('translator')->get('lang.mode'); ?> *</p>
                    </div>
                    <div class="col-lg-6">
                            <div class="d-flex radio-btn-flex ml-40">
                                <?php if(@$method['bank_info']->active_status == 1): ?>
                                <div class="mr-30">
                                    <input type="radio" name="payment_mode" id="cash" value="bank" class="common-radio relationButton" onclick="relationButton('Bk')" <?php echo e(@$method['bank_info']->active_status == 1? 'checked':''); ?>>
                                    <label for="cash"><?php echo app('translator')->get('lang.bank'); ?></label>
                                </div>
                                <?php endif; ?>
                                <?php if(@$method['cheque_info']->active_status == 1): ?>
                                <div class="mr-30">
                                    <input type="radio" name="payment_mode" id="cheque" value="cheque" class="common-radio relationButton"  onclick="relationButton('Cq')" <?php echo e(@$method['bank_info']->active_status != 1? 'checked':''); ?>>
                                    <label for="cheque"><?php echo app('translator')->get('lang.cheque'); ?></label>
                                </div>
                                <?php endif; ?>
                            </div>
                    </div>
                </div>
               
               <div class="row">
                <div class="col-md-6 bank-details" id="bank-area">
                    <strong><?php echo $data['bank_info']->bank_details; ?></strong>
                </div>
                <div class="col-md-6 cheque-details" id="cheque-area">
                    <strong><?php echo $data['cheque_info']->cheque_details; ?></strong>
                </div>
               </div>
               
                <div class="row mt-25">
                    <div class="col-lg-12" id="sibling_name_div">
                        <div class="input-effect mt-20">
                            <textarea class="primary-input form-control" cols="0" rows="3" name="note" id="note"><?php echo e(isset($fees_payment)?$fees_payment->note:''); ?></textarea>
                            <label><?php echo app('translator')->get('lang.note'); ?> </label>
                            <span class="focus-border textarea"></span>
                        </div>
                    </div>
                </div>
                    <div class="row no-gutters input-right-icon mt-35">
                        <div class="col">
                            <div class="input-effect">
                                <input class="primary-input" id="placeholderInput" type="text"
                                       placeholder="<?php echo e(isset($visitor)? ($visitor->file != ""? showPicName($visitor->file):'File Name'):'File Name'); ?>"
                                       readonly>
                                <span class="focus-border"></span>

                                <?php if($errors->has('file')): ?>
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong><?php echo e(@$errors->first('file')); ?></strong>
                                    </span>
                            <?php endif; ?>
                            
                            </div>
                        </div>
                        <div class="col-auto">
                            <button class="primary-btn-small-input" type="button">
                                <label class="primary-btn small fix-gr-bg"
                                       for="browseFile"><?php echo app('translator')->get('lang.browse'); ?></label>
                                <input type="file" class="d-none" id="browseFile" name="slip">
                            </button>
                        </div>
                </div>
            </div>


            <!-- <div class="col-lg-12 text-center mt-40">
                <button class="primary-btn fix-gr-bg" id="save_button_sibling" type="button">
                    <span class="ti-check"></span>
                    save information
                </button>
            </div> -->
            <div class="col-lg-12 text-center mt-40">
                <div class="mt-40 d-flex justify-content-between">
                    <button type="button" class="primary-btn tr-bg" data-dismiss="modal"><?php echo app('translator')->get('lang.cancel'); ?></button>

                    <button class="primary-btn fix-gr-bg" type="submit">
                    <?php if(!isset($fees_payment)): ?>
                    <?php echo app('translator')->get('lang.save'); ?> 
                    <?php else: ?>
                    <?php echo app('translator')->get('lang.update'); ?>
                    <?php endif; ?>

                    <?php echo app('translator')->get('lang.information'); ?></button>
                </div>
            </div>
        </div>
    <?php echo e(Form::close()); ?>

</div>
<script type="text/javascript">

        relationButton = (status) => {

            var cheque_area = document.getElementById("cheque-area");

            var bank_area = document.getElementById("bank-area");

            if(status == "Bk"){
                cheque_area.style.display = "none";
                bank_area.style.display = "block";

            }else if(status == "Cq"){

                cheque_area.style.display = "block";
                bank_area.style.display = "none";

            }
        }


    
</script>
<?php /**PATH E:\Server3\htdocs\spondon\infixedu_lv7.0_rv_4.5\resources\views/backEnd/studentPanel/fees_generate_modal_child.blade.php ENDPATH**/ ?>