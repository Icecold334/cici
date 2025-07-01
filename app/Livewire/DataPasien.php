<?php

namespace App\Livewire;

use App\Models\Pasien;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;

class DataPasien extends Component
{
    use WithPagination, WithoutUrlPagination;

    public $search = '';
    public $paginate = 5;
    public $modalOpen = false;
    public $modalMode = 'create';
    public $currentId = null;

    public $nama, $alamat, $tlahir, $nohp;

    protected $paginationTheme = 'tailwind';

    protected $rules = [
        'nama' => 'required|string|max:255',
        'alamat' => 'required|string|max:255',
        'tlahir' => 'required|date',
        'nohp' => 'required|string|max:20',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function openModal($mode = 'create', $id = null)
    {
        $this->resetValidation();
        $this->reset(['nama', 'alamat', 'tlahir', 'nohp']);
        $this->modalMode = $mode;
        $this->modalOpen = true;

        if ($id) {
            $pasien = Pasien::findOrFail($id);
            $this->currentId = $id;
            $this->nama = $pasien->nama;
            $this->alamat = $pasien->alamat;
            $this->tlahir = $pasien->tlahir->format('Y-m-d');
            $this->nohp = $pasien->nohp;
        }
    }

    public function closeModal()
    {
        $this->modalOpen = false;
        $this->reset(['nama', 'alamat', 'tlahir', 'nohp', 'currentId']);
    }

    public function showPasien($id)
    {
        return redirect()->to('/pasien/show/' . $id);
    }

    public function save()
    {
        $this->validate();

        if ($this->modalMode === 'edit' && $this->currentId) {
            $pasien = Pasien::findOrFail($this->currentId);
        } else {
            $pasien = new Pasien();
        }

        $pasien->nama = $this->nama;
        $pasien->alamat = $this->alamat;
        $pasien->tlahir = $this->tlahir;
        $pasien->nohp = $this->nohp;
        $pasien->save();

        $this->closeModal();
    }

    public function delete($id)
    {
        $pasien = Pasien::findOrFail($id);
        $pasien->delete();
    }

    public function render()
    {
        $pasiens = Pasien::where('nama', 'like', '%' . $this->search . '%')
            ->orWhere('alamat', 'like', '%' . $this->search . '%')->orderBy('nama')
            ->paginate($this->paginate);

        return view('livewire.data-pasien', compact('pasiens'));
    }
}
