<?php

namespace App\Livewire;

use App\Models\Counter as ModelsCounter;
use Livewire\Component;
use Livewire\WithPagination;

class Counter extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $name;
    public $email;
    public $address;
    public $updateData = false;
    public $counterId;
    public $keyword;
    public $counterSelectedId = [];
    public $sortColumn = 'name';
    public $sortDirection = 'asc';
    public function render()
    {
        if ($this->keyword != null) {
            $data = ModelsCounter::where('name', 'like', '%' .  $this->keyword . '%')
                ->orWhere('email', 'like', '%' . $this->keyword . '%')
                ->orWhere('address', 'like', '%' . $this->keyword . '%')
                ->orderBy($this->sortColumn,  $this->sortDirection)
                ->paginate(3);
        } else {
            $data = ModelsCounter::orderBy($this->sortColumn, $this->sortDirection)->paginate(3);
        }

        return view('livewire.counter', ['dataCounter' => $data]);
    }

    public function store()
    {
        $rules = [
            'name' => 'required',
            'email' => 'required',
            'address' => 'required',
        ];

        $message = [
            'name.required' => 'Nama wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak sesuai',
            'address.required' => 'Alamat wajib diisi',
        ];

        $validated = $this->validate($rules, $message);
        ModelsCounter::create($validated);
        session()->flash('success', 'Data berhasil ditambahkan');

        $this->clear();
    }

    public function edit($id)
    {
        $data = ModelsCounter::find($id);

        $this->name = $data->name;
        $this->email = $data->email;
        $this->address = $data->address;


        $this->updateData = true;
        $this->counterId = $id;
    }

    public function update()
    {
        $rules = [
            'name' => 'required',
            'email' => 'required',
            'address' => 'required',
        ];

        $message = [
            'name.required' => 'Nama wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak sesuai',
            'address.required' => 'Alamat wajib diisi',
        ];

        $validated = $this->validate($rules, $message);
        $data = ModelsCounter::find($this->counterId);
        $data->update($validated);
        session()->flash('success', 'Data berhasil diubah');

        $this->clear();
    }

    public function clear()
    {
        $this->name = '';
        $this->email = '';
        $this->address = '';

        $this->counterSelectedId = [];
        $this->updateData = false;
        $this->counterId = '';
    }

    public function delete()
    {
        if ($this->counterId != '') {
            $id = $this->counterId;
            ModelsCounter::find($id)->delete();
        }

        if (count($this->counterSelectedId)) {
            for ($item = 0; $item < count($this->counterSelectedId); $item++) {
                ModelsCounter::find($this->counterSelectedId[$item])->delete();
            }
        }
        session()->flash('success', 'Data berhasil dihapus');

        $this->clear();
    }

    public function deleteConfirm($id)
    {
        if ($id != '') {
            $this->counterId = $id;
        }
    }

    public function sort($columnName)
    {
        $this->sortColumn = $columnName;
        $this->sortDirection = $this->sortDirection == 'asc' ? 'desc' : 'asc';
    }
}
