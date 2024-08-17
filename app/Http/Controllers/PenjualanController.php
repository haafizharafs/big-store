<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Barang;
use App\Models\Penjualan;
use App\Models\BarangJual;

class PenjualanController extends Controller
{
    public function simpan(Request $request)
    {
        try {
            $namaAdmin = Auth::user()->name;
            if ($namaAdmin == 'Admin Serdam') {
                $lokasi = 'Serdam';
            } elseif ($namaAdmin == 'Admin 28') {
                $lokasi = '28';
            } else {
                $lokasi = 'all';
            }

            // Log untuk memeriksa data yang diterima
            \Log::info('Request data: ', $request->all());

            // Buat Penjualan baru
            $penjualan = Penjualan::create([
                'lokasi' => $lokasi,
                'total_harga' => $request->total_harga,
                'status' => $request->status, // Menggunakan status yang diterima dari request
            ]);

            // Simpan setiap item di barang_juals
            if (!empty($request->items) && is_array($request->items)) {
                foreach ($request->items as $item) {
                    // Log untuk memeriksa data setiap item
                    \Log::info('Item data: ', $item);

                    // Periksa apakah kunci 'barang_id' ada di item
                    if (!isset($item['barang_id'])) {
                        return response()->json(['message' => 'Data item tidak valid: barang_id tidak ditemukan'], 400);
                    }

                    // Ganti null atau undefined deskripsi dengan string kosong
                    $deskripsi = $item['deskripsi'] ?? '';

                    BarangJual::create([
                        'penjualan_id' => $penjualan->id,
                        'barang_id' => $item['barang_id'],
                        'jumlah' => $item['jumlah'], // Menambahkan jumlah barang
                        'deskripsi' => $deskripsi,
                    ]);
                }
            }

            // Kurangi stok barang yang dibeli
            foreach ($request->items as $item) {
                $barang = Barang::find($item['barang_id']);
                if (!$barang) {
                    return response()->json(['message' => 'Barang tidak ditemukan'], 404);
                }

                // Kurangi stok barang
                $barang->jumlah -= $item['jumlah'];
                $barang->save();
            }

            return response()->json(['message' => 'Data berhasil disimpan']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }
}
