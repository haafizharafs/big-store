<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Gudang;
use App\Models\Kategori;
use App\Models\Satuan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Alert;

class BarangController extends Controller
{
    //
    public function index()
    {
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

        // $this->addBreadcrumb('barang', url('/barang'));
        return view('pages.gudang.barang', compact('data'));
    }

    public function formTambahBarang() {
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

        return view('pages.gudang.tambahBarang', compact('data'));
    }

    public function simpan(Request $request)
    {
        $validateBarang = $request->validate([
            'kode' => 'required',
            'kategori_id' => 'required',
            'serial_number' => 'nullable|unique:barangs,serial_number',
            'nama' => 'required',
            'gudang_id' => 'required',
            'satuan_id' => 'required',
            'harga' => 'required|numeric',
            'jumlah' => 'required|numeric'
        ], [
            'kode.required' => 'Kode wajib diisi!',
            'kategori_id.required' => 'Kategori wajib diisi!',
            'serial_number.unique' => 'SN telah terdaftar!',
            'nama.required' => 'Nama Barang wajib diisi!',
            'gudang_id.required' => 'Gudang wajib diisi!',
            'satuan_id.required' => 'Satuan wajib diisi!',
            'harga.required' => 'Harga barang wajib diisi!',
            'harga.numeric' => 'Harga barang wajib berupa angka!',
            'jumlah.required' => 'Jumlah wajib diisi!',
            'jumlah.numeric' => 'Jumlah wajib berupa angka!',
        ]);

        Barang::create($validateBarang);

        Alert::success('Berhasil',"Barang $request->nama berhasil ditambahkan");
        return redirect()->back()->with('success', 'Data added successfully');
        // return response()->json(['message' => 'added successfully'], 200);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'edit_kode' => 'required',
            'edit_serial' => 'nullable',
            'edit_nama' => 'required',
            'edit_harga' => 'required|numeric',
            'edit_jumlah' => 'required|numeric',
        ], [
            'edit_kode.required' => 'Kode wajib diisi!',
            'edit_nama.required' => 'Nama Barang wajib diisi!',
            'edit_harga.required' => 'Harga Barang Wajib diisi!',
            'edit_harga.numeric' => 'Harga Barang Wajib berupa angka!',
            'edit_jumlah.required' => 'Jumlah wajib diisi!',
            'edit_jumlah.numeric' => 'Jumlah wajib berupa angka!',
        ]);
        $barang = Barang::where('id', $id)->first();
        $barang->kode = $request->edit_kode;
        $barang->serial_number = $request->edit_serial;
        $barang->nama = $request->edit_nama;
        $barang->harga = $request->edit_harga;
        $barang->jumlah = $request->edit_jumlah;
        $barang->save();

        Alert::success('Berhasil',"Barang $request->nama berhasil diedit");
        return redirect()->back();
    }

    public function delete($id)
    {
        $barang = Barang::find($id);
        $barang->delete();

        Alert::success('Berhasil',"$barang->nama berhasil dihapus");
        return redirect()->back();
    }
}
