<?php

namespace App\Livewire;

use App\Models\Student;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class ListStudents extends Component
{
    use WithPagination;
    
    public string $search = '';

    #[Url()]
    public string $sortColumn = 'created_at', $sortDirection = 'desc';

    // #[Layout('layouts.app')] dah generate livewire config file, xyah pakai da line ni
    public function render()
    {
        $query = Student::query();

        $query = $this->applySearch($query);

        $query = $this->applySort($query);

        return view('livewire.list-students',[
            'students' => $query->paginate(10)
            // 'students' => $query->orderBy('id','DESC')->paginate(10)
        ]);
    }

    protected function applySort(Builder $query)
    {
        return $query->orderBy($this->sortColumn,$this->sortDirection);
    }

    public function sortBy(string $column)
    {
        if($this->sortColumn == $column){
            $this->sortDirection = $this->sortDirection == 'asc' ? 'desc' : 'asc';
        }else{
            $this->sortDirection = 'asc';
            $this->sortColumn = $column;
        }
        
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

    // public function queryString()
    // {
    //     return [
    //         'sortColumn',
    //         'sortDirection',
    //     ];
    // }
}
