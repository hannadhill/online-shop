<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $products = Product::all();
        $query=$request->input('query');
        $itemPerPage=10;
        $page=$request->input('limit', 5);
        $order=$request->input('order');
        $sort=$request->input('sort');
        if($query){
            $products=Product::where($order, 'name', 'like', '%'.$query.'%')->orderBy($order, $sort)->paginate($itemPerPage);
        } else {
            $products=Product::orderBy($order,$sort)->paginate($itemPerPage);
        }
        return response()->json($products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'category_id' => "required|exists:categories,id",
            'brand_id' => "required|exists:brands,id",
        ]);
        Product::create($request->all());
        return response()->json(['message' => 'Produk berhasil ditambahkan'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::find($id);
        return response()->json(['product' => $product]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product, string $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:50',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'category_id' => "required|exists:categories,id",
            'brand_id' => "required|exists:brands,id",
        ]);
        $product = Product::findOrFail($id);
        $product->update($validatedData);
        return response()->json(['message' => 'Produk berhasil diupdate'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product, string $id)
    {
        $product = Product::find($id);
        $product->delete();
        return response()->json(['message' => 'Produk berhasil dihapus']);
    }
}
