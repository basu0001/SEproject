<?php

namespace App\Http\Controllers;

use App\SmSection;
use App\tableList;
use App\YearCheck;
use App\ApiBaseMethod;
use App\SmAcademicYear;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SmSectionController extends Controller
{
    public function __construct()
	{
        $this->middleware('PM');
        // User::checkAuth();
	}

    public function index(Request $request)
    {
        
// return YearCheck::getAcademicId();
        try {
            $sections = SmSection::where('active_status', '=', 1)->where('academic_id', YearCheck::getAcademicId())->where('school_id', Auth::user()->school_id)->get();
            // return $sections;
            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                return ApiBaseMethod::sendResponse($sections, null);
            }
            return view('backEnd.academics.section', compact('sections'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
    public function store(Request $request)
    {
        if (YearCheck::getAcademicId()=='') {
            Toastr::warning('Please setup academic year', 'Warning');
            return redirect()->back();
        } 
        $academic_year=SmAcademicYear::where('school_id',Auth::user()->school_id)->first();
        if ($academic_year==null) {
            Toastr::warning('Create academic year first', 'Warning');
            return redirect()->back();
        }

        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => "required|max:200"
        ]);
        $is_duplicate = SmSection::where('school_id', Auth::user()->school_id)->where('section_name', $request->name)->first();
        if ($is_duplicate) {
            Toastr::error('Duplicate section name found!', 'Failed');
            return redirect()->back()->withErrors($validator)->withInput();
        }



        if ($validator->fails()) {
            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                return ApiBaseMethod::sendError('Validation Error.', $validator->errors());
            }
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        try {
            $section = new SmSection();
            $section->section_name = $request->name;
            $section->created_at = YearCheck::getYear() . '-' . date('m-d h:i:s');
            $section->school_id = Auth::user()->school_id;
            $section->academic_id = YearCheck::getAcademicId();
            $result = $section->save();

            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                if ($result) {
                    return ApiBaseMethod::sendResponse(null, 'Section has been created successfully');
                } else {
                    return ApiBaseMethod::sendError('Something went wrong, please try again.');
                }
            } else {
                if ($result) {
                    Toastr::success('Operation successful', 'Success');
                    return redirect()->back();
                }
            }
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
    public function edit(Request $request, $id)
    {

        try {
            $section = SmSection::find($id);
            $sections = SmSection::where('active_status', '=', 1)->orderBy('id', 'desc')->where('academic_id', YearCheck::getAcademicId())->where('school_id', Auth::user()->school_id)->get();

            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                $data = [];
                $data['section'] = $section->toArray();
                $data['sections'] = $sections->toArray();
                return ApiBaseMethod::sendResponse($data, null);
            }

            return view('backEnd.academics.section', compact('section', 'sections'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
    public function update(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => "required|max:200|unique:sm_sections,section_name," . $request->id
        ]);

        $is_duplicate = SmSection::where('school_id', Auth::user()->school_id)->where('section_name', $request->name)->where('id','!=', $request->id)->first();
        if ($is_duplicate) {
            Toastr::error('Duplicate section name found!', 'Failed');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if ($validator->fails()) {
            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                return ApiBaseMethod::sendError('Validation Error.', $validator->errors());
            }
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $section = SmSection::find($request->id);
            $section->section_name = $request->name;
            $result = $section->save();

            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                if ($result) {
                    return ApiBaseMethod::sendResponse(null, 'Section has been updated successfully');
                } else {
                    return ApiBaseMethod::sendError('Something went wrong, please try again.');
                }
            } else {
                if ($result) {
                    Toastr::success('Operation successful', 'Success');

                    return redirect('section');
                } else {
                    Toastr::error('Operation Failed', 'Failed');
                    return redirect()->back();
                }
            }
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
    public function delete(Request $request, $id)
    {
        try {
            $tables = tableList::getTableList('section_id', $id);
            try {
                if ($tables == null) {
                    $delete_query = $section = SmSection::destroy($request->id);

                    if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                        if ($section) {
                            return ApiBaseMethod::sendResponse(null, 'Section has been deleted successfully');
                        } else {
                            return ApiBaseMethod::sendError('Something went wrong, please try again.');
                        }
                    } else {
                        if ($delete_query) {
                            Toastr::success('Operation successful', 'Success');
                            return redirect('section');
                        } else {
                            Toastr::error('Operation Failed', 'Failed');
                            return redirect()->back();
                        }
                    }
                } else {
                    $msg = 'This data already used in  : ' . $tables . ' Please remove those data first';
                    Toastr::error($msg, 'Failed');
                    return redirect()->back();
                }
            } catch (\Illuminate\Database\QueryException $e) {

                $msg = 'This data already used in  : ' . $tables . ' Please remove those data first';
                Toastr::error($msg, 'Failed');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
}