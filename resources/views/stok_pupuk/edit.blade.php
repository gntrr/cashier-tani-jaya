<x-app-layout>
<div class="px-4 sm:px-6 lg:px-8 container mx-auto py-4">
  <div class="bg-slate-50/70 rounded-2xl p-3 sm:p-4">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">

      {{-- Header --}}
      <div class="p-4 sm:p-5 flex items-center justify-between bg-slate-50/70 border-b border-slate-200">
        <h1 class="text-lg font-semibold text-slate-800">Edit data - {{ $pupuk->nama_pupuk }}</h1>
        <a href="{{ route('stok-pupuk.index') }}"
           class="inline-flex items-center rounded-full bg-slate-900 px-4 py-2 text-sm font-medium text-white hover:bg-slate-800">
          Kembali
        </a>
      </div>

      <form action="{{ route('stok-pupuk.update', $pupuk->id_pupuk) }}" method="POST" class="p-4 sm:p-5">
        @csrf @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-5">
          {{-- Kode Pupuk --}}
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Kode</label>
            <input type="text" name="kode_pupuk" value="{{ old('kode_pupuk', $pupuk->kode_pupuk) }}" readonly disabled
                   class="w-full rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 text-sm">
          </div>

          {{-- Nama Pupuk --}}
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Nama Pupuk</label>
            <input type="text" name="nama_pupuk" value="{{ old('nama_pupuk', $pupuk->nama_pupuk) }}"
                   class="w-full rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 text-sm">
            @error('nama_pupuk') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
          </div>

          {{-- Jumlah (stok_pupuk) --}}
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Jumlah</label>
            <input type="number" name="stok_pupuk" min="0" step="1"
                   value="{{ old('stok_pupuk', $pupuk->stok_pupuk) }}"
                   class="w-full rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 text-sm">
            @error('stok_pupuk') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
          </div>

          {{-- Satuan (Kg) --}}
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Satuan (Kg)</label>
            <input type="number" name="satuan_kg" min="0.001" step="0.001"
                   value="{{ old('satuan_kg', $pupuk->satuan_kg) }}"
                   class="w-full rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 text-sm">
            @error('satuan_kg') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
          </div>

          {{-- Harga Beli --}}
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Harga Beli</label>
            <input type="number" name="harga_beli" min="0" step="1"
                   value="{{ old('harga_beli', $pupuk->harga_beli) }}"
                   class="w-full rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 text-sm">
            @error('harga_beli') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
          </div>

          {{-- Harga Jual --}}
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Harga Jual</label>
            <input type="number" name="harga_jual" min="0" step="1"
                   value="{{ old('harga_jual', $pupuk->harga_jual) }}"
                   class="w-full rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 text-sm">
            @error('harga_jual') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
          </div>
        </div>

        <div class="mt-6 flex items-center justify-between">
          <div class="flex items-center gap-2">
            <a href="{{ route('stok-pupuk.index') }}"
               class="rounded-full px-4 py-2 text-sm font-medium text-slate-700 border border-slate-200 hover:bg-slate-50">
              Batal
            </a>
            <button type="submit"
                    class="rounded-full bg-emerald-600 px-4 py-2 text-sm font-medium text-white hover:bg-emerald-700">
              Simpan perubahan
            </button>
          </div>
        </div>
      </form>

    </div>
  </div>
</div>
</x-app-layout>
