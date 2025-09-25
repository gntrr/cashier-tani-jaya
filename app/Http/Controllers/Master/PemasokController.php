<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pemasok;

class PemasokController extends Controller
{
    public function index(Request $request)
    {
        $query = Pemasok::query();
        if ($request->filled('kode')) {
            $query->where('kode_pemasok', 'ILIKE', '%'.$request->kode.'%');
        }
        if ($request->filled('nama')) {
            $query->where('nama_pemasok', 'ILIKE', '%'.$request->nama.'%');
        }
        $pemasok = $query->orderBy('nama_pemasok')->paginate(10)->withQueryString();
        return view('pemasok.index', compact('pemasok'));
    }

    public function create()
    {
        return view('pemasok.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'kode_pemasok' => 'required|max:45|unique:pemasok,kode_pemasok',
            'nama_pemasok' => 'required|max:255',
            'telepon_pemasok' => 'nullable|max:20',
            'alamat_pemasok' => 'nullable|max:500',
        ]);
        Pemasok::create($data);
        return redirect()->route('pemasok.index')->with('success','Pemasok berhasil ditambahkan');
    }

    public function edit(Pemasok $pemasok)
    {
        return view('pemasok.edit', compact('pemasok'));
    }

    public function update(Request $request, Pemasok $pemasok)
    {
        $data = $request->validate([
            'kode_pemasok' => 'required|max:45|unique:pemasok,kode_pemasok,' . $pemasok->id_pemasok . ',id_pemasok',
            'nama_pemasok' => 'required|max:255',
            'telepon_pemasok' => 'nullable|max:20',
            'alamat_pemasok' => 'nullable|max:500',
        ]);
        $pemasok->update($data);
        return redirect()->route('pemasok.index')->with('success','Pemasok berhasil diperbarui');
    }

    public function destroy(Pemasok $pemasok)
    {
        $pemasok->delete();
        return redirect()->route('pemasok.index')->with('success','Pemasok dihapus');
    }
}
