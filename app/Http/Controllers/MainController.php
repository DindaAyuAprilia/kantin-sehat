<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{
    public function adminDataKaryawan()
    {
        $this->authorizeAdmin();
        return view('admin.data-karyawan');
    }

    public function adminBarang()
    {
        $this->authorizeAdmin();
        return view('admin.barang');
    }

    public function adminPersediaan()
    {
        $this->authorizeAdmin();
        return view('admin.persediaan');
    }

    public function adminStockOpname()
    {
        $this->authorizeAdmin();
        return view('admin.stock-opname');
    }

    public function kasirTransaksi()
    {
        $this->authorizeKasir();
        return view('kasir.dashboard');
    }

    public function kasirInventory()
    {
        $this->authorizeKasir();
        return view('kasir.inventory');
    }

    public function adminKasDashboard()
    {
        $this->authorizeAdmin();
        return view('admin.dashboard');
    }

    public function adminSaldoBulanan()
    {
        $this->authorizeAdmin();
        return view('admin.saldo-bulanan');
    }

    public function adminGaji()
    {
        $this->authorizeAdmin();
        return view('admin.gaji');
    }

    public function adminTransaksiShift()
    {
        $this->authorizeAdmin();
        return view('admin.transaksi-shift');
    }

    public function adminPengeluaran()
    {
        $this->authorizeAdmin();
        return view('admin.pengeluaran');
    }

    public function adminTransaksiHistori()
    {
        $this->authorizeAdmin();
        return view('admin.transaksi-histori');
    }

    protected function authorizeAdmin()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Tidak diizinkan');
        }
    }

    protected function authorizeKasir()
    {
        if (Auth::user()->role !== 'kasir') {
            abort(403, 'Tidak diizinkan');
        }
    }
}