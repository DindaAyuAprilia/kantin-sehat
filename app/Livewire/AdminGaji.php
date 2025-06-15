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

    public $kasirs = [];
    public $selectedKasirId;
    public $jumlah;
    public $tanggal_pembayaran;
    public $isModifyingPembayaran = false;
    public $selectedPaymentId;
    public $isLoading = false;
    public $search = '';

    protected $listeners = [
        'deletePembayaran',
        'proceedUpdatePembayaran',
    ];

    public function mount()
    {
        $this->isLoading = true;
        $this->kasirs = User::where('status', 'aktif')->where('role', 'kasir')->get();
        $this->tanggal_pembayaran = Carbon::now()->format('Y-m-d');
        $this->isLoading = false;
    }

    public function savePembayaran()
    {
        $this->isLoading = true;

        $this->validate([
            'selectedKasirId' => 'required|exists:users,id',
            'jumlah' => 'required|numeric|min:1',
            'tanggal_pembayaran' => 'required|date',
        ]);

        $currentKas = Kas::first() ?? new Kas(['saldo_kas' => 0]);
        if ($currentKas->saldo_kas < $this->jumlah) {
            $this->dispatch('swal:success', message: 'Pembayaran gaji gagal dicatat: Saldo kas tidak cukup.');
            $this->isLoading = false;
            return;
        }

        $currentKas->saldo_kas -= $this->jumlah;
        $currentKas->save();

        GajiPembayaran::create([
            'karyawan_id' => $this->selectedKasirId,
            'admin_id' => Auth::id(),
            'tanggal_pembayaran' => $this->tanggal_pembayaran,
            'jumlah' => $this->jumlah,
            'periode_bulan' => Carbon::parse($this->tanggal_pembayaran)->format('F Y'),
        ]);

        $this->resetForm();
        $this->dispatch('swal:success', message: 'Pembayaran gaji berhasil dicatat.');
        $this->isLoading = false;
    }

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

    public function confirmUpdate()
    {
        $this->dispatch('swal:confirmUpdate');
    }

    public function proceedUpdatePembayaran()
    {
        $this->isLoading = true;

        $this->validate([
            'selectedKasirId' => 'required|exists:users,id',
            'jumlah' => 'required|numeric|min:1',
            'tanggal_pembayaran' => 'required|date',
        ]);

        $payment = GajiPembayaran::find($this->selectedPaymentId);
        if ($payment) {
            $currentKas = Kas::first() ?? new Kas(['saldo_kas' => 0]);
            // Kembalikan jumlah lama ke kas
            $currentKas->saldo_kas += $payment->jumlah;
            // Periksa apakah saldo cukup untuk jumlah baru
            if ($currentKas->saldo_kas < $this->jumlah) {
                $this->dispatch('swal:success', message: 'Pembayaran gaji gagal diperbarui: Saldo kas tidak cukup.');
                $this->isLoading = false;
                return;
            }
            // Kurangi jumlah baru dari kas
            $currentKas->saldo_kas -= $this->jumlah;
            $currentKas->save();

            $payment->update([
                'karyawan_id' => $this->selectedKasirId,
                'admin_id' => Auth::id(),
                'tanggal_pembayaran' => $this->tanggal_pembayaran,
                'jumlah' => $this->jumlah,
                'periode_bulan' => Carbon::parse($this->tanggal_pembayaran)->format('F Y'),
            ]);
        }

        $this->resetForm();
        $this->dispatch('swal:success', message: 'Pembayaran gaji berhasil diperbarui.');
        $this->isLoading = false;
    }

    public function confirmDelete($id)
    {
        $this->dispatch('swal:confirmDelete', id: $id);
    }

    public function deletePembayaran($id)
    {
        $this->isLoading = true;
        $payment = GajiPembayaran::find($id);
        if ($payment) {
            $currentKas = Kas::first() ?? new Kas(['saldo_kas' => 0]);
            // Kembalikan jumlah pembayaran ke kas
            $currentKas->saldo_kas += $payment->jumlah;
            $currentKas->save();

            $payment->delete();
            $this->dispatch('swal:success', message: 'Pembayaran gaji berhasil dihapus.');
        }
        $this->isLoading = false;
    }

    public function resetForm()
    {
        $this->selectedKasirId = null;
        $this->jumlah = null;
        $this->tanggal_pembayaran = Carbon::now()->format('Y-m-d');
        $this->isModifyingPembayaran = false;
        $this->selectedPaymentId = null;
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

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