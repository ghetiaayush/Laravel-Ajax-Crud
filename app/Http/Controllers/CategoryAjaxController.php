<?php

namespace App\Http\Controllers;
use App\Category;
use Illuminate\Http\Request;
use DataTables;

class CategoryAjaxController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Category::latest()->get();
            return Datatables::of($data)->addIndexColumn()->addColumn('action', function($row){
            $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-link btn-sm editProduct">Edit</a>';
            $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-link btn-sm deleteProduct">Delete</a>';
            return $btn;})->addColumn('status', function($row){
            if($row->status){return '<span class="badge badge-primary">Active</span>';}
            else{return '<span class="badge badge-danger">Deactive</span>';}})->rawColumns(['action','status'])->make(true);
        }return view('categoryAjax');
    }

    public function store(Request $request)
    {
            $category = Category::firstOrNew(['id' => $request->id]);
            $category->name = $request->name;
            $category->status = $request->status;
            $category->save();
            return response()->json(['success'=>'Category saved successfully.']);
    }

    public function edit($id)
    {
        $product = Category::find($id);
        return response()->json($product);
    }

    public function destroy($id)
    {
        Category::find($id)->delete();
        return response()->json(['success'=>'Category deleted successfully.']);
    }
}
