<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

use Carbon\Carbon;
use App\Models\Penjualan;
use App\Models\MutasiKeluar;

class DashboardController extends Controller
{
    public function index(){
        $bulan = Carbon::now()->month;
        $tahun = Carbon::now()->year;
        $namaAdmin = Auth::user()->name;

        if ($namaAdmin == 'Admin Serdam') {
            //jumlah transaksi
            $transaksiTunggu = Penjualan::where('status', 1)
                ->where('lokasi', 'Serdam')
                ->whereYear('created_at', $tahun)
                ->whereMonth('created_at', $bulan)
                ->count();
            $transaksiSelesai = Penjualan::where('status', 2)
                ->where('lokasi', 'Serdam')
                ->whereYear('created_at', $tahun)
                ->whereMonth('created_at', $bulan)
                ->count();
            //pendapatan
            $pendapatan = Penjualan::where('status', 2)
                ->where('lokasi', 'Serdam')
                ->whereYear('created_at', $tahun)
                ->whereMonth('created_at', $bulan)
                ->sum('total_harga');
            //mutasi keluar
            $mutasiKeluar = MutasiKeluar::whereHas('gudang', function ($query) {
                $query->where('nama', 'Serdam');
            })->count();
        } elseif ($namaAdmin == 'Admin 28') {
            //jumlah transaksi
            $transaksiTunggu = Penjualan::where('status', 1)
                ->where('lokasi', '28')
                ->whereYear('created_at', $tahun)
                ->whereMonth('created_at', $bulan)
                ->count();
            $transaksiSelesai = Penjualan::where('status', 2)
                ->where('lokasi', '28')
                ->whereYear('created_at', $tahun)
                ->whereMonth('created_at', $bulan)
                ->count();
            //pendapatan
            $pendapatan = Penjualan::where('status', 2)
                ->where('lokasi', '28')
                ->whereYear('created_at', $tahun)
                ->whereMonth('created_at', $bulan)
                ->sum('total_harga');
            //mutasi keluar
            $mutasiKeluar = MutasiKeluar::whereHas('gudang', function ($query) {
                $query->where('nama', '28');
            })->count();
        } else {
            $transaksiTunggu = Penjualan::where('status', 1)
                ->whereYear('created_at', $tahun)
                ->whereMonth('created_at', $bulan)
                ->count();
            $transaksiSelesai = Penjualan::where('status', 2)
                ->whereYear('created_at', $tahun)
                ->whereMonth('created_at', $bulan)
                ->count();
            $pendapatan = Penjualan::where('status', 2)
                ->whereYear('created_at', $tahun)
                ->whereMonth('created_at', $bulan)
                ->sum('total_harga');
            $mutasiKeluar = MutasiKeluar::count();
        }

        // $bulan = Carbon::now()->month;
        // $tahun = Carbon::now()->year;

        // //jumlah transaksi
        // $transaksiTunggu = Penjualan::where('status', 1)
        //     ->whereYear('created_at', $tahun)
        //     ->whereMonth('created_at', $bulan)
        //     ->count();
        // $transaksiSelesai = Penjualan::where('status', 2)
        //     ->whereYear('created_at', $tahun)
        //     ->whereMonth('created_at', $bulan)
        //     ->count();

        // //pendapatan
        // $pendapatan = Penjualan::where('status', 2)
        //     ->whereYear('created_at', $tahun)
        //     ->whereMonth('created_at', $bulan)
        //     ->sum('total_harga');

        //mutasi keluar
        // $mutasiKeluar = MutasiKeluar::count();

        return view('pages.dashboard', compact('pendapatan', 'transaksiTunggu', 'transaksiSelesai', 'mutasiKeluar'));
    }
}
