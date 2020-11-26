<?php

namespace App\Http\Controllers;

use App\YearCheck;
use App\ApiBaseMethod;
use App\SmBookCategory;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;

class SmBookCategoryController extends Controller
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
        try{
            $bookCategories = SmBookCategory::where('school_id',Auth::user()->school_id)->get();
            return view('backEnd.library.bookCategoryList', compact('bookCategories'));
        }catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_name' => "required",
        ]);
        // school wise uquine validation
        $is_duplicate = SmBookCategory::where('school_id', Auth::user()->school_id)->where('category_name', $request->category_name)->first();
        if ($is_duplicate) {
            Toastr::error('Duplicate name found!', 'Failed');
            return redirect()->back()->withInput();
        }
        try{
            $categories = new SmBookCategory();
            $categories->category_name = $request->category_name;
            $categories->school_id = Auth::user()->school_id;
            $categories->academic_id = YearCheck::getAcademicId();
            $results = $categories->save();

            if ($results) {
                Toastr::success('Operation successful', 'Success');
                return redirect('book-category-list');
            } else {
                Toastr::error('Operation Failed', 'Failed');
                return redirect()->back();
            }
        }catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        try{
            $editData = SmBookCategory::find($id);
            $bookCategories = SmBookCategory::where('school_id',Auth::user()->school_id)->get();
            return view('backEnd.library.bookCategoryList', compact('bookCategories', 'editData'));
        }catch (\Exception $e) {
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
            'category_name' => "required",
        ]);
        // school wise uquine validation
        $is_duplicate = SmBookCategory::where('school_id', Auth::user()->school_id)->where('category_name', $request->category_name)->where('id', '!=', $request->id)->first();
        if ($is_duplicate) {
            Toastr::error('Duplicate name found!', 'Failed');
            return redirect()->back()->withInput();
        }
        try{
            $categories =  SmBookCategory::find($id);
            $categories->category_name = $request->category_name;
            $results = $categories->update();
            if ($results) {
                Toastr::success('Operation successful', 'Success');
                return redirect('book-category-list');
            } else {
                Toastr::error('Operation Failed', 'Failed');
                return redirect()->back();
            }
        }catch (\Exception $e) {
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

        $tables = \App\tableList::getTableList('book_category_id', $id);
        try {
            if ($tables==null) {
               $result = SmBookCategory::destroy($id);
                if ($result) {
                    Toastr::success('Operation successful', 'Success');
                    return redirect()->back();
                } else {
                    Toastr::error('Operation Failed', 'Failed');
                    return redirect()->back();
                }
            }else{
                 $msg = 'This data already used in  : ' . $tables . ' Please remove those data first';
                Toastr::error( $msg, 'Failed');
                return redirect()->back();
            }

        } catch (\Illuminate\Database\QueryException $e) {

            $msg = 'This data already used in  : ' . $tables . ' Please remove those data first';
            Toastr::error( $msg, 'Failed');
            return redirect()->back();
        }

    }

    public function deleteBookCategoryView(Request $request, $id)
    {


        try{
            $title = "Are you sure to detete this Book category?";
            $url = url('delete-book-category/' . $id);
            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                return ApiBaseMethod::sendResponse($id, null);
            }
            return view('backEnd.modal.delete', compact('id', 'title', 'url'));

        }catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }


    }

    public function deleteBookCategory($id)
    {

        $tables = \App\tableList::getTableList('book_category_id', $id);


        try {
            if ($tables==null) {
                $result = SmBookCategory::destroy($id);
                if ($result) {
                    Toastr::success('Operation successful', 'Success');
                    return redirect()->back();
                } else {
                    Toastr::error('Operation Failed', 'Failed');
                    return redirect()->back();
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

    }
}
