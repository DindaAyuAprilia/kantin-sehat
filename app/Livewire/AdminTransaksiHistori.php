<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\KasirTransaksi;
use App\Models\DetailTransaksi;
use App\Models\Barang;
use Illuminate\Support\Facades\Auth;

class AdminTransaksiHistori extends Component
{
    use WithPagination;

    public $editingTransactionId;
    public $editingDetails = [];
    public $editingDate;
    public $search = '';
    public $filter_metode_pembayaran = '';

    protected $listeners = [
        'proceedDeleteTransaction' => 'proceedDeleteTransaction',
    ];

    public function mount()
    {
        if (Auth::check() && Auth::user()->role !== 'admin') {
            abort(403, 'Hanya admin yang dapat mengakses halaman ini.');
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
        ]);
    }
}