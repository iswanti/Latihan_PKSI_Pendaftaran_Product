<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

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
        $request->validate([
            'kode_produk' => ['required', 'unique:products,kode_produk', 'regex:/^[A-Za-z]{2}[0-9]{3}$/'],
            'nama_produk' => 'required',
            'kategori'    => 'required',
            'harga'       => 'required|numeric',
            'deskripsi'   => 'required',
            'dokumen'     => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048'
        ], [
            'kode_produk.required' => 'Kode produk wajib diisi',
            'kode_produk.regex'    => 'Kode produk harus terdiri dari 2 huruf dan 3 angka. Contoh: AB123',
            'kode_produk.unique'   => 'Kode produk sudah digunakan',
            'nama_produk.required' => 'Nama produk wajib diisi',
            'kategori.required'    => 'Kategori wajib diisi',
            'harga.required'       => 'Harga wajib diisi',
            'harga.numeric'        => 'Harga harus berupa angka',
            'deskripsi.required'   => 'Deskripsi wajib diisi',
        ]);

        $namaFile = null;

        if ($request->hasFile('dokumen')) {

            $namaFile = time() . '_' .
                $request->file('dokumen')->getClientOriginalName();

            $request->file('dokumen')
                    ->storeAs('products', $namaFile, 'public');
        }
        $request->merge([
            'kode_produk' => strtoupper($request->kode_produk)
        ]);
        Product::create([
            'kode_produk' => $request->kode_produk,
            'nama_produk' => $request->nama_produk,
            'kategori'    => $request->kategori,
            'harga'       => $request->harga,
            'deskripsi'   => $request->deskripsi,
            'dokumen'     => $namaFile
        ]);

        return redirect('/products')
                ->with('success', 'Produk berhasil ditambahkan');
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

        $request->validate([
            'kode_produk' => [
            'required',
            Rule::unique('products', 'kode_produk')->ignore($product->id),
            'regex:/^[A-Za-z]{2}[0-9]{3}$/'
        ],
            'nama_produk' => 'required',
            'kategori'    => 'required',
            'harga'       => 'required|numeric',
            'deskripsi'   => 'required',
            'dokumen'     => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048'
        ], [
            'kode_produk.required' => 'Kode produk wajib diisi',
            'kode_produk.regex'    => 'Kode produk harus terdiri dari 2 huruf dan 3 angka. Contoh: AB123',
            'kode_produk.unique'   => 'Kode produk sudah digunakan',
            'nama_produk.required' => 'Nama produk wajib diisi',
            'kategori.required'    => 'Kategori wajib diisi',
            'harga.required'       => 'Harga wajib diisi',
            'harga.numeric'        => 'Harga harus berupa angka',
            'deskripsi.required'   => 'Deskripsi wajib diisi',
        ]);

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
        $product->kategori    = $request->kategori;
        $product->harga       = $request->harga;
        $product->deskripsi   = $request->deskripsi;
        $product->kode_produk = strtoupper($request->kode_produk);

        $product->save();

        return redirect('/products')
                ->with('success', 'Produk berhasil diperbarui');
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
