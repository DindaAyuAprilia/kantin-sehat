<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use App\Models\GajiPembayaran;
use App\Models\Kas;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class AdminGaji extends Component
{
    use WithPagination;

    // Deklarasi properti komponen
    public $kasirs = [];
    public $selectedKasirId;
    public $jumlah;
    public $tanggal_pembayaran;
    public $isModifyingPembayaran = false;
    public $selectedPaymentId;
    public $isLoading = false;
    public $search = '';

    // Mendefinisikan listener untuk event
    protected $listeners = [
        'deletePembayaran',
        'proceedUpdatePembayaran',
    ];

    // Inisialisasi data saat komponen dimuat
    public function mount()
    {
        $this->isLoading = true;
        $this->kasirs = User::where('status', 'aktif')->where('role', 'kasir')->get();
        $this->tanggal_pembayaran = Carbon::now()->format('Y-m-d');
        $this->isLoading = false;
    }

    // Menyimpan data pembayaran gaji baru
    public function savePembayaran()
    {
        $this->isLoading = true;

        // Validasi input
        $this->validate([
            'selectedKasirId' => 'required|exists:users,id',
            'jumlah' => 'required|numeric|min:1',
            'tanggal_pembayaran' => 'required|date',
        ]);

        // Periksa saldo kas
        $currentKas = Kas::first() ?? new Kas(['saldo_kas' => 0]);
        if ($currentKas->saldo_kas < $this->jumlah) {
            $this->dispatch('swal:success', message: 'Pembayaran gaji gagal dicatat: Saldo kas tidak cukup.');
            $this->isLoading = false;
            return;
        }

        // Kurangi saldo kas
        $currentKas->saldo_kas -= $this->jumlah;
        $currentKas->save();

        // Simpan data pembayaran gaji
        GajiPembayaran::create([
            'karyawan_id' => $this->selectedKasirId,
            'admin_id' => Auth::id(),
            'tanggal_pembayaran' => $this->tanggal_pembayaran,
            'jumlah' => $this->jumlah,
            'periode_bulan' => Carbon::parse($this->tanggal_pembayaran)->format('F Y'),
        ]);

        // Reset form setelah simpan
        $this->resetForm();
        $this->dispatch('swal:success', message: 'Pembayaran gaji berhasil dicatat.');
        $this->isLoading = false;
    }

    // Mengedit data pembayaran gaji
    public function editPembayaran($id)
    {
        $this->isLoading = true;
        $payment = GajiPembayaran::find($id);
        if ($payment) {
            $this->selectedPaymentId = $id;
            $this->selectedKasirId = $payment->karyawan_id;
            $this->jumlah = $payment->jumlah;
            $this->tanggal_pembayaran = Carbon::parse($payment->tanggal_pembayaran)->format('Y-m-d');
            $this->isModifyingPembayaran = true;
        }
        $this->isLoading = false;
    }

    // Konfirmasi pembaruan data
    public function confirmUpdate()
    {
        $this->dispatch('swal:confirmUpdate');
    }

    // Proses pembaruan data pembayaran
    public function proceedUpdatePembayaran()
    {
        $this->isLoading = true;

        // Validasi input
        $this->validate([
            'selectedKasirId' => 'required|exists:users,id',
            'jumlah' => 'required|numeric|min:1',
            'tanggal_pembayaran' => 'required|date',
        ]);

        $payment = GajiPembayaran::find($this->selectedPaymentId);
        if ($payment) {
            // Perbarui saldo kas
            $currentKas = Kas::first() ?? new Kas(['saldo_kas' => 0]);
            $currentKas->saldo_kas += $payment->jumlah;
            if ($currentKas->saldo_kas < $this->jumlah) {
                $this->dispatch('swal:success', message: 'Pembayaran gaji gagal diperbarui: Saldo kas tidak cukup.');
                $this->isLoading = false;
                return;
            }
            $currentKas->saldo_kas -= $this->jumlah;
            $currentKas->save();

            // Perbarui data pembayaran
            $payment->update([
                'karyawan_id' => $this->selectedKasirId,
                'admin_id' => Auth::id(),
                'tanggal_pembayaran' => $this->tanggal_pembayaran,
                'jumlah' => $this->jumlah,
                'periode_bulan' => Carbon::parse($this->tanggal_pembayaran)->format('F Y'),
            ]);
        }

        // Reset form setelah pembaruan
        $this->resetForm();
        $this->dispatch('swal:success', message: 'Pembayaran gaji berhasil diperbarui.');
        $this->isLoading = false;
    }

    // Konfirmasi penghapusan data
    public function confirmDelete($id)
    {
        $this->dispatch('swal:confirmDelete', id: $id);
    }

    // Menghapus data pembayaran
    public function deletePembayaran($id)
    {
        $this->isLoading = true;
        $payment = GajiPembayaran::find($id);
        if ($payment) {
            // Kembalikan saldo kas
            $currentKas = Kas::first() ?? new Kas(['saldo_kas' => 0]);
            $currentKas->saldo_kas += $payment->jumlah;
            $currentKas->save();

            // Hapus data pembayaran
            $payment->delete();
            $this->dispatch('swal:success', message: 'Pembayaran gaji berhasil dihapus.');
        }
        $this->isLoading = false;
    }

    // Reset input form
    public function resetForm()
    {
        $this->selectedKasirId = null;
        $this->jumlah = null;
        $this->tanggal_pembayaran = Carbon::now()->format('Y-m-d');
        $this->isModifyingPembayaran = false;
        $this->selectedPaymentId = null;
    }

    // Memperbarui pencarian
    public function updatedSearch()
    {
        $this->resetPage();
    }

    // Render tampilan dengan data pembayaran
    public function render()
    {
        $query = GajiPembayaran::with(['karyawan', 'admin'])
            ->orderBy('tanggal_pembayaran', 'desc')
            ->when($this->search, function ($q) {
                return $q->whereHas('karyawan', function ($query) {
                    $query->where('nama', 'like', '%' . $this->search . '%')
                          ->orWhere('email', 'like', '%' . $this->search . '%');
                })
                ->orWhereHas('admin', function ($query) {
                    $query->where('nama', 'like', '%' . $this->search . '%');
                })
                ->orWhere('tanggal_pembayaran', 'like', '%' . $this->search . '%')
                ->orWhere('jumlah', 'like', '%' . $this->search . '%');
            });

        $paymentHistory = $query->paginate(10);

        return view('livewire.admin-gaji', [
            'paymentHistory' => $paymentHistory,
        ]);
    }
}