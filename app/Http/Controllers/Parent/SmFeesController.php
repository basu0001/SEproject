<?php

namespace App\Http\Controllers\Parent;

use App\YearCheck;
use App\SmStudent;
use App\SmFeesAssign;
use App\SmFeesPayment;

use App\SmBankPaymentSlip;
use App\ApiBaseMethod;
use App\SmPaymentGatewaySetting;
use App\SmPaymentMethhod;
use App\SmFeesAssignDiscount;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class SmFeesController extends Controller
{
    public function __construct()
	{
        $this->middleware('PM');
        // User::checkAuth();
    }

    public function childrenFees($id)
    {

        try{
            $student = SmStudent::where('id', $id)->first();
            $fees_assigneds = SmFeesAssign::where('student_id', $student->id)->where('academic_id', YearCheck::getAcademicId())->where('school_id',Auth::user()->school_id)->get();
            $fees_discounts = SmFeesAssignDiscount::where('student_id', $student->id)->where('academic_id', YearCheck::getAcademicId())->where('school_id',Auth::user()->school_id)->get();

            $applied_discount = [];
            foreach ($fees_discounts as $fees_discount) {
                $fees_payment = SmFeesPayment::select('fees_discount_id')->where('fees_discount_id', $fees_discount->id)->where('academic_id', YearCheck::getAcademicId())->first();
                if (isset($fees_payment->fees_discount_id)) {
                    $applied_discount[] = $fees_payment->fees_discount_id;
                }
            }
            $stripe_info = SmPaymentGatewaySetting::where('gateway_name', 'stripe')->where('school_id', Auth::user()->school_id)->first();

            $data['bank_info'] = SmPaymentMethhod::where('method', 'Bank')->where('school_id', Auth::user()->school_id)->first();
            $data['cheque_info'] = SmPaymentMethhod::where('method', 'Cheque')->where('school_id', Auth::user()->school_id)->first();

            return view('backEnd.parentPanel.childrenFees', compact('student', 'fees_assigneds', 'fees_discounts', 'applied_discount', 'stripe_info','data'));
        }catch (\Exception $e) {
           Toastr::error('Operation Failed', 'Failed');
           return redirect()->back();
        }
    }

    public function childBankSlipStore(Request $request){

        try{

            $fileName = "";
            if ($request->file('slip') != "") {
                $file = $request->file('slip');
                $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
                $file->move('public/uploads/bankSlip/', $fileName);
                $fileName = 'public/uploads/bankSlip/' . $fileName;
            }

            $date = strtotime($request->date);

            $newformat = date('Y-m-d', $date);

            $payment = new SmBankPaymentSlip();
            $payment->date = $newformat;
            $payment->amount = $request->amount;
            $payment->note = $request->note;
            $payment->slip = $fileName;
            $payment->fees_type_id = $request->fees_type_id;
            $payment->student_id = $request->student_id;
            $payment->payment_mode = $request->payment_mode;
            $payment->school_id = Auth::user()->school_id;
            $payment->academic_id = YearCheck::getAcademicId();
            $payment->save();

            Toastr::success('Operation successful', 'Success');
            return redirect()->back();


        }catch (\Exception $e) {
           Toastr::error('Operation Failed', 'Failed');
           return redirect()->back(); 
        }
        
    }


    public function feesGenerateModalChildView($id){

        $fees_payment = SmBankPaymentSlip::find($id);
        return view('backEnd.feesCollection.view_bank_payment', compact('fees_payment'));
    }

    public function feesGenerateModalChildEdit(Request $request , $amount, $student_id, $type, $id){

        try {

            $amount = $amount;
            $fees_type_id = $type;
            $student_id = $student_id;
            $discounts = SmFeesAssignDiscount::where('student_id', $student_id)->where('school_id',Auth::user()->school_id)->get();

            $applied_discount = [];
            foreach ($discounts as $fees_discount) {
                $fees_payment = SmFeesPayment::select('fees_discount_id')->where('fees_discount_id', $fees_discount->id)->where('school_id',Auth::user()->school_id)->first();
                if (isset($fees_payment->fees_discount_id)) {
                    $applied_discount[] = $fees_payment->fees_discount_id;
                }
            }

            $fees_payment = SmBankPaymentSlip::find($id);


            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                $data = [];
                $data['amount'] = $amount;
                $data['discounts'] = $discounts;
                $data['fees_type_id'] = $fees_type_id;
                $data['student_id'] = $student_id;
                $data['applied_discount'] = $applied_discount;
                return ApiBaseMethod::sendResponse($data, null);
            }


            return view('backEnd.feesCollection.fees_generate_modal_child', compact('amount', 'discounts', 'fees_type_id', 'student_id', 'applied_discount', 'fees_payment'));

        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }

    }
    public function childBankSlipUpdate(Request $request){

        try{


            $fileName = "";
            if ($request->file('slip') != "") {
                
                $visitor = SmBankPaymentSlip::find($request->id);

                if ($visitor->file != "") {
                    $path = url('/') . $visitor->slip;
                    if (file_exists($path)) {
                        unlink($path);
                    }
                }
    
                $file = $request->file('slip');
                $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
                $file->move('public/uploads/bankSlip/', $fileName);
                $fileName = 'public/uploads/bankSlip/' . $fileName;
            }

            $date = strtotime($request->date);

            $newformat = date('Y-m-d', $date);

            $payment = SmBankPaymentSlip::find($request->id);
            $payment->date = $newformat;
            $payment->amount = $request->amount;
            $payment->note = $request->note;
            if($fileName != ""){
                $payment->slip = $fileName;
            }
            
            $payment->payment_mode = $request->payment_mode;
            $payment->save();

            Toastr::success('Operation successful', 'Success');
            return redirect()->back();


        }catch (\Exception $e) {
           Toastr::error('Operation Failed', 'Failed');
           return redirect()->back(); 
        }
        
    }

    public function childBankSlipDelete(Request $request)
    {

    try{
            $visitor = SmBankPaymentSlip::find($request->id);
            if ($visitor->file != "") {
                $path = url('/') . $visitor->slip;
                if (file_exists($path)) {
                    unlink($path);
                }
            }
            $result = $visitor->delete();

            Toastr::success('Operation successful', 'Success');
            return redirect()->back();
    
            
        }catch (\Exception $e) {
           Toastr::error('Operation Failed', 'Failed');
           return redirect()->back(); 
        }
    }

    
}
