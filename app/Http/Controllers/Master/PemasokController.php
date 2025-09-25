<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PemasokController extends Controller
{
    public function index()
    {
        return view('pemasok.index');
    }
}
