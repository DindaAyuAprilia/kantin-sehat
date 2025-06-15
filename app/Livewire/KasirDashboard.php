<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Barang;
use App\Models\KasirTransaksi;
use App\Models\DetailTransaksi;
use App\Models\Shift;
use App\Models\Kas;
use App\Models\KasTitipan;
use App\Models\KasKembalian;
use App\Models\Persediaan;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class KasirDashboard extends Component
{
    public $search = '';
    public $cart = [];
    public $totalHarga = 0;
    public $selectedDate;
    public $transactions = [];
    public $paymentMethod = 'tunai';
    public $totalTunai = 0;
    public $totalTransfer = 0;
    public $searchResults = [];
    public $uangDiberikan = 0;
    public $kembalian = 0;
    public $kembalianDiambil = 0;

    protected $listeners = [
        'proceedCheckout',
        'handleUangDiberikan' => 'setUangDiberikan',
        'handleKembalianDiambil' => 'setKembalianDiambil',
    ];

    // Inisialisasi komponen
    public function mount()
    {
        if (Auth::check() && Auth::user()->role !== 'kasir') {
            abort(403, 'Hanya kasir yang dapat mengakses halaman ini.');
        }

        config(['app.timezone' => 'Asia/Makassar']);
        date_default_timezone_set('Asia/Makassar');

        $this->selectedDate = Carbon::today()->toDateString();
        $this->loadTransactions();
    }

    public function updatedSearch($value)
    {
        $value = trim($value);
        if (!empty($value)) {
            $this->searchResults = Barang::where('is_active', true)
                ->where(function ($query) use ($value) {
                    $query->where('kode_barang', 'like', '%' . $value . '%')
                          ->orWhere('nama', 'like', '%' . $value . '%');
                })
                ->take(10)
                ->get();
        } else {
            $this->searchResults = [];
        }
    }

    // Pilih barang
    public function selectBarang($barangId, $quantity = 1)
    {
        $barang = Barang::find($barangId);
        if (!$barang) {
            Log::warning('Barang tidak ditemukan untuk ID: ' . $barangId);
            $this->dispatch('show-alert', message: 'Barang tidak ditemukan.');
            return;
        }

        if (!$barang->is_active) {
            Log::warning('Barang tidak aktif: ' . $barang->nama);
            $this->dispatch('show-alert', message: 'Barang "' . $barang->nama . '" tidak aktif.');
            $this->search = '';
            $this->searchResults = [];
            $this->dispatch('focus-input');
            return;
        }

        if ($barang->status_titipan && !$barang->hasil_bagi_id) {
            Log::warning('Barang titipan ' . $barang->nama . ' tidak memiliki tipe hasil bagi.');
            $this->dispatch('show-alert', message: 'Barang titipan "' . $barang->nama . '" tidak memiliki tipe hasil bagi.');
            $this->search = '';
            $this->searchResults = [];
            $this->dispatch('focus-input');
            return;
        }

        $existingItemIndex = array_search($barang->id, array_column($this->cart, 'barang_id'));

        if ($existingItemIndex !== false) {
            $requestedQuantity = $this->cart[$existingItemIndex]['quantity'] + $quantity;
        } else {
            $requestedQuantity = $quantity;
        }

        if ($barang->stok < $requestedQuantity) {
            Log::warning('Stok tidak cukup untuk barang: ' . $barang->nama . ' (Stok tersedia: ' . $barang->stok . ', Diminta: ' . $requestedQuantity . ')');
            $this->dispatch('show-alert', message: 'Stok barang "' . $barang->nama . '" tidak cukup. Stok tersedia: ' . $barang->stok . '.');
            $this->search = '';
            $this->searchResults = [];
            $this->dispatch('focus-input');
            return;
        }

        Log::info('Barang ditemukan: ' . $barang->nama . ' (Barcode: ' . $barang->kode_barang . ')');
        if ($existingItemIndex !== false) {
            $this->cart[$existingItemIndex]['quantity'] = $requestedQuantity;
            $this->cart[$existingItemIndex]['subtotal'] = $this->cart[$existingItemIndex]['quantity'] * $barang->harga_jual;
        } else {
            $this->cart[] = [
                'barang_id' => $barang->id,
                'barcode' => $barang->kode_barang,
                'name' => $barang->nama,
                'price' => $barang->harga_jual,
                'quantity' => $quantity,
                'subtotal' => $barang->harga_jual * $quantity,
            ];
        }

        $this->calculateTotalHarga();
        $this->search = '';
        $this->searchResults = [];
        $this->dispatch('item-added');
        $this->dispatch('focus-input');
    }

    public function addItem()
    {
        $barcode = trim($this->search);
        if (empty($barcode)) {
            return;
        }

        Log::info('Mencoba menambahkan barang dengan barcode: ' . $barcode);

        $barang = Barang::where('kode_barang', $barcode)
            ->where('is_active', true)
            ->first();

        if (!$barang) {
            Log::warning('Barang tidak ditemukan atau tidak aktif untuk barcode: ' . $barcode);
            $this->dispatch('show-alert', message: 'Barang dengan barcode "' . $barcode . '" tidak ditemukan atau tidak aktif.');
            $this->search = '';
            $this->searchResults = [];
            $this->dispatch('focus-input');
            return;
        }

        $this->selectBarang($barang->id);
    }

    public function updateQuantity($index, $quantity)
    {
        if (!isset($this->cart[$index])) {
            return;
        }

        $quantity = max(1, (int)$quantity);
        $barang = Barang::find($this->cart[$index]['barang_id']);

        if (!$barang) {
            Log::warning('Barang tidak ditemukan untuk ID: ' . $this->cart[$index]['barang_id']);
            $this->dispatch('show-alert', message: 'Barang tidak ditemukan.');
            return;
        }

        if ($barang->stok < $quantity) {
            Log::warning('Stok tidak cukup untuk barang: ' . $barang->nama . ' (Stok tersedia: ' . $barang->stok . ', Diminta: ' . $quantity . ')');
            $this->dispatch('show-alert', message: 'Stok barang "' . $barang->nama . '" tidak cukup. Stok tersedia: ' . $barang->stok . '.');
            return;
        }

        $this->cart[$index]['quantity'] = $quantity;
        $this->cart[$index]['subtotal'] = $quantity * $this->cart[$index]['price'];
        $this->calculateTotalHarga();
        $this->dispatch('item-updated');
        $this->dispatch('focus-input');
    }

    public function incrementQuantity($index)
    {
        if (!isset($this->cart[$index])) {
            return;
        }

        $this->updateQuantity($index, $this->cart[$index]['quantity'] + 1);
    }

    public function decrementQuantity($index)
    {
        if (!isset($this->cart[$index])) {
            return;
        }

        $this->updateQuantity($index, $this->cart[$index]['quantity'] - 1);
    }

    public function removeFromCart($index)
    {
        if (isset($this->cart[$index])) {
            unset($this->cart[$index]);
            $this->cart = array_values($this->cart);
            $this->calculateTotalHarga();
            $this->dispatch('item-removed');
            $this->dispatch('focus-input');
        }
    }

    public function calculateTotalHarga()
    {
        $this->totalHarga = array_sum(array_column($this->cart, 'subtotal'));
    }

    // Proses checkout
    public function checkout()
    {
        if (empty($this->cart)) {
            $this->dispatch('show-alert', message: 'Keranjang kosong.');
            $this->dispatch('focus-input');
            return;
        }

        if (!Auth::check() || Auth::user()->role !== 'kasir') {
            $this->dispatch('show-alert', message: 'Akses ditolak.');
            $this->dispatch('focus-input');
            return;
        }

        if (!in_array($this->paymentMethod, ['tunai', 'transfer'])) {
            $this->dispatch('show-alert', message: 'Pilih metode pembayaran yang valid.');
            $this->dispatch('focus-input');
            return;
        }

        $currentTime = Carbon::now();
        $shift = Shift::where('jam_mulai', '<=', $currentTime->format('H:i'))
                      ->where('jam_selesai', '>=', $currentTime->format('H:i'))
                      ->first();

        if (!$shift) {
            $this->dispatch('show-alert', message: 'Tidak ada shift aktif saat ini. Silakan hubungi admin untuk mengatur shift.');
            $this->dispatch('focus-input');
            return;
        }

        if ($this->paymentMethod === 'tunai') {
            $this->dispatch('swal:inputUangDiberikan', totalHarga: $this->totalHarga);
        } else {
            $this->dispatch('swal:confirmCheckout');
        }
    }

    public function setUangDiberikan($jumlah)
    {
        $this->uangDiberikan = floatval($jumlah);

        if ($this->uangDiberikan < $this->totalHarga) {
            $this->dispatch('show-alert', message: 'Uang yang diberikan kurang dari total harga.');
            $this->dispatch('focus-input');
            return;
        }

        $this->kembalian = $this->uangDiberikan - $this->totalHarga;
        if ($this->kembalian > 0 && $this->paymentMethod === 'tunai') {
            $this->dispatch('swal:inputKembalianOpsi', kembalian: $this->kembalian);
        } else {
            $this->dispatch('swal:confirmCheckout');
        }
    }

    public function setKembalianDiambil($jumlah, $opsi)
    {
        $this->kembalianDiambil = floatval($jumlah);

        if ($opsi === 'sebagian') {
            if ($this->kembalianDiambil < 0) {
                $this->dispatch('show-alert', message: 'Nominal kembalian tidak boleh minus.');
                return;
            }
            if ($this->kembalianDiambil > $this->kembalian) {
                $this->dispatch('show-alert', message: 'Nominal kembalian tidak boleh melebihi Rp ' . number_format($this->kembalian, 0, ',', '.'));
                return;
            }
        } elseif ($opsi === 'tidak') {
            $this->kembalianDiambil = 0;
        } elseif ($opsi === 'iya') {
            $this->kembalianDiambil = $this->kembalian;
        }

        if ($opsi === 'batal') {
            $this->kembalian = 0;
            $this->kembalianDiambil = 0;
            $this->dispatch('focus-input');
            return;
        }

        $this->dispatch('swal:confirmCheckout');
    }

    // Simpan transaksi
    public function proceedCheckout()
    {
        config(['app.timezone' => 'Asia/Makassar']);
        date_default_timezone_set('Asia/Makassar');

        $currentTime = Carbon::now();
        $shift = Shift::where('jam_mulai', '<=', $currentTime->format('H:i'))
                      ->where('jam_selesai', '>=', $currentTime->format('H:i'))
                      ->first();

        if (!$shift) {
            $this->dispatch('show-alert', message: 'Tidak ada shift aktif saat ini. Transaksi tidak dapat dilanjutkan.');
            $this->dispatch('focus-input');
            return;
        }

        $kas = Kas::firstOrCreate(['id' => 1], ['saldo_kas' => 0.00]);
        $transaksi = KasirTransaksi::create([
            'user_id' => Auth::user()->id,
            'total_harga' => $this->totalHarga,
            'metode_pembayaran' => $this->paymentMethod,
            'tanggal' => now()->toDateString(),
            'shift_id' => $shift->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        foreach ($this->cart as $item) {
            $barang = Barang::with('hasilBagi')->find($item['barang_id']);
            if (!$barang) {
                Log::warning('Barang tidak ditemukan saat checkout untuk ID: ' . $item['barang_id']);
                continue;
            }

            $subtotal = $item['quantity'] * $barang->harga_jual;

            $quantityNeeded = $item['quantity'];
            $totalBiayaPokok = 0;
            $persediaans = Persediaan::where('barang_id', $barang->id)
                ->whereIn('tipe', ['pembelian', 'penambahan_titipan'])
                ->where('sisa_stok', '>', 0)
                ->orderBy('tanggal', 'asc')
                ->orderBy('id', 'asc')
                ->get();

            foreach ($persediaans as $persediaan) {
                if ($quantityNeeded <= 0) {
                    break;
                }

                $available = $persediaan->sisa_stok;
                $used = min($available, $quantityNeeded);
                $biayaPokokPerUnit = $persediaan->total_harga / $persediaan->jumlah;
                $totalBiayaPokok += $used * $biayaPokokPerUnit;

                $persediaan->sisa_stok -= $used;
                $persediaan->save();

                $quantityNeeded -= $used;
                Log::info("Menggunakan {$used} unit dari persediaan ID {$persediaan->id} untuk barang {$barang->nama} dengan biaya pokok Rp {$biayaPokokPerUnit}/unit");
            }

            if ($quantityNeeded > 0) {
                Log::warning("Stok persediaan tidak cukup untuk barang {$barang->nama}. Kekurangan: {$quantityNeeded} unit.");
                $this->dispatch('show-alert', message: "Stok persediaan untuk barang {$barang->nama} tidak cukup.");
                return;
            }

            $profit = $subtotal - $totalBiayaPokok;

            DetailTransaksi::create([
                'transaksi_id' => $transaksi->id,
                'barang_id' => $barang->id,
                'jumlah' => $item['quantity'],
                'subtotal' => $subtotal,
                'harga_satuan' => $barang->harga_jual,
                'biaya_pokok' => $totalBiayaPokok,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $barang->stok -= $item['quantity'];
            $barang->save();

            if ($barang->status_titipan) {
                $kasTitipan = KasTitipan::where('barang_id', $barang->id)->first();
                if (!$kasTitipan) {
                    $kasTitipan = KasTitipan::create([
                        'barang_id' => $barang->id,
                        'saldo_kas' => 0.00,
                    ]);
                    Log::info('KasTitipan dibuat untuk barang ID: ' . $barang->id);
                }

                $kasTitipan->saldo_kas += $totalBiayaPokok;
                $kasTitipan->save();
                Log::info('KasTitipan untuk barang ' . $barang->nama . ' diperbarui: +' . $totalBiayaPokok);

                $roundingUnit = $barang->hasilBagi && $barang->hasilBagi->tipe == '2000' ? 2000 : 1000;
                $profitPerUnit = ($subtotal - $totalBiayaPokok) / $item['quantity'];
                $roundedProfitPerUnit = $roundingUnit;
                $totalRoundedProfit = $roundedProfitPerUnit * $item['quantity'];
                $kas->saldo_kas += $totalRoundedProfit;
                Log::info('Kas utama diperbarui untuk barang titipan ' . $barang->nama . ': +' . $totalRoundedProfit . ' (rounded to ' . $roundingUnit . ')');
            } else {
                $kas->saldo_kas += $subtotal;
                Log::info('Kas utama diperbarui untuk barang non-titipan ' . $barang->nama . ': +' . $subtotal);
            }
        }

        // Simpan KasKembalian hanya setelah konfirmasi akhir
        $sisaKembalian = $this->kembalian - $this->kembalianDiambil;
        if ($sisaKembalian > 0) {
            KasKembalian::create([
                'jumlah' => $sisaKembalian,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            Log::info('Sisa kembalian disimpan ke kas_kembalian: ' . $sisaKembalian);
        }

        $kas->save();
        Log::info('Kas utama disimpan dengan saldo: ' . $kas->saldo_kas);

        $this->cart = [];
        $this->totalHarga = 0;
        $this->paymentMethod = 'tunai';
        $this->uangDiberikan = 0;
        $this->kembalian = 0;
        $this->kembalianDiambil = 0;
        $this->dispatch('swal:success', message: 'Transaksi berhasil disimpan dengan Unix ID: ' . $transaksi->unix_id);
        $this->dispatch('focus-input');
        $this->loadTransactions();
    }

    // Muat transaksi
    public function loadTransactions()
    {
        if (!Auth::check()) {
            $this->transactions = [];
            $this->totalTunai = 0;
            $this->totalTransfer = 0;
            return;
        }

        $this->transactions = KasirTransaksi::with('details.barang')
            ->where('user_id', Auth::user()->id)
            ->whereDate('tanggal', $this->selectedDate)
            ->orderBy('created_at', 'desc')
            ->get();

        $this->totalTunai = KasirTransaksi::where('user_id', Auth::user()->id)
            ->whereDate('tanggal', $this->selectedDate)
            ->where('metode_pembayaran', 'tunai')
            ->sum('total_harga');

        $this->totalTransfer = KasirTransaksi::where('user_id', Auth::user()->id)
            ->whereDate('tanggal', $this->selectedDate)
            ->where('metode_pembayaran', 'transfer')
            ->sum('total_harga');
    }

    public function previousDay()
    {
        $this->selectedDate = Carbon::parse($this->selectedDate)->subDay()->toDateString();
        $this->loadTransactions();
        $this->dispatch('focus-input');
    }

    public function nextDay()
    {
        $this->selectedDate = Carbon::parse($this->selectedDate)->addDay()->toDateString();
        $this->loadTransactions();
        $this->dispatch('focus-input');
    }

    // Metode untuk memperbarui tanggal yang dipilih secara langsung
    public function updatedSelectedDate()
    {
        $this->loadTransactions();
    }

    public function render()
    {
        return view('livewire.kasir-dashboard');
    }
}