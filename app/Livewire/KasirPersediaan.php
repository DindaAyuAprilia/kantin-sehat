<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Barang;

class KasirPersediaan extends Component
{
    public $barangs;
    public $search_query = '';

    public function mount()
    {
        $this->loadBarangs();
    }

    public function updatedSearchQuery($value)
    {
        $this->loadBarangs();
    }

    public function loadBarangs()
    {
        $this->barangs = Barang::query()
            ->where(function ($query) {
                $query->where('nama', 'like', '%' . $this->search_query . '%')
                    ->orWhere('kode_barang', 'like', '%' . $this->search_query . '%');
            })
            ->get();
    }

    public function render()
    {
        return view('livewire.kasir-persediaan');
    }
}