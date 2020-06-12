<?php

namespace App\Http\Controllers;

use App\Category;
use DataTables;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return view('category.index');
    }

    public function create()
    {
        $model = new Category();
        return view('form', ['model' => $model]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:20'
        ]);
        $model = Category::create($request->all());
        return response()->json($model);
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $model = Category::findOrFail($id);
        return view('form', ['model' => $model]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);
        $model = Category::findOrFail($id)->update($request->all());
        return response()->json($model);
    }

    public function delete($id)
    {
        $model = Category::findOrFail($id)->delete();
        return response()->json($model);
    }

    public function datatable()
    {
        $model = Category::with(['product'])->get();
        return DataTables::of($model)
            ->addColumn('action', function($model){
                return view('action',[
                    'model' => $model,
                    'etitle' => 'Category',
                    'edit' => route('category.edit', $model->id),
                    'delete' => route('category.delete', $model->id)
                ]);
            })
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->make(true);
    }
}
