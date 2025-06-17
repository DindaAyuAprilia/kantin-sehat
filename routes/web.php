<?php

use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

require __DIR__ . '/auth.php';

Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('kasir.dashboard');
    }
    return redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/data-karyawan', [MainController::class, 'adminDataKaryawan'])->name('admin.data-karyawan');
    Route::get('/admin/data-barang', [MainController::class, 'adminBarang'])->name('admin.barang');
    Route::get('/admin/data-persediaan', [MainController::class, 'adminPersediaan'])->name('admin.persediaan');
    Route::get('/kasir/dashboard', [MainController::class, 'kasirTransaksi'])->name('kasir.dashboard');
    Route::get('/admin/dashboard', [MainController::class, 'adminKasDashboard'])->name('admin.dashboard');
    Route::get('/saldo-bulanan', [MainController::class, 'adminSaldoBulanan'])->name('saldo-bulanan');
    Route::get('/admin/gaji', action: [MainController::class, 'adminGaji'])->name('admin.gaji');
    Route::get('/admin/transaksi-shift', [MainController::class, 'adminTransaksiShift'])->name('admin.transaksi-shift');
    Route::get('/kasir/persediaan-barang', [MainController::class, 'kasirPersediaan'])->name('kasir.persediaan');
    Route::get('/admin/stock-opname', [MainController::class, 'adminStockOpname'])->name('admin.stock-opname');
    Route::get('/admin/pengeluaran', [MainController::class, 'adminPengeluaran'])->name('admin.pengeluaran');
    Route::get('/admin/transaksi-histori', [MainController::class, 'adminTransaksiHistori'])->name('admin.transaksi-histori');
});

// Route untuk menampilkan laporan HTML
Route::get('/report/view/{key}', function ($key) {
    $htmlContent = Session::get($key);
    if ($htmlContent) {
        return response($htmlContent)->header('Content-Type', 'text/html');
    }
    return redirect()->back()->with('error', 'Laporan tidak ditemukan.');
})->name('report.view');