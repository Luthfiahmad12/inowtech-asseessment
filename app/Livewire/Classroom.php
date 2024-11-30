<?php

namespace App\Livewire;

use App\Models\Classroom as ModelsClassroom;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Classroom extends Component
{
    #[Title('Daftar Kelas')]

    #[Validate('required')]
    public $class_name = '';

    public $edit_name;
    public $id;

    public $search = '';

    public array $getTeachers = [];
    public array $getStudents = [];

    public function save()
    {
        $this->validate();

        \App\Models\Classroom::create($this->all());

        $this->reset();

        session()->flash('success', 'Berhasil Tambah Data');

        $this->dispatch('close-modal', 'create-data');
    }

    public function getData($id)
    {
        $data = ModelsClassroom::findOrFail($id);
        $this->edit_name = $data->class_name;
        $this->id = $data->id;
        $this->dispatch('open-modal', 'update-data');
    }

    public function edit()
    {
        ModelsClassroom::findOrFail($this->id)->update([
            'class_name' => $this->edit_name
        ]);

        $this->reset();

        session()->flash('success', 'Berhasil Update Data');

        $this->dispatch('close-modal', 'update-data');
    }

    public function destroy($id)
    {
        ModelsClassroom::findOrFail($id)->delete();
        session()->flash('warning', 'Berhasil Hapus Data');
    }

    public function getTeacher($id)
    {
        $this->getTeachers = \App\Models\Classroom::with('teachers')->find($id)->toArray();
        // dd($this->getTeachers);
        $this->dispatch('open-modal', 'get-teacher');
    }

    public function getStudent($id)
    {
        $this->getStudents = \App\Models\Classroom::with('students')->find($id)->toArray();
        // dd($this->getStudents);
        $this->dispatch('open-modal', 'get-student');
    }

    public function render()
    {
        return view('livewire.classroom', [
            'title' => 'Daftar Kelas',
            'classrooms' => \App\Models\Classroom::with('students', 'teachers')->search($this->search)->get(),
        ]);
    }
}
