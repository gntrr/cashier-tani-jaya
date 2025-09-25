<?php

namespace App\Http\Controllers\Transaksi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pembelian;
use App\Models\DetailPembelian;
use App\Models\Pemasok;
use App\Models\Pupuk;
use Illuminate\Support\Facades\DB;

class PembelianController extends Controller
{
    public function index(Request $request)
    {
        $query = Pembelian::query()->with(['pemasok','user']);

        if ($request->filled('kode')) {
            $query->where('kode_pembelian', 'ILIKE', '%'.$request->kode.'%');
        }
        if ($request->filled('dari')) {
            $query->whereDate('created_at', '>=', $request->dari);
        }
        if ($request->filled('sampai')) {
            $query->whereDate('created_at', '<=', $request->sampai);
        }
        if ($request->filled('pemasok')) {
            $query->whereHas('pemasok', function($q) use ($request){
                $q->where('nama_pemasok', 'ILIKE', '%'.$request->pemasok.'%')
                  ->orWhere('kode_pemasok', 'ILIKE', '%'.$request->pemasok.'%');
            });
        }
        if ($request->filled('pupuk')) {
            $query->whereHas('detail.pupuk', function($q) use ($request){
                $q->where('nama_pupuk', 'ILIKE', '%'.$request->pupuk.'%')
                  ->orWhere('kode_pupuk', 'ILIKE', '%'.$request->pupuk.'%');
            });
        }

        $pembelian = $query->latest()->paginate(15)->withQueryString();
        $totalNominal = (clone $query)->sum('bayar');
        $totalTransaksi = (clone $query)->count();

        return view('pembelian.index', compact('pembelian','totalNominal','totalTransaksi'));
    }

    public function create()
    {
        $pemasok = Pemasok::orderBy('nama_pemasok')->get();
        $pupuk = Pupuk::orderBy('nama_pupuk')->get();
        return view('pembelian.create', compact('pemasok','pupuk'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pemasok_id' => 'required|exists:pemasok,id_pemasok',
            'bayar' => 'required|numeric|min:0',
            'item_pupuk_id' => 'required|array|min:1',
            'item_pupuk_id.*' => 'required|exists:pupuk,id_pupuk',
            'item_jumlah' => 'required|array|min:1',
            'item_jumlah.*' => 'required|integer|min:1',
            'item_harga_beli' => 'array',
            'item_harga_beli.*' => 'nullable|numeric|min:0'
        ]);

        DB::beginTransaction();
        try {
            $user = $request->user();
            $today = now()->format('Ymd');
            $seq = Pembelian::whereDate('created_at', now()->toDateString())->count() + 1;
            $kode = 'PB'.$today.str_pad($seq,4,'0',STR_PAD_LEFT);

            $total_item = 0; $total_bayar = 0; $details = [];
            foreach ($request->item_pupuk_id as $i => $pupukId) {
                if (!$pupukId) continue;
                $qty = (int)($request->item_jumlah[$i] ?? 0);
                if ($qty <= 0) continue;
                $pupuk = Pupuk::lockForUpdate()->findOrFail($pupukId);
                $harga = $request->item_harga_beli[$i] !== null && $request->item_harga_beli[$i] !== ''
                    ? (float)$request->item_harga_beli[$i]
                    : (float)$pupuk->harga_beli;
                $subtotal = $harga * $qty;
                $total_item += $qty;
                $total_bayar += $subtotal;
                $details[] = [
                    'pupuk_id_pupuk' => $pupuk->id_pupuk,
                    'harga_beli' => $harga,
                    'jumlah' => $qty,
                    'subtotal' => $subtotal,
                ];
                // stok bertambah
                $pupuk->increment('stok_pupuk', $qty);
            }

            if (empty($details)) {
                throw new \Exception('Detail item kosong');
            }

            if ($request->bayar < $total_bayar) {
                throw new \Exception('Nominal bayar kurang dari total pembelian');
            }

            $pembelian = Pembelian::create([
                'user_id' => $user->id,
                'pemasok_id_pemasok' => $request->pemasok_id,
                'kode_pembelian' => $kode,
                'total_item' => $total_item,
                'bayar' => $total_bayar,
            ]);

            foreach ($details as $d) {
                $d['pembelian_id_pembelian'] = $pembelian->id_pembelian;
                DetailPembelian::create($d);
            }

            DB::commit();
            return redirect()->route('pembelian.show', $pembelian->id_pembelian)->with('success','Transaksi pembelian tersimpan');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withInput()->with('error',$e->getMessage());
        }
    }

    public function show(Pembelian $pembelian)
    {
        $pembelian->load(['pemasok','user','detail.pupuk']);
        return view('pembelian.show', compact('pembelian'));
    }

    public function destroy(Pembelian $pembelian)
    {
        if ($pembelian->trashed()) {
            return redirect()->route('pembelian.index')->with('error','Transaksi sudah dihapus');
        }
        DB::transaction(function() use ($pembelian) {
            $pembelian->load('detail.pupuk');
            foreach ($pembelian->detail as $d) {
                // kurangi stok yang sebelumnya ditambah -> revert
                $d->pupuk->decrement('stok_pupuk', $d->jumlah);
            }
            $pembelian->detail()->delete();
            $pembelian->delete();
        });
        return redirect()->route('pembelian.index')->with('success','Transaksi pembelian dihapus & stok direvert');
    }
}
