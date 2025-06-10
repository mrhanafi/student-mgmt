<?php

namespace App\Livewire;

use App\Livewire\Forms\CreateStudentForm;
use App\Models\Classes;
use App\Models\Section;
use App\Models\Student;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;

class CreateStudent extends Component
{
    public CreateStudentForm $form;

    // shift to form object
    // #[Validate('required',message:"Please provide student name")] 
    // public $name;
    // #[Validate('required|email|unique:students,email')] 
    // public $email;
    #[Validate('required')] 
    public $class_id;
    // #[Validate('required')] 
    // public $section_id;

    // public $sections = [];

    public function addStudent()
    {
        // dd($this->section_id);
        $this->validate();      //validate here, kalo x, die xvalidate class_id
        
        // Student::create([
        //     'name' => $this->name,
        //     'email' => $this->email,
        //     'class_id' => $this->class_id,
        //     'section_id' => $this->section_id,
        // ]);
        $this->form->storeStudent($this->class_id);

        // return redirect(route('students.index'));
        return $this->redirect(route('students.index'),navigate:true);
    }

    public function updatedClassId($value)
    {
        // $this->sections = Section::where('class_id',$value)->get();
        $this->form->setSections($value);
    }

    // #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.create-student',[
            'classes' => Classes::all(),
            // 'sections' => Section::all(),
        ]);
    }
}
