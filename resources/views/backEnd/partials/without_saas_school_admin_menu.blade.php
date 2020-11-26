                    @if(@in_array(399, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                        <li>
                            <a href="{{url('manage-adons')}}">@lang('lang.module') @lang('lang.manager')</a>
                        </li>
                    @endif

                        @if(@in_array(401, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('manage-currency')}}">@lang('lang.manage') @lang('lang.currency')</a>
                                </li>
                        @endif

                       @if(in_array(410, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)

                            <li>
                                <a href="{{url('email-settings')}}">@lang('lang.email_settings')</a>
                            </li>
                        @endif
                       {{--  @if(@in_array(152, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                            <li>
                                <a href="{{route('payment_method')}}"> @lang('lang.payment_method')</a>
                            </li>
                        @endif
                        @if(@in_array(412, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)

                            <li>
                                <a href="{{url('payment-method-settings')}}">@lang('lang.payment_method_settings')</a>
                            </li>
                        @endif --}}

                       @if(@in_array(428, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)

                                <li>
                                    <a href="{{route('base_setup')}}">@lang('lang.base_setup')</a>
                                </li>
                         @endif

                         @if(@in_array(549, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)

                            <li>
                                <a href="{{url('language-list')}}">@lang('lang.language')</a>
                            </li>
                        @endif

                        @if(@in_array(451, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)

                            <li>
                                <a href="{{url('language-settings')}}">@lang('lang.language_settings')</a>
                            </li>
                        @endif
                        @if(@in_array(456, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)

                            <li>
                                <a href="{{url('backup-settings')}}">@lang('lang.backup_settings')</a>
                            </li>
                        @endif
                        
                       @if(@in_array(444, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)

                            <li>
                                <a href="{{url('sms-settings')}}">@lang('lang.sms_settings')</a>
                            </li>
                        @endif
                       
                        @if(@in_array(463, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                            <li>
                                <a href="{{url('button-disable-enable')}}">@lang('lang.button') @lang('lang.manage') </a>
                            </li>
                        @endif


                        @if(@in_array(477, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)

                            <li>
                                <a href="{{url('about-system')}}">@lang('lang.about')</a>
                            </li>
                        @endif

                        @if(@in_array(478, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)

                            <li>
                                <a href="{{url('update-system')}}">@lang('lang.update')</a>
                            </li>
                        @endif
                       
                        @if(@in_array(480, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                            <li>
                                <a href="{{url('templatesettings/email-template')}}">@lang('lang.email') @lang('lang.template')</a>
                            </li>
                            {{-- <li>
                                <a href="{{url('sms-template')}}">@lang('lang.sms') @lang('lang.template')</a>
                            </li> --}}
                        @endif
                        @if(@in_array(482, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                        <li>
                            <a href="{{url('api/permission')}}">@lang('lang.api') @lang('lang.permission') </a>
                        </li>
                    @endif
