

<li>

    @if(Auth::user()->role_id == 1)
        <a href="{{url('/superadmin-dashboard')}}" id="admin-dashboard">
    @else
        <a href="{{url('/admin-dashboard')}}" id="admin-dashboard">
    @endif
    
        <span class="flaticon-speedometer"></span>
        @lang('lang.dashboard')
    </a>
    </li>
    <li>
    <a href="#subMenuAdministrator" data-toggle="collapse" aria-expanded="false"
        class="dropdown-toggle">
        <span class="flaticon-analytics"></span>
        @lang('lang.institution')
        
    </a>
    <ul class="collapse list-unstyled" id="subMenuAdministrator">
        <li>
            <a href="{{url('administrator/institution-list')}}">@lang('lang.institution') @lang('lang.list')</a>
        </li>
    </ul>
    </li>
    
    
    
    {{-- <li>
    <a href="#subMenuPackages" data-toggle="collapse" aria-expanded="false"
        class="dropdown-toggle">
        <span class="flaticon-analytics"></span>
        @lang('lang.packages')
    </a>
    <ul class="collapse list-unstyled" id="subMenuPackages">
        <li>
            <a href="{{url('administrator/package-list')}}"> @lang('lang.package_list')</a>
        </li>
    </ul>
    </li>
    
    <li>
    <a href="#subMenuInfixInvoice" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
        <span class="flaticon-accounting"></span> Invoice </a>
    <ul class="collapse list-unstyled" id="subMenuInfixInvoice">
        <li><a href="{{url('infix/invoice-create')}}">Invoice Create</a></li>
        <li><a href="{{url('infix/invoice-list')}}">Invoice list</a></li>
        <li><a href="{{url('infix/invoice-category')}}">Invoice Category</a></li>
        <li><a href="{{url('infix/invoice-setting')}}">Invoice Setting</a></li>
    
    </ul>
    </li> --}}
    
    <li>
    <a href="#subMenuCommunicate" data-toggle="collapse" aria-expanded="false"
        class="dropdown-toggle">
        <span class="flaticon-email"></span>
        @lang('lang.communicate')
    </a>
    <ul class="collapse list-unstyled" id="subMenuCommunicate">
        <li>
            <a href="{{url('administrator/send-mail')}}">@lang('lang.send') @lang('lang.mail')</a>
            <a href="{{url('administrator/send-sms')}}">@lang('lang.send') @lang('lang.sms')</a>
            <a href="{{url('administrator/send-notice')}}">@lang('lang.send') @lang('lang.notice')</a>
        </li>
    </ul>
    </li>
    
    <li>
    <a href="#subMenuInfixInvoice" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
        <span class="flaticon-accounting"></span> Reports </a>
    <ul class="collapse list-unstyled" id="subMenuInfixInvoice">
        <li><a href="{{url('administrator/student-list')}}">@lang('lang.student') @lang('lang.list')</a></li>
        <li><a href="{{url('administrator/income-expense')}}">@lang('lang.income')/@lang('lang.expense')</a></li>
        <li><a href="{{url('administrator/teacher-list')}}">@lang('lang.teacher') @lang('lang.list')</a></li>
        <li><a href="{{url('administrator/class-list')}}">@lang('lang.class') @lang('lang.list')</a></li>
        <li><a href="{{url('administrator/class-routine')}}">@lang('lang.class') @lang('lang.routine')</a></li>
        <li><a href="{{url('administrator/student-attendance')}}">@lang('lang.student') @lang('lang.attendance')</a></li>
        <li><a href="{{url('administrator/staff-attendance')}}">@lang('lang.staff') @lang('lang.attendance')</a></li>
        <li><a href="{{url('administrator/merit-list-report')}}">@lang('lang.merit_list_report')</a></li>
        <li><a href="{{url('administrator/mark-sheet-report-student')}}">@lang('lang.mark_sheet_report')</a></li>
        <li><a href="{{url('administrator/tabulation-sheet-report')}}">@lang('lang.tabulation_sheet_report')</a></li>
    
        <li><a href="{{url('administrator/progress-card-report')}}">Progress Card Report</a></li>
    </ul>
    </li>
    <li>
    <a href="#subMenusystemSettings" data-toggle="collapse" aria-expanded="false"
        class="dropdown-toggle">
        <span class="flaticon-settings"></span>
        @lang('lang.system_settings')
    </a>
    <ul class="collapse list-unstyled" id="subMenusystemSettings">
        
            <li>
                <a href="{{url('administrator/general-settings')}}"> @lang('lang.general_settings')</a>
            </li>
        
            <li>
                <a href="{{url('administrator/email-settings')}}">@lang('lang.email_settings')</a>
            </li>
    
            <li>
                <a href="{{url('administrator/manage-currency')}}">@lang('lang.manage-currency')</a>
            </li>
            
        
            {{-- <li>
                <a href="{{url('payment-method-settings')}}">@lang('lang.payment_method_settings')</a>
            </li> --}}
        
        
            {{-- <li>
                <a href="{{route('role')}}">@lang('lang.role')</a>
            </li> --}}
        
            <li>
                <a href="{{ url('administrator/module-permission')}}">@lang('lang.module') @lang('lang.permission')</a>
            </li>
        
            {{-- <li>
                <a href="{{url('login-access-control')}}">@lang('lang.login_permission')</a>
            </li> --}}
        
            <li>
                <a href="{{url('administrator/base-group')}}">@lang('lang.base_group')</a>
            </li>
        
            <li>
                <a href="{{url('administrator/base-setup')}}">@lang('lang.base_setup')</a>
            </li>
        
            {{-- <li>
                <a href="{{url('academic-year')}}">@lang('lang.academic_year')</a>
            </li> --}}
        
            {{-- <li>
                <a href="{{url('session')}}">@lang('lang.session')</a>
            </li> --}}
            {{-- <li>
                <a href="{{url('sms-settings')}}">@lang('lang.sms_settings')</a>
            </li> --}}
            <li>
                <a href="{{url('administrator/language-settings')}}">@lang('lang.language_settings')</a>
            </li>
        
            <li>
                <a href="{{url('administrator/backup-settings')}}">@lang('lang.backup_settings')</a>
            </li>
        
            <li>
                <a href="{{url('administrator/update-system')}}">@lang('lang.update_system')</a>
            </li>
        
        @if(Auth::user()->role_id == 1)
            <li>
                <a href="{{url('administrator/admin-data-delete')}}">@lang('lang.SampleDataEmpty')</a>
            </li>
        @endif
    
    </ul>
    </li>
    
    
    
    
                    <li>
                        <a href="#subMenusystemStyle" data-toggle="collapse" aria-expanded="false"
                            class="dropdown-toggle">
                            <span class="flaticon-settings"></span>
                            @lang('lang.style')
                        </a>
                        <ul class="collapse list-unstyled" id="subMenusystemStyle">
                                <li>
                                    <a href="{{url('administrator/background-setting')}}">@lang('lang.background_settings')</a>
                                </li>
                                <li>
                                    <a href="{{url('administrator/color-style')}}">@lang('lang.color') @lang('lang.theme')</a>
                                </li>
                        </ul>
                    </li>
    
                    <li>
                        <a href="#subMenuApi" data-toggle="collapse" aria-expanded="false"
                            class="dropdown-toggle">
                            <span class="flaticon-settings"></span>
                            @lang('lang.api')
                            @lang('lang.permission')
                        </a>
                        <ul class="collapse list-unstyled" id="subMenuApi">
                                <li>
                                    <a href="{{url('administrator/api/permission')}}">@lang('lang.api') @lang('lang.permission') </a>
                                </li>
                        </ul>
                    </li>
    
    
    
                    <li>
                        <a href="#subMenufrontEndSettings" data-toggle="collapse" aria-expanded="false"
                            class="dropdown-toggle">
                            <span class="flaticon-software"></span>
                            @lang('lang.front_settings')
                        </a>
                        <ul class="collapse list-unstyled" id="subMenufrontEndSettings">
                            <li>
                                <a href="{{url('admin-home-page')}}"> @lang('lang.home_page') </a>
                            </li>
    
                            <li>
                                <a href="{{url('news')}}">@lang('lang.news_list')</a>
                            </li>
                            <li>
                                <a href="{{url('news-category')}}">@lang('lang.news') @lang('lang.category')</a>
                            </li>
                            <li>
                                <a href="{{url('testimonial')}}">@lang('lang.testimonial')</a>
                            </li>
                            <li>
                                <a href="{{url('course-list')}}">@lang('lang.course_list')</a>
                            </li>
                            <li>
                                <a href="{{url('contact-page')}}">@lang('lang.contact') @lang('lang.page') </a>
                            </li>
                            <li>
                                <a href="{{url('contact-message')}}">@lang('lang.contact') @lang('lang.message')</a>
                            </li>
                            <li>
                                <a href="{{url('about-page')}}"> @lang('lang.about_us') </a>
                            </li>
                            <li>
                                <a href="{{url('custom-links')}}"> @lang('lang.custom_links') </a>
                            </li>
                        </ul>
                    </li>
    
    
    <li>
    <a href="#Ticket" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
        <span class="flaticon-settings"></span>
        @lang('lang.ticket_system')
    </a>
    <ul class="collapse list-unstyled" id="Ticket">
        <li><a href="{{ url('ticket-category') }}"> @lang('lang.ticket_category')</a></li>
        <li><a href="{{ url('ticket-priority') }}">@lang('lang.ticket_priority')</a></li>
        <li><a href="{{ url('admin/ticket-view') }}">@lang('lang.ticket_list')</a>
        </li>
    </ul>
    </li>
    
    {{-- SAAS -302 --}}
    
    
    
    

       
        
        
        
        
            