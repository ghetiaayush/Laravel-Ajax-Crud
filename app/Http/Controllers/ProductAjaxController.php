<?php

namespace App\Http\Controllers;
use App\Product;
use App\Category;
use Illuminate\Http\Request;
use DataTables;

class ProductAjaxController extends Controller
{
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $data = Product::latest()->get();
            return Datatables::of($data)->addIndexColumn()->addColumn('action', function($row){
            $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-link btn-sm editProduct">Edit</a>';
            $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-link btn-sm deleteProduct">Delete</a>';
            return $btn;})->addColumn('status', function($row){
            if($row->status){return '<span class="badge badge-info">Active</span>';}
            else{return '<span class="badge badge-dark">Deactive</span>';}})->rawColumns(['action','status'])->make(true);
        }
        $categories = Category::all();
        return view('productAjax', compact('categories'));
    }

    public function store(Request $request)
    {
        //dd($request->all());
          $product =   Product::firstOrNew(
            ['id' => $request->product_id]);
            $product->name = $request->name;
            $product->detail = $request->detail;
            $product->sku = $request->sku;
            $product->price= $request->price;
            $product->status= $request->status;
            $product->category= $request->category;
            $product->save();

            return response()->json(['success'=>'Product saved successfully.']);
    }

    public function edit($id)
    {

        $product = Product::find($id);
        return response()->json($product);
    }

    public function destroy($id)
    {
        Product::find($id)->delete();
        return response()->json(['success'=>'Product deleted successfully.']);
    }
}
