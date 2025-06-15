<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Url;

trait Sortable{
    #[Url()]
    public string $sortColumn = 'created_at', $sortDirection = 'desc';

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
}