<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

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
}
