<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category_product;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Image_product;

class CategoryProductController extends Controller
{
    
    public function create_category(Request $request) {
        DB::beginTransaction(); 
        try {
            Category_product::create([
                'product_id' => $request->product_id,
                'description' => $request->description
            ]);

            $max = Category_product::where('product_id', $request->product_id)->count() == 3;
            DB::commit();
            return redirect()->back()->with(['success' => 'Kategori Berhasil Ditambahkan', 'max' => $max]);
        } catch (\Throwable $th) {
            DB::rollBack();
        }
    }

    public function delete_category($id) {
        DB::beginTransaction(); 
        try {
            Image_product::where('category_id', $id)->delete();
            Category_product::find($id)->delete();
            DB::commit();
            return redirect()->back()->with('success', 'Kategori Berhasil Dihapus');
        } catch (\Throwable $th) {
            DB::rollBack();
        }
    }

    public function edit_image(Request $request) {
        DB::beginTransaction(); 
        try {
            Category_product::find($request->category_id)->update([
                'description' => $request->description
            ]);
            DB::commit();
            return redirect()->back()->with('success', 'Kategori Berhasil Diubah');
        } catch (\Throwable $th) {
            DB::rollBack();
        }
    }
}