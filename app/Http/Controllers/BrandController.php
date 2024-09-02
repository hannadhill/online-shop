<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $brands = Brand::all();
        $query=$request->input('query');
        $itemPerPage=10;
        $page=$request->input('limit', 5);
        $order=$request->input('order');
        $sort=$request->input('sort');
        if($query){
            $brands=Brand::where($order, 'name', 'like', '%'.$query.'%')->orderBy($order, $sort)->paginate($itemPerPage);
        } else {
            $brands=Brand::orderBy($order,$sort)->paginate($itemPerPage);
        }
        return response()->json($brands);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
        ]);
        Brand::create($request->all());
        return response()->json(['message' => 'Nama brand berhasil di tambahkan'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Brand $brand, string $id)
    {
        $brand = Brand::find($id);
        return response()->json(['brand' => $brand]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Brand $brand, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:50',
        ]);
        $brand = Brand::findOrFail($id);
        $brand->update($request->all());
        return response()->json(['message' => 'Nama brand berhasil diubah'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand, string $id)
    {
        $brand = Brand::findOrFail($id);
        $brand->delete();
        return response()->json(['message' => 'Brand berhasil dihapus'], 200);
    }
}
