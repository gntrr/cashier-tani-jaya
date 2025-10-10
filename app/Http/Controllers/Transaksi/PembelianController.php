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
        $query = Pembelian::query()->with(['pemasok','user','detail.pupuk']);

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
        // total nominal hanya count yang sudah lunas
        $totalNominal = (clone $query)->where('status', 'lunas')->sum('bayar');
        $totalTransaksi = (clone $query)->count();

        // dd($pembelian, $totalNominal, $totalTransaksi);
        return view('pembelian.index', compact('pembelian','totalNominal','totalTransaksi'));
    }

    public function create()
    {
        $pemasok = Pemasok::orderBy('nama_pemasok')->get();
        $pupuk = Pupuk::orderBy('nama_pupuk')->get();
        return view('pembelian.create', compact('pemasok','pupuk'));
    }

    public function edit(Pembelian $pembelian)
    {
        if ($pembelian->trashed()) {
            return redirect()->route('pembelian.index')->with('error','Transaksi sudah dihapus');
        }
        $pembelian->load(['detail.pupuk','pemasok']);
        $pemasok = Pemasok::orderBy('nama_pemasok')->get();
        $pupuk = Pupuk::orderBy('nama_pupuk')->get();
        return view('pembelian.edit', compact('pembelian','pemasok','pupuk'));
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
            'item_harga_beli.*' => 'nullable|numeric|min:0',
            'tanggal_beli' => 'required|date',
            'status' => 'required|in:lunas,tertunda'
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
                'tanggal_beli' => $request->tanggal_beli,
                'status' => $request->status
            ]);

            foreach ($details as $d) {
                $d['pembelian_id_pembelian'] = $pembelian->id_pembelian;
                DetailPembelian::create($d);
            }

            DB::commit();
            // return redirect()->route('pembelian.show', $pembelian->id_pembelian)->with('success','Transaksi pembelian tersimpan');
            return redirect()->route('pembelian.index')->with('success','Transaksi pembelian tersimpan');
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

    public function update(Request $request, Pembelian $pembelian)
    {
        if ($pembelian->trashed()) {
            return redirect()->route('pembelian.index')->with('error','Transaksi sudah dihapus');
        }

        $request->validate([
            'pemasok_id' => 'required|exists:pemasok,id_pemasok',
            'bayar' => 'required|numeric|min:0',
            'item_pupuk_id' => 'required|array|min:1',
            'item_pupuk_id.*' => 'required|exists:pupuk,id_pupuk',
            'item_jumlah' => 'required|array|min:1',
            'item_jumlah.*' => 'required|integer|min:1',
            'item_harga_beli' => 'array',
            'item_harga_beli.*' => 'nullable|numeric|min:0',
            'tanggal_beli' => 'required|date',
            'status' => 'required|in:lunas,tertunda'
        ]);

        DB::beginTransaction();
        try {
            $pembelian->load('detail');
            // Map lama: pupuk_id => qty
            $oldMap = [];
            foreach ($pembelian->detail as $d) {
                $oldMap[$d->pupuk_id_pupuk] = ($oldMap[$d->pupuk_id_pupuk] ?? 0) + $d->jumlah;
            }

            $newDetails = [];
            $newMap = [];
            $total_item = 0; $total_bayar = 0;
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
                $newDetails[] = [
                    'pupuk_id_pupuk' => $pupukId,
                    'harga_beli' => $harga,
                    'jumlah' => $qty,
                    'subtotal' => $subtotal,
                ];
                $newMap[$pupukId] = ($newMap[$pupukId] ?? 0) + $qty;
            }

            if (empty($newDetails)) {
                throw new \Exception('Detail item kosong');
            }
            if ($request->bayar < $total_bayar) {
                throw new \Exception('Nominal bayar kurang dari total pembelian');
            }

            // Hitung diff stok
            $allIds = array_unique(array_merge(array_keys($oldMap), array_keys($newMap)));
            if ($allIds) {
                $pupukRows = Pupuk::whereIn('id_pupuk', $allIds)->lockForUpdate()->get()->keyBy('id_pupuk');
                foreach ($allIds as $pid) {
                    $oldQty = $oldMap[$pid] ?? 0;
                    $newQty = $newMap[$pid] ?? 0;
                    $diff = $newQty - $oldQty; // positif: tambah stok, negatif: kurangi stok (revert)
                    if ($diff > 0) {
                        $pupukRows[$pid]->increment('stok_pupuk', $diff);
                    } elseif ($diff < 0) {
                        $need = abs($diff);
                        if ($pupukRows[$pid]->stok_pupuk < $need) {
                            throw new \Exception('Stok pupuk '.($pupukRows[$pid]->nama_pupuk ?? $pid).' tidak cukup untuk mengurangi '.$need);
                        }
                        $pupukRows[$pid]->decrement('stok_pupuk', $need);
                    }
                }
            }

            // Soft delete detail lama & buat baru
            $pembelian->detail()->delete();
            foreach ($newDetails as $d) {
                $d['pembelian_id_pembelian'] = $pembelian->id_pembelian;
                DetailPembelian::create($d);
            }

            $pembelian->update([
                'pemasok_id_pemasok' => $request->pemasok_id,
                'total_item' => $total_item,
                'bayar' => $total_bayar,
                'tanggal_beli' => $request->tanggal_beli,
                'status' => $request->status
            ]);

            DB::commit();
            // return redirect()->route('pembelian.show', $pembelian->id_pembelian)->with('success','Transaksi pembelian diperbarui');
            return redirect()->route('pembelian.index')->with('success','Transaksi pembelian diperbarui');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withInput()->with('error',$e->getMessage());
        }
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
