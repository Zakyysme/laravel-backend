<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ProductModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Validator as ValidationValidator;

class productController extends Controller
{
    public function getProduk(){
        $data = ProductModel::get();
        
        return response()->json([
            'status' => true,
            'message' => 'data_produk', 
            'data' => $data 
        ], 200);
    }

    public function createProduk(Request $request){
        $validator = Validator::make($request->all(), [
           'nama_produk' => 'required', 
           'deskripsi_produk' => 'required', 
           'jumlah_produk' => 'required', 
           'harga_produk' => 'required', 
           'kategori' =>'required', 
           'status' => 'required', 
        ]);

        if ($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        $produk = ProductModel::create([
            'nama_produk' => $request->nama_produk,
            'deskripsi_produk' => $request->deskripsi_produk,
            'jumlah_produk' => $request->jumlah_produk,
            'harga_produk' => $request->harga_produk,
            'kategori' => $request->kategori,
            'status' => $request->status,
        ]);
        if ($produk){
            return response()->json([
                'status' => true,
                'message' => 'Berhasil membuat data Produk'
            ], 201);
        }

        return response()->json([
            'status' => false,
            'message' => 'gagal menambahkan data produk'
        ], 409);
    }

    public function editProduk(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'nama_produk' => 'required',
            'deskripsi_produk' => 'required',
            'jumlah_produk' => 'required',
            'harga_produk' => 'required',
            'kategori' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $produk = ProductModel::where('id', $id)->update([
            'nama_produk' => $request->nama_produk,
            'deskripsi_produk' => $request->deskripsi_produk,
            'jumlah_produk' => $request->jumlah_produk,
            'harga_produk' => $request->harga_produk,
            'kategori' => $request->kategori,
            'status' => $request->status,
        ]);
        if ($produk) {
            return response()->json([
                'status' => true,
                'message' => 'Berhasil mengedit data Produk'
            ], 201);
        }

        return response()->json([
            'status' => false,
            'message' => 'gagal mengedit data produk'
        ], 409);
    }
    public function deleteProduk($id){
        $produk = ProductModel::find($id);

        if(!$produk){
            return response()->json([
                'status' => false,
                'message' => 'Produk tidak ditemukan'
            ], 404);
        }

        $produk->delete();

        return response()->json([
           'status' => true,
           'message' => 'Produk berhasil dihapus' 
        ], 200);
    }
}