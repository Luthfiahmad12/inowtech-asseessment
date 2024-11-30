<?php

namespace App\Livewire;

use App\Models\Classroom;
use App\Models\Teacher as ModelsTeacher;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Title;
use Livewire\Component;

class Teacher extends Component
{
    #[Title('Daftar Guru')]

    public $search = '';

    public $name, $email, $teacher_id, $classroom_id;
    public $edit_id, $edit_name, $edit_email, $edit_teacher_id, $edit_classroom_id;

    protected function rules()
    {
        if ($this->edit_id) {
            return [
                'edit_name' => ['required', Rule::unique('teachers', 'name')->ignore($this->edit_id)],
                'edit_email' => ['required', Rule::unique('teachers', 'email')->ignore($this->edit_id)],
                'edit_teacher_id' => ['required', 'numeric', 'digits:18', Rule::unique('teachers', 'teacher_id')->ignore($this->edit_id)],
                'edit_classroom_id' => 'required',
            ];
        }
        return [
            'name' => ['required', Rule::unique('teachers', 'name')],
            'email' => ['required', Rule::unique('teachers', 'email')],
            'teacher_id' => ['required', 'numeric', 'digits:18', Rule::unique('teachers', 'teacher_id')],
            'classroom_id' => 'required',
        ];
    }

    public function save()
    {
        $validated = $this->validate();

        ModelsTeacher::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'teacher_id' => $validated['classroom_id'],
            'classroom_id' => $validated['classroom_id'],
        ]);
        $this->reset();
        session()->flash('success', 'Berhasil tambah data');
        $this->dispatch('close-modal', 'create-data');
    }

    public function getData($id)
    {
        $data = ModelsTeacher::findOrFail($id);
        $this->edit_name = $data->name;
        $this->edit_email = $data->email;
        $this->edit_teacher_id = $data->teacher_id;
        $this->edit_classroom_id = $data->classroom_id;
        $this->edit_id = $data->id;
        $this->dispatch('open-modal', 'update-data');
    }

    public function edit()
    {
        $validated = $this->validate();

        ModelsTeacher::findOrFail($this->edit_id)->update([
            'name' => $validated['edit_name'],
            'email' => $validated['edit_email'],
            'teacher_id' => $validated['edit_teacher_id'],
            'classroom_id' => $validated['edit_classroom_id'],
        ]);
        $this->reset();
        session()->flash('success', 'Berhasil update data');
        $this->dispatch('close-modal', 'update-data');
    }

    public function destroy($id)
    {
        ModelsTeacher::findOrFail($id)->delete();
        session()->flash('warning', 'Berhasil hapus data');
    }


    public function render()
    {
        return view('livewire.teacher', [
            'title' => 'Daftar Guru',
            'teachers' => ModelsTeacher::with('classroom')->search($this->search)->get(),
            'classrooms' => Classroom::all()
        ]);
    }
}
