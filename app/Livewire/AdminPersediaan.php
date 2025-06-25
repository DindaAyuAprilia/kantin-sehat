<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Persediaan;
use App\Models\StokMasuk;
use App\Models\Barang;
use App\Models\KasTitipan;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;

class AdminPersediaan extends Component
{
    use WithPagination;

    public $barang_id = '';
    public $search_query_form = '';
    public $search_query_table = '';
    public $search_results;
    public $tipe = '';
    public $tanggal = '';
    public $jumlah = '';
    public $alasan = '';
    public $barangs;
    public $isLoading = false;
    public $isEditing = false;
    public $selectedId = null;
    public $total_harga = 0;
    public $harga_beli = 0;
    public $showHistory = false;
    public $isDataChanged = false;
    public $tipe_filter = 'all';
    public $use_calculator = false;
    public $pack_amount = '';
    public $items_per_pack = '';
    public $use_discount = false;
    public $discount_amount = 0;

    protected $paginationTheme = 'bootstrap';

    protected $listeners = [
        'proceedSave',
        'editPersediaan',
        'proceedUpdate',
        'deletePersediaan',
    ];

    public function mount()
    {
        $this->isLoading = true;
        $this->barangs = Barang::all();
        $this->tanggal = date('Y-m-d');
        $this->search_results = collect();
        $this->tipe = '';
        $this->isLoading = false;
    }

    public function updatedTipeFilter()
    {
        $this->resetPage();
    }

    public function updatedSearchQueryForm($value)
    {
        if ($value) {
            $barang = Barang::where('kode_barang', $value)->first();
            if ($barang) {
                $this->selectBarang($barang->id);
                $this->search_results = collect();
                $this->dispatch('barangSelected');
                return;
            }

            $this->search_results = Barang::where('nama', 'like', '%' . $value . '%')
                ->orWhere('kode_barang', 'like', '%' . $value . '%')
                ->take(10)
                ->get();
        } else {
            $this->search_results = collect();
        }
    }

    public function selectBarang($barang_id)
    {
        $barang = Barang::find($barang_id);
        if ($barang) {
            $this->barang_id = $barang->id;
            $this->search_query_form = $barang->nama;
            $this->search_results = collect();
            $this->harga_beli = $barang->harga_pokok;
            $this->tipe = $barang->status_titipan ? 'penambahan_titipan' : 'pembelian';
            $this->calculateTotalHarga();
            $this->dispatch('barangSelected');
            if ($this->isEditing) {
                $this->isDataChanged = true;
            }
        }
    }

    public function updatedJumlah($value)
    {
        if (!$this->use_calculator) {
            $this->calculateTotalHarga();
        }
        if ($this->isEditing) {
            $this->isDataChanged = true;
        }
    }

    public function updatedHargaBeli($value)
    {
        if (!$this->use_calculator) {
            $this->calculateTotalHarga();
        }
        if ($this->isEditing) {
            $this->isDataChanged = true;
        }
    }

    public function updatedTotalHarga($value)
    {
        if ($this->use_calculator) {
            $this->calculateUnitValues();
        }
        if ($this->isEditing) {
            $this->isDataChanged = true;
        }
    }

    public function updatedTipe($value)
    {
        if ($this->isEditing) {
            $this->isDataChanged = true;
        }
    }

    public function updatedTanggal($value)
    {
        if ($this->isEditing) {
            $this->isDataChanged = true;
        }
    }

    public function updatedAlasan($value)
    {
        if ($this->isEditing) {
            $this->isDataChanged = true;
        }
    }

     public function updatedPackAmount()
    {
        if ($this->use_calculator) {
            $this->calculateUnitValues();
        }
    }

    public function updatedItemsPerPack()
    {
        if ($this->use_calculator) {
            $this->calculateUnitValues();
        }
    }

    public function updatedDiscountAmount()
    {
        if ($this->use_calculator && $this->use_discount) {
            $this->calculateUnitValues();
        }
    }

    public function updatedUseDiscount($value)
    {
        if ($this->use_calculator) {
            if (!$value) {
                $this->discount_amount = 0;
            }
        }
    }

    public function set($data)
    {
        if (isset($data['jumlah'])) {
            $this->jumlah = $data['jumlah'];
        }
        if (isset($data['harga_beli'])) {
            $this->harga_beli = $data['harga_beli'];
        }
        if (isset($data['total_harga'])) {
            $this->total_harga = $data['total_harga'];
        }
    }

    protected function calculateTotalHarga()
    {
        if ($this->jumlah && is_numeric($this->jumlah) && $this->harga_beli) {
            $this->total_harga = $this->jumlah * $this->harga_beli;
        } else {
            $this->total_harga = 0;
        }
    }

    protected function calculateUnitValues()
    {
        if ($this->use_calculator && in_array($this->tipe, ['pembelian', 'penambahan_titipan'])) {
            $packAmount = (float) $this->pack_amount;
            $itemsPerPack = (float) $this->items_per_pack;
            $totalPrice = (float) $this->total_harga;
            $discountAmount = $this->use_discount ? (float) $this->discount_amount : 0;

            $totalStock = $packAmount * $itemsPerPack;
            $adjustedTotalPrice = max(0, $totalPrice - $discountAmount);
            $this->jumlah = $totalStock > 0 ? (int) $totalStock : 0;
            $this->harga_beli = ($this->jumlah > 0 && $adjustedTotalPrice > 0) ? round($adjustedTotalPrice / $this->jumlah, 2) : 0;
            $this->total_harga = $adjustedTotalPrice;
        }
    }

    public function save()
    {
        $this->dispatch('swal:confirmSave');
    }

    public function proceedSave()
    {
        $this->isLoading = true;

        if ($this->use_calculator && in_array($this->tipe, ['pembelian', 'penambahan_titipan'])) {
            $this->calculateUnitValues();
        }

        $this->validate([
            'barang_id' => 'required|exists:barangs,id',
            'tipe' => 'required|in:pembelian,penghapusan,penambahan_titipan,pengambilan_titipan',
            'tanggal' => 'required|date',
            'jumlah' => 'required|integer|min:1',
            'harga_beli' => 'required|numeric|min:0',
            'total_harga' => 'required_if:use_calculator,true|numeric|min:0',
            'alasan' => 'nullable|string|max:255',
            'pack_amount' => 'nullable|integer|min:0',
            'items_per_pack' => 'nullable|integer|min:0',
        ]);

        $barang = Barang::find($this->barang_id);
        $kasTitipan = KasTitipan::where('barang_id', $barang->id)->first();
        $this->total_harga = $this->total_harga + $this->discount_amount;
        $this->harga_beli = $this->total_harga/$this->jumlah;
    

        if (in_array($this->tipe, ['penghapusan', 'pengambilan_titipan'])) {
            if ($this->jumlah > $barang->stok) {
                $this->isLoading = false;
                $this->dispatch('swal:error', message: 'Maaf, stok tidak cukup. Stok saat ini: ' . $barang->stok);
                return;
            }
        }

        if ($this->tipe === 'pembelian') {
            $barang->stok += $this->jumlah;
            $barang->harga_pokok = $this->harga_beli;
            StokMasuk::create([
                'barang_id' => $barang->id,
                'jumlah_masuk' => $this->jumlah,
                'harga_beli' => $this->harga_beli,
                'sisa_stok' => $this->jumlah,
                'tanggal_masuk' => $this->tanggal,
            ]);
        } elseif ($this->tipe === 'penghapusan') {
            $barang->stok -= $this->jumlah;
            if ($barang->stok < 0) {
                $barang->stok = 0;
            }
            // Hitung total_harga dengan FIFO
            $totalHargaPenghapusan = 0;
            $quantityNeeded = $this->jumlah;
            $persediaans = Persediaan::where('barang_id', $barang->id)
                ->whereIn('tipe', ['pembelian', 'penambahan_titipan'])
                ->where('sisa_stok', '>', 0)
                ->orderBy('tanggal', 'asc')
                ->orderBy('id', 'asc')
                ->get();

            foreach ($persediaans as $persediaan) {
                if ($quantityNeeded <= 0) break;
                $available = min($persediaan->sisa_stok, $quantityNeeded);
                $biayaPokokPerUnit = $persediaan->total_harga / $persediaan->jumlah;
                $totalHargaPenghapusan += $available * $biayaPokokPerUnit;
                $persediaan->sisa_stok -= $available;
                $persediaan->save();
                $quantityNeeded -= $available;
            }

            if ($quantityNeeded > 0) {
                $this->isLoading = false;
                $this->dispatch('swal:error', message: 'Stok tidak cukup untuk penghapusan menggunakan FIFO.');
                return;
            }

            $this->total_harga = $totalHargaPenghapusan;

        } elseif ($this->tipe === 'penambahan_titipan') {
            $barang->stok += $this->jumlah;
            $barang->harga_pokok = $this->harga_beli;
            if (!$kasTitipan) {
                KasTitipan::create([
                    'barang_id' => $barang->id,
                    'saldo_kas' => 0.00,
                ]);
            }
            StokMasuk::create([
                'barang_id' => $barang->id,
                'jumlah_masuk' => $this->jumlah,
                'harga_beli' => $this->harga_beli,
                'sisa_stok' => $this->jumlah,
                'tanggal_masuk' => $this->tanggal,
            ]);
        } elseif ($this->tipe === 'pengambilan_titipan') {
            $barang->stok -= $this->jumlah;
            if ($barang->stok < 0) {
                $barang->stok = 0;
            }
        }

        $barang->save();

        Persediaan::create([
            'barang_id' => $this->barang_id,
            'kelola_id' => Auth::id(),
            'tipe' => $this->tipe,
            'tanggal' => $this->tanggal,
            'jumlah' => $this->jumlah,
            'alasan' => $this->alasan,
            'total_harga' => $this->total_harga,
            'sisa_stok' => in_array($this->tipe, ['pembelian', 'penambahan_titipan']) ? $this->jumlah : 0,
        ]);

        $this->resetForm();
        $this->dispatch('swal:success', message: 'Persediaan berhasil ditambahkan.');
        $this->isLoading = false;
    }

    public function confirmEdit($id)
    {
        $this->editPersediaan($id);
    }

    public function editPersediaan($id)
    {
        $this->isLoading = true;
        $this->selectedId = $id;
        $persediaan = Persediaan::find($this->selectedId);
        if ($persediaan) {
            $this->barang_id = $persediaan->barang_id;
            $this->search_query_form = $persediaan->barang->nama;
            $this->search_results = collect();
            $this->tipe = $persediaan->tipe;
            $this->tanggal = $persediaan->tanggal;
            $this->jumlah = $persediaan->jumlah;
            $this->alasan = $persediaan->alasan;
            $this->total_harga = $persediaan->total_harga;
            $this->harga_beli = $persediaan->total_harga / $persediaan->jumlah;
            $this->use_calculator = false;
            $this->pack_amount = '';
            $this->items_per_pack = '';
            $this->isEditing = true;
            $this->isDataChanged = false;
        }
        $this->isLoading = false;
    }

    public function confirmUpdate()
    {
        if ($this->isDataChanged) {
            $this->dispatch('swal:confirmUpdatePersediaan');
        } else {
            $this->proceedUpdate();
        }
    }

    public function proceedUpdate()
    {
        $this->isLoading = true;

        if ($this->use_calculator && in_array($this->tipe, ['pembelian', 'penambahan_titipan'])) {
            $this->calculateUnitValues();
        }

        $this->validate([
            'barang_id' => 'required|exists:barangs,id',
            'tipe' => 'required|in:pembelian,penghapusan,penambahan_titipan,pengambilan_titipan',
            'tanggal' => 'required|date',
            'jumlah' => 'required|integer|min:1',
            'harga_beli' => 'required|numeric|min:0',
            'total_harga' => 'required_if:use_calculator,true|numeric|min:0',
            'alasan' => 'nullable|string|max:255',
            'pack_amount' => 'nullable|integer|min:0',
            'items_per_pack' => 'nullable|integer|min:0',
        ]);

        $persediaan = Persediaan::find($this->selectedId);
        if ($persediaan) {
            $barang = Barang::find($persediaan->barang_id);
            $kasTitipan = KasTitipan::where('barang_id', $barang->id)->first();

            if ($persediaan->tipe === 'pembelian') {
                $barang->stok -= $persediaan->jumlah;
            } elseif ($persediaan->tipe === 'penghapusan') {
                $barang->stok += $persediaan->jumlah;
            } elseif ($persediaan->tipe === 'penambahan_titipan') {
                $barang->stok -= $persediaan->jumlah;
            } elseif ($persediaan->tipe === 'pengambilan_titipan') {
                $barang->stok += $persediaan->jumlah;
            }

            if (in_array($this->tipe, ['penghapusan', 'pengambilan_titipan'])) {
                if ($this->jumlah > $barang->stok) {
                    $this->isLoading = false;
                    $this->dispatch('swal:error', message: 'Maaf, stok tidak cukup. Stok saat ini: ' . $barang->stok);
                    $barang->save();
                    return;
                }
            }

            if ($this->tipe === 'pembelian') {
                $barang->stok += $this->jumlah;
                $barang->harga_pokok = $this->harga_beli;
                $stokMasuk = StokMasuk::where('barang_id', $barang->id)
                    ->where('tanggal_masuk', $persediaan->tanggal)
                    ->first();
                if ($stokMasuk) {
                    $stokMasuk->update([
                        'jumlah_masuk' => $this->jumlah,
                        'harga_beli' => $this->harga_beli,
                        'sisa_stok' => $stokMasuk->sisa_stok + ($this->jumlah - $persediaan->jumlah),
                    ]);
                } else {
                    StokMasuk::create([
                        'barang_id' => $barang->id,
                        'jumlah_masuk' => $this->jumlah,
                        'harga_beli' => $this->harga_beli,
                        'sisa_stok' => $this->jumlah,
                        'tanggal_masuk' => $this->tanggal,
                    ]);
                }
            } elseif ($this->tipe === 'penghapusan') {
                $barang->stok -= $this->jumlah;
                if ($barang->stok < 0) {
                    $barang->stok = 0;
                }

                // Hitung total_harga dengan FIFO untuk penghapusan baru
                $totalHargaPenghapusan = 0;
                $quantityNeeded = $this->jumlah;
                $persediaans = Persediaan::where('barang_id', $barang->id)
                    ->whereIn('tipe', ['pembelian', 'penambahan_titipan'])
                    ->where('sisa_stok', '>', 0)
                    ->orderBy('tanggal', 'asc')
                    ->orderBy('id', 'asc')
                    ->get();

                // Kembalikan sisa_stok dari entri lama
                if ($persediaan->tipe === 'penghapusan') {
                    $oldQuantity = $persediaan->jumlah;
                    $oldPersediaans = Persediaan::where('barang_id', $barang->id)
                        ->whereIn('tipe', ['pembelian', 'penambahan_titipan'])
                        ->where('tanggal', '<=', $persediaan->tanggal)
                        ->orderBy('tanggal', 'asc')
                        ->orderBy('id', 'asc')
                        ->get();

                    foreach ($oldPersediaans as $oldPersediaan) {
                        if ($oldQuantity <= 0) break;
                        $available = min($oldPersediaan->jumlah - $oldPersediaan->sisa_stok, $oldQuantity);
                        $oldPersediaan->sisa_stok += $available;
                        $oldPersediaan->save();
                        $oldQuantity -= $available;
                    }
                }

                // Alokasikan penghapusan baru dengan FIFO
                foreach ($persediaans as $persediaanItem) {
                    if ($quantityNeeded <= 0) break;
                    $available = min($persediaanItem->sisa_stok, $quantityNeeded);
                    $biayaPokokPerUnit = $persediaanItem->total_harga / $persediaanItem->jumlah;
                    $totalHargaPenghapusan += $available * $biayaPokokPerUnit;
                    $persediaanItem->sisa_stok -= $available;
                    $persediaanItem->save();
                    $quantityNeeded -= $available;
                }

                if ($quantityNeeded > 0) {
                    $this->isLoading = false;
                    $this->dispatch('swal:error', message: 'Stok tidak cukup untuk penghapusan menggunakan FIFO.');
                    $barang->save();
                    return;
                }

                $this->total_harga = $totalHargaPenghapusan;
            } elseif ($this->tipe === 'penambahan_titipan') {
                $barang->stok += $this->jumlah;
                $barang->harga_pokok = $this->harga_beli;
                if (!$kasTitipan) {
                    KasTitipan::create([
                        'barang_id' => $barang->id,
                        'saldo_kas' => 0.00,
                    ]);
                }
                $stokMasuk = StokMasuk::where('barang_id', $barang->id)
                    ->where('tanggal_masuk', $persediaan->tanggal)
                    ->first();
                if ($stokMasuk) {
                    $stokMasuk->update([
                        'jumlah_masuk' => $this->jumlah,
                        'harga_beli' => $this->harga_beli,
                        'sisa_stok' => $stokMasuk->sisa_stok + ($this->jumlah - $persediaan->jumlah),
                    ]);
                } else {
                    StokMasuk::create([
                        'barang_id' => $barang->id,
                        'jumlah_masuk' => $this->jumlah,
                        'harga_beli' => $this->harga_beli,
                        'sisa_stok' => $this->jumlah,
                        'tanggal_masuk' => $this->tanggal,
                    ]);
                }
            } elseif ($this->tipe === 'pengambilan_titipan') {
                $barang->stok -= $this->jumlah;
                if ($barang->stok < 0) {
                    $barang->stok = 0;
                }
            }

            $barang->save();

            $persediaan->update([
                'barang_id' => $this->barang_id,
                'kelola_id' => Auth::id(),
                'tipe' => $this->tipe,
                'tanggal' => $this->tanggal,
                'jumlah' => $this->jumlah,
                'alasan' => $this->alasan,
                'total_harga' => $this->total_harga,
                'sisa_stok' => in_array($this->tipe, ['pembelian', 'penambahan_titipan']) ? $this->jumlah : $persediaan->sisa_stok,
            ]);
        }

        $this->resetForm();
        $this->dispatch('swal:success', message: 'Persediaan berhasil diperbarui.');
        $this->isLoading = false;
    }

    public function updateBarangHargaPokok($barang_id, $harga_beli)
    {
        $barang = Barang::find($barang_id);
        if ($barang) {
            $barang->harga_pokok = $harga_beli;
            $barang->save();
        }
            }

    public function confirmDelete($id)
    {
        $persediaan = Persediaan::find($id);
        if ($persediaan) {
            $this->dispatch('swal:confirmDeletePersediaan', id: $id);
        } else {
            $this->dispatch('swal:error', message: 'Data persediaan tidak ditemukan.');
        }
    }

    public function deletePersediaan($id)
    {
        $this->isLoading = true;
        $persediaan = Persediaan::find($id);
        if ($persediaan) {
            $barang = Barang::find($persediaan->barang_id);

            if ($persediaan->tipe === 'pembelian') {
                $barang->stok -= $persediaan->jumlah;
                $stokMasuk = StokMasuk::where('barang_id', $barang->id)
                    ->where('tanggal_masuk', $persediaan->tanggal)
                    ->first();
                if ($stokMasuk) {
                    $stokMasuk->sisa_stok -= $persediaan->jumlah;
                    if ($stokMasuk->sisa_stok < 0) {
                        $stokMasuk->sisa_stok = 0;
                    }
                    $stokMasuk->save();
                }
            } elseif ($persediaan->tipe === 'penghapusan') {
                $barang->stok += $persediaan->jumlah;
            } elseif ($persediaan->tipe === 'penambahan_titipan') {
                $barang->stok -= $persediaan->jumlah;
                $stokMasuk = StokMasuk::where('barang_id', $barang->id)
                    ->where('tanggal_masuk', $persediaan->tanggal)
                    ->first();
                if ($stokMasuk) {
                    $stokMasuk->sisa_stok -= $persediaan->jumlah;
                    if ($stokMasuk->sisa_stok < 0) {
                        $stokMasuk->sisa_stok = 0;
                    }
                    $stokMasuk->save();
                }
            } elseif ($persediaan->tipe === 'pengambilan_titipan') {
                $barang->stok += $persediaan->jumlah;
            }

            if ($barang->stok < 0) {
                $barang->stok = 0;
            }

            $barang->save();
            $persediaan->delete();

            $this->reset(['selectedId']);
            $this->dispatch('swal:success', message: 'Persediaan berhasil dihapus.');
        } else {
            $this->dispatch('swal:error', message: 'Data persediaan tidak ditemukan.');
        }
        $this->isLoading = false;
    }

    public function resetForm()
    {
        $this->reset(['barang_id', 'search_query_form', 'search_results', 'tipe', 'tanggal', 'jumlah', 'alasan', 'isEditing', 'selectedId', 'total_harga', 'harga_beli', 'isDataChanged', 'use_calculator', 'pack_amount', 'items_per_pack']);
        $this->tanggal = date('Y-m-d');
        $this->tipe = '';
        $this->search_results = collect();
    }

    public function updatedSearchQueryTable()
    {
        $this->resetPage();
    }

    public function loadActivityLogs()
    {
        return Activity::where('log_name', 'persediaan')
            ->with('causer', 'subject.barang')
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'history_page');
    }

    public function toggleHistory()
    {
        $this->showHistory = !$this->showHistory;
    }

    public function previousHistoryPage()
    {
        $this->setPage(max($this->paginators['history_page'] - 1, 1), 'history_page');
    }

    public function nextHistoryPage()
    {
        $this->setPage($this->paginators['history_page'] + 1, 'history_page');
    }

    public function gotoHistoryPage($page)
    {
        $this->setPage($page, 'history_page');
    }

    public function render()
    {
        $query = Persediaan::query()
            ->with(['barang', 'kelola'])
            ->when($this->search_query_table, function ($q) {
                return $q->whereHas('barang', function ($query) {
                    $query->where('nama', 'like', '%' . $this->search_query_table . '%')
                          ->orWhere('kode_barang', 'like', '%' . $this->search_query_table . '%');
                })->orWhere('tanggal', 'like', '%' . $this->search_query_table . '%');
            })
            ->when($this->tipe_filter !== 'all', function ($q) {
                return $q->where('tipe', $this->tipe_filter);
            })
            ->orderBy('created_at', 'desc');

        $persediaans = $query->paginate(25);

        $activityLogs = $this->showHistory
            ? Activity::where('log_name', 'persediaan')
                ->with('causer', 'subject.barang')
                ->orderBy('created_at', 'desc')
                ->paginate(10, ['*'], 'history_page')
            : collect();

        return view('livewire.admin-persediaan', [
            'persediaans' => $persediaans,
            'activityLogs' => $activityLogs,
            'search_results' => $this->search_results
        ]);
    }
}