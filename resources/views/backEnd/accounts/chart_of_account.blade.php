@extends('backEnd.master')
@section('mainContent')
<section class="sms-breadcrumb mb-40 white-box">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1>@lang('lang.chart_of_account')</h1>
            <div class="bc-pages">
                <a href="{{url('dashboard')}}">@lang('lang.dashboard')</a>
                <a href="#">@lang('lang.accounts')</a>
                <a href="#">@lang('lang.chart_of_account')</a>
            </div>
        </div>
    </div>
</section>
<section class="admin-visitor-area up_st_admin_visitor">
    <div class="container-fluid p-0">
        @if(isset($chart_of_account))
         @if(in_array(149, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1 )

        <div class="row">
            <div class="offset-lg-10 col-lg-2 text-right col-md-12 mb-20">
                <a href="{{url('chart-of-account')}}" class="primary-btn small fix-gr-bg">
                    <span class="ti-plus pr-2"></span>
                    @lang('lang.add')
                </a>
            </div>
        </div>
        @endif
        @endif
        <div class="row">


            <div class="col-lg-3">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="main-title">
                            <h3 class="mb-30">@if(isset($chart_of_account))
                                    @lang('lang.edit')
                                @else
                                    @lang('lang.add')
                                @endif
                                @lang('lang.chart_of_account')
                            </h3>
                        </div>
                        @if(isset($chart_of_account))
                        {{ Form::open(['class' => 'form-horizontal', 'files' => true,  'url' => 'chart-of-account/'.@$chart_of_account->id, 'method' => 'PUT', 'enctype' => 'multipart/form-data']) }}
                        @else
                          @if(in_array(149, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1 )
                        {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'url' => 'chart-of-account',
                        'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
                        @endif
                        @endif
                        <div class="white-box">
                            <div class="add-visitor">
                                <div class="row">

                                    <div class="col-lg-12">
                                        @if(session()->has('message-success'))
                                        <div class="alert alert-success">
                                            {{ session()->get('message-success') }}
                                        </div>
                                        @elseif(session()->has('message-danger'))
                                        <div class="alert alert-danger">
                                            {{ session()->get('message-danger') }}
                                        </div>
                                        @endif
                                        <div class="input-effect">
                                            <input class="primary-input form-control{{ @$errors->has('head') ? ' is-invalid' : '' }}"
                                                type="text" name="head" autocomplete="off" value="{{isset($chart_of_account)? $chart_of_account->head: old('head')}}">
                                            <input type="hidden" name="id" value="{{isset($chart_of_account)? $chart_of_account->id: ''}}">
                                            <label>@lang('lang.head') <span>*</span></label>
                                            <span class="focus-border"></span>
                                            @if ($errors->has('head'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ @$errors->first('head') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row  mt-40">
                                    <div class="col-lg-12">
                                        <select class="niceSelect w-100 bb form-control{{ @$errors->has('type') ? ' is-invalid' : '' }}" name="type">
                                            <option data-display="@lang('lang.type') " value="">@lang('lang.type') </option>
                                            <option value="A" {{@$chart_of_account->type == 'A'? 'selected':old('type') == ('A'? 'selected':'') }}>@lang('lang.asset')</option>
                                            <option value="E" {{@$chart_of_account->type == 'E'? 'selected':old('type') == ('E'? 'selected':'') }}>@lang('lang.expense')</option>
                                            <option value="I" {{@$chart_of_account->type == 'I'? 'selected':old('type') == ('I'? 'selected':'' )}}>@lang('lang.income')</option>
                                            <option value="L" {{@$chart_of_account->type == 'L'? 'selected':old('type') == ('L'? 'selected':'') }}>@lang('lang.liability')</option>
                                        </select>

                                         
                                        @if ($errors->has('type'))
                                        <span class="invalid-feedback invalid-select" role="alert">
                                            <strong>{{ @$errors->first('type') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            	@php
                                  $tooltip = "";
                                  if(in_array(149, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1 ){
                                        $tooltip = "";
                                    }else{
                                        $tooltip = "You have no permission to add";
                                    }
                                @endphp
                                <div class="row mt-40">
                                    <div class="col-lg-12 text-center">
                                       <button class="primary-btn fix-gr-bg" data-toggle="tooltip" title="{{$tooltip}}">
                                            <span class="ti-check"></span>
                                            @if(isset($chart_of_account))
                                                @lang('lang.update')
                                            @else
                                                @lang('lang.save')
                                            @endif
                                            @lang('lang.head')
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>

            <div class="col-lg-9">
                <div class="row">
                    <div class="col-lg-4 no-gutters">
                        <div class="main-title">
                            <h3 class="mb-0">@lang('lang.chart_of_account') @lang('lang.list')</h3>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">

                        <table id="table_id" class="display school-table" cellspacing="0" width="100%">

                            <thead>
                                @if(session()->has('message-success-delete') != "" ||
                                session()->get('message-danger-delete') != "")
                                <tr>
                                    <td colspan="3">
                                        @if(session()->has('message-success-delete'))
                                        <div class="alert alert-success">
                                            {{ session()->get('message-success-delete') }}
                                        </div>
                                        @elseif(session()->has('message-danger-delete'))
                                        <div class="alert alert-danger">
                                            {{ session()->get('message-danger-delete') }}
                                        </div>
                                        @endif
                                    </td>
                                </tr>
                                @endif
                                <tr>
                                    <th>@lang('lang.name')</th>
                                    <th>@lang('lang.type')</th>
                                    <th>@lang('lang.action')</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($chart_of_accounts as $chart_of_account)
                                <tr>
                                    <td>{{@$chart_of_account->head}}</td>
                                            {{-- <option value="A" {{@$chart_of_account->type == 'A'? 'selected':old('type') == 'A'? 'selected':'' }}>@lang('lang.asset')</option>
                                            <option value="E" {{@$chart_of_account->type == 'E'? 'selected':old('type') == 'E'? 'selected':'' }}>@lang('lang.expense')</option>
                                            <option value="I" {{@$chart_of_account->type == 'I'? 'selected':old('type') == 'I'? 'selected':'' }}>@lang('lang.income')</option>
                                            <option value="L" {{@$chart_of_account->type == 'L'? 'selected':old('type') == 'L'? 'selected':'' }}>@lang('lang.liability')</option> --}}
                                    <td>
                                        @if($chart_of_account->type=="A")@lang('lang.asset') @endif
                                        @if($chart_of_account->type=="E")@lang('lang.expense') @endif
                                        @if($chart_of_account->type=="I")@lang('lang.income') @endif
                                        @if($chart_of_account->type=="L")@lang('lang.liability') @endif

                                        {{-- {{@$chart_of_account->type == "I"? 'Income':'Expense'}} --}}
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn dropdown-toggle" data-toggle="dropdown">
                                                @lang('lang.select')
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right">
                                               @if(in_array(150, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1 )

                                                <a class="dropdown-item" href="{{url('chart-of-account', [@$chart_of_account->id])}}">@lang('lang.edit')</a>
                                               @endif
                                               @if(in_array(151, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1 )

                                                <a class="dropdown-item" data-toggle="modal" data-target="#deleteChartOfAccountModal{{@$chart_of_account->id}}"
                                                    href="#">@lang('lang.delete')</a>
                                           @endif
                                                </div>
                                        </div>
                                    </td>
                                </tr>
                                <div class="modal fade admin-query" id="deleteChartOfAccountModal{{@$chart_of_account->id}}" >
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">@lang('lang.delete') @lang('lang.chart_of_account')</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>

                                            <div class="modal-body">
                                                <div class="text-center">
                                                    <h4>@lang('lang.are_you_sure_to_delete')</h4>
                                                </div>

                                                <div class="mt-40 d-flex justify-content-between">
                                                    <button type="button" class="primary-btn tr-bg" data-dismiss="modal">@lang('lang.cancel')</button>
                                                     {{ Form::open(['url' => 'chart-of-account/'.@$chart_of_account->id, 'method' => 'DELETE', 'enctype' => 'multipart/form-data']) }}
                                                    <button class="primary-btn fix-gr-bg" type="submit">@lang('lang.delete')</button>
                                                     {{ Form::close() }}
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
