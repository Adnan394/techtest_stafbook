<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image_product;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ImageProductController extends Controller
{
    public function create_image(Request $request) {
        DB::beginTransaction(); 
        try {
            $filename = '';
            if($request->hasFile('image')) {
                $request->file('image')->move('img_product/', $request->file('image')->getClientOriginalName());
                $filename = $request->file('image')->getClientOriginalName();
            }
            Image_product::create([
                'category_id' => $request->category_id,
                'image' => $filename
            ]);
            DB::commit();
            return redirect()->back()->with('success', 'Gambar Berhasil Ditambahkan');
        } catch (\Throwable $th) {
            dd($th);
            DB::rollBack();
        }
    }

    public function delete_image($id) {
        DB::beginTransaction(); 
        try {
            Image_product::find($id)->delete();
            DB::commit();
            return redirect()->back()->with('success', 'Gambar Berhasil Dihapus');
        } catch (\Throwable $th) {
            DB::rollBack();
        }
    }

    public function edit_image(Request $request) {
        DB::beginTransaction(); 
        try {
            $filename = '';
            if($request->hasFile('image')) {
                $request->file('image')->move('img_product/', $request->file('image')->getClientOriginalName());
                $filename = $request->file('image')->getClientOriginalName();
            }

            Image_product::find($request->id)->update([
                'image' => $filename
            ]);
            DB::commit();
            return redirect()->back()->with('success', 'Gambar Berhasil Diubah');
        } catch (\Throwable $th) {
            DB::rollBack();
        }
    }
}