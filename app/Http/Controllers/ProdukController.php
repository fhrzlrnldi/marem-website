<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Produk;
use App\Http\Requests\StoreProdukRequest;
use App\Http\Requests\UpdateProdukRequest;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $produk = Produk::paginate(10);
        return view('produk.indexproduk', compact('produk'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('produk.createproduk');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProdukRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'harga' => 'required|integer',
            'gambar_produk' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $validatedData['user_id'] = auth()->user()->id;

        // Jika ada file gambar yang diunggah, simpan gambar
        if ($request->hasFile('gambar_produk')) {
            $image = $request->file('gambar_produk');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('produk'), $imageName);
            $validatedData['gambar_produk'] = $imageName;
        }

        // Tambahkan produk baru ke database
        $produk = Produk::create($validatedData);

        // Redirect ke halaman produk atau lakukan sesuai kebutuhan Anda
        return redirect()->route('indexproduk')->with('success', 'Produk berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Produk  $produk
     * @return \Illuminate\Http\Response
     */
    public function show(Produk $produk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Produk  $produk
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $produk = Produk::where('id',$id)->first();
        return view('produk.editproduk', compact('produk')); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProdukRequest  $request
     * @param  \App\Models\Produk  $produk
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $produk = Produk::where('id',$request->id)->first();
        // dd($request->id);
        // Validasi input
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'harga' => 'required|integer',
            'gambar_produk' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required'
        ]);

        // Jika ada file gambar yang diunggah, simpan gambar
        if ($request->hasFile('gambar_produk')) {
            $image = $request->file('gambar_produk');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('produk'), $imageName);
            $validatedData['gambar_produk'] = $imageName;
        }

        $produk->update($validatedData);

        // Redirect ke halaman produk atau lakukan sesuai kebutuhan Anda
        return redirect()->route('indexproduk')->with('success', 'Produk berhasil diperbarui!');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Produk  $produk
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        // dd($id);
        $produk = Produk::find($id);
        if (!$produk) {
            return response()->json(['message' => 'Produk not found'], 404);
        }

        $produk->delete();
        return back()->with('message', 'Produk deleted successfully');
    }
}
