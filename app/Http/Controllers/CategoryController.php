<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categories = Category::all();
        $query=$request->input('query');
        $itemPerPage=10;
        $page=$request->input('limit', 5);
        $order=$request->input('order');
        $sort=$request->input('sort');
        if($query){
            $categories=Category::where($order, 'name', 'like', '%'.$query.'%')->orderBy($order, $sort)->paginate($itemPerPage);
        } else {
            $categories=Category::orderBy($order,$sort)->paginate($itemPerPage);
        }

        return response()->json($categories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
        ]);
        Category::create($request->all());
        return response()->json(['message' => 'Category berhasil ditambahkan'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category, string $id)
    {
        $category = Category::find($id);
        return response()->json(['category' => $category]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:50',
        ]);
        $category = Category::findOrFail($id);
        $category->update($request->all());
        return response()->json(['message' => 'Category berhasil diupdate'], 200);    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category, string $id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return response()->json(['message' => 'Category berhasil dihapus'], 200);
    }
}
