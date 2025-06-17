<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;

class AdminDataKaryawan extends Component
{
    use WithPagination;

    // Properti Publik
    public $nama = '';
    public $email = '';
    public $password = '';
    public $status = 'aktif';
    public $role = 'kasir';
    public $tanggal_berhenti = null;
    public $isEditingKaryawan = false;
    public $selectedKaryawanId = null;
    public $roleFilter = 'all';
    public $search = '';

    // Simpan Karyawan
    public function saveKaryawan()
    {
        $this->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email' . ($this->isEditingKaryawan ? ',' . $this->selectedKaryawanId : ''),
            'password' => $this->isEditingKaryawan ? 'nullable|min:8' : 'required|min:8',
            'status' => 'required|in:aktif,berhenti',
            'role' => 'required|in:admin,kasir',
            'tanggal_berhenti' => 'nullable|date|after_or_equal:created_at',
        ]);

        User::create([
            'nama' => $this->nama,
            'email' => $this->email,
            'password' => bcrypt($this->password),
            'role' => $this->role,
            'status' => $this->status,
            'tanggal_berhenti' => $this->status === 'berhenti' ? $this->tanggal_berhenti : null,
        ]);

        $this->reset(['nama', 'email', 'password', 'status', 'role', 'tanggal_berhenti', 'isEditingKaryawan', 'selectedKaryawanId']);
        $this->resetPage();

        $this->dispatch('swal:success', message: 'Karyawan berhasil ditambahkan.');
    }

    
    protected $listeners = [
        'proceedUpdateKaryawan',
    ];
    
    // Edit Karyawan
    public function edit($id)
    {
        $this->selectedKaryawanId = $id;
        $karyawan = User::find($this->selectedKaryawanId);
        if ($karyawan) {
            $this->nama = $karyawan->nama;
            $this->email = $karyawan->email;
            $this->status = $karyawan->status;
            $this->role = $karyawan->role;
            $this->tanggal_berhenti = $karyawan->tanggal_berhenti ? \Carbon\Carbon::parse($karyawan->tanggal_berhenti)->format('Y-m-d') : null;
            $this->isEditingKaryawan = true;
        }
    }

    public function confirmUpdate()
    {
        $this->dispatch('swal:confirmUpdate');
    }

    public function proceedUpdateKaryawan()
    {
        $this->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->selectedKaryawanId,
            'password' => 'nullable|min:8',
            'status' => 'required|in:aktif,berhenti',
            'role' => 'required|in:admin,kasir',
            'tanggal_berhenti' => 'nullable|date|after_or_equal:created_at',
        ]);

        $karyawan = User::find($this->selectedKaryawanId);
        if ($karyawan) {
            $karyawan->update([
                'nama' => $this->nama,
                'email' => $this->email,
                'password' => $this->password ? bcrypt($this->password) : $karyawan->password,
                'status' => $this->status,
                'role' => $this->role,
                'tanggal_berhenti' => $this->status === 'berhenti' ? $this->tanggal_berhenti : null,
            ]);
        }

        $this->reset(['nama', 'email', 'password', 'status', 'role', 'tanggal_berhenti', 'isEditingKaryawan', 'selectedKaryawanId']);
        $this->resetPage();

        $this->dispatch('swal:success', message: 'Karyawan berhasil diperbarui.');
    }

    // Reset Halaman Filter
    public function updatedRoleFilter()
    {
        $this->resetPage();
    }

    // Reset Halaman Pencarian
    public function updatedSearch()
    {
        $this->resetPage();
    }

    // Reset Form
    public function resetForm()
    {
        $this->reset(['nama', 'email', 'password', 'status', 'role', 'tanggal_berhenti', 'isEditingKaryawan', 'selectedKaryawanId']);
        $this->resetPage();
    }

    // Render View
    public function render()
    {
        $query = User::query()
            ->orderBy('created_at', 'desc')
            ->when($this->roleFilter !== 'all', function ($q) {
                return $q->where('role', $this->roleFilter);
            })
            ->when($this->search, function ($q) {
                return $q->where('nama', 'like', '%' . $this->search . '%')
                         ->orWhere('email', 'like', '%' . $this->search . '%')
                         ->orWhere('role', 'like', '%' . $this->search . '%')
                         ->orWhere('status', 'like', '%' . $this->search . '%')
                         ->orWhere('tanggal_berhenti', 'like', '%' . $this->search . '%');
            });

        $karyawan = $query->paginate(10);

        return view('livewire.admin-data-karyawan', [
            'karyawan' => $karyawan,
        ]);
    }
}