<?php

namespace App\Livewire;

use App\Exports\StudentsExport;
use App\Models\Student;
use App\Traits\Searchable;
use App\Traits\Sortable;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Lazy()]

class ListStudents extends Component
{
    use WithPagination, Searchable,Sortable;
    
    // public string $search = '';

    // #[Url()]
    // public string $sortColumn = 'created_at', $sortDirection = 'desc';

    public array $selectedStudentIds = [],$studentIdsOnPage = [],$allStudentIds = [];

 

    // #[Layout('layouts.app')] dah generate livewire config file, xyah pakai da line ni
    public function render()
    {
        sleep(2);
        $query = Student::query();

        $query = $this->applySearch($query);

        $query = $this->applySort($query);

        $this->allStudentIds = $query->pluck('id')->map(fn($id) => (string) $id)->toArray();

        $students = $query->paginate(5);

        // $this->studentIdsOnPage = $students->pluck('id')->toArray();
        $this->studentIdsOnPage = $students->map(fn($student) => (string) $student->id )->toArray();        //tukar ni sbb pluck buat id jdi int, yg ni tukar jdi string (utk kes select all)
        // dd( $this->studentIdsOnPage );

        return view('livewire.list-students',[
            'students' => $students
            // 'students' => $query->orderBy('id','DESC')->paginate(10)
        ]);
    }

    public function placeholder()
    {
        return view('components.table-placeholder');
    }

    // protected function applySort(Builder $query)
    // {
    //     return $query->orderBy($this->sortColumn,$this->sortDirection);
    // }

    // public function sortBy(string $column)
    // {
    //     if($this->sortColumn == $column){
    //         $this->sortDirection = $this->sortDirection == 'asc' ? 'desc' : 'asc';
    //     }else{
    //         $this->sortDirection = 'asc';
    //         $this->sortColumn = $column;
    //     }
        
    // }

    // public function applySearch(Builder $query)
    // {
    //     return $query->where('name','like','%'.$this->search.'%')
    //     ->orWhere('email','like','%'.$this->search.'%')
    //     ->orWhereHas('class',function($query){
    //         $query->where('name','like','%'.$this->search.'%');
    //     });
    // }

    public function deleteStudent(Student $student)
    {
        // Authorization check
        $student->delete();

        // return redirect(route('students.index'));
    }

    public function deleteStudents()
    {
        // $students = Student::find($this->selectedStudentIds);

        // foreach($students as $student){
        //     $this->deleteStudent($student);
        // }

        Notification::make()
            ->title('Selected records deleted successfully')
            ->success()
            ->send();
    }

    public function export()
    {
        // dd($this->selectedStudentIds);
        return (new StudentsExport($this->selectedStudentIds))->download(now().'_students.xlsx');
    }

    // public function queryString()
    // {
    //     return [
    //         'sortColumn',
    //         'sortDirection',
    //     ];
    // }
}
