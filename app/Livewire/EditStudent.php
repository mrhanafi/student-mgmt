<?php

namespace App\Livewire;

use App\Models\Classes;
use App\Models\Section;
use App\Models\Student;
use Livewire\Attributes\Validate;
use Livewire\Component;

class EditStudent extends Component
{
    public Student $student;

    #[Validate('required',message:"Please provide student name")] 
    public $name;
    #[Validate('required|email|unique:students,email')] 
    public $email;
    #[Validate('required')] 
    public $class_id;
    #[Validate('required')] 
    public $section_id;

    public $sections = [];

    public function updateStudent()
    {
        // dd($this->section_id);
        $this->validate([
            'email' => 'required|email|unique:students,email,'. $this->student->id
        ]);
        
        $this->student->update([
            'name' => $this->name,
            'email' => $this->email,
            'class_id' => $this->class_id,
            'section_id' => $this->section_id,
        ]);

        return $this->redirect(route('students.index'));
    }

    public function updatedClassId($value)
    {
        $this->sections = Section::where('class_id',$value)->get();
    }

    public function mount()
    {
        $this->fill($this->student->only(['name','email','class_id','section_id']));
        $this->sections = Section::where('class_id',$this->student->class_id)->get();
        // dd($this->sections);
    }

    public function render()
    {
        return view('livewire.edit-student',[
            'classes' => Classes::all(),
        ]);
    }
}
