<?php

namespace App\Http\Controllers;

use Auth;
use App\SmClass;
use App\SmStudent;
use App\YearCheck;
use Illuminate\Http\Request;
use App\SmStudentCertificate;
use Barryvdh\DomPDF\Facade as PDF;
use Brian2694\Toastr\Facades\Toastr;


class SmStudentCertificateController extends Controller
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
    public function index()
    {

        try {
            $certificates = SmStudentCertificate::where('active_status', 1)->where('school_id',Auth::user()->school_id)->get();
            return view('backEnd.admin.student_certificate', compact('certificates'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => "required|max:50",
            'file' => "required|mimes:pdf,doc,docx,jpg,jpeg,png|dimensions:width=1100,height=850"

        ]);



        try {
            $fileName = "";
            if ($request->file('file') != "") {
                $file = $request->file('file');
                $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
                $file->move('public/uploads/certificate/', $fileName);
                $fileName = 'public/uploads/certificate/' . $fileName;
            }

            $certificate = new SmStudentCertificate();
            $certificate->name = $request->name;
            $certificate->header_left_text = $request->header_left_text;
            $certificate->date = date('Y-m-d', strtotime($request->date));
            $certificate->body = $request->body;
            $certificate->footer_left_text = $request->footer_left_text;
            $certificate->footer_center_text = $request->footer_center_text;
            $certificate->footer_right_text = $request->footer_right_text;
            $certificate->student_photo = $request->student_photo;
            $certificate->file = $fileName;
            $certificate->school_id = Auth::user()->school_id;
            $certificate->academic_id = YearCheck::getAcademicId();

            $result = $certificate->save();
            if ($result) {
                Toastr::success('Operation successful', 'Success');

                return redirect()->back();
            } else {
                Toastr::error('Operation Failed', 'Failed');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function edit($id)
    {

        try {
            $certificate = SmStudentCertificate::find($id);
            $certificates = SmStudentCertificate::where('active_status', 1)->where('school_id',Auth::user()->school_id)->get();
            return view('backEnd.admin.student_certificate', compact('certificates', 'certificate'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => "required|max:50"
        ]);


        try {
            $fileName = "";
            if ($request->file('file') != "") {
                $certificate = SmStudentCertificate::find($request->id);
                if ($certificate->file != "") {
                    unlink($certificate->file);
                }


                $file = $request->file('file');
                $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
                $file->move('public/uploads/certificate/', $fileName);
                $fileName = 'public/uploads/certificate/' . $fileName;
            }

            $certificate = SmStudentCertificate::find($request->id);
            $certificate->name = $request->name;
            $certificate->header_left_text = $request->header_left_text;
            $certificate->date = date('Y-m-d', strtotime($request->date));
            $certificate->body = $request->body;
            $certificate->footer_left_text = $request->footer_left_text;
            $certificate->footer_center_text = $request->footer_center_text;
            $certificate->footer_right_text = $request->footer_right_text;
            $certificate->student_photo = $request->student_photo;
            if ($fileName != "") {
                $certificate->file = $fileName;
            }

            $result = $certificate->save();
            if ($result) {
                Toastr::success('Operation successful', 'Success');

                return redirect('student-certificate');
            } else {
                Toastr::error('Operation Failed', 'Failed');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        try {
            $certificate = SmStudentCertificate::find($id);
            unlink($certificate->file);
            $result = $certificate->delete();

            if ($result) {
                Toastr::success('Operation successful', 'Success');

                return redirect('student-certificate');
            } else {
                Toastr::error('Operation Failed', 'Failed');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }


    // for get route
    public function generateCertificate()
    {

        try {
            $classes = SmClass::where('active_status', 1)->where('academic_id', YearCheck::getAcademicId())->where('school_id',Auth::user()->school_id)->get();
            $certificates = SmStudentCertificate::where('active_status', 1)->where('school_id',Auth::user()->school_id)->get();
            return view('backEnd.admin.generate_certificate', compact('classes', 'certificates'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    // for post route
    public function generateCertificateSearch(Request $request)
    {
        $request->validate([
            'class' => 'required',
            'certificate' => 'required'
        ]);

        try {
            $certificate_id = $request->certificate;
            $class_id = $request->class;
            $students = SmStudent::query();
            $students->where('active_status', 1);
            $students->where('class_id', $request->class);

            if ($request->section != "") {
                $students->where('section_id', $request->section);
            }

            $students = $students->where('academic_id', YearCheck::getAcademicId())->where('school_id',Auth::user()->school_id)->get();

            $classes = SmClass::where('active_status', 1)->where('academic_id', YearCheck::getAcademicId())->where('school_id',Auth::user()->school_id)->get();
            $certificates = SmStudentCertificate::where('active_status', 1)->where('school_id',Auth::user()->school_id)->get();
            return view('backEnd.admin.generate_certificate', compact('classes', 'certificates', 'certificate_id', 'certificates', 'students', 'class_id'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function generateCertificateGenerate($s_id, $c_id)
    {

        try {
            $s_ids = explode('-', $s_id);
            $students = [];
            foreach ($s_ids as $sId) {
                $students[] = SmStudent::find($sId);
            }

            $certificate = SmStudentCertificate::find($c_id);

            // return view('backEnd.admin.student_certificate_print', ['students' => $students, 'certificate' => $certificate]);
            $pdf = PDF::loadView('backEnd.admin.student_certificate_print', ['students' => $students, 'certificate' => $certificate]);
            $pdf->setPaper('A4', 'landscape');
            return $pdf->stream('certificate.pdf');
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
}