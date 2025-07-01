<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index()
    {
        return view('transaksi.index');
    }
    public function create()
    {
        return view('transaksi.create');
    }
    public function show($id)
    {
        return view('transaksi.show', compact('id'));
    }
}
