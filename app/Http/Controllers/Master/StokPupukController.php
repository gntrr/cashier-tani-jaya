<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pupuk;
use Illuminate\Support\Facades\DB;

class StokPupukController extends Controller
{
    public function index(Request $request)
    {
        $query = Pupuk::query();

        if ($request->filled('kode')) {
            $query->where('kode_pupuk', 'ILIKE', '%'.$request->kode.'%');
        }
        if ($request->filled('nama')) {
            $query->where('nama_pupuk', 'ILIKE', '%'.$request->nama.'%');
        }

        $pupuk = $query->orderBy('nama_pupuk')->paginate(10)->withQueryString();

        return view('stok_pupuk.index', compact('pupuk'));
    }

    public function create()
    {
        return view('stok_pupuk.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_pupuk' => 'required|string|max:45',
            'harga_beli' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0|gte:harga_beli',
            'stok_pupuk' => 'required|integer|min:0'
        ]);

        // Generate kode otomatis: PPK-0001, PPK-0002, ...
        $nextId = (int) (Pupuk::max('id_pupuk') ?? 0) + 1;
        $kode = 'PPK-'.str_pad($nextId, 4, '0', STR_PAD_LEFT);

        Pupuk::create(array_merge($data, [
            'kode_pupuk' => $kode,
        ]));
        return redirect()->route('stok-pupuk.index')->with('success','Pupuk berhasil ditambahkan');
    }

    public function edit(Pupuk $pupuk)
    {
        return view('stok_pupuk.edit', compact('pupuk'));
    }

    public function update(Request $request, Pupuk $pupuk)
    {
        $data = $request->validate([
            'nama_pupuk' => 'required|string|max:45',
            'harga_beli' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0|gte:harga_beli',
            'stok_pupuk' => 'required|integer|min:0'
        ]);
        $pupuk->update($data);
        return redirect()->route('stok-pupuk.index')->with('success','Pupuk berhasil diperbarui');
    }

    public function destroy(Pupuk $pupuk)
    {
        $pupuk->delete();
        return redirect()->route('stok-pupuk.index')->with('success','Pupuk berhasil dihapus');
    }
}
