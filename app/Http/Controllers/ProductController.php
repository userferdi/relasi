<?php

namespace App\Http\Controllers;

use App\Product;
use App\Category;
use App\Brand;
use App\Details;
use DataTables;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        // dd($model);
        return view('product.index');
    }

    public function create()
    {
        $model = new Product;
        $model['category'] = Category::all()->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE)->pluck('name', 'id');
        $model['brand'] = Brand::all()->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE)->pluck('name', 'id');
        return view('product.form', ['model' => $model]);
    }

    public function store(Request $request)
    {
        $model['category'] = Category::select($request->category_id);
        $model['brand'] = Brand::select($request->brand_id);
        $this->validate($request, [
            'name' => 'required',
            'price' => 'required',
            'image' => 'required',
            'category_id' => 'required',
            'brand_id' => 'required'
        ]);
        $model = Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'image' => $request->image,
            'category_id' => $request->category,
            'brand_id' => $request->brand
        ]);
        return response()->json($model);
    }

    public function edit($id)
    {
        $model = Product::findOrFail($id);
        $model['category'] = Category::all()->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE)->pluck('name', 'id');
        return view('product.form', ['model' => $model]);
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function delete($id)
    {
        //
    }

    public function datatable()
    {
        $model = Product::get();
        return DataTables::of($model)
            ->addColumn('category_id', function($model){
                return $model->category->name;
            })
            ->addColumn('brand_id', function($model){
                return $model->brand->name;
            })
            ->editColumn('updated_at', function($model){
                return $model->created_at->diffForHumans();
            })
            ->addColumn('ibtn', function($model){
                $button = '<a href="#" class="btn-sm btn-dark modal-show mb-2" name="show">Show</a>';
                return $button;
            })
            ->editColumn('price', function($model){
                $price = 'Rp ';
                $price .= number_format($model->price, 0, ',', '.');
                return $price;
            })

            ->addColumn('action', function($model){
                $button = 
'<a href="" class="details-control" name="Details Product: '.$model->name.'"><i class="icon-eye-open text-primary"></i></a> | 
<a href="'.route('product.edit', $model->id).'" class="modal-show edit" name="Edit Product: '.$model->name.'"><i class="icon-pencil text-success"></i></a> | 
<a href="'.route('product.delete', $model->id).'" class="delete" name="'.$model->name.'"><i class="icon-trash text-danger"></i></a>';
                return $button;
            })
            ->addIndexColumn()
            ->rawColumns(['ibtn','action'])
            ->make(true);
    }
}