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
        $q = trim($request->get('q', ''));
        $perPage = (int) ($request->integer('per_page') ?? 10); // follow select
        $sort = $request->get('sort', 'nama_pupuk');
        $dir = strtolower($request->get('dir', 'asc')) === 'desc' ? 'desc' : 'asc';

        // whitelist kolom yang boleh di-sort
        $sortable = ['nama_pupuk','kode_pupuk','harga_beli','harga_jual','stok_pupuk','satuan_kg','created_at'];
        if (!in_array($sort, $sortable, true)) {
            $sort = 'nama_pupuk';
        }

        $items = Pupuk::query()
            ->when($q !== '', function ($qr) use ($q) {
                $qr->where('nama_pupuk', 'like', "%{$q}%")
                ->orWhere('kode_pupuk', 'like', "%{$q}%");
            })
            ->orderBy($sort, $dir)
            ->paginate($perPage)
            ->withQueryString();

        return view('stok_pupuk.index', compact('items','q','perPage','sort','dir'));
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
            'stok_pupuk' => 'required|integer|min:0',
            'satuan_kg' => 'required|numeric|min:0'
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
            'stok_pupuk' => 'required|integer|min:0',
            'satuan_kg' => 'required|numeric|min:0'
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
