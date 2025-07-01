<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PasienController extends Controller
{
    public function index()
    {
        return view('pasien.index');
    }
    public function show($id)
    {
        return view('pasien.show', compact('id'));
    }
}
