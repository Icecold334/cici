<?php

namespace App\Livewire;

use App\Models\Layanan;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class DataLayanan extends Component
{
    use WithPagination, WithoutUrlPagination;

    public $search = '';
    public $paginate = 5;

    protected $paginationTheme = 'tailwind'; // agar cocok dengan Tailwind CSS

    public function updatingSearch()
    {
        $this->resetPage(); // reset ke halaman 1 saat search berubah
    }

    public function render()
    {
        $layanans = Layanan::where('nama', 'like', '%' . $this->search . '%')
            ->orWhere('deskripsi', 'like', '%' . $this->search . '%')
            ->paginate($this->paginate);

        return view('livewire.data-layanan', compact('layanans'));
    }
}
