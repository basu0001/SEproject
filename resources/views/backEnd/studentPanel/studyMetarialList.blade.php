@extends('backEnd.master')
@section('mainContent')
@php
function showPicName($data){
$name = explode('/', $data);
return $name[3];
}
@endphp
<section class="sms-breadcrumb mb-40 white-box">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1>@lang('lang.study_material') @lang('lang.list') </h1>
            <div class="bc-pages">
                <a href="{{url('dashboard')}}">@lang('lang.dashboard')</a>
                <a href="#">@lang('lang.teacher')</a>
                <a href="#">@lang('lang.study_material') @lang('lang.list')</a>
            </div>
        </div>
    </div>
</section>

<section class="admin-visitor-area">
    <div class="container-fluid p-0">

<div class="row">
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-4 no-gutters">
                <div class="main-title">
                    <h3 class="mb-0">@lang('lang.study_material') @lang('lang.list')</h3>
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
                            <td colspan="6">
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
                            <th>@lang('lang.content_title') </th>
                            <th>@lang('lang.date')</th>
                            <th>@lang('lang.available_for')</th>
                            <th>@lang('lang.class_Sec')</th>
                            <th>@lang('lang.action')</th>
                        </tr>
                    </thead>

                    <tbody>
                        @if(isset($uploadContents))
                        @foreach($uploadContents as $value)
                        <tr>

                            <td>{{@$value->content_title}}</td>
                            <td  data-sort="{{strtotime(@$value->upload_date)}}" >
                               {{@$value->upload_date != ""? App\SmGeneralSettings::DateConvater(@$value->upload_date):''}}

                            </td>
                            <td>
                                @if(@$value->available_for_admin == 1)
                                    {{'All admin'}}<br>
                                @endif
                                @if(@$value->available_for_all_classes == 1)
                                    {{'All classes student'}}
                                @endif
                            </td>
                            <td>

                            @if($value->class != "")
                                {{@$value->classes->class_name}}
                            @endif 

                            @if(@$value->section != "")
                                ({{@$value->sections->section_name}})
                            @endif


                            </td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn dropdown-toggle" data-toggle="dropdown">
                                        @lang('lang.select')
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        @if(@$value->upload_file != "")
                                            @if(@in_array(30, App\GlobalVariable::GlobarModuleLinks()))
                                            <a class="dropdown-item" href="{{url('upload-content-document/'.showPicName(@$value->upload_file))}}">
                                                @lang('lang.download') <span class="pl ti-download"></span></a>
                                            
                                            @endif
                                        @endif
                                    </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</section>
@endsection
