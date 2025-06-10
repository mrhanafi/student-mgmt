<?php

namespace App\Livewire;

use App\Models\Student;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class ListStudents extends Component
{
    use WithPagination;
    
    public string $search = '';

    // #[Layout('layouts.app')] dah generate livewire config file, xyah pakai da line ni
    public function render()
    {
        $query = Student::query();

        $query = $this->applySearch($query);

        return view('livewire.list-students',[
            'students' => $query->orderBy('id','DESC')->paginate(10)
        ]);
    }

    public function applySearch(Builder $query)
    {
        return $query->where('name','like','%'.$this->search.'%')
        ->orWhere('email','like','%'.$this->search.'%')
        ->orWhereHas('class',function($query){
            $query->where('name','like','%'.$this->search.'%');
        });
    }

    public function deleteStudent($studentId)
    {
        Student::find($studentId)->delete();

        // return redirect(route('students.index'));
    }
}
