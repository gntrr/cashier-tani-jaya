<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $q       = trim($request->get('q', ''));
        $perPage = (int) ($request->integer('per_page') ?? 10); // follow select
        $sort    = $request->get('sort', 'name');
        $dir     = strtolower($request->get('dir', 'asc')) === 'desc' ? 'desc' : 'asc';

        // whitelist kolom yang boleh di-sort
        $sortable = ['name','email','role','is_active','created_at'];
        if (! in_array($sort, $sortable, true)) {
            $sort = 'name';
        }

        $items = User::query()
            ->when($q !== '', function ($qr) use ($q) {
                $qr->where(function ($sub) use ($q) {
                    $sub->where('name', 'like', "%{$q}%")
                        ->orWhere('email', 'like', "%{$q}%");
                });
            })
            ->orderBy($sort, $dir)
            ->paginate($perPage)
            ->withQueryString();

        return view('users.index', [
            'items'   => $items,
            'q'       => $q,
            'perPage' => $perPage,
            'sort'    => $sort,
            'dir'     => $dir,
        ]);
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'email' => ['required','string','email','max:255','unique:users,email'],
            'role' => ['required', Rule::in([0,1])],
            'password' => ['required','string','min:8','confirmed'],
            'is_active' => ['required', 'boolean'],
            'foto'       => ['nullable','image','mimes:jpg,jpeg,png,webp','max:2048'],
        ]);

        $user = new User();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->role = (int)$data['role'];
        $user->password = Hash::make($data['password']);
        $user->is_active = (bool)$data['is_active'];
        if ($request->hasFile('foto')) {
            // disimpan ke storage/app/public/avatars
            $user->foto = $request->file('foto')->store('avatars', 'public');
        }
        $user->save();

        return redirect()->route('users.index')->with('success','User berhasil dibuat.');
    }

    public function edit(User $user)
    {
        $this->authorizeEdit($user);
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $this->authorizeEdit($user);
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'email' => ['required','string','email','max:255', Rule::unique('users','email')->ignore($user->id)],
            'role' => ['required', Rule::in([0,1])],
            'password' => ['nullable','string','min:8','confirmed'],
            'foto'       => ['nullable','image','mimes:jpg,jpeg,png,webp','max:2048'],
            'hapus_foto' => ['nullable','boolean'],
            'is_active' => ['required', 'boolean'],
        ]);

        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->role = (int)$data['role'];
        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }
        $user->is_active = (bool)$data['is_active'];
        
        // handle foto
        if (($data['hapus_foto'] ?? false) && $user->foto) {
            Storage::disk('public')->delete($user->foto);
            $user->foto = null;
        }
        if ($request->hasFile('foto')) {
            if ($user->foto) Storage::disk('public')->delete($user->foto);
            $user->foto = $request->file('foto')->store('avatars', 'public');
        }

        $user->save();

        return redirect()->route('users.index')->with('success','User berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if (Auth::id() === $user->id) {
            return back()->with('error', 'Tidak dapat menghapus akun sendiri.');
        }

        // Opsional tapi sehat: jangan hapus admin terakhir
        if ((int)$user->role === 0) {
            $adminCount = User::where('role', 0)->count();
            if ($adminCount <= 1) {
                return back()->with('error', 'Tidak bisa menghapus admin terakhir.');
            }
        }

        DB::transaction(function () use ($user) {
            // HAPUS PERMANEN; FK CASCADE akan ngebabat penjualan & pembelian user ini
            if ($user->foto) Storage::disk('public')->delete($user->foto);
            $user->forceDelete();
        });

        return redirect()->route('users.index')->with('success', 'User & data terkait berhasil dihapus permanen.');
    }

    private function authorizeEdit(User $target): void
    {
        $me = Auth::user();
        // role 1 = Admin (boleh edit siapa saja)
        if ((int)$me->role === 1) return;

        // selain admin hanya boleh edit dirinya sendiri
        if ($me->id !== $target->id) {
            abort(403, 'Anda tidak berwenang mengedit pengguna ini.');
        }
    }

}
