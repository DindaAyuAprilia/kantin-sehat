<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Barang;
use App\Models\KasTitipan;
use App\Models\Persediaan;
use App\Models\HasilBagi;
use App\Models\StokMasuk;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AdminBarang extends Component
{
    use WithPagination;

    public $hasilBagis;
    public $kode_barang = '';
    public $nama = '';
    public $harga_pokok = '';
    public $harga_jual = '';
    public $stok = 0;
    public $is_active = true;
    public $status_titipan = false;
    public $tipe_barang = 'lainnya';
    public $hasil_bagi_id = null;
    public $tipe_hasil_bagi = '';
    public $isLoading = false;
    public $isEditing = false;
    public $selectedId = null;
    public $isEditingHasilBagi = false;
    public $selectedHasilBagiId = null;
    public $activeTab = 'barang';
    public $search = '';
    public $filter_tipe_barang = '';
    public $use_unit_calculator = 1;
    public $pack_amount = '';
    public $items_per_pack = '';
    public $total_purchase_price = '';
    public $use_discount = false;
    public $discount_amount = 0; 


    protected $listeners = [
        'proceedUpdateBarang' => 'proceedUpdateBarang',
        'proceedUpdateHasilBagi' => 'proceedUpdateHasilBagi',
        'toggleActiveBarang' => 'toggleActiveBarang',
    ];

    public function mount()
    {
        $this->isLoading = true;
        $this->hasilBagis = HasilBagi::all();
        $this->kode_barang = $this->generateUniqueBarcode();
        $this->isLoading = false;
        $this->use_unit_calculator = 1;
    }

    public function generateUniqueBarcode($length = 9)
    {
        do {
            $min = pow(10, $length - 1);
            $max = pow(10, $length) - 1;
            $barcode = mt_rand($min, $max);
        } while (Barang::where('kode_barang', $barcode)->exists());

        return $barcode;
    }

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function updatedStatusTitipan($value)
    {
        $this->isLoading = true;
        $this->resetErrorBag('status_titipan');

        if ($value) {
            $this->tipe_barang = 'titipan';
            if (!$this->kode_barang) {
                $this->kode_barang = $this->generateUniqueBarcode();
            }
        } else {
            $this->tipe_barang = 'lainnya';
            if (!$this->kode_barang) {
                $this->kode_barang = $this->generateUniqueBarcode();
            }
            $this->hasil_bagi_id = null;
        }

        $this->isLoading = false;
    }

    public function updatedPackAmount()
    {
        $this->calculateUnitValues();
    }

    public function updatedItemsPerPack()
    {
        $this->calculateUnitValues();
    }

    public function updatedTotalPurchasePrice()
    {
        $this->calculateUnitValues();
    }

    protected function calculateUnitValues()
    {
        if (!$this->use_unit_calculator) {
            $packAmount = (float) $this->pack_amount;
            $itemsPerPack = (float) $this->items_per_pack;
            $totalPrice = (float) $this->total_purchase_price;
            $discountAmount = $this->use_discount ? (float) $this->discount_amount : 0;

            $this->stok = $packAmount * $itemsPerPack;
            $this->stok = $this->stok > 0 ? (int) $this->stok : 0;
            $adjustedTotalPrice = max(0, $totalPrice - $discountAmount);
            $this->harga_pokok = ($this->stok > 0 && $adjustedTotalPrice > 0) ? $adjustedTotalPrice / $this->stok : 0;
            $this->total_purchase_price = $adjustedTotalPrice;
        }
    }

    public function save()
    {
        $this->isLoading = true;

        $this->calculateUnitValues();

        $this->validate([
            'kode_barang' => 'required|unique:barangs,kode_barang' . ($this->isEditing ? ',' . $this->selectedId : ''),
            'nama' => 'required|string|max:255',
            'harga_pokok' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'status_titipan' => 'boolean',
            'tipe_barang' => 'required|in:snack,minuman,kebutuhan,lainnya,titipan',
            'hasil_bagi_id' => 'required_if:status_titipan,1|nullable|exists:hasil_bagis,id',
            'pack_amount' => 'nullable|integer|min:0',
            'items_per_pack' => 'nullable|integer|min:0',
            'total_purchase_price' => 'nullable|numeric|min:0',
            'discount_amount' => 'nullable|numeric|min:0',
        ]); 

        // Hitung nilai untuk mode kalkulator otomatis
        if (!$this->use_unit_calculator) {
            $this->calculateUnitValues();
        } else {
            $totalPurchasePrice = (float) $this->total_purchase_price;
            $discountAmount = $this->use_discount ? (float) $this->discount_amount : 0;
            $this->total_purchase_price = $totalPurchasePrice + (3 * $discountAmount);
        }

        $barang = Barang::create([
            'kode_barang' => $this->kode_barang,
            'nama' => $this->nama,
            'harga_pokok' => $this->harga_pokok,
            'harga_jual' => $this->harga_jual,
            'stok' => $this->stok,
            'is_active' => $this->is_active,
            'status_titipan' => $this->status_titipan,
            'tipe_barang' => $this->status_titipan ? 'titipan' : $this->tipe_barang,
            'hasil_bagi_id' => $this->status_titipan ? $this->hasil_bagi_id : null,
        ]);

        // Simpan stok masuk
        StokMasuk::create([
            'barang_id' => $barang->id,
            'jumlah_masuk' => $this->stok,
            'harga_beli' => $this->harga_pokok, 
            'sisa_stok' => $this->stok,
            'tanggal_masuk' => Carbon::now(),
        ]);

        if ($this->status_titipan) {
            KasTitipan::create([
                'barang_id' => $barang->id,
                'saldo_kas' => 0.00,
            ]);

            Persediaan::create([
                'barang_id' => $barang->id,
                'kelola_id' => Auth::id(),
                'tipe' => 'penambahan_titipan',
                'tanggal' => Carbon::now(),
                'jumlah' => $this->stok,
                'alasan' => 'Penambahan awal barang titipan',
                'total_harga' => $this->total_purchase_price,
                'sisa_stok' => $this->stok,
            ]);
        } else {
            Persediaan::create([
                'barang_id' => $barang->id,
                'kelola_id' => Auth::id(),
                'tipe' => 'pembelian',
                'tanggal' => Carbon::now(),
                'jumlah' => $this->stok,
                'alasan' => 'Pembelian awal stok barang',
                'total_harga' => $this->total_purchase_price,
                'sisa_stok' => $this->stok,
            ]);
        }

        $this->use_discount = false;
        $this->discount_amount = 0;

        $this->resetForm();
        $this->dispatch('swal:success', message: 'Barang berhasil ditambahkan.');
        $this->isLoading = false;
    }

    public function editBarang($id)
    {
        $this->isLoading = true;
        $this->selectedId = $id;
        $barang = Barang::find($id);
        if ($barang) {
            $this->kode_barang = $barang->kode_barang;
            $this->nama = $barang->nama;
            $this->harga_pokok = $barang->harga_pokok;
            $this->harga_jual = $barang->harga_jual;
            $this->stok = $barang->stok;
            $this->is_active = $barang->is_active;
            $this->status_titipan = $barang->status_titipan;
            $this->tipe_barang = $barang->tipe_barang;
            $this->hasil_bagi_id = $barang->hasil_bagi_id;
            $this->isEditing = true;
        }
        $this->isLoading = false;
    }

    public function confirmUpdate()
    {
        $this->dispatch('swal:confirmUpdateBarang');
    }

    public function proceedUpdateBarang()
    {
        $this->isLoading = true;
        $this->validate([
            'kode_barang' => 'required|unique:barangs,kode_barang,' . $this->selectedId,
            'nama' => 'required|string|max:255',
            'harga_pokok' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0',
            'status_titipan' => 'boolean',
            'tipe_barang' => 'required|in:snack,minuman,kebutuhan,lainnya,titipan',
            'hasil_bagi_id' => 'required_if:status_titipan,1|nullable|exists:hasil_bagis,id',
        ]);

        $barang = Barang::find($this->selectedId);
        if ($barang) {
            $kasTitipan = KasTitipan::where('barang_id', $barang->id)->first();

            if ($this->status_titipan && !$kasTitipan) {
                KasTitipan::create([
                    'barang_id' => $barang->id,
                    'saldo_kas' => 0.00,
                ]);
            }

            $barang->update([
                'kode_barang' => $this->kode_barang,
                'nama' => $this->nama,
                'harga_pokok' => $this->harga_pokok,
                'harga_jual' => $this->harga_jual,
                'stok' => $barang->stok,
                'is_active' => $this->is_active,
                'status_titipan' => $this->status_titipan,
                'tipe_barang' => $this->status_titipan ? 'titipan' : $this->tipe_barang,
                'hasil_bagi_id' => $this->status_titipan ? $this->hasil_bagi_id : null,
            ]);
        }

        $this->resetForm();
        $this->dispatch('swal:success', message: 'Barang berhasil diperbarui.');
        $this->isLoading = false;
    }

    public function confirmToggleActive($id)
    {
        $this->selectedId = $id;
        $barang = Barang::find($id);
        if ($barang) {
            $this->dispatch('swal:confirmToggleActive', id: $id, is_active: $barang->is_active);
        }
    }

    public function toggleActiveBarang($id)
    {
        $this->isLoading = true;
        $barang = Barang::find($id);
        if ($barang) {
            $barang->is_active = !$barang->is_active;
            $barang->save();
            $this->dispatch('swal:success', message: 'Status barang berhasil diubah.');
        } else {
            $this->dispatch('swal:error', message: 'Barang tidak ditemukan.');
        }
        $this->isLoading = false;
    }

    public function saveHasilBagi()
    {
        $this->isLoading = true;
        $this->validate([
            'tipe_hasil_bagi' => 'required|numeric|min:100',
        ]);

        HasilBagi::create([
            'tipe' => $this->tipe_hasil_bagi,
        ]);

        $this->reset(['tipe_hasil_bagi', 'isEditingHasilBagi', 'selectedHasilBagiId']);
        $this->mount();
        $this->dispatch('swal:success', message: 'Hasil bagi berhasil ditambahkan.');
        $this->isLoading = false;
    }

    public function editHasilBagi($id)
    {
        $this->isLoading = true;
        $this->selectedHasilBagiId = $id;
        $hasilBagi = HasilBagi::find($id);
        if ($hasilBagi) {
            $this->tipe_hasil_bagi = $hasilBagi->tipe;
            $this->isEditingHasilBagi = true;
        }
        $this->isLoading = false;
    }

    public function confirmUpdateHasilBagi()
    {
        $this->dispatch('swal:confirmUpdateHasilBagi');
    }

    public function proceedUpdateHasilBagi()
    {
        $this->isLoading = true;
        $this->validate([
            'tipe_hasil_bagi' => 'required|numeric|min:100',
        ]);

        $hasilBagi = HasilBagi::find($this->selectedHasilBagiId);
        if ($hasilBagi) {
            $hasilBagi->update([
                'tipe' => $this->tipe_hasil_bagi,
            ]);
        }

        $this->reset(['tipe_hasil_bagi', 'isEditingHasilBagi', 'selectedHasilBagiId']);
        $this->mount();
        $this->dispatch('swal:success', message: 'Hasil bagi berhasil diperbarui.');
        $this->isLoading = false;
    }

    public function printAllTitipanBarcodes()
    {
        $this->isLoading = true;

        $query = Barang::query()
            ->where('is_active', true)
            ->when($this->filter_tipe_barang, function ($q) {
                return $q->where('tipe_barang', $this->filter_tipe_barang);
            })
            ->orderBy('nama', 'asc');

        $barangs = $query->get();

        if ($barangs->isEmpty()) {
            $this->dispatch('swal:error', message: 'Tidak ada barang yang sesuai untuk dicetak barcode-nya.');
            $this->isLoading = false;
            return;
        }

        foreach ($barangs as $barang) {
            if (empty($barang->kode_barang)) {
                $barang->kode_barang = $this->generateUniqueBarcode();
                $barang->save();
            }
        }

        $htmlContent = $this->generateBarcodeHtml($barangs);

        $reportKey = 'barcode_report_' . now()->format('YmdHis');
        Session::put($reportKey, $htmlContent);

        $this->redirect(route('report.view', ['key' => $reportKey]), navigate: false);
        $this->isLoading = false;
    }

    private function generateBarcodeHtml($barangs)
    {
        $html = <<<HTML
    <!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Cetak Barcode Barang</title>
        <style>
            body {
                font-family: 'Arial', sans-serif;
                margin: 0;
                padding: 5mm;
                background-color: #fff;
            }
            .container {
                max-width: 210mm;
                margin: 0 auto;
            }
            h1 {
                text-align: center;
                color: #007022;
                font-size: 16px;
                margin-bottom: 5mm;
            }
            .barcode-grid {
                display: grid;
                grid-template-columns: repeat(4, 1fr);
                gap: 2mm;
                page-break-after: always;
            }
            .barcode-item {
                background-color: #fff;
                border: 1px solid #007022;
                border-radius: 2mm;
                padding: 2mm;
                text-align: center;
                height: 35mm;
                display: flex;
                flex-direction: column;
                justify-content: space-between;
                box-sizing: border-box;
            }
            .barcode-item p {
                margin: 1mm 0;
                font-size: 8px;
                color: #1f2937;
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap;
            }
            .barcode-item p strong {
                color: #007022;
            }
            .barcode-item svg {
                width: 100%;
                height: 18mm;
            }
            .print-button {
                display: block;
                width: 120px;
                margin: 5mm auto 0;
                padding: 3mm 8mm;
                background-color: #007022;
                color: #fff;
                border: none;
                border-radius: 2mm;
                font-size: 12px;
                cursor: pointer;
            }
            .print-button:hover {
                background-color: #005b1a;
            }
            @media print {
                body {
                    margin: 0;
                    padding: 0;
                }
                .container {
                    padding: 3mm;
                }
                .barcode-grid {
                    gap: 1mm;
                }
                .barcode-item {
                    page-break-inside: avoid;
                    box-shadow: none;
                }
                .print-button {
                    display: none;
                }
                @page {
                    size: A4;
                    margin: 5mm;
                }
                /* Support for F4 paper */
                @media print and (min-height: 330mm) {
                    @page {
                        size: 210mm 330mm;
                        margin: 5mm;
                    }
                }
            }
        </style>
        <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>
    </head>
    <body>
        <div class="container">
            <h1>Daftar Barcode Barang</h1>
    HTML;

        if ($barangs->isEmpty()) {
            $html .= '<p style="text-align: center; color: #1f2937;">Tidak ada data barang untuk ditampilkan.</p>';
        } else {
            $itemsPerPage = 24; // 4x6 grid
            $chunks = $barangs->chunk($itemsPerPage);

            foreach ($chunks as $index => $chunk) {
                if ($index > 0) {
                    $html .= '</div></div><div class="container"><h1>Daftar Barcode Barang (Lanjutan)</h1>';
                }
                $html .= '<div class="barcode-grid">';
                foreach ($chunk as $barang) {
                    $html .= <<<HTML
                <div class="barcode-item">
                    <p><strong>{$barang->nama}</strong></p>
                    <p>Kode: {$barang->kode_barang}</p>
                    <svg id="barcode-{$barang->id}"></svg>
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            JsBarcode("#barcode-{$barang->id}", "{$barang->kode_barang}", {
                                format: "CODE128",
                                width: 1.2,
                                height: 40,
                                displayValue: true,
                                fontSize: 8
                            });
                        });
                    </script>
                </div>
    HTML;
                }
                $html .= '</div>';
            }
        }

        $html .= <<<HTML
            <button class="print-button" onclick="window.print()">Cetak Barcode</button>
        </div>
    </body>
    </html>
    HTML;

        return $html;
    }

    public function resetForm()
    {
        $this->reset(['kode_barang', 'nama', 'harga_pokok', 'harga_jual', 'stok', 'is_active', 'status_titipan', 'tipe_barang', 'hasil_bagi_id', 'isEditing', 'selectedId', 'use_unit_calculator', 'pack_amount', 'items_per_pack', 'total_purchase_price',]);
        $this->kode_barang = $this->generateUniqueBarcode();
        $this->tipe_barang = 'lainnya';
        $this->status_titipan = 0; // Set status_titipan ke 'Tidak'
        $this->is_active = true;
        $this->use_unit_calculator = 1;
        $this->pack_amount = 0;
        $this->items_per_pack = 0;
        $this->total_purchase_price = 0;
        $this->use_discount = false;
        $this->discount_amount = 0;
        $this->dispatch('resetForm');
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedFilterTipeBarang()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Barang::with('hasilBagi')
            ->when($this->search, function ($q) {
                return $q->where('kode_barang', 'like', '%' . $this->search . '%')
                    ->orWhere('nama', 'like', '%' . $this->search . '%');
            })
            ->when($this->filter_tipe_barang, function ($q) {
                return $q->where('tipe_barang', $this->filter_tipe_barang);
            });

        $paginator = $query->paginate(25);

        return view('livewire.admin-barang', [
            'barangs' => $paginator,
        ]);
    }
}