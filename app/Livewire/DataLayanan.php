<?php

namespace App\Livewire;

use App\Models\Layanan;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;

class DataLayanan extends Component
{
    use WithPagination, WithoutUrlPagination;

    public $search = '';
    public $paginate = 5;
    public $modalOpen = false;
    public $modalMode = 'create'; // or 'edit' or 'view'
    public $currentId = null;

    public $nama, $deskripsi, $harga;

    protected $paginationTheme = 'tailwind';

    protected $rules = [
        'nama' => 'required|string|max:255',
        'deskripsi' => 'nullable|string',
        'harga' => 'required|numeric',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function openModal($mode = 'create', $id = null)
    {
        $this->resetValidation();
        $this->reset(['nama', 'deskripsi', 'harga']);
        $this->modalMode = $mode;
        $this->modalOpen = true;

        if ($id) {
            $layanan = Layanan::findOrFail($id);
            $this->currentId = $id;
            $this->nama = $layanan->nama;
            $this->deskripsi = $layanan->deskripsi;
            $this->harga = $layanan->harga;
        }
    }

    public function closeModal()
    {
        $this->modalOpen = false;
        $this->reset(['nama', 'deskripsi', 'harga', 'currentId']);
    }

    public function save()
    {
        $this->validate();

        if ($this->modalMode === 'edit' && $this->currentId) {
            $layanan = Layanan::findOrFail($this->currentId);
        } else {
            $layanan = new Layanan();
        }

        $layanan->nama = $this->nama;
        $layanan->deskripsi = $this->deskripsi;
        $layanan->harga = $this->harga;
        $layanan->save();
        $this->dispatch('toast', title: 'Data layanan disimpan', icon: 'success');
        $this->closeModal();
    }

    public function delete($id)
    {
        $layanan = Layanan::findOrFail($id);
        $layanan->delete();
        $this->dispatch('toast', title: 'Layanan dihapus', icon: 'success');
    }

    public function render()
    {
        $layanans = Layanan::where('nama', 'like', '%' . $this->search . '%')
            ->orWhere('deskripsi', 'like', '%' . $this->search . '%')
            ->paginate($this->paginate);

        return view('livewire.data-layanan', compact('layanans'));
    }
}
