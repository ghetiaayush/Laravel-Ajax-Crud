<?php

namespace App\Http\Controllers;
use App\Product;
use Illuminate\Http\Request;
use DataTables;

class ProductFilterController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Product::select('*');
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('status', function($row){
                         if($row->status){
                            return '<span class="badge badge-warning">Active</span>';
                         }else{
                            return '<span class="badge badge-dark">Deactive</span>';
                         }
                    })
                    ->filter(function ($instance) use ($request) {
                        if ($request->get('status') == '0' || $request->get('status') == '1') {
                            $instance->where('status', $request->get('status'));
                        }
                        if (!empty($request->get('search'))) {
                             $instance->where(function($w) use($request){
                                $search = $request->get('search');
                                $w->orWhere('name', 'LIKE', "%$search%")
                                ->orWhere('detail', 'LIKE', "%$search%")
                                ->orWhere('sku', 'LIKE', "%$search%")
                                ->orWhere('price', 'LIKE', "%$search%")
                                ->orWhere('category', 'LIKE', "%$search%")
                                ->orWhere('status', 'LIKE', "%$search%");
                            });
                        }
                    })
                    ->rawColumns(['status'])
                    ->make(true);
        }
        return view('filterAjax');
    }
}
