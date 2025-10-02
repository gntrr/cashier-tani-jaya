<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pemasok;

class PemasokController extends Controller
{
    public function index(Request $request)
    {
        $q = trim($request->get('q', ''));
        $perPage = (int) ($request->integer('per_page') ?? 10); // follow select
        $sort = $request->get('sort', 'nama_pemasok');
        $dir = strtolower($request->get('dir', 'asc')) === 'desc' ? 'desc' : 'asc';

        // whitelist kolom yang boleh di-sort
        $sortable = ['nama_pemasok','kode_pemasok','telepon_pemasok','created_at'];
        if (!in_array($sort, $sortable, true)) {
            $sort = 'nama_pemasok';
        }

        $items = Pemasok::query()
            ->when($q !== '', function ($qr) use ($q) {
                $qr->where('nama_pemasok', 'like', "%{$q}%")
                ->orWhere('kode_pemasok', 'like', "%{$q}%");
            })
            ->orderBy($sort, $dir)
            ->paginate($perPage)
            ->withQueryString();

        return view('pemasok.index', compact('items','q','perPage','sort','dir'));
    }

    public function create()
    {
        return view('pemasok.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_pemasok' => 'required|max:255',
            'telepon_pemasok' => 'nullable|max:20',
            'alamat_pemasok' => 'nullable|max:500',
        ]);

        $nextId = (int)(Pemasok::max('id_pemasok') ?? 0) + 1;
        $kode = 'SUP-'.str_pad($nextId,4,'0',STR_PAD_LEFT);

        Pemasok::create(array_merge($data,[
            'kode_pemasok' => $kode,
        ]));
        return redirect()->route('pemasok.index')->with('success','Pemasok berhasil ditambahkan');
    }

    public function edit(Pemasok $pemasok)
    {
        return view('pemasok.edit', compact('pemasok'));
    }

    public function update(Request $request, Pemasok $pemasok)
    {
        $data = $request->validate([
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
