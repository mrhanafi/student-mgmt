<?php

namespace App\Livewire\Forms;

use App\Models\Section;
use App\Models\Student;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CreateStudentForm extends Form
{
    

    #[Validate('required',message:"Please provide student name")] 
    public $name;
    #[Validate('required|email|unique:students,email')] 
    public $email;
    #[Validate('required')] 
    public $section_id;

    public $sections = [];

    public function storeStudent($class_id)
    {
        $this->validate();
        
        Student::create([
            'name' => $this->name,
            'email' => $this->email,
            'class_id' => $class_id,
            'section_id' => $this->section_id,
        ]);
    }

    public function setSections($class_id)
    {
        $this->sections = Section::where('class_id',$class_id)->get();
    }
}
