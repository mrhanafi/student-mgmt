<?php

namespace App\Livewire;

use App\Models\Student;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class ListStudents extends Component
{
    use WithPagination;

    // #[Layout('layouts.app')] dah generate livewire config file, xyah pakai da line ni
    public function render()
    {
        return view('livewire.list-students',[
            'students' => Student::orderBy('id','DESC')->paginate()
        ]);
    }

    public function deleteStudent($studentId)
    {
        Student::find($studentId)->delete();

        // return redirect(route('students.index'));
    }
}
