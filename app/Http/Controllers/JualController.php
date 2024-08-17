<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Gudang;
use App\Models\Kategori;
use App\Models\Satuan;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Alert;

class JualController extends Controller
{
    public function index() {
        $namaAdmin = Auth::user()->name;
        if ($namaAdmin == 'Admin Serdam') {
            $data['gudang'] = Gudang::where('nama', 'Serdam')->get();
            $data['barang'] = Barang::whereHas('gudang', function ($query) {
                $query->where('nama', 'Serdam');
            })->get();
            $data['kategori'] = Kategori::all();
            $data['satuan'] = Satuan::all();
        } elseif ($namaAdmin == 'Admin 28') {
            $data['gudang'] = Gudang::where('nama', '28')->get();
            $data['barang'] = Barang::whereHas('gudang', function ($query) {
                $query->where('nama', '28');
            })->get();
            $data['kategori'] = Kategori::all();
            $data['satuan'] = Satuan::all();
        } else {
            $data['gudang'] = Gudang::all();
            $data['barang'] = Barang::all();
            $data['kategori'] = Kategori::all();
            $data['satuan'] = Satuan::all();
        }

        // $data['gudang'] = Gudang::all();
        // $data['barang'] = Barang::all();
        // $data['kategori'] = Kategori::all();
        // $data['satuan'] = Satuan::all();

        return view('pages.jual.jual', compact('data'));
    }
}
