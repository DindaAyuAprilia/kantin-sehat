<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\KasirTransaksi;
use App\Models\DetailTransaksi;
use App\Models\Barang;
use App\Models\Kas;
use App\Models\Shift;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class AdminTransaksiHistori extends Component
{
    use WithPagination;

    public $editingTransactionId;
    public $editingDetails = [];
    public $editingDate;
    public $search = '';
    public $filter_metode_pembayaran = '';
    public $new_transaction_search = '';
    public $searchResults = [];
    public $cart = [];
    public $totalHarga = 0;
    public $paymentMethod = 'tunai';
    public $transactionDate;
    public $shift_id;
    public $shifts;

    protected $listeners = [
        'proceedDeleteTransaction' => 'proceedDeleteTransaction',
        'clear-search-results' => 'clearSearchResults',
    ];

    public function mount()
    {
        if (Auth::check() && Auth::user()->role !== 'admin') {
            abort(403, 'Hanya admin yang dapat mengakses halaman ini.');
        }
        $this->transactionDate = Carbon::today()->toDateString();
        $this->shifts = Shift::all();
    }

    public function updatedNewTransactionSearch($value)
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

    public function clearSearchResults()
    {
        $this->new_transaction_search = '';
        $this->searchResults = [];
    }

    public function selectBarang($barangId, $quantity = 1)
    {
        $barang = Barang::find($barangId);
        if (!$barang) {
            $this->dispatch('swal:error', message: 'Barang tidak ditemukan.');
            return;
        }

        if (!$barang->is_active) {
            $this->dispatch('swal:error', message: 'Barang "' . $barang->nama . '" tidak aktif.');
            $this->new_transaction_search = '';
            $this->searchResults = [];
            $this->dispatch('focus-transaction-input');
            return;
        }

        if ($barang->status_titipan && !$barang->hasil_bagi_id) {
            $this->dispatch('swal:error', message: 'Barang titipan "' . $barang->nama . '" tidak memiliki tipe hasil bagi.');
            $this->new_transaction_search = '';
            $this->searchResults = [];
            $this->dispatch('focus-transaction-input');
            return;
        }

        $existingItemIndex = array_search($barang->id, array_column($this->cart, 'barang_id'));

        if ($existingItemIndex !== false) {
            $requestedQuantity = $this->cart[$existingItemIndex]['quantity'] + $quantity;
        } else {
            $requestedQuantity = $quantity;
        }

        if ($barang->stok < $requestedQuantity) {
            $this->dispatch('swal:error', message: 'Stok barang "' . $barang->nama . '" tidak cukup. Stok tersedia: ' . $barang->stok . '.');
            $this->new_transaction_search = '';
            $this->searchResults = [];
            $this->dispatch('focus-transaction-input');
            return;
        }

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
        $this->new_transaction_search = '';
        $this->searchResults = [];
        $this->dispatch('focus-transaction-input');
    }

    public function addItem()
    {
        $barcode = trim($this->new_transaction_search);
        if (empty($barcode)) {
            return;
        }

        $barang = Barang::where('kode_barang', $barcode)
            ->where('is_active', true)
            ->first();

        if (!$barang) {
            $this->dispatch('swal:error', message: 'Barang dengan barcode "' . $barcode . '" tidak ditemukan atau tidak aktif.');
            $this->new_transaction_search = '';
            $this->searchResults = [];
            $this->dispatch('focus-transaction-input');
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
            $this->dispatch('swal:error', message: 'Barang tidak ditemukan.');
            return;
        }

        if ($barang->stok < $quantity) {
            $this->dispatch('swal:error', message: 'Stok barang "' . $barang->nama . '" tidak cukup. Stok tersedia: ' . $barang->stok . '.');
            return;
        }

        $this->cart[$index]['quantity'] = $quantity;
        $this->cart[$index]['subtotal'] = $quantity * $this->cart[$index]['price'];
        $this->calculateTotalHarga();
        $this->dispatch('focus-transaction-input');
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
            $this->dispatch('focus-transaction-input');
        }
    }

    public function calculateTotalHarga()
    {
        $this->totalHarga = array_sum(array_column($this->cart, 'subtotal'));
    }

    public function createTransaction()
    {
        if (empty($this->cart)) {
            $this->dispatch('swal:error', message: 'Keranjang kosong.');
            $this->dispatch('focus-transaction-input');
            return;
        }

        if (!Auth::check() || Auth::user()->role !== 'admin') {
            $this->dispatch('swal:error', message: 'Akses ditolak.');
            $this->dispatch('focus-transaction-input');
            return;
        }

        if (!in_array($this->paymentMethod, ['tunai', 'non_tunai'])) {
            $this->dispatch('swal:error', message: 'Pilih metode pembayaran yang valid.');
            $this->dispatch('focus-transaction-input');
            return;
        }

        if (!$this->transactionDate) {
            $this->dispatch('swal:error', message: 'Tanggal transaksi harus diisi.');
            $this->dispatch('focus-transaction-input');
            return;
        }

        if (!$this->shift_id) {
            $this->dispatch('swal:error', message: 'Shift harus dipilih.');
            $this->dispatch('focus-transaction-input');
            return;
        }

        try {
            $kas = Kas::firstOrCreate(['id' => 1], ['saldo_kas' => 0.00]);
            $transaksi = KasirTransaksi::create([
                'user_id' => Auth::user()->id,
                'total_harga' => $this->totalHarga,
                'metode_pembayaran' => $this->paymentMethod,
                'tanggal' => $this->transactionDate,
                'shift_id' => $this->shift_id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            foreach ($this->cart as $item) {
                $barang = Barang::find($item['barang_id']);
                if (!$barang) {
                    Log::warning('Barang tidak ditemukan saat membuat transaksi untuk ID: ' . $item['barang_id']);
                    continue;
                }

                $subtotal = $item['quantity'] * $barang->harga_jual;
                DetailTransaksi::create([
                    'transaksi_id' => $transaksi->id,
                    'barang_id' => $barang->id,
                    'jumlah' => $item['quantity'],
                    'subtotal' => $subtotal,
                    'harga_satuan' => $barang->harga_jual,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $barang->stok -= $item['quantity'];
                $barang->save();

                $kas->saldo_kas += $subtotal;
            }

            $kas->save();
            $this->cart = [];
            $this->totalHarga = 0;
            $this->paymentMethod = 'tunai';
            $this->transactionDate = Carbon::today()->toDateString();
            $this->shift_id = null;
            $this->dispatch('swal:success', message: 'Transaksi berhasil disimpan dengan Unix ID: ' . $transaksi->unix_id);
            $this->dispatch('focus-transaction-input');
        } catch (\Exception $e) {
            $this->dispatch('swal:error', message: 'Terjadi kesalahan saat menyimpan transaksi: ' . $e->getMessage());
        }
    }

    public function editTransaction($id)
    {
        $transaction = KasirTransaksi::with('details.barang')->findOrFail($id);
        $this->editingTransactionId = $id;
        $this->editingDate = $transaction->tanggal->toDateString();
        $this->editingDetails = $transaction->details->map(function ($detail) {
            return [
                'id' => $detail->id,
                'barang_id' => $detail->barang_id,
                'nama' => $detail->barang ? $detail->barang->nama : 'N/A',
                'jumlah' => $detail->jumlah,
                'harga_satuan' => $detail->harga_satuan,
                'subtotal' => $detail->subtotal,
                'keterangan' => $detail->keterangan,
            ];
        })->toArray();
    }

    public function removeDetail($index)
    {
        unset($this->editingDetails[$index]);
        $this->editingDetails = array_values($this->editingDetails);
    }

    public function cancelEdit()
    {
        $this->reset(['editingTransactionId', 'editingDetails', 'editingDate']);
    }

    public function saveTransaction()
    {
        try {
            $transaction = KasirTransaksi::findOrFail($this->editingTransactionId);

            // Revert original stock changes
            foreach ($transaction->details as $detail) {
                if ($detail->barang_id) {
                    $barang = Barang::find($detail->barang_id);
                    if ($barang) {
                        $barang->stok += $detail->jumlah;
                        $barang->save();
                    }
                }
            }

            // Update transaction date
            $transaction->tanggal = $this->editingDate;
            $transaction->save();

            // Update details
            $newTotal = 0;
            foreach ($this->editingDetails as $detailData) {
                $detail = DetailTransaksi::find($detailData['id']);
                if ($detail) {
                    if ($detail->barang_id) {
                        $barang = Barang::find($detail->barang_id);
                        if ($barang) {
                            $barang->stok -= $detailData['jumlah'];
                            $barang->save();
                            $detail->jumlah = $detailData['jumlah'];
                            $detail->subtotal = $detailData['jumlah'] * $detail->harga_satuan;
                        }
                    } else {
                        $detail->subtotal = $detailData['subtotal'];
                        $detail->harga_satuan = $detailData['subtotal'];
                        $detail->keterangan = $detailData['keterangan'];
                    }
                    $detail->save();
                    $newTotal += $detail->subtotal;
                }
            }

            // Remove deleted details
            $remainingDetailIds = array_column($this->editingDetails, 'id');
            $detailsToDelete = $transaction->details()->whereNotIn('id', $remainingDetailIds)->get();
            foreach ($detailsToDelete as $detail) {
                if ($detail->barang_id) {
                    $barang = Barang::find($detail->barang_id);
                    if ($barang) {
                        $barang->stok += $detail->jumlah;
                        $barang->save();
                    }
                }
                $detail->delete();
            }

            // Update total_harga
            $transaction->total_harga = $newTotal;
            $transaction->save();

            $this->cancelEdit();
            $this->dispatch('swal:success', message: 'Transaksi berhasil diubah.');
        } catch (\Exception $e) {
            $this->dispatch('swal:error', message: 'Terjadi kesalahan saat mengubah transaksi: ' . $e->getMessage());
        }
    }

    public function confirmDelete($id)
    {
        $this->dispatch('swal:confirmAction', [
            'message' => 'Apakah Anda yakin ingin menghapus transaksi ini?',
            'action' => 'proceedDeleteTransaction',
            'id' => $id
        ]);
    }

    public function proceedDeleteTransaction($id)
    {
        try {
            $transaction = KasirTransaksi::findOrFail($id);
            foreach ($transaction->details as $detail) {
                if ($detail->barang_id) {
                    $barang = Barang::find($detail->barang_id);
                    if ($barang) {
                        $barang->stok += $detail->jumlah;
                        $barang->save();
                    }
                }
            }
            $transaction->delete();
            $this->dispatch('swal:success', message: 'Transaksi berhasil dihapus.');
        } catch (\Exception $e) {
            $this->dispatch('swal:error', message: 'Terjadi kesalahan saat menghapus transaksi: ' . $e->getMessage());
        }
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedFilterMetodePembayaran()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = KasirTransaksi::with(['details.barang', 'user'])
            ->when($this->search, function ($q) {
                return $q->where('unix_id', 'like', '%' . $this->search . '%')
                    ->orWhereHas('user', function ($q) {
                        $q->where('nama', 'like', '%' . $this->search . '%');
                    });
            })
            ->when($this->filter_metode_pembayaran, function ($q) {
                return $q->where('metode_pembayaran', $this->filter_metode_pembayaran);
            });

        $transactions = $query->orderBy('tanggal', 'desc')->paginate(10);

        return view('livewire.admin-transaksi-histori', [
            'transactions' => $transactions,
            'shifts' => $this->shifts,
        ]);
    }
}