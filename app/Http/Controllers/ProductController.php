<?php

namespace App\Http\Controllers;

use App\Product;
use DataTables;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return view('product.index');
    }

    public function create()
    {
        $model = new Product();
        return view('product.form', ['model' => $model]);
    }

    public function store(Request $request)
    {
        //
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function datatable()
    {
        $model = Product::all();
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
            ->addColumn('action', function($model){
                return view('action',[
                    'model' => $model,
                    'show' => route('product.show', $model->id),
                    'edit' => route('product.edit', $model->id),
                    'delete' => route('product.delete', $model->id)
                ]);
            })
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->make(true);
    }
}