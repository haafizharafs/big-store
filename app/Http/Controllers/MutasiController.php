<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Mutasi;
use App\Models\MutasiMasuk;
use App\Models\MutasiKembali;
use App\Models\MutasiKeluar;
use App\Models\Gudang;
use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Satuan;
use Alert;

class MutasiController extends Controller
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
            // $data['mutasiMasuk'] = MutasiMasuk::whereHas('gudang', function ($query) {
            //     $query->where('nama', 'Serdam');
            // })->get();
            $data['mutasiKeluar'] = MutasiKeluar::whereHas('gudang', function ($query) {
                $query->where('nama', 'Serdam');
            })->get();
            $data['mutasiKembali'] = MutasiKembali::whereHas('gudang', function ($query) {
                $query->where('nama', 'Serdam');
            })->get();
        } elseif ($namaAdmin == 'Admin 28') {
            $data['gudang'] = Gudang::where('nama', '28')->get();
            $data['barang'] = Barang::whereHas('gudang', function ($query) {
                $query->where('nama', '28');
            })->get();
            $data['kategori'] = Kategori::all();
            $data['satuan'] = Satuan::all();
            // $data['mutasiMasuk'] = MutasiMasuk::whereHas('gudang', function ($query) {
            //     $query->where('nama', '28');
            // })->get();
            $data['mutasiKeluar'] = MutasiKeluar::whereHas('gudang', function ($query) {
                $query->where('nama', '28');
            })->get();
            $data['mutasiKembali'] = MutasiKembali::whereHas('gudang', function ($query) {
                $query->where('nama', '28');
            })->get();
        } else {
            // $data['mutasiMasuk'] = MutasiMasuk::all();
            $data['mutasiKeluar'] = MutasiKeluar::all();
            $data['mutasiKembali'] = MutasiKembali::all();
            $data['gudang'] = Gudang::all();
            $data['kategori'] = Kategori::all();
            $data['satuan'] = Satuan::all();
            $data['barang'] = Barang::all();
        }

        // $data['mutasiMasuk'] = MutasiMasuk::all();
        // $data['mutasiKeluar'] = MutasiKeluar::all();
        // $data['mutasiKembali'] = MutasiKembali::all();
        // $data['gudang'] = Gudang::all();
        // $data['kategori'] = Kategori::all();
        // $data['satuan'] = Satuan::all();
        // $data['barang'] = Barang::all();

        // $this->addBreadcrumb('mutasi', url('admin/mutasi'));
        return view('pages.gudang.mutasi', compact('data'));
    }

    // public function simpanMasuk(Request $request)
    // {
    //     //membuat data mutasi
    //     MutasiMasuk::create([
    //        'barang_id' => $request->barang,
    //        'sumber_gudang_id' => $request->dariGudang,
    //        'jumlah' => $request->jumlah,
    //        'tujuan_gudang_id' => $request->keGudang,
    //     ]);

    //     //mengambil data barang pada gudang sumber
    //     $barang = Barang::findOrFail($request->barang);

    //     //cek jumlah barang
    //     if($barang->jumlah < $request->jumlah) {
    //         return response()->json(['message' => 'Jumlah barang tidak mencukupi']);
    //     }

    //     //mengurangi jumlah barang pada gudang sumber
    //     $barang->decrement('jumlah', $request->jumlah);

    //     //membuat barang dengan dengan data gudang tujuan, jumlah yang dipindahkan
    //     Barang::create([
    //         'kode' => $barang->kode,
    //         'serial_number' => $barang->serial_number,
    //         'nama' => $barang->nama,
    //         'gudang_id' => $request->keGudang,
    //         'kategori_id' => $barang->kategori_id,
    //         'satuan_id' => $barang->satuan_id,
    //         'jumlah' => $request->jumlah,
    //     ]);

    //     Alert::success('Berhasil',"Mutasi Masuk $request->nama berhasil!");
    //     return redirect()->back();
    // }
    // public function deleteMasuk($id)
    // {
    //     $masuk = MutasiMasuk::find($id);
    //     $masuk->delete();

    //     Alert::success('Berhasil',"Mutasi Masuk $masuk->nama berhasil dihapus!");
    //     return redirect()->back();
    // }

    public function simpanKeluar(Request $request) {
        //mengambil data barang pada gudang sumber
        $barang = Barang::findOrFail($request->barang);

        MutasiKeluar::create([
            'barang_id' => $request->barang,
            'gudang_id' => $barang->gudang->id,
            'tujuan' => $request->tujuan,
            'jumlah' => $request->jumlah,
        ]);

        //mengambil data barang pada gudang sumber
        $barang = Barang::findOrFail($request->barang);

        //cek jumlah barang
        if($barang->jumlah < $request->jumlah) {
            return response()->json(['message' => 'jumlah barang tidak mencukupi']);
        }

        //mengurangi jumlah barang pada gudang sumber
        $barang->decrement('jumlah', $request->jumlah);

        Alert::success('Berhasil',"Mutasi Keluar $barang->nama berhasil!");
        return redirect()->back();
    }
    public function deleteKeluar($id)
    {
        $keluar = MutasiKeluar::find($id);
        $keluar->delete();

        Alert::success('Berhasil',"Mutasi Keluar $keluar->nama berhasil dihapus!");
        return redirect()->back();
    }

    public function simpanKembali(Request $request) {
        //mengambil data barang pada mutasi keluar
        $mutasiKeluar = MutasiKeluar::findOrFail($request->mutasiKeluar);
        $barang = Barang::findOrFail($mutasiKeluar->barang->id);

        MutasiKembali::create([
            'sumber' => $mutasiKeluar->tujuan,
            'barang_id' => $mutasiKeluar->barang->id,
            'jumlah' => $mutasiKeluar->jumlah,
            'gudang_id' => $mutasiKeluar->gudang->id,
        ]);

        //menambah jumlah barang pada gudang tujuan
        $barang->increment('jumlah', $mutasiKeluar->jumlah);

        //menghapus record mutasi keluar
        MutasiKeluar::find($request->mutasiKeluar)->delete();

        Alert::success('Berhasil',"Mutasi Kembali $barang->nama berhasil!");
        return redirect()->back();
    }
    public function deleteKembali($id) {
        $kembali = MutasiKembali::find($id);
        $kembali->delete();

        Alert::success('Berhasil',"Mutasi Kembali $kembali->nama berhasil dihapus!");
        return redirect()->back();
    }
}
