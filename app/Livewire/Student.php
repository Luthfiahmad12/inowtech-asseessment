<?php

namespace App\Livewire;

use App\Models\Classroom;
use App\Models\Student as ModelsStudent;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Title;
use Livewire\Component;

class Student extends Component
{
    #[Title('Daftar Siswa')]

    public $search = '';


    public $name, $address, $classroom_id;
    public $edit_id, $edit_name,  $edit_address, $edit_classroom_id;

    protected function rules()
    {
        if ($this->edit_id) {
            return [
                'edit_name' => ['required', Rule::unique('students', 'name')->ignore($this->edit_id)],  // Ignore saat update
                'edit_address' => 'required',
                'edit_classroom_id' => 'required',
            ];
        }
        return [
            'name' => ['required', Rule::unique('students', 'name')],
            'address' => 'required',
            'classroom_id' => 'required',
        ];
    }

    public function save()
    {
        $validated = $this->validate();
        ModelsStudent::create([
            'name' => $validated['name'],
            'address' => $validated['address'],
            'classroom_id' => $validated['classroom_id'],
        ]);
        $this->reset();
        session()->flash('success', 'Berhasil tambah data');
        $this->dispatch('close-modal', 'create-data');
    }

    public function getData($id)
    {
        $data = ModelsStudent::findOrFail($id);
        $this->edit_name = $data->name;
        $this->edit_address = $data->address;
        $this->edit_classroom_id = $data->classroom_id;
        $this->edit_id = $data->id;

        $this->dispatch('open-modal', 'update-data');
    }

    public function edit()
    {
        $validated = $this->validate();
        // dd($validated);
        ModelsStudent::findOrFail($this->edit_id)->update([
            'name' => $validated['edit_name'],
            'address' => $validated['edit_address'],
            'classroom_id' => $validated['edit_classroom_id'],
        ]);

        $this->reset();

        session()->flash('success', 'Berhasil Update Data');

        $this->dispatch('close-modal', 'update-data');
    }

    public function destroy($id)
    {
        ModelsStudent::findOrFail($id)->delete();
        session()->flash('warning', 'Berhasil hapus data');
    }

    public function render()
    {
        return view('livewire.student', [
            'title' => 'Daftar Siswa',
            'students' => ModelsStudent::with('classroom')->search($this->search)->get(),
            'classrooms' => Classroom::all()
        ]);
    }
}
