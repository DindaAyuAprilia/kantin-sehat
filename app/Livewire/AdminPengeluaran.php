<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Pengeluaran;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class AdminPengeluaran extends Component
{
    use WithPagination;

    public $tanggal;
    public $deskripsi;
    public $jumlah;
    public $isLoading = false;
    public $search = '';
    public $selectedMonth;
    public $isEditing = false;
    public $selectedId = null;
    public $isDeleting = false;

    protected $listeners = [
        'proceedUpdate' => 'proceedUpdate',
        'proceedDelete' => 'proceedDelete',
    ];

    public function mount()
    {
        $this->tanggal = date('Y-m-d');
        $this->selectedMonth = date('Y-m');
    }

    public function updatedSelectedMonth()
    {
        $this->resetPage();
    }

    public function save()
    {
        $this->isLoading = true;
        $this->validate([
            'tanggal' => 'required|date',
            'deskripsi' => 'required|string|max:255',
            'jumlah' => 'required|numeric|min:0',
        ]);

        if ($this->isEditing) {
            $this->confirmUpdate();
        } else {
            Pengeluaran::create([
                'tanggal' => $this->tanggal,
                'deskripsi' => $this->deskripsi,
                'jumlah' => $this->jumlah,
                'user_id' => Auth::id(),
            ]);

            $this->resetForm();
            $this->dispatch('swal:success', message: 'Pengeluaran berhasil ditambahkan.');
        }
        $this->isLoading = false;
    }

    public function editPengeluaran($id)
    {
        $this->isLoading = true;
        $this->selectedId = $id;
        $pengeluaran = Pengeluaran::find($id);
        if ($pengeluaran) {
            $this->tanggal = $pengeluaran->tanggal;
            $this->deskripsi = $pengeluaran->deskripsi;
            $this->jumlah = $pengeluaran->jumlah;
            $this->isEditing = true;
        }
        $this->isLoading = false;
    }

    public function confirmUpdate()
    {
        $this->dispatch('swal:confirmUpdatePengeluaran');
    }

    public function proceedUpdate()
    {
        $this->isLoading = true;
        $this->validate([
            'tanggal' => 'required|date',
            'deskripsi' => 'required|string|max:255',
            'jumlah' => 'required|numeric|min:0',
        ]);

        $pengeluaran = Pengeluaran::find($this->selectedId);
        if ($pengeluaran) {
            $pengeluaran->update([
                'tanggal' => $this->tanggal,
                'deskripsi' => $this->deskripsi,
                'jumlah' => $this->jumlah,
            ]);
            $this->resetForm();
            $this->dispatch('swal:success', message: 'Pengeluaran berhasil diperbarui.');
        } else {
            $this->dispatch('swal:error', message: 'Pengeluaran tidak ditemukan.');
        }
        $this->isLoading = false;
    }

    public function confirmDelete($id)
    {
        $this->selectedId = $id;
        $this->dispatch('swal:confirmDeletePengeluaran', id: $id);
    }

    public function proceedDelete($id)
    {
        $this->isLoading = true;
        $pengeluaran = Pengeluaran::find($id);
        if ($pengeluaran) {
            $pengeluaran->delete();
            $this->resetForm();
            $this->dispatch('swal:success', message: 'Pengeluaran berhasil dihapus.');
        } else {
            $this->dispatch('swal:error', message: 'Pengeluaran tidak ditemukan.');
        }
        $this->isLoading = false;
    }

    public function resetForm()
    {
        $this->reset(['tanggal', 'deskripsi', 'jumlah', 'isEditing', 'selectedId', 'isDeleting']);
        $this->tanggal = date('Y-m-d');
    }

    public function render()
    {
        $startDate = Carbon::parse($this->selectedMonth)->startOfMonth()->format('Y-m-d');
        $endDate = Carbon::parse($this->selectedMonth)->endOfMonth()->format('Y-m-d');

        $pengeluarans = Pengeluaran::with('user')
            ->when($this->search, function ($query) {
                $query->where('deskripsi', 'like', '%' . $this->search . '%')
                    ->orWhere('tanggal', 'like', '%' . $this->search . '%');
            })
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->orderBy('tanggal', 'desc')
            ->paginate(10);

        return view('livewire.admin-pengeluaran', [
            'pengeluarans' => $pengeluarans,
        ]);
    }
}