<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProdukAPI;

class ProdukApiController extends Controller
{
    //
    // Menampilkan semua produk
    public function index()
    {
        $produk = ProdukApi::all();
        return response()->json($produk);
    }

    // Menampilkan detail produk berdasarkan ID
    public function show($id)
    {
        $produk = ProdukApi::find($id);

        if (!$produk) {
            return response()->json(['message' => 'Produk tidak ditemukan'], 404);
        }

        return response()->json($produk);
    }

    // Menambahkan produk baru
    public function store(Request $request)
{
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'category' => 'required|string|max:255',
        'stok' => 'required|integer',
        'price' => 'required|numeric',
        'image' => 'nullable|file|mimes:jpeg,png,jpg|max:2048', // Validasi file
        'description' => 'nullable|string',
    ]);

    if ($request->hasFile('image')) {
        // Simpan file gambar
        $fileName = time() . '-' . $request->file('image')->getClientOriginalName();
        $request->file('image')->move(public_path('images'), $fileName);
        $validatedData['image'] = $fileName;
    }

    $produk = ProdukApi::create($validatedData);

    return response()->json(['message' => 'Produk berhasil ditambahkan', 'data' => $produk], 201);
}


    // Memperbarui produk
    public function update(Request $request, $id)
    {
        $produk = ProdukApi::find($id);

        if (!$produk) {
            return response()->json(['message' => 'Produk tidak ditemukan'], 404);
        }

        $validatedData = $request->validate([
            'name' => 'string|max:255',
            'category' => 'string|max:255',
            'stok' => 'integer',
            'price' => 'numeric',
            'image' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        $produk->update($validatedData);

        return response()->json(['message' => 'Produk berhasil diperbarui', 'data' => $produk]);
    }

    // Menghapus produk
    public function destroy($id)
    {
        $produk = ProdukApi::find($id);

        if (!$produk) {
            return response()->json(['message' => 'Produk tidak ditemukan'], 404);
        }

        $produk->delete();

        return response()->json(['message' => 'Produk berhasil dihapus']);
    }
}

