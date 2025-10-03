<x-app-layout>
<div class="px-4 sm:px-6 lg:px-8 container mx-auto py-4">
  <div class="bg-slate-50/70 rounded-2xl p-3 sm:p-4">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">

      {{-- Header --}}
      <div class="p-4 sm:p-5 flex items-center justify-between bg-slate-50/70 border-b border-slate-200">
        <h1 class="text-lg font-semibold text-slate-800">Edit User - {{ $user->name }}</h1>
        <a href="{{ route('users.index') }}"
           class="inline-flex items-center rounded-full bg-slate-900 px-4 py-2 text-sm font-medium text-white hover:bg-slate-800">
          Kembali
        </a>
      </div>

      <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data" class="p-4 sm:p-5">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-5">
          {{-- Foto Profil --}}
          <div class="md:col-span-2">
            <label class="block text-sm font-medium text-slate-700 mb-2">Foto Profil</label>
            <div class="flex items-center gap-4">
                @php
                    // Escape the first letter for URL
                    $escapedName = \Illuminate\Support\Str::substr($user->name, 0, 1);
                @endphp
                <img id="preview-foto" src="{{ $user->foto ? asset('storage/'.$user->foto) : 'https://placehold.co/600x400?text='.$escapedName }}"
                    alt="Preview Foto" class="w-28 h-28 rounded-full object-cover border">
                <div class="space-y-2">
                    <input type="file" name="foto" id="input-foto" accept="image/*"
                        class="block w-full text-sm file:mr-3 rounded-full file:border-0 file:bg-emerald-600 file:px-4 file:py-2 file:text-white hover:file:bg-emerald-700
                                rounded-xl border border-slate-300 focus:border-emerald-500 focus:ring-emerald-500">
                    <div class="text-xs text-slate-500">Biarkan jika tidak ingin mengubah foto</div>
                    @error('foto') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        {{-- <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-5"> --}}
          {{-- Nama --}}
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Nama</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}"
                   class="w-full rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 text-sm">
          </div>

          {{-- Email --}}
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}"
                   class="w-full rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 text-sm">
          </div>

          {{-- Role --}}
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Role</label>
            <select name="role" class="w-full rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 text-sm">
              <option value="1" @selected(old('role', $user->role) == 1)>Admin</option>
              <option value="0" @selected(old('role', $user->role) == 0)>Kasir</option>
            </select>
          </div>

          {{-- Password --}}
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Password (opsional)</label>
            <input type="password" name="password"
                   class="w-full rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 text-sm">
          </div>

          {{-- Konfirmasi Password --}}
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Konfirmasi Password</label>
            <input type="password" name="password_confirmation"
                   class="w-full rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 text-sm">
          </div>

          {{-- Status --}}
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Status</label>
            <select name="is_active" class="w-full rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 text-sm">
              <option value="1" @selected(old('is_active', $user->is_active) == 1)>Aktif</option>
              <option value="0" @selected(old('is_active', $user->is_active) == 0)>Nonaktif</option>
            </select>
          </div>
        </div>

        <div class="mt-6 flex items-center justify-end gap-2">
          <a href="{{ route('users.index') }}"
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
</script>
{{-- script preview --}}
<script>
    document.getElementById('input-foto')?.addEventListener('change', (e) => {
        const [file] = e.target.files || [];
        if (file) document.getElementById('preview-foto').src = URL.createObjectURL(file);
    });
</script>
