<?php

namespace App\Http\Controllers;

use App\Brand;
use DataTables;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index()
    {
        return view('brand.index');
    }

    public function create()
    {
        $model = new Brand();
        return view('form', ['model' => $model]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);
        $model = Brand::create($request->all());
        return response()->json($model);
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $model = Brand::findOrFail($id);
        return view('form', ['model' => $model]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);
        $model = Brand::findOrFail($id)->update($request->all());
        return response()->json($model);
    }

    public function delete($id)
    {
        $model = Brand::findOrFail($id)->delete();
        return response()->json($model);
    }

    public function datatable()
    {
        $model = Brand::with(['product'])->get();
        return DataTables::of($model)
            ->addColumn('action', function($model){
                return view('action',[
                    'model' => $model,
                    'etitle' => 'Brand',
                    'edit' => route('brand.edit', $model->id),
                    'delete' => route('brand.delete', $model->id)
                ]);
            })
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->make(true);
    }
}