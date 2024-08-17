<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Penjualan;
use App\Models\BarangJual;
use App\Models\Barang;
use Alert;

class HistoriPenjualanController extends Controller
{
    // public function index()
    // {
    //     // Ambil semua penjualan dengan status 2
    //     $penjualans = Penjualan::where('status', 2)->get();

    //     return view('pages.jual.historiPenjualan', compact('penjualans'));
    // }
    public function index()
    {
        $namaAdmin = Auth::user()->name;
        if ($namaAdmin == 'Admin Serdam') {
            $penjualanTunggu = Penjualan::where('status', 1)
                ->where('lokasi', 'Serdam')
                ->get();
            $penjualanSelesai = Penjualan::where('status', 2)
                ->where('lokasi', 'Serdam')
                ->get();
            $barang = Barang::all();
        } elseif ($namaAdmin == 'Admin 28') {
            $penjualanTunggu = Penjualan::where('status', 1)
                ->where('lokasi', '28')
                ->get();
            $penjualanSelesai = Penjualan::where('status', 2)
                ->where('lokasi', '28')
                ->get();
            $barang = Barang::all();
        } else {
            $penjualanTunggu = Penjualan::where('status', 1)->get();
            $penjualanSelesai = Penjualan::where('status', 2)->get();
            $barang = Barang::all();
        }

        // $penjualanTunggu = Penjualan::where('status', 1)->get();
        // $penjualanSelesai = Penjualan::where('status', 2)->get();
        // $barang = Barang::all();

        return view('pages.jual.historiPenjualan', compact('penjualanTunggu', 'penjualanSelesai', 'barang'));
    }

    public function detail($id)
    {
        $penjualan = Penjualan::with('barangJuals.barang')->findOrFail($id);
        $barangs = Barang::all(); // Ambil semua barang untuk mendapatkan stok

        return response()->json([
            'penjualan' => $penjualan,
            'barangs' => $barangs
        ]);
    }

    public function deletePenjualanTunggu($id)
    {
        // Temukan penjualan yang akan dihapus
        $penjualanTunggu = Penjualan::findOrFail($id);

        // Ambil semua barang_juals yang terkait dengan penjualan
        $barangJuals = BarangJual::where('penjualan_id', $id)->get();

        // Kembalikan jumlah barang di tabel barang
        foreach ($barangJuals as $barangJual) {
            $barang = Barang::find($barangJual->barang_id);
            if ($barang) {
                $barang->jumlah += $barangJual->jumlah;
                $barang->save();
            }
        }

        // Hapus entri barang_juals berdasarkan penjualan_id
        BarangJual::where('penjualan_id', $id)->delete();

        // Hapus penjualan
        $penjualanTunggu->delete();

        Alert::success('Berhasil',"Penjualan menunggu berhasil dihapus");
        return redirect()->back();
    }

    public function selesaiPenjualanTunggu(Request $request, $id)
    {
        $penjualanTunggu = Penjualan::findOrFail($id);
        $barangJuals = $request->input('barang_juals');

        foreach ($barangJuals as $barangJual) {
            $barangId = $barangJual['barang_id'];
            $jumlahBaru = $barangJual['jumlah'];
            $deskripsiBaru = $barangJual['deskripsi'];

            if ($jumlahBaru !== null) {
                $barang = Barang::findOrFail($barangId);
                $existingBarangJual = $penjualanTunggu->barangJuals()->where('barang_id', $barangId)->first();

                if ($existingBarangJual) {
                    $selisihJumlah = $jumlahBaru - $existingBarangJual->jumlah;

                    // Update barang_juals
                    $existingBarangJual->jumlah = $jumlahBaru;
                    $existingBarangJual->deskripsi = $deskripsiBaru ?? $existingBarangJual->deskripsi;
                    $existingBarangJual->save();

                    // Update barangs
                    $barang->jumlah -= $selisihJumlah;
                    $barang->save();
                } else {
                    Log::warning("Barang Jual not found for barang_id: $barangId");
                }
            } else {
                Log::warning("Jumlah is null for barang_id: $barangId");
            }
        }

        // Recalculate total price for the penjualan
        $totalHarga = $penjualanTunggu->barangJuals->sum(function ($barangJual) {
            return $barangJual->jumlah * $barangJual->barang->harga;
        });
        $penjualanTunggu->total_harga = $totalHarga;
        $penjualanTunggu->save();

        // Update status of penjualan
        $penjualanTunggu->status = '2';
        $penjualanTunggu->save();

        Alert::success('Berhasil', "Penjualan berhasil diselesaikan");
        return redirect()->back();
    }
}
