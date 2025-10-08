<?php

namespace App\Http\Controllers\Transaksi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\DetailPenjualan;
use App\Models\Pupuk;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class PenjualanController extends Controller
{
    public function index(Request $request)
    {
        $query = Penjualan::query()->with('user');

        if ($request->filled('kode')) {
            $query->where('kode_penjualan', 'ILIKE', '%'.$request->kode.'%');
        }
        if ($request->filled('dari')) {
            $query->whereDate('created_at', '>=', $request->dari);
        }
        if ($request->filled('sampai')) {
            $query->whereDate('created_at', '<=', $request->sampai);
        }

        $penjualan = $query->latest()->paginate(15)->withQueryString();

        // Ringkas total (sementara)
        $totalNominal = (clone $query)->sum('total_harga');
        $totalTransaksi = (clone $query)->count();

        return view('penjualan.index', compact('penjualan','totalNominal','totalTransaksi'));
    }

    public function create()
    {
        $pupuk = Pupuk::orderBy('nama_pupuk')->get();
        return view('penjualan.create', compact('pupuk'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'bayar' => 'required|numeric|min:0',
            'item_pupuk_id' => 'required|array|min:1',
            'item_pupuk_id.*' => 'required|exists:pupuk,id_pupuk',
            'item_jumlah' => 'required|array|min:1',
            'item_jumlah.*' => 'required|integer|min:1',
            'item_harga_jual' => 'array',
            'item_harga_jual.*' => 'nullable|numeric|min:0'
        ]);

        DB::beginTransaction();
        try {
            $user = $request->user();
            $today = now()->format('Ymd');
            $seq = Penjualan::whereDate('created_at', now()->toDateString())->count() + 1;
            $kode = 'PJ'.$today.str_pad($seq,4,'0',STR_PAD_LEFT);

            $total_item = 0; $total_harga = 0; $detailRows = [];
            foreach ($request->item_pupuk_id as $idx => $pupukId) {
                if (!$pupukId) continue;
                $qty = (int)($request->item_jumlah[$idx] ?? 0);
                if ($qty <= 0) continue;
                $pupuk = Pupuk::lockForUpdate()->findOrFail($pupukId);
                if ($pupuk->stok_pupuk < $qty) {
                    throw new \Exception("Stok pupuk {$pupuk->nama_pupuk} tidak cukup");
                }
                $harga = $request->item_harga_jual[$idx] !== null && $request->item_harga_jual[$idx] !== ''
                    ? (float)$request->item_harga_jual[$idx]
                    : (float)$pupuk->harga_jual;
                $subtotal = $harga * $qty;
                $total_item += $qty;
                $total_harga += $subtotal;
                $detailRows[] = [
                    'pupuk_id_pupuk' => $pupuk->id_pupuk,
                    'harga_jual' => $harga,
                    'jumlah' => $qty,
                    'subtotal' => $subtotal,
                ];
                // update stok
                $pupuk->decrement('stok_pupuk', $qty);
            }

            if (empty($detailRows)) {
                throw new \Exception('Detail item kosong');
            }

            if ($request->bayar < $total_harga) {
                throw new \Exception('Pembayaran kurang dari total penjualan');
            }

            $penjualan = Penjualan::create([
                'user_id' => $user->id,
                'kode_penjualan' => $kode,
                'total_item' => $total_item,
                'total_harga' => $total_harga,
                'bayar' => $request->bayar,
                'kembalian' => $request->bayar - $total_harga,
            ]);

            foreach ($detailRows as $d) {
                $d['penjualan_id_penjualan'] = $penjualan->id_penjualan;
                DetailPenjualan::create($d);
            }

            DB::commit();
            return redirect()->route('penjualan.show', $penjualan->id_penjualan)->with('success','Transaksi penjualan berhasil disimpan');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withInput()->with('error',$e->getMessage());
        }
    }

    public function show(Penjualan $penjualan)
    {
        $penjualan->load(['user','detail.pupuk']);
        return view('penjualan.show', compact('penjualan'));
    }

    public function receipt(Penjualan $penjualan)
    {
        $penjualan->load(['user','detail.pupuk']);
        return view('penjualan.receipt', compact('penjualan'));
    }

    public function destroy(Penjualan $penjualan)
    {
        if ($penjualan->trashed()) {
            return redirect()->route('penjualan.index')->with('error','Transaksi sudah dihapus');
        }
        DB::transaction(function() use ($penjualan) {
            $penjualan->load('detail.pupuk');
            foreach ($penjualan->detail as $d) {
                // kembalikan stok
                $d->pupuk->increment('stok_pupuk', $d->jumlah);
            }
            $penjualan->detail()->delete();
            $penjualan->delete();
        });
        return redirect()->route('penjualan.index')->with('success','Transaksi penjualan dihapus & stok dikembalikan');
    }
}
