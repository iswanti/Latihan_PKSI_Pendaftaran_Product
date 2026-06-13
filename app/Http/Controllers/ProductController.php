<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // Menampilkan semua produk
    public function index()
    {
        $products = Product::all();

        return view('products.index', compact('products'));
    }

    // Menampilkan form tambah
    public function create()
    {
        return view('products.create');
    }

    // Menyimpan data
    public function store(Request $request)
    {
        $namaFile = null;

        if ($request->hasFile('dokumen')) {

            $namaFile = time() . '_' .
                $request->file('dokumen')->getClientOriginalName();

            $request->file('dokumen')
                    ->storeAs('products', $namaFile, 'public');
        }

        Product::create([
            'kode_produk' => $request->kode_produk,
            'nama_produk' => $request->nama_produk,
            'kategori'    => $request->kategori,
            'harga'       => $request->harga,
            'deskripsi'   => $request->deskripsi,
            'dokumen'     => $namaFile
        ]);

        return redirect('/products');
    }

    // Menampilkan form edit
    public function edit($id)
    {
        $product = Product::findOrFail($id);

        return view('products.edit', compact('product'));
    }

    // Update data
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        if ($request->hasFile('dokumen')) {

            if ($product->dokumen) {
                Storage::disk('public')
                    ->delete('products/' . $product->dokumen);
            }

            $namaFile = time() . '_' .
                $request->file('dokumen')->getClientOriginalName();

            $request->file('dokumen')
                    ->storeAs('products', $namaFile, 'public');

            $product->dokumen = $namaFile;
        }

        $product->kode_produk = $request->kode_produk;
        $product->nama_produk = $request->nama_produk;
        $product->kategori = $request->kategori;
        $product->harga = $request->harga;
        $product->deskripsi = $request->deskripsi;

        $product->save();

        return redirect('/products');
    }

    // Hapus data
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if ($product->dokumen) {
            Storage::disk('public')
                ->delete('products/' . $product->dokumen);
        }

        $product->delete();

        return redirect('/products');
    }
}