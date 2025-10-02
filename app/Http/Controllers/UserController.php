<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();
        if ($request->filled('q')) {
            $q = '%'.$request->q.'%';
            $query->where(function($sub) use ($q){
                $sub->where('name','ILIKE',$q)->orWhere('email','ILIKE',$q);
            });
        }
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }
        $users = $query->orderBy('created_at','desc')->paginate(15)->withQueryString();
        return view('users.index', compact('users'));
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
        ]);

        $user = new User();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->role = (int)$data['role'];
        $user->password = Hash::make($data['password']);
        $user->save();

        return redirect()->route('users.index')->with('success','User berhasil dibuat.');
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'email' => ['required','string','email','max:255', Rule::unique('users','email')->ignore($user->id)],
            'role' => ['required', Rule::in([0,1])],
            'password' => ['nullable','string','min:8','confirmed'],
        ]);

        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->role = (int)$data['role'];
        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }
        $user->save();

        return redirect()->route('users.index')->with('success','User berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if (Auth::id() === $user->id) {
            return back()->with('error','Tidak dapat menghapus akun sendiri.');
        }
        // Optional guard: prevent hard conflicts by soft-deleting only
        $user->delete();
        return redirect()->route('users.index')->with('success','User berhasil dihapus.');
    }
}
