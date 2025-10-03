<x-app-layout>
<div class="px-4 sm:px-6 lg:px-8 container mx-auto py-4">
  <div class="bg-slate-50/70 rounded-2xl p-3 sm:p-4">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">

      {{-- Header --}}
      <div class="p-4 sm:p-5 flex items-center justify-between bg-slate-50/70 border-b border-slate-200">
        <h1 class="text-lg font-semibold text-slate-800">Tambah data</h1>
        <a href="{{ route('pemasok.index') }}"
           class="inline-flex items-center rounded-full bg-slate-900 px-4 py-2 text-sm font-medium text-white hover:bg-slate-800">
          Kembali
        </a>
      </div>

      <form action="{{ route('pemasok.store') }}" method="POST" class="p-4 sm:p-5">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-5">
          {{-- Kode Pemasok --}}
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Kode</label>
            <input type="text" name="kode_pemasok" value="(otomatis)" disabled
                   class="w-full rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 text-sm">
            @error('kode_pemasok') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
          </div>

          {{-- Nama Pemasok --}}
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Nama Pemasok</label>
            <input type="text" name="nama_pemasok" value="{{ old('nama_pemasok') }}"
                   class="w-full rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 text-sm">
            @error('nama_pemasok') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
          </div>

          {{-- Telepon Pemasok --}}
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Telepon</label>
            <input type="text" name="telepon_pemasok" value="{{ old('telepon_pemasok') }}"
                   class="w-full rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 text-sm">
            @error('telepon_pemasok') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
          </div>

          {{-- Alamat Pemasok --}}
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Alamat</label>
            <input type="text" name="alamat_pemasok" value="{{ old('alamat_pemasok') }}"
                   class="w-full rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 text-sm">
            @error('alamat_pemasok') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
          </div>
        </div>

        <div class="mt-6 flex items-center justify-end gap-2">
          <a href="{{ route('pemasok.index') }}"
             class="rounded-full px-4 py-2 text-sm font-medium text-slate-700 border border-slate-200 hover:bg-slate-50">
            Batal
          </a>
          <button type="submit"
                  class="rounded-full bg-emerald-600 px-4 py-2 text-sm font-medium text-white hover:bg-emerald-700">
            Simpan
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
</x-app-layout>
