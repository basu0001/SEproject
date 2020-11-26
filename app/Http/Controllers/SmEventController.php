<?php

namespace App\Http\Controllers;

use App\User;
use App\SmEvent;
use App\SmStaff;
use App\SmStudent;
use App\SmParent;
use App\YearCheck;
use App\SmNotification;
use App\ApiBaseMethod;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class SmEventController extends Controller
{
    public function __construct()
	{
        $this->middleware('PM');
        // User::checkAuth();
	}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $events = SmEvent::where('school_id', Auth::user()->school_id)->where('academic_id', YearCheck::getAcademicId())->get();
            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                return ApiBaseMethod::sendResponse($events, null);
            }
            return view('backEnd.events.eventsList', compact('events'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'event_title' => "required",
            'for_whom' => "required",
            'from_date' => "required",
            'to_date' => "required",
            'event_des' => "required",
            'event_location' => 'required',
            'upload_file_name' => "sometimes|nullable|mimes:pdf,doc,docx,jpg,jpeg,png|max:10000",
        ]);

        if ($validator->fails()) {
            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                return ApiBaseMethod::sendError('Validation Error.', $validator->errors());
            }
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        try {
            $fileName = "";
            if ($request->file('upload_file_name') != "") {
                $file = $request->file('upload_file_name');
                $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
                $file->move('public/uploads/events/', $fileName);
                $fileName = 'public/uploads/events/' . $fileName;
            }
            $user = Auth()->user();

            if ($user) {
                $login_id = $user->id;
            } else {
                $login_id = $request->login_id;
            }

            $events = new SmEvent();
            $events->event_title = $request->event_title;
            $events->for_whom = $request->for_whom;
            $events->event_des = $request->event_des;
            $events->event_location = $request->event_location;
            $events->from_date = date('Y-m-d', strtotime($request->from_date));
            $events->to_date = date('Y-m-d', strtotime($request->to_date));
            $events->created_by = $login_id;
            $events->uplad_image_file = $fileName;
            $events->school_id = Auth::user()->school_id;
            $events->academic_id = YearCheck::getAcademicId();
            $results = $events->save();



            if ($request->for_whom == 'All') {

                $users = User::where('school_id', Auth::user()->school_id)->where('active_status', 1)->get();


                foreach ($users as $value) {

                    $notification = new SmNotification;
                    $notification->user_id = $value->id;
                    $notification->role_id = $value->role_id;
                    $notification->date = date('Y-m-d');
                    $notification->message = $request->event_title;
                    $notification->school_id = Auth::user()->school_id;
                    $notification->save();
                }
            } elseif ($request->for_whom == 'Teacher') {

                $users = User::where('school_id', Auth::user()->school_id)->where('active_status', 1)->where('role_id', 4)->get();


                foreach ($users as $value) {

                    $notification = new SmNotification;
                    $notification->user_id = $value->id;
                    $notification->role_id = $value->role_id;
                    $notification->date = date('Y-m-d');
                    $notification->message = $request->event_title;
                    $notification->school_id = Auth::user()->school_id;
                    $notification->save();
                }
            } elseif ($request->for_whom == 'Student') {

                $users = User::where('school_id', Auth::user()->school_id)->where('active_status', 1)->where('role_id', 2)->get();


                foreach ($users as $value) {

                    $notification = new SmNotification;
                    $notification->user_id = $value->id;
                    $notification->role_id = $value->role_id;
                    $notification->date = date('Y-m-d');
                    $notification->message = $request->event_title;
                    $notification->school_id = Auth::user()->school_id;
                    $notification->save();
                }
            } elseif ($request->for_whom == 'Parents') {

                $users = User::where('school_id', Auth::user()->school_id)->where('active_status', 1)->where('role_id', 3)->get();


                foreach ($users as $value) {

                    $notification = new SmNotification;
                    $notification->user_id = $value->id;
                    $notification->role_id = $value->role_id;
                    $notification->date = date('Y-m-d');
                    $notification->message = $request->event_title;
                    $notification->school_id = Auth::user()->school_id;
                    $notification->save();
                }
            }





            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                if ($results) {
                    return ApiBaseMethod::sendResponse(null, 'New Event has been added successfully');
                } else {
                    return ApiBaseMethod::sendError('Something went wrong, please try again.');
                }
            } else {
                if ($results) {
                    Toastr::success('Operation successful', 'Success');
                    return redirect()->back();
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

    public function edit(Request $request, $id)
    {
        try {
            $editData = SmEvent::find($id);
            $events = SmEvent::where('school_id', Auth::user()->school_id)->get();

            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                $data = [];
                $data['editData'] = $editData->toArray();
                $data['events'] = $events->toArray();
                return ApiBaseMethod::sendResponse($data, null);
            }
            return view('backEnd.events.eventsList', compact('editData', 'events'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'event_title' => "required",
            'for_whom' => "required",
            'from_date' => "required",
            'to_date' => "required",
            'event_des' => "required",
            'event_location' => "required",
            'upload_file_name' => "sometimes|nullable|mimes:pdf,doc,docx,jpg,jpeg,png|max:10000",

        ]);

        if ($validator->fails()) {
            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                return ApiBaseMethod::sendError('Validation Error.', $validator->errors());
            }
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        try {
            $fileName = "";
            if ($request->file('upload_file_name') != "") {
                $eventFile = SmEvent::find($id);
                if ($eventFile->uplad_image_file != "") {
                    unlink($eventFile->uplad_image_file);
                }

                $file = $request->file('upload_file_name');
                $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
                $file->move('public/uploads/events/', $fileName);
                $fileName = 'public/uploads/events/' . $fileName;
            }

            $user = Auth()->user();

            if ($user) {
                $login_id = $user->id;
            } else {
                $login_id = $request->login_id;
            }

            $events = SmEvent::find($id);
            $events->event_title = $request->event_title;
            $events->for_whom = $request->for_whom;
            $events->event_des = $request->event_des;
            $events->event_location = $request->event_location;
            $events->from_date = date('Y-m-d', strtotime($request->from_date));
            $events->to_date = date('Y-m-d', strtotime($request->to_date));
            $events->updated_by = $login_id;
            $events->uplad_image_file = $fileName;
            $results = $events->update();

            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                if ($results) {
                    return ApiBaseMethod::sendResponse(null, 'Event has been updated successfully');
                } else {
                    return ApiBaseMethod::sendError('Something went wrong, please try again.');
                }
            } else {
                if ($results) {
                    Toastr::success('Operation successful', 'Success');
                    return redirect('event');
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

    public function deleteEventView(Request $request, $id)
    {
        try {
            if (ApiBaseMethod::checkUrl($request->fullUrl())) {

                return ApiBaseMethod::sendResponse($id, null);
            }
            return view('backEnd.events.deleteEventView', compact('id'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function deleteEvent(Request $request, $id)
    {

        try {
            $result = SmEvent::destroy($id);

            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                if ($result) {
                    return ApiBaseMethod::sendResponse(null, 'Event has been deleted successfully');
                } else {
                    return ApiBaseMethod::sendError('Something went wrong, please try again.');
                }
            } else {
                if ($result) {
                    Toastr::success('Operation successful', 'Success');
                    return redirect('event');
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
}