<?php

namespace App\Http\Controllers;

use App\SmStyle;
use App\YearCheck;
use App\SmBackgroundSetting;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;

class SmBackgroundController extends Controller
{
    public function __construct()
	{
        $this->middleware('PM');
        // User::checkAuth();
	}
    public function index()
    {
        try{
            $background_settings = SmBackgroundSetting::where('school_id',Auth::user()->school_id)->get();
            return view('backEnd.systemSettings.background_setting', compact('background_settings'));
        }catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }


    public function backgroundSettingsStore(Request $request)
    {
        // dd($request->input());

        $request->validate([
            'background_type' => 'required'
        ]);

        if ($request->background_type == 'color') {
            $request->validate([
                'color' => 'required'
            ]);
        } else {
            $request->validate([
                'image' => 'required'
            ]);
        }

       try{
            $fileName = "";
            if ($request->file('image') != "") {
                $file = $request->file('image');
                $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
                $file->move('public/uploads/backgroundImage/', $fileName);
                $fileName = 'public/uploads/backgroundImage/' . $fileName;
            }

            if ($request->style == 1) {
                $title = 'Dashboard Background';
            } else {
                $title = 'Login Background';
            }

            $background_setting = new SmBackgroundSetting();
            $background_setting->is_default = 0;
            $background_setting->title = $title;
            $background_setting->type = $request->background_type;
            $background_setting->school_id = Auth::user()->school_id;
            if ($request->background_type == 'color') {
                $background_setting->color = $request->color;
            } else {
                $background_setting->image = $fileName;
            }
            $result = $background_setting->save();


            if ($result) {
                Toastr::success('Operation successful', 'Success');
                return redirect()->back();
            } else {
                Toastr::error('Operation Failed', 'Failed');
                return redirect()->back();
            }
        }catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }


    public function backgroundSettingsStatus($id)
    {
        try{
            $background = SmBackgroundSetting::find($id);
            if ($background->is_default == 1 && $background->title == "Login Background") {
                SmBackgroundSetting::where([['is_default', 1], ['title', 'Login Background']])->where('school_id',Auth::user()->school_id)->update(['is_default' => 0]);
                $result = SmBackgroundSetting::where('id', $id)->update(['is_default' => 1]);
            } else if ($background->is_default == 1 && $background->title == "Dashboard Background") {
                SmBackgroundSetting::where([['is_default', 1], ['title', 'Dashboard Background']])->where('school_id',Auth::user()->school_id)->update(['is_default' => 0]);
                $result = SmBackgroundSetting::where('id', $id)->update(['is_default' => 1]);
            } else if ($background->is_default == 0 && $background->title == "Login Background") {
                SmBackgroundSetting::where([['is_default', 1], ['title', 'Login Background']])->where('school_id',Auth::user()->school_id)->update(['is_default' => 0]);
                $result = SmBackgroundSetting::where('id', $id)->update(['is_default' => 1]);
            } else if ($background->is_default == 0 && $background->title == "Dashboard Background") {
                SmBackgroundSetting::where([['is_default', 1], ['title', 'Dashboard Background']])->where('school_id',Auth::user()->school_id)->update(['is_default' => 0]);
                $result = SmBackgroundSetting::where('id', $id)->update(['is_default' => 1]);
            }
            if ($result) {
                Toastr::success('Operation successful', 'Success');
                return redirect()->back();
            } else {
                Toastr::error('Operation Failed', 'Failed');
                return redirect()->back();
            }
        }catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }


    public function backgroundSettingsUpdate(Request $request)
    {
        $request->validate([
            'type' => 'required'
        ]);

        if ($request->type == 'color') {
            $request->validate([
                'color' => 'required'
            ]);
        } else {
            $request->validate([
                'image' => 'required'
            ]);
        }

        try{
            $fileName = "";
            if ($request->file('image') != "") {
                $file = $request->file('image');
                $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
                $file->move('public/uploads/backgroundImage/', $fileName);
                $fileName = 'public/uploads/backgroundImage/' . $fileName;
            }


            $background_setting = SmBackgroundSetting::find(1);
            $background_setting->type = $request->type;
            if ($request->type == 'color') {
                $background_setting->color = $request->color;
                $background_setting->image = '';
                if ($background_setting->image != "" && file_exists($background_setting->image)) {
                    unlink($background_setting->image);
                }
            } else {
                $background_setting->color = '';
                $background_setting->image = $fileName;
            }

            $result = $background_setting->save();


            if ($result) {
                Toastr::success('Operation successful', 'Success');
                return redirect()->back();
            } else {
                Toastr::error('Operation Failed', 'Failed');
                return redirect()->back();
            }
        }catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function backgroundSettingsDelete($id)
    {
        try{
            $result = SmBackgroundSetting::find($id)->delete();
            if ($result) {
                Toastr::success('Operation successful', 'Success');
                return redirect()->back();
            } else {
                Toastr::error('Operation Failed', 'Failed');
                return redirect()->back();
            }
        }catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }


    public function colorTheme()
    {
        try{
            $color_styles = SmStyle::where('school_id',Auth::user()->school_id)->get();
            return view('backEnd.systemSettings.color_theme', compact('color_styles'));
        }catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function colorThemeSet($id)
    {
        try{
            $background = SmStyle::find($id);
            SmStyle::where('is_active', 1)->where('school_id',Auth::user()->school_id)->update(['is_active' => 0]);
            $result = SmStyle::where('id', $id)->update(['is_active' => 1]);
            if ($result) {
                Toastr::success('Operation successful', 'Success');
                return redirect()->back();
            } else {
                Toastr::error('Operation Failed', 'Failed');
                return redirect()->back();
            }
        }catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
}
