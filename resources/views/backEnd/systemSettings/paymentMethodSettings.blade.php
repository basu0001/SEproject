@extends('backEnd.master')
@section('mainContent')
<section class="sms-breadcrumb mb-40 white-box">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1>@lang('lang.payment_method_settings')</h1>
            <div class="bc-pages">
                <a href="{{url('dashboard')}}">@lang('lang.dashboard')</a>
                <a href="#">@lang('lang.system_settings')</a>
                <a href="#">@lang('lang.payment_method_settings')</a>
            </div>
        </div>
    </div>
</section>
<section class="mb-40 student-details">
    <div class="container-fluid p-0">
        <div class="row">

            
                <!-- Select a Payment Gateway -->    
                 <div class="col-lg-3">
                    <div class="main-title">
                        <h3 class="mb-30">@lang('lang.select_a_payment_gateway')   </h3>  
                    </div>
                    @if(in_array(413, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1 )
                        {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'url' => 'is-active-payment']) }}
                    @endif
                    <div class="white-box">
                        <div class="row mt-40">
                            <div class="col-lg-12">
                                
                                 @foreach($paymeny_gateway as $value)

                                  @if(App\SmGeneralSettings::isModule('RazorPay') == FALSE && $value->method =="RazorPay" ) 

                                  @else
                                    <div class="input-effect">
                                        <input type="checkbox" id="gateway_{{@$value->method}}" class="common-checkbox class-checkbox" name="gateways[{{@$value->id}}]" value="{{@$value->id}}" {{@$value->active_status == 1? 'checked':''}}>
                                        <label for="gateway_{{@$value->method}}">{{@$value->method}}  
                                        </label>
                                    </div>
                                    @endif

                                @endforeach


                                        @if($errors->has('gateways'))
                                            <span class="text-danger validate-textarea-checkbox" role="alert">
                                                <strong>{{ $errors->first('gateways') }}</strong>
                                            </span>
                                        @endif

                            </div>
                        </div>

                        @php 
                            $tooltip = "";
                            if(in_array(413, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1 ){
                                    $tooltip = "";
                                }else{
                                    $tooltip = "You have no permission to Update";
                                }
                        @endphp
                        <div class="row mt-40">
                            <div class="col-lg-12 text-center">
                                <button class="primary-btn fix-gr-bg" data-toggle="tooltip" title="{{@$tooltip}}">
                                    <span class="ti-check"></span>
                                    @lang('lang.update')
                                </button>
                            </div>
                        </div>
                    </div>


                    {{ Form::close() }}




                </div>
                <!-- End Select a Payment Gateway -->  


            <div class="col-lg-9">
                 <ul class="nav nav-tabs justify-content-end mt-sm-md-20 mb-30" role="tablist">
                    @foreach($paymeny_gateway_settings as $row) 
                    @if(App\SmGeneralSettings::isModule('RazorPay') == FALSE && $row->gateway_name =="RazorPay")
                    @else

                        <li class="nav-item">
                            <a class="nav-link @if(@$row->gateway_name=='Stripe') active show @endif " href="#{{@$row->gateway_name}}" role="tab" data-toggle="tab">{{@$row->gateway_name}}</a> 
                        </li> 

                    @endif
                    @endforeach 
                </ul>



                <!-- Tab panes -->
                <div class="tab-content">

                    @foreach($paymeny_gateway_settings as $row) 

                            <div role="tabpanel" class="tab-pane fade   @if(@$row->gateway_name=='Stripe') active show @endif " id="{{@$row->gateway_name}}">
 
                                @if(in_array(414, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1 )
                                    <form class="form-horizontal" action="{{url('/update-payment-gateway')}}" method="POST">
                                @endif   
                                    @csrf 
                                    <div class="white-box">

                                        

                                        <div class="">
                                            <input type="hidden" name="url" id="url" value="{{URL::to('/')}}"> 
                                            <input type="hidden" name="gateway_name" id="gateway_{{@$row->gateway_name}}" value="{{@$row->gateway_name}}"> 
                                            <div class="row mb-30">
                                               <div class="col-md-10">
                                                <?php 

                                                if(@$row->gateway_name=="PayPal")
                                                {
                                                    @$paymeny_gateway = ['gateway_name','gateway_username','gateway_password','gateway_signature','gateway_client_id','gateway_mode','gateway_secret_key'];
                                                } 
                                                else if(@$row->gateway_name=="Stripe")
                                                { 
                                                    @$paymeny_gateway = ['gateway_name','gateway_username','gateway_secret_key','gateway_publisher_key']; 
                                                }
                                                else if(@$row->gateway_name=="Paystack")
                                                { 

                                                    @$paymeny_gateway = ['gateway_name','gateway_username','gateway_secret_key','gateway_publisher_key'];

                                                }else if(@$row->gateway_name=="Razorpay")
                                                { 
                                                    @$paymeny_gateway = ['gateway_name','gateway_secret_key','gateway_publisher_key'];

                                                }else if(@$row->gateway_name=="Bank"){
                                                    @$paymeny_gateway = ['gateway_name', 'bank_details'];

                                                }else if(@$row->gateway_name=="Cheque"){ 
                                                    @$paymeny_gateway = ['gateway_name','cheque_details'];

                                                }
                                                    if(@$row->gateway_name=="Stripe" || @$row->gateway_name=="Paystack" || @$row->gateway_name=="RazorPay"){

                                                    $count=0;

                                                    foreach ($paymeny_gateway as $input_field) {
                                                        @$newStr = @$input_field;
                                                        @$label_name = str_replace('_', ' ', @$newStr);  
                                                        @$value= @$row->$input_field; ?>

                                                        <div class="row">
                                                            <div class="col-lg-12 mb-30">
                                                                <div class="input-effect">
                                                                    <input class="primary-input form-control{{ $errors->has($input_field) ? ' is-invalid' : '' }}"
                                                                    type="text" name="{{$input_field}}" id="gateway_{{$input_field}}" autocomplete="off" value="{{isset($value)? $value : ''}}" @if(@$count==0) readonly="" @endif>
                                                                    <label>{{@$label_name}} <span></span> </label>
                                                                    <span class="focus-border"></span>
                                                                    <span class="modal_input_validation red_alert"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php $count++; } ?>

                                              <?php  }elseif(@$row->gateway_name=="Bank" || @$row->gateway_name=="Cheque") {

                                                $count=0;

                                                    foreach ($paymeny_gateway as $input_field) {
                                                        @$newStr = @$input_field;
                                                        @$label_name = str_replace('_', ' ', @$newStr);  
                                                        @$value= @$row->$input_field; ?>
                                                        @if($count == 0)

                                                            <div class="row">
                                                            <div class="col-lg-12 mb-30">
                                                                <div class="input-effect">
                                                                    <input class="primary-input form-control{{ $errors->has($input_field) ? ' is-invalid' : '' }}"
                                                                    type="text" name="{{$input_field}}" id="gateway_{{$input_field}}" autocomplete="off" value="{{isset($value)? $value : ''}}" @if(@$count==0) readonly="" @endif>
                                                                    <label>{{@$label_name}} <span></span> </label>
                                                                    <span class="focus-border"></span>
                                                                    <span class="modal_input_validation red_alert"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @else
                                                        
                                                        <div class="row">
                                                            <div class="col-lg-12 mt-50">
                                                                <div class="input-effect sm2_mb_20">
                                                                    <script src="https://cdn.ckeditor.com/4.12.1/standard/ckeditor.js"></script>
                                                                    <textarea class="primary-input article-ckeditor form-control" cols="0" rows="3" name="{{$input_field}}" id="article-ckeditor">{{@$value}}</textarea>

                                                                    <script>
                                                                        CKEDITOR.replace( "<?php echo $input_field ?>" );
                                                                    </script>
                                                                    <span class="focus-border textarea"></span>
                                                                    <label class="textarea-label"> @lang('lang'.'.'.$input_field) <span></span> </label>
                                                                </div>
                                                            </div>
                                                        </div>


                                                        @endif
                                                        

                                                        <?php $count++; } 



                                              }
                                              ?>


                                            </div>

                                            <div class="col-md-7">
                                                <div class="row justify-content-center">
                                                    @if(!empty(@$row->logo))
                                                        <img class="logo"  src="{{ URL::asset(@$row->logo) }}" style="width: auto; height: 100px; ">  

                                                    @endif


                                                </div>
                                                <div class="row justify-content-center">
                                                  
                                                        @if(session()->has('message-success'))
                                                          <p class=" text-success">
                                                              {{ session()->get('message-success') }}
                                                          </p>
                                                        @elseif(session()->has('message-danger'))
                                                          <p class=" text-danger">
                                                              {{ session()->get('message-danger') }}
                                                          </p>
                                                        @endif 
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    @php 
                                        $tooltip = "";
                                        if(in_array(414, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1 ){
                                                $tooltip = "";
                                            }else{
                                                $tooltip = "You have no permission to add";
                                            }
                                    @endphp
                                    <div class="row mt-40">
                                        <div class="col-lg-12 text-center">
                                            <button class="primary-btn fix-gr-bg" data-toggle="tooltip" title="{{@$tooltip}}">
                                                <span class="ti-check"></span>
                                                @lang('lang.update')
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>



                        </div> 

                    @endforeach 

                </div>
            </div>



        </div>
    </div>
</section>
@endsection
