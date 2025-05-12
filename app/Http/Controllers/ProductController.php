<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Category_product;
use App\Models\Image_product;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('product.index', [
            // 'categories' => Category_product::all(),
            'product' => Product::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            Product::create([
                'name' => $request->name,
            ]);

            $max = Product::count() == 5;
            DB::commit();
            return redirect()->back()->with(['success' => 'Produk Berhasil Ditambahkan', 'max' => $max]);
            // return redirect()->back()->with('success', 'Produk Berhasil Ditambahkan');
        } catch (\Throwable $th) {
            DB::rollBack();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        DB::beginTransaction();
        try {
            Product::find($request->product_id)->update([
                'name' => $request->name,
            ]);
            DB::commit();
            return redirect()->back()->with('success', 'Produk Berhasil Diubah');
        } catch (\Throwable $th) {
            DB::rollBack();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();
        try {
            $category = Category_product::where('product_id', $id)->pluck('id');
            Image_product::whereIn('category_id', $category)->delete();
            $category = Category_product::where('product_id', $id)->delete();
            Product::find($id)->delete();
            DB::commit();
            return redirect()->back()->with('success', 'Produk Berhasil Dihapus');
        } catch (\Throwable $th) {
            dd($th);
            DB::rollBack();
        }
    }
}